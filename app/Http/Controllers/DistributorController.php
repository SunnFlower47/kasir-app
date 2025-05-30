<?php
namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index()
    {
        $distributors = Distributor::all();
        return view('admin.distributor.index', compact('distributors'));
    }

    public function create()
    {
        return view('admin.distributor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Distributor::create($validated);

        return redirect()->route('admin.distributor.index')->with('success', 'Distributor berhasil ditambahkan.');
    }

    public function edit(Distributor $distributor)
    {
        return view('distributor.edit', compact('distributor'));
    }

    public function update(Request $request, Distributor $distributor)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $distributor->update($validated);

        return redirect()->route('admin.distributor.index')->with('success', 'Distributor berhasil diperbarui.');
    }

    public function destroy(Distributor $distributor)
    {
        $distributor->delete();

        return redirect()->route('admin.distributor.index')->with('success', 'Distributor berhasil dihapus.');
    }
}
