<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index()
    {
        $produks = Barang::orderBy('nama')->get();
        return view('kasir.dashboard', compact('produks'));
    }

    public function simpanTransaksi(Request $request)
{
    $data = $request->validate([
        'total' => 'required|numeric|min:0',
        'uang_bayar' => 'required|numeric|min:0',
        'kembalian' => 'required|numeric',
        'keranjang' => 'required|array|min:1',
        'keranjang.*.id' => 'required|integer|exists:barangs,id',
        'keranjang.*.harga' => 'required|numeric|min:0',
        'keranjang.*.jumlah' => 'required|integer|min:1',
    ]);

    DB::beginTransaction();
    try {
        $transaksi = Transaksi::create([
            'total' => $data['total'],
            'uang_bayar' => $data['uang_bayar'],
            'kembalian' => $data['kembalian'],
            'tanggal' => now(),
        ]);

        foreach ($data['keranjang'] as $item) {
            $produk = Barang::find($item['id']);

            if (!$produk) {
                throw new \Exception("Produk ID {$item['id']} tidak ditemukan.");
            }

            if ($produk->stok < $item['jumlah']) {
                throw new \Exception("Stok untuk {$produk->nama} tidak mencukupi.");
            }

            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item['id'],
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $item['harga'] * $item['jumlah'],
            ]);

            $produk->stok -= $item['jumlah'];
            $produk->save();
        }

        DB::commit();

        // Ambil data produk terbaru untuk update stok di frontend
        $updatedProduk = Barang::select('id', 'stok')->get();

        return response()->json([
            'success' => true,
            'transaksi' => $transaksi,
            'updatedProduk' => $updatedProduk,
        ]);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ]);
    }
}

}
