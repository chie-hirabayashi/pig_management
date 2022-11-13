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
        // TODO:過去の再発、流産、年齢

        // 仮設定
        // $female_id = 5;
        // $criterion_rotate = 1.8;
        // $criterion_num = 8;

        // 本設定(1:かつ、2:または)
        $condition_first_rotate = $request->first_rotate;
        $condition_second_rotate = $request->second_rotate;
        $condition_first_num = $request->first_born_num;
        $condition_second_num = $request->second_born_num;
        $first_operator = $request->first_operator;
        $second_operator = $request->second_operator;
        $operator = $request->operator;

        $extracts = [];
        $conditions['first_rotate'] = $condition_first_rotate;
        $conditions['second_rotate'] = $condition_second_rotate;
        $conditions['first_num'] = $condition_first_num;
        $conditions['second_num'] = $condition_second_num;
        $conditions['first_operator'] = $first_operator;
        $conditions['second_operator'] = $second_operator;
        $conditions['operator'] = $operator;
        // var_dump($first_operator);
        // var_dump($second_operator);
        // dd($conditions);
        // 稼働中のfemalePig取得
        $femalePigs = FemalePig::where('deleted_at', null)->get();

        foreach ($femalePigs as $femalePig) {
            // 並べ替えて全出産情報取得
            $bornInfo_all = MixInfo::where('female_id', $femalePig->id)
                ->orderBy('id', 'desc')
                ->whereNotNull('born_day')
                ->get();
            $validity_count = count($bornInfo_all); // 出産件数カウント

            // 出産件数によって処理を分岐
            // 回転数算出
            switch (true) {
                case $validity_count >= 3:
                    $bornInfo_past2 = $bornInfo_all->take(3); //過去3回の出産情報
                    $rotates = self::getRotate($bornInfo_past2); //回転数算出
                    for ($i = 0; $i < 2; $i++) {
                        $bornInfo_past2[$i]['rotate'] = $rotates[$i];
                    }
                    $bornInfo_past2 = $bornInfo_past2->take(2);
                    break;

                case $validity_count === 2:
                    $bornInfo_past2 = $bornInfo_all->take($validity_count); //過去1~2回の出産情報
                    $rotates = self::getRotate($bornInfo_past2); //回転数算出
                    $rotates[1] = 99;
                    for ($i = 0; $i < 2; $i++) {
                        $bornInfo_past2[$i]['rotate'] = $rotates[$i];
                    }
                    break;

                case $validity_count < 2:
                    $newBornInfo = new mixInfo();
                    $newBornInfo->female_id = $femalePig->id;
                    $newBornInfo->born_num = 99; //出産なし
                    $newBornInfo->rotate = 99; //出産情報なし
                    $bornInfo_past2[0] = $newBornInfo;
                    $bornInfo_past2[1] = $newBornInfo;
            }

            // 仮設定による抽出
            // foreach ($bornInfo_past2 as $bornInfo) {
            //     if ($bornInfo->rotate < $criterion_rotate ||
            //         $bornInfo->born_num < $criterion_num) {
            //         $extracts[] = $bornInfo;
            //     }
            // }

            // 本設定による抽出
            switch (true) {
                case $first_operator == 1 && $operator == 1:
                    // かつ,かつ,かつ
                    if (
                        $bornInfo_past2[0]->rotate <= $condition_first_rotate &&
                        $bornInfo_past2[0]->born_num <= $condition_first_num &&
                        $bornInfo_past2[1]->rotate <=
                            $condition_second_rotate &&
                        $bornInfo_past2[1]->born_num <= $condition_second_num
                    ) {
                        $extracts[] = $bornInfo_past2[0];
                        $extracts[] = $bornInfo_past2[1];
                    }
                    break;

                case $first_operator == 1 && $operator == 2:
                    // かつ,または,かつ
                    if (
                        $bornInfo_past2[0]->rotate <= $condition_first_rotate &&
                        $bornInfo_past2[1]->rotate <= $condition_second_rotate
                    ) {
                        $extracts[] = $bornInfo_past2[0];
                        $extracts[] = $bornInfo_past2[1];
                    }
                    if (
                        $bornInfo_past2[0]->born_num <= $condition_first_num &&
                        $bornInfo_past2[1]->born_num <= $condition_second_num
                    ) {
                        $extracts[] = $bornInfo_past2[0];
                        $extracts[] = $bornInfo_past2[1];
                    }
                    break;

                case $first_operator == 2 && $operator == 1:
                    // または,かつ,または
                    if (
                        ($bornInfo_past2[0]->rotate < $condition_first_rotate ||
                            $bornInfo_past2[0]->born_num <
                                $condition_first_num) &&
                        ($bornInfo_past2[1]->rotate <
                            $condition_second_rotate ||
                            $bornInfo_past2[1]->born_num <
                                $condition_second_num)
                    ) {
                        $extracts[] = $bornInfo_past2[0];
                        $extracts[] = $bornInfo_past2[1];
                    }
                    break;

                case $first_operator == 2 && $operator == 2:
                    // または,または,または
                    if (
                        $bornInfo_past2[0]->rotate < $condition_first_rotate ||
                        $bornInfo_past2[0]->born_num < $condition_first_num
                    ) {
                        $extracts[] = $bornInfo_past2[0];
                    }
                    if (
                        $bornInfo_past2[1]->rotate < $condition_second_rotate ||
                        $bornInfo_past2[1]->born_num < $condition_second_num
                    ) {
                        $extracts[] = $bornInfo_past2[1];
                    }
                    break;
            }
        }

        // // かつ,かつ,または
        // if ($bornInfo_past2[0]->rotate <= $condition_first_rotate &&
        //     $bornInfo_past2[1]->rotate <= $condition_second_rotate &&
        //     ($bornInfo_past2[0]->born_num <= $condition_first_num ||
        //     $bornInfo_past2[1]->born_num <= $condition_second_num) ) {
        //     $extracts[] = $bornInfo_past2[0];
        //     $extracts[] = $bornInfo_past2[1];
        // }

        // // かつ,または,または
        // if ($bornInfo_past2[0]->rotate <= $condition_first_rotate &&
        //     $bornInfo_past2[1]->rotate <= $condition_second_rotate) {
        //     $extracts[] = $bornInfo_past2[0];
        //     $extracts[] = $bornInfo_past2[1];
        // }
        // if ($bornInfo_past2[0]->born_num <= $condition_first_num ||
        //     $bornInfo_past2[1]->born_num <= $condition_second_num ) {
        //     $extracts[] = $bornInfo_past2[0];
        //     $extracts[] = $bornInfo_past2[1];
        // }

        // // または,または,かつ
        // if ($bornInfo_past2[0]->rotate <= $condition_first_rotate ||
        //     $bornInfo_past2[1]->rotate <= $condition_second_rotate) {
        //     $extracts[] = $bornInfo_past2[0];
        //     $extracts[] = $bornInfo_past2[1];
        // }
        // if ($bornInfo_past2[0]->born_num <= $condition_first_num &&
        //     $bornInfo_past2[1]->born_num <= $condition_second_num ) {
        //     $extracts[] = $bornInfo_past2[0];
        //     $extracts[] = $bornInfo_past2[1];
        // }

        self::softDeleteResolution($extracts);
        // dd($extracts);
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
