<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBornInfoRequest;
use App\Http\Requests\UpdateBornInfoRequest;
use App\Models\BornInfo;
use App\Models\FemalePig;
use App\Models\MixInfo;

class BornInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('born_infos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(MixInfo $mixInfo)
    {
        // born_infosテーブルのmix_id確認
        if (BornInfo::where('mix_id', $mixInfo->id)->exists()) {
            return back()->withErrors('既に出産登録済みです。');
        } else {
            // フラグ確認
            if ($mixInfo->recurrence_flag === 1 ||
                $mixInfo->abortion_flag === 1) {
                    return back()->withErrors('出産登録できる交配記録がありません。');
                }
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
    public function store(StoreBornInfoRequest $request, MixInfo $mixInfo)
    {
        // // born_infosテーブルのmix_id確認
        // if (BornInfo::where('mix_id', $mixInfo->id)->exists()) {
        //     return back()->withErrors('既に出産登録済みです。');
        // } else {
        //     // フラグ確認
        //     if ($mixInfo->recurrence_flag === 1 ||
        //         $mixInfo->abortion_flag === 1) {
        //             return back()->withErrors('出産登録できる交配記録がありません。');
        //         }
        // }
        
        $bornInfo = new BornInfo($request->all());
        $femalePig = FemalePig::find($request->female_id);

        if ($mixInfo->mix_day > $bornInfo->born_day) {
            return back()->withErrors('出産日は交配日の後の日付を指定してください。');
        }

        try {
            // $mixInfo->female_id = $id;
            $mixInfo->born_info()->save($bornInfo);
            return redirect()
                ->route('female_pigs.show', $femalePig)
                ->with('notice', '出産情報を登録しました');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BornInfo  $bornInfo
     * @return \Illuminate\Http\Response
     */
    public function show(BornInfo $bornInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BornInfo  $bornInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(MixInfo $mixInfo, BornInfo $bornInfo)
    {
        return view('born_infos.edit')
            ->with(compact('mixInfo', 'bornInfo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBornInfoRequest  $request
     * @param  \App\Models\BornInfo  $bornInfo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBornInfoRequest $request, MixInfo $mixInfo, BornInfo $bornInfo)
    {
        $mix_day = $mixInfo->mix_day;
        $femalePig = $bornInfo->female_pig;
        $bornInfo->fill($request->all());
// dd($mix_day);
        if ($mix_day > $request->born_day) {
            return back()->withErrors('出産日が正しくありません。交配日より後の日付に変更してください。');
        }

        try {
            $bornInfo->save();
            return redirect()
                ->route('female_pigs.show', $femalePig)
                ->with('notice', '出産情報を編集しました');
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
    public function destroy(MixInfo $mixInfo, BornInfo $bornInfo)
    {
        $femalePig = $bornInfo->female_pig;
        // dd($femalePig);
        try {
            $bornInfo->delete();
            return redirect()
                ->route('female_pigs.show', $femalePig)
                ->with('notice', '出産情報を削除しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }
}
