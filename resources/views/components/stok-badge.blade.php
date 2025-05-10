<span @class([
    'badge',
    'badge-success' => $stok > 10,
    'badge-warning' => $stok > 0 && $stok <= 10,
    'badge-danger'  => $stok <= 0,
])>
    {{ $stok }}
</span>
