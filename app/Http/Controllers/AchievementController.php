<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MixInfo;

class AchievementController extends Controller
{
    public function index()
    {
        // 2020年に稼働した母豚を抽出
        $date = date('2020');

        // 稼働母豚
        $working_femalePigs = MixInfo::groupBy('female_id')
            ->where('mix_day', '<=', '2021-12-31')
            ->where('mix_day', '>=', '2021-01-01')
            ->get('female_id');
        $count_workingFemalePigs = count($working_femalePigs);

        // 交配回数
        $count_mixs = MixInfo::where('mix_day', '<=', '2020-12-31')
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
        // dd($count_borns);

        return view('achievements.index')->with(compact('count_workingFemalePigs'));
    }
}
