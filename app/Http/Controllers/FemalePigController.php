<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFemalePigRequest;
use App\Http\Requests\UpdateFemalePigRequest;
use App\Models\FemalePig;
use App\Models\MixInfo;
use App\Exports\FemalePigExport;
use App\Imports\FemalePigImport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FemalePigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchItems = FemalePig::all()->sortBy('individual_num');
        $femalePigs = FemalePig::with('mix_infos')->with('born_infos')->get();
        // $femalePigs = FemalePig::all(); これだとN+1
        // dd($femalePigs);
        // Explanation:状態statusの区分
        // 観察中:交配から120日間(交配~出産予定114日+6日)
        // 保育中:出産から24日間(離乳21~25日)
        // 待機中:再発、流産後(+上記以外)

        foreach ($femalePigs as $femalePig) {
            $mixInfo_last = $femalePig->mix_infos->last();
            $bornInfo_last = $femalePig->born_infos->last();
            // $today = Carbon::now(); //本設定
            $today = Carbon::create('2022-10-25'); //仮設定
            // $today = Carbon::create('2022-8-1'); //仮設定

            // if (!empty($mixInfo_last->mix_day)) {
            if (!empty($mixInfo_last)) {
                $mix_day = Carbon::create($mixInfo_last->mix_day);
            }

            if (!empty($bornInfo_last)) {
                $born_day = Carbon::create($bornInfo_last->born_day);
            }

            switch (true) {
                // 観察中:交配から120日間(交配~出産予定114日+6日)
                case !empty($mixInfo_last) &&
                    $today->diffInDays($mix_day) <= 120:
                    $femalePig->status = '観察中';
                    break;

                // 保育中:出産から24日間(離乳21~25日)
                case !empty($bornInfo_last) &&
                    $today->diffInDays($born_day) < 24:
                    $femalePig->status = '保育中';
                    break;

                // 待機中:再発、流産後
                case !empty($mixInfo_last) && $mixInfo_last->trouble_id !== 1:
                    $femalePig->status = '待機中';
                    break;

                // 上記以外
                default:
                    $femalePig->status = '待機中';
                    break;
            }
// dd($femalePigs);
            // $bornInfo_last = MixInfo::where('female_id', $femalePig->id)
            //     ->whereNotNull('born_day')
            //     ->get()
            //     ->last();
            // bornInfoがある場合、予測回転数算出
            if ($bornInfo_last) {
                $femalePig->rotate_prediction = self::getnPredictionRotateFromBornInfo($bornInfo_last);
                // $femalePig->rotate_prediction = self::getPredictionRotate(
                //     $femalePig
                // );
            }
        }

        // status順に並び替え
        $femalePigs = $femalePigs->sortByDesc('status');

        // 検索機能
        $search = $request->search;
        $search_age = $request->search_age;
        $search_flag = $request->search_flag;
        $search_rotate = $request->search_rotate;
        if ($search !== null) {
            $femalePigs = $femalePigs->where('id', $search);
        }
        if ($search_age) {
            $femalePigs = $femalePigs->filter(function ($femalePig) use (
                $search_age
            ) {
                return $femalePig->age == $search_age;
            });
        }
        if ($search_flag) {
            $femalePigs = $femalePigs->where('warn_flag', $search_flag);
        }
        if ($search_rotate) {
            $femalePigs = $femalePigs
                ->where('rotate_prediction', '!==', null)
                ->where('rotate_prediction', '<=', 1.8);
        }
        // dd($femalePigs);

        return view('female_pigs.index')->with(
            compact('femalePigs', 'searchItems')
        );
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
        $mixInfos = $femalePig
            ->mix_infos()
            ->orderBy('mix_day', 'desc') //->latest()でも可
            ->get()
            ->load('female_pig');

        $mixInfo = $mixInfos->first();
        // 出産情報の入れ物作成
        $bornInfos = new Collection();

        // 現在から1年前の日付を定義
        $last_year = Carbon::now()
            ->subYear(1)
            ->toDateString();

        // mixInfo交配情報の整理
        if ($mixInfo) {
            // 再発総数を登録
            $recurrences = DB::table('mix_infos')
                ->where('female_id', $femalePig->id)
                ->where('trouble_id', 2)
                ->get();
            $mixInfo['sum_recurrence'] = count($recurrences);

            // 流産総数を登録
            $abortions = DB::table('mix_infos')
                ->where('female_id', $femalePig->id)
                ->where('trouble_id', 3)
                ->get();
            $mixInfo['sum_abortion'] = count($abortions);

            // 過去1年間の再発回数を登録
            $last_year_recurrences = $recurrences->where(
                'trouble_day',
                '>',
                $last_year
            );
            $mixInfo['lastYsum_recurrences'] = count($last_year_recurrences);

            // 過去1年間の流産回数を登録
            $last_year_abortions = $abortions->where(
                'trouble_day',
                '>',
                $last_year
            );
            $mixInfo['lastYsum_abortions'] = count($last_year_abortions);
        } else {
            // 交配記録が1件もない場合、空の出産データを渡す
            $mix_ranking = [];

            return view('female_pigs.show')->with(
                compact(
                    'femalePig',
                    'mixInfos',
                    'mixInfo',
                    'bornInfos',
                    'mix_ranking',
                )
            );
        }

        // 交配相手ごとにデータ整理
        $first_mixes = $femalePig->mix_infos->groupBy('first_male_id');
        $second_mixes = $femalePig->mix_infos->groupBy('second_male_id');
        $first_noTorouble_mixes = $femalePig->mix_infos
            ->where('trouble_id', 1)
            ->groupBy('first_male_id');
        $second_noTorouble_mixes = $femalePig->mix_infos
            ->where('trouble_id', 1)
            ->groupBy('second_male_id');

        $all_mixes = self::mergeTowMixes($first_mixes, $second_mixes);
        $noTrouble_mixes = self::mergeTowMixes(
            $first_noTorouble_mixes,
            $second_noTorouble_mixes
        );

        unset($all_mixes['']);
        unset($noTrouble_mixes['']);
        // dd($noTrouble_mixes);

        foreach ($all_mixes as $key1 => $val1) {
            // male_pigのsoftDelete対策
            $array = self::maleSoftDeleteResolution($key1);
            $exist_male = $array[0];
            $delete_male = $array[1];

            foreach ($noTrouble_mixes as $key2 => $val2) {
                if ($key1 == $key2) {
                    $maleGroupe_mix_infos[] = [
                        'male' => $exist_male,
                        'delete_male' => $delete_male,
                        'mix_all' => $val1,
                        'mix_noTrouble' => $val2,
                        'mix_probability' => round(($val2 / $val1) * 100),
                    ];
                }
            }
        }

        $all_ids = array_keys($all_mixes);
        $noTrouble_ids = array_keys($noTrouble_mixes);

        foreach ($all_ids as $id) {
            if (!in_array($id, $noTrouble_ids)) {
                // male_pigのsoftDelete対策
                $array = self::maleSoftDeleteResolution($id);
                $exist_male = $array[0];
                $delete_male = $array[1];

                $maleGroupe_mix_infos[] = [
                    'male' => $exist_male,
                    'delete_male' => $delete_male,
                    'mix_all' => $all_mixes[$id],
                    'mix_noTrouble' => 0,
                    'mix_probability' => 0,
                ];
            }
        }

        // deleteMaleを除く交配ランキング
        $count = count($maleGroupe_mix_infos);
        for ($i = 0; $i < $count; $i++) {
            if ($maleGroupe_mix_infos[$i]['male'] == null) {
                unset($maleGroupe_mix_infos[$i]);
            }
        }

        // 並び替え要素を準備
        $mix_probabilitys = array_column(
            $maleGroupe_mix_infos,
            'mix_probability'
        );
        $mix_all = array_column($maleGroupe_mix_infos, 'mix_all');

        // good順に並び替え
        array_multisort(
            $mix_probabilitys,
            SORT_DESC,
            $mix_all,
            SORT_DESC,
            $maleGroupe_mix_infos
        );
        $mix_ranking = $maleGroupe_mix_infos;


        // 出産情報の入れ物作成
        $bornInfos = new Collection();
        // $bornInfos = new SupportCollection();
        // 全出産情報取得
        foreach ($mixInfos as $mixInfo) {
            $bornInfo = $mixInfo->born_info()->get()->load('mix_info');
            if (!empty($bornInfo[0])) {
            // dd($bornInfo);
            // if (!empty($bornInfo)) {これはだめ
                $bornInfos->add($bornInfo[0]);
            }
        }

        // dd($bornInfos);

        // 過去１年間の出産情報
        $lastYear_bornInfos = $bornInfos
            ->where('born_day', '>', $last_year);
