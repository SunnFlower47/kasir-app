<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        $query = Barang::with(['kategori', 'distributor'])
            ->orderBy('kode_barang', 'asc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%'.$this->search.'%')
                  ->orWhere('kode_barang', 'like', '%'.$this->search.'%')
                  ->orWhere('barcode', 'like', '%'.$this->search.'%');
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Barcode',
            'Nama Barang',
            'Kategori',
            'Distributor',
            'Harga Modal',
            'Harga Jual',
            'Stok',
            'Satuan',
            'Keterangan',
            'Tanggal Expired'
        ];
    }

    public function map($barang): array
{
    return [
        $barang->kode_barang,
        $barang->barcode ?? '-',
        $barang->nama,
        $barang->kategori->nama ?? '-',
        $barang->distributor->nama ?? '-',
        number_format($barang->harga_modal, 2, ',', '.'),
        number_format($barang->harga_jual, 2, ',', '.'),
        $barang->stok,
        $barang->satuan,
        $barang->keterangan ?? '-',
        $barang->expired_at ? \Carbon\Carbon::parse($barang->expired_at)->format('d-m-Y') : '-'
    ];
}

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A:K' => ['alignment' => ['wrapText' => true]],
            'F:G' => ['numberFormat' => ['formatCode' => '#,##0.00']],
        ];
    }
}
