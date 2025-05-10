@extends('layouts.admin')

@section('title', 'Daftar Barang')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Barang</h1>
        <div class="d-flex">
            <form action="{{ route('barang.index') }}" method="GET" class="form-inline mr-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari barang..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown">
                    <i class="fas fa-download"></i> Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                    <li class="dropdown-header">Format Export</li>
                    <li><a class="dropdown-item" href="{{ route('barang.export', ['format' => 'xlsx']) }}">
                        <i class="fas fa-file-excel text-success me-2"></i> Excel</a></li>
                    <li><a class="dropdown-item" href="{{ route('barang.export', ['format' => 'csv']) }}">
                        <i class="fas fa-file-csv text-primary me-2"></i> CSV</a></li>
                    <li><a class="dropdown-item" href="{{ route('barang.export', ['format' => 'pdf']) }}">
                        <i class="fas fa-file-pdf text-danger me-2"></i> PDF</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="{{ route('barang.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i> Tambah Barang
            </a>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                    <li class="dropdown-header">Filter Berdasarkan</li>
                    <li><a class="dropdown-item" href="{{ route('barang.index', ['filter' => 'stok_rendah']) }}">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i> Stok Rendah (&lt;10)</a></li>
                    <li><a class="dropdown-item" href="{{ route('barang.index', ['filter' => 'akan_expired']) }}">
                        <i class="fas fa-clock text-info me-2"></i> Akan Expired (30 hari)</a></li>
                    <li><a class="dropdown-item" href="{{ route('barang.index', ['filter' => 'sudah_expired']) }}">
                        <i class="fas fa-times-circle text-danger me-2"></i> Sudah Expired</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('barang.index') }}">
                        <i class="fas fa-sync-alt me-2"></i> Reset Filter</a></li>
                </ul>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th>Expired</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangs as $index => $barang)
                        <tr>
                            <td>{{ $barangs->firstItem() + $index }}</td>
                            <td>
                                <span class="text-primary">{{ $barang->kode_barang }}</span>
                                @if($barang->barcode)
                                    <div><small class="text-muted">{{ $barang->barcode }}</small></div>
                                @endif
                            </td>
                            <td>{{ $barang->nama }}</td>
                            <td>
                                <div>Harga Modal: <span class="text-primary">Rp {{ number_format($barang->harga_modal, 0, ',', '.') }}</span></div>
                                <div>Harga Jual : <span class="text-success">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</span></div>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $barang->stok > 20 ? 'bg-success' : ($barang->stok > 5 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $barang->stok }} {{ $barang->satuan }}
                                </span>
                            </td>
                            <td>{{ $barang->kategori->nama ?? '-' }}</td>
                            <td>
                            @if($barang->expired_at)
                                @php
                                    $expired = \Carbon\Carbon::parse($barang->expired_at)->endOfDay();
                                    $today = \Carbon\Carbon::now();
                                    $daysDifference = $today->diffInDays($expired, false);
                                    if ($daysDifference < 0) {
                                        $class = 'text-danger fw-bold';
                                        $badge = '<span class="badge bg-danger ms-1">Expired</span>';
                                        $tooltip = 'Expired ' . abs($daysDifference) . ' days ago';
                                    } elseif ($daysDifference <= 30) {
                                        $class = 'text-warning fw-bold';
                                        $badge = '<span class="badge bg-warning text-dark ms-1">Akan Exp</span>';
                                        $tooltip = 'Will expire in ' . $daysDifference . ' days';
                                    } else {
                                        $class = 'text-success';
                                        $badge = '';
                                        $tooltip = 'Will expire in ' . $daysDifference . ' days';
                                    }
                                @endphp
                                <span class="{{ $class }}" data-bs-toggle="tooltip" title="{{ $tooltip }}">
                                    {{ $expired->format('d M Y') }}
                                </span>
                                {!! $badge !!}
                            @else
                                <span class="text-muted" data-bs-toggle="tooltip" title="No expiration date">-</span>
                            @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center flex-wrap gap-1">
                                    <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                    <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger btn-delete" data-name="{{ $barang->nama }}">
                                            <i class="fas fa-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                @if(request('search'))
                                    <h4 class="text-muted">Tidak ditemukan hasil untuk "{{ request('search') }}"</h4>
                                    <a href="{{ route('barang.index') }}" class="btn btn-secondary mt-2">
                                        <i class="fas fa-undo me-1"></i> Reset Pencarian
                                    </a>
                                @else
                                    <h4 class="text-muted">Belum ada data barang</h4>
                                    <a href="{{ route('barang.create') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus me-1"></i> Tambah Barang
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Improved Pagination --}}
            @if($barangs->hasPages())
            <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-muted mb-2 mb-md-0">
                    Menampilkan <strong>{{ $barangs->firstItem() }}</strong> sampai <strong>{{ $barangs->lastItem() }}</strong> dari <strong>{{ $barangs->total() }}</strong> data
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        {{-- Previous Page Link --}}
                        @if ($barangs->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $barangs->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($barangs->getUrlRange(1, $barangs->lastPage()) as $page => $url)
                            @if ($page == $barangs->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($barangs->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $barangs->nextPageUrl() }}" rel="next">&raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">&raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    .table td, .table th { vertical-align: middle; }
    .badge { font-size: 0.85em; padding: 0.35em 0.65em; }
    .pagination { margin-bottom: 0; }
    .pagination .page-item.active .page-link {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    .pagination .page-link {
        color: #4e73df;
    }
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
    }
    .swal2-popup { font-size: 1.2rem !important; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Tooltip init
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Message with SweetAlert2
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'BERHASIL',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
    });
    @elseif(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'GAGAL!',
        text: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 2000
    });
    @endif

    // SweetAlert2 delete confirmation
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data ini akan dihapus dan tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').submit();
                }
            });
        });
    });
</script>
@endpush

@endsection
