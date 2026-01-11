<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengaduanExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection(): Collection
    {
        return $this->data->map(function ($item) {
            return [
                $item->user->name,
                $item->judul,
                $item->kategori_utama,
                $item->sub_kategori,
                $item->getStatusLabel(),
                $item->deskripsi,
                $item->lokasi,
                $item->created_at->format('d-m-Y H:i'),
                $item->petugas->nama_petugas ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Pelapor',
            'Judul',
            'Kategori Utama',
            'Sub Kategori',
            'Status',
            'Deskripsi',
            'Lokasi',
            'Tanggal Laporan Dibuat',
            'Nama Petugas',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        // Header
        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '2563EB'],
            ],
        ]);

        // Border semua tabel
        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => 'CBD5E1'],
                ],
            ],
        ]);

        return [];
    }
}

