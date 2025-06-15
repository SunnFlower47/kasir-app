<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['total', 'uang_bayar', 'kembalian', 'tanggal'];

    public function detail()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
