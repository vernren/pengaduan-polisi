<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use App\Exports\PengaduanExport;
use App\Exports\PengaduanExportWord;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function download(Request $request)
    {
        $query = Pengaduan::with(['user', 'petugas']);

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->kategori_utama) {
            $query->where('kategori_utama', $request->kategori_utama);
        }

        if ($request->sub_kategori) {
            $query->where('sub_kategori', $request->sub_kategori);
        }

        if ($request->tanggal_mulai) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->tanggal_selesai) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $data = $query->get();

        if ($request->format === 'excel') {
            return Excel::download(
                new PengaduanExport($data),
                'laporan_pengaduan.xlsx'
            );
        }

        if ($request->format === 'word') {
            return (new PengaduanExportWord($data))->download();
        }

        abort(404);
    }
}
