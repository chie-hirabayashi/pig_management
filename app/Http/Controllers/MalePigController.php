<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMalePigRequest;
use App\Http\Requests\UpdateMalePigRequest;
use App\Exports\MalePigExport;
use App\Imports\MalePigImport;
use App\Models\FemalePig;
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
        $malePigs = MalePig::with('first_mix_infos')
            ->with('second_mix_infos')
            ->get();

        foreach ($malePigs as $malePig) {
            // 全交配情報取得
            $first_mixs = $malePig->first_mix_infos;
            $second_mixs = $malePig->second_mix_infos;
            // 異常のない交配情報取得
            $first_noTroubles = $malePig->first_mix_infos->where(
                'trouble_id',
                1
            );
            $second_noTroubles = $malePig->second_mix_infos->where(
                'trouble_id',
                1
            );
            // 交配成功率算出
            $mix_probability =
                (count($first_noTroubles) + count($second_noTroubles)) /
                (count($first_mixs) + count($second_mixs));

            // 交配成功率をセット
            $malePig->mix_probability = round($mix_probability * 100, 0);

            // 交配相手ごとにデータを整理
            $first_females = $first_mixs->groupBy('female_id');
            $second_females = $second_mixs->groupBy('female_id');
            $first_noTrouble_females = $first_noTroubles->groupBy('female_id');
            $second_noTrouble_females = $second_noTroubles->groupBy(
                'female_id'
            );

            // 交配相手ごとにデータを整理
            $first_females = $first_mixs->groupBy('female_id');
            $second_females = $second_mixs->groupBy('female_id');
            $first_noTrouble_females = $first_noTroubles->groupBy('female_id');
            $second_noTrouble_females = $second_noTroubles->groupBy(
                'female_id'
            );

            // 1回目と2回目の交配回数をまとめる(経過異常含む)
            $first_mixes = [];
            foreach ($first_females as $key => $val) {
                $first_mixes[$key] = count($val);
            }
            $second_mixes = [];
            foreach ($second_females as $key => $val) {
                $second_mixes[$key] = count($val);
            }
            foreach ($first_mixes as $key1 => $val1) {
                foreach ($second_mixes as $key2 => $val2) {
                    if ($key1 == $key2) {
                        $first_mixes[$key1] = $val1 + $val2;
                    }
                }
            }

            $all_mixes = $first_mixes + $second_mixes;
            $malePig->all_mixes = array_sum($all_mixes);
        }
        // dd($malePig);

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
        // 全交配情報取得
        $first_mixs = $malePig->first_mix_infos;
        $second_mixs = $malePig->second_mix_infos;
        // 異常のない交配情報取得
        $first_noTroubles = $first_mixs->where('trouble_id', 1);
        $second_noTroubles = $second_mixs->where('trouble_id', 1);

        // 交配成功率算出
        $mix_probability =
            (count($first_noTroubles) + count($second_noTroubles)) /
            (count($first_mixs) + count($second_mixs));

        // 交配成功率をセット
        $malePig->mix_probability = round($mix_probability * 100, 0);

        // 交配相手ごとにデータを整理
        $first_females = $first_mixs->groupBy('female_id');
        $second_females = $second_mixs->groupBy('female_id');
        $first_noTrouble_females = $first_noTroubles->groupBy('female_id');
        $second_noTrouble_females = $second_noTroubles->groupBy('female_id');

        // 1回目と2回目の交配回数をまとめる(経過異常含む)
        $all_mixes = self::mergeTowMixes($first_females, $second_females);

        // 1回目と2回目の交配回数をまとめる(経過順調のみ)
        $noTrouble_mixes = self::mergeTowMixes($first_noTrouble_females, $second_noTrouble_females);

        foreach ($all_mixes as $key1 => $val1) {
            // female_pigのsoftDelete対策
            $array = self::femaleSoftDeleteResolution($key1);
            $exist_female = $array[0];
            $delete_female = $array[1];

            foreach ($noTrouble_mixes as $key2 => $val2) {
                if ($key1 == $key2) {
                    $individual_mix_indfos[] = [
                        'female' => $exist_female,
                        'delete_female' => $delete_female,
                        'mix_all' => $val1,
                        'mix_noTrouble' => $val2,
                        'mix_probability' => round(($val2 / $val1) * 100),
                    ];
                }
            }
        }

        $key_1 = array_keys($all_mixes);
        $key_2 = array_keys($noTrouble_mixes);

        foreach ($key_1 as $key) {
            if (!in_array($key, $key_2)) {
                // female_pigのsoftDelete対策
                $array = self::femaleSoftDeleteResolution($key);
                $exist_female = $array[0];
                $delete_female = $array[1];

                $individual_mix_indfos[] = [
                    'female' => $exist_female,
                    'delete_female' => $delete_female,
                    'mix_all' => $all_mixes[$key],
                    'mix_noTrouble' => 0,
                    'mix_probability' => 0,
                ];
            }
        }

        // セット
        $malePig->individual_mix_infos = $individual_mix_indfos;

        return view('male_pigs.show')->with(compact('malePig'));
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
            $first_mix_day = $malePig->first_mix_infos->first()->mix_day;
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
            return redirect(route('male_pigs.show', $malePig));
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    public function mergeTowMixes($first_datas, $second_datas)
    {
        $first_lists = [];
        foreach ($first_datas as $key => $val) {
            $first_lists[$key] = count($val);
        }
        $second_lists = [];
        foreach ($second_datas as $key => $val) {
            $second_lists[$key] = count($val);
        }
        foreach ($first_lists as $key1 => $val1) {
            foreach ($second_lists as $key2 => $val2) {
                if ($key1 == $key2) {
                    $first_lists[$key1] = $val1 + $val2;
                }
            }
        }
        return $first_lists + $second_lists;
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
