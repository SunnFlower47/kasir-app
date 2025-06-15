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
       Schema::create('transaksis', function (Blueprint $table) {
    $table->id();
    $table->integer('total');
    $table->integer('uang_bayar');
    $table->integer('kembalian');
    $table->dateTime('tanggal');
    $table->timestamps();


});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
