<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TroubleCategory extends Model
{
    use HasFactory;

    // MassAsignment対策
    protected $fillable = [
        'trouble_name',
    ];

    // リレーション
    /**
     * Get all of the mix_infos for the TroubleCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mix_infos()
    {
        return $this->hasMany(MixInfo::class, 'trouble_id', 'id');
    }
}
