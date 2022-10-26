<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMixInfoRequest;
use App\Http\Requests\UpdateMixInfoRequest;
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
    public function create(FemalePig $femalePig, MalePig $malePig)
    {
        $malePigs = MalePig::all();
        
        return view('mix_infos.create')
            ->with(compact('femalePig', 'malePigs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMixInfoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMixInfoRequest $request, FemalePig $femalePig)
    {
        $mixInfo = new MixInfo($request->all());
        // var_dump($mixInfo->male_first_id);
        // dd($mixInfo);
        $mix_day = Carbon::create($request->mix_day);
        $mixInfo->recurrence_first_schedule = $mix_day->addDay(20)->toDateString();
        $mixInfo->recurrence_second_schedule = $mix_day->addDay(40)->toDateString();
        $mixInfo->female_id = $femalePig->id;

        try {
            $mixInfo->save();
            // $femalePig->mix_infos()->save($mixInfo);
            return redirect()
                ->route('female_pigs.index')
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
    public function edit(MixInfo $mixInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMixInfoRequest  $request
     * @param  \App\Models\MixInfo  $mixInfo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMixInfoRequest $request, MixInfo $mixInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MixInfo  $mixInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(MixInfo $mixInfo)
    {
        //
    }
}
