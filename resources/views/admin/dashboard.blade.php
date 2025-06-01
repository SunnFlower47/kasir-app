@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Dashboard Admin</h1>

    {{-- Info Cards (Link to Details) --}}
    <div class="row g-4">
        <div class="col-md-3">
            <a href="{{ route('admin.barang.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3"><i class="bi bi-box-seam fs-1"></i></div>
                        <div>
                            <h6 class="mb-1">Total Barang</h6>
                            <h4 class="mb-0">{{ $totalBarang ?? 0 }}</h4>
                            <small>Barang terdaftar</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('admin.kategori.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3"><i class="bi bi-tags fs-1"></i></div>
                        <div>
                            <h6 class="mb-1">Total Kategori</h6>
                            <h4 class="mb-0">{{ $totalKategori ?? 0 }}</h4>
                            <small>Kategori produk</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('admin.distributor.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3"><i class="bi bi-truck fs-1"></i></div>
                        <div>
                            <h6 class="mb-1">Total Distributor</h6>
                            <h4 class="mb-0">{{ $totalDistributor ?? 0 }}</h4>
                            <small>Distributor aktif</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
@canSee(['superadmin'])
        <div class="col-md-3">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 bg-info text-white h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3"><i class="bi bi-people fs-1"></i></div>
                        <div>
                            <h6 class="mb-1">Total User</h6>
                            <h4 class="mb-0">{{ $totalUser ?? 0 }}</h4>
                            <small>Pengguna terdaftar</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
@endcanSee
    </div>
</div>
@endsection
