<?php

namespace App\Http\Controllers;

use App\Models\FemalePig;
use Illuminate\Http\Request;
use App\Models\MixInfo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AchievementController extends Controller
{
    public function index()
    {
        // 2020年に稼働した母豚を抽出
        $year = '2021';
        $begin_date = $year. '-01-01';
        $end_date = $year. '-12-31';
        // dd($end_date);

        // TODO:mix_dayのminとmaxからすべての年のデータを作成
        // viewで一覧表示

        // 稼働母豚
        $working_femalePigs = MixInfo::groupBy('female_id')
            ->where('mix_day', '>=', '2021-01-01')
            ->where('mix_day', '<=', '2021-12-31')
            ->get('female_id');
        $count_workingFemalePigs = count($working_femalePigs);

        // 交配回数
        $count_mixes = MixInfo::where('mix_day', '>=', '2020-01-01')
            ->where('mix_day', '<=', '2020-12-31')
            ->count();

        // 分娩腹数
        $count_borns = MixInfo::
            where('born_day', '>=', '2020-01-01')
            ->where('born_day', '<=', '2020-12-31')
            ->whereNotNull('born_day')
            ->count();

        // 開始子豚
        $bornPigs = MixInfo::
            where('born_day', '>=', '2020-01-01')
            ->where('born_day', '<=', '2020-12-31')
            ->whereNotNull('born_day')
            ->selectRaw('SUM(born_num) as sum_born_num')
            ->get();
        $count_bornPigs = $bornPigs->first()->sum_born_num;

        // 離乳子豚
        $weaningPigs = MixInfo::
            where('weaning_day', '>=', '2020-01-01')
            ->where('weaning_day', '<=', '2020-12-31')
            ->whereNotNull('weaning_day')
            ->selectRaw('SUM(weaning_num) as sum_weaning_num')
            ->get();
        $count_weaningPigs = $weaningPigs->first()->sum_weaning_num;


        // 現在、稼働中の母豚の整理
        // DO:年単位の成績 ex.2021年
        // DO:母豚の年齢単位の成績 ex.5歳
        // これには廃用個体が含まれない
        $existPigs = FemalePig::withCount([
            'mix_infos AS total_mix_count' => function ($query) {
                // $query->select(DB::raw('COUNT(*) as count_sum'));
                $query
                    ->where('mix_day', '>=', '2021-01-01')
                    ->where('mix_day', '<=', '2021-12-31');
            },
        ])->withCount([
            'mix_infos AS total_born_count' => function ($query) {
                $query->where('trouble_id', 1)
                    ->where('mix_day', '>=', '2021-01-01')
                    ->where('mix_day', '<=', '2021-12-31');
            },
        ])->withCount([
            'mix_infos AS total_childPigs' => function ($query) {
                // $query->select(DB::raw('SUM(born_num) as count_sum'));
                $query
                    ->where('mix_day', '>=', '2021-01-01')
                    ->where('mix_day', '<=', '2021-12-31')
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
        // dd($childCount_byAge_average);
        
        // 期間内に稼働中の母豚の整理
        // DO:期間 ex.2021年
        // DO:年齢で整理
        // これには廃用個体を含む
        // BUG:期間以降に導入された個体が含まれている
        $femalePigs = FemalePig::withTrashed()
            ->where('left_day', '>=', '2021-01-01')
            ->orWhere('add_day', '<=', '2021-12-31')
            ->whereNull('left_day')
            ->get();
            // foreach ($femalePigs as $femalePig) {
            //     if ($femalePig->add_day > '2021-12-31') {
            //         echo '<pre>';
            //         var_dump($femalePig->add_day);
            //         echo '</pre>';
            //     }
            // }
            // dd($femalePigs);

        // ->の順番重要
        $femalePigs = FemalePig::withTrashed()
            ->where('left_day', '>=', $begin_date)
            ->orWhere('add_day', '<=', $end_date)
            ->whereNull('left_day')
            ->withCount([
            'mix_infos AS total_mix_count' => function ($query) use($begin_date, $end_date){
                $query
                    ->where('mix_day', '>=', $begin_date)
                    ->where('mix_day', '<=', $end_date);
            },
        ])->withCount([
            'mix_infos AS total_born_count' => function ($query) use($begin_date, $end_date){
                $query->where('trouble_id', 1)
                    ->where('born_day', '>=', $begin_date)
                    ->where('born_day', '<=', $end_date);
            },
        ])->withCount([
            'mix_infos AS total_childPigs' => function ($query) use($begin_date, $end_date){
                $query
                    ->where('born_day', '>=', $begin_date)
                    ->where('born_day', '<=', $end_date)
                    ->select(DB::raw('SUM(born_num) as count_sum'));
            },
        ])
        ->get();
        $count_byAge = $femalePigs->groupBy('age')->map(function($age) { return $age->count();});
        $mixCount_byAge_total = $femalePigs->groupBy('age')->map(function($age) { return $age->sum('total_mix_count');});
        $mixCount_byAge_average = $femalePigs->groupBy('age')->map(function($age) { return $age->sum('total_mix_count')/$age->count();});
        $bornCount_byAge_total = $femalePigs->groupBy('age')->map(function($age) { return $age->sum('total_born_count');});
        $bornCount_byAge_average = $femalePigs->groupBy('age')->map(function($age) { return $age->sum('total_born_count')/$age->count();});
        $childCount_byAge_total = $femalePigs->groupBy('age')->map(function($age) { return $age->sum('total_childPigs');});
        $childCount_byAge_average = $femalePigs->groupBy('age')->map(function($age) { return $age->sum('total_childPigs')/$age->count();});
        dd($bornCount_byAge_average);

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
