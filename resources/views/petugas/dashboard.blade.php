@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('scripts')
    <script>
        // FITUR DOWNLOAD LAPORAN
        function toggleDownloadDropdown() {
            document.getElementById('downloadDropdown').classList.toggle('hidden');
        }

        document.addEventListener('click', function(e) {
            const btn = document.getElementById('btnDownload');
            const dropdown = document.getElementById('downloadDropdown');

            if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
        /* =========================
               SUB KATEGORI FILTER
            ========================= */
        const filterSubKategoriOptions = {
            pengaduan: {
                pencurian: 'Pencurian',
                penipuan: 'Penipuan',
                kekerasan: 'Kekerasan',
                narkoba: 'Narkoba',
                lainnya: 'Lainnya'
            },
            permintaan: {
                pengawalan: 'Pengawalan'
            }
        };

        const filterKategori = document.getElementById('filter_kategori');
        const filterSubKategori = document.getElementById('filter_sub_kategori');

        function updateFilterSubKategori(selectedKategori, selectedSub = '') {
            filterSubKategori.innerHTML = '<option value="">Semua</option>';

            if (!selectedKategori || !filterSubKategoriOptions[selectedKategori]) {
                return;
            }

            Object.entries(filterSubKategoriOptions[selectedKategori]).forEach(([key, label]) => {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = label;

                if (key === selectedSub) {
                    option.selected = true;
                }

                filterSubKategori.appendChild(option);
            });
        }

        /* EVENT CHANGE */
        filterKategori.addEventListener('change', function() {
            updateFilterSubKategori(this.value);
        });

        /* LOAD SAAT REFRESH */
        document.addEventListener('DOMContentLoaded', function() {
            updateFilterSubKategori(
                "{{ request('kategori_utama') }}",
                "{{ request('sub_kategori') }}"
            );
        });
    </script>
@endsection

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

        /* Stats Bar - SEVA Style */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }

        .stat-card.pending::before {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        }

        .stat-card.proses::before {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        .stat-card.selesai::before {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        }

        .stat-card.total::before {
            background: linear-gradient(135deg, #4b5563 0%, #6b7280 100%);
        }

        .stat-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .stat-info p:first-child {
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
        }

        .stat-card.pending .stat-value {
            color: #f59e0b;
        }

        .stat-card.proses .stat-value {
            color: #3b82f6;
        }

        .stat-card.selesai .stat-value {
            color: #10b981;
        }

        .stat-card.total .stat-value {
            color: #6b7280;
        }

        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.2;
        }

        .stat-card.pending .stat-icon {
            color: #f59e0b;
        }

        .stat-card.proses .stat-icon {
            color: #3b82f6;
        }

        .stat-card.selesai .stat-icon {
            color: #10b981;
        }

        .stat-card.total .stat-icon {
            color: #6b7280;
        }

        .stat-description {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 0.5rem;
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

        .filter-chip:hover {
            background: #dbeafe;
            border-color: #3b82f6;
            color: #1e40af;
        }

        .filter-chip.active {
            background: #dbeafe;
            border-color: #3b82f6;
            color: #1e40af;
        }

        /* Advanced Filter Section */
        .advanced-filter {
            background: white;
            border-radius: 16px;
            padding: 1.75rem 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .filter-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-count {
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748b;
        }

        .filter-count span {
            color: #3b82f6;
            font-weight: 700;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .filter-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
        }

        .filter-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .filter-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .filter-input.error {
            border-color: #ef4444;
        }

        .error-message {
            font-size: 0.75rem;
            color: #ef4444;
            margin-top: 0.25rem;
        }

        .filter-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.25);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(30, 64, 175, 0.35);
        }

        .btn-secondary {
            background: #ef4444;
            color: white;
        }

        .btn-secondary:hover {
            background: #dc2626;
            transform: translateY(-2px);
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

        .card-title-row {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            flex-wrap: wrap;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.4;
            word-wrap: break-word;
            overflow-wrap: break-word;
            flex: 1;
        }

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
            flex-shrink: 0;
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

        /* .status-ditolak {
        background: #fee2e2;
        color: #991b1b;
        border: 2px solid #ef4444;
    } */

        .card-kategori {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
            flex-wrap: wrap;
        }

        .kategori-item {
            display: flex;
            gap: 0.25rem;
        }

        .kategori-label {
            font-weight: 700;
            color: #475569;
        }

        .kategori-value {
            color: #64748b;
        }

        .card-description {
            color: #64748b;
            font-size: 0.9375rem;
            line-height: 1.7;
            margin-bottom: 1.25rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: pre-line;
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

        .card-actions {
            display: flex;
            gap: 0.75rem;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.3s ease;
            white-space: nowrap;
            border: none;
            cursor: pointer;
        }

        .action-primary {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
        }

        .action-primary:hover {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            transform: translateX(4px);
        }

        .action-danger {
            background: #ef4444;
            color: white;
        }

        .action-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        /* Photo Grid */
        .photo-grid {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .photo-item {
            width: 64px;
            height: 64px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #e2e8f0;
        }

        .photo-more {
            width: 64px;
            height: 64px;
            background: #f1f5f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            border: 1px solid #e2e8f0;
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

        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .title-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .stats-bar {
                grid-template-columns: 1fr;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .card-header {
                flex-direction: column;
                gap: 1rem;
            }

            .card-title-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .card-actions {
                width: 100%;
            }

            .action-button {
                flex: 1;
                justify-content: center;
            }

            .advanced-filter {
                padding: 1.25rem;
            }

            .filter-section {
                padding: 1.25rem;
            }

            .pengaduan-card {
                padding: 1.25rem;
            }
        }
    </style>

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <div class="title-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <span>Dashboard Petugas</span>
        </div>
        <p class="page-subtitle">
            Kelola dan tanggapi laporan masyarakat
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-bar">
        <div class="stat-card pending">
            <div class="stat-content">
                <div class="stat-info">
                    <p>Menunggu</p>
                    <div class="stat-value">{{ $stats['pending'] }}</div>
                </div>
                <i class="fas fa-clock stat-icon"></i>
            </div>
            <p class="stat-description">Perlu ditindaklanjuti</p>
        </div>

        <div class="stat-card proses">
            <div class="stat-content">
                <div class="stat-info">
                    <p>Diproses</p>
                    <div class="stat-value">{{ $stats['diproses'] }}</div>
                </div>
                <i class="fas fa-cog fa-spin stat-icon"></i>
            </div>
            <p class="stat-description">Sedang ditangani</p>
        </div>

        <div class="stat-card selesai">
            <div class="stat-content">
                <div class="stat-info">
                    <p>Selesai</p>
                    <div class="stat-value">{{ $stats['selesai'] }}</div>
                </div>
                <i class="fas fa-check-circle stat-icon"></i>
            </div>
            <p class="stat-description">Telah diselesaikan</p>
        </div>

        <div class="stat-card total">
            <div class="stat-content">
                <div class="stat-info">
                    <p>Total</p>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                </div>
                <i class="fas fa-file-alt stat-icon"></i>
            </div>
            <p class="stat-description">Semua laporan</p>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-section">
        <div class="filter-chips">
            <a href="?status=all" class="filter-chip {{ request('status', 'all') == 'all' ? 'active' : '' }}">
                <i class="fas fa-th"></i>
                Semua
            </a>
            <a href="?status=pending" class="filter-chip {{ request('status') == 'pending' ? 'active' : '' }}">
                <i class="fas fa-clock"></i>
                Menunggu
            </a>
            <a href="?status=diproses" class="filter-chip {{ request('status') == 'diproses' ? 'active' : '' }}">
                <i class="fas fa-spinner"></i>
                Diproses
            </a>
            <a href="?status=selesai" class="filter-chip {{ request('status') == 'selesai' ? 'active' : '' }}">
                <i class="fas fa-check-circle"></i>
                Selesai
            </a>
        </div>
    </div>

    <!-- Advanced Filter -->
    <div class="advanced-filter">
        <div class="filter-header">
            <h2 class="filter-title">
                <i class="fas fa-filter"></i>
                Filter Lanjutan
            </h2>
            <span class="filter-count">
                Total Laporan: <span>{{ $pengaduan->total() }}</span>
            </span>
        </div>

        <form method="GET">
            <div class="filter-grid">
                <div class="filter-group">
                    <label>Kategori Utama</label>
                    <select name="kategori_utama" id="filter_kategori" class="filter-input">
                        <option value="">Semua</option>
                        <option value="laporan" {{ request('kategori_utama') == 'laporan' ? 'selected' : '' }}>
                            Laporan
                        </option>
                        <option value="permintaan" {{ request('kategori_utama') == 'permintaan' ? 'selected' : '' }}>
                            Pengawalan
                        </option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Sub Kategori</label>
                    <select name="sub_kategori" id="filter_sub_kategori" class="filter-input">
                        <option value="">Semua</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                        class="filter-input @error('tanggal_mulai') error @enderror">
                </div>

                <div class="filter-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}"
                        class="filter-input @error('tanggal_selesai') error @enderror">
                    @error('tanggal_selesai')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Terapkan Filter
                </button>
                <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i>
                    Reset
                </a>

                <div class="relative ml-auto">
                    <button type="button" id="btnDownload" class="btn btn-primary" onclick="toggleDownloadDropdown()">
                        <i class="fas fa-download"></i>
                        Download Laporan
                        <i class="fas fa-chevron-down ml-1"></i>
                    </button>

                    <div id="downloadDropdown"
                        class="hidden absolute right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg min-w-[180px] z-50">

                        <a href="{{ route('petugas.laporan.download', array_merge(request()->all(), ['format' => 'excel'])) }}"
                            class="block px-4 py-3 text-sm hover:bg-gray-100">
                            <i class="fas fa-file-excel text-green-600 mr-2"></i>
                            Download Excel
                        </a>

                        <a href="{{ route('petugas.laporan.download', array_merge(request()->all(), ['format' => 'word'])) }}"
                            class="block px-4 py-3 text-sm hover:bg-gray-100">
                            <i class="fas fa-file-word text-blue-600 mr-2"></i>
                            Download Word
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <!-- Pengaduan Grid -->
    @if ($pengaduan->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h3 class="empty-title">Tidak Ada Laporan</h3>
            <p class="empty-description">
                Belum ada laporan yang tersedia untuk ditampilkan
            </p>
        </div>
    @else
        <div class="pengaduan-grid">
            @foreach ($pengaduan as $item)
                <div class="pengaduan-card">
                    <div class="card-header">
                        <div class="card-content">
                            <div class="card-title-row">
                                <h3 class="card-title">{{ $item->judul }}</h3>
                                <span class="status-badge status-{{ strtolower($item->status) }}">
                                    @if ($item->status == 'menunggu')
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
                            </div>

                            <div class="card-kategori">
                                <div class="kategori-item">
                                    <span class="kategori-label">Kategori:</span>
                                    <span class="kategori-value">{{ $item->kategori_utama }}</span>
                                </div>
                                <div class="kategori-item">
                                    <span class="kategori-label">Sub Kategori:</span>
                                    <span class="kategori-value">{{ $item->sub_kategori }}</span>
                                </div>
                            </div>

                            <p class="card-description">
                                {{ Str::limit($item->deskripsi, 180) }}
                            </p>

                            <div class="info-tags">
                                <span class="info-tag">
                                    <i class="fas fa-user"></i>
                                    {{ $item->user->name }}
                                </span>
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
                                @if ($item->foto->count() > 0)
                                    <span class="info-tag"
                                        style="background: #fef3c7; border-color: #fbbf24; color: #92400e;">
                                        <i class="fas fa-images" style="color: #f59e0b;"></i>
                                        {{ $item->foto->count() }} Foto
                                    </span>
                                @endif
                            </div>

                            @if ($item->foto->count())
                                <div class="photo-grid">
                                    @foreach ($item->foto->take(3) as $foto)
                                        <img src="{{ Storage::url($foto->file_path) }}" class="photo-item"
                                            alt="Foto pengaduan">
                                    @endforeach
                                    @if ($item->foto->count() > 3)
                                        <div class="photo-more">
                                            +{{ $item->foto->count() - 3 }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="card-actions">
                            <a href="{{ route('petugas.pengaduan.show', $item) }}" class="action-button action-primary">
                                <i class="fas fa-eye"></i>
                                Lihat Detail
                            </a>

                            <form action="{{ route('petugas.pengaduan.destroy', $item) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus pengaduan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-button action-danger">
                                    <i class="fas fa-trash"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top: 2rem;">
            {{ $pengaduan->links() }}
        </div>
    @endif

@endsection
