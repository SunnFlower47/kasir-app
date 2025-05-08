@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <h1>Edit Kategori</h1>
    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="nama">Nama Kategori</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama', $kategori->nama) }}" required>
        </div>
        <button type="submit">Update</button>
    </form>
@endsection
