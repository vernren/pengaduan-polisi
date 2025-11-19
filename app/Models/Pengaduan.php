<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';

    protected $fillable = [
        'user_id', 'judul', 'deskripsi', 'lokasi', 'tanggal_kejadian',
        'kategori', 'status', 'tanggapan', 'petugas_id'
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',
    ];

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

    // ✅ Versi aman untuk PHP 7
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
}
