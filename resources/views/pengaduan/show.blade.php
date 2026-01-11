@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<style>
    /* ==================== RESPONSIVE STYLES ==================== */
    
    /* Base Styles */
    .detail-wrapper {
        width: 100%;
        margin: 0 auto;
    }

    /* Back Button */
    .back-button {
        margin-bottom: 1.5rem;
        display: inline-flex;
        align-items: center;
        color: #4b5563;
        transition: all 0.2s;
    }

    .back-button:hover {
        color: #1f2937;
    }

    /* Status Badge */
    .status-badge-responsive {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        white-space: nowrap;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    /* Map Container */
    .map-container-responsive {
        width: 100%;
        height: 320px;
        border-radius: 0.5rem;
        overflow: hidden;
        border: 1px solid #d1d5db;
    }

    /* Photo Grid */
    .photo-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    .photo-item {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 1px solid #d1d5db;
        transition: all 0.2s;
    }

    .photo-item:hover {
        border-color: #6b7280;
        transform: scale(1.02);
    }

    /* Timeline */
    .timeline-item {
        display: flex;
        align-items: start;
        gap: 0.75rem;
    }

    .timeline-icon {
        width: 2rem;
        height: 2rem;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Feedback Modal */
    .modal-content {
        width: 100%;
        max-width: 28rem;
        padding: 1.5rem;
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    /* Star Rating */
    .star-rating {
        display: flex;
        gap: 0.25rem;
        font-size: 2rem;
        cursor: pointer;
        user-select: none;
    }

    .star {
        transition: all 0.2s;
    }

    .star:hover {
        transform: scale(1.1);
    }

    /* ==================== TABLET (768px - 1024px) ==================== */
    @media (max-width: 1024px) {
        .info-grid {
            gap: 0.875rem;
        }

        .photo-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.875rem;
        }
    }

    /* ==================== MOBILE (max-width: 768px) ==================== */
    @media (max-width: 768px) {
        .detail-wrapper {
            padding: 0;
        }

        /* Back Button */
        .back-button {
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        /* Main Grid - Stack to Single Column */
        .grid.md\\:grid-cols-3 {
            grid-template-columns: 1fr !important;
        }

        /* Header Title & Status */
        .header-title-section {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 0.75rem;
        }

        .header-title-section h1 {
            font-size: 1.25rem;
            line-height: 1.4;
        }

        .status-badge-responsive {
            padding: 0.375rem 0.875rem;
            font-size: 0.8125rem;
        }

        /* Info Grid - Stack to Single Column */
        .info-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        /* Map */
        .map-container-responsive {
            height: 250px;
            margin-bottom: 1rem;
        }

        /* Description Text */
        .description-text {
            font-size: 0.875rem;
            line-height: 1.6;
        }

        /* Photo Grid - 2 Columns on Mobile */
        .photo-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .photo-item {
            height: 120px;
        }

        /* Cards */
        .bg-white.rounded-lg {
            padding: 1rem !important;
            margin-bottom: 1rem;
        }

        /* Sidebar Order - Move to Bottom */
        .sidebar-section {
            order: 2;
        }

        .main-content-section {
            order: 1;
        }

        /* Timeline */
        .timeline-icon {
            width: 1.75rem;
            height: 1.75rem;
        }

        .timeline-item p {
            font-size: 0.8125rem;
        }

        /* Pelapor Info */
        .pelapor-info {
            font-size: 0.8125rem;
        }

        /* Feedback Modal */
        .modal-content {
            margin: 1rem;
            padding: 1.25rem;
            max-width: calc(100% - 2rem);
        }

        .star-rating {
            font-size: 1.75rem;
        }

        /* Tanggapan Petugas */
        .tanggapan-section {
            padding: 1rem !important;
        }

        .tanggapan-section p {
            font-size: 0.875rem;
        }

        /* Rating Card */
        .rating-card {
            padding: 1rem !important;
            margin-top: 1rem;
        }

        .rating-stars {
            font-size: 1.25rem;
        }
    }

    /* ==================== SMALL MOBILE (max-width: 480px) ==================== */
    @media (max-width: 480px) {
        /* Back Button */
        .back-button {
            font-size: 0.8125rem;
            margin-bottom: 0.875rem;
        }

        /* Title */
        .header-title-section h1 {
            font-size: 1.125rem;
        }

        /* Status Badge */
        .status-badge-responsive {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }

        /* Cards Padding */
        .bg-white.rounded-lg {
            padding: 0.875rem !important;
            border-radius: 0.5rem;
        }

        /* Map */
        .map-container-responsive {
            height: 220px;
        }

        /* Info Items */
        .info-item {
            font-size: 0.8125rem;
        }

        .info-item .text-gray-500 {
            font-size: 0.75rem;
        }

        /* Description */
        .description-text {
            font-size: 0.8125rem;
            line-height: 1.5;
        }

        /* Photo Grid - Single Column for Very Small Screens */
        .photo-grid {
            grid-template-columns: 1fr;
            gap: 0.625rem;
        }

        .photo-item {
            height: 180px;
        }

        /* Timeline */
        .timeline-icon {
            width: 1.5rem;
            height: 1.5rem;
            font-size: 0.75rem;
        }

        .timeline-item {
            gap: 0.625rem;
        }

        .timeline-item p {
            font-size: 0.75rem;
        }

        /* Pelapor Section */
        .pelapor-info {
            font-size: 0.75rem;
        }

        .pelapor-info .font-semibold {
            font-size: 0.8125rem;
        }

        /* Buttons in Modal */
        .modal-buttons button {
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
        }

        /* Star Rating */
        .star-rating {
            font-size: 1.5rem;
            gap: 0.125rem;
        }

        /* Textarea */
        textarea {
            font-size: 0.875rem;
            padding: 0.625rem 0.75rem;
        }

        /* Emergency Contact */
        .emergency-contact {
            padding: 0.875rem !important;
        }

        .emergency-contact p {
            font-size: 0.75rem;
        }

        /* Tanggapan */
        .tanggapan-section {
            padding: 0.875rem !important;
        }

        .tanggapan-section h3 {
            font-size: 0.9375rem;
        }

        .tanggapan-section p {
            font-size: 0.8125rem;
        }

        /* Rating Display */
        .rating-card {
            padding: 0.875rem !important;
        }

        .rating-stars {
            font-size: 1.125rem;
        }
    }

    /* ==================== EXTRA SMALL MOBILE (max-width: 360px) ==================== */
    @media (max-width: 360px) {
        .header-title-section h1 {
            font-size: 1rem;
        }

        .map-container-responsive {
            height: 200px;
        }

        .photo-item {
            height: 160px;
        }

        .modal-content {
            margin: 0.75rem;
            padding: 1rem;
        }

        .star-rating {
            font-size: 1.25rem;
        }
    }

    /* ==================== LANDSCAPE MODE ==================== */
    @media (max-height: 600px) and (orientation: landscape) {
        .map-container-responsive {
            height: 180px;
        }

        .modal-content {
            max-height: 90vh;
            overflow-y: auto;
        }

        .photo-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .photo-item {
            height: 120px;
        }
    }

    /* ==================== TOUCH OPTIMIZATIONS ==================== */
    @media (hover: none) and (pointer: coarse) {
        /* Larger touch targets */
        .back-button {
            padding: 0.5rem;
            margin: -0.5rem;
        }

        .star {
            padding: 0.25rem;
        }

        /* Disable hover effects on touch */
        .photo-item:hover {
            transform: none;
            border-color: #d1d5db;
        }

        .back-button:hover {
            color: #4b5563;
        }
    }

    /* FIX: Leaflet attribution in modal */
    #feedbackModal .leaflet-control-attribution,
    #feedbackModal .leaflet-control {
        display: none !important;
    }

    #feedbackModal {
        z-index: 9999 !important;
    }

    /* Prevent horizontal scroll */
    body {
        overflow-x: hidden;
    }

    /* Ensure images don't overflow */
    img {
        max-width: 100%;
        height: auto;
    }
</style>

<div class="detail-wrapper">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ auth()->user()->isPetugas() ? route('petugas.dashboard') : route('dashboard') }}" 
           class="back-button">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="md:col-span-2 space-y-6 main-content-section">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-start mb-4 header-title-section">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $pengaduan->judul }}</h1>
                    <span class="status-badge-responsive {{ $pengaduan->getStatusBadgeClass() }}">
                        {{ $pengaduan->getStatusLabel() }}
                    </span>
                </div>

                <div class="info-grid mb-6 text-sm">
                    <div class="info-item">
                        <p class="text-gray-500 mb-1"><i class="fas fa-layer-group mr-2"></i>Kategori</p>
                        <p class="font-semibold text-gray-800">{{ $pengaduan->getKategoriLabel() }}</p>
                    </div>
                    <div class="info-item">
                        <p class="text-gray-500 mb-1"><i class="fas fa-tag mr-2"></i>Sub Kategori</p>
                        <p class="font-semibold text-gray-800">{{ $pengaduan->getSubKategoriLabel() }}</p>
                    </div>
                    <div class="col-span-2 info-item">
                        <p class="text-gray-500 mb-1"><i class="fas fa-calendar mr-2"></i>Tanggal</p>
                        <p class="font-semibold text-gray-800">{{ $pengaduan->tanggal_kejadian->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 mb-2"><i class="fas fa-map-marker-alt mr-2"></i>Lokasi</h3>
                    <p class="text-gray-700 mb-3">{{ $pengaduan->lokasi }}</p>
                    
                    <!-- Leaflet map -->
                    <div id="mapContainer" class="map-container-responsive bg-gray-50">
                        <div id="map" class="w-full h-full"></div>
                        <div id="mapFallback" class="hidden p-4">
                            <p class="text-gray-600 text-sm">Koordinat lokasi tidak tersedia. Tidak dapat menampilkan peta.</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 mb-2"><i class="fas fa-align-left mr-2"></i>Deskripsi</h3>
                    <p class="description-text text-gray-700 leading-relaxed break-words overflow-hidden whitespace-pre-line">
                        {{ $pengaduan->deskripsi }}
                    </p>
                </div>

                @if($pengaduan->foto->count() > 0)
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-3"><i class="fas fa-image mr-2"></i>Foto Bukti</h3>
                        <div class="photo-grid">
                            @foreach($pengaduan->foto as $foto)
                                <a href="{{ Storage::url($foto->file_path) }}" target="_blank" class="group">
                                    <img src="{{ Storage::url($foto->file_path) }}" alt="Bukti" 
                                        class="photo-item">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            @if($pengaduan->tanggapan || $pengaduan->nama_petugas)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 tanggapan-section">
                    <h3 class="font-semibold text-blue-900 mb-3 flex items-center">
                        <i class="fas fa-user-shield mr-2"></i>Tanggapan Petugas
                    </h3>

                    @if($pengaduan->tanggapan)
                        <p class="text-blue-800 leading-relaxed mb-3">
                            {{ $pengaduan->tanggapan }}
                        </p>
                    @endif

                    @if($pengaduan->nama_petugas)
                        <p class="text-sm text-blue-700 font-semibold">
                            <i class="fas fa-user mr-1"></i>
                            Nama Petugas : {{ $pengaduan->nama_petugas }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6 sidebar-section">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-4"><i class="fas fa-user mr-2"></i>Pelapor</h3>
                <div class="space-y-3 text-sm pelapor-info">
                    <div>
                        <p class="text-gray-500">Nama</p>
                        <p class="font-semibold text-gray-800">{{ $pengaduan->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-semibold text-gray-800">{{ $pengaduan->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Telepon</p>
                        <p class="font-semibold text-gray-800">{{ $pengaduan->user->phone }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-4"><i class="fas fa-clock mr-2"></i>Timeline</h3>
                <div class="space-y-4">
                    <div class="timeline-item">
                        <div class="timeline-icon bg-green-100">
                            <i class="fas fa-plus text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-gray-800">Pengaduan Dibuat</p>
                            <p class="text-xs text-gray-500">{{ $pengaduan->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    @if($pengaduan->status != 'pending')
                        <div class="timeline-item">
                            <div class="timeline-icon bg-blue-100">
                                <i class="fas fa-check text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-800">Status Diperbarui</p>
                                <p class="text-xs text-gray-500">{{ $pengaduan->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if($pengaduan->rating)
                <div class="bg-green-50 border border-green-200 rounded-lg p-5 rating-card">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-semibold text-green-900 flex items-center">
                            ⭐ Penilaian Anda
                        </h3>

                        <span class="text-sm font-semibold text-green-700">
                            @switch($pengaduan->rating)
                                @case(5) Sangat Puas @break
                                @case(4) Puas @break
                                @case(3) Cukup @break
                                @case(2) Kurang @break
                                @default Tidak Puas
                            @endswitch
                        </span>
                    </div>

                    <!-- Star Display -->
                    <div class="flex items-center text-xl mb-3 rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $pengaduan->rating ? 'text-yellow-400' : 'text-gray-300' }}">
                                ★
                            </span>
                        @endfor
                    </div>

                    <!-- Feedback -->
                    @if($pengaduan->feedback)
                        <div class="bg-white border border-green-200 rounded p-3 text-sm text-gray-700 italic">
                            "{{ $pengaduan->feedback }}"
                        </div>
                    @endif
                </div>
            @endif

            @if(!auth()->user()->isPetugas())
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 emergency-contact">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Jika ada pertanyaan, hubungi:
                    </p>
                    <p class="text-sm font-semibold text-yellow-900 mt-2">
                        <i class="fas fa-phone mr-2"></i>110 (Darurat)
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@if($pengaduan->canGiveFeedback() && !$pengaduan->rating)
<div id="feedbackModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 p-4">

    <div class="modal-content">
        <h3 class="text-lg font-bold mb-4 flex items-center">
            ⭐ Berikan Feedback Anda
        </h3>

        <form method="POST" action="{{ route('pengaduan.feedback', $pengaduan) }}">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-2">Rating Pelayanan</label>

                <div id="starRating" class="star-rating">
                    <span data-value="1" class="star text-gray-300">★</span>
                    <span data-value="2" class="star text-gray-300">★</span>
                    <span data-value="3" class="star text-gray-300">★</span>
                    <span data-value="4" class="star text-gray-300">★</span>
                    <span data-value="5" class="star text-gray-300">★</span>
                </div>

                <p id="ratingText" class="text-sm text-gray-600 mt-1">
                    Pilih rating Anda
                </p>

                <input type="hidden" name="rating" id="ratingInput" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Komentar</label>
                <textarea name="feedback"
                          rows="4"
                          required
                          class="w-full border rounded px-3 py-2 text-sm"
                          placeholder="Tuliskan pengalaman Anda... Minimal 10 karakter"></textarea>
            </div>

            <div class="flex justify-end gap-2 modal-buttons">
                <button type="button"
                        onclick="closeFeedbackModal()"
                        class="px-4 py-2 border rounded hover:bg-gray-50 transition">
                    Nanti
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                    Kirim Feedback
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const kategori = @json($pengaduan->kategori_utama);
    const lat  = @json($pengaduan->latitude);
    const lng  = @json($pengaduan->longitude);
    const slat = @json($pengaduan->start_latitude);
    const slng = @json($pengaduan->start_longitude);
    const elat = @json($pengaduan->end_latitude);
    const elng = @json($pengaduan->end_longitude);

    const mapEl = document.getElementById('map');
    const fallback = document.getElementById('mapFallback');

    if (!mapEl) return;

    // Init Map
    window.leafletMap = L.map(mapEl, {
        center: [-6.2, 106.8],
        zoom: 13,
        scrollWheelZoom: true
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(window.leafletMap);

    // Mode: Pengaduan (1 Point)
    if (kategori === 'pengaduan') {
        if (!lat || !lng) {
            mapEl.style.display = 'none';
            fallback.classList.remove('hidden');
            return;
        }

        L.marker([Number(lat), Number(lng)])
            .addTo(window.leafletMap)
            .bindPopup('Lokasi Kejadian');

        window.leafletMap.setView([Number(lat), Number(lng)], 15);
    }

    // Mode: Permintaan (2 Points + Routing)
    if (kategori === 'permintaan') {
        if (!slat || !slng || !elat || !elng) {
            mapEl.style.display = 'none';
            fallback.classList.remove('hidden');
            return;
        }

        // Manual Markers
        L.marker([Number(slat), Number(slng)], {
            icon: L.icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
                iconSize: [32, 32]
            })
        }).addTo(window.leafletMap)
          .bindPopup('Titik Awal');

        L.marker([Number(elat), Number(elng)], {
            icon: L.icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                iconSize: [32, 32]
            })
        }).addTo(window.leafletMap)
          .bindPopup('Titik Akhir');

        // Routing
        L.Routing.control({
            waypoints: [
                L.latLng(Number(slat), Number(slng)),
                L.latLng(Number(elat), Number(elng))
            ],
            router: L.Routing.osrmv1({
                serviceUrl: 'https://router.project-osrm.org/route/v1'
            }),
            addWaypoints: false,
            draggableWaypoints: false,
            fitSelectedRoutes: true,
            show: false,
            createMarker: () => null
        }).addTo(window.leafletMap);

        window.leafletMap.fitBounds([
            [Number(slat), Number(slng)],
            [Number(elat), Number(elng)]
        ]);
    }

    // Fix map size after modal
    setTimeout(() => {
        if (window.leafletMap) {
            window.leafletMap.invalidateSize();
        }
    }, 300);
});
</script>

{{-- Feedback Modal Scripts --}}
@if($pengaduan->canGiveFeedback())
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('feedbackModal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            if (window.leafletMap) {
                window.leafletMap.invalidateSize();
            }
        }, 300);
    }

    // Star Rating
    const stars = document.querySelectorAll('#starRating .star');
    const ratingInput = document.getElementById('ratingInput');
    const ratingText = document.getElementById('ratingText');

    const labels = {
        1: 'Tidak Puas',
        2: 'Kurang',
        3: 'Cukup',
        4: 'Puas',
        5: 'Sangat Puas'
    };

    let selectedRating = 0;

    stars.forEach(star => {
        star.addEventListener('mouseenter', () => {
            highlightStars(star.dataset.value);
        });

        star.addEventListener('mouseleave', () => {
            highlightStars(selectedRating);
        });

        star.addEventListener('click', () => {
            selectedRating = star.dataset.value;
            ratingInput.value = selectedRating;
            ratingText.textContent = labels[selectedRating];
        });
    });

    function highlightStars(rating) {
        stars.forEach(star => {
            star.classList.toggle(
                'text-yellow-400',
                star.dataset.value <= rating
            );
            star.classList.toggle(
                'text-gray-300',
                star.dataset.value > rating
            );
        });
    }
});

function closeFeedbackModal() {
    const modal = document.getElementById('feedbackModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}
</script>
@endif