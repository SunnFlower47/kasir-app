<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $fillable = ['nama'];

    /**
     * Relationship to Barang
     */
    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}
