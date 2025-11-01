<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoPengaduan extends Model
{
    protected $table = 'foto_pengaduan';

    protected $fillable = [
        'pengaduan_id', 'file_path', 'keterangan'
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
