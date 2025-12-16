@extends('layouts.app')

@section('title', 'Buat Pengaduan - Pengaduan Polisi')

@section('content')
{{-- Leaflet CSS (bisa juga dimasukkan ke <head> layout jika prefer) --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-purple-600 hover:text-purple-800">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fas fa-file-alt text-purple-600 mr-2"></i>Buat Laporan Baru
        </h2>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" id="pengaduanForm">
            @csrf
            
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-heading mr-2"></i>Judul Laporan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="judul" value="{{ old('judul') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                    placeholder="Contoh: Permintaan Pengawalan Acara">
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-layer-group mr-2"></i>Kategori Utama <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori_utama" id="kategori_utama" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                        <option value="">Pilih Kategori</option>
                        {{-- <option value="informasi" {{ old('kategori_utama') == 'informasi' ? 'selected' : '' }}>Informasi</option> --}}
                        <option value="pengaduan" {{ old('kategori_utama') == 'pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                        <option value="permintaan" {{ old('kategori_utama') == 'permintaan' ? 'selected' : '' }}>Permintaan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tag mr-2"></i>Sub Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="sub_kategori" id="sub_kategori" required disabled
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                        <option value="">Pilih Kategori Utama Dahulu</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-calendar mr-2"></i>Tanggal<span class="text-red-500">*</span>
                </label>
                <input type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}" required max="{{ date('Y-m-d') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
            </div>

            <div class="mb-6 relative">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-map-marker-alt mr-2"></i>Lokasi<span class="text-red-500">*</span>
                </label>
                <input type="text" id="searchLocation" name="lokasi" value="{{ old('lokasi') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                    placeholder="Ketik untuk mencari lokasi atau klik pada peta" autocomplete="off">
                
                <!-- Suggestions container (will be positioned by JS) -->
                <div id="nominatim-suggestions" class="absolute left-0 right-0 mt-1 z-50"></div>

                <!-- Hidden inputs untuk koordinat -->
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                
                <!-- Leaflet Map -->
                <div id="map" class="w-full h-96 rounded-lg border border-gray-300 mt-3"></div>
                <p class="text-sm text-gray-500 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Ketik alamat atau klik pada peta untuk menandai lokasi
                </p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-align-left mr-2"></i>Deskripsi<span class="text-red-500">*</span>
                </label>
                <textarea name="deskripsi" required rows="6"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                    placeholder="Jelaskan deskripsi laporan secara detail...">{{ old('deskripsi') }}</textarea>
                <p class="text-sm text-gray-500 mt-2">Minimal 50 karakter</p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-camera mr-2"></i>Foto Bukti (Opsional)
                </label>
                <input type="file" name="foto[]" multiple accept="image/*" id="fotoInput"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB per foto. Bisa upload beberapa foto.</p>
                
                <div id="previewContainer" class="mt-4 grid grid-cols-4 gap-4"></div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-yellow-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Perhatian:</strong> Pastikan semua informasi yang Anda berikan akurat dan sesuai fakta. Laporan palsu dapat dikenakan sanksi hukum.
                </p>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="flex-1 gradient-bg text-white py-3 rounded-lg hover:opacity-90 transition font-semibold">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Laporan
                </button>
                <a href="{{ route('dashboard') }}" class="px-8 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold text-gray-700">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<!-- Leaflet JS & Control Geocoder -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
/*
 Full Leaflet + OpenStreetMap + Nominatim integration (open-source)
 NOTE: Nominatim public server has rate-limits. For production use self-hosting or paid geocoding.
 Replace 'contact@domain.com' in USER_AGENT variable with a valid contact email or app id.
*/

// Config: User-Agent for Nominatim requests (change to your app/email)
const USER_AGENT = 'PengaduanApp/1.0 (contact@domain.com)'; // <-- GANTI dengan email nyata

// Sub kategori options (sama seperti sebelumnya)
const subKategoriOptions = {
    informasi: {
        'pembuatan_sim': 'Pembuatan SIM',
        'perpanjangan_sim': 'Perpanjangan SIM',
        'pembuatan_skck': 'Pembuatan SKCK',
        'laporan_kehilangan': 'Laporan Kehilangan',
        'surat_keterangan': 'Surat Keterangan',
        'izin_keramaian': 'Izin Keramaian',
        'informasi_umum': 'Informasi Umum'
    },
    pengaduan: {
        'kecelakaan_lalu_lintas': 'Kecelakaan Lalu Lintas',
        'pencurian': 'Pencurian',
        'penipuan': 'Penipuan',
        'kekerasan': 'Kekerasan/Penganiayaan',
        'narkoba': 'Narkoba/NAPZA',
        'perjudian': 'Perjudian',
        'pelanggaran_lalu_lintas': 'Pelanggaran Lalu Lintas',
        'gangguan_kamtibmas': 'Gangguan Kamtibmas',
        'kejahatan_siber': 'Kejahatan Siber',
        'pengaduan_lainnya': 'Lainnya'
    },
    permintaan: {
        'pengawalan': 'Pengawalan'
    }
};

// Update subkategori saat change
document.getElementById('kategori_utama').addEventListener('change', function() {
    const kategori = this.value;
    const subKategoriSelect = document.getElementById('sub_kategori');
    
    subKategoriSelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
    
    if (kategori && subKategoriOptions[kategori]) {
        subKategoriSelect.disabled = false;
        
        Object.entries(subKategoriOptions[kategori]).forEach(([value, label]) => {
            const option = document.createElement('option');
            option.value = value;
            option.textContent = label;
            subKategoriSelect.appendChild(option);
        });
    } else {
        subKategoriSelect.disabled = true;
    }
});

// Preview foto (sama seperti sebelumnya)
document.getElementById('fotoInput').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('previewContainer');
    previewContainer.innerHTML = '';
    
    Array.from(e.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(event) {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `
                <img src="${event.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-300">
                <span class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 rounded-b-lg truncate">${file.name}</span>
            `;
            previewContainer.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});

// Form validation ditahan sampai lokasi terisi
document.getElementById('pengaduanForm').addEventListener('submit', function(e) {
    const latitude = document.getElementById('latitude').value;
    const longitude = document.getElementById('longitude').value;
    
    if (!latitude || !longitude) {
        e.preventDefault();
        alert('Silakan pilih lokasi pada peta terlebih dahulu!');
        return false;
    }
});

// --- Leaflet + Nominatim logic ---
let map, marker;
let suggestionBox;

// helper: update hidden inputs
function updateCoordinatesLatLng(lat, lng) {
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
}

// Reverse geocode (Nominatim)
async function reverseGeocodeNominatim(lat, lng) {
    try {
        const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lng)}`;
        const res = await fetch(url, {
            headers: { 'Accept': 'application/json', 'User-Agent': USER_AGENT }
        });
        if (!res.ok) return;
        const data = await res.json();
        if (data && data.display_name) {
            document.getElementById('searchLocation').value = data.display_name;
        }
    } catch (err) {
        console.warn('Reverse geocode failed', err);
    }
}

// Place marker helper
function placeMarkerAndPanTo(lat, lng, displayName = null) {
    marker.setLatLng([lat, lng]);
    marker.addTo(map);
    map.panTo([lat, lng]);
    updateCoordinatesLatLng(lat, lng);
    if (displayName) {
        document.getElementById('searchLocation').value = displayName;
    } else {
        reverseGeocodeNominatim(lat, lng);
    }
}

// Initialize suggestion box and search-autocomplete using Nominatim
let searchTimeout = null;
function setupSearchAutocomplete() {
    const input = document.getElementById('searchLocation');
    suggestionBox = document.getElementById('nominatim-suggestions');

    // style suggestion box (Tailwind classes)
    suggestionBox.className = 'bg-white border border-gray-200 rounded shadow overflow-hidden';

    // ensure suggestionBox positioned under the input
    function positionSuggestionBox() {
        const rect = input.getBoundingClientRect();
        suggestionBox.style.top = (input.offsetTop + input.offsetHeight + 4) + 'px';
        suggestionBox.style.left = input.offsetLeft + 'px';
        suggestionBox.style.width = input.offsetWidth + 'px';
    }
    positionSuggestionBox();
    window.addEventListener('resize', positionSuggestionBox);

    input.addEventListener('input', function() {
        const q = this.value.trim();
        suggestionBox.innerHTML = '';
        if (searchTimeout) clearTimeout(searchTimeout);
        if (q.length < 3) return;

        // debounce
        searchTimeout = setTimeout(async () => {
            try {
                const url = `https://nominatim.openstreetmap.org/search?format=jsonv2&q=${encodeURIComponent(q)}&addressdetails=1&limit=6&countrycodes=id`;
                const res = await fetch(url, {
                    headers: { 'Accept': 'application/json', 'User-Agent': USER_AGENT }
                });
                if (!res.ok) return;
                const results = await res.json();
                suggestionBox.innerHTML = '';
                if (!results || results.length === 0) {
                    const empty = document.createElement('div');
                    empty.className = 'p-2 text-sm text-gray-500';
                    empty.textContent = 'Tidak ada hasil';
                    suggestionBox.appendChild(empty);
                    return;
                }
                results.forEach(r => {
                    const item = document.createElement('div');
                    item.className = 'p-2 cursor-pointer hover:bg-gray-100 text-sm';
                    item.textContent = r.display_name;
                    item.addEventListener('click', function() {
                        const lat = parseFloat(r.lat);
                        const lon = parseFloat(r.lon);
                        placeMarkerAndPanTo(lat, lon, r.display_name);
                        suggestionBox.innerHTML = '';
                    });
                    suggestionBox.appendChild(item);
                });
            } catch (err) {
                console.warn('Search failed', err);
            }
        }, 300);
    });

    // hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        const inputRect = input.getBoundingClientRect();
        if (!input.contains(e.target) && !suggestionBox.contains(e.target)) {
            suggestionBox.innerHTML = '';
        }
    });
}

