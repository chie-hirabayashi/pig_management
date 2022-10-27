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

        return view('born_infos.create')
            ->with(compact('mixInfo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBornInfoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBornInfoRequest $request, MixInfo $mixInfo)
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
        
        $bornInfo = new BornInfo($request->all());
        $femalePig = FemalePig::find($request->female_id);
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
    public function edit(BornInfo $bornInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBornInfoRequest  $request
     * @param  \App\Models\BornInfo  $bornInfo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBornInfoRequest $request, BornInfo $bornInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BornInfo  $bornInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(BornInfo $bornInfo)
    {
        //
    }
}
