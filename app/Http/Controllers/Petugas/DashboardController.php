<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil status dari query string (mis. ?status=pending). default 'all' = semua status.
        $status = $request->query('status', 'all');

        // Daftar status valid (pastikan ini sesuai dengan nilai di DB)
        $validStatuses = ['pending', 'diproses', 'selesai', 'ditolak'];

        // Statistik counts untuk cards
        $stats = [
            'pending'  => Pengaduan::where('status', 'pending')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai'  => Pengaduan::where('status', 'selesai')->count(),
            'total'    => Pengaduan::count(),
        ];

        // Query dasar dengan relasi yang dibutuhkan
        $query = Pengaduan::with('user', 'foto')->latest();

        // Terapkan filter jika status valid dan bukan 'all'
        if ($status !== 'all' && in_array($status, $validStatuses, true)) {
            $query->where('status', $status);
        }

        // Paginate dan pertahankan query string (kecuali page)
        $pengaduan = $query->paginate(15)->appends($request->except('page'));

        return view('petugas.dashboard', compact('stats', 'pengaduan'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load('user', 'foto', 'petugas');
        return view('petugas.show', compact('pengaduan'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'tanggapan' => 'nullable|string',
        ]);

        $pengaduan->update([
            'status' => $validated['status'],
            'tanggapan' => $validated['tanggapan'] ?? null,
            'petugas_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui!');
    }
}
