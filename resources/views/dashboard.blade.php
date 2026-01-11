@extends('layouts.app')

@section('title', 'Dashboard - Laporan Polisi')

@section('content')
<style>
body {
    background: #ffffff;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    overflow-x: hidden;
}

/* Header Section - SEVA Style */
.page-header {
    background: white;
    border-radius: 16px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
    width: 100%;
    box-sizing: border-box;
}

.page-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
}

.title-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.page-subtitle {
    color: #64748b;
    font-size: 0.9375rem;
    line-height: 1.6;
}

/* Stats Bar */
.stats-bar {
    background: white;
    border-radius: 16px;
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    display: flex;
    gap: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
    width: 100%;
    box-sizing: border-box;
}

.stat-item {
    flex: 1;
    text-align: center;
    padding: 0.5rem;
    border-right: 1px solid #e2e8f0;
    min-width: 0;
}

.stat-item:last-child {
    border-right: none;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1e40af;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 500;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.action-card {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.action-card:hover {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transform: translateY(-4px);
    border-color: #3b82f6;
}

.action-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.action-icon.create {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    color: #374151;
}

.action-icon.chat {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
}

.action-icon.history {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.action-content h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.action-content p {
    font-size: 0.875rem;
    color: #64748b;
}

/* Filter Section - SEVA Style */
.filter-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
    width: 100%;
    box-sizing: border-box;
}

.filter-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.filter-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.filter-chip {
    padding: 0.625rem 1.25rem;
    background: #f1f5f9;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    color: #475569;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-chip:hover, .filter-chip.active {
    background: #dbeafe;
    border-color: #3b82f6;
    color: #1e40af;
}

.filter-chip .count {
    background: white;
    padding: 0.125rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
}

/* Reports Section */
.reports-section {
    background: white;
    border-radius: 16px;
    padding: 2rem 2.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
    width: 100%;
    box-sizing: border-box;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.view-all-link {
    color: #3b82f6;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.view-all-link:hover {
    color: #1e40af;
    gap: 0.75rem;
}

/* Card Grid */
.pengaduan-grid {
    display: grid;
    gap: 1.25rem;
    width: 100%;
}

/* Card - SEVA Inspired */
.pengaduan-card {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    position: relative;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    width: 100%;
    box-sizing: border-box;
    overflow: hidden;
}

.pengaduan-card:hover {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transform: translateY(-4px);
    border-color: #cbd5e1;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
    gap: 1.5rem;
    width: 100%;
}

.card-content {
    flex: 1;
    min-width: 0;
    overflow: hidden;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
    line-height: 1.4;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.card-description {
    color: #64748b;
    font-size: 0.9375rem;
    line-height: 1.7;
    margin-bottom: 1.25rem;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

/* Info Tags */
.info-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.625rem;
    margin-bottom: 1rem;
}

.info-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 0.875rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    color: #475569;
    font-size: 0.8125rem;
    font-weight: 500;
    white-space: nowrap;
}

.info-tag i {
    color: #3b82f6;
    font-size: 0.75rem;
    flex-shrink: 0;
}

/* Status Badge - SEVA Style */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.125rem;
    border-radius: 10px;
    font-size: 0.8125rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    white-space: nowrap;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
    border: 2px solid #fbbf24;
}

.status-diproses {
    background: #dbeafe;
    color: #1e40af;
    border: 2px solid #3b82f6;
}

.status-selesai {
    background: #d1fae5;
    color: #065f46;
    border: 2px solid #10b981;
}

.status-ditolak {
    background: #fee2e2;
    color: #991b1b;
    border: 2px solid #ef4444;
}

.card-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    align-items: flex-end;
    flex-shrink: 0;
}

/* Detail Button */
.detail-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    color: white;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.detail-button:hover {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    transform: translateX(4px);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    border: 2px dashed #e2e8f0;
    border-radius: 16px;
}

.empty-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 3rem;
    color: #3b82f6;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.empty-description {
    color: #64748b;
    font-size: 1rem;
    line-height: 1.6;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .stats-bar {
        flex-direction: column;
        gap: 1rem;
        padding: 1.25rem;
    }
    
    .stat-item {
        border-right: none;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 1rem;
    }
    
    .stat-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
    
    .card-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .card-actions {
        width: 100%;
        align-items: stretch;
    }
    
    .status-badge {
        justify-content: center;
    }
    
    .detail-button {
        width: 100%;
        justify-content: center;
    }
    
    .filter-section {
        padding: 1.25rem;
    }
    
    .reports-section {
        padding: 1.5rem;
    }
    
    .pengaduan-card {
        padding: 1.25rem;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 1.25rem;
    }
    
    .title-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .card-title {
        font-size: 1.125rem;
    }
    
    .stat-value {
        font-size: 1.5rem;
    }
}
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <div class="title-icon">
            <i class="fas fa-home"></i>
        </div>
        <span>Dashboard</span>
    </div>
    <p class="page-subtitle">
        Selamat datang, <strong>{{ auth()->user()->name }}</strong>! Kelola dan pantau semua laporan Anda di sini.
    </p>
