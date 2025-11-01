<!-- resources/views/petugas/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">
        <i class="fas fa-user-shield mr-2"></i>Dashboard Petugas
    </h1>
    <p class="text-gray-600">Kelola dan tanggapi pengaduan masyarakat</p>
</div>

<!-- Stats Cards -->
<div class="grid md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-yellow-100 text-sm font-semibold">Menunggu</p>
                <p class="text-4xl font-bold mt-2">{{ $stats['pending'] }}</p>
            </div>
            <i class="fas fa-clock text-5xl opacity-30"></i>
        </div>
        <p class="text-xs text-yellow-100 mt-3">Perlu ditindaklanjuti</p>
    </div>

    <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-blue-100 text-sm font-semibold">Diproses</p>
                <p class="text-4xl font-bold mt-2">{{ $stats['diproses'] }}</p>
            </div>
            <i class="fas fa-cog fa-spin text-5xl opacity-30"></i>
        </div>
        <p class="text-xs text-blue-100 mt-3">Sedang ditangani</p>
    </div>

    <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-green-100 text-sm font-semibold">Selesai</p>
                <p class="text-4xl font-bold mt-2">{{ $stats['selesai'] }}</p>
            </div>
            <i class="fas fa-check-circle text-5xl opacity-30"></i>
        </div>
        <p class="text-xs text-green-100 mt-3">Telah diselesaikan</p>
    </div>

    <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-purple-100 text-sm font-semibold">Total</p>
                <p class="text-4xl font-bold mt-2">{{ $stats['total'] }}</p>
            </div>
            <i class="fas fa-file-alt text-5xl opacity-30"></i>
        </div>
        <p class="text-xs text-purple-100 mt-3">Semua pengaduan</p>
    </div>
</div>

<!-- Filter Tabs -->
<div class="bg-white rounded-lg shadow-lg mb-6">
    <div class="flex border-b border-gray-200 overflow-x-auto">
        <a href="?status=all" class="px-6 py-4 font-semibold {{ request('status', 'all') == 'all' ? 'text-purple-600 border-b-2 border-purple-600' : 'text-gray-600 hover:text-purple-600' }} whitespace-nowrap">
            Semua
        </a>
        <a href="?status=pending" class="px-6 py-4 font-semibold {{ request('status') == 'pending' ? 'text-yellow-600 border-b-2 border-yellow-600' : 'text-gray-600 hover:text-yellow-600' }} whitespace-nowrap">
            Menunggu
        </a>
        <a href="?status=diproses" class="px-6 py-4 font-semibold {{ request('status') == 'diproses' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' }} whitespace-nowrap">
            Diproses
        </a>
        <a href="?status=selesai" class="px-6 py-4 font-semibold {{ request('status') == 'selesai' ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-600 hover:text-green-600' }} whitespace-nowrap">
            Selesai
        </a>
    </div>
</div>

<!-- Pengaduan List -->
<div class="bg-white rounded-lg shadow-lg">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-list mr-2"></i>Daftar Pengaduan
        </h2>
    </div>

    @if($pengaduan->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">Tidak ada pengaduan untuk ditampilkan</p>
        </div>
    @else
        <div class="divide-y divide-gray-200">
            @foreach($pengaduan as $item)
                <div class="p-6 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1">
                            <div class="flex items-start space-x-3 mb-2">
                                <h3 class="font-bold text-lg text-gray-800">{{ $item->judul }}</h3>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $item->getStatusBadgeClass() }}">
                                    {{ $item->getStatusLabel() }}
                                </span>
                            </div>
                            
                            <p class="text-gray-600 mb-3">{{ Str::limit($item->deskripsi, 120) }}</p>
                            
                            <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-user mr-1"></i>{{ $item->user->name }}</span>
                                <span><i class="fas fa-calendar mr-1"></i>{{ $item->created_at->format('d M Y, H:i') }}</span>
                                <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $item->lokasi }}</span>
                                <span><i class="fas fa-tag mr-1"></i>{{ ucfirst($item->kategori) }}</span>
                                <span class="font-semibold {{ $item->prioritas == 'tinggi' ? 'text-red-600' : ($item->prioritas == 'sedang' ? 'text-yellow-600' : 'text-green-600') }}">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>Prioritas {{ ucfirst($item->prioritas) }}
                                </span>
                            </div>
                        </div>

                        <div class="ml-4 flex flex-col space-y-2">
                            <a href="{{ route('petugas.pengaduan.show', $item) }}" 
                                class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition text-center text-sm font-semibold whitespace-nowrap">
                                <i class="fas fa-eye mr-1"></i>Lihat Detail
                            </a>
                        </div>
                    </div>

                    @if($item->foto->count() > 0)
                        <div class="mt-3 flex space-x-2">
                            @foreach($item->foto->take(3) as $foto)
                                <img src="{{ Storage::url($foto->file_path) }}" alt="Bukti" 
                                    class="w-16 h-16 object-cover rounded border border-gray-300">
                            @endforeach
                            @if($item->foto->count() > 3)
                                <div class="w-16 h-16 bg-gray-200 rounded border border-gray-300 flex items-center justify-center text-xs text-gray-600 font-semibold">
                                    +{{ $item->foto->count() - 3 }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="p-6 border-t border-gray-200">
            {{ $pengaduan->links() }}
        </div>
    @endif
</div>
@endsection