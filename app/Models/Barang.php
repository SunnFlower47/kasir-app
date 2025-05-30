<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    protected $table = 'barangs';

    protected $fillable = [
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

    protected $casts = [
        'expired_at' => 'datetime',
        'harga_modal' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'stok' => 'integer'
    ];

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class, 'id_distributor');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function isLowStock(int $threshold = 5): bool
    {
        return $this->stok < $threshold;
    }

    public function isExpired(): bool
    {
        return $this->expired_at && $this->expired_at->isPast();
    }

    public function isExpiringSoon(int $days = 30): bool
    {
        return $this->expired_at &&
               $this->expired_at->isFuture() &&
               $this->expired_at->diffInDays(now()) <= $days;
    }
}
