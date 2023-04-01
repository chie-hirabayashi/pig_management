<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MixInfo extends Model
{
    use HasFactory;

    // Mass Assignment対策
    protected $fillable = [
        'female_id',
        'first_male_id',
        'second_male_id',
        'mix_day',
        'first_recurrence_schedule',
        'first_recurrence',
        'second_recurrence_schedule',
        'second_recurrence',
        'delivery_schedule',
        'trouble_day',
        'trouble_id',
        'born_day',
        'born_num',
        'stillbirth_num',
        'born_weight',
        'foster_female',
        'foster_male',
        'control_num',
        'weaning_day',
        'weaning_num',
        'weaning_weight',
    ];

    // リレーション
    /**
     * Get the female_pig that owns the MixInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function female_pig()
    {
        return $this->belongsTo(FemalePig::class, 'female_id', 'id');
    }

    /**
     * Get the female_pig_with_trashed that owns the MixInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function female_pig_with_trashed()
    {
        return $this->belongsTo(
            FemalePig::class,
            'female_id',
            'id'
        )->withTrashed();
    }

    /**
     * Get the male_pig that owns the MixInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function first_male_pig()
    {
        return $this->belongsTo(MalePig::class, 'first_male_id', 'id');
    }

    /**
     * Get the first_male_pig_with_trashed that owns the MixInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function first_male_pig_with_trashed()
    {
        return $this->belongsTo(
            MalePig::class,
            'first_male_id',
            'id'
        )->withTrashed();
    }

    /**
     * Get the male_pig that owns the MixInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function second_male_pig()
    {
        return $this->belongsTo(MalePig::class, 'second_male_id', 'id');
    }

    /**
     * Get the second_male_pig_with_trashed that owns the MixInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function second_male_pig_with_trashed()
    {
        return $this->belongsTo(MalePig::class, 'second_male_id', 'id')
            ->withDefault()
            ->withTrashed();
    }

    /**
     * Get the trouble_category that owns the MixInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trouble_category()
    {
        return $this->belongsTo(TroubleCategory::class, 'trouble_id', 'id');
    }

    /**
     * Get the born_info associated with the MixInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function born_info()
    {
        return $this->hasOne(BornInfo::class, 'mix_id', 'id');
    }

    // アクセサ
    public function getElapsedDaysAttribute()
    {
        $mix_day = Carbon::create($this->mix_day);
        $today = Carbon::now();

        return $today->diffInDays($mix_day);
    }

    public function getDeliveryDateAttribute()
    {
        $delivery_date = substr($this->delivery_schedule, -5);

        return $delivery_date;
    }

    public function getBornDateAttribute()
    {
        $born_date = substr($this->born_day, -5);

        return $born_date;
    }

    public function getForecastDateAttribute()
    {
        $mix_day = Carbon::create($this->mix_day);
        $born_day = Carbon::create($this->born_day);

        if ($this->born_num) {
            $forecast_date = $born_day->addDays(66); # 出産段階:出産頭数で予測,66日で出荷
        } else {
            $forecast_date = $mix_day->addDays(180); # 交配段階:推定出産頭数で予測180日で出荷
        }
        return date('Y-m', strtotime($forecast_date));
    }

    public function getForecastNumAttribute()
    {
        if ($this->born_num) {
            $forecast_num = $this->born_num;
        } else {
            $forecast_num = 10;
        }
        return $forecast_num;
    }
}
