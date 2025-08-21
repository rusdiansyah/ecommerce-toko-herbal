<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Produk extends Model
{
    protected $fillable = [
        'kategori_produk_id',
        'nama',
        'slug',
        'deskripsi',
        'berat',
        'harga',
        'stokAda',
        'gambar',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id');
    }

    public function scopeRating()
    {
        $review = ReviewProduk::where('produk_id',$this->id)
        ->select(DB::raw('avg(rating) as tRating'))
        ->first();
        return (int) $review->tRating ?? 0;
    }
}
