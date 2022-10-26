<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MixInfo extends Model
{
    use HasFactory;

    // Mass Assignment対策
    protected $fillable = [
        'female_id',
        'male_first_id',
        'male_second_id',
        'mix_day',
        'recurrence_first_schedule',
        'recurrence_second_schedule',
        'recurrence_day',
        'recurrence_flag',
        'abortion_flag',
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
     * Get the male_pig that owns the MixInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function first_male_pig()
    {
        return $this->belongsTo(MalePig::class, 'male_first_id', 'id');
    }

    /**
     * Get the male_pig that owns the MixInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function second_male_pig()
    {
        return $this->belongsTo(MalePig::class, 'male_second_id', 'id');
    }
}
