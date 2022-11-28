<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MixInfo;
use App\Models\FemalePig;
use App\Models\MalePig;
use Carbon\Carbon;

class ExtractController extends Controller
{
    public function index(Request $request)
    {
        // 抽出に必要な要件
        // 過去２回の回転数
        // 過去２回の出産頭数
        // TODO:過去の再発回数、流産回数、年齢

        // 抽出方法変更
        // condition=1__直前で抽出(回転数または産子数:該当が多い、何を抽出したいか不明)
        // condition=2__直前、オプションありで抽出
        // condition=3__過去2回で抽出(回転数かつ産子数:該当が少なすぎて抽出できない)
        // condition=4__過去2回、オプションあり抽出

        // 仮条件
        // $female_id = 5;
        // $condition_rotate = 1.8;
        // $condition_num = 8;
        // $condition_recurrence = 1;

        // 本条件
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
        $femalePigs = FemalePig::where('deleted_at', null)->get();

        foreach ($femalePigs as $femalePig) {
            // 再発、流産回数を取得
            $troubleInfos = $femalePig->mix_infos->where('trouble_day', !null);
            $count_troubles = count($troubleInfos);

            // 稼働中の全出産を取得
            $bornInfo_all = MixInfo::where('female_id', $femalePig->id)
                ->orderBy('id', 'desc')
                ->whereNotNull('born_day')
                ->get();
            $count_bornInfo_all = count($bornInfo_all); // 出産件数カウント

            // 全出産件数ごとに回転数を算出
            switch (true) {
                case $count_bornInfo_all >= 3:
                    $bornInfo_3past = $bornInfo_all->take(3); //過去3回の出産情報
                    $rotates = self::getRotate($bornInfo_3past); //回転数算出
                    for ($i = 0; $i < 2; $i++) {
                        $bornInfo_3past[$i]['rotate'] = $rotates[$i];
                        $bornInfo_3past[$i]['troubles'] = $count_troubles;
                    }
                    $bornInfo_2past = $bornInfo_3past->take(2);

                    // 予測回転数
                    $bornInfo_2past[0]['rotate_prediction'] = self::getPredictionRotate($femalePig);
                    break;

                case $count_bornInfo_all == 2:
                    $bornInfo_2past = $bornInfo_all; //過去2回の出産情報
                    $rotates = self::getRotate($bornInfo_2past); //回転数算出
                    $rotates[1] = 99;
                    for ($i = 0; $i < 2; $i++) {
                        $bornInfo_2past[$i]['rotate'] = $rotates[$i];
                        $bornInfo_2past[$i]['troubles'] = $count_troubles;
                    }

                    // 予測回転数
                    $bornInfo_2past[0]['rotate_prediction'] = self::getPredictionRotate($femalePig);
                    // dd($bornInfo_2past);
                    break;

                case $count_bornInfo_all == 1:
                    $bornInfo_past = $bornInfo_all[0]; //過去1回の出産情報
                    $newBornInfo = new mixInfo();
                    $newBornInfo->female_id = $femalePig->id;
                    $newBornInfo->born_num = 99; // 抽出できない値をセット
                    $newBornInfo->rotate = 99; // 抽出できない値をセット
                    $newBornInfo->troubles = $count_troubles;
                    $bornInfo_2past[0] = $bornInfo_past;
                    $bornInfo_2past[1] = $newBornInfo;
                    // $bornInfo_2past[0]['troubles'] = $count_troubles;
                    // $bornInfo_2past[1]['troubles'] = $count_troubles;
                    // 予測回転数
                    $bornInfo_2past[0]['rotate_prediction'] = self::getPredictionRotate($femalePig);
                    // dd($bornInfo_2past);
                    break;
                
                case $count_bornInfo_all == 0:
                    $newBornInfo = new mixInfo();
                    $newBornInfo->female_id = $femalePig->id;
                    $newBornInfo->born_num = 99; // 抽出できない値をセット
                    $newBornInfo->rotate = 99; // 抽出できない値をセット
                    $newBornInfo->troubles = $count_troubles;
                    $bornInfo_2past[0] = $newBornInfo;
                    $bornInfo_2past[1] = $newBornInfo;
                    // $bornInfo_2past[0]['troubles'] = $count_troubles;
                    // $bornInfo_2past[1]['troubles'] = $count_troubles;
                    $bornInfo_2past[0]['rotate_prediction'] = 99;
                    break;
            }

            // 予測回転数算出
            // $bornInfo_last = MixInfo::where('female_id', $femalePig->id)
            //     ->whereNotNull('born_day')
            //     ->get()
            //     ->last();
            // dd($bornInfo_last);
            // $carbon_now = Carbon::now();
            // $carbon_last = Carbon::create($bornInfo_last->born_day);
            // $rotate_prediction = 365 / $carbon_now->diffInDays($carbon_last);
            // $bornInfo_2past[0]['rotate_prediction'] = $rotate_prediction;

            // 抽出条件に従い抽出
            // 直前のみで抽出
            if ($condition == 1) {
                if ((
                    $bornInfo_2past[0]->rotate <= $condition_first_rotate &&
                    $bornInfo_2past[0]->born_num <= $condition_first_num) ||
                    $bornInfo_2past[0]->rotate_prediction <= 1.5
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
                        if ((
                            $bornInfo_2past[0]->rotate <= $condition_first_rotate &&
                            $bornInfo_2past[0]->born_num <= $condition_first_num &&
                            $bornInfo_2past[0]->troubles >= $condition_trouble_num &&
                            $femalePig->age >= $condition_female_age ) ||
                            $bornInfo_2past[0]->rotate_prediction <= 1.5
                        ) {
                            $extracts[] = $bornInfo_2past[0];
                        }
                        break;

                    // または
                    case $option_operator == 2:
                        if (
                            $bornInfo_2past[0]->rotate <= $condition_first_rotate &&
                            $bornInfo_2past[0]->born_num <= $condition_first_num && (
                            $bornInfo_2past[0]->troubles >= $condition_trouble_num ||
                            $femalePig->age >= $condition_female_age ) ||
                            $bornInfo_2past[0]->rotate_prediction <= 1.5
                        ) {
                            $extracts[] = $bornInfo_2past[0];
                        }
                        break;
                }
            }

            // 過去2回で抽出
            if ($condition == 3) {
                if ((
                    $bornInfo_2past[0]->rotate <= $condition_first_rotate ||
                    $bornInfo_2past[0]->born_num <= $condition_first_num) && (
                    $bornInfo_2past[1]->rotate <= $condition_second_rotate ||
                    $bornInfo_2past[1]->born_num <= $condition_second_num) ||
                    $bornInfo_2past[0]->rotate_prediction <= 1.5
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
                            $femalePig->age >= $condition_female_age &&
                            $bornInfo_2past[0]->troubles >= $condition_trouble_num &&
                            $bornInfo_2past[1]->troubles >= $condition_trouble_num && (
                            $bornInfo_2past[0]->rotate <= $condition_first_rotate ||
                            $bornInfo_2past[0]->born_num <= $condition_first_num) && (
                            $bornInfo_2past[1]->rotate <= $condition_second_rotate ||
                            $bornInfo_2past[1]->born_num <= $condition_second_num) ||
                            $bornInfo_2past[0]->rotate_prediction <= 1.5
                        ) {
                            $extracts[] = $bornInfo_2past[0];
                            $extracts[] = $bornInfo_2past[1];
                        }
                        break;

                    // または
                    case $option_operator == 2:
                        if ((
                            $bornInfo_2past[0]->rotate <= $condition_first_rotate ||
                            $bornInfo_2past[0]->born_num <= $condition_first_num) && (
                            $bornInfo_2past[1]->rotate <= $condition_second_rotate ||
                            $bornInfo_2past[1]->born_num <= $condition_second_num) && (
                            $femalePig->age >= $condition_female_age ||
                            $bornInfo_2past[0]->troubles >= $condition_trouble_num || 
                            $bornInfo_2past[1]->troubles >= $condition_trouble_num) ||
                            $bornInfo_2past[0]->rotate_prediction <= 1.5
                        ) {
                            $extracts[] = $bornInfo_2past[0];
                            $extracts[] = $bornInfo_2past[1];
                        }
                        break;
                }
            }
        }
        // dd($extracts);

        foreach ($extracts as $info) {
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
        
        // self::OldmaleSoftDeleteResolution($extracts);
        // self::softDeleteResolution($extracts);

        return view('extracts.index')->with(compact('extracts', 'conditions'));
    }

    public function conditions()
    {
        return view('extracts.conditions');
    }

    // // 回転数算出
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

    // // 予測回転数算出
    // public function getPredictionRotate($femalePig)
    // {
    //         $bornInfo_last = MixInfo::where('female_id', $femalePig->id)
    //             ->whereNotNull('born_day')
    //             ->get()
    //             ->last();
    //         $carbon_now = Carbon::now();
    //         $carbon_last = Carbon::create($bornInfo_last->born_day);
    //         $rotate_prediction = 365 / $carbon_now->diffInDays($carbon_last);
            
    //         return round($rotate_prediction, 2);
    // }
}
