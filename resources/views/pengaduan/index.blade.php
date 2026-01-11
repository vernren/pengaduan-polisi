@extends('layouts.app')

@section('title', 'Riwayat Laporan')

@section('content')
<style>
body {
    background: #ffffff; /* putih */
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    overflow-x: hidden;
}

/* REMOVED: Extra container since layout.app already has container mx-auto */

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

.header-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
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

.create-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.75rem;
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    color: white;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9375rem;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 12px rgba(30, 64, 175, 0.25);
    white-space: nowrap;
}

.create-button:hover {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(30, 64, 175, 0.35);
}

.page-subtitle {
    color: #64748b;
    font-size: 0.9375rem;
    line-height: 1.6;
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

/* Card Grid */
.pengaduan-grid {
    display: grid;
    gap: 1.25rem;
    margin-bottom: 2rem;
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

.photo-tag {
    background: #fef3c7;
    border-color: #fbbf24;
    color: #92400e;
    font-weight: 600;
}

.photo-tag i {
    color: #f59e0b;
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

.status-menunggu {
    background: #fef3c7;
    color: #92400e;
    border: 2px solid #fbbf24;
}

.status-proses {
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

/* Response Box */
.response-box {
    background: #f8fafc;
    border-left: 4px solid #3b82f6;
    border-radius: 10px;
    padding: 1.25rem;
    margin-top: 1.25rem;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.response-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.625rem;
}

.response-header i {
    color: #3b82f6;
    flex-shrink: 0;
}

.response-officer {
    font-weight: 600;
    color: #1e40af;
    font-size: 0.875rem;
}

.response-text {
    color: #475569;
    font-size: 0.875rem;
    line-height: 1.6;
}

/* Empty State */
.empty-state {
    background: white;
    border-radius: 16px;
    padding: 4rem 2rem;
    text-align: center;
    border: 2px dashed #e2e8f0;
    width: 100%;
    box-sizing: border-box;
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
    margin-bottom: 2rem;
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

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .header-top {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .create-button {
        width: 100%;
        justify-content: center;
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
    
    .filter-section {
        padding: 1.25rem;
    }
    
    .info-tags {
        gap: 0.5rem;
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
    <div class="header-top">
        <div class="page-title">
            <div class="title-icon">
                <i class="fas fa-history"></i>
            </div>
            <span>Riwayat Laporan</span>
        </div>
    </div>
    <p class="page-subtitle">
        Pantau dan kelola semua pengaduan yang telah Anda kirimkan
    </p>
</div>

@if($pengaduan->isEmpty())
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-folder-open"></i>
        </div>
        <h3 class="empty-title">Belum Ada Pengaduan</h3>
        <p class="empty-description">
            Anda belum membuat pengaduan apapun.<br>
            Mulai buat pengaduan pertama Anda sekarang untuk mendapatkan bantuan.
        </p>
        <a href="{{ route('pengaduan.create') }}" class="create-button">
            <i class="fas fa-plus"></i>
            Buat Pengaduan Pertama
        </a>
    </div>
@else
    <!-- Stats Bar -->
    <div class="stats-bar">
        <div class="stat-item">
            <div class="stat-value">{{ $pengaduan->total() }}</div>
            <div class="stat-label">Total Laporan</div>
        </div>
        <div class="stat-item">
            <div class="stat-value" style="color: #f59e0b;">
                {{ $pengaduan->where('status', 'menunggu')->count() }}
            </div>
            <div class="stat-label">Menunggu</div>
        </div>
        <div class="stat-item">
            <div class="stat-value" style="color: #3b82f6;">
                {{ $pengaduan->where('status', 'proses')->count() }}
            </div>
            <div class="stat-label">Diproses</div>
        </div>
        <div class="stat-item">
            <div class="stat-value" style="color: #10b981;">
                {{ $pengaduan->where('status', 'selesai')->count() }}
            </div>
            <div class="stat-label">Selesai</div>
        </div>
    </div>

    {{-- <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-title">Filter Status</div>
        <div class="filter-chips">
            <a href="{{ route('pengaduan.index') }}" class="filter-chip active">
                <i class="fas fa-th"></i>
                Semua
                <span class="count">{{ $pengaduan->total() }}</span>
            </a>
            <a href="{{ route('pengaduan.index', ['status' => 'menunggu']) }}" class="filter-chip">
                <i class="fas fa-clock"></i>
                Menunggu
            </a>
            <a href="{{ route('pengaduan.index', ['status' => 'proses']) }}" class="filter-chip">
                <i class="fas fa-spinner"></i>
                Diproses
            </a>
            <a href="{{ route('pengaduan.index', ['status' => 'selesai']) }}" class="filter-chip">
                <i class="fas fa-check-circle"></i>
                Selesai
            </a>
            <a href="{{ route('pengaduan.index', ['status' => 'ditolak']) }}" class="filter-chip">
                <i class="fas fa-times-circle"></i>
                Ditolak
            </a>
        </div>
    </div> --}}

    <!-- Pengaduan Grid -->
    <div class="pengaduan-grid">
        @foreach($pengaduan as $item)
            <div class="pengaduan-card">
                <div class="card-header">
                    <div class="card-content">
                        <h3 class="card-title">{{ $item->judul }}</h3>
                        <p class="card-description">
                            {{ Str::limit($item->deskripsi, 180) }}
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
                                <i class="fas fa-map-marker-alt"></i>
                                {{ Str::limit($item->lokasi, 25) }}
                            </span>
                            <span class="info-tag">
                                <i class="fas fa-tag"></i>
                                {{ ucfirst($item->kategori) }}
                            </span>
                            @if($item->foto->count() > 0)
                                <span class="info-tag photo-tag">
                                    <i class="fas fa-images"></i>
                                    {{ $item->foto->count() }} Foto
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card-actions">
                        <span class="status-badge status-{{ strtolower($item->status) }}">
                            @if($item->status == 'menunggu')
                                <i class="fas fa-clock"></i>
                            @elseif($item->status == 'proses')
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

                @if($item->tanggapan && $item->petugas)
                    <div class="response-box">
                        <div class="response-header">
                            <i class="fas fa-user-shield"></i>
                            <span class="response-officer">
                                Tanggapan dari {{ $item->petugas->name }}
                            </span>
                        </div>
                        <p class="response-text">
                            {{ Str::limit($item->tanggapan, 150) }}
                        </p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div style="margin-top: 2rem;">
        {{ $pengaduan->links() }}
    </div>
@endif

@endsection