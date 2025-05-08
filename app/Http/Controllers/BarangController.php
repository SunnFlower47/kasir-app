<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Distributor;
use App\Models\Kategori;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::with('distributor', 'kategori')->get();
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
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang',
            'nama' => 'required',
            'barcode' => 'nullable',
            'harga_modal' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
            'satuan' => 'required',
            'id_distributor' => 'nullable|exists:distributors,id',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'keterangan' => 'nullable',
            'expired_at' => 'nullable|date',
        ]);

        Barang::create($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    $request->validate([
        'kode_barang' => 'required|unique:barangs,kode_barang,' . $barang->id,
        'nama' => 'required',
        'harga_modal' => 'required|numeric',
        'harga_jual' => 'required|numeric',
        'stok' => 'required|integer',
        'satuan' => 'required',
    ]);

    $barang->update($request->all());

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
}
