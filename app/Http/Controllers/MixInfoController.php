<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMixInfoRequest;
use App\Http\Requests\StoreBornInfoRequest;
use App\Http\Requests\UpdateMixInfoRequest;
use App\Http\Requests\UpdateBornInfoRequest;
use App\Models\FemalePig;
use App\Models\MalePig;
use App\Models\MixInfo;
use App\Models\TroubleCategory;
use Carbon\Carbon;
use App\Exports\MixInfoExport;
use App\Imports\MixInfoImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        // 交配記録の確認
        if (!MixInfo::where('female_id', $femalePig->id)->exists()) {
            // 交配記録なし
            $malePigs = MalePig::all();
            return view('mix_infos.create')
                ->with(compact('femalePig', 'malePigs'));

        } else {
            // 交配記録あり
            $mixInfos = $femalePig->mix_infos;
            $mixInfo = $mixInfos->last();
            // $mixInfo = $mixInfos->sortByDesc('mix_day')->first();
            
            // born_infosテーブルのmix_id確認
            if ($mixInfo->born_day !== null ||
                // mix_infosテーブルのflag確認
                $mixInfo->trouble_id !== 1 ) {
                    $malePigs = MalePig::all();
                    return view('mix_infos.create')
                        ->with(compact('femalePig', 'malePigs'));
            }
            return back()->withErrors('未処理の交配記録があります。');
        }
        
        return back()->withErrors('予期せぬエラーが発生しました');

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
        $firstMale_add_day = MalePig::find($request->male_first_id)->add_day;
        // dd($firstMale_add_day);
        
        // オス2の導入日
        if ($request->male_second_id) {
            $secondMale_add_day = MalePig::find($request->male_second_id)->add_day;
        } else {
            $secondMale_add_day = $firstMale_add_day;
        }
        
        // 交配日の適正確認
        if ($request->mix_day < $femalePig->add_day ||
            $request->mix_day < $firstMale_add_day ||
            $request->mix_day < $secondMale_add_day) {
            return back()->withErrors('交配日は導入日の後です。');
        }
        
        // 交配日
        $mix_day = Carbon::create($request->mix_day);
        
        // 登録情報準備
        $mixInfo = new MixInfo($request->all());
        $mixInfo->recurrence_first_schedule = $mix_day->addDay(21)->toDateString();
        $mixInfo->recurrence_second_schedule = $mix_day->addDay(42)->toDateString();
        $mixInfo->delivery_schedule = $mix_day->addDay(113)->toDateString();

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
        // softDelete対策必要
        // self::softDeleteResolution($born_infos);
        self::softDeleteResolution($mixInfo);
        // dd($femalePig);
        return view('mix_infos.edit')
            ->with(compact('femalePig', 'mixInfo', 'femalePigs', 'malePigs', 'troubleCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMixInfoRequest  $request
     * @param  \App\Models\MixInfo  $mixInfo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMixInfoRequest $request, FemalePig $femalePig, MixInfo $mixInfo)
    {
        // 再発・流産登録は日付が必須
        if ($request->trouble_id !== '1') {
            $request->validate([
                'trouble_day' => 'required|date|after:mix_day|before_or_equal:today',
                'trouble_id'  => 'required|integer',
            ]);
        }
        // 交配日の適正化
        if ($request->mix_day < $femalePig->add_day ||
            $request->mix_day < $mixInfo->first_male_pig->add_day ||
            $request->mix_day < $mixInfo->second_male_pig->add_day) {
            return back()->withErrors('交配日は導入日の後です。');
        }

        // 更新内容準備
        // 交配日
        $mixInfo->fill($request->all());
        $mix_day = Carbon::create($request->mix_day);
        $mixInfo->recurrence_first_schedule = $mix_day->addDay(20)->toDateString();
        $mixInfo->recurrence_second_schedule = $mix_day->addDay(40)->toDateString();

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
        // 出産登録できる交配記録の確認
        if ($mixInfo->born_day !== null ||
            $mixInfo->trouble_id !== 1) {
            return back()->withErrors('出産登録できる交配記録がありません。');
        }

        $femalePig = $mixInfo->female_pig;
        return view('born_infos.create')
            ->with(compact('mixInfo', 'femalePig'));
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
            return back()->withInput()->withErrors($th->getMessage());
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
        return view('born_infos.edit')
            ->with(compact('mixInfo', 'femalePig'));
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
        $mixInfo->born_day = null;
        $mixInfo->born_num = null;
        dd($mixInfo);
        try {
            $mixInfo->save();
            return redirect()
                ->route('female_pigs.show', $femalePig)
                ->with('notice', '出産情報を削除しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    public function export(){
        return Excel::download(new MixInfoExport, 'mix_info.xlsx');
    }

    public function import(Request $request){
        $excel_file = $request->file('excel_file');
        $excel_file->store('excels');
        Excel::import(new MixInfoImport, $excel_file);
        // return view('index');
        return redirect()
            ->route('female_pigs.index')
            ->with('notice', 'インポートしました');
    }

    // first_male_pigとsecond_male_pigの
    // softDeleteとnull対策function
    public function softDeleteResolution($mixInfo)
    {
        // first_male_pigのsoftDelete対策
        $judge_1 = MalePig::where('id',$mixInfo->male_first_id)->onlyTrashed()->get();
        if (!$judge_1->isEmpty()) {
            $deletePig_1 = $judge_1[0]->individual_num;
            $mixInfo->first_delete_male = $deletePig_1;
            $mixInfo->first_male = null;
        } else {
            $mixInfo->first_delete_male = null;
            $mixInfo->first_male = $mixInfo->first_male_pig->individual_num;
        }
        // second_male_pigのnullとsoftDelete対策
        if ($mixInfo->male_second_id !== null) {
            $judge_2 = MalePig::where('id',$mixInfo->male_second_id)->onlyTrashed()->get();
            if (!$judge_2->isEmpty()) {
                $deletePig_2 = $judge_2[0]->individual_num;
                $mixInfo->second_delete_male = $deletePig_2;
                $mixInfo->second_male = null;
            } else {
                $mixInfo->second_delete_male = null;
                $mixInfo->second_male = $mixInfo->second_male_pig->individual_num;
            }
        } else {
                $mixInfo->second_delete_male = null;
                $mixInfo->second_male = null;
        }
        return $mixInfo;
    }

    // cssテスト用
    public function test(){
        return view('born_infos.index');
    }
}
