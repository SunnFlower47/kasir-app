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
    Schema::create('stok_logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('barang_id');
        $table->enum('jenis', ['masuk', 'keluar']);
        $table->integer('jumlah');
        $table->text('keterangan')->nullable();
        $table->timestamps();

        $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_logs');
    }
};
