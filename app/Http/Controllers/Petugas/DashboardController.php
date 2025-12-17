<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $validStatuses = ['pending', 'diproses', 'selesai', 'ditolak'];

        $stats = [
            'pending'  => Pengaduan::where('status', 'pending')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai'  => Pengaduan::where('status', 'selesai')->count(),
            'total'    => Pengaduan::count(),
        ];

        $query = Pengaduan::with('user', 'foto')->latest();

        if ($status !== 'all' && in_array($status, $validStatuses, true)) {
            $query->where('status', $status);
        }

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
        'tanggapan' => $validated['tanggapan'],
        'petugas_id' => auth()->id(), // ID petugas login
    ]);

    return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui!');
}

    // ======================
    // ✅ HAPUS PENGADUAN
    // ======================
    public function destroy(Pengaduan $pengaduan)
    {
        foreach ($pengaduan->foto as $foto) {
            if ($foto->file_path && Storage::exists($foto->file_path)) {
                Storage::delete($foto->file_path);
            }
            $foto->delete();
        }

        $pengaduan->delete();

        return redirect()
            ->route('petugas.dashboard')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }
}