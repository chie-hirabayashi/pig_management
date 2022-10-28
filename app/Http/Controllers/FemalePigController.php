<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFemalePigRequest;
use App\Http\Requests\UpdateFemalePigRequest;
use App\Models\BornInfo;
use App\Models\FemalePig;
use App\Models\MixInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FemalePigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $femalePigs = FemalePig::all();
        
        return view('female_pigs.index')
            ->with(compact('femalePigs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('female_pigs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFemalePigRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFemalePigRequest $request)
    {
        $femalePig = new FemalePig($request->all());

        try {
            $femalePig->save();
            return redirect()
                ->route('female_pigs.show', $femalePig)
                ->with('notice', '新しい母豚を登録しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FemalePig  $femalePig
     * @return \Illuminate\Http\Response
     */
    public function show(FemalePig $femalePig)
    {
        $mixInfos = $femalePig->mix_infos;
        $mixInfo = $mixInfos->last();

        $last_year = Carbon::now()->subYear(1)->toDateString();

        // mixInfo準備
        if ($mixInfo) {
            // 再発取得
            $recurrence_flags = DB::table('mix_infos')
                ->where('female_id', $femalePig->id)
                ->where('recurrence_flag', 1)
                ->get();
            $mixInfo['sum_recurrence'] = count($recurrence_flags);

            // 流産取得
            $abortion_flags = DB::table('mix_infos')
                ->where('female_id', $femalePig->id)
                ->where('abortion_flag', 1)
                ->get();
            $mixInfo['sum_abortion'] = count($abortion_flags);

            // 過去1年間の再発取得
            $last_year_recurrences = DB::table('mix_infos')
                ->where('female_id', $femalePig->id)
                ->where('mix_day', '>', $last_year)
                ->where('recurrence_flag', 1)
                ->get();
            $mixInfo['lastYsum_recurrences'] = count($last_year_recurrences);
            
            // 過去1年間の流産取得
            $last_year_abortions = DB::table('mix_infos')
                ->where('female_id', $femalePig->id)
                ->where('mix_day', '>', $last_year)
                ->where('abortion_flag', 1)
                ->get();
            $mixInfo['lastYsum_abortions'] = count($last_year_abortions);
        }

        // 過去1年間のbornInfo取得
        $last_year_bornInfos = DB::table('born_infos')
            ->where('female_id', $femalePig->id)
            ->where('born_day', '>', $last_year)
            ->get();

        // 出産あり
        if (BornInfo::where('female_id', $femalePig->id)->exists()) {
            // 回転数算出
            $bornInfos = $femalePig->born_infos;
            $count = count($bornInfos);
            for ($i=0; $i < $count-1 ; $i++) { 
                $carbon_0 = Carbon::create($bornInfos[$i]->born_day);
                $carbon_1 = Carbon::create($bornInfos[$i+1]->born_day);
                $rotate_date = 365 / $carbon_0->diffInDays($carbon_1);
                // bornInfoにrotateを追加
                $bornInfos[$i+1]['rotate'] = round($rotate_date, 2);
            }
            
            // 過去1年間の回転数算出
            $lastY_born_rotates = [];
            $count = count($last_year_bornInfos);
            for ($i=0; $i < $count-1 ; $i++) { 
                $carbon_0 = Carbon::create($last_year_bornInfos[$i]->born_day);
                $carbon_1 = Carbon::create($last_year_bornInfos[$i+1]->born_day);
                $rotate_date = 365 / $carbon_0->diffInDays($carbon_1);
                // 
                $lastY_born_rotates[] = round($rotate_date, 2);
            }
            // 回転数がない場合
            if (empty($lastY_born_rotates)) {
                $lastY_born_rotates[] = 0;
            }

            // 最新の出産情報取得
            $bornInfo = $bornInfos[(count($bornInfos)-1)];
            $bornInfo['av_born_num'] = round($bornInfos->avg('born_num'), 2);
            $bornInfo['lastYav_born_num'] = round($last_year_bornInfos->avg('born_num'), 2);
            $bornInfo['av_rotate'] = round($bornInfos->avg('rotate'), 2);
            $bornInfo['lastYav_rotate'] = round(array_sum($lastY_born_rotates) / count($lastY_born_rotates), 2);

        // 出産なし
        } else {
            $bornInfos = [];
            $bornInfo = null;
        }
        // dd($bornInfo);
        return view('female_pigs.show')->with(compact('femalePig', 'mixInfos', 'bornInfos', 'mixInfo', 'bornInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FemalePig  $femalePig
     * @return \Illuminate\Http\Response
     */
    public function edit(FemalePig $femalePig)
    {
        return view('female_pigs.edit')->with(compact('femalePig'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFemalePigRequest  $request
     * @param  \App\Models\FemalePig  $femalePig
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateFemalePigRequest $request,
        FemalePig $femalePig
    ) {
        // 変更前の個体番号を保持
        $individual_num = $femalePig->individual_num;
        $femalePig->fill($request->all());

        // 個体番号を変更する場合は複合ユニークを確認
        if ($individual_num !== $request->individual_num) {
            $request->validate([
                'individual_num' => 'required|string|max:20|unique:female_pigs,individual_num,NULL,exist,exist,1'
            ]);
        }

        // 登録
        try {
            $femalePig->save();
            return redirect()
                ->route('female_pigs.show', $femalePig)
                ->with('notice', '修正しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FemalePig  $femalePig
     * @return \Illuminate\Http\Response
     */
    public function destroy(FemalePig $femalePig)
    {
        // フラッシュメッセージ作成
        $flash_msg = $femalePig->individual_num . 'を廃用にしました';

        try {
            $femalePig->delete();
            return redirect()
                ->route('female_pigs.index')
                ->with('notice', $flash_msg);
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }
}
