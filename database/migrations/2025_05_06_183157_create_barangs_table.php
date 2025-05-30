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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('barcode')->nullable();
            $table->decimal('harga_modal', 10, 2);
            $table->decimal('harga_jual', 10, 2);
            $table->integer('stok')->default(0);
            $table->string('satuan')->default('pcs');
            $table->unsignedBigInteger('id_distributor')->nullable();
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->text('keterangan')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();

            // Add index to foreign key columns for better performance
            $table->index('id_distributor');
            $table->index('kategori_id');
        });

        // Add foreign key constraints separately to ensure tables exist
        Schema::table('barangs', function (Blueprint $table) {
            $table->foreign('id_distributor')
                  ->references('id')
                  ->on('distributors')
                  ->onDelete('set null');

            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategoris')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropForeign(['id_distributor']);
            $table->dropForeign(['kategori_id']);
        });

        Schema::dropIfExists('barangs');
    }
};
