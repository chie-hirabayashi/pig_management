<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\FemalePig;
use App\Models\MalePig;
use App\Models\MixInfo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // male_pigのsoftDeleteとnull対策
    // public function OldmaleSoftDeleteResolution($mixInfos)
    // {
    //     foreach ($mixInfos as $mixInfo) {
    //         // first_male_pigのsoftDelete対策
    //         $judge = MalePig::where('id', $mixInfo->first_male_id)
    //             ->onlyTrashed()
    //             ->get();
    //         if ($judge->isnotEmpty()) {
    //             $deletePig = $judge[0]->individual_num;
    //             $mixInfo->first_delete_male = $deletePig;
    //             $mixInfo->first_male = null;
    //         } else {
    //             $mixInfo->first_delete_male = null;
    //             $mixInfo->first_male = $mixInfo->first_male_pig->individual_num;
    //         }
    //         // second_male_pigのnullとsoftDelete対策
    //         if ($mixInfo->second_male_id !== null) {
    //             $judge = MalePig::where('id', $mixInfo->second_male_id)
    //                 ->onlyTrashed()
    //                 ->get();
    //             if ($judge->isnotEmpty()) {
    //                 $deletePig = $judge[0]->individual_num;
    //                 $mixInfo->second_delete_male = $deletePig;
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

    // male_pigのsoftDelete対策
    public function maleSoftDeleteResolution($id)
    {
        $judge = MalePig::where('id', $id)
            ->onlyTrashed()
            ->get();
        if ($judge->isnotEmpty()) {
            $exist_male = null;
            $delete_male = $judge[0]->individual_num;
        } else {
            $exist_male = MalePig::find($id)->individual_num;
            $delete_male = null;
        }
        return [$exist_male, $delete_male];
    }

    // female_pigのsoftDelete対策
    public function femaleSoftDeleteResolution($id)
    {
        $judge = FemalePig::where('id', $id)
            ->onlyTrashed()
            ->get();
        if ($judge->isnotEmpty()) {
            $exist_female = null;
            $delete_female = $judge[0]->individual_num;
        } else {
            $exist_female = FemalePig::find($id)->individual_num;
            $delete_female = null;
        }
        return array($exist_female, $delete_female);
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

    // 予測回転数算出
    public function getPredictionRotate($femalePig)
    {
            $bornInfo_last = MixInfo::where('female_id', $femalePig->id)
                ->whereNotNull('born_day')
                ->get()
                ->last();
            
            $carbon_now = Carbon::now();
            $carbon_last = Carbon::create($bornInfo_last->born_day);
            $rotate_prediction = 365 / $carbon_now->diffInDays($carbon_last);
            
            return round($rotate_prediction, 2);
    }

    // 予測回転数算出
    public function getNewPredictionRotate($femalePig)
    {
            $mixInfos = $femalePig->mix_infos;
            // dd($mixInfos);
            $bornInfo_last = self::getBornInfos($mixInfos)->last();
            // $mixInfo = $femalePig->mix_infos->where('trouble_id', '==', 1)->last();
            // これだと妊娠中の$mixInfoを拾ってしまう
            // $bornInfo_last = $mixInfo->born_info;

            $carbon_now = Carbon::now();
            $carbon_last = Carbon::create($bornInfo_last->born_day);
            // dd($carbon_last);
            $rotate_prediction = 365 / $carbon_now->diffInDays($carbon_last);
            
            return round($rotate_prediction, 2);
    }

    public function getBornInfos($mixInfos)
    {
        // 出産情報の入れ物作成
        $bornInfos = new Collection();

        // 全出産情報取得
        foreach ($mixInfos as $mixInfo) {
            $bornInfo = $mixInfo->born_info()->get()->load('mix_info');
            if (!empty($bornInfo[0])) {
                $bornInfos->add($bornInfo[0]);
            }
        }
        return $bornInfos;
    }
}
