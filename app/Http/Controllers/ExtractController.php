<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MixInfo;
use App\Models\FemalePig;

class ExtractController extends Controller
{
    public function index(Request $request)
    {
        // 抽出方法変更
        // condition=1__直前で抽出(回転数または産子数:該当が多い、何を抽出したいか不明)
        // condition=2__直前、オプションありで抽出
        // condition=3__過去2回で抽出(回転数かつ産子数:該当が少なすぎて抽出できない)
        // condition=4__過去2回、オプションあり抽出

        // 抽出条件
        $condition = $request->condition; // 抽出方法
        $condition_first_rotate = $request->first_rotate; // 直前の回転数の条件
        $condition_second_rotate = $request->second_rotate; // 前回の回転数の条件
        $condition_first_num = $request->first_born_num; // 直前の産子数の条件
        $condition_second_num = $request->second_born_num; // 前回の産子数の条件
        $condition_female_age = $request->female_age; // 年齢の条件
        $condition_trouble_num = $request->trouble_num; // 再発および流産回数の条件
        $option_operator = $request->option_operator; // オプションで使用:年齢と異常回数をつなぐ演算子

        // view用に抽出条件をセット
        $extracts = [];
        $conditions['condition'] = $condition;
        $conditions['first_rotate'] = $condition_first_rotate;
        $conditions['second_rotate'] = $condition_second_rotate;
        $conditions['first_num'] = $condition_first_num;
        $conditions['second_num'] = $condition_second_num;
        $conditions['female_age'] = $condition_female_age;
        $conditions['trouble_num'] = $condition_trouble_num;
        $conditions['option_operator'] = $option_operator;

        // 稼働中のfemalePigsを取得
        // $femalePigs = FemalePig::where('deleted_at', null)->get();
        $femalePigs = FemalePig::with('mix_infos')->where('deleted_at', null)->get();
        foreach ($femalePigs as $femalePig) {
            // 再発、流産回数を取得
            $count_troubles = $femalePig
                ->mix_infos
                ->whereNotNull('trouble_day')
                ->load('female_pig')
                ->count(); # N+1解消 クエリ少ない モデル多い こっちが速い
            // $count_troubles = MixInfo::with('female_pig')->where('female_id', $femalePig->id)
            //     ->whereNotNull('trouble_day')
            //     ->count(); # N+1解消 クエリ発行が多い モデル少ない

            // 稼働中の全出産を取得
            $born_infos = $femalePig
                ->mix_infos
                ->load('female_pig')
                ->whereNotNull('born_day')
                ->sortByDesc('id')
                ->values(); # N+1解消 クエリ少ない モデル多い こっちが速い
            // $born_infos = MixInfo::with('female_pig')->where('female_id', $femalePig->id)
            //     ->orderBy('id', 'desc')
            //     ->whereNotNull('born_day')
            //     ->get(); # N+1解消 クエリ多い モデル少ない
            $count_born_all = count($born_infos); // 出産件数カウント

            // dd($born_infos);
            // 全出産件数ごとに回転数を算出
            switch (true) {
                case $count_born_all >= 3:
                    $bornInfo_3past = $born_infos->take(3); //過去3回の出産情報
                    $rotates = self::getRotate($bornInfo_3past); //回転数算出
                    for ($i = 0; $i < 2; $i++) {
                        $bornInfo_3past[$i]['rotate'] = $rotates[$i];
                        $bornInfo_3past[$i]['troubles'] = $count_troubles;
                    }
                    $bornInfo_2past = $bornInfo_3past->take(2);

                    // 予測回転数
                    $bornInfo_2past[0][
                        'rotate_prediction'
                    ] = self::getPredictionRotate($femalePig);
                    break;

                case $count_born_all == 2:
                    $bornInfo_2past = $born_infos; //過去2回の出産情報
                    $rotates = self::getRotate($bornInfo_2past); //回転数算出
                    $rotates[1] = 99;
                    for ($i = 0; $i < 2; $i++) {
                        $bornInfo_2past[$i]['rotate'] = $rotates[$i];
                        $bornInfo_2past[$i]['troubles'] = $count_troubles;
                    }

                    // 予測回転数
                    $bornInfo_2past[0][
                        'rotate_prediction'
                    ] = self::getPredictionRotate($femalePig);
                    break;

                case $count_born_all == 1:
                    $bornInfo_first = $born_infos->first(); //過去1回の出産情報
                    $bornInfo_second = new mixInfo();
                    $bornInfo_second->female_id = $femalePig->id;
                    $bornInfo_second->born_num = 99; // 抽出できない値をセット
                    $bornInfo_second->rotate = 99; // 抽出できない値をセット
                    $bornInfo_second->troubles = $count_troubles;
                    $bornInfo_2past[0] = $bornInfo_first;
                    $bornInfo_2past[1] = $bornInfo_second;
                    // 予測回転数
                    $bornInfo_2past[0][
                        'rotate_prediction'
                    ] = self::getPredictionRotate($femalePig);
                    break;

                case $count_born_all == 0:
                    $bornInfo_pretend = new mixInfo();
                    $bornInfo_pretend->female_id = $femalePig->id;
                    $bornInfo_pretend->born_num = 99; // 抽出できない値をセット
                    $bornInfo_pretend->rotate = 99; // 抽出できない値をセット
                    $bornInfo_pretend->troubles = $count_troubles;
                    $bornInfo_2past[0] = $bornInfo_pretend;
                    $bornInfo_2past[1] = $bornInfo_pretend;
                    $bornInfo_2past[0]['rotate_prediction'] = 99;
                    break;
            }

            // 抽出条件に従い抽出
            // 直前のみで抽出
            if ($condition == 1) {
                if (
                    ($bornInfo_2past[0]->rotate <= $condition_first_rotate &&
                        $bornInfo_2past[0]->born_num <= $condition_first_num) ||
                    $bornInfo_2past[0]->rotate_prediction <= 1.8
                ) {
                    $extracts[] = $bornInfo_2past[0];
                }
            }

            // 直前のみ、オプションありで抽出
            // operator_conditionはかつだけでOK
            if ($condition == 2) {
                // dd($option_operator);
                switch (true) {
                    // かつ
                    case $option_operator == 1:
                        if (
                            ($bornInfo_2past[0]->rotate <=
                                $condition_first_rotate &&
                                $bornInfo_2past[0]->born_num <=
                                    $condition_first_num &&
                                $bornInfo_2past[0]->troubles >=
                                    $condition_trouble_num &&
                                $femalePig->age >= $condition_female_age) ||
                            $bornInfo_2past[0]->rotate_prediction <= 1.8
                        ) {
                            $extracts[] = $bornInfo_2past[0];
                        }
                        break;

                    // または
                    case $option_operator == 2:
                        if (
                            ($bornInfo_2past[0]->rotate <=
                                $condition_first_rotate &&
                                $bornInfo_2past[0]->born_num <=
                                    $condition_first_num &&
                                ($bornInfo_2past[0]->troubles >=
                                    $condition_trouble_num ||
                                    $femalePig->age >=
                                        $condition_female_age)) ||
                            $bornInfo_2past[0]->rotate_prediction <= 1.8
                        ) {
                            $extracts[] = $bornInfo_2past[0];
                        }
                        break;
                }
            }

            // 過去2回で抽出
            if ($condition == 3) {
                if (
                    (($bornInfo_2past[0]->rotate <= $condition_first_rotate ||
                        $bornInfo_2past[0]->born_num <= $condition_first_num) &&
                        ($bornInfo_2past[1]->rotate <=
                            $condition_second_rotate ||
                            $bornInfo_2past[1]->born_num <=
                                $condition_second_num)) ||
                    $bornInfo_2past[0]->rotate_prediction <= 1.8
                ) {
                    $extracts[] = $bornInfo_2past[0];
                    $extracts[] = $bornInfo_2past[1];
                }
            }
            // 過去2回、オプションありで抽出
            if ($condition == 4) {
                switch (true) {
                    // かつ
                    case $option_operator == 1:
                        if (
                            ($femalePig->age >= $condition_female_age &&
                                $bornInfo_2past[0]->troubles >=
                                    $condition_trouble_num &&
                                $bornInfo_2past[1]->troubles >=
                                    $condition_trouble_num &&
                                ($bornInfo_2past[0]->rotate <=
                                    $condition_first_rotate ||
                                    $bornInfo_2past[0]->born_num <=
                                        $condition_first_num) &&
                                ($bornInfo_2past[1]->rotate <=
                                    $condition_second_rotate ||
                                    $bornInfo_2past[1]->born_num <=
                                        $condition_second_num)) ||
                            $bornInfo_2past[0]->rotate_prediction <= 1.8
                        ) {
                            $extracts[] = $bornInfo_2past[0];
                            $extracts[] = $bornInfo_2past[1];
                        }
                        break;

                    // または
                    case $option_operator == 2:
                        if (
                            (($bornInfo_2past[0]->rotate <=
                                $condition_first_rotate ||
                                $bornInfo_2past[0]->born_num <=
                                    $condition_first_num) &&
                                ($bornInfo_2past[1]->rotate <=
                                    $condition_second_rotate ||
                                    $bornInfo_2past[1]->born_num <=
                                        $condition_second_num) &&
                                ($femalePig->age >= $condition_female_age ||
                                    $bornInfo_2past[0]->troubles >=
                                        $condition_trouble_num ||
                                    $bornInfo_2past[1]->troubles >=
                                        $condition_trouble_num)) ||
                            $bornInfo_2past[0]->rotate_prediction <= 1.8
                        ) {
                            $extracts[] = $bornInfo_2past[0];
                            $extracts[] = $bornInfo_2past[1];
                        }
                        break;
                }
            }
        }
        // dd($extracts);

        foreach ($extracts as $extract) {
            // first_male_pigのsoftDelete対策
            if ($extract->first_male_id !== null) {
                $array = self::maleSoftDeleteResolution($extract->first_male_id);
                $exist_male = $array[0];
                $delete_male = $array[1];
                $extract->first_male = $exist_male;
                $extract->first_delete_male = $delete_male;
            } else {
                $extract->first_male = null;
                $extract->first_delete_male = null;
            }

            // second_male_pigのnullとsoftDelete対策
            if ($extract->second_male_id !== null) {
                $array = self::maleSoftDeleteResolution(
                    $extract->second_male_id
                );
                $exist_male = $array[0];
                $delete_male = $array[1];
                $extract->second_male = $exist_male;
                $extract->second_delete_male = $delete_male;
            } else {
                $extract->second_male = null;
                $extract->second_delete_male = null;
            }
        }

// dd($femalePigs);
        return view('extracts.index')->with(compact('extracts', 'conditions'));
    }

    public function conditions()
    {
        return view('extracts.conditions');
    }
}
