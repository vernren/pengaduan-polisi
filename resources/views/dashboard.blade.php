@extends('layouts.app')

@section('title', 'Dashboard - Laporan Polisi')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">
        <i class="fas fa-home mr-2"></i>Dashboard
    </h1>
    <p class="text-gray-600">
        Selamat datang, <strong>{{ auth()->user()->name }}</strong>!
    </p>
</div>

<!-- Quick Stats -->
<div class="grid md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-yellow-100 text-sm font-semibold">Menunggu</p>
                <p class="text-3xl font-bold mt-2">
                    {{ $pengaduan->where('status', 'pending')->count() }}
                </p>
            </div>
            <i class="fas fa-clock text-4xl opacity-50"></i>
        </div>
    </div>

    <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-blue-100 text-sm font-semibold">Diproses</p>
                <p class="text-3xl font-bold mt-2">
                    {{ $pengaduan->where('status', 'diproses')->count() }}
                </p>
            </div>
            <i class="fas fa-cog fa-spin text-4xl opacity-50"></i>
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-green-100 text-sm font-semibold">Selesai</p>
                <p class="text-3xl font-bold mt-2">
                    {{ $pengaduan->where('status', 'selesai')->count() }}
                </p>
            </div>
            <i class="fas fa-check-circle text-4xl opacity-50"></i>
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-purple-100 text-sm font-semibold">Total Laporan</p>
                <p class="text-3xl font-bold mt-2">{{ $pengaduan->count() }}</p>
            </div>
            <i class="fas fa-file-alt text-4xl opacity-50"></i>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('pengaduan.create') }}"
       class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
        <div class="flex items-center space-x-4">
            <div class="bg-purple-100 w-14 h-14 rounded-full flex items-center justify-center">
                <i class="fas fa-plus text-purple-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800">Buat Laporan</h3>
                <p class="text-sm text-gray-600">Laporkan kejadian baru</p>
            </div>
        </div>
    </a>

    <a href="{{ route('chatbot.index') }}"
       class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
        <div class="flex items-center space-x-4">
            <div class="bg-blue-100 w-14 h-14 rounded-full flex items-center justify-center">
                <i class="fas fa-comments text-blue-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800">Tanya Chatbot</h3>
                <p class="text-sm text-gray-600">Dapatkan bantuan cepat</p>
            </div>
        </div>
    </a>

    <a href="{{ route('pengaduan.index') }}"
       class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
        <div class="flex items-center space-x-4">
            <div class="bg-green-100 w-14 h-14 rounded-full flex items-center justify-center">
                <i class="fas fa-history text-green-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800">Riwayat Laporan</h3>
                <p class="text-sm text-gray-600">Lihat semua laporan</p>
            </div>
        </div>
    </a>
</div>

<!-- Recent Reports -->
<div class="bg-white rounded-lg shadow-lg p-6 overflow-hidden">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-clock mr-2"></i>Laporan Terbaru
        </h2>
        <a href="{{ route('pengaduan.index') }}"
           class="text-purple-600 hover:text-purple-800 font-semibold text-sm">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    @if($pengaduan->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">Anda belum memiliki laporan</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($pengaduan as $item)
            <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition">
                <div class="flex justify-between items-start gap-4">
                    <!-- LEFT -->
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-800 mb-1 break-all">
                            {{ $item->judul }}
                        </h3>
                        <p class="text-sm text-gray-600 break-words overflow-hidden whitespace-pre-line">
                            {{ Str::limit($item->deskripsi, 100) }}
                        </p>
                    </div>

                    <!-- STATUS -->
                    <span class="px-3 py-1 rounded-full text-xs font-semibold shrink-0 {{ $item->getStatusBadgeClass() }}">
                        {{ $item->getStatusLabel() }}
                    </span>
                </div>

                <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100">
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span><i class="fas fa-calendar mr-1"></i>{{ $item->created_at->format('d M Y') }}</span>
                        <span><i class="fas fa-tag mr-1"></i>{{ ucfirst($item->kategori) }}</span>
                    </div>
                    <a href="{{ route('pengaduan.show', $item) }}"
                       class="text-purple-600 hover:text-purple-800 font-semibold text-sm whitespace-nowrap">
                        Detail <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
