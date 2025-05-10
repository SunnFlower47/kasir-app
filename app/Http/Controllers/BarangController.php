<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Distributor;
use App\Models\Kategori;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangExport;
use Barryvdh\DomPDF\Facade\Pdf;



class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Barang::with(['kategori', 'distributor']);

    // Handle search
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('kode_barang', 'like', "%{$search}%")
              ->orWhere('barcode', 'like', "%{$search}%");
        });
    }

    // Handle filter stok dan expired
    if ($request->has('filter')) {
    switch ($request->filter) {
        case 'stok_rendah':
            $query->where('stok', '<', 10);
            break;

        case 'akan_expired':
            $query->whereNotNull('expired_at')
                 ->whereDate('expired_at', '>', now()) // Not expired yet
                 ->whereDate('expired_at', '<=', now()->addDays(30)); // Within 30 days
            break;

        case 'sudah_expired':
            $query->whereNotNull('expired_at')
                 ->whereDate('expired_at', '<', now()); // Already expired
            break;
    }
}
    $barangs = $query->orderBy('nama')->paginate(9);

    return view('barang.index', compact('barangs'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $distributors = Distributor::all();
        $kategoris = Kategori::all();
        return view('barang.create', compact('distributors', 'kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang'    => 'required|unique:barangs,kode_barang',
            'nama'           => 'required',
            'barcode'        => 'nullable',
            'harga_modal'    => 'required|numeric',
            'harga_jual'     => 'required|numeric',
            'stok'           => 'required|integer',
            'satuan'         => 'required',
            'id_distributor' => 'nullable|exists:distributors,id',
            'kategori_id'    => 'nullable|exists:kategoris,id',
            'keterangan'     => 'nullable',
            'expired_at'     => 'nullable|date',
        ]);

        Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barang = Barang::with('distributor', 'kategori')->findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = Barang::findOrFail($id);
        $distributors = Distributor::all();
        $kategoris = Kategori::all();

        return view('barang.edit', compact('barang', 'distributors', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barang = Barang::findOrFail($id);

        $validated = $request->validate([
            'kode_barang'    => 'required|unique:barangs,kode_barang,' . $barang->id,
            'nama'           => 'required',
            'barcode'        => 'nullable',
            'harga_modal'    => 'required|numeric',
            'harga_jual'     => 'required|numeric',
            'stok'           => 'required|integer',
            'satuan'         => 'required',
            'id_distributor' => 'nullable|exists:distributors,id',
            'kategori_id'    => 'nullable|exists:kategoris,id',
            'keterangan'     => 'nullable',
            'expired_at'     => 'nullable|date',
        ]);

        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
public function export($format)
{
    $search = request()->get('search');
    $date = now()->format('Y-m-d');
    $filename = "data-barang-{$date}.{$format}";

    switch ($format) {
        case 'xlsx':
            return Excel::download(new BarangExport($search), $filename);

        case 'csv':
            return Excel::download(new BarangExport($search), $filename, \Maatwebsite\Excel\Excel::CSV);

        case 'pdf':
            $data = Barang::with(['kategori', 'distributor'])
                ->when($search, function($query) use ($search) {
                    $query->where('nama', 'like', '%'.$search.'%')
                          ->orWhere('kode_barang', 'like', '%'.$search.'%')
                          ->orWhere('barcode', 'like', '%'.$search.'%');
                })
                ->orderBy('kode_barang', 'asc')
                ->get();

            $pdf = Pdf::loadView('exports.barang-pdf', [
                'barang' => $data,
                'title' => 'Laporan Data Barang',
                'date' => $date,
                'search' => $search
            ])->setPaper('a4', 'landscape');

            return $pdf->download($filename);

        default:
            abort(404, 'Format export tidak valid');
    }
}
}
