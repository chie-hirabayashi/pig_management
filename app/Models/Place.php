<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'place_num',
        'female_id',
        'category',
    ];

    /**
     * Get the female_pig associated with the Place
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function female_pig()
    {
        return $this->hasOne(FemalePig::class, 'female_id', 'id');
    }
}