</div>

<!-- Stats Bar -->
<div class="stats-bar">
    <div class="stat-item">
        <div class="stat-value" style="color: #f59e0b;">
            {{ $pengaduan->where('status', 'pending')->count() }}
        </div>
        <div class="stat-label">Menunggu</div>
    </div>
    <div class="stat-item">
        <div class="stat-value" style="color: #3b82f6;">
            {{ $pengaduan->where('status', 'diproses')->count() }}
        </div>
        <div class="stat-label">Diproses</div>
    </div>
    <div class="stat-item">
        <div class="stat-value" style="color: #10b981;">
            {{ $pengaduan->where('status', 'selesai')->count() }}
        </div>
        <div class="stat-label">Selesai</div>
    </div>
    <div class="stat-item">
        <div class="stat-value">
            {{ $pengaduan->count() }}
        </div>
        <div class="stat-label">Total Laporan</div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <a href="{{ route('pengaduan.create') }}" class="action-card">
        <div class="action-icon create">
            <i class="fas fa-plus"></i>
        </div>
        <div class="action-content">
            <h3>Buat Laporan</h3>
            <p>Laporkan kejadian baru</p>
        </div>
    </a>

    <a href="{{ route('chatbot.index') }}" class="action-card">
        <div class="action-icon chat">
            <i class="fas fa-comments"></i>
        </div>
        <div class="action-content">
            <h3>Tanya Chatbot</h3>
            <p>Dapatkan bantuan cepat</p>
        </div>
    </a>

    <a href="{{ route('pengaduan.index') }}" class="action-card">
        <div class="action-icon history">
            <i class="fas fa-history"></i>
        </div>
        <div class="action-content">
            <h3>Riwayat Laporan</h3>
            <p>Lihat semua laporan</p>
        </div>
    </a>
</div>

{{-- <!-- Filter Section -->
@if(!$pengaduan->isEmpty())
<div class="filter-section">
    <div class="filter-title">Filter Status</div>
    <div class="filter-chips">
        <a href="{{ route('dashboard') }}" class="filter-chip active">
            <i class="fas fa-th"></i>
            Semua
            <span class="count">{{ $pengaduan->count() }}</span>
        </a>
        <a href="{{ route('dashboard', ['status' => 'pending']) }}" class="filter-chip">
            <i class="fas fa-clock"></i>
            Menunggu
        </a>
        <a href="{{ route('dashboard', ['status' => 'diproses']) }}" class="filter-chip">
            <i class="fas fa-spinner"></i>
            Diproses
        </a>
        <a href="{{ route('dashboard', ['status' => 'selesai']) }}" class="filter-chip">
            <i class="fas fa-check-circle"></i>
            Selesai
        </a>
        <a href="{{ route('dashboard', ['status' => 'ditolak']) }}" class="filter-chip">
            <i class="fas fa-times-circle"></i>
            Ditolak
        </a>
    </div>
</div>
@endif --}}

<!-- Recent Reports -->
<div class="reports-section">
    <div class="section-header">
        <h2 class="section-title">
            <i class="fas fa-clock"></i>
            Laporan Terbaru
        </h2>
        <a href="{{ route('pengaduan.index') }}" class="view-all-link">
            Lihat Semua
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    @if($pengaduan->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-folder-open"></i>
            </div>
            <h3 class="empty-title">Belum Ada Laporan</h3>
            <p class="empty-description">
                Anda belum memiliki laporan apapun.<br>
                Mulai buat laporan pertama Anda sekarang untuk mendapatkan bantuan.
            </p>
        </div>
    @else
        <div class="pengaduan-grid">
            @foreach($pengaduan->take(5) as $item)
                <div class="pengaduan-card">
                    <div class="card-header">
                        <div class="card-content">
                            <h3 class="card-title">{{ $item->judul }}</h3>
                            <p class="card-description">
                                {{ Str::limit($item->deskripsi, 150) }}
                            </p>
                            
                            <div class="info-tags">
                                <span class="info-tag">
                                    <i class="fas fa-calendar"></i>
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                                <span class="info-tag">
                                    <i class="fas fa-clock"></i>
                                    {{ $item->created_at->format('H:i') }} WIB
                                </span>
                                <span class="info-tag">
                                    <i class="fas fa-tag"></i>
                                    {{ ucfirst($item->kategori) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-actions">
                            <span class="status-badge status-{{ strtolower($item->status) }}">
                                @if($item->status == 'pending')
                                    <i class="fas fa-clock"></i>
                                @elseif($item->status == 'diproses')
                                    <i class="fas fa-spinner fa-spin"></i>
                                @elseif($item->status == 'selesai')
                                    <i class="fas fa-check-circle"></i>
                                @else
                                    <i class="fas fa-times-circle"></i>
                                @endif
                                {{ $item->getStatusLabel() }}
                            </span>
                            <a href="{{ route('pengaduan.show', $item) }}" class="detail-button">
                                Lihat Detail
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection