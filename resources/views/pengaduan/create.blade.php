@extends('layouts.app')

@section('title', 'Buat Pengaduan - Pengaduan Polisi')

@section('content')
<<<<<<< HEAD
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-purple-600 hover:text-purple-800">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                <i class="fas fa-file-alt text-purple-600 mr-2"></i>Buat Pengaduan Baru
            </h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-heading mr-2"></i>Judul Pengaduan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                        placeholder="Contoh: Pencurian Motor di Parkiran">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tag mr-2"></i>Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                        <option value="">Pilih Kategori</option>
                        <option value="pencurian" {{ old('kategori') == 'pencurian' ? 'selected' : '' }}>Pencurian</option>
                        <option value="kekerasan" {{ old('kategori') == 'kekerasan' ? 'selected' : '' }}>Kekerasan</option>
                        <option value="narkoba" {{ old('kategori') == 'narkoba' ? 'selected' : '' }}>Narkoba</option>
                        <option value="lalu_lintas" {{ old('kategori') == 'lalu_lintas' ? 'selected' : '' }}>Lalu Lintas
                        </option>
                        <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
=======
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css"/>

<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-purple-600 hover:text-purple-800">
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6">Buat Pengaduan Baru</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- JUDUL --}}
            <div class="mb-4">
                <label class="font-semibold">Judul Pengaduan *</label>
                <input type="text" name="judul" required
                    class="w-full border px-3 py-2 rounded"
                    placeholder="Contoh: Permintaan Pengawalan Acara">
            </div>

            {{-- KATEGORI --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="font-semibold">Kategori Utama *</label>
                    <select name="kategori_utama" id="kategori_utama" required
                        class="w-full border px-3 py-2 rounded">
                        <option value="">Pilih</option>
                        <option value="pengaduan">Pengaduan</option>
                        <option value="permintaan">Permintaan (Pengawalan)</option>
                    </select>
                </div>

                <div>
                    <label class="font-semibold">Sub Kategori *</label>
                    <select name="sub_kategori" id="sub_kategori" required
                        class="w-full border px-3 py-2 rounded" disabled>
                        <option value="">Pilih kategori dahulu</option>
                    </select>
>>>>>>> origin/main
                </div>

<<<<<<< HEAD
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>Lokasi Kejadian <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                            placeholder="Jl. Contoh No. 123, Jakarta">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-calendar mr-2"></i>Tanggal Kejadian <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}" required
                            max="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-align-left mr-2"></i>Deskripsi Kejadian <span class="text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi" required rows="6"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                        placeholder="Jelaskan kronologi kejadian secara detail...">{{ old('deskripsi') }}</textarea>
                    <p class="text-sm text-gray-500 mt-2">Minimal 50 karakter</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-camera mr-2"></i>Foto Bukti (Opsional)
                    </label>
                    <input type="file" name="foto[]" multiple accept="image/*" id="fotoInput"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                    <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB per foto. Bisa upload beberapa
                        foto.</p>

                    <div id="previewContainer" class="mt-4 grid grid-cols-4 gap-4"></div>
=======
            {{-- TANGGAL --}}
            <div class="mb-4">
                <label class="font-semibold" id="tanggalLabel">Tanggal *</label>
                <input type="date" name="tanggal_kejadian" id="tanggal_kejadian" required
                    class="w-full border px-3 py-2 rounded">
            </div>

            {{-- MODE PENGAWALAN --}}
            <div class="mb-3 hidden" id="routeModeWrapper">
                <label class="font-semibold">Mode Penentuan Titik *</label>
                <div class="flex gap-6 mt-1">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="route_mode" value="start" checked>
                        Titik Awal
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="route_mode" value="end">
                        Titik Akhir
                    </label>
>>>>>>> origin/main
                </div>

<<<<<<< HEAD
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Perhatian:</strong> Pastikan semua informasi yang Anda berikan akurat dan sesuai fakta.
                        Laporan palsu dapat dikenakan sanksi hukum.
                    </p>
                </div>

                <div class="flex space-x-4">
                    <button type="submit"
                        class="flex-1 gradient-bg text-white py-3 rounded-lg hover:opacity-90 transition font-semibold">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Pengaduan
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="px-8 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold text-gray-700">
                        Batal
                    </a>
                </div>
            </form>
        </div>
=======
            {{-- CARI ALAMAT --}}
            <div class="mb-4 relative">
                <label class="font-semibold">Cari Alamat *</label>
                <input type="text" id="searchLocation"
                    class="w-full border px-3 py-2 rounded"
                    placeholder="Ketik alamat lalu pilih"
                    autocomplete="off">
                
                {{-- DROPDOWN LANGSUNG DI BAWAH INPUT --}}
                <div id="suggestions"
                    class="absolute left-0 right-0 bg-white border rounded shadow hidden"
                    style="z-index: 10000; max-height: 260px; overflow-y: auto; top: 100%; margin-top: 2px;">
                </div>
            </div>

            {{-- MAP --}}
            <div class="mb-4">
                <label class="font-semibold" id="mapLabel">Lokasi *</label>
                <div id="map" class="h-96 border rounded" style="z-index: 1;"></div>

                <div class="flex justify-between text-sm text-gray-600 mt-2">
                    <span>
                        Pengaduan: 1 titik | Permintaan: 2 titik + rute jalan
                    </span>
                    <button type="button" id="resetMap" class="text-red-600 hover:underline">
                        Reset Lokasi
                    </button>
                </div>
            </div>

            {{-- HIDDEN INPUT --}}
            <input type="hidden" name="lokasi" id="lokasi">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <input type="hidden" name="start_latitude" id="start_latitude">
            <input type="hidden" name="start_longitude" id="start_longitude">
            <input type="hidden" name="end_latitude" id="end_latitude">
            <input type="hidden" name="end_longitude" id="end_longitude">

            {{-- DESKRIPSI --}}
            <div class="mb-4">
                <label class="font-semibold">Deskripsi *</label>
                <textarea name="deskripsi" rows="5" required
                    class="w-full border px-3 py-2 rounded"
                    placeholder="Minimal 50 karakter"></textarea>
            </div>

            {{-- FOTO --}}
            <div class="mb-6">
                <label class="font-semibold">Foto Bukti (Opsional)</label>
                <input type="file" name="foto[]" multiple accept="image/*"
                    class="w-full border px-3 py-2 rounded">
            </div>

            <button type="submit"
                class="w-full bg-purple-600 text-white py-3 rounded font-semibold">
                Kirim Pengaduan
            </button>
        </form>
>>>>>>> origin/main
    </div>
@endsection

@section('scripts')
<<<<<<< HEAD
    <script>
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
    </script>
@endsection
=======
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<script>
/* =========================
   SUB KATEGORI
========================= */
const subKategoriOptions = {
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

/* =========================
   MAP INIT
========================= */
let map = L.map('map').setView([-6.2088, 106.8456], 13);
let startMarker = null;
let endMarker = null;
let routingControl = null;

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
}).addTo(map);

/* =========================
   ELEMENT
========================= */
const kategori = document.getElementById('kategori_utama');
const subKategori = document.getElementById('sub_kategori');
const mapLabel = document.getElementById('mapLabel');
const routeModeWrapper = document.getElementById('routeModeWrapper');
const tanggalInput = document.getElementById('tanggal_kejadian');
const tanggalLabel = document.getElementById('tanggalLabel');

/* =========================
   KATEGORI CHANGE
========================= */
kategori.addEventListener('change', () => {
    subKategori.innerHTML = '<option value="">Pilih</option>';
    subKategori.disabled = false;

    Object.entries(subKategoriOptions[kategori.value]).forEach(([k, v]) => {
        subKategori.innerHTML += `<option value="${k}">${v}</option>`;
    });

    resetMap();

    if (kategori.value === 'permintaan') {
        routeModeWrapper.classList.remove('hidden');
        mapLabel.textContent = 'Titik Awal & Akhir Pengawalan';
        tanggalLabel.textContent = 'Tanggal Pengawalan *';
        tanggalInput.removeAttribute('max');
    } else {
        routeModeWrapper.classList.add('hidden');
        mapLabel.textContent = 'Lokasi Kejadian';
        tanggalLabel.textContent = 'Tanggal Kejadian *';
        tanggalInput.setAttribute('max', new Date().toISOString().split('T')[0]);
    }
});

/* =========================
   MAP CLICK
========================= */
map.on('click', e => {
    if (!kategori.value) {
        alert('Pilih kategori terlebih dahulu');
        return;
    }

    if (kategori.value === 'pengaduan') {
        resetMap();
        startMarker = L.marker(e.latlng).addTo(map);
        latitude.value = e.latlng.lat;
        longitude.value = e.latlng.lng;
        
        // Ambil alamat dari koordinat menggunakan reverse geocoding
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${e.latlng.lat}&lon=${e.latlng.lng}`)
            .then(res => res.json())
            .then(data => {
                lokasi.value = data.display_name || 'Lokasi tidak diketahui';
            })
            .catch(() => {
                lokasi.value = `${e.latlng.lat}, ${e.latlng.lng}`;
            });
    }

    if (kategori.value === 'permintaan') {
        const mode = document.querySelector('input[name="route_mode"]:checked').value;

        if (mode === 'start') {
            if (startMarker) map.removeLayer(startMarker);
            startMarker = L.marker(e.latlng, {
                icon: L.icon({
                    iconUrl: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
                    iconSize: [32, 32]
                })
            }).addTo(map);

            start_latitude.value = e.latlng.lat;
            start_longitude.value = e.latlng.lng;
        }

        if (mode === 'end') {
            if (endMarker) map.removeLayer(endMarker);
            endMarker = L.marker(e.latlng, {
                icon: L.icon({
                    iconUrl: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                    iconSize: [32, 32]
                })
            }).addTo(map);

            end_latitude.value = e.latlng.lat;
            end_longitude.value = e.latlng.lng;
        }

        drawRealRoute();
    }
});

/* =========================
   DRAW REAL ROUTE (OSRM)
========================= */
function drawRealRoute() {
    if (!startMarker || !endMarker) return;

    if (routingControl) {
        map.removeControl(routingControl);
    }

    routingControl = L.Routing.control({
        waypoints: [
            startMarker.getLatLng(),
            endMarker.getLatLng()
        ],
        router: L.Routing.osrmv1({
            serviceUrl: 'https://router.project-osrm.org/route/v1'
        }),
        lineOptions: {
            styles: [{ color: 'blue', weight: 5 }]
        },
        addWaypoints: false,
        draggableWaypoints: false,
        fitSelectedRoutes: true,
        show: false,
        createMarker: () => null
    }).addTo(map);
}

/* =========================
   RESET MAP
========================= */
function resetMap() {
    if (startMarker) map.removeLayer(startMarker);
    if (endMarker) map.removeLayer(endMarker);
    if (routingControl) map.removeControl(routingControl);

    startMarker = endMarker = routingControl = null;

    start_latitude.value = start_longitude.value = '';
    end_latitude.value = end_longitude.value = '';
    latitude.value = longitude.value = '';
}

document.getElementById('resetMap').addEventListener('click', resetMap);

/* =========================
   AUTOCOMPLETE ALAMAT
========================= */
const input = document.getElementById('searchLocation');
const suggestions = document.getElementById('suggestions');
let debounce;

input.addEventListener('input', function () {
    clearTimeout(debounce);
    if (this.value.length < 3) {
        suggestions.classList.add('hidden');
        return;
    }

    debounce = setTimeout(async () => {
        const res = await fetch(
            `https://nominatim.openstreetmap.org/search?format=json&q=${this.value}&countrycodes=id`
        );
        const data = await res.json();

        suggestions.innerHTML = '';
        suggestions.classList.remove('hidden');

        data.forEach(place => {
            const div = document.createElement('div');
            div.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm';
            div.textContent = place.display_name;

            div.onclick = () => {
                const latlng = {
                    lat: parseFloat(place.lat),
                    lng: parseFloat(place.lon)
                };

                map.setView(latlng, 16);
                map.fire('click', { latlng });
                input.value = place.display_name;
                
                // Isi field lokasi untuk kategori pengaduan
                if (kategori.value === 'pengaduan') {
                    lokasi.value = place.display_name;
                }
                
                suggestions.classList.add('hidden');
            };

            suggestions.appendChild(div);
        });
    }, 400);
});

// Sembunyikan dropdown ketika klik di luar
document.addEventListener('click', (e) => {
    if (!input.contains(e.target) && !suggestions.contains(e.target)) {
        suggestions.classList.add('hidden');
    }
});
</script>
@endsection
>>>>>>> origin/main
