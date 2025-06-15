<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
class TransaksiController extends Controller
{
    public function kasir()
{
    $produks = Barang::orderBy('nama')->get(); // ambil semua produk dari tabel barangs
    return view('kasir.dashboard', compact('produks'));
}
}
