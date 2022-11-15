<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMalePigRequest;
use App\Http\Requests\UpdateMalePigRequest;
use App\Exports\MalePigExport;
use App\Imports\MalePigImport;
use App\Models\MalePig;
use App\Models\MixInfo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

        return view('male_pigs.index')->with(compact('malePigs'));
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
            return back()->withErrors($th->getMessage());
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
        return view('male_pigs.edit')->with(compact('malePig'));
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
        // error:最初の交配日<導入日
        $exist_firstId = MixInfo::where(
            'first_male_id',
            $malePig->id
        )->exists();
        $exist_secondId = MixInfo::where(
            'second_male_id',
            $malePig->id
        )->exists();

        if ($exist_firstId || $exist_secondId) {
            $first_mix_day  = $malePig->first_mix_infos->first()->mix_day;
            $second_mix_day = $malePig->second_mix_infos->first()->mix_day;

            switch ($first_mix_day > $second_mix_day) {
                case true:
                    $mix_day = $first_mix_day;
                    break;
                case false:
                    $mix_day = $second_mix_day;
                    break;
                default:
            }

            if ($mix_day < $request->add_day) {
                return back()->withErrors(
                    '導入日が正しくありません。交配日より前の日付に変更してください。'
                );
            }
        }

        // 変更前の個体番号を保持
        $individual_num = $malePig->individual_num;
        $malePig->fill($request->all());

        // 個体番号を変更する場合:複合ユニークを確認
        if ($individual_num !== $request->individual_num) {
            $request->validate([
                'individual_num' =>
                    'required|string|max:20|unique:male_pigs,individual_num,NULL,exist,exist,1',
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
        // 通知作成
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

    public function updateFlag(Request $request, MalePig $malePig)
    {
        $malePig->warn_flag = $request->warn_flag;
        
        try {
            $malePig->save();
            return redirect(route('male_pigs.index'));
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new MalePigExport(), 'malePigs_data.xlsx');
    }

    public function import(Request $request)
    {
        $excel_file = $request->file('excel_file');
        $excel_file->store('excels');
        Excel::import(new MalePigImport(), $excel_file);
        // return view('index');
        return redirect()
            ->route('male_pigs.index')
            ->with('notice', 'インポートしました');
    }
}
