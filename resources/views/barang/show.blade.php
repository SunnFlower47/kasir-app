@extends('layouts.admin')

@section('title', 'Detail Barang')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Barang</h1>
        <a href="{{ route('barang.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Daftar Barang
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-box"></i> {{ $barang->nama }}
                <span class="badge badge-light ml-2">{{ $barang->kode_barang }}</span>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">Barcode</th>
                                    <td>
                                        @if($barang->barcode)
                                            {{ $barang->barcode }}
                                            <button class="btn btn-sm btn-outline-primary ml-2" onclick="printBarcode('{{ $barang->barcode }}')">
                                                <i class="fas fa-print"></i> Cetak
                                            </button>
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Harga Modal</th>
                                    <td>Rp {{ number_format($barang->harga_modal, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Harga Jual</th>
                                    <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Stok Tersedia</th>
                                    <td>
                                        <span class="{{ $barang->stok < 5 ? 'text-danger font-weight-bold' : '' }}">
                                            {{ $barang->stok }} {{ $barang->satuan }}
                                        </span>
                                        @if($barang->stok < 5)
                                            <span class="badge badge-warning ml-2">Stok Rendah!</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Satuan</th>
                                    <td>{{ $barang->satuan ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">Distributor</th>
                                    <td>{{ $barang->distributor->nama ?? 'Tidak ada' }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>{{ $barang->kategori->nama ?? 'Tidak ada' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Expired</th>
                                    <td>
                                        @if ($barang->expired_at)
                                            {{ \Carbon\Carbon::parse($barang->expired_at)->isoFormat('D MMMM Y') }}
                                            @if(\Carbon\Carbon::parse($barang->expired_at)->isPast())
                                                <span class="badge badge-danger ml-2">Kadaluarsa!</span>
                                            @elseif(\Carbon\Carbon::parse($barang->expired_at)->diffInDays() < 30)
                                                <span class="badge badge-warning ml-2">Akan kadaluarsa</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Belum ada</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>{{ $barang->keterangan ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Ditambahkan</th>
                                    <td>{{ $barang->created_at->isoFormat('D MMMM Y, HH:mm') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diupdate</th>
                                    <td>{{ $barang->updated_at->isoFormat('D MMMM Y, HH:mm') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Barang
                        </a>
                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus Barang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function printBarcode(barcode) {
        // Implement barcode printing functionality here
        alert('Mencetak barcode: ' + barcode);
        // You would typically use a barcode printing library here
    }
</script>
@endpush
@endsection
