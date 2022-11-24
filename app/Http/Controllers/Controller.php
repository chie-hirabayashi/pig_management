<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\MalePig;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // male_pigのsoftDeleteとnull対策
    public function maleSoftDeleteResolution($mixInfo)
    {
        // first_male_pigのsoftDelete対策
        $judge = MalePig::where('id', $mixInfo->first_male_id)
            ->onlyTrashed()
            ->get();
        if ($judge->isnotEmpty()) {
            $deletePig = $judge[0]->individual_num;
            $mixInfo->first_delete_male = $deletePig;
            $mixInfo->first_male = null;
        } else {
            $mixInfo->first_delete_male = null;
            $mixInfo->first_male = $mixInfo->first_male_pig->individual_num;
        }
        // second_male_pigのnullとsoftDelete対策
        if ($mixInfo->second_male_id !== null) {
            $judge = MalePig::where('id', $mixInfo->second_male_id)
                ->onlyTrashed()
                ->get();
            if ($judge->isnotEmpty()) {
                $deletePig = $judge[0]->individual_num;
                $mixInfo->second_delete_male = $deletePig;
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
        return $mixInfo;
    }
}
