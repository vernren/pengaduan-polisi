<?php
// app/Http/Controllers/PengaduanController.php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\FotoPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::where('user_id', auth()->id())
            ->with('foto', 'petugas')
            ->latest()
            ->paginate(10);
            
        return view('pengaduan.index', compact('pengaduan'));
    }

    public function create()
    {
        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:50',
            'lokasi' => 'required|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'tanggal_kejadian' => 'required|date|before_or_equal:today',
            'kategori_utama' => 'required|in:informasi,pengaduan,permintaan',
            'sub_kategori' => 'required|string|max:100',
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'deskripsi.min' => 'Deskripsi minimal 50 karakter',
            'tanggal_kejadian.before_or_equal' => 'Tanggal kejadian tidak boleh di masa depan',
            'latitude.required' => 'Silakan pilih lokasi pada peta',
            'longitude.required' => 'Silakan pilih lokasi pada peta',
        ]);

        // Validasi sub kategori sesuai kategori utama
        $kategoriOptions = Pengaduan::getKategoriOptions();
        if (!isset($kategoriOptions[$validated['kategori_utama']]['sub'][$validated['sub_kategori']])) {
            return back()->withErrors(['sub_kategori' => 'Sub kategori tidak valid'])->withInput();
        }

        $pengaduan = Pengaduan::create([
            'user_id' => auth()->id(),
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi' => $validated['lokasi'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'tanggal_kejadian' => $validated['tanggal_kejadian'],
            'kategori_utama' => $validated['kategori_utama'],
            'sub_kategori' => $validated['sub_kategori'],
            'status' => 'pending',
        ]);

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $foto) {
                $path = $foto->store('pengaduan', 'public');
                
                FotoPengaduan::create([
                    'pengaduan_id' => $pengaduan->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dibuat!');
    }

    public function show(Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== auth()->id() && !auth()->user()->isPetugas()) {
            abort(403);
        }

        $pengaduan->load('foto', 'user', 'petugas');
        return view('pengaduan.show', compact('pengaduan'));
    }
}