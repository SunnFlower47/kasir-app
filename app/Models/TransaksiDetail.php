<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $fillable = ['transaksi_id', 'produk_id', 'harga', 'jumlah', 'subtotal'];

    public function produk()
    {
        return $this->belongsTo(Barang::class, 'produk_id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
