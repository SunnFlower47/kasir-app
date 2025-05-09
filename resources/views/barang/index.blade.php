@extends('layouts.admin')

@section('title', 'Daftar Barang')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Barang</h1>

    <a href="{{ route('barang.create') }}" class="btn btn-success mb-3">+ Tambah Barang</a>

    @if($barangs->count())
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama</th>
                    <th>Harga Modal</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Distributor</th>
                    <th>Kategori</th>
                    <th width="130px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangs as $barang)
                    <tr>
                        <td>{{ $barang->kode_barang }}</td>
                        <td>{{ $barang->nama }}</td>
                        <td>Rp {{ number_format($barang->harga_modal, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                        <td>{{ $barang->stok }}</td>
                        <td>{{ $barang->distributor->nama ?? '-' }}</td>
                        <td>{{ $barang->kategori->nama ?? '-' }}</td>
                        <td>
                            <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="alert alert-info">Belum ada data barang.</div>
    @endif
</div>
@endsection
