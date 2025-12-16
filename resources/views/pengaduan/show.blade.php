@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="mb-6">
    <a href="{{ auth()->user()->isPetugas() ? route('petugas.dashboard') : route('dashboard') }}" class="text-purple-600 hover:text-purple-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>

<div class="grid md:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-start mb-4">
                <h1 class="text-2xl font-bold text-gray-800">{{ $pengaduan->judul }}</h1>
                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $pengaduan->getStatusBadgeClass() }}">
                    {{ $pengaduan->getStatusLabel() }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                <div>
                    <p class="text-gray-500 mb-1"><i class="fas fa-layer-group mr-2"></i>Kategori</p>
                    <p class="font-semibold text-gray-800">{{ $pengaduan->getKategoriLabel() }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1"><i class="fas fa-tag mr-2"></i>Sub Kategori</p>
                    <p class="font-semibold text-gray-800">{{ $pengaduan->getSubKategoriLabel() }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-gray-500 mb-1"><i class="fas fa-calendar mr-2"></i>Tanggal</p>
                    <p class="font-semibold text-gray-800">{{ $pengaduan->tanggal_kejadian->format('d M Y') }}</p>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="font-semibold text-gray-800 mb-2"><i class="fas fa-map-marker-alt mr-2"></i>Lokasi</h3>
                <p class="text-gray-700 mb-3">{{ $pengaduan->lokasi }}</p>
                
                <!-- Leaflet map (will show fallback message if coords missing) -->
                <div id="mapContainer" class="w-full h-80 rounded-lg border border-gray-300 bg-gray-50 overflow-hidden">
                    <div id="map" class="w-full h-full"></div>
                    <div id="mapFallback" class="hidden p-4">
                        <p class="text-gray-600">Koordinat lokasi tidak tersedia. Tidak dapat menampilkan peta.</p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="font-semibold text-gray-800 mb-2"><i class="fas fa-align-left mr-2"></i>Deskripsi</h3>
                <p class="text-gray-700 leading-relaxed">{{ $pengaduan->deskripsi }}</p>
            </div>

            @if($pengaduan->foto->count() > 0)
                <div>
                    <h3 class="font-semibold text-gray-800 mb-3"><i class="fas fa-image mr-2"></i>Foto Bukti</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($pengaduan->foto as $foto)
                            <a href="{{ Storage::url($foto->file_path) }}" target="_blank" class="group">
                                <img src="{{ Storage::url($foto->file_path) }}" alt="Bukti" 
                                    class="w-full h-40 object-cover rounded-lg border border-gray-300 group-hover:border-purple-500 transition">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        @if($pengaduan->tanggapan)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="font-semibold text-blue-900 mb-3 flex items-center">
                    <i class="fas fa-user-shield mr-2"></i>Tanggapan Petugas
                </h3>
                <p class="text-blue-800 leading-relaxed mb-3">{{ $pengaduan->tanggapan }}</p>
                @if($pengaduan->petugas)
                    <p class="text-sm text-blue-600">
                        <i class="fas fa-user mr-1"></i>{{ $pengaduan->petugas->name }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="font-semibold text-gray-800 mb-4"><i class="fas fa-user mr-2"></i>Pelapor</h3>
            <div class="space-y-3 text-sm">
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
                <div class="flex items-start space-x-3">
                    <div class="bg-green-100 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-plus text-green-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-sm text-gray-800">Pengaduan Dibuat</p>
                        <p class="text-xs text-gray-500">{{ $pengaduan->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                @if($pengaduan->status != 'pending')
                    <div class="flex items-start space-x-3">
                        <div class="bg-blue-100 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
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

        @if(!auth()->user()->isPetugas())
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
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
@endsection

@section('scripts')
<!-- Leaflet (Open-source map) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Use Blade's JSON encoding to safely pass PHP values to JS
    const lat = @json($pengaduan->latitude);
    const lng = @json($pengaduan->longitude);
    const title = @json($pengaduan->judul);
    const alamat = @json($pengaduan->lokasi);

    const mapEl = document.getElementById('map');
    const mapFallback = document.getElementById('mapFallback');

    // If coordinates are not present or invalid, hide map and show fallback
    if (lat === null || lng === null || isNaN(Number(lat)) || isNaN(Number(lng))) {
        // hide map div content and show fallback message
        mapEl.style.display = 'none';
        mapFallback.classList.remove('hidden');
        return;
    }

    // Initialize Leaflet map
    const map = L.map('map', {
        center: [Number(lat), Number(lng)],
        zoom: 15,
        scrollWheelZoom: true
    });

    // Tiles (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Marker + popup
    const marker = L.marker([Number(lat), Number(lng)]).addTo(map);
    const popupHtml = `
        <div class="text-sm">
            <strong>${escapeHtml(title)}</strong><br>
            <span>${escapeHtml(alamat)}</span>
        </div>
    `;
    marker.bindPopup(popupHtml);

    // Open popup by default
    marker.openPopup();
});

// simple escape for popup content
function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}
</script>
@endsection
