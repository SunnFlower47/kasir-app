@extends('layouts.admin')

@section('title', 'Daftar Barang')



@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Barang</h1>

        <div class="d-flex">
            {{-- Pencarian
            <form action="{{ route('admin.barang.index') }}" method="GET" class="form-inline me-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari barang..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form> --}}

            {{-- Export --}}
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" id="exportDropdown" data-bs-toggle="dropdown">
                    <i class="fas fa-download me-1"></i> Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                    <li class="dropdown-header">Format Export</li>
                    <li><a class="dropdown-item" href="{{ route('admin.barang.export', ['format' => 'xlsx']) }}"><i class="fas fa-file-excel text-success me-2"></i> Excel</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.barang.export', ['format' => 'csv']) }}"><i class="fas fa-file-csv text-primary me-2"></i> CSV</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.barang.export', ['format' => 'pdf']) }}"><i class="fas fa-file-pdf text-danger me-2"></i> PDF</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Card Tabel Barang --}}
    <div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <a href="{{ route('admin.barang.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i> Tambah Barang
        </a>

        <div class="dropdown ms-auto">
            <button class="btn btn-outline-secondary dropdown-toggle" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-filter me-1"></i> Filter
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                <li class="dropdown-header">Filter Berdasarkan</li>
                <li><a class="dropdown-item" href="{{ route('admin.barang.index', ['filter' => 'stok_rendah']) }}"><i class="fas fa-exclamation-triangle text-warning me-2"></i> Stok Rendah (&lt;10)</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.barang.index', ['filter' => 'akan_expired']) }}"><i class="fas fa-clock text-info me-2"></i> Akan Expired (30 hari)</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.barang.index', ['filter' => 'sudah_expired']) }}"><i class="fas fa-times-circle text-danger me-2"></i> Sudah Expired</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('admin.barang.index') }}"><i class="fas fa-sync-alt me-2"></i> Reset Filter</a></li>
            </ul>
        </div>
    </div>


        {{-- Tabel Barang --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>barcode</th>
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
                                <span class="text-primary">{{ $barang->barcode }}</span>
                            </td>
                            <td>{{ $barang->nama }}</td>
                            <td>
                                <div>Modal: <span class="text-primary">Rp {{ number_format($barang->harga_modal, 0, ',', '.') }}</span></div>
                                <div>Jual: <span class="text-success">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</span></div>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $barang->stok > 10 ? 'bg-success' : ($barang->stok > 5 ? 'bg-warning ' : 'bg-danger') }}">
                                    {{ $barang->stok }} {{ $barang->satuan }}
                                </span>
                            </td>
                            <td>{{ $barang->kategori->nama ?? '-' }}</td>
                            <td>
                                @if($barang->expired_at)
                                    @php
                                        $expired = \Carbon\Carbon::parse($barang->expired_at)->endOfDay();
                                        $today = \Carbon\Carbon::now();
                                        $daysDiff = $today->diffInDays($expired, false);
                                        $badge = '';
                                        $class = 'text-success';
                                        $tooltip = 'Kadaluarsa dalam ' . $daysDiff . ' hari';

                                        if ($daysDiff < 0) {
                                            $class = 'text-danger';
                                            $badge = '<span class="badge bg-danger ms-1">Expired</span>';
                                            $tooltip = 'Kadaluarsa ' . abs($daysDiff) . ' hari lalu';
                                        } elseif ($daysDiff <= 30) {
                                            $class = 'text-warning';
                                            $badge = '<span class="badge bg-warning text-dark ms-1">Akan Exp</span>';
                                        }
                                    @endphp
                                    <span class="{{ $class }}" data-bs-toggle="tooltip" title="{{ $tooltip }}">
                                        {{ $expired->format('d M Y') }}
                                    </span>
                                    {!! $badge !!}
                                @else
                                    <span class="text-muted" data-bs-toggle="tooltip" title="Tidak ada tanggal kadaluarsa">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center flex-wrap gap-1">
                                    <a href="{{ route('admin.barang.show', $barang->id) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                    <a href="{{ route('admin.barang.edit', $barang->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST" class="delete-form d-inline">
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
                        {{-- <tr>
                            <td colspan="8" class="text-center py-4">
                                @if(request('search'))
                                    <h4 class="text-muted">Tidak ditemukan hasil untuk "{{ request('search') }}"</h4>
                                    <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary mt-2">
                                        <i class="fas fa-undo me-1"></i> Reset Pencarian
                                    </a>
                                @else
                                    <h4 class="text-muted">Belum ada data barang</h4>
                                    <a href="{{ route('admin.barang.create') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus me-1"></i> Tambah Barang
                                    </a>
                                @endif
                            </td>
                        </tr> --}}
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            {{-- @if($barangs->hasPages())
            <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-muted mb-2 mb-md-0">
                    Menampilkan <strong>{{ $barangs->firstItem() }}</strong> - <strong>{{ $barangs->lastItem() }}</strong> dari <strong>{{ $barangs->total() }}</strong> data
                </div>
                <nav>
                    {{ $barangs->links('pagination::bootstrap-4') }}
                </nav>
            </div>
            @endif --}}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table td, .table th { vertical-align: middle; }
    .badge { font-size: 0.85em; padding: 0.35em 0.65em; }
    /* .pagination { margin-bottom: 0; }
    .pagination .page-item.active .page-link {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    .pagination .page-link {
        color: #4e73df;
    }
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
    } */
    .swal2-container {
        z-index: 99999 !important;
    }
    .swal2-container {
        z-index: 99999 !important;
    }

    .swal2-popup {
        font-size: 1.4rem !important;
    }

    .swal2-toast {
        font-size: 1.2rem !important;
    }
</style>

@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Inisialisasi DataTables
    $('#dataTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "lengthChange": true,
        "pageLength": 10,
        "language": {
            "emptyTable": "Tidak ada data tersedia",
            "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
            "infoEmpty": "Menampilkan 0 hingga 0 dari 0 data",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "search": "Cari:",
            "zeroRecords": "Tidak ditemukan data yang sesuai"
        }
    });

    // Tooltip Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Notifikasi session
    @if(session('success'))
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: {!! json_encode(session('success')) !!},
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
    @endif

    @if(session('error'))
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: {!! json_encode(session('error')) !!},
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
    @endif

    // Konfirmasi hapus
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const itemName = $(this).data('name');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: `Data "${itemName}" akan dihapus permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush


