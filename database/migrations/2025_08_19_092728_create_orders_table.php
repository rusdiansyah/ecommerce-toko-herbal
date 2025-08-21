<?php

use App\Models\User;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->enum('statusBayar',['Belum Lunas','Lunas'])->default('Belum Lunas');
            $table->string('buktiBayar')->nullable();
            $table->enum('metodeBayar',['Cash','Transfer','Qris','VA'])->default('Cash');
            $table->integer('total');
            $table->string('catatan')->nullable();
            $table->enum('statusPengiriman',['Order','Dikirim','Diterima'])->default('Order');
            $table->string('noResi','30')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
