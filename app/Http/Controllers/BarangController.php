<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Distributor;
use App\Models\Kategori;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangExport;
use Barryvdh\DomPDF\Facade\Pdf;

use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index(Request $request)
{
    $query = Barang::with(['kategori', 'distributor']);

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('barcode', 'like', "%{$search}%");

        });
    }

    if ($request->has('filter')) {
        switch ($request->filter) {
            case 'stok_rendah':
                $query->where('stok', '<', 10);
                break;
            case 'akan_expired':
                $query->whereNotNull('expired_at')
                      ->whereDate('expired_at', '>', now())
                      ->whereDate('expired_at', '<=', now()->addDays(30));
                break;
            case 'sudah_expired':
                $query->whereNotNull('expired_at')
                      ->whereDate('expired_at', '<', now());
                break;
        }
    }

    $barangs = $query->orderBy('nama')->paginate(9);

    return view('admin.barang.index', compact('barangs'));
}


    public function create()
    {
        $distributors = Distributor::all();
        $kategoris = Kategori::all();

        return view('admin.barang.create', compact('distributors', 'kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $barang = Barang::with('distributor', 'kategori')->findOrFail($id);
        return view('admin.barang.show', compact('barang'));
    }

    public function edit(string $id)
    {
        $barang = Barang::findOrFail($id);
        $distributors = Distributor::all();
        $kategoris = Kategori::all();

        return view('admin.barang.edit', compact('barang', 'distributors', 'kategoris'));
    }

    public function update(Request $request, string $id)
    {
        $barang = Barang::findOrFail($id);

        $validated = $request->validate([
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

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil dihapus.');
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
                              ->orWhere('barcode', 'like', '%'.$search.'%');
                    })
                    ->get();

                $pdf = Pdf::loadView('admin.exports.barang-pdf', [
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

    public function stockAlert()
    {
        $threshold = 10;
        $barangs = Barang::with(['kategori', 'distributor'])
                        ->where('stok', '<', $threshold)
                        ->orderBy('stok', 'asc')
                        ->get();

        return view('admin.barang.stock_alert', compact('barangs', 'threshold'));
    }



}
