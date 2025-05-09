@extends('layouts.admin')

@section('title', 'Tambah Distributor')

@section('content')
    <div class="container">
        <h1 class="mb-4">Tambah Distributor</h1>

        <form action="{{ route('distributor.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Distributor</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control">
            </div>

            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" name="telepon" class="form-control">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('distributor.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
