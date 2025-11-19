<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard - Pengaduan Polisi')

@section('content')
<style>
    .hero-section {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(30, 58, 138, 0.3);
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(30%, -30%);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }
    
    .action-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        border-color: #d4af37;
    }
    
    .report-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    
    .report-card:hover {
        border-color: #d4af37;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
    }
    
    .badge-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .badge-diproses {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .badge-selesai {
        background: #d1fae5;
        color: #065f46;
    }
    
    .gold-accent {
        color: #d4af37;
    }
    
    .police-badge {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
</style>

<!-- Hero Section -->
<div class="hero-section p-8 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <div class="flex items-center mb-4">
                <div class="police-badge mr-4">
                    <i class="fas fa-shield-alt text-2xl" style="color: #1e3a8a;"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold mb-1">Dashboard Pengaduan Polisi</h1>
                    <p class="text-blue-100">Sistem Pengaduan Masyarakat Online</p>
                </div>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-4 backdrop-blur-sm">
                <p class="text-lg">Selamat datang, <strong class="gold-accent">{{ auth()->user()->name }}</strong></p>
                <p class="text-sm text-blue-100 mt-1">Kepolisian Republik Indonesia berkomitmen melayani masyarakat dengan profesional</p>
            </div>
        </div>
        <div class="hidden lg:block">
            <i class="fas fa-building text-8xl opacity-20"></i>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid md:grid-cols-4 gap-6 mb-8">
    <!-- Pending -->
    <div class="stat-card p-6">
        <div class="flex justify-between items-start mb-4">
            <div class="stat-icon" style="background: #fef3c7;">
                <i class="fas fa-clock" style="color: #f59e0b;"></i>
            </div>
            <div class="text-right">
                <p class="text-4xl font-bold text-gray-800">{{ $pengaduan->where('status', 'pending')->count() }}</p>
                <p class="text-sm text-gray-500 mt-1">Laporan</p>
            </div>
        </div>
        <div class="border-t border-gray-100 pt-3">
            <p class="text-sm font-semibold text-gray-700">Menunggu Proses</p>
            <p class="text-xs text-gray-500 mt-1">Sedang dalam antrian</p>
        </div>
    </div>

    <!-- Processing -->
    <div class="stat-card p-6">
        <div class="flex justify-between items-start mb-4">
            <div class="stat-icon" style="background: #dbeafe;">
                <i class="fas fa-sync-alt fa-spin" style="color: #3b82f6;"></i>
            </div>
            <div class="text-right">
                <p class="text-4xl font-bold text-gray-800">{{ $pengaduan->where('status', 'diproses')->count() }}</p>
                <p class="text-sm text-gray-500 mt-1">Laporan</p>
            </div>
        </div>
        <div class="border-t border-gray-100 pt-3">
            <p class="text-sm font-semibold text-gray-700">Sedang Diproses</p>
            <p class="text-xs text-gray-500 mt-1">Dalam penanganan</p>
        </div>
    </div>

    <!-- Completed -->
    <div class="stat-card p-6">
        <div class="flex justify-between items-start mb-4">
            <div class="stat-icon" style="background: #d1fae5;">
                <i class="fas fa-check-circle" style="color: #10b981;"></i>
            </div>
            <div class="text-right">
                <p class="text-4xl font-bold text-gray-800">{{ $pengaduan->where('status', 'selesai')->count() }}</p>
                <p class="text-sm text-gray-500 mt-1">Laporan</p>
            </div>
        </div>
        <div class="border-t border-gray-100 pt-3">
            <p class="text-sm font-semibold text-gray-700">Selesai Ditangani</p>
            <p class="text-xs text-gray-500 mt-1">Sudah terselesaikan</p>
        </div>
    </div>

    <!-- Total -->
    <div class="stat-card p-6" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white;">
        <div class="flex justify-between items-start mb-4">
            <div class="stat-icon" style="background: rgba(255, 255, 255, 0.2);">
                <i class="fas fa-file-alt" style="color: white;"></i>
            </div>
            <div class="text-right">
                <p class="text-4xl font-bold">{{ $pengaduan->count() }}</p>
                <p class="text-sm text-blue-100 mt-1">Laporan</p>
            </div>
        </div>
        <div class="border-t border-blue-400 border-opacity-30 pt-3">
            <p class="text-sm font-semibold">Total Pengaduan</p>
            <p class="text-xs text-blue-100 mt-1">Keseluruhan laporan</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mb-8">
    <h2 class="text-xl font-bold text-gray-800 mb-4">
        <i class="fas fa-bolt gold-accent mr-2"></i>Akses Cepat
    </h2>
    <div class="grid md:grid-cols-3 gap-6">
        <a href="{{ route('pengaduan.create') }}" class="action-card p-6">
            <div class="flex items-start space-x-4">
                <div class="stat-icon flex-shrink-0" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                    <i class="fas fa-plus text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Buat Pengaduan Baru</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Laporkan kejadian atau masalah yang perlu ditangani petugas</p>
                    <div class="mt-3 flex items-center text-blue-600 font-semibold text-sm">
                        <span>Buat Laporan</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('chatbot.index') }}" class="action-card p-6">
            <div class="flex items-start space-x-4">
                <div class="stat-icon flex-shrink-0" style="background: #d4af37;">
                    <i class="fas fa-robot text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Bantuan Chatbot</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Dapatkan informasi dan panduan melalui asisten virtual</p>
                    <div class="mt-3 flex items-center font-semibold text-sm" style="color: #d4af37;">
                        <span>Chat Sekarang</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('pengaduan.index') }}" class="action-card p-6">
            <div class="flex items-start space-x-4">
                <div class="stat-icon flex-shrink-0" style="background: #10b981;">
                    <i class="fas fa-list-alt text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Riwayat Pengaduan</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Lihat status dan detail semua laporan Anda</p>
                    <div class="mt-3 flex items-center text-green-600 font-semibold text-sm">
                        <span>Lihat Riwayat</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Recent Reports -->
