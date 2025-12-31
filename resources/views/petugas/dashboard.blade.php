@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('scripts')

    <script>
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
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-user-shield mr-2"></i>Dashboard Petugas
        </h1>
        <p class="text-gray-600">Kelola dan tanggapi laporan masyarakat</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-yellow-100 text-sm font-semibold">Menunggu</p>
                    <p class="text-4xl font-bold mt-2">{{ $stats['pending'] }}</p>
                </div>
                <i class="fas fa-clock text-5xl opacity-30"></i>
            </div>
            <p class="text-xs text-yellow-100 mt-3">Perlu ditindaklanjuti</p>
        </div>

        <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-blue-100 text-sm font-semibold">Diproses</p>
                    <p class="text-4xl font-bold mt-2">{{ $stats['diproses'] }}</p>
                </div>
                <i class="fas fa-cog fa-spin text-5xl opacity-30"></i>
            </div>
            <p class="text-xs text-blue-100 mt-3">Sedang ditangani</p>
        </div>

        <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-green-100 text-sm font-semibold">Selesai</p>
                    <p class="text-4xl font-bold mt-2">{{ $stats['selesai'] }}</p>
                </div>
                <i class="fas fa-check-circle text-5xl opacity-30"></i>
            </div>
            <p class="text-xs text-green-100 mt-3">Telah diselesaikan</p>
        </div>

        <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-purple-100 text-sm font-semibold">Total</p>
                    <p class="text-4xl font-bold mt-2">{{ $stats['total'] }}</p>
                </div>
                <i class="fas fa-file-alt text-5xl opacity-30"></i>
            </div>
            <p class="text-xs text-purple-100 mt-3">Semua laporan</p>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-lg shadow-lg mb-6 overflow-x-auto">
        <div class="flex border-b border-gray-200 whitespace-nowrap">
            <a href="?status=all"
                class="px-6 py-4 font-semibold {{ request('status', 'all') == 'all' ? 'text-purple-600 border-b-2 border-purple-600' : 'text-gray-600 hover:text-purple-600' }}">
                Semua
            </a>
            <a href="?status=pending"
                class="px-6 py-4 font-semibold {{ request('status') == 'pending' ? 'text-yellow-600 border-b-2 border-yellow-600' : 'text-gray-600 hover:text-yellow-600' }}">
                Menunggu
            </a>
            <a href="?status=diproses"
                class="px-6 py-4 font-semibold {{ request('status') == 'diproses' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' }}">
                Diproses
            </a>
            <a href="?status=selesai"
                class="px-6 py-4 font-semibold {{ request('status') == 'selesai' ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-600 hover:text-green-600' }}">
                Selesai
            </a>
        </div>
    </div>

    <!-- laporan List -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
<div class="p-6 border-b border-gray-200">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-list mr-2"></i>Daftar Laporan
        </h2>
        <span class="text-sm font-semibold text-gray-600">
            Total Laporan : 
            <span class="text-purple-600 font-bold">
                {{ $pengaduan->total() }}
            </span>
        </span>
    </div>

    <!-- Filter Kategori -->
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        {{-- KATEGORI UTAMA --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Kategori Utama</label>
            <select name="kategori_utama" id="filter_kategori" class="px-4 py-2 border rounded-lg">
                <option value="">Semua</option>
                <option value="pengaduan" {{ request('kategori_utama') == 'pengaduan' ? 'selected' : '' }}>
                    Pengaduan
                </option>
                <option value="permintaan" {{ request('kategori_utama') == 'permintaan' ? 'selected' : '' }}>
                    Pengawalan
                </option>
            </select>
        </div>

        {{-- SUB KATEGORI --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Sub Kategori</label>
            <select name="sub_kategori" id="filter_sub_kategori" class="px-4 py-2 border rounded-lg">
                <option value="">Semua</option>
            </select>
        </div>

        <button class="bg-purple-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-purple-700">
            Terapkan
        </button>
    </form>
</div>

        @if ($pengaduan->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Tidak ada laporan</p>
            </div>
        @else
            <div class="divide-y divide-gray-200">
                @foreach ($pengaduan as $item)
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start gap-4">
                            <!-- LEFT -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start gap-3 flex-wrap mb-2">
                                    <h3 class="font-bold text-lg text-gray-800 break-all">
                                        {{ $item->judul }}
                                    </h3>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $item->getStatusBadgeClass() }}">
                                        {{ $item->getStatusLabel() }}
                                    </span>
                                </div>

                                <div class="flex items-start gap-3 flex-wrap mb-2">
                                    <p class="font-bold">
                                        Kategori :
                                    </p>
                                    {{ $item->kategori_utama }}

                                    <p class="font-bold">
                                        Sub kategori :
                                    </p>
                                    {{ $item->sub_kategori }}
                                </div>

                                <p class="text-gray-600 mb-3 break-words overflow-hidden whitespace-pre-line">
                                    {{ Str::limit($item->deskripsi, 120) }}
                                </p>

                                <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                    <span><i class="fas fa-user mr-1"></i>{{ $item->user->name }}</span>
                                    <span><i
                                            class="fas fa-calendar mr-1"></i>{{ $item->created_at->format('d M Y, H:i') }}</span>
                                    <span class="break-all overflow-wrap-anywhere">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $item->lokasi }}
                                    </span>
                                </div>
                            </div>

                            <!-- RIGHT -->
                            <div class="flex flex-col sm:flex-row gap-2 shrink-0">
                                <a href="{{ route('petugas.pengaduan.show', $item) }}"
                                    class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-purple-700 whitespace-nowrap">
                                    <i class="fas fa-eye mr-1"></i>Lihat Detail
                                </a>

                                <form action="{{ route('petugas.pengaduan.destroy', $item) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus pengaduan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 whitespace-nowrap">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if ($item->foto->count())
                            <div class="mt-4 flex gap-2">
                                @foreach ($item->foto->take(3) as $foto)
                                    <img src="{{ Storage::url($foto->file_path) }}"
                                        class="w-16 h-16 object-cover rounded border">
                                @endforeach
                                @if ($item->foto->count() > 3)
                                    <div
                                        class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-xs font-semibold">
                                        +{{ $item->foto->count() - 3 }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="p-6 border-t border-gray-200">
                {{ $pengaduan->links() }}
            </div>
        @endif
    </div>
@endsection
