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
        // 交配日
        $mix_day = Carbon::create($request->mix_day);
        // メス導入日
        $female_add_day = Carbon::create($femalePig->add_day);
        // オス導入日
        $firstMale = MalePig::find($request->male_first_id);
        $secondMale = MalePig::find($request->male_second_id);
        $firstM_add_day = Carbon::create($firstMale->add_day);
        $secondM_add_day = Carbon::create($secondMale->add_day);

        // mix_dayがメス,オス1,オス2のadd_day以降か確認
        if ($mix_day < $female_add_day ||
            $mix_day < $firstM_add_day ||
            $mix_day < $secondM_add_day) {

            $request->validate([
                'mix_day' => 'required|date|before_or_equal:today|after_add_day'
            ]);
        }
        
        // 登録情報準備
        $mixInfo = new MixInfo($request->all());
        $mixInfo->recurrence_first_schedule = $mix_day->addDay(20)->toDateString();
        $mixInfo->recurrence_second_schedule = $mix_day->addDay(40)->toDateString();

        try {
            // $mixInfo->save();
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
}