// dd($lastYear_bornInfos);
        $count_allBorn = count($bornInfos);
        $count_lastYearBorn = count($lastYear_bornInfos);

        switch (true) {
            case $count_allBorn == 1:
                // 1回の出産情報を登録(回転数なし)
                $bornInfos->first()->rotate = null; //回転数なし
                $bornInfos->first()->count_allBorn = $count_allBorn; //全出産回数
                $bornInfos->first()->count_lastYearBorn = $count_lastYearBorn; //過去1年間の出産回数
                break;

            case $count_allBorn > 1:
                // 回転数を登録
                $rotates = self::getRotate($bornInfos); //回転数算出
                for ($i = 0; $i < $count_allBorn - 1; $i++) {
                    $bornInfos[$i]['rotate'] = $rotates[$i];
                }

                // 2回以上の出産情報を登録(回転数あり)
                $bornInfos->first()->count_allBorn = $count_allBorn; //全出産回数
                $bornInfos->first()->count_lastYearBorn = $count_lastYearBorn; //過去1年間の出産回数
                break;
        }

        // 以下出産情報の整理
        // 全ての出産情報
        $born_infos = MixInfo::with('female_pig')
            ->where('female_id', $femalePig->id)
            ->whereNotNull('born_day')
            ->orderBy('mix_day', 'desc') //->latest()でも可
            ->get();

        // 過去１年間の出産情報
        $last_year_bornInfos = MixInfo::where('female_id', $femalePig->id)
            ->whereNotNull('born_day')
            ->where('born_day', '>', $last_year)
            ->latest()
            ->get();

        $count_born_infos = count($born_infos);
        $count_lastY_born_infos = count($last_year_bornInfos);

        switch (true) {
            case $count_born_infos == 0:
                // 空の出産情報を登録
                $born_infos = [];
                $born_info = null;
                $born_info_last_time = null;
                break;

            case $count_born_infos == 1:
                // 1回の出産情報を登録(回転数なし)
                $born_infos[0]['rotate'] = null; // 回転数なし
                $born_info = $born_infos->first();
                $born_info_last_time = null;
                $born_info['count_born'] = $count_born_infos; //出産回数
                $born_info['count_lastY_born'] = $count_lastY_born_infos; //過去1年間の出産回数
                $born_info['av_born_num'] = round(
                    $born_infos->avg('born_num'),
                    2
                ); //平均産子数
                $born_info['av_rotate'] = null; //平均回転数
                break;

            default:
                // 回転数を登録
                $rotates = self::getRotate($born_infos); //回転数算出
                for ($i = 0; $i < $count_born_infos - 1; $i++) {
                    $born_infos[$i]['rotate'] = $rotates[$i];
                }

                // 2回以上の出産情報を登録(回転数あり)
                $born_info = $born_infos->first();
                $born_info_last_time = $born_infos[1];
                $born_info['count_born'] = $count_born_infos; //出産回数
                $born_info['count_lastY_born'] = $count_lastY_born_infos; //過去1年間の出産回数
                $born_info['av_born_num'] = round(
                    $born_infos->avg('born_num'),
                    2
                ); //平均産子数
                $born_info['av_rotate'] = round($born_infos->avg('rotate'), 2); //平均回転数
                break;
        }
