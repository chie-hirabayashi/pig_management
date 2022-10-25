<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMalePigRequest;
use App\Http\Requests\UpdateMalePigRequest;
use App\Models\MalePig;

class MalePigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $malePigs = MalePig::all();
        
        return view('male_pigs.index')
            ->with(compact('malePigs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('male_pigs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMalePigRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMalePigRequest $request)
    {
        $malePig = new MalePig($request->all());

        try {
            $malePig->save();
            return redirect()
                ->route('male_pigs.index')
                ->with('notice', '新しい父豚を登録しました');
        } catch (\Throwable $th) {
            return back()
                ->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MalePig  $malePig
     * @return \Illuminate\Http\Response
     */
    public function show(MalePig $malePig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MalePig  $malePig
     * @return \Illuminate\Http\Response
     */
    public function edit(MalePig $malePig)
    {
        return view('male_pigs.edit')
                ->with(compact('malePig'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMalePigRequest  $request
     * @param  \App\Models\MalePig  $malePig
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMalePigRequest $request, MalePig $malePig)
    {
        // 変更前の個体番号を保持
        $individual_num = $malePig->individual_num;
        $malePig->fill($request->all());
        
        // 個体番号を変更する場合は複合ユニークを確認
        if ($individual_num !== $request->individual_num) {
            $request->validate([
                'individual_num' => 'required|string|max:20|unique:male_pigs,individual_num,NULL,exist,exist,1'
            ]);
        }

        // 登録
        try {
            $malePig->save();
            return redirect()
                ->route('male_pigs.index')
                ->with('notice', '変更しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MalePig  $malePig
     * @return \Illuminate\Http\Response
     */
    public function destroy(MalePig $malePig)
    {
        // フラッシュメッセージ作成
        $flash_msg = $malePig->individual_num . 'を廃用にしました';

        try {
            $malePig->delete();
            return redirect()
                ->route('male_pigs.index')
                ->with('notice', $flash_msg);
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }
}
