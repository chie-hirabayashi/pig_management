<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMixInfoRequest;
use App\Http\Requests\StoreBornInfoRequest;
use App\Http\Requests\UpdateMixInfoRequest;
use App\Http\Requests\UpdateBornInfoRequest;
use App\Exports\MixInfoExport;
use App\Exports\MixInfoSourceExport;
use App\Imports\MixInfoImport;
use App\Models\FemalePig;
use App\Models\MalePig;
use App\Models\MixInfo;
use App\Models\TroubleCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class MixInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FemalePig $femalePig)
    {
        // 交配記録がない場合:すぐに登録画面に遷移
        if (!MixInfo::where('female_id', $femalePig->id)->exists()) {
            $malePigs = MalePig::all();
            return view('mix_infos.create')->with(
                compact('femalePig', 'malePigs')
            );
        }

        // 交配記録がある場合:最後の交配で出産、再発、流産していれば登録画面に遷移
        $mixInfos = $femalePig->mix_infos;
        $mixInfo = $mixInfos->last();

        if ($mixInfo->born_day !== null || $mixInfo->trouble_id !== 1) {
            $malePigs = MalePig::all();
            return view('mix_infos.create')->with(
                compact('femalePig', 'malePigs')
            );
        }
        return back()->withErrors('未処理の交配記録があります。');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMixInfoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMixInfoRequest $request, FemalePig $femalePig)
    {
        // オス1の導入日
        $firstMale_add_day = MalePig::find($request->first_male_id)->add_day;

        // オス2の導入日
        if ($request->second_male_id) {
            $secondMale_add_day = MalePig::find($request->second_male_id)
                ->add_day;
        } else {
            $secondMale_add_day = $firstMale_add_day;
        }

        // 直前の出産or再発or流産の日付
        if ($femalePig->mix_infos->last()) {
            switch ($femalePig->mix_infos->last()->born_day == null) {
                case true:
                    $last_recode_day = $femalePig->mix_infos->last()
                        ->trouble_day;
                    break;

                case false:
                    $last_recode_day = $femalePig->mix_infos->last()->born_day;
                    break;
            }
        } else {
            $last_recode_day = $femalePig->add_day;
        }

        // error:交配日<導入日、交配日<前回の出産、再発、流産日
        switch (true) {
            case $request->mix_day < $femalePig->add_day ||
                $request->mix_day < $firstMale_add_day ||
                $request->mix_day < $secondMale_add_day:
                return back()->withErrors('交配日は導入日の後です。');
                break;

            case $request->mix_day < $last_recode_day:
                return back()->withErrors(
                    '交配日は前回の出産日、再発日、流産日の後です。'
                );
                break;
        }

        // 登録情報をセット
        $mixInfo = new MixInfo($request->all());
        $mix_day = Carbon::create($request->mix_day);
        $mixInfo->first_recurrence_schedule = $mix_day
            ->addDay(21)
            ->toDateString();
        $mixInfo->second_recurrence_schedule = $mix_day
            ->addDay(21)
            ->toDateString();
        $mixInfo->delivery_schedule = $mix_day->addDay(71)->toDateString();

        try {
            $femalePig->mix_infos()->save($mixInfo);
            return redirect()
                ->route('female_pigs.show', $femalePig)
                ->with('notice', '交配記録を登録しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MixInfo  $mixInfo
     * @return \Illuminate\Http\Response
     */
    public function show(MixInfo $mixInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MixInfo  $mixInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(FemalePig $femalePig, MixInfo $mixInfo)
    {
        $femalePigs = FemalePig::all();
        $malePigs = MalePig::all();
        $troubleCategories = TroubleCategory::all();
        // dd($mixInfo->first_male_pig);
        // self::maleSoftDeleteResolution($mixInfo);
        // self::softDeleteResolution($mixInfo);

        return view('mix_infos.edit')->with(
            compact(
                'femalePigs',
                'femalePig',
                'malePigs',
                'troubleCategories',
                'mixInfo'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMixInfoRequest  $request
     * @param  \App\Models\MixInfo  $mixInfo
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateMixInfoRequest $request,
        FemalePig $femalePig,
        MixInfo $mixInfo
    ) {
        // femalePigを変更する場合
        if ($femalePig->id !== intval($request->female_id)) {
            $mixInfo = FemalePig::find($request->female_id)->mix_infos->last();

            // 交配記録があり、最後の交配で出産、再発、流産していれば更新処理を継続
            switch (true) {
                case $mixInfo == null:
                    return back()->withErrors(
                        '選択した母豚は、修正する交配記録がありません。'
                    );
                    break;

                case $mixInfo->born_day !== null || $mixInfo->trouble_id !== 1:
                    break;

                default:
                    return back()->withErrors(
                        '選択した母豚は、未処理の交配記録があります。'
                    );
                    break;
            }
        }

        // error:再発日、流産日<導入日
        if ($request->trouble_id !== '1') {
            $request->validate([
                'trouble_day' =>
                    'required|date|after:mix_day|before_or_equal:today',
                'trouble_id' => 'required|integer',
            ]);
        }

        // オス1の導入日
        $firstMale_add_day = MalePig::find($request->first_male_id)->add_day;

        // オス2の導入日
        if ($request->second_male_id) {
            $secondMale_add_day = MalePig::find($request->second_male_id)
                ->add_day;
        } else {
            $secondMale_add_day = $firstMale_add_day;
        }

        // 直前の出産or再発or流産の日付
        $end_recode = $femalePig
            ->mix_infos()
            ->latest()
            ->get();
        if (count($end_recode) < 2) {
            // 直前の出産、再発、流産がない場合、母豚の導入日をセット
            $end_recode_day = $firstMale_add_day;
        } else {
            // 直前の出産、再発、流産がある場合、出産日または再発、流産日をセット
            switch ($end_recode[1]->born_day == null) {
                case true:
                    $end_recode_day = $end_recode[1]->trouble_day;
                    break;

                case false:
                    $end_recode_day = $end_recode[1]->born_day;
                    break;
            }
        }

        // error:交配日<導入日、交配日<前回の出産、再発、流産日
        switch (true) {
            case $request->mix_day < $femalePig->add_day ||
                $request->mix_day < $firstMale_add_day ||
                $request->mix_day < $secondMale_add_day:
                return back()->withErrors('交配日は導入日の後です。');
                break;

            case $request->mix_day < $end_recode_day:
                return back()->withErrors(
                    '交配日は前回の出産日、再発日、流産日の後です。'
                );
                break;
        }

        // 登録情報をセット
        $mixInfo->fill($request->all());
        $mix_day = Carbon::create($request->mix_day);
        $mixInfo->first_recurrence_schedule = $mix_day
            ->addDay(21)
            ->toDateString();
        $mixInfo->second_recurrence_schedule = $mix_day
            ->addDay(21)
            ->toDateString();
        $mixInfo->delivery_schedule = $mix_day->addDay(71)->toDateString();

        try {
            $mixInfo->save();
            return redirect()
                ->route('female_pigs.show', $femalePig)
                ->with('notice', '交配記録を更新しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MixInfo  $mixInfo
     * @return \Illuminate\Http\Response
     */
    // public function destroy(MixInfo $mixInfo, FemalePig $femalePig)
    public function destroy(FemalePig $femalePig, MixInfo $mixInfo)
    {
        try {
            $mixInfo->delete();
            return redirect()
                ->route('female_pigs.show', $femalePig)
                ->with('notice', '交配記録を削除しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createBorn(MixInfo $mixInfo)
    {
        // 最後の交配記録に出産、再発、流産の記録がある場合、出産登録不可
        if ($mixInfo->born_day !== null || $mixInfo->trouble_id !== 1) {
            return back()->withErrors('出産登録できる交配記録がありません。');
        }

        $femalePig = $mixInfo->female_pig;
        return view('born_infos.create')->with(compact('mixInfo', 'femalePig'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBornInfoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBorn(StoreBornInfoRequest $request, MixInfo $mixInfo)
    {
        $mixInfo->fill($request->all());
        $femalePig = $mixInfo->female_pig;

        try {
            $mixInfo->save();
            return redirect()
                ->route('female_pigs.show', $femalePig)
                ->with('notice', '出産情報を登録しました');
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->withErrors($th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MixInfo  $mixInfo
     * @return \Illuminate\Http\Response
     */
    public function editBorn(MixInfo $mixInfo)
    {
        $femalePig = $mixInfo->female_pig;
        return view('born_infos.edit')->with(compact('mixInfo', 'femalePig'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMixInfoRequest  $request
     * @param  \App\Models\MixInfo  $mixInfo
     * @return \Illuminate\Http\Response
     */
    public function updateBorn(UpdateBornInfoRequest $request, MixInfo $mixInfo)
    {
        $femalePig = $mixInfo->female_pig;
        $mixInfo->fill($request->all());

        try {
            $mixInfo->save();
            return redirect()
                ->route('female_pigs.show', $femalePig)
                ->with('notice', '出産情報を更新しました。');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BornInfo  $bornInfo
     * @return \Illuminate\Http\Response
     */
    public function destroyBorn(MixInfo $mixInfo)
    {
        $femalePig = $mixInfo->female_pig;
        $mixInfo->born_day = null; //born_dayカラムを空に戻す
        $mixInfo->born_num = null; //born_numカラムを空に戻す

        try {
            $mixInfo->save();
            return redirect()
                ->route('female_pigs.show', $femalePig)
                ->with('notice', '出産情報を削除しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    public function managementBook()
    {
        $mixInfos = MixInfo::with([
            'female_pig_with_trashed',
            'first_male_pig_with_trashed',
            'second_male_pig_with_trashed',
        ])->orderBy('mix_day', 'desc')->Paginate(50);

        // dd($mixInfos);
        return view('management_book.index')->with(compact('mixInfos'));
    }

    public function forecast()
    {
        $now = Carbon::now();
        $limit = $now->addDays(-180)->toDateString(); # 今日以降の出荷予定を取得:交配から出荷まで180日+7日(予備)-42日(再発確認)
        // $mixInfos = DB::table('mix_infos')
        $mixInfos = MixInfo::
            where('mix_day', '>=', $limit)
            ->where('trouble_id', 1)
            ->get();

        $forecast_num = $mixInfos->groupBy('forecast_date')
        ->map(function ($f_date) {
                return $f_date->sum('forecast_num');
            });
        // dd($forecast_num);

        return view('forecast.index')->with(compact('forecast_num'));
    }

    public function export()
    {
        # 全データ出力
        // return Excel::download(new MixInfoExport(), 'mix_info.xlsx');

        # 帳票出力
        $mixInfos = MixInfo::with(
            'female_pig_with_trashed',
            'first_male_pig_with_trashed',
            'first_male_pig_with_trashed',
            'second_male_pig_with_trashed'
        )->get();
        $view = view('mix_infos.export')->with(compact('mixInfos'));
        return Excel::download(new MixInfoExport($view), 'mix_info.xlsx');
    }

    public function source_export()
    {
        # 全データ出力
        return Excel::download(
            new MixInfoSourceExport(),
            'source_mix_info.xlsx'
        );
    }

    public function import(Request $request)
    {
        // FIXME:データの取込は初期化してから、初期化コマンド作成、バリデーション作成
        try {
            $excel_file = $request->file('excel_file');
            $excel_file->store('excels');
            Excel::import(new MixInfoImport(), $excel_file);
            return redirect()
                ->route('female_pigs.index')
                ->with('notice', 'インポートしました');
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->withErrors($th->getMessage());
        }
    }

    // cssテスト用
    public function test()
    {
        return view('born_infos.index');
    }
}
