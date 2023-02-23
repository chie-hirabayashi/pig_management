<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFemalePigRequest;
use App\Http\Requests\UpdateFemalePigRequest;
use App\Http\Requests\importRequest;
use App\Models\FemalePig;
use App\Models\MixInfo;
use App\Exports\FemalePigExport;
use App\Imports\FemalePigImport;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Stmt\TryCatch;

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
        $femalePigs = FemalePig::with(['mix_infos', 'place'])->get();

        // foreach ($femalePigs as $femalePig) {
        //     $femalePig->status; # 状態プロパティ追加
        //     $femalePig->rotate_prediction; # 予測回転数プロパティ追加
        //     $femalePig->sort_day;
        // }

        // status順に並び替え
        $femalePigs = $femalePigs->sortByDesc('status')->sortBy('sort_day');

        // $today = Carbon::now(); 
        
        // $first_recurrence = Carbon::create($femalePigs[0]->mix_infos->last()->first_recurrence_schedule);
        // $second_recurrence = Carbon::create($femalePigs[0]->mix_infos->last()->second_recurrence_schedule);
        // $delivery_recurrence = Carbon::create($femalePigs[0]->mix_infos->last()->delivery_schedule);
        
        // $day1 = $today->diffInDays($first_recurrence);
        // $day2 = $today->diffInDays($second_recurrence);
        // $day3 = $today->diffInDays($delivery_recurrence);
        // $box = [$day1, $day2, $day3];

        // $femalePigs[0]->day = min($box);
