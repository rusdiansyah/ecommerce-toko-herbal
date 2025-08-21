<?php

use App\Models\Produk;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('review_produks', function (Blueprint $table) {
            $table->foreignIdFor(Produk::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_produks', function (Blueprint $table) {
            // $table->dropColumn('produk_id');
        });
    }
};
