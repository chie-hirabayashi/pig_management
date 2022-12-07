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

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // male_pigのsoftDelete対策
    public function maleSoftDeleteResolution($id)
    {
        $judge = MalePig::where('id', $id)
            ->onlyTrashed()
            ->get();
        if ($judge->isNotEmpty()) {
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
            // $exist_female = FemalePig::find($id)->individual_num;
            $exist_female = FemalePig::find($id);
            $delete_female = null;
        }
        return [$exist_female, $delete_female];
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
        $born_last = MixInfo::where('female_id', $femalePig->id)
            ->whereNotNull('born_day')
            ->get()
            ->last();
        $carbon_now = Carbon::now();
        $carbon_last = Carbon::create($born_last->born_day);
        $rotate_prediction = 365 / $carbon_now->diffInDays($carbon_last);

        return round($rotate_prediction, 2);
    }
}
