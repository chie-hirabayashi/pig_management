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

        // TODO:mix_dayのminとmaxからすべての年のデータを作成
        // viewで一覧表示

        // 稼働母豚
        $working_femalePigs = MixInfo::groupBy('female_id')
            ->where('mix_day', '<=', '2021-12-31')
            ->where('mix_day', '>=', '2021-01-01')
            ->get('female_id');
        $count_workingFemalePigs = count($working_femalePigs);

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


        // 現在、稼働中の母豚の整理
        // DO:年単位の成績 ex.2021年
        // TODO:母豚の年齢単位の成績 ex.5歳
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
            'mix_infos AS total_childPigs' => function ($query) {
                // $query->select(DB::raw('SUM(born_num) as count_sum'));
                $query->where('mix_day', '<=', '2021-12-31')
                    ->where('mix_day', '>=', '2021-01-01')
                    ->select(DB::raw('SUM(born_num) as count_sum'));
            },
        ])
        ->get();
        $test = $existPigs->groupBy('age');
        $count_byAge = $existPigs->groupBy('age')->map(function($age) { return $age->count();});
        $mixCount_byAge_total = $existPigs->groupBy('age')->map(function($age) { return $age->sum('total_mix_count');});
        $mixCount_byAge_average = $existPigs->groupBy('age')->map(function($age) { return $age->sum('total_mix_count')/$age->count();});
        $bornCount_byAge_total = $existPigs->groupBy('age')->map(function($age) { return $age->sum('total_born_count');});
        $bornCount_byAge_average = $existPigs->groupBy('age')->map(function($age) { return $age->sum('total_born_count')/$age->count();});
        $childCount_byAge_total = $existPigs->groupBy('age')->map(function($age) { return $age->sum('total_childPigs');});
        $childCount_byAge_average = $existPigs->groupBy('age')->map(function($age) { return $age->sum('total_childPigs')/$age->count();});
        // $existPigsにageキー追加
        // foreach ($existPigs as $existPig) {
        //     $existPig->age = $existPig->age;
        // }
        dd($childCount_byAge_average);
        // 検算用:合計交配回数
        

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
