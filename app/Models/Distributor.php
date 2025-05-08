<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $fillable = ['nama', 'alamat', 'telepon'];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id_distributor');
    }
}

