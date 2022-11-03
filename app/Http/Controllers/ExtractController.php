<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MixInfo;
use App\Models\FemalePig;
use Carbon\Carbon;

class ExtractController extends Controller
{
    public function index()
    {
        // 抽出に必要な要件
        // 過去２回の回転数
        // 過去２回の出産頭数
        // 過去の再発、流産

        // 仮設定
        $female_id = 5;
        $criterion_rotate = 1.8;
        $criterion_num = 8;
        $extracts = [];
        
        // 稼働中のメスのID取得
        $femalePigs = FemalePig::where('deleted_at', null)->get();
        
        // 出産情報取得
        // $femalePig = FemalePig::find($female_id); //サンプル個体
        // $mixInfo = $femalePig->mix_infos; //サンプル個体の全交配データ

        $femalePigs = FemalePig::all();
        foreach ($femalePigs as $femalePig) {
            $bornInfo_all = MixInfo::where('female_id', $femalePig->id)->orderBy('id','desc')->whereNotNull('born_day')->get(); //サンプル個体の全出産情報
            $validity_count = count($bornInfo_all); // 有効性の確認(3つ以上Ok)

            switch (true) {
                case ($validity_count >= 3):
                    $bornInfo_past2 = $bornInfo_all->take(3); //過去3回の出産情報
                    $rotates = self::getRotate($bornInfo_past2); //回転数算出
                    for ($i=0; $i < 2 ; $i++) { 
                        $bornInfo_past2[$i]['rotate'] = $rotates[$i+1];
                    }
                    $bornInfo_past2 = $bornInfo_past2->take(2);
                    break;

                case ($validity_count === 2):
                    $bornInfo_past2 = $bornInfo_all->take($validity_count); //過去1~2回の出産情報
                    $rotates = self::getRotate($bornInfo_past2); //回転数算出
                    $rotates[2] = 0;
                    for ($i=0; $i < 2 ; $i++) { 
                        $bornInfo_past2[$i]['rotate'] = $rotates[$i+1];
                    }
                    break;

                case ($validity_count < 2):
                    $newBornInfo = new mixInfo;
                    $newBornInfo->female_id = $female_id;
                    $newBornInfo->born_num = 99; //出産なし
                    $newBornInfo->rotate = 99; //出産情報なし
                    $bornInfo_past2[0] = $newBornInfo;
                    $bornInfo_past2[1] = $newBornInfo;
            }
            // dd($bornInfo_past2);
            foreach ($bornInfo_past2 as $bornInfo) {
                if ($bornInfo->rotate < $criterion_rotate ||
                    $bornInfo->born_num < $criterion_num) {
                    $extracts[] = $bornInfo;
                }
            }
        }
        // dd($extracts);

        
        return view('extracts.index')
            ->with(compact('extracts'));
    }

    // 回転数算出function
    public function getRotate($bornInfos)
    {
        $array = [];
        $count = count($bornInfos);
        for ($i=0; $i < $count-1 ; $i++) { 
                $carbon_1 = Carbon::create($bornInfos[$i]->born_day);
                $carbon_2 = Carbon::create($bornInfos[$i+1]->born_day);
                $rotate = 365 / $carbon_1->diffInDays($carbon_2);
                // born_infosにrotateを追加
                $array[$i+1] = round($rotate, 2);
            }
        return $array;
    }
}

