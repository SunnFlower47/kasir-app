<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Distributor;

class AdminController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalKategori = Kategori::count();
        $totalDistributor = Distributor::count();

        return view('admin.dashboard', compact('totalBarang', 'totalKategori', 'totalDistributor'));
    }
}
