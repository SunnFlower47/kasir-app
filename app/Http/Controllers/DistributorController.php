<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index()
    {
        $distributors = Distributor::all();
        return view('distributor.index', compact('distributors'));
    }

    public function create()
    {
        return view('distributor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Distributor::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('distributor.index')->with('success', 'Distributor berhasil ditambahkan!');
    }

    public function show($id)
    {
        $distributor = Distributor::findOrFail($id);
        return view('distributor.show', compact('distributor'));
    }

    public function edit($id)
    {
        $distributor = Distributor::findOrFail($id);
        return view('distributor.edit', compact('distributor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $distributor = Distributor::findOrFail($id);
        $distributor->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('distributor.index')->with('success', 'Distributor berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $distributor = Distributor::findOrFail($id);
        $distributor->delete();

        return redirect()->route('distributor.index')->with('success', 'Distributor berhasil dihapus!');
    }
}
