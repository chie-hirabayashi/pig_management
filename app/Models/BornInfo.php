<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BornInfo extends Model
{
    use HasFactory;

    // Mass Assignment対策
    protected $fillable = [
        'female_id',
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
     * Get the femele_pig that owns the BornInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function femele_pig()
    {
        return $this->belongsTo(FemalePig::class, 'female_id', 'id');
    }
}
