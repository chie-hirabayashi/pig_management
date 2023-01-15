<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class MalePig extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Mass Assignment対策
    protected $fillable = [
        'id',
        'individual_num',
        'add_day',
        'left_day',
        'warn_flag',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // リレーション
    /**
     * Get all of the mix_infos for the MalePig
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function first_mix_infos()
    {
        return $this->hasMany(MixInfo::class, 'first_male_id', 'id');
    }

    /**
     * Get all of the mix_infos for the MalePig
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function second_mix_infos()
    {
        return $this->hasMany(MixInfo::class, 'second_male_id', 'id');
    }

    /**
     * Get all of the born_infos for the MalePig
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function first_born_infos()
    {
        return $this->hasMany(BornInfo::class, 'first_male_id', 'id');
    }

    /**
     * Get all of the born_infos for the MalePig
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function second_Born_infos()
    {
        return $this->hasMany(MixInfo::class, 'second_male_id', 'id');
    }

    // アクセサ
    public function getAgeAttribute()
    {
        $add_day = Carbon::create($this->add_day);
        $now = Carbon::now();

        return $now->addMonth(6)->diffInYears($add_day);
    }

    public function getMixProbabilityAttribute()
    {
        // 全交配情報取得
        $first_mixes = $this->first_mix_infos;
        $second_mixes = $this->second_mix_infos;
        // 異常のない交配情報取得
        $first_noTroubles = $this->first_mix_infos
                                ->where('trouble_id', 1);
        $second_noTroubles = $this->second_mix_infos
                                ->where('trouble_id', 1);
        // 交配成功率算出
        if (count($first_mixes)==0 && count($second_mixes)==0) {
            $mix_probability = 0;
        } else {
            $mix_probability =
                (count($first_noTroubles) + count($second_noTroubles)) /
                (count($first_mixes) + count($second_mixes));
        }
        // 交配成功率をセット
        return round($mix_probability * 100, 0);
    }

    public function getAllMIxesAttribute()
    {
        // 全交配情報取得
        $first_mixes = $this->first_mix_infos;
        $second_mixes = $this->second_mix_infos;
        // 異常のない交配情報取得
        $first_noTroubles = $this->first_mix_infos
                                ->where('trouble_id', 1);
        $second_noTroubles = $this->second_mix_infos
                                ->where('trouble_id', 1);

        // 交配相手ごとにデータを整理
        $first_females = $first_mixes->groupBy('female_id');
        $second_females = $second_mixes->groupBy('female_id');
        // $first_noTrouble_females = $first_noTroubles->groupBy('female_id');
        // $second_noTrouble_females = $second_noTroubles->groupBy(
        //     'female_id'
        // );

        // 1回目と2回目の交配回数をまとめる(経過異常含む)
        $first_mixes = [];
        foreach ($first_females as $key => $val) {
            $first_mixes[$key] = count($val);
        }
        $second_mixes = [];
        foreach ($second_females as $key => $val) {
            $second_mixes[$key] = count($val);
        }
        foreach ($first_mixes as $key1 => $val1) {
            foreach ($second_mixes as $key2 => $val2) {
                if ($key1 == $key2) {
                    $first_mixes[$key1] = $val1 + $val2;
                }
            }
        }
        $all_mixes = $first_mixes + $second_mixes;
        return array_sum($all_mixes);
    }
}
