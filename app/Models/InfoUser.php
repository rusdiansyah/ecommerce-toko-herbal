<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoUser extends Model
{
    protected $fillable =[
        'user_id',
        'noWa',
        'alamat',
    ];
}
