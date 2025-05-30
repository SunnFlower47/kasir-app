@extends('layouts.admin')

@section('title', 'Daftar Distributor')

@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar Distributor</h1>

        <a href="{{ route('admin.distributor.create') }}" class="btn btn-success mb-3">Tambah Distributor</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Distributor</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($distributors as $distributor)
                    <tr>
                        <td>{{ $distributor->nama }}</td>
                        <td>{{ $distributor->alamat }}</td>
                        <td>{{ $distributor->telepon }}</td>
                        <td>{{ $distributor->email }}</td>
                        <td>
                            <a href="{{ route('admin.distributor.edit', $distributor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.distributor.destroy', $distributor->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus distributor ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Belum ada distributor yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
