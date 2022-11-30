<?php

namespace App\Http\Controllers;

use App\Models\BornInfo;
use Illuminate\Http\Request;
use App\Models\MixInfo;
use App\Models\FemalePig;

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
        $femalePigs = FemalePig::with('mix_infos')
                        ->with('born_infos')
                        ->where('deleted_at', null)
                        ->get();
        // dd($femalePigs);

        foreach ($femalePigs as $femalePig) {
            // 基本情報
            // $femalePig = $femalePigs[9];
            // $bornInfos = $femalePig->born_infos()->latest()->get()
            $bornInfos = $femalePig->born_infos()
                        ->orderBy('born_day', 'desc') //注意:->latet()ではNG
                        ->get()
                        ->load('mix_info')
                        ->load('female_pig')
                        ->load('first_male_pig')
                        ->load('second_male_pig');
            // $bornInfos = BornInfo::with('mix_info')
            //             ->with('female_pig')
            //             ->with('first_male_pig')
            //             ->with('second_male_pig')
            //             ->where('female_id', $femalePig->id)
            //             ->latest()
            //             ->get();
            // dd($bornInfos);
            // dd($bornInfos->first());

            // 再発、流産回数を取得
            // $troubleInfos = $femalePig->mix_infos->where('trouble_day', !null);
            // $count_troubles = count($troubleInfos);
            $count_troubles = $femalePig->mix_infos()->whereNotNull('trouble_day')->count();
            // dd($count_troubles);

            // 稼働中の全出産を取得
            // $mixInfos = $femalePig->mix_infos()->orderBy('id', 'desc')->get();
            // $bornInfos = self::getBornInfos($mixInfos);
            // $count_allBorn = count($bornInfos);
            $count_allBorn = $bornInfos->count();
            // dd($count_allBorn);

            // 全出産件数ごとに回転数を算出
            switch (true) {
                case $count_allBorn >= 3:
                    $bornInfo_3past = $bornInfos->take(3); //過去3回の出産情報
                    $rotates = self::getRotate($bornInfo_3past); //回転数算出
                    for ($i = 0; $i < 2; $i++) {
                        $bornInfo_3past[$i]['rotate'] = $rotates[$i];
                        $bornInfo_3past[$i]['troubles'] = $count_troubles;
                    }
                    $bornInfo_2past = $bornInfo_3past->take(2);
                    // 予測回転数
                    // $bornInfo_2past[0]['rotate_prediction'] = self::getPredictionRotate($femalePig);
                    $bornInfo_2past[0]['rotate_prediction'] = self::getnPredictionRotateFromBornInfo($bornInfos->first());
                    break;

                case $count_allBorn == 2:
                    $bornInfo_2past = $bornInfos; //過去2回の出産情報
                    $rotates = self::getRotate($bornInfo_2past); //回転数算出
                    $rotates[1] = 99;
                    for ($i = 0; $i < 2; $i++) {
                        $bornInfo_2past[$i]['rotate'] = $rotates[$i];
                        $bornInfo_2past[$i]['troubles'] = $count_troubles;
                    }

                    // 予測回転数
                    // $bornInfo_2past[0]['rotate_prediction'] = self::getPredictionRotate($femalePig);
                    $bornInfo_2past[0]['rotate_prediction'] = self::getnPredictionRotateFromBornInfo($bornInfos->first());
                    break;

                case $count_allBorn == 1:
                    $bornInfo_first = $bornInfos->first(); //過去1回の出産情報
                    // dd($bornInfo_first);
                    $bornInfo_second = new BornInfo();
                    $bornInfo_second->mix_id = $bornInfos->first()->mix_id;
                    $bornInfo_second->born_num = 99; // 抽出できない値をセット
                    $bornInfo_second->rotate = 99; // 抽出できない値をセット
                    $bornInfo_second->troubles = $count_troubles;
                    $bornInfo_second->female_num = $femalePig->individual_num;
                    $bornInfo_2past[0] = $bornInfo_first;
                    $bornInfo_2past[1] = $bornInfo_second;
                    // $bornInfo_2past[0]['rotate_prediction'] = self::getPredictionRotate($femalePig);
                    $bornInfo_2past[0]['rotate_prediction'] = self::getnPredictionRotateFromBornInfo($bornInfos->first());
                    break;
                
                case $count_allBorn == 0:
                    $bornInfo_pretend = new bornInfo();
                    $bornInfo_pretend->born_num = 99; // 抽出できない値をセット
                    $bornInfo_pretend->rotate = 99; // 抽出できない値をセット
                    $bornInfo_pretend->troubles = $count_troubles;
                    $bornInfo_2past[0] = $bornInfo_pretend;
                    $bornInfo_2past[1] = $bornInfo_pretend;
                    $bornInfo_2past[0]['rotate_prediction'] = 99;
                    break;
            }
// dd($bornInfo_2past);
            // 抽出条件に従い抽出
            // 直前のみで抽出
            if ($condition == 1) {
                if ((
                    $bornInfo_2past[0]->rotate <= $condition_first_rotate &&
                    $bornInfo_2past[0]->born_num <= $condition_first_num) ||
                    $bornInfo_2past[0]->rotate_prediction <= 1.8
                ) {
                    $extracts[] = $bornInfo_2past[0];
                }
            }
// dd($extracts);
            // 直前のみ、オプションありで抽出
            if ($condition == 2) {
                switch (true) {
                    // かつ
                    case $option_operator == 1:
                        if ((
                            $bornInfo_2past[0]->rotate <= $condition_first_rotate &&
                            $bornInfo_2past[0]->born_num <= $condition_first_num &&
                            $bornInfo_2past[0]->troubles >= $condition_trouble_num &&
                            $femalePig->age >= $condition_female_age ) ||
                            $bornInfo_2past[0]->rotate_prediction <= 1.8
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
                            $bornInfo_2past[0]->rotate_prediction <= 1.8
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
                            $femalePig->age >= $condition_female_age &&
                            $bornInfo_2past[0]->troubles >= $condition_trouble_num &&
                            $bornInfo_2past[1]->troubles >= $condition_trouble_num && (
                            $bornInfo_2past[0]->rotate <= $condition_first_rotate ||
                            $bornInfo_2past[0]->born_num <= $condition_first_num) && (
                            $bornInfo_2past[1]->rotate <= $condition_second_rotate ||
                            $bornInfo_2past[1]->born_num <= $condition_second_num) ||
                            $bornInfo_2past[0]->rotate_prediction <= 1.8
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
        foreach ($extracts as $info) {
            // first_male_pigのsoftDelete対策
            $array = self::maleSoftDeleteResolution($info->mix_info->first_male_id);
            $exist_male = $array[0];
            $delete_male = $array[1];
            $info->first_male = $exist_male;
            $info->first_delete_male = $delete_male;

            // second_male_pigのnullとsoftDelete対策
            if ($info->mix_info->second_male_id !== null) {
                $array = self::maleSoftDeleteResolution($info->mix_info->second_male_id);
                $exist_male = $array[0];
                $delete_male = $array[1];
                $info->second_male = $exist_male;
                $info->second_delete_male = $delete_male;
            } else {
                $info->second_male = null;
                $info->second_delete_male = null;
            }
        }

    // dd($extracts);
        return view('extracts.index')->with(compact('extracts', 'conditions'));
    }

    public function conditions()
    {
        return view('extracts.conditions');
    }

}
