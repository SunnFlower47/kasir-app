@extends('layouts.admin')

@section('title', 'Tambah Barang')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Barang</h1>

    <form action="{{ route('barang.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="kode_barang" class="form-label">Kode Barang</label>
            <input type="text" name="kode_barang" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Barang</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="barcode" class="form-label">Barcode</label>
            <input type="text" name="barcode" class="form-control">
        </div>

        <div class="mb-3">
            <label for="harga_modal" class="form-label">Harga Modal</label>
            <input type="number" name="harga_modal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="harga_jual" class="form-label">Harga Jual</label>
            <input type="number" name="harga_jual" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan</label>
            <input type="text" name="satuan" class="form-control">
        </div>

        <div class="mb-3">
            <label for="id_distributor" class="form-label">Distributor</label>
            <select name="id_distributor" class="form-control" required>
                <option value="">-- Pilih Distributor --</option>
                @foreach($distributors as $distributor)
                    <option value="{{ $distributor->id }}">{{ $distributor->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select name="kategori_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="2"></textarea>
        </div>

        <div class="mb-3">
            <label for="expired_at" class="form-label">Tanggal Expired</label>
            <input type="date" name="expired_at" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
