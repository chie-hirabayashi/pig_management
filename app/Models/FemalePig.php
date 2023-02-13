<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class FemalePig extends Model
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
        'exist',
    ];

    // リレーション
    /**
     * Get all of the mix_infos for the FemalePig
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mix_infos()
    {
        return $this->hasMany(MixInfo::class, 'female_id', 'id');
    }

    /**
     * Get all of the born_infos for the FemalePig
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function born_infos()
    {
        return $this->hasMany(BornInfo::class, 'female_id', 'id');
    }

    /**
     * Get all of the born_infos for the FemalePig
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    // アクセサ
    public function getAgeAttribute()
    {
        $add_day = Carbon::create($this->add_day);
        $now = Carbon::now();
        
        return $now->addMonth(6)->diffInYears($add_day);
    }

    public function getAgeInThoseDaysAttribute()
    {
        $add_day = Carbon::create($this->add_day);
        $year = Carbon::create($this->year);

        return $year->addYear(1)->addMonth(6)->diffInYears($add_day);
    }

    public function getStatusAttribute()
    {
        $mixInfo_last = $this->mix_infos->last();
        $today = Carbon::now(); 
        
        if (!empty($mixInfo_last->mix_day)) {
            $mix_day = Carbon::create($mixInfo_last->mix_day);
        }

        if (!empty($mixInfo_last->born_day)) {
            $born_day = Carbon::create($mixInfo_last->born_day);
        }
        
        switch (true) {
            // 観察中:mix_dayあり&&born_dayなし&&troubleなし
            // 参考:120日間(交配~出産予定114日+6日)
            case !empty($mixInfo_last->mix_day) &&
                empty($mixInfo_last->born_day) &&
                $mixInfo_last->trouble_id == 1:
                // $today->diffInDays($mix_day) <= 120:
                return '観察中';
                break;

            // 保育中:born_dayあり&&weaning_dayなし
            case !empty($mixInfo_last->born_day) &&
                empty($mixInfo_last->weaning_day):
                // $today->diffInDays($born_day) < 24:
                return '保育中';
                break;

            // 待機中:再発、流産
            // case !empty($mixInfo_last->trouble_id) && $mixInfo_last->trouble_id !== 1:
            case $mixInfo_last->trouble_id !== 1:
                return '待機中';
                break;

            // 上記以外
            default:
                return '待機中';
                break;
        }
    }

    public function getRotatePredictionAttribute()
    {
        $born_last = MixInfo::where('female_id', $this->id)
            ->whereNotNull('born_day')
            ->get()
            ->last();

        // bornInfoがある場合、予測回転数算出
        if ($born_last) {
            $carbon_now = Carbon::now();
            $carbon_last = Carbon::create($born_last->born_day);
            $rotate_prediction = 365 / $carbon_now->diffInDays($carbon_last);

            return round($rotate_prediction, 2);
            // return self::getPredictionRotate($this);
        } else {
            return 0;
        }
    }
}
