<?php

namespace App\Exports;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class PengaduanExportWord
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function download()
    {
        $phpWord = new PhpWord();

        // SECTION LANDSCAPE
        $section = $phpWord->addSection([
            'orientation'   => 'landscape',
            'pageSizeW'     => 16838, // A4 Landscape
            'pageSizeH'     => 11906,
            'marginTop'     => 720,
            'marginBottom'  => 720,
            'marginLeft'    => 720,
            'marginRight'   => 720,
        ]);

        // JUDUL
        $section->addText(
            'LAPORAN PENGADUAN MASYARAKAT',
            [
                'bold' => true,
                'size' => 14,
            ],
            [
                'alignment' => 'center',
                'spaceAfter' => 300,
            ]
        );

        // TABEL
        $table = $section->addTable([
            'borderSize'  => 6,
            'borderColor' => '999999',
            'cellMargin'  => 80,
        ]);

        // HEADER TABEL
        $headers = [
            'Nama Pelapor',
            'Judul',
            'Kategori Utama',
            'Sub Kategori',
            'Status',
            'Deskripsi',
            'Lokasi',
            'Tanggal Laporan',
            'Nama Petugas',
        ];

        $table->addRow(900);
        foreach ($headers as $header) {
            $table->addCell(2000)->addText($header, [
                'bold' => true,
                'size' => 9,
            ]);
        }

        // ISI DATA
        foreach ($this->data as $item) {
            $table->addRow();
            $table->addCell()->addText($item->user->name ?? '-');
            $table->addCell()->addText($item->judul);
            $table->addCell()->addText($item->kategori_utama);
            $table->addCell()->addText($item->sub_kategori);
            $table->addCell()->addText($item->getStatusLabel());
            $table->addCell()->addText($item->deskripsi);
            $table->addCell()->addText($item->lokasi);
            $table->addCell()->addText(
                $item->created_at->format('d M Y H:i')
            );
            $table->addCell()->addText(
                $item->petugas->nama_petugas ?? '-'
            );
        }

        // SIMPAN FILE
        $fileName = 'laporan_pengaduan_' . now()->format('Ymd_His') . '.docx';
        $path = storage_path($fileName);

        IOFactory::createWriter($phpWord, 'Word2007')->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