// dd($mixInfos);
        // mixInfosのsoftDelete対策
        foreach ($mixInfos as $info) {
            // first_male_pigのsoftDelete対策
            $array = self::maleSoftDeleteResolution($info->first_male_id);
            $exist_male = $array[0];
            $delete_male = $array[1];
            // dd($array);
            $info->first_male = $exist_male;
            $info->first_delete_male = $delete_male;

            // second_male_pigのnullとsoftDelete対策
            if ($info->second_male_id !== null) {
                $array = self::maleSoftDeleteResolution($info->second_male_id);
                $exist_male = $array[0];
                $delete_male = $array[1];
                $info->second_male = $exist_male;
                $info->second_delete_male = $delete_male;
            } else {
                $info->second_male = null;
                $info->second_delete_male = null;
            }
        }
// dd($mixInfos);
        // borninfosのsoftDelete対策
        foreach ($bornInfos as $info) {
            $mix_info = $info->mix_info()->get();
            $array = self::maleSoftDeleteResolution($mix_info->first()->first_male_id);
            $exist_male = $array[0];
            $delete_male = $array[1];
            $info->first_male = $exist_male;
            $info->first_delete_male = $delete_male;

            // second_male_pigのnullとsoftDelete対策
            if ($mix_info->first()->second_male_id !== null) {
                $array = self::maleSoftDeleteResolution($mix_info->first()->second_male_id);
                $exist_male = $array[0];
                $delete_male = $array[1];
                $info->second_male = $exist_male;
                $info->second_delete_male = $delete_male;
            } else {
                $info->second_male = null;
                $info->second_delete_male = null;
            }
        }

        // born_infosのsoftDelete対策
        foreach ($born_infos as $info) {
            // first_male_pigのsoftDelete対策
            $array = self::maleSoftDeleteResolution($info->first_male_id);
            $exist_male = $array[0];
            $delete_male = $array[1];
            $info->first_male = $exist_male;
            $info->first_delete_male = $delete_male;

            // second_male_pigのnullとsoftDelete対策
            if ($info->second_male_id !== null) {
                $array = self::maleSoftDeleteResolution($info->second_male_id);
                $exist_male = $array[0];
                $delete_male = $array[1];
                $info->second_male = $exist_male;
                $info->second_delete_male = $delete_male;
            } else {
                $info->second_male = null;
                $info->second_delete_male = null;
            }
        }

        return view('female_pigs.show')->with(
            compact(
                'femalePig',
                'mixInfos',
                'mixInfo',
                'mix_ranking',
                'bornInfos'
            )
        );
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
        // error:最初の交配日<導入日
        $mix_day = $femalePig->mix_infos->first()->mix_day;
        if ($mix_day < $request->add_day) {
            return back()->withErrors(
                '導入日が正しくありません。交配日より前の日付に変更してください。'
            );
        }

        // 変更前の個体番号を保持
        $before_individual_num = $femalePig->individual_num;
        $femalePig->fill($request->all());

        // 個体番号を変更する場合:複合ユニークを確認
        if ($before_individual_num !== $request->individual_num) {
            $request->validate([
                'individual_num' =>
                    'required|string|max:20|unique:female_pigs,individual_num,NULL,exist,exist,1',
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
        // 通知作成
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

    public function updateFlag(Request $request, FemalePig $femalePig)
    {
        $femalePig->warn_flag = $request->warn_flag;

        try {
            $femalePig->save();
            return redirect(route('female_pigs.show', $femalePig));
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    public function updateRecurrence(Request $request, FemalePig $femalePig)
    {
        $mixInfo = $femalePig->mix_infos->last();
        $mixInfo->fill($request->all());

        try {
            $mixInfo->save();
            return redirect(route('female_pigs.show', $femalePig));
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new FemalePigExport(), 'femalePigs_data.xlsx');
    }

    public function import(Request $request)
    {
        $excel_file = $request->file('excel_file');
        $excel_file->store('excels');
        Excel::import(new FemalePigImport(), $excel_file);
        // return view('index');
        return redirect()
            ->route('female_pigs.index')
            ->with('notice', 'インポートしました');
    }

    // // 回転数算出function
    // public function getRotate($bornInfos)
    // {
    //     $array = [];
    //     $count = count($bornInfos);
    //     for ($i = 0; $i < $count - 1; $i++) {
    //         $carbon_1 = Carbon::create($bornInfos[$i]->born_day);
    //         $carbon_2 = Carbon::create($bornInfos[$i + 1]->born_day);
    //         $rotate = 365 / $carbon_1->diffInDays($carbon_2);
    //         // born_infosにrotateを追加
    //         $array[$i] = round($rotate, 2);
    //     }
    //     return $array;
    // }

    // first_male_pigとsecond_male_pigの
    // softDeleteとnull対策function
    // public function softDeleteResolution($mixInfos)
    // {
    //     foreach ($mixInfos as $mixInfo) {
    //         // first_male_pigのsoftDelete対策
    //         $judge_1 = MalePig::where('id', $mixInfo->first_male_id)
    //             ->onlyTrashed()
    //             ->get();
    //         if ($judge_1->isnotEmpty()) {
    //             $deletePig_1 = $judge_1[0]->individual_num;
    //             $mixInfo->first_delete_male = $deletePig_1;
    //             $mixInfo->first_male = null;
    //         } else {
    //             $mixInfo->first_delete_male = null;
    //             $mixInfo->first_male = $mixInfo->first_male_pig->individual_num;
    //         }

    //         // second_male_pigのnullとsoftDelete対策
    //         if ($mixInfo->second_male_id !== null) {
    //             $judge_2 = MalePig::where('id', $mixInfo->second_male_id)
    //                 ->onlyTrashed()
    //                 ->get();
    //             if ($judge_2->isnotEmpty()) {
    //                 $deletePig_2 = $judge_2[0]->individual_num;
    //                 $mixInfo->second_delete_male = $deletePig_2;
    //                 $mixInfo->second_male = null;
    //             } else {
    //                 $mixInfo->second_delete_male = null;
    //                 $mixInfo->second_male =
    //                     $mixInfo->second_male_pig->individual_num;
    //             }
    //         } else {
    //             $mixInfo->second_delete_male = null;
    //             $mixInfo->second_male = null;
    //         }
    //     }
    //     return $mixInfos;
    // }

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

    // female_pigのsoftDelete対策
    // リファクタリング
    // public function onemaleSoftDeleteResolution($id)
    // {
    //     $judge = MalePig::where('id', $id)
    //         ->onlyTrashed()
    //         ->get();
    //     if ($judge->isnotEmpty()) {
    //         $exist_male = null;
    //         $delete_male = $judge[0]->individual_num;
    //     } else {
    //         $exist_male = MalePig::find($id)->individual_num;
    //         $delete_male = null;
    //     }
    //     return [$exist_male, $delete_male];
    // }

    // public function testmaleSoftDeleteResolution($id)
    // {
    //     $judge = MalePig::where('id', $id)
    //         ->onlyTrashed()
    //         ->get();
    //     if ($judge->isnotEmpty()) {
    //         $exist_male = null;
    //         $delete_male = $judge[0]->individual_num;
    //     } else {
    //         $exist_male = MalePig::find($id)->individual_num;
    //         $delete_male = null;
    //     }
    //     return [$exist_male, $delete_male];
    // }
}
