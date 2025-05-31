<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


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
            ->orderBy('id', 'asc'); // Urutkan berdasarkan id

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('barcode', 'like', '%' . $this->search . '%'); // Search dengan barcode dan nama
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Barcode',        // Nama kolom tetap Barcode
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
            $barang->barcode ?? '-',                   // Tampilkan barcode di Excel
            $barang->nama,
            $barang->kategori->nama ?? '-',
            $barang->distributor->nama ?? '-',
            number_format($barang->harga_modal, 2, ',', '.'),
            number_format($barang->harga_jual, 2, ',', '.'),
            $barang->stok,
            $barang->satuan,
            $barang->keterangan ?? '-',
            $barang->expired_at ? \Carbon\Carbon::parse($barang->expired_at)->format('d-m-Y') : '-',
        ];
    }

   public function styles(Worksheet $sheet)
{
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

    // Style untuk header (baris 1)
    $sheet->getStyle('A1:J1')->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => ['argb' => 'FFFFFFFF'],
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['argb' => 'FF4A90E2'], // biru muda
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => true,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ]);

    // Border dan alignment untuk semua data (A1 sampai J terakhir)
    $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
        'alignment' => [
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => true,
        ],
    ]);

    // Zebra striping (baris ganjil data mulai dari 2)
    for ($row = 2; $row <= $highestRow; $row++) {
        if ($row % 2 == 0) { // baris genap
            $sheet->getStyle("A{$row}:J{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF2F2F2'); // abu-abu muda
        }
    }

    // Format angka untuk kolom Harga Modal (E) dan Harga Jual (F)
    $sheet->getStyle("E2:F{$highestRow}")->getNumberFormat()->setFormatCode('#,##0.00');

    // Set row height agar wrap text enak terbaca
    for ($row = 1; $row <= $highestRow; $row++) {
        $sheet->getRowDimension($row)->setRowHeight(20);
    }
}
}
