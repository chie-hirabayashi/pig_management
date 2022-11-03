<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFemalePigRequest;
use App\Http\Requests\UpdateFemalePigRequest;
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
        // $mixInfos = MixInfo::all();
        
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
            $recurrences = DB::table('mix_infos')
                ->where('female_id', $femalePig->id)
                ->where('trouble_id', 2)
                ->get();
            $mixInfo['sum_recurrence'] = count($recurrences);

            // 流産取得
            $abortions = DB::table('mix_infos')
                ->where('female_id', $femalePig->id)
                ->where('trouble_id', 3)
                ->get();
            $mixInfo['sum_abortion'] = count($abortions);
            
            // 過去1年間の再発取得
            $last_year_recurrences = $recurrences->where('trouble_day', '>', $last_year);
            $mixInfo['lastYsum_recurrences'] = count($last_year_recurrences);
            
            // 過去1年間の流産取得
            $last_year_abortions = $abortions->where('trouble_day', '>', $last_year);
            $mixInfo['lastYsum_abortions'] = count($last_year_abortions);
        } else {
            $born_infos = [];
            $born_info = null;
            return view('female_pigs.show')->with(compact('femalePig', 'mixInfos', 'mixInfo', 'born_infos', 'born_info'));
        }

        // 出産回数
        $born_infos = MixInfo::where('female_id', $femalePig->id)
            ->whereNotNull('born_day')->get();
        $count_born_infos = count($born_infos);

        // 過去１年間の出産回数
        $last_year_bornInfos = $mixInfos->where('born_day', '>', $last_year);
        $count_lastY_born_infos = count($last_year_bornInfos);
        // dd($count_born_infos);
        if ($count_born_infos !== 0) {
        // 出産あり
            // 回転数算出
            for ($i=0; $i < $count_born_infos-1 ; $i++) { 
                $carbon_1 = Carbon::create($born_infos[$i]->born_day);
                $carbon_2 = Carbon::create($born_infos[$i+1]->born_day);
                $rotate = 365 / $carbon_1->diffInDays($carbon_2);
                // born_infosにrotateを追加
                $born_infos[$i+1]['rotate'] = round($rotate, 2);
            }

            if ($count_born_infos == 1) {
                $born_infos[0]['rotate'] = 0;
            }
            
            // 過去1年間の回転数算出
            for ($i=0; $i < $count_lastY_born_infos-1 ; $i++) { 
                $carbon_1 = Carbon::create($last_year_bornInfos[$i]->born_day);
                $carbon_2 = Carbon::create($last_year_bornInfos[$i+1]->born_day);
                $rotate = 365 / $carbon_1->diffInDays($carbon_2);
                // 
                $lastY_born_rotates[] = round($rotate, 2);
            }
            // 回転数がない場合
            if (empty($lastY_born_rotates)) {
                $lastY_born_rotates[] = 0;
            }
            // dd($lastY_born_rotates);

            // 最新の出産情報取得
            $born_info = $born_infos[($count_born_infos-1)];
            $born_info['count_born'] = $count_born_infos;
            $born_info['count_lastY_born'] = $count_lastY_born_infos;
            $born_info['av_born_num'] = round($born_infos->avg('born_num'), 2);
            $born_info['lastYav_born_num'] = round($last_year_bornInfos->avg('born_num'), 2);
            $born_info['av_rotate'] = round($born_infos->avg('rotate'), 2);
            $born_info['lastYav_rotate'] = round(array_sum($lastY_born_rotates) / count($lastY_born_rotates), 2);

        } else {
        // 出産なし
            $born_infos = [];
            $born_info = null;
        }
// dd($mixInfo);
        return view('female_pigs.show')->with(compact('femalePig', 'mixInfos', 'mixInfo', 'born_infos', 'born_info'));
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
        // 一番古い交配日を取得、バリデーション
        $mix_day = $femalePig->mix_infos->first()->mix_day;
        if ($mix_day < $request->add_day) {
            return back()->withErrors('導入日が正しくありません。交配日より前の日付に変更してください。');
        }
        
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
