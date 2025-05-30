@extends('layouts.admin')

@section('title', 'Daftar Kategori')

@section('content')
    <h1>Daftar Kategori</h1>
    <a href="{{ route('admin.kategori.create') }}">Tambah Kategori</a>
    <table border="1">
        <tr>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
        @foreach ($kategoris as $kategori)
        <tr>
            <td>{{ $kategori->nama }}</td>
            <td>
                <a href="{{ route('admin.kategori.edit', $kategori->id) }}">Edit</a>
                <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
