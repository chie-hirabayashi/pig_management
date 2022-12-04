<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BornInfo extends Model
{
    use HasFactory;

    // Mass Assignment対策
    protected $fillable = [
        'mix_id',
        'female_id',
        'first_male_id',
        'second_male_id',
        'born_day',
        'born_num',
    ];

    // リレーション
    /**
     * Get the mix_info that owns the BornInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mix_info()
    {
        return $this->belongsTo(MixInfo::class, 'mix_id', 'id');
    }

    /**
     * Get the female_pig that owns the BornInfo
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
        return $this->belongsTo(MalePig::class, 'first_male_id', 'id');
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

}
