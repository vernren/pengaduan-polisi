@extends('layouts.app')

@section('title', 'Riwayat Pengaduan')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">
        <i class="fas fa-history mr-2"></i>Riwayat Pengaduan
    </h1>
    <p class="text-gray-600">Semua pengaduan yang pernah Anda buat</p>
</div>

<div class="bg-white rounded-lg shadow-lg p-6">
    @if($pengaduan->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Belum ada pengaduan</p>
            <a href="{{ route('pengaduan.create') }}" class="gradient-bg text-white px-6 py-3 rounded-lg hover:opacity-90 transition font-semibold inline-block">
                <i class="fas fa-plus mr-2"></i>Buat Pengaduan Pertama
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($pengaduan as $item)
                <div class="border border-gray-200 rounded-lg p-5 hover:border-gray-300 transition">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-gray-800 mb-2">{{ $item->judul }}</h3>
                            <p class="text-gray-600 mb-3">{{ Str::limit($item->deskripsi, 150) }}</p>
                            
                            <div class="flex flex-wrap gap-3 text-sm text-gray-500">
                                <span><i class="fas fa-calendar mr-1"></i>{{ $item->created_at->format('d M Y, H:i') }}</span>
                                <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $item->lokasi }}</span>
                                <span><i class="fas fa-tag mr-1"></i>{{ ucfirst($item->kategori) }}</span>
                                @if($item->foto->count() > 0)
                                    <span><i class="fas fa-image mr-1"></i>{{ $item->foto->count() }} Foto</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="ml-4 text-right">
                            <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $item->getStatusBadgeClass() }} block mb-2">
                                {{ $item->getStatusLabel() }}
                            </span>
                            <a href="{{ route('pengaduan.show', $item) }}" class="text-gray-600 hover:text-gray-800 font-semibold text-sm">
                                Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>

                    @if($item->tanggapan && $item->petugas)
                        <div class="mt-4 pt-4 border-t border-gray-200 bg-blue-50 -mx-5 -mb-5 px-5 py-4 rounded-b-lg">
                            <p class="text-sm font-semibold text-blue-800 mb-1">
                                <i class="fas fa-reply mr-1"></i>Tanggapan dari {{ $item->petugas->name }}
                            </p>
                            <p class="text-sm text-blue-700">{{ Str::limit($item->tanggapan, 100) }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $pengaduan->links() }}
        </div>
    @endif
</div>
@endsection