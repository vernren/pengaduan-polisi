<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',

        // lokasi pengaduan (1 titik)
        'lokasi',
        'latitude',
        'longitude',

        // lokasi permintaan pengawalan (2 titik)
        'start_latitude',
        'start_longitude',
        'end_latitude',
        'end_longitude',

        'tanggal_kejadian',
        'kategori_utama',
        'sub_kategori',
        'status',
        'tanggapan',
        'petugas_id',
        'nama_petugas',

        // =========================
        // ✅ FEEDBACK MASYARAKAT
        // =========================
        'rating',
        'feedback',
        'feedback_at',
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',

        // 1 titik
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',

        // 2 titik
        'start_latitude' => 'decimal:8',
        'start_longitude' => 'decimal:8',
        'end_latitude' => 'decimal:8',
        'end_longitude' => 'decimal:8',

        // =========================
        // ✅ CAST FEEDBACK
        // =========================
        'feedback_at' => 'datetime',
    ];

    /**
     * =========================
     * KATEGORI & SUB KATEGORI
     * =========================
     */
    public static function getKategoriOptions()
    {
        return [
            'pengaduan' => [
                'label' => 'Pengaduan',
                'sub' => [
                    'kecelakaan_lalu_lintas' => 'Kecelakaan Lalu Lintas',
                    'pencurian' => 'Pencurian',
                    'penipuan' => 'Penipuan',
                    'kekerasan' => 'Kekerasan / Penganiayaan',
                    'narkoba' => 'Narkoba / NAPZA',
                    'perjudian' => 'Perjudian',
                    'pelanggaran_lalu_lintas' => 'Pelanggaran Lalu Lintas',
                    'gangguan_kamtibmas' => 'Gangguan Kamtibmas',
                    'kejahatan_siber' => 'Kejahatan Siber',
                    'pengaduan_lainnya' => 'Lainnya',
                ],
            ],

            'permintaan' => [
                'label' => 'Permintaan',
                'sub' => [
                    'pengawalan' => 'Pengawalan',
                ],
            ],
        ];
    }

    /**
     * =========================
     * RELATIONSHIP
     * =========================
     */
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

    /**
     * =========================
     * HELPER METHOD
     * =========================
     */
    public function isPermintaan()
    {
        return $this->kategori_utama === 'permintaan';
    }

    public function isPengaduan()
    {
        return $this->kategori_utama === 'pengaduan';
    }

    public function getKategoriLabel()
    {
        $kategori = self::getKategoriOptions();
        return $kategori[$this->kategori_utama]['label'] ?? ucfirst($this->kategori_utama);
    }

    public function getSubKategoriLabel()
    {
        $kategori = self::getKategoriOptions();

        if (
            isset($kategori[$this->kategori_utama]) &&
            isset($kategori[$this->kategori_utama]['sub'][$this->sub_kategori])
        ) {
            return $kategori[$this->kategori_utama]['sub'][$this->sub_kategori];
        }

        return ucfirst(str_replace('_', ' ', $this->sub_kategori));
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

    /**
     * =========================
     * ✅ HELPER FEEDBACK
     * =========================
     */

    // apakah pengaduan sudah bisa diberi feedback
public function canGiveFeedback()
{
    return $this->status === 'selesai'
        && is_null($this->feedback)
        && is_null($this->rating);
}


    // apakah pengaduan sudah ada feedback
    public function hasFeedback()
    {
        return !is_null($this->feedback);
    }
}
