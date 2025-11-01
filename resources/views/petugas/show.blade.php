<!-- resources/views/petugas/show.blade.php -->
@extends('layouts.app')

@section('title', 'Detail Pengaduan - Petugas')

@section('content')
<div class="mb-6">
    <a href="{{ route('petugas.dashboard') }}" class="text-purple-600 hover:text-purple-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
    </a>
</div>

<div class="grid md:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-start mb-6">
                <h1 class="text-2xl font-bold text-gray-800">{{ $pengaduan->judul }}</h1>
                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $pengaduan->getStatusBadgeClass() }}">
                    {{ $pengaduan->getStatusLabel() }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6 text-sm bg-gray-50 p-4 rounded-lg">
                <div>
                    <p class="text-gray-500 mb-1"><i class="fas fa-tag mr-2"></i>Kategori</p>
                    <p class="font-semibold text-gray-800">{{ ucfirst($pengaduan->kategori) }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1"><i class="fas fa-exclamation-triangle mr-2"></i>Prioritas</p>
                    <p class="font-semibold {{ $pengaduan->prioritas == 'tinggi' ? 'text-red-600' : ($pengaduan->prioritas == 'sedang' ? 'text-yellow-600' : 'text-green-600') }}">
                        {{ ucfirst($pengaduan->prioritas) }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1"><i class="fas fa-map-marker-alt mr-2"></i>Lokasi</p>
                    <p class="font-semibold text-gray-800">{{ $pengaduan->lokasi }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1"><i class="fas fa-calendar mr-2"></i>Tanggal Kejadian</p>
                    <p class="font-semibold text-gray-800">{{ $pengaduan->tanggal_kejadian->format('d M Y') }}</p>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="font-semibold text-gray-800 mb-3"><i class="fas fa-align-left mr-2"></i>Deskripsi Kejadian</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700 leading-relaxed">{{ $pengaduan->deskripsi }}</p>
                </div>
            </div>

            @if($pengaduan->foto->count() > 0)
                <div>
                    <h3 class="font-semibold text-gray-800 mb-3"><i class="fas fa-image mr-2"></i>Foto Bukti ({{ $pengaduan->foto->count() }})</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($pengaduan->foto as $foto)
                            <a href="{{ Storage::url($foto->file_path) }}" target="_blank" class="group relative">
                                <img src="{{ Storage::url($foto->file_path) }}" alt="Bukti" 
                                    class="w-full h-48 object-cover rounded-lg border-2 border-gray-300 group-hover:border-purple-500 transition">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition rounded-lg flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 text-2xl"></i>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Form Update Status -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="font-semibold text-gray-800 mb-4 text-lg">
                <i class="fas fa-edit mr-2"></i>Update Status & Tanggapan
            </h3>

            <form action="{{ route('petugas.pengaduan.update', $pengaduan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-toggle-on mr-2"></i>Status Pengaduan
                    </label>
                    <select name="status" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                        <option value="pending" {{ $pengaduan->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-comment-alt mr-2"></i>Tanggapan / Catatan
                    </label>
                    <textarea name="tanggapan" rows="5"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                        placeholder="Berikan tanggapan atau catatan untuk pelapor...">{{ old('tanggapan', $pengaduan->tanggapan) }}</textarea>
                    <p class="text-sm text-gray-500 mt-2">Tanggapan ini akan dilihat oleh pelapor</p>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="flex-1 gradient-bg text-white py-3 rounded-lg hover:opacity-90 transition font-semibold">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        @if($pengaduan->tanggapan)
            <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6">
                <h3 class="font-semibold text-blue-900 mb-3 flex items-center">
                    <i class="fas fa-history mr-2"></i>Tanggapan Sebelumnya
                </h3>
                <p class="text-blue-800 leading-relaxed mb-3">{{ $pengaduan->tanggapan }}</p>
                @if($pengaduan->petugas)
                    <div class="flex items-center text-sm text-blue-600 pt-3 border-t border-blue-200">
                        <i class="fas fa-user-shield mr-2"></i>
                        <span>{{ $pengaduan->petugas->name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $pengaduan->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-user mr-2"></i>Informasi Pelapor
            </h3>
            <div class="space-y-3 text-sm">
                <div class="pb-3 border-b border-gray-200">
                    <p class="text-gray-500 mb-1">Nama Lengkap</p>
                    <p class="font-semibold text-gray-800">{{ $pengaduan->user->name }}</p>
                </div>
                <div class="pb-3 border-b border-gray-200">
                    <p class="text-gray-500 mb-1">NIK</p>
                    <p class="font-semibold text-gray-800">{{ $pengaduan->user->nik ?? '-' }}</p>
                </div>
                <div class="pb-3 border-b border-gray-200">
                    <p class="text-gray-500 mb-1">Email</p>
                    <p class="font-semibold text-gray-800">{{ $pengaduan->user->email }}</p>
                </div>
                <div class="pb-3 border-b border-gray-200">
                    <p class="text-gray-500 mb-1">Telepon</p>
                    <p class="font-semibold text-gray-800">{{ $pengaduan->user->phone }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Alamat</p>
                    <p class="font-semibold text-gray-800">{{ $pengaduan->user->address ?? '-' }}</p>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="tel:{{ $pengaduan->user->phone }}" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition font-semibold text-center block">
                    <i class="fas fa-phone mr-2"></i>Hubungi Pelapor
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-clock mr-2"></i>Timeline
            </h3>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="bg-green-100 w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-plus text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-sm text-gray-800">Pengaduan Dibuat</p>
                        <p class="text-xs text-gray-500">{{ $pengaduan->created_at->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-gray-600 mt-1">{{ $pengaduan->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                @if($pengaduan->status != 'pending')
                    <div class="flex items-start space-x-3">
                        <div class="bg-blue-100 w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-gray-800">Status Diperbarui</p>
                            <p class="text-xs text-gray-500">{{ $pengaduan->updated_at->format('d M Y, H:i') }}</p>
                            <p class="text-xs text-gray-600 mt-1">{{ $pengaduan->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
            <p class="text-sm text-purple-800 font-semibold mb-2">
                <i class="fas fa-info-circle mr-2"></i>Catatan Penting
            </p>
            <ul class="text-xs text-purple-700 space-y-1">
                <li>• Prioritas tinggi harus ditangani dalam 24 jam</li>
                <li>• Selalu berikan tanggapan yang jelas</li>
                <li>• Update status secara berkala</li>
            </ul>
        </div>
    </div>
</div>
@endsection