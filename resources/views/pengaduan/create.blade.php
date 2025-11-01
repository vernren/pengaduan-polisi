<!-- resources/views/pengaduan/create.blade.php -->
@extends('layouts.app')

@section('title', 'Buat Pengaduan - Pengaduan Polisi')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-purple-600 hover:text-purple-800">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fas fa-file-alt text-purple-600 mr-2"></i>Buat Pengaduan Baru
        </h2>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-heading mr-2"></i>Judul Pengaduan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="judul" value="{{ old('judul') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                    placeholder="Contoh: Pencurian Motor di Parkiran">
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tag mr-2"></i>Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                        <option value="">Pilih Kategori</option>
                        <option value="pencurian" {{ old('kategori') == 'pencurian' ? 'selected' : '' }}>Pencurian</option>
                        <option value="kekerasan" {{ old('kategori') == 'kekerasan' ? 'selected' : '' }}>Kekerasan</option>
                        <option value="narkoba" {{ old('kategori') == 'narkoba' ? 'selected' : '' }}>Narkoba</option>
                        <option value="lalu_lintas" {{ old('kategori') == 'lalu_lintas' ? 'selected' : '' }}>Lalu Lintas</option>
                        <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Prioritas <span class="text-red-500">*</span>
                    </label>
                    <select name="prioritas" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                        <option value="rendah" {{ old('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                        <option value="sedang" {{ old('prioritas', 'sedang') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="tinggi" {{ old('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    </select>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-map-marker-alt mr-2"></i>Lokasi Kejadian <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                        placeholder="Jl. Contoh No. 123, Jakarta">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-calendar mr-2"></i>Tanggal Kejadian <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}" required max="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-align-left mr-2"></i>Deskripsi Kejadian <span class="text-red-500">*</span>
                </label>
                <textarea name="deskripsi" required rows="6"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                    placeholder="Jelaskan kronologi kejadian secara detail...">{{ old('deskripsi') }}</textarea>
                <p class="text-sm text-gray-500 mt-2">Minimal 50 karakter</p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-camera mr-2"></i>Foto Bukti (Opsional)
                </label>
                <input type="file" name="foto[]" multiple accept="image/*" id="fotoInput"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB per foto. Bisa upload beberapa foto.</p>
                
                <div id="previewContainer" class="mt-4 grid grid-cols-4 gap-4"></div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-yellow-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Perhatian:</strong> Pastikan semua informasi yang Anda berikan akurat dan sesuai fakta. Laporan palsu dapat dikenakan sanksi hukum.
                </p>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="flex-1 gradient-bg text-white py-3 rounded-lg hover:opacity-90 transition font-semibold">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Pengaduan
                </button>
                <a href="{{ route('dashboard') }}" class="px-8 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold text-gray-700">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('fotoInput').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('previewContainer');
        previewContainer.innerHTML = '';
        
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(event) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${event.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-300">
                    <span class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 rounded-b-lg truncate">${file.name}</span>
                `;
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection