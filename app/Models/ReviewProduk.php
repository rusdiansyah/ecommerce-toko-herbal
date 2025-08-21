<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewProduk extends Model
{
    protected $fillable = [
        'order_detail_id',
        'produk_id',
        'rating',
        'komentar',
    ];
}
