@extends('layouts.admin')

@section('title', 'Detail Barang')

@section('content')
    <div class="container">
        <h1 class="mb-4">Detail Barang: {{ $barang->nama }}</h1>

        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item"><strong>Kode Barang:</strong> {{ $barang->kode_barang }}</li>
                    <li class="list-group-item"><strong>Nama:</strong> {{ $barang->nama }}</li>
                    <li class="list-group-item"><strong>Barcode:</strong> {{ $barang->barcode ?? 'Tidak ada' }}</li>
                    <li class="list-group-item"><strong>Harga Modal:</strong> {{ number_format($barang->harga_modal, 2) }}</li>
                    <li class="list-group-item"><strong>Harga Jual:</strong> {{ number_format($barang->harga_jual, 2) }}</li>
                    <li class="list-group-item"><strong>Stok:</strong> {{ $barang->stok }}</li>
                    <li class="list-group-item"><strong>Satuan:</strong> {{ $barang->satuan }}</li>
                    <li class="list-group-item"><strong>Keterangan:</strong> {{ $barang->keterangan ?? 'Tidak ada' }}</li>
                    <li class="list-group-item"><strong>Expired:</strong>
                        @if ($barang->expired_at)
                            {{ \Carbon\Carbon::parse($barang->expired_at)->format('d-m-Y') }}
                        @else
                            Belum ada
                        @endif
                    </li>
                    <li class="list-group-item"><strong>Distributor:</strong> {{ $barang->distributor->nama ?? 'Tidak ada' }}</li>
                    <li class="list-group-item"><strong>Kategori:</strong> {{ $barang->kategori->nama ?? 'Tidak ada' }}</li>
                </ul>
            </div>
        </div>

        <a href="{{ route('barang.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Barang</a>
    </div>
@endsection
