@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
    <h1>Tambah Kategori</h1>
    <form action="{{ route('admin.kategori.store') }}" method="POST">
        @csrf
        <div>
            <label for="nama">Nama Kategori</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        <button type="submit">Simpan</button>
    </form>
@endsection
