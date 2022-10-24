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

    protected $fillable = [
        'individual_num',
        'add_day',
    ];

    public function getAgeAttribute()
    {
        $add_day = Carbon::create($this->add_day);
        $now = Carbon::now();
        
        return $now->addMonth(6)->diffInYears($add_day);
    }
}
