<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Distributor;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
{
    // Basic counts
    $totalBarang = Barang::count();
    $totalKategori = Kategori::count();
    $totalDistributor = Distributor::count();

    // Low stock items (threshold < 5)
    $lowStockItems = Barang::where('stok', '<', 10)->count();

    // Barang yang sudah kadaluarsa
    $expiredItems = Barang::whereNotNull('expired_at')
        ->where('expired_at', '<', now())
        ->count();

    // Barang mendekati kadaluarsa (dalam 30 hari)
    $expiringSoon = Barang::whereNotNull('expired_at')
        ->whereBetween('expired_at', [now(), now()->addDays(30)])
        ->count();

    // Barang baru minggu ini
    $newThisWeek = Barang::where('created_at', '>=', now()->subDays(7))->count();

    // Recent items (last 5 added)
    $recentItems = Barang::with('kategori')
        ->latest()
        ->take(5)
        ->get();

    // Chart data — masih placeholder (nanti ubah ke grafik penjualan)
    $chartData = Kategori::withCount(['barangs as total_stok' => function($query) {
        $query->select(DB::raw('COALESCE(SUM(stok), 0)'));
    }])
    ->orderBy('total_stok', 'desc')
    ->get();

    $chartCategories = $chartData->pluck('nama_kategori');
    $chartValues = $chartData->pluck('total_stok');

    return view('admin.dashboard', [
        'totalBarang' => $totalBarang,
        'totalKategori' => $totalKategori,
        'totalDistributor' => $totalDistributor,
        'lowStockItems' => $lowStockItems,
        'recentItems' => $recentItems,
        'chartCategories' => $chartCategories,
        'chartData' => $chartValues,
        'expiringSoon' => $expiringSoon,
        'newThisWeek' => $newThisWeek,
        'expiredItems' => $expiredItems,  // Tambahkan expired items
    ]);
}

}
