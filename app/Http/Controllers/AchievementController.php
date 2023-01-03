<?php

namespace App\Http\Controllers;

use App\Models\FemalePig;
use Illuminate\Http\Request;
use App\Models\MixInfo;
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
        $first_mix_day = MixInfo::orderBy('mix_day')
            ->first('mix_day');
        $last_mix_day = MixInfo::orderBy('mix_day', 'desc')
            ->first('mix_day');
        // first_mix_dayにcarbonで1年加算、last_mix_dayを超えたら終わり
        $carbon = new Carbon($first_mix_day->mix_day);
        $year = substr($carbon->toDateString(), 0, 4);
        $years = array($year);
        while ($year <= substr($last_mix_day->mix_day, 0, 4)) {
            $year = $carbon->addYear(1);
            $years[] = substr($year->toDateString(), 0, 4);
        }

        // 入れ物用意
        $achievements = [];
        foreach ($years as $year) {
            // 日付
            $begin_date = $year. '-01-01';
            $end_date = $year. '-12-31';
            // 稼働母豚
            $working_femalePigs = MixInfo::groupBy('female_id')
                ->where('mix_day', '>=', $begin_date)
                ->where('mix_day', '<=', $end_date)
                ->get('female_id');
            $count_workingFemalePigs = count($working_femalePigs);

            // 交配回数
            $count_mixes = MixInfo::where('mix_day', '>=', $begin_date)
                ->where('mix_day', '<=', $end_date)
                ->count();
    
            // 分娩腹数
            $count_borns = MixInfo::
                where('born_day', '>=', $begin_date)
                ->where('born_day', '<=', $end_date)
                ->whereNotNull('born_day')
                ->count();
    
            // 開始子豚
            $bornPigs = MixInfo::
                where('born_day', '>=', $begin_date)
                ->where('born_day', '<=', $end_date)
                ->whereNotNull('born_day')
                ->selectRaw('SUM(born_num) as sum_born_num')
                ->get();
            $count_bornPigs = $bornPigs->first()->sum_born_num;
    
            // 離乳子豚
            $weaningPigs = MixInfo::
                where('weaning_day', '>=', $begin_date)
                ->where('weaning_day', '<=', $end_date)
                ->whereNotNull('weaning_day')
                ->selectRaw('SUM(weaning_num) as sum_weaning_num')
                ->get();
            $count_weaningPigs = $weaningPigs->first()->sum_weaning_num;

            // 交配成功率
            $success_mix = round($count_borns / $count_mixes, 2);
            // 一腹産数
            if ($count_borns !== 0) {
                $bornPigs_by_borns = round($count_bornPigs / $count_borns, 2);
            } else {
                $bornPigs_by_borns = 0;
            }
            // 産子数
            $rotates = round($count_borns / $count_workingFemalePigs, 2);
// dd($count_borns);
            $achievements[] = (array(
                'year' => $year,
                'count_workingPigs' => $count_workingFemalePigs,
                'count_mixes' => $count_mixes,
                'count_borns' => $count_borns,
                'count_bornPigs' => $count_bornPigs,
                'count_weaningPigs' => $count_weaningPigs,
                'success_mix' => $success_mix,
                'bornPigs_by_borns' => $bornPigs_by_borns,
                'rotates' => $rotates,
                ));
        }
        // dd($achievements);

        return view('achievements.index')->with(
            compact(
                'achievements'
            )
        );
    }

    public function show(Request $request)
    {
        // 2020年に稼働した母豚を抽出
        // $year = '2021';
        $year = $request->year;
        $begin_date = $year. '-01-01';
        $end_date = $year. '-12-31';

        // 期間内に稼働中の母豚の整理
        // DO:期間 ex.2021年
        // DO:年齢で整理
        // これには廃用個体を含む
        // BUG:期間以降に導入された個体が含まれている
        // $femalePigs = FemalePig::withTrashed()
        //     ->where('add_day', '<=', $end_date)
        //     ->orWhere('left_day', '>=', $begin_date)
        //     ->whereNull('left_day')
        //     ->get();

        // ->の順番重要
        $femalePigs = FemalePig::withTrashed()
            ->where('add_day', '<=', $end_date)
            ->orWhere('left_day', '>=', $begin_date)
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
            'mix_infos AS total_bornPigs' => function ($query) use($begin_date, $end_date){
                $query
                    ->where('born_day', '>=', $begin_date)
                    ->where('born_day', '<=', $end_date)
                    ->select(DB::raw('SUM(born_num) as count_sum'));
            },
        ])->withCount([
            'mix_infos AS total_weaningPigs' => function ($query) use($begin_date, $end_date){
                $query
                    ->where('weaning_day', '>=', $begin_date)
                    ->where('weaning_day', '<=', $end_date)
                    ->select(DB::raw('SUM(weaning_num) as count_sum'));
            },
        ])
        ->get();

        // dd($femalePigs[8]);
        // 当時の年齢を算出するためにyearセット
        foreach ($femalePigs as $femalePig) {
            $femalePig->year = $year;
        }
        // dd($femalePigs);
        $count_workingPigs_byAge = $femalePigs->sortBy('age_in_those_days')->groupBy('age_in_those_days')->map(function($age) { return $age->count();});
        $count_mixes_byAge_total = $femalePigs->sortBy('age_in_those_days')->groupBy('age_in_those_days')->map(function($age) { return $age->sum('total_mix_count');});
        $count_borns_byAge_total = $femalePigs->sortBy('age_in_those_days')->groupBy('age_in_those_days')->map(function($age) { return $age->sum('total_born_count');});
        $count_bornPigs_byAge_total = $femalePigs->sortBy('age_in_those_days')->groupBy('age_in_those_days')->map(function($age) { return $age->sum('total_bornPigs');});
        $count_weaningPigs_byAge_total = $femalePigs->sortBy('age_in_those_days')->groupBy('age_in_those_days')->map(function($age) { return $age->sum('total_weaningPigs');});
        // $count_mixes_byAge_average = $femalePigs->groupBy('age_in_those_days')->map(function($age) { return $age->sum('total_mix_count')/$age->count();});
        // $count_borns_byAge_average = $femalePigs->groupBy('age_in_those_days')->map(function($age) { return $age->sum('total_born_count')/$age->count();});
        // $count_bornPigs_byAge_average = $femalePigs->groupBy('age_in_those_days')->map(function($age) { return $age->sum('total_bornPigs')/$age->count();});
        // dd($count_workingPigs_byAge);
        foreach ($count_workingPigs_byAge as $key => $value) {
            $achievements[$key] = array('age' => $key);
        }
        foreach ($count_workingPigs_byAge as $key => $value) {
            $achievements[$key]['count_workingPigs'] = $value;
        }
        foreach ($count_mixes_byAge_total as $key => $value) {
            $achievements[$key]['count_mixes_byAge_total'] = $value;
        }
        foreach ($count_borns_byAge_total as $key => $value) {
            $achievements[$key]['count_borns_byAge_total'] = $value;
        }
        foreach ($count_bornPigs_byAge_total as $key => $value) {
            $achievements[$key]['count_bornPigs_byAge_total'] = $value;
        }
        foreach ($count_weaningPigs_byAge_total as $key => $value) {
            $achievements[$key]['count_weaningPigs_byAge_total'] = $value;
        }
        // dd($achievements);
        // $achievement = (array(
        //     'count_workingPigs' => $count_workingPigs_byAge,
        //     'count_mixes' => $count_mixes_byAge_total,
        //     'count_borns' => $count_borns_byAge_total,
        //     'count_bornPigs' => $count_bornPigs_byAge_total,
        //     'count_weaningPigs' => $count_weaningPigs_byAge_total,
        //     // 'success_mix' => $success_mix,
        //     // 'bornPigs_by_borns' => $bornPigs_by_borns,
        //     // 'rotates' => $rotates,
        //     ));
        return view('achievements.show')->with(compact('achievements', 'femalePigs'));

        // 現在、稼働中の母豚の整理
        // DO:年単位の成績 ex.2021年
        // DO:母豚の年齢単位の成績 ex.5歳
        // これには廃用個体が含まれない
        $existPigs = FemalePig::withCount([
            'mix_infos AS total_mix_count' => function ($query) use($begin_date, $end_date) {
                // $query->select(DB::raw('COUNT(*) as count_sum'));
                $query
                    ->where('mix_day', '>=', $begin_date)
                    ->where('mix_day', '<=', $end_date);
            },
        ])->withCount([
            'mix_infos AS total_born_count' => function ($query) use($begin_date, $end_date) {
                $query->where('trouble_id', 1)
                    ->where('mix_day', '>=', $begin_date)
                    ->where('mix_day', '<=', $end_date);
            },
        ])->withCount([
            'mix_infos AS total_childPigs' => function ($query) use($begin_date, $end_date) {
                // $query->select(DB::raw('SUM(born_num) as count_sum'));
                $query
                    ->where('mix_day', '>=', $begin_date)
                    ->where('mix_day', '<=', $end_date)
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
        
    }
}
