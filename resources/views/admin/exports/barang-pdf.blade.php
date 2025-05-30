<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 20px; text-align: right; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Tanggal: {{ date('d F Y', strtotime($date)) }}</p>
        @if($search)
        <p>Filter Pencarian: "{{ $search }}"</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Kode</th>
                <th width="10%">Barcode</th>
                <th width="15%">Nama Barang</th>
                <th width="10%">Kategori</th>
                <th width="10%">Distributor</th>
                <th width="10%" class="text-right">Harga Modal</th>
                <th width="10%" class="text-right">Harga Jual</th>
                <th width="5%" class="text-center">Stok</th>
                <th width="5%" class="text-center">Satuan</th>
                <th width="10%" class="text-center">Expired</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $key => $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->kode_barang }}</td>
                <td>{{ $item->barcode ?? '-' }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->kategori->nama ?? '-' }}</td>
                <td>{{ $item->distributor->nama ?? '-' }}</td>
                <td class="text-right">{{ number_format($item->harga_modal, 2, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->harga_jual, 2, ',', '.') }}</td>
                <td class="text-center">{{ $item->stok }}</td>
                <td class="text-center">{{ $item->satuan }}</td>
                <td class="text-center">
    {{ $item->expired_at ? \Carbon\Carbon::parse($item->expired_at)->format('d-m-Y') : '-' }}
</td>

            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d-m-Y H:i:s') }}
    </div>
</body>
</html>
