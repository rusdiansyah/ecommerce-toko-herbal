<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'produk_id',
        'jumlah',
        'harga',
        'subTotal',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function review()
    {
        return $this->hasOne(ReviewProduk::class);
    }
}