<div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-history gold-accent mr-2"></i>Pengaduan Terbaru
        </h2>
        <a href="{{ route('pengaduan.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm flex items-center">
            Lihat Semua 
            <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>

    @if($pengaduan->isEmpty())
        <div class="text-center py-16">
            <div class="inline-block p-6 bg-gray-50 rounded-full mb-4">
                <i class="fas fa-folder-open text-6xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Pengaduan</h3>
            <p class="text-gray-500 mb-6">Anda belum memiliki pengaduan yang terdaftar dalam sistem</p>
            <a href="{{ route('pengaduan.create') }}" class="inline-flex items-center px-6 py-3 rounded-lg font-semibold text-white transition" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                <i class="fas fa-plus mr-2"></i>Buat Pengaduan Pertama
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($pengaduan as $item)
                <div class="report-card p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background: #f3f4f6;">
                                    <i class="fas fa-file-alt text-gray-600"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-800 mb-1 text-lg">{{ $item->judul }}</h3>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ Str::limit($item->deskripsi, 120) }}</p>
                                </div>
                            </div>
                        </div>
                        <span class="px-4 py-1.5 rounded-full text-xs font-semibold ml-4 {{ $item->getStatusBadgeClass() }}">
                            {{ $item->getStatusLabel() }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <span class="flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                {{ $item->created_at->format('d M Y') }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-tag mr-2"></i>
                                {{ ucfirst($item->kategori) }}
                            </span>
                        </div>
                        <a href="{{ route('pengaduan.show', $item) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm flex items-center">
                            Lihat Detail
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Info Footer -->
<div class="mt-8 p-6 rounded-xl" style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);">
    <div class="flex items-start space-x-4">
        <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background: #1e3a8a;">
            <i class="fas fa-info text-white text-xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800 mb-2">Informasi Penting</h3>
            <p class="text-sm text-gray-600 leading-relaxed">
                Setiap pengaduan yang masuk akan diproses oleh petugas kami dengan profesional dan rahasia. 
                Pastikan informasi yang Anda berikan akurat untuk mempercepat proses penanganan.
            </p>
        </div>
    </div>
</div>
@endsection