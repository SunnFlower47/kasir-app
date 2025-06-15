<?php

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
        Schema::create('transaksi_details', function (Blueprint $table) {
    $table->id();
    $table->foreignId('transaksi_id')->constrained()->cascadeOnDelete();
    $table->foreignId('produk_id')->constrained('barangs')->cascadeOnDelete();
    $table->integer('harga');
    $table->integer('jumlah');
    $table->integer('subtotal');
    $table->timestamps();
});



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_details');
    }
};
