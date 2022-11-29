<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BornInfo;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BornInfoImport;
use App\Models\FemalePig;
use App\Models\MixInfo;
use App\Http\Requests\StoreBornInfoRequest;
use App\Http\Requests\UpdateBornInfoRequest;

class BornInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(MixInfo $mixInfo)
    {
        $femalePig = FemalePig::find($mixInfo->female_id);
        return view('born_infos.born_create')->with(compact('mixInfo', 'femalePig'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBornInfoRequest $request, MixInfo $mixInfo)
    {
        $bornInfo = new BornInfo();
        $bornInfo->mix_id = $mixInfo->id;
        $bornInfo->fill($request->all());
        $femalePig = $mixInfo->female_pig;

        try {
            $bornInfo->save();
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MixInfo $mixInfo, BornInfo $bornInfo)
    {
        $femalePig = $mixInfo->female_pig;
        return view('born_infos.born_edit')->with(compact('mixInfo', 'bornInfo', 'femalePig'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBornInfoRequest $request, MixInfo $mixInfo, BornInfo $bornInfo)
    {
        $femalePig = $mixInfo->female_pig;
        $bornInfo->fill($request->all());
// dd($bornInfo);
        try {
            $bornInfo->save();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MixInfo $mixInfo, BornInfo $bornInfo)
    {
        $femalePig = $mixInfo->female_pig;
        
        try {
            $bornInfo->delete();
            return redirect()
                ->route('female_pigs.show', $femalePig)
                ->with('notice', '出産情報を削除しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    public function import(Request $request)
    {
        $excel_file = $request->file('excel_file');
        $excel_file->store('excels');
        Excel::import(new BornInfoImport(), $excel_file);
        
        return redirect()
            ->route('female_pigs.index')
            ->with('notice', 'インポートしました');
    }
}
