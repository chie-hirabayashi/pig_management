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
        'memo',
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
     * Get the place associated with the FemalePig
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function place()
    {
        return $this->hasOne(Place::class, 'female_id', 'id')->withDefault();
    }

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

        return $year
            ->addYear(1)
            ->addMonth(6)
            ->diffInYears($add_day);
    }

    public function getStatusAttribute()
    {
        $mixInfo_last = $this->mix_infos->last();

        switch (true) {
            // 観察中:mix_dayあり&&born_dayなし&&troubleなし
            // 参考:120日間(交配~出産予定114日+6日)
            case !empty($mixInfo_last->mix_day) &&
                empty($mixInfo_last->born_day) &&
                $mixInfo_last->trouble_id == 1:
                return '観察中';
                break;

            // 保育中:born_dayあり&&weaning_dayなし
            // 参考:24日間(出産~離乳)
            case !empty($mixInfo_last->born_day) &&
                empty($mixInfo_last->weaning_day):
                return '保育中';
                break;

            // 待機中:再発、流産
            case empty($mixInfo_last->trouble_id):
                return '待機中';
                break;

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

    public function getSortDayAttribute()
    {
        $today = Carbon::now();

        if (empty($this->mix_infos->last()) || $this->mix_infos->last()->trouble_id != 1) {
            $this->status = '待機中';
        } else {
        // }
        // if (!empty($this->mix_infos->last())) {
            $first_recurrence = Carbon::create(
                $this->mix_infos->last()->first_recurrence_schedule
            );
            $second_recurrence = Carbon::create(
                $this->mix_infos->last()->second_recurrence_schedule
            );
            $delivery_recurrence = Carbon::create(
                $this->mix_infos->last()->delivery_schedule
            );

            $day1 = $today->diffInDays($first_recurrence);
            $day2 = $today->diffInDays($second_recurrence);
            $day3 = $today->diffInDays($delivery_recurrence);
            $day = [$day1, $day2, $day3];
        }

        if ($this->status == '観察中') {
            return min($day);
        } else {
            return 140;
        }
    }
}