// dd($femalePigs);
        // 検索機能
        $search = $request->search;
        $search_age = $request->search_age;
        $search_flag = $request->search_flag;
        $search_rotate = $request->search_rotate;
        if ($search) {
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
        $mixInfos = MixInfo::where('female_id', $femalePig->id)->get();

        // // 1年前の日付
        $last_year = Carbon::now()
            ->subYear(1)
            ->toDateString();

        # $mixInfos start #
        if ($mixInfos->isNotEmpty()) {
            // 再発総数を登録
            $count_recurrences = $femalePig
                ->mix_infos
                ->where('trouble_id', 2)
                ->count();
            // $count_recurrences = $femalePig
            //     ->mix_infos()
            //     ->where('trouble_id', 2)
            //     ->count();
            $mixInfos->last()->count_recurrences = $count_recurrences;

            // 流産総数を登録
            $count_abortions = $femalePig
                ->mix_infos
                ->where('trouble_id', 3)
                ->count();
            // $count_abortions = $femalePig
            //     ->mix_infos()
            //     ->where('trouble_id', 3)
            //     ->get() //これと
            //     ->load('female_pig') //これを追加してN+1解消
            //     ->count();
            $mixInfos->last()->count_abortions = $count_abortions;

            // 過去1年間の再発回数を登録
            $count_lastYear_recurrences = $femalePig
                ->mix_infos
                ->where('trouble_id', 2)
                ->where('trouble_day', '>', $last_year)
                ->count();
            // $count_lastYear_recurrences = $femalePig
            //     ->mix_infos()
            //     ->where('trouble_id', 2)
            //     ->where('trouble_day', '>', $last_year)
            //     ->count();
            $mixInfos->last()->count_lastYear_recurrences = $count_lastYear_recurrences;

            // 過去1年間の流産回数を登録
            $count_lastYear_abortions = $femalePig
                ->mix_infos
                ->where('trouble_id', 3)
                ->where('trouble_day', '>', $last_year)
                ->count();
            // $count_lastYear_abortions = $femalePig
            //     ->mix_infos()
            //     ->where('trouble_id', 3)
            //     ->where('trouble_day', '>', $last_year)
            //     ->get() //これと
            //     ->load('female_pig') //これを追加してN+1解消
            //     ->count();
            $mixInfos->last()->count_lastYear_abortions = $count_lastYear_abortions;
        } else {
            # $mixInfosが0件の場合 start #
            $mix_ranking = [];
            $born_infos = [];
// dd($born_infos);
            return view('female_pigs.show')->with(
                compact('femalePig', 'mixInfos', 'born_infos', 'mix_ranking')
            );
            # $mixInfosが0件の場合 end #
        }
        # $mixInfos end #

        # mix_ranking start #
        // 全ての交配情報のarray作成 : $male_id => $count_allMixes
        $first_mixes = $femalePig->mix_infos->groupBy('first_male_id');
        $second_mixes = $femalePig->mix_infos->groupBy('second_male_id');
        $all_mixes = self::mergeTowMixes($first_mixes, $second_mixes);
        unset($all_mixes['']);

        // 成功した交配情報のarray作成 : $male_id => $count_noTrapubleMixes
        $first_noTrouble_mixes = $femalePig->mix_infos
            ->where('trouble_id', 1)
            ->groupBy('first_male_id');
        $second_noTrouble_mixes = $femalePig->mix_infos
            ->where('trouble_id', 1)
            ->groupBy('second_male_id');
        $noTrouble_mixes = self::mergeTowMixes(
            $first_noTrouble_mixes,
            $second_noTrouble_mixes
        );
        unset($noTrouble_mixes['']);

        // 交配成功率 > 0 の場合
        foreach ($all_mixes as $maleId_1 => $countMixes_all) {
            // male_pigのsoftDelete対策
            $array = self::maleSoftDeleteResolution($maleId_1);
            $exist_male = $array[0];
            $delete_male = $array[1];

            foreach ($noTrouble_mixes as $maleId_2 => $countMixes_noTrouble) {
                if ($maleId_1 == $maleId_2) {
                    $maleGroupe_mixInfos[] = [
                        'male' => $exist_male,
                        'delete_male' => $delete_male,
                        'mix_all' => $countMixes_all,
                        'mix_noTrouble' => $countMixes_noTrouble,
                        'mix_probability' => round(
                            ($countMixes_noTrouble / $countMixes_all) * 100
                        ),
                    ];
                }
            }
        }

        // male_idだけのarray作成
        $all_mixes_maleIds = array_keys($all_mixes);
        $noTrouble_mixes_maleIds = array_keys($noTrouble_mixes);

        // 交配成功率 == 0 の場合
        foreach ($all_mixes_maleIds as $id) {
            if (!in_array($id, $noTrouble_mixes_maleIds)) {
                // male_pigのsoftDelete対策
                $array = self::maleSoftDeleteResolution($id);
                $exist_male = $array[0];
                $delete_male = $array[1];

                $maleGroupe_mixInfos[] = [
                    'male' => $exist_male,
                    'delete_male' => $delete_male,
                    'mix_all' => $all_mixes[$id],
                    'mix_noTrouble' => 0,
                    'mix_probability' => 0,
                ];
            }
        }

        // delete_maleはランキング対象から除外する
        $count = count($maleGroupe_mixInfos); # これが無いとforの回数が変わり正しく処理されない
        for ($i = 0; $i < $count; $i++) {
            if ($maleGroupe_mixInfos[$i]['male'] == null) {
                unset($maleGroupe_mixInfos[$i]);
            }
        }
        // 並び替え要素(交配成功率、交配回数)を準備
        $mix_probabilities = array_column(
            $maleGroupe_mixInfos,
            'mix_probability'
        );
        $mix_all = array_column($maleGroupe_mixInfos, 'mix_all');

        // 交配成功率、交配回数順に並び替え
        array_multisort(
            $mix_probabilities,
            SORT_DESC,
            $mix_all,
            SORT_DESC,
            $maleGroupe_mixInfos
        );

        $mix_ranking = $maleGroupe_mixInfos;
        # mix_ranking end #

        # bornInfos start #
        // 全ての出産情報
        $born_infos = $mixInfos
            ->whereNotNull('born_day')
            ->values()
            ->load('female_pig');
        // dd($born_infos);
        // $born_infos = MixInfo::with('female_pig')
        //     ->where('female_id', $femalePig->id)
        //     ->whereNotNull('born_day')
        //     // ->orderBy('mix_day', 'desc') //->latest()は不可
        //     ->get();
        // 過去１年間の出産情報
        $lastYear_born_infos = $mixInfos
            ->whereNotNull('born_day')
            ->where('born_day', '>', $last_year);
        // $lastYear_born_infos = MixInfo::where('female_id', $femalePig->id)
        //     ->whereNotNull('born_day')
        //     ->where('born_day', '>', $last_year)
        //     ->get();

        $count_allBorn = count($born_infos);
        $count_lastYearBorn = count($lastYear_born_infos);

        switch (true) {
            case $count_allBorn == 0:
                // 空の出産情報を登録
                $born_infos = $mixInfos;
                break;

            case $count_allBorn == 1:
                // 1回の出産情報を登録(回転数なし)
                $born_infos->last()
                        ->rotate = null; //回転数なし
                $born_infos->last()
                        ->count_allBorn = $count_allBorn; //全出産回数
                $born_infos->last()
                        ->count_lastYearBorn = $count_lastYearBorn; //過去1年間の出産回数
                $born_infos->last()
                        ->rotate_prediction = self::getPredictionRotate($femalePig); //予測回転数
                break;

            case $count_allBorn > 1:
                // 回転数を登録
                $rotates = self::getRotate($born_infos); //回転数算出
                for ($i = 0; $i < $count_allBorn - 1; $i++) {
                    $born_infos[$i+1]['rotate'] = $rotates[$i];
                }

                // 2回以上の出産情報を登録(回転数あり)
                $born_infos->last()
                        ->count_allBorn = $count_allBorn; //全出産回数
                $born_infos->last()
                        ->count_lastYearBorn = $count_lastYearBorn; //過去1年間の出産回数
                $born_infos->last()
                        ->rotate_prediction = self::getPredictionRotate($femalePig); //予測回転数
                break;
        }
        # bornInfos end #

        # mixInfosのmalesoftDelete対策 start #
        foreach ($mixInfos as $info) {
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
        # mixInfosのmalesoftDelete対策 end #

        # bornInfosのmalesoftDelete対策 start #
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
// dd($mixInfos);
// dd($born_infos);
        return view('female_pigs.show')->with(
            compact(
                'femalePig',
                'mixInfos',
                'born_infos',
                'mix_ranking'
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

    public function import(importRequest $request)
    {
        // FIXME:データの取込は初期化してから、初期化コマンド作成、バリデーション作成
        try {
            $excel_file = $request->file('excel_file');
            $excel_file->store('excels');
            Excel::import(new FemalePigImport(), $excel_file);
            return redirect()
                ->route('female_pigs.index')
                ->with('notice', 'インポートしました');
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->withErrors($th->getMessage());
        }
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
