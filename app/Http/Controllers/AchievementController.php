<?php

namespace App\Http\Controllers;

use App\Models\FemalePig;
use Illuminate\Http\Request;
use App\Models\MixInfo;
use Illuminate\Support\Facades\DB;

class AchievementController extends Controller
{
    public function index()
    {
        // 2020年に稼働した母豚を抽出
        $date = date('2020');

        // mix_dayのminとmaxからすべての年のデータを作成

        // 稼働母豚
        $working_femalePigs = MixInfo::groupBy('female_id')
            ->where('mix_day', '<=', '2021-12-31')
            ->where('mix_day', '>=', '2021-01-01')
            ->get('female_id');
        $count_workingFemalePigs = count($working_femalePigs);

        // 現在、稼働中の母豚の整理
        // TODO:2021年の成績に修正
        $existPigs = FemalePig::withCount([
            'mix_infos AS total_mix_count' => function ($query) {
                // $query->select(DB::raw('COUNT(*) as count_sum'));
                $query->where('mix_day', '<=', '2021-12-31')
                    ->where('mix_day', '>=', '2021-01-01');
            },
        ])->withCount([
            'mix_infos AS total_born_count' => function ($query) {
                $query->where('trouble_id', 1)
                    ->where('mix_day', '<=', '2021-12-31')
                    ->where('mix_day', '>=', '2021-01-01');
            },
        ])->withCount([
            'mix_infos AS total_childPig' => function ($query) {
                // $query->select(DB::raw('SUM(born_num) as count_sum'));
                $query->where('mix_day', '<=', '2021-12-31')
                    ->where('mix_day', '>=', '2021-01-01')
                    ->select(DB::raw('SUM(born_num) as count_sum'));
            },
        ])
        ->get();
        // dd($existPigs);

        // 交配回数
        $count_mixes = MixInfo::where('mix_day', '<=', '2020-12-31')
            ->where('mix_day', '>=', '2020-01-01')
            ->count();

        // 分娩腹数
        $count_borns = MixInfo::where('born_day', '<=', '2020-12-31')
            ->where('born_day', '>=', '2020-01-01')
            ->whereNotNull('born_day')
            ->count();

        // 開始子豚
        $bornPigs = MixInfo::where('born_day', '<=', '2020-12-31')
            ->where('born_day', '>=', '2020-01-01')
            ->whereNotNull('born_day')
            ->selectRaw('SUM(born_num) as sum_born_num')
            ->get();
        $count_bornPigs = $bornPigs->first()->sum_born_num;

        // 離乳子豚
        $weaningPigs = MixInfo::where('weaning_day', '<=', '2020-12-31')
            ->where('weaning_day', '>=', '2020-01-01')
            ->whereNotNull('weaning_day')
            ->selectRaw('SUM(weaning_num) as sum_weaning_num')
            ->get();
        $count_weaningPigs = $weaningPigs->first()->sum_weaning_num;

        return view('achievements.index')->with(
            compact(
                'count_workingFemalePigs',
                'count_mixes',
                'count_borns',
                'count_bornPigs',
                'count_weaningPigs'
            )
        );
    }
}
