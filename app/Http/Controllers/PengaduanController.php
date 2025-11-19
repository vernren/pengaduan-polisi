<?php

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
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'tanggal_kejadian' => 'required|date',
            'kategori' => 'required|in:pencurian,kekerasan,narkoba,lalu_lintas,lainnya',
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pengaduan = Pengaduan::create([
            'user_id' => auth()->id(),
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi' => $validated['lokasi'],
            'tanggal_kejadian' => $validated['tanggal_kejadian'],
            'kategori' => $validated['kategori'],
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
