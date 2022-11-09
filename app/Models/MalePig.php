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
        return $this->hasMany(MixInfo::class, 'male_first_id', 'id');
    }

    /**
     * Get all of the mix_infos for the MalePig
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function second_mix_infos()
    {
        return $this->hasMany(MixInfo::class, 'male_second_id', 'id');
    }

    // アクセサ
    public function getAgeAttribute()
    {
        $add_day = Carbon::create($this->add_day);
        $now = Carbon::now();
        
        return $now->addMonth(6)->diffInYears($add_day);
    }
}
