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

        if ($status !== 'all' && in_array($status, $validStatuses)) {
            $query->where('status', $status);
        }

        $pengaduan = $query->paginate(15)->withQueryString();

        return view('petugas.dashboard', compact('stats', 'pengaduan'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load('user', 'foto');
        return view('petugas.show', compact('pengaduan'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'status'        => 'required|in:pending,diproses,selesai,ditolak',
            'nama_petugas'  => 'required|string|max:100',
            'tanggapan'     => 'nullable|string',
        ]);

        $pengaduan->update($validated);

        return back()->with('success', 'Pengaduan berhasil diperbarui');
    }

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
            ->with('success', 'Pengaduan berhasil dihapus');
    }
}
