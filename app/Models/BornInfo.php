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

    // /**
    //  * Get the mix_info associated with the BornInfo
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\HasOne
    //  */
    // public function mix_info()
    // {
    //     return $this->hasOne(MixInfo::class, 'mix_id', 'id');
    // }
}
