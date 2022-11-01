<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMixInfoRequest;
use App\Http\Requests\UpdateMixInfoRequest;
use App\Models\BornInfo;
use Illuminate\Http\Request;
use App\Models\FemalePig;
use App\Models\MalePig;
use App\Models\MixInfo;
use Carbon\Carbon;

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
            $mixInfo = $mixInfos->sortByDesc('mix_day')->first();
            
            // born_infosテーブルのmix_id確認
            if (BornInfo::where('mix_id', $mixInfo->id)->exists() ||
                // mix_infosテーブルのflag確認
                $mixInfo->recurrence_flag === 1 ||
                $mixInfo->abortion_flag ===1 ) {
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
        // $mixInfo->female_id = $femalePig->id;

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
        return view('mix_infos.edit')
            ->with(compact('femalePig', 'mixInfo', 'femalePigs', 'malePigs'));
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

        // 更新内容準備
        $mixInfo->fill($request->all());
        $mixInfo->recurrence_first_schedule = $mix_day->addDay(20)->toDateString();
        $mixInfo->recurrence_second_schedule = $mix_day->addDay(40)->toDateString();

        try {
            $mixInfo->save();
            return redirect()
                ->route('female_pigs.show', $femalePig)
                ->with('notice', '交配記録を修正しました');
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
}
