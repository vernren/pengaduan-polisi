@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="mb-6">
    <a href="{{ auth()->user()->isPetugas() ? route('petugas.dashboard') : route('dashboard') }}" class="text-gray-600 hover:text-gray-800">
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
                <p class="text-gray-700 leading-relaxed
                        break-words
                        overflow-hidden
                        whitespace-pre-line">
                    {{ $pengaduan->deskripsi }}
                </p>

            </div>

            @if($pengaduan->foto->count() > 0)
                <div>
                    <h3 class="font-semibold text-gray-800 mb-3"><i class="fas fa-image mr-2"></i>Foto Bukti</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($pengaduan->foto as $foto)
                            <a href="{{ Storage::url($foto->file_path) }}" target="_blank" class="group">
                                <img src="{{ Storage::url($foto->file_path) }}" alt="Bukti" 
                                    class="w-full h-40 object-cover rounded-lg border border-gray-300 group-hover:border-gray-500 transition">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        @if($pengaduan->tanggapan || $pengaduan->nama_petugas)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
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

        @if($pengaduan->rating)
    <div class="bg-green-50 border border-green-200 rounded-lg p-5 mt-4 max-w-xl">
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

        <!-- ⭐ STAR READ-ONLY -->
        <div class="flex items-center text-xl mb-3">
            @for($i = 1; $i <= 5; $i++)
                <span class="{{ $i <= $pengaduan->rating ? 'text-yellow-400' : 'text-gray-300' }}">
                    ★
                </span>
            @endfor
        </div>

        <!-- 💬 KOMENTAR -->
        @if($pengaduan->feedback)
            <div class="bg-white border border-green-200 rounded p-3 text-sm text-gray-700 italic">
                “{{ $pengaduan->feedback }}”
            </div>
        @endif
    </div>
@endif


        

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

@if($pengaduan->canGiveFeedback() && !$pengaduan->rating)
<div id="feedbackModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">

    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
        <h3 class="text-lg font-bold mb-4 flex items-center">
            ⭐ Berikan Feedback Anda
        </h3>

        <form method="POST" action="{{ route('pengaduan.feedback', $pengaduan) }}">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-2">Rating Pelayanan</label>

                <div id="starRating" class="flex gap-1 text-3xl cursor-pointer select-none">
                    <span data-value="1" class="star text-gray-300">★</span>
                    <span data-value="2" class="star text-gray-300">★</span>
                    <span data-value="3" class="star text-gray-300">★</span>
                    <span data-value="4" class="star text-gray-300">★</span>
                    <span data-value="5" class="star text-gray-300">★</span>
                </div>

                <p id="ratingText" class="text-sm text-gray-600 mt-1">
                    Pilih rating Anda
                </p>

                <!-- nilai asli yang dikirim ke backend -->
                <input type="hidden" name="rating" id="ratingInput" required>
            </div>


            <div class="mb-4">
                <label class="block font-semibold mb-1">Komentar</label>
                <textarea name="feedback"
                          rows="4"
                          required
                          class="w-full border rounded px-3 py-2"
                          placeholder="Tuliskan pengalaman Anda..."></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeFeedbackModal()"
                        class="px-4 py-2 border rounded">
                    Nanti
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-gray-600 text-white rounded">
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

    const kategori = @json($pengaduan->kategori_utama );
    const lat  = @json($pengaduan->latitude);
    const lng  = @json($pengaduan->longitude);
    const slat = @json($pengaduan->start_latitude);
    const slng = @json($pengaduan->start_longitude);
    const elat = @json($pengaduan->end_latitude);
    const elng = @json($pengaduan->end_longitude);

    const mapEl = document.getElementById('map');
    const fallback = document.getElementById('mapFallback');

    if (!mapEl) return;

    // =========================
    // INIT MAP (SINGLE SOURCE)
    // =========================
    window.leafletMap = L.map(mapEl, {
        center: [-6.2, 106.8],
        zoom: 13,
        scrollWheelZoom: true
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(window.leafletMap);

    // =========================
    // MODE: PENGADUAN (1 TITIK)
    // =========================
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

    // =========================
    // MODE: PERMINTAAN (2 TITIK)
    // =========================
if (kategori === 'permintaan') {
    if (!slat || !slng || !elat || !elng) {
        mapEl.style.display = 'none';
        fallback.classList.remove('hidden');
        return;
    }

    // =====================
    // MARKER MANUAL (FIX)
    // =====================
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

    // =====================
    // ROUTING (TANPA MARKER DUPLIKAT)
    // =====================
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



});
</script>


{{-- ===============================
     FEEDBACK MODAL (AUTO POPUP)
     =============================== --}}
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
});

document.addEventListener('DOMContentLoaded', function () {
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
@endsection

<style>
    /* FIX: Leaflet attribution muncul di atas modal feedback */
    #feedbackModal .leaflet-control-attribution,
    #feedbackModal .leaflet-control {
        display: none !important;
    }

    /* Pastikan modal benar-benar di atas map */
    #feedbackModal {
        z-index: 9999 !important;
    }
</style>

