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
}
