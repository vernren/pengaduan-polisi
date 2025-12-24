<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\FotoPengaduan;
use Illuminate\Http\Request;

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
        /**
         * =========================
         * VALIDASI DASAR
         * =========================
         */
        $baseRules = [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:50',
            'kategori_utama' => 'required|in:pengaduan,permintaan',
            'sub_kategori' => 'required|string|max:100',
            'foto.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ];

        /**
         * =========================
         * VALIDASI TANGGAL
         * =========================
         */
        if ($request->kategori_utama === 'pengaduan') {
            $baseRules['tanggal_kejadian'] = 'required|date|before_or_equal:today';
        } else {
            $baseRules['tanggal_kejadian'] = 'required|date';
        }

        /**
         * =========================
         * VALIDASI LOKASI
         * =========================
         */
        if ($request->kategori_utama === 'pengaduan') {
            $baseRules['lokasi'] = 'required|string|max:500';
            $baseRules['latitude'] = 'required|numeric|between:-90,90';
            $baseRules['longitude'] = 'required|numeric|between:-180,180';
        }

        if ($request->kategori_utama === 'permintaan') {
            $baseRules['start_latitude'] = 'required|numeric|between:-90,90';
            $baseRules['start_longitude'] = 'required|numeric|between:-180,180';
            $baseRules['end_latitude'] = 'required|numeric|between:-90,90';
            $baseRules['end_longitude'] = 'required|numeric|between:-180,180';
        }

        $validated = $request->validate($baseRules);

        /**
         * =========================
         * VALIDASI SUB KATEGORI
         * =========================
         */
        $kategoriOptions = Pengaduan::getKategoriOptions();
        if (
            !isset($kategoriOptions[$validated['kategori_utama']]) ||
            !isset($kategoriOptions[$validated['kategori_utama']]['sub'][$validated['sub_kategori']])
        ) {
            return back()->withErrors(['sub_kategori' => 'Sub kategori tidak valid'])->withInput();
        }

        /**
         * =========================
         * SIMPAN PENGADUAN
         * =========================
         */
        $pengaduanData = [
            'user_id' => auth()->id(),
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal_kejadian' => $validated['tanggal_kejadian'],
            'kategori_utama' => $validated['kategori_utama'],
            'sub_kategori' => $validated['sub_kategori'],
            'status' => 'pending',
        ];

        if ($validated['kategori_utama'] === 'pengaduan') {
            $pengaduanData['lokasi'] = $validated['lokasi'];
            $pengaduanData['latitude'] = $validated['latitude'];
            $pengaduanData['longitude'] = $validated['longitude'];
        }

        if ($validated['kategori_utama'] === 'permintaan') {
            $pengaduanData['start_latitude'] = $validated['start_latitude'];
            $pengaduanData['start_longitude'] = $validated['start_longitude'];
            $pengaduanData['end_latitude'] = $validated['end_latitude'];
            $pengaduanData['end_longitude'] = $validated['end_longitude'];
        }

        $pengaduan = Pengaduan::create($pengaduanData);

        /**
         * =========================
         * SIMPAN FOTO
         * =========================
         */
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $foto) {
                $path = $foto->store('pengaduan', 'public');

                FotoPengaduan::create([
                    'pengaduan_id' => $pengaduan->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dibuat!');
    }

    public function show(Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== auth()->id() && !auth()->user()->isPetugas()) {
            abort(403);
        }

        $pengaduan->load('foto', 'user', 'petugas');
        return view('pengaduan.show', compact('pengaduan'));
    }

    /**
     * ==================================================
     * ✅ TAMBAHAN: SIMPAN FEEDBACK MASYARAKAT
     * ==================================================
     */
    public function storeFeedback(Request $request, Pengaduan $pengaduan)
    {
        // hanya pemilik laporan
        if ($pengaduan->user_id !== auth()->id()) {
            abort(403);
        }

        // hanya jika sudah selesai
        if ($pengaduan->status !== 'selesai') {
            return back()->with('error', 'Feedback hanya dapat diberikan jika pengaduan telah selesai.');
        }

        // tidak boleh isi dua kali
        if ($pengaduan->feedback) {
            return back()->with('error', 'Feedback sudah diberikan.');
        }

        $validated = $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'feedback' => 'required|string|min:10|max:500',
        ]);

        $pengaduan->update([
            'rating'      => $validated['rating'],
            'feedback'    => $validated['feedback'],
            'feedback_at' => now(),
        ]);

        return back()->with('success', 'Terima kasih atas feedback Anda 🙏');
    }
}
