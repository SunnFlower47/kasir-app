<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'kode_barang',
        'nama',
        'barcode',
        'harga_modal',
        'harga_jual',
        'stok',
        'satuan',
        'id_distributor',
        'kategori_id',
        'keterangan',
        'expired_at'
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'id_distributor');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
