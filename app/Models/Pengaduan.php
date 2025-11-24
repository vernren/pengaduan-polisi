<?php
// app/Models/Pengaduan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';

    protected $fillable = [
        'user_id', 'judul', 'deskripsi', 'lokasi', 'latitude', 'longitude',
        'tanggal_kejadian', 'kategori_utama', 'sub_kategori', 
        'status', 'tanggapan', 'petugas_id'
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Definisi kategori dan sub kategori
    public static function getKategoriOptions()
    {
        return [
            'informasi' => [
                'label' => 'Informasi',
                'sub' => [
                    'pembuatan_sim' => 'Pembuatan SIM',
                    'perpanjangan_sim' => 'Perpanjangan SIM',
                    'pembuatan_skck' => 'Pembuatan SKCK',
                    'laporan_kehilangan' => 'Laporan Kehilangan',
                    'surat_keterangan' => 'Surat Keterangan',
                    'izin_keramaian' => 'Izin Keramaian',
                    'informasi_umum' => 'Informasi Umum',
                ]
            ],
            'pengaduan' => [
                'label' => 'Pengaduan',
                'sub' => [
                    'kecelakaan_lalu_lintas' => 'Kecelakaan Lalu Lintas',
                    'pencurian' => 'Pencurian',
                    'penipuan' => 'Penipuan',
                    'kekerasan' => 'Kekerasan/Penganiayaan',
                    'narkoba' => 'Narkoba/NAPZA',
                    'perjudian' => 'Perjudian',
                    'pelanggaran_lalu_lintas' => 'Pelanggaran Lalu Lintas',
                    'gangguan_kamtibmas' => 'Gangguan Kamtibmas',
                    'kejahatan_siber' => 'Kejahatan Siber',
                    'pengaduan_lainnya' => 'Lainnya',
                ]
            ],
            'permintaan' => [
                'label' => 'Permintaan',
                'sub' => [
                    'pengawalan' => 'Pengawalan',
                ]
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function foto()
    {
        return $this->hasMany(FotoPengaduan::class);
    }

    public function getStatusBadgeClass()
    {
        switch ($this->status) {
            case 'pending':
                return 'bg-yellow-100 text-yellow-800';
            case 'diproses':
                return 'bg-blue-100 text-blue-800';
            case 'selesai':
                return 'bg-green-100 text-green-800';
            case 'ditolak':
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    public function getStatusLabel()
    {
        switch ($this->status) {
            case 'pending':
                return 'Menunggu';
            case 'diproses':
                return 'Diproses';
            case 'selesai':
                return 'Selesai';
            case 'ditolak':
                return 'Ditolak';
            default:
                return 'Unknown';
        }
    }

    public function getKategoriLabel()
    {
        $kategori = self::getKategoriOptions();
        return $kategori[$this->kategori_utama]['label'] ?? ucfirst($this->kategori_utama);
    }

    public function getSubKategoriLabel()
    {
        $kategori = self::getKategoriOptions();
        if (isset($kategori[$this->kategori_utama]['sub'][$this->sub_kategori])) {
            return $kategori[$this->kategori_utama]['sub'][$this->sub_kategori];
        }
        return ucfirst(str_replace('_', ' ', $this->sub_kategori));
    }
}