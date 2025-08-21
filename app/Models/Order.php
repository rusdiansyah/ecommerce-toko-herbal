<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'nomor',
        'user_id',
        'statusBayar',
        'buktiBayar',
        'metodeBayar',
        'total',
        'catatan',
        'statusPengiriman',
        'noResi',
    ];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
