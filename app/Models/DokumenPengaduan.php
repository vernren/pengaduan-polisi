<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPengaduan extends Model
{
    protected $table = 'dokumen_pengaduan';

    protected $fillable = [
        'pengaduan_id',
        'file_path',
        'keterangan'
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
