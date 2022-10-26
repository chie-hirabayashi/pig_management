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
        'individual_num',
        'add_day',
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

    // アクセサ
    public function getAgeAttribute()
    {
        $add_day = Carbon::create($this->add_day);
        $now = Carbon::now();
        
        return $now->addMonth(6)->diffInYears($add_day);
    }
}
