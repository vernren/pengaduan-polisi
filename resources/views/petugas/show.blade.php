@extends('layouts.app')

@section('title', 'Detail Pengaduan - Petugas')

@section('content')
    <div class="mb-6">
        <a href="{{ route('petugas.dashboard') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
        </a>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-start mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $pengaduan->judul }}</h1>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $pengaduan->getStatusBadgeClass() }}">
                        {{ $pengaduan->getStatusLabel() }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6 text-sm bg-gray-50 p-4 rounded-lg">
                    <div>
                        <p class="text-gray-500 mb-1"><i class="fas fa-layer-group mr-2"></i>Kategori Utama</p>
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
                    <div class="flex items-start text-sm text-gray-600 mb-3">
                        <i class="fas fa-map-pin mr-2 mt-1"></i>

                        @if ($pengaduan->kategori_utama === 'pengaduan')
                            <div>
                                <span>
                                    Koordinat:
                                    {{ $pengaduan->latitude }},
                                    {{ $pengaduan->longitude }}
                                </span>
                                <br>
                                <a target="_blank" class="text-blue-600 hover:text-blue-800 inline-flex items-center mt-1"
                                    href="https://www.google.com/maps?q={{ $pengaduan->latitude }},{{ $pengaduan->longitude }}">
                                    <i class="fas fa-external-link-alt mr-1"></i>
                                    Buka di Google Maps
                                </a>
                            </div>
                        @else
                            <div>
                                <span>
                                    <strong>Titik Awal:</strong><br>
                                    {{ $pengaduan->start_latitude }},
                                    {{ $pengaduan->start_longitude }}
                                </span>
                                <br><br>
                                <span>
                                    <strong>Titik Akhir:</strong><br>
                                    {{ $pengaduan->end_latitude }},
                                    {{ $pengaduan->end_longitude }}
                                </span>
                                <br>
                                <a target="_blank" class="text-blue-600 hover:text-blue-800 inline-flex items-center mt-2"
                                    href="https://www.google.com/maps/dir/
                                {{ $pengaduan->start_latitude }},
                                {{ $pengaduan->start_longitude }}/
                                {{ $pengaduan->end_latitude }},
                                {{ $pengaduan->end_longitude }}">
                                    <i class="fas fa-route mr-1"></i>
                                    Lihat Rute di Google Maps
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Google Maps Display -->
                    <div id="map" class="w-full h-80 rounded-lg border border-gray-300"></div>
                </div>

                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 mb-3"><i class="fas fa-align-left mr-2"></i>Deskripsi</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p
                            class="text-gray-700 leading-relaxed
                            break-words
                            overflow-hidden
                            whitespace-pre-line">
                            {{ $pengaduan->deskripsi }}
                        </p>

                    </div>
                </div>

                @if ($pengaduan->foto->count() > 0)
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-3"><i class="fas fa-image mr-2"></i>Foto Bukti
                            ({{ $pengaduan->foto->count() }})</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($pengaduan->foto as $foto)
                                <a href="{{ Storage::url($foto->file_path) }}" target="_blank" class="group relative">
                                    <img src="{{ Storage::url($foto->file_path) }}" alt="Bukti"
                                        class="w-full h-48 object-cover rounded-lg border-2 border-gray-300 group-hover:border-gray-500 transition">
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition rounded-lg flex items-center justify-center">
                                        <i
                                            class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 text-2xl"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            @php
                $isSelesai = $pengaduan->status === 'selesai';
            @endphp
            <!-- UPDATE -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="font-semibold text-lg mb-4">
                    <i class="fas fa-edit mr-2"></i>Update Status & Tanggapan
                </h3>

                {{-- INFO JIKA SUDAH SELESAI --}}
                @if ($isSelesai)
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-800 rounded-lg p-3 text-sm">
                        <i class="fas fa-lock mr-2"></i>
                        Pengaduan ini telah <strong>SELESAI</strong> dan tidak dapat diubah kembali.
                    </div>
                @endif

                <form action="{{ $isSelesai ? '#' : route('petugas.pengaduan.update', $pengaduan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- NAMA PETUGAS --}}
                    <div class="mb-4">
                        <label class="font-semibold">Nama Petugas Penanganan</label>
                        <input type="text" name="nama_petugas"
                            value="{{ old('nama_petugas', $pengaduan->nama_petugas) }}"
                            {{ $isSelesai ? 'disabled' : 'required' }}
                            class="w-full px-4 py-2 border rounded
                          {{ $isSelesai ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                    </div>

                    {{-- STATUS --}}
                    <div class="mb-4">
                        <label class="font-semibold">Status</label>
                        <select name="status" {{ $isSelesai ? 'disabled' : '' }}
                            class="w-full px-4 py-2 border rounded
                           {{ $isSelesai ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                            <option value="pending" {{ $pengaduan->status == 'pending' ? 'selected' : '' }}>
                                Menunggu
                            </option>
                            <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>
                                Diproses
                            </option>
                            <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                    </div>

                    {{-- TANGGAPAN --}}
                    <div class="mb-4">
                        <label class="font-semibold">Tanggapan</label>
                        <textarea name="tanggapan" rows="4" {{ $isSelesai ? 'disabled' : '' }}
                            class="w-full px-4 py-2 border rounded
                             {{ $isSelesai ? 'bg-gray-100 cursor-not-allowed' : '' }}">{{ old('tanggapan', $pengaduan->tanggapan) }}</textarea>
                    </div>

                    {{-- BUTTON --}}
                    @if (!$isSelesai)
                        <button type="submit" class="w-full bg-gray-600 text-white py-2 rounded hover:bg-gray-700">
                            Simpan Perubahan
                        </button>
                    @else
                        <button type="button" disabled
                            class="w-full bg-gray-300 text-gray-600 py-2 rounded cursor-not-allowed">
                            Pengaduan Telah Selesai
                        </button>
                    @endif
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user mr-2"></i>Informasi Pelapor
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="pb-3 border-b border-gray-200">
                        <p class="text-gray-500 mb-1">Nama Lengkap</p>
                        <p class="font-semibold text-gray-800">{{ $pengaduan->user->name }}</p>
                    </div>
                    <div class="pb-3 border-b border-gray-200">
                        <p class="text-gray-500 mb-1">NIK</p>
                        <p class="font-semibold text-gray-800">{{ $pengaduan->user->nik ?? '-' }}</p>
                    </div>
                    <div class="pb-3 border-b border-gray-200">
                        <p class="text-gray-500 mb-1">Email</p>
                        <p class="font-semibold text-gray-800">{{ $pengaduan->user->email }}</p>
                    </div>
                    <div class="pb-3 border-b border-gray-200">
                        <p class="text-gray-500 mb-1">Telepon</p>
                        <p class="font-semibold text-gray-800">{{ $pengaduan->user->phone }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Alamat</p>
                        <p class="font-semibold text-gray-800">{{ $pengaduan->user->address ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Foto Pelapor</p>
                        @if ($pengaduan->user->foto_selfie)
                            <img src="{{ Storage::url($pengaduan->user->foto_selfie) }}" class="w-40 rounded">
                        @endif
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="tel:{{ $pengaduan->user->phone }}"
                        class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition font-semibold text-center block">
                        <i class="fas fa-phone mr-2"></i>Hubungi Pelapor
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-clock mr-2"></i>Timeline
                </h3>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="bg-green-100 w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-plus text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-gray-800">Pengaduan Dibuat</p>
                            <p class="text-xs text-gray-500">{{ $pengaduan->created_at->format('d M Y, H:i') }}</p>
                            <p class="text-xs text-gray-600 mt-1">{{ $pengaduan->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    @if ($pengaduan->status != 'pending')
                        <div class="flex items-start space-x-3">
                            <div class="bg-blue-100 w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-800">Status Diperbarui</p>
                                <p class="text-xs text-gray-500">{{ $pengaduan->updated_at->format('d M Y, H:i') }}</p>
                                <p class="text-xs text-gray-600 mt-1">{{ $pengaduan->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($pengaduan->hasFeedback())
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mt-6">
                            <h3 class="font-semibold text-green-900 mb-3">
                                📝 Feedback Masyarakat
                            </h3>

                            <p class="mb-2">
                                <strong>Rating:</strong>
                                {{ str_repeat('⭐', $pengaduan->rating) }}
                                ({{ $pengaduan->rating }}/5)
                            </p>

                            <p class="text-gray-800 mb-2 break-words whitespace-normal">
                                "{{ $pengaduan->feedback }}"
                            </p>


                            <p class="text-sm text-gray-500">
                                Diberikan pada {{ $pengaduan->feedback_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kategori = @json($pengaduan->kategori_utama);

            const lat = @json($pengaduan->latitude);
            const lng = @json($pengaduan->longitude);

            const slat = @json($pengaduan->start_latitude);
            const slng = @json($pengaduan->start_longitude);
            const elat = @json($pengaduan->end_latitude);
            const elng = @json($pengaduan->end_longitude);

            const mapEl = document.getElementById('map');
            if (!mapEl) return;

            // ===============================
            // VALIDASI KOORDINAT
            // ===============================
            let valid = false;

            if (kategori === 'pengaduan') {
                valid = lat && lng && !isNaN(lat) && !isNaN(lng);
            }

            if (kategori === 'permintaan') {
                valid = slat && slng && elat && elng &&
                    !isNaN(slat) && !isNaN(slng) &&
                    !isNaN(elat) && !isNaN(elng);
            }

            if (!valid) {
                mapEl.innerHTML = `
            <div class="flex items-center justify-center h-full">
                <p class="text-gray-600">
                    Koordinat tidak tersedia. Tidak dapat menampilkan peta.
                </p>
            </div>`;
                return;
            }

            // ===============================
            // INIT MAP
            // ===============================
            const center = kategori === 'permintaan' ? [Number(slat), Number(slng)] : [Number(lat), Number(lng)];

            const map = L.map('map', {
                center: center,
                zoom: 15,
                scrollWheelZoom: true
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // ===============================
            // MODE PENGADUAN (1 TITIK)
            // ===============================
            if (kategori === 'pengaduan') {
                L.marker([Number(lat), Number(lng)])
                    .addTo(map)
                    .bindPopup('Lokasi')
                    .openPopup();
            }

            // ===============================
            // MODE PERMINTAAN (PENGAWALAN)
            // 2 TITIK + RUTE JALAN
            // ===============================
            if (kategori === 'permintaan') {
                // marker start
                L.marker([Number(slat), Number(slng)], {
                    icon: L.icon({
                        iconUrl: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
                        iconSize: [32, 32]
                    })
                }).addTo(map).bindPopup('Titik Awal');

                // marker end
                L.marker([Number(elat), Number(elng)], {
                    icon: L.icon({
                        iconUrl: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                        iconSize: [32, 32]
                    })
                }).addTo(map).bindPopup('Titik Akhir');

                // routing mengikuti jalan
                L.Routing.control({
                    waypoints: [
                        L.latLng(Number(slat), Number(slng)),
                        L.latLng(Number(elat), Number(elng))
                    ],
                    router: L.Routing.osrmv1({
                        serviceUrl: 'https://router.project-osrm.org/route/v1'
                    }),
                    lineOptions: {
                        styles: [{
                            color: '#6D28D9',
                            weight: 5
                        }]
                    },
                    addWaypoints: false,
                    draggableWaypoints: false,
                    fitSelectedRoutes: true,
                    show: false,
                    createMarker: () => null
                }).addTo(map);
            }

            L.control.scale().addTo(map);
        });
    </script>
@endsection
