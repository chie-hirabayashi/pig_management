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
}
