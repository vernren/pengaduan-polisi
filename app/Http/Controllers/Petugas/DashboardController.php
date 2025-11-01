<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending' => Pengaduan::where('status', 'pending')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'total' => Pengaduan::count(),
        ];

        $pengaduan = Pengaduan::with('user', 'foto')
            ->latest()
            ->paginate(15);

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
            'tanggapan' => $validated['tanggapan'],
            'petugas_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui!');
    }
}
