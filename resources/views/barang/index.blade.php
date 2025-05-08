<!-- resources/views/barang/index.blade.php -->
@extends('layouts.admin')  <!-- Menyertakan layout admin yang sudah ada -->

@section('content')
    <h1>Daftar Barang</h1>
    <a href="{{ route('barang.create') }}" class="btn btn-success">Tambah Barang</a><br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama</th>
                <th>Harga Modal</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Distributor</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $barang)
                <tr>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->nama }}</td>
                    <td>{{ number_format($barang->harga_modal, 2) }}</td>
                    <td>{{ number_format($barang->harga_jual, 2) }}</td>
                    <td>{{ $barang->stok }}</td>
                    <td>{{ $barang->distributor->nama ?? 'N/A' }}</td>
                    <td>{{ $barang->kategori->nama ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


@endsection
