<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $fillable =[
        'bank',
        'nomor',
        'nama',
    ];
}
