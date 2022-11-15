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

        // 仮条件
        // $female_id = 5;
        // $criterion_rotate = 1.8;
        // $criterion_num = 8;

        // 本条件
        $condition_first_rotate  = $request->first_rotate; // 直前の回転数の抽出条件
        $condition_second_rotate = $request->second_rotate; // 前回の回転数の抽出条件
        $condition_first_num     = $request->first_born_num; // 直前の産子数の抽出条件
        $condition_second_num    = $request->second_born_num; // 前回の産子数の抽出条件
        $first_operator          = $request->first_operator; // 直前の回転数と産子数をつなぐ演算子
        $second_operator         = $request->second_operator; // 前回の回転数と産子数をつなぐ演算子
        $operator                = $request->operator; // 直前と前回をつなぐ演算子

        $extracts = [];
        $conditions['first_rotate']    = $condition_first_rotate;
        $conditions['second_rotate']   = $condition_second_rotate;
        $conditions['first_num']       = $condition_first_num;
        $conditions['second_num']      = $condition_second_num;
        $conditions['first_operator']  = $first_operator;
        $conditions['second_operator'] = $second_operator;
        $conditions['operator']        = $operator;

        // 稼働中のfemalePigs
        $femalePigs = FemalePig::where('deleted_at', null)->get();

        foreach ($femalePigs as $femalePig) {
            // 稼働中の全ての出産情報
            $bornInfo_all = MixInfo::where('female_id', $femalePig->id)
                ->orderBy('id', 'desc')
                ->whereNotNull('born_day')
                ->get();
            // 稼働中の全出産件数
            $count_bornInfo_all = count($bornInfo_all); // 出産件数カウント

            // 出産件数ごとに回転数を算出
            switch (true) {
                case $count_bornInfo_all >= 3:
                    $bornInfo_3past = $bornInfo_all->take(3); //過去3回の出産情報
                    $rotates = self::getRotate($bornInfo_3past); //回転数算出
                    for ($i = 0; $i < 2; $i++) {
                        $bornInfo_3past[$i]['rotate'] = $rotates[$i];
                    }
                    $bornInfo_2past = $bornInfo_3past->take(2);
                    break;

                case $count_bornInfo_all == 2:
                    $bornInfo_2past = $bornInfo_all; //過去2回の出産情報
                    $rotates = self::getRotate($bornInfo_2past); //回転数算出
                    $rotates[1] = 99;
                    for ($i = 0; $i < 2; $i++) {
                        $bornInfo_2past[$i]['rotate'] = $rotates[$i];
                    }
                    break;

                case $count_bornInfo_all < 2:
                    $newBornInfo = new mixInfo();
                    $newBornInfo->female_id = $femalePig->id;
                    $newBornInfo->born_num = 99; // 抽出できない値をセット
                    $newBornInfo->rotate = 99; // 抽出できない値をセット
                    $bornInfo_2past[0] = $newBornInfo;
                    $bornInfo_2past[1] = $newBornInfo;
            }

            // 仮設定による抽出
            // foreach ($bornInfo_2past as $bornInfo) {
            //     if ($bornInfo->rotate < $criterion_rotate ||
            //         $bornInfo->born_num < $criterion_num) {
            //         $extracts[] = $bornInfo;
            //     }
            // }

            // 本設定による抽出
            switch (true) {
                // かつ,かつ
                case $first_operator == 1 && $operator == 1:
                    if (
                        $bornInfo_2past[0]->rotate <= $condition_first_rotate &&
                        $bornInfo_2past[0]->born_num <= $condition_first_num &&
                        $bornInfo_2past[1]->rotate <= $condition_second_rotate &&
                        $bornInfo_2past[1]->born_num <= $condition_second_num
                    ) {
                        $extracts[] = $bornInfo_2past[0];
                        $extracts[] = $bornInfo_2past[1];
                    }
                    break;

                // かつ,または
                case $first_operator == 1 && $operator == 2:
                    if (
                        $bornInfo_2past[0]->rotate <= $condition_first_rotate &&
                        $bornInfo_2past[0]->born_num <= $condition_first_num
                    ) {
                        $extracts[] = $bornInfo_2past[0];
                    }
                    if (
                        $bornInfo_2past[1]->rotate <= $condition_second_rotate &&
                        $bornInfo_2past[1]->born_num <= $condition_second_num
                    ) {
                        $extracts[] = $bornInfo_2past[1];
                    }
                    break;

                // または,かつ
                case $first_operator == 2 && $operator == 1:
                    if (
                        ($bornInfo_2past[0]->rotate < $condition_first_rotate ||
                            $bornInfo_2past[0]->born_num < $condition_first_num) &&
                        ($bornInfo_2past[1]->rotate < $condition_second_rotate ||
                            $bornInfo_2past[1]->born_num < $condition_second_num)
                    ) {
                        $extracts[] = $bornInfo_2past[0];
                        $extracts[] = $bornInfo_2past[1];
                    }
                    break;

                // または,または
                case $first_operator == 2 && $operator == 2:
                    if (
                        $bornInfo_2past[0]->rotate < $condition_first_rotate ||
                        $bornInfo_2past[0]->born_num < $condition_first_num ||
                        $bornInfo_2past[1]->rotate < $condition_second_rotate ||
                        $bornInfo_2past[1]->born_num < $condition_second_num
                    ) {
                        $extracts[] = $bornInfo_2past[0];
                        $extracts[] = $bornInfo_2past[1];
                    }
                    break;
            }
        }

        self::softDeleteResolution($extracts);

        return view('extracts.index')->with(compact('extracts', 'conditions'));
    }

    public function conditions()
    {
        return view('extracts.conditions');
    }

    // 回転数算出function
    public function getRotate($bornInfos)
    {
        $array = [];
        $count = count($bornInfos);
        for ($i = 0; $i < $count - 1; $i++) {
            $carbon_1 = Carbon::create($bornInfos[$i]->born_day);
            $carbon_2 = Carbon::create($bornInfos[$i + 1]->born_day);
            $rotate = 365 / $carbon_1->diffInDays($carbon_2);
            // born_infosにrotateを追加
            $array[$i] = round($rotate, 2);
        }
        return $array;
    }

    // first_male_pigとsecond_male_pigの
    // softDeleteとnull対策function
    public function softDeleteResolution($mixInfos)
    {
        foreach ($mixInfos as $mixInfo) {
            // first_male_pigのsoftDelete対策
            $judge_1 = MalePig::where('id', $mixInfo->first_male_id)
                ->onlyTrashed()
                ->get();
            if (!$judge_1->isEmpty()) {
                $deletePig_1 = $judge_1[0]->individual_num;
                $mixInfo->first_delete_male = $deletePig_1;
                $mixInfo->first_male = null;
            } else {
                $mixInfo->first_delete_male = null;
                $mixInfo->first_male = $mixInfo->first_male_pig->individual_num;
            }

            // second_male_pigのnullとsoftDelete対策
            if ($mixInfo->second_male_id !== null) {
                $judge_2 = MalePig::where('id', $mixInfo->second_male_id)
                    ->onlyTrashed()
                    ->get();
                if (!$judge_2->isEmpty()) {
                    $deletePig_2 = $judge_2[0]->individual_num;
                    $mixInfo->second_delete_male = $deletePig_2;
                    $mixInfo->second_male = null;
                } else {
                    $mixInfo->second_delete_male = null;
                    $mixInfo->second_male =
                        $mixInfo->second_male_pig->individual_num;
                }
            } else {
                $mixInfo->second_delete_male = null;
                $mixInfo->second_male = null;
            }
        }
        return $mixInfos;
    }
}