// Initialize Leaflet map
function initMapLeaflet() {
    const defaultLatLng = [-6.2088, 106.8456]; // Jakarta

    map = L.map('map', { center: defaultLatLng, zoom: 13, scrollWheelZoom: true });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    marker = L.marker(defaultLatLng, { draggable: true });

    // When marker dragged -> update coords + reverse geocode
    marker.on('dragend', function(e) {
        const pos = e.target.getLatLng();
        updateCoordinatesLatLng(pos.lat, pos.lng);
        reverseGeocodeNominatim(pos.lat, pos.lng);
    });

    // Click on map -> move/add marker
    map.on('click', function(e) {
        placeMarkerAndPanTo(e.latlng.lat, e.latlng.lng);
    });

    // Try using browser geolocation to center map & marker
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            map.setView([lat, lng], 15);
            placeMarkerAndPanTo(lat, lng);
        }, function(err) {
            console.warn('Geolocation failed or denied', err);
        });
    }

    // Add scale control
    L.control.scale().addTo(map);

    // Add built-in geocoder control if plugin available
    if (L.Control && L.Control.Geocoder) {
        const geocoderControl = L.Control.geocoder({
            defaultMarkGeocode: false,
            geocoder: L.Control.Geocoder.nominatim()
        }).on('markgeocode', function(e) {
            const latlng = e.geocode.center;
            placeMarkerAndPanTo(latlng.lat, latlng.lng, e.geocode.name || e.geocode.html || '');
        }).addTo(map);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    initMapLeaflet();
    setupSearchAutocomplete();

    // position suggestion box initially (in case layout changed)
    const input = document.getElementById('searchLocation');
    const suggestionBoxEl = document.getElementById('nominatim-suggestions');
    if (input && suggestionBoxEl) {
        suggestionBoxEl.style.position = 'absolute';
        suggestionBoxEl.style.zIndex = '10000';
        suggestionBoxEl.style.maxHeight = '260px';
        suggestionBoxEl.style.overflowY = 'auto';
    }
});
</script>
@endsection
