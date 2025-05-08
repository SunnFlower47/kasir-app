@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Dashboard Admin</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Barang</h5>
                        <p class="card-text">{{ $totalBarang ?? '0' }} barang</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Kategori</h5>
                        <p class="card-text">{{ $totalKategori ?? '0' }} kategori</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Distributor</h5>
                        <p class="card-text">{{ $totalDistributor ?? '0' }} distributor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
