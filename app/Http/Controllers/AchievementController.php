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
        // mix_dayの年を配列に整理
        $first_mix_day = MixInfo::orderBy('mix_day')->first('mix_day'); # object['mix_day' => '2018-08-01']
        $last_mix_day = MixInfo::orderBy('mix_day', 'desc')->first('mix_day'); # object['mix_day' => '2022-12-27']
        $carbon = new Carbon($first_mix_day->mix_day); # date: 2018-08-01 00:00:00.0 Asia/Tokyo (+09:00)
        $year = substr($carbon->toDateString(), 0, 4); # "2018"
        $years = [$year];
        while ($year <= substr($last_mix_day->mix_day, 0, 4)) {
            $year = $carbon->addYear(1);
            $years[] = substr($year->toDateString(), 0, 4);
        } # $years = ['2018', '2019', '2020', ...]
        // 箱用意
        $achievements = [];
        foreach ($years as $year) {
            // $year = '2019';
            // 日付
            $begin_date = $year . '-01-01';
            $end_date = $year . '-12-31';

            // 稼働母豚
            $working_femalePigs = MixInfo::groupBy('female_id')
                ->where([
                    ['mix_day', '>=', $begin_date],
                    ['mix_day', '<=', $end_date],
                ])
                // ->where('mix_day', '>=', $begin_date)
                // ->where('mix_day', '<=', $end_date)
                ->get('female_id');
            $count_workingFemalePigs = count($working_femalePigs);

            // 交配回数
            $count_mixes = MixInfo::where([
                ['mix_day', '>=', $begin_date],
                ['mix_day', '<=', $end_date],
                ])
                // $count_mixes = MixInfo::where('mix_day', '>=', $begin_date)
                // ->where('mix_day', '<=', $end_date)
                ->count();

            // 分娩腹数
            // $count_borns = MixInfo::where('born_day', '>=', $begin_date)
            //     ->where('born_day', '<=', $end_date)
            $count_borns = MixInfo::where([
                ['born_day', '>=', $begin_date],
                ['born_day', '<=', $end_date],
                ])
                ->whereNotNull('born_day')
                ->count();

            // 開始子豚
            $bornPigs = MixInfo::where('born_day', '>=', $begin_date)
                ->where('born_day', '<=', $end_date)
                ->whereNotNull('born_day')
                ->selectRaw('SUM(born_num) as sum_born_num')
                ->get();
            $count_bornPigs = $bornPigs->first()->sum_born_num;

            // 離乳子豚
            $weaningPigs = MixInfo::where('weaning_day', '>=', $begin_date)
                ->where('weaning_day', '<=', $end_date)
                ->whereNotNull('weaning_day')
                ->selectRaw('SUM(weaning_num) as sum_weaning_num')
                ->get();
            $count_weaningPigs = $weaningPigs->first()->sum_weaning_num;

            // 廃用頭数
            $count_leftPigs = FemalePig::withTrashed()
                // where([['left_day', '>=', $begin_date],['left_day', '<=', $end_date]])
                ->where('left_day', '>=', $begin_date)
                ->where('left_day', '<=', $end_date)
                ->count();

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
            $achievements[] = [
                'year' => $year,
                'count_workingPigs' => $count_workingFemalePigs,
                'count_mixes' => $count_mixes,
                'count_borns' => $count_borns,
                'count_bornPigs' => $count_bornPigs,
                'count_weaningPigs' => $count_weaningPigs,
                'success_mix' => $success_mix,
                'bornPigs_by_borns' => $bornPigs_by_borns,
                'rotates' => $rotates,
                'count_leftPigs' => $count_leftPigs,
            ];
        }
        // dd($achievements);

        return view('achievements.index')->with(compact('achievements'));
    }

    public function show(Request $request)
    {
        $achievement = $request->all();

        $year = $request->year;
        $begin_date = $year . '-01-01';
        $end_date = $year . '-12-31';

        // 期間内に稼働中の母豚の整理
        // DO:期間 ex.2021年
        // DO:年齢で整理
        // これには廃用個体を含む
        // BUG:期間以降に導入された個体が含まれている
        //         $femalePigs = FemalePig::withTrashed()
        //             ->where([['add_day', '<=', $end_date], ['left_day', '>=', $begin_date]])
        //             ->orWhere([['add_day', '<=', $end_date], ['left_day', '=', null]])
        //             ->get();
        // dd($femalePigs);
        // ->の順番重要
        $femalePigs = FemalePig::withTrashed()
            ->where([
                ['add_day', '<=', $end_date],
                ['left_day', '>=', $begin_date],
            ])
            ->orWhere([
                ['add_day', '<=', $end_date],
                ['left_day', '=', null],
            ])
            // ->where('add_day', '<=', $end_date)
            // ->andWhere('left_day', '>=', $begin_date)
            // ->orWhere('left_day', '=', null)
            // ->whereNull('left_day')
            // ->orWhereNull('left_day')
            ->withCount([
                'mix_infos AS total_mix_count' => function ($query) use (
                    $begin_date,
                    $end_date
                ) {
                    $query->where([
                        ['mix_day', '>=', $begin_date],
                        ['mix_day', '<=', $end_date]
                    ]);
                        // ->where('mix_day', '>=', $begin_date)
                        // ->where('mix_day', '<=', $end_date);
                },
            ])
            ->withCount([
                'mix_infos AS total_born_count' => function ($query) use (
                    $begin_date,
                    $end_date
                ) {
                    $query
                        ->where('trouble_id', 1)
                        ->where([['born_day', '>=', $begin_date],['born_day', '<=', $end_date]]);
                        // ->where('mix_day', '>=', $begin_date)
                        // ->where('mix_day', '<=', $end_date);
                        // ->where('born_day', '>=', $begin_date)
                        // ->where('born_day', '<=', $end_date);
                },
            ])
            ->withCount([
                'mix_infos AS total_born_count_by_mix_day' => function ($query) use (
                    $begin_date,
                    $end_date
                ) {
                    $query
                        ->where('trouble_id', 1)
                        ->where([['mix_day', '>=', $begin_date],['mix_day', '<=', $end_date]]);
                },
            ])
            ->withCount([
                'mix_infos AS total_bornPigs' => function ($query) use (
                    $begin_date,
                    $end_date
                ) {
                    $query
                        ->where('born_day', '>=', $begin_date)
                        ->where('born_day', '<=', $end_date)
                        ->select(DB::raw('SUM(born_num) as count_sum'));
                },
            ])
            ->withCount([
                'mix_infos AS total_weaningPigs' => function ($query) use (
                    $begin_date,
                    $end_date
                ) {
                    $query
                        ->where('weaning_day', '>=', $begin_date)
                        ->where('weaning_day', '<=', $end_date)
                        ->select(DB::raw('SUM(weaning_num) as count_sum'));
                },
            ])
            ->get();
        $femalePigs->load('mix_infos');

        // 当時の年齢を算出するためにyearセット
        foreach ($femalePigs as $femalePig) {
            $femalePig->year = $year;
        }
        // FIXME: 'age_in_those_days'は'age'のスコープに入らないようにするためだが、任意の文字列では機能しないのはなぜ？？
        $count_workingPigs_byAge = $femalePigs
            ->sortBy('age_in_those_days')
            ->groupBy('age_in_those_days')
            ->map(function ($age) {
                return $age->count();
            });
        $count_mixes_byAge_total = $femalePigs
            ->sortBy('age_in_those_days')
            ->groupBy('age_in_those_days')
            ->map(function ($age) {
                return $age->sum('total_mix_count');
            });
        $count_borns_byAge_total = $femalePigs
            ->sortBy('age_in_those_days')
            ->groupBy('age_in_those_days')
            ->map(function ($age) {
                return $age->sum('total_born_count');
            });
        $count_borns_byAge_total_byMix_day = $femalePigs
            ->sortBy('age_in_those_days')
            ->groupBy('age_in_those_days')
            ->map(function ($age) {
                return $age->sum('total_born_count_by_mix_day');
            });
        // dd($count_borns_byAge_total);
        $count_bornPigs_byAge_total = $femalePigs
            ->sortBy('age_in_those_days')
            ->groupBy('age_in_those_days')
            ->map(function ($age) {
                return $age->sum('total_bornPigs');
            });
        $count_weaningPigs_byAge_total = $femalePigs
            ->sortBy('age_in_those_days')
            ->groupBy('age_in_those_days')
            ->map(function ($age) {
                return $age->sum('total_weaningPigs');
            });

        // 交配成功率
        foreach ($count_mixes_byAge_total as $key => $value) {
            if ($value !== 0) {
                $success_mix[$key] = round(
                    // $count_borns_byAge_total[$key] /
                    $count_borns_byAge_total_byMix_day[$key] /
                        $count_mixes_byAge_total[$key],
                    2
                );
            } else {
                $success_mix[$key] = 0;
            }
        }
        // 一腹産数
        foreach ($count_borns_byAge_total as $key => $value) {
            if ($value !== 0) {
                $bornPigs_by_borns[$key] = round(
                    $count_bornPigs_byAge_total[$key] /
                        $count_borns_byAge_total[$key],
                    2
                );
            } else {
                $bornPigs_by_borns[$key] = 0;
            }
        }
        // 産子数
        foreach ($count_workingPigs_byAge as $key => $value) {
            $rotates[$key] = round(
                $count_borns_byAge_total[$key] / $count_workingPigs_byAge[$key],
                2
            );
        }

        foreach ($count_workingPigs_byAge as $key => $value) {
            $achievements_by_age[$key] = ['age' => $key];
        }
        foreach ($count_workingPigs_byAge as $key => $value) {
            $achievements_by_age[$key]['count_workingPigs'] = $value;
        }
        foreach ($count_mixes_byAge_total as $key => $value) {
            $achievements_by_age[$key]['count_mixes_byAge_total'] = $value;
        }
        foreach ($count_borns_byAge_total as $key => $value) {
            $achievements_by_age[$key]['count_borns_byAge_total'] = $value;
        }
        foreach ($count_bornPigs_byAge_total as $key => $value) {
            $achievements_by_age[$key]['count_bornPigs_byAge_total'] = $value;
        }
        foreach ($count_weaningPigs_byAge_total as $key => $value) {
            $achievements_by_age[$key]['count_weaningPigs_byAge_total'] = $value;
        }
        foreach ($success_mix as $key => $value) {
            $achievements_by_age[$key]['success_mix'] = $value;
        }
        foreach ($bornPigs_by_borns as $key => $value) {
            $achievements_by_age[$key]['bornPigs_by_borns'] = $value;
        }
        foreach ($rotates as $key => $value) {
            $achievements_by_age[$key]['rotates'] = $value;
        }

        $achievements_by_age = array_values($achievements_by_age);
        // dd($achievements_by_age);
        return view('achievements.show')->with(
            compact('achievements_by_age', 'achievement', 'femalePigs')
        );

        ## ここから非表示
        // // 現在、稼働中の母豚の整理
        // // DO:年単位の成績 ex.2021年
        // // DO:母豚の年齢単位の成績 ex.5歳
        // // これには廃用個体が含まれない
        // $existPigs = FemalePig::withCount([
        //     'mix_infos AS total_mix_count' => function ($query) use (
        //         $begin_date,
        //         $end_date
        //     ) {
        //         // $query->select(DB::raw('COUNT(*) as count_sum'));
        //         $query
        //             ->where('mix_day', '>=', $begin_date)
        //             ->where('mix_day', '<=', $end_date);
        //     },
        // ])
        //     ->withCount([
        //         'mix_infos AS total_born_count' => function ($query) use (
        //             $begin_date,
        //             $end_date
        //         ) {
        //             $query
        //                 ->where('trouble_id', 1)
        //                 ->where('mix_day', '>=', $begin_date)
        //                 ->where('mix_day', '<=', $end_date);
        //         },
        //     ])
        //     ->withCount([
        //         'mix_infos AS total_childPigs' => function ($query) use (
        //             $begin_date,
        //             $end_date
        //         ) {
        //             // $query->select(DB::raw('SUM(born_num) as count_sum'));
        //             $query
        //                 ->where('mix_day', '>=', $begin_date)
        //                 ->where('mix_day', '<=', $end_date)
        //                 ->select(DB::raw('SUM(born_num) as count_sum'));
        //         },
        //     ])
        //     ->get();

        // $test = $existPigs->groupBy('age');
        // $count_byAge = $existPigs->groupBy('age')->map(function ($age) {
        //     return $age->count();
        // });
        // $mixCount_byAge_total = $existPigs
        //     ->groupBy('age')
        //     ->map(function ($age) {
        //         return $age->sum('total_mix_count');
        //     });
        // $mixCount_byAge_average = $existPigs
        //     ->groupBy('age')
        //     ->map(function ($age) {
        //         return $age->sum('total_mix_count') / $age->count();
        //     });
        // $bornCount_byAge_total = $existPigs
        //     ->groupBy('age')
        //     ->map(function ($age) {
        //         return $age->sum('total_born_count');
        //     });
        // $bornCount_byAge_average = $existPigs
        //     ->groupBy('age')
        //     ->map(function ($age) {
        //         return $age->sum('total_born_count') / $age->count();
        //     });
        // $childCount_byAge_total = $existPigs
        //     ->groupBy('age')
        //     ->map(function ($age) {
        //         return $age->sum('total_childPigs');
        //     });
        // $childCount_byAge_average = $existPigs
        //     ->groupBy('age')
        //     ->map(function ($age) {
        //         return $age->sum('total_childPigs') / $age->count();
        //     });
        // dd($childCount_byAge_average);
    }
}
