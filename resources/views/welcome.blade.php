@extends('layouts.app')

@section('title', 'Pengaduan Polisi')

@section('content')
<div class="relative -mx-4 -mt-10 mb-0">
    <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white py-24 px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                        Sistem Pengaduan Masyarakat
                    </h1>
                    <p class="text-xl md:text-2xl mb-4 text-gray-300">
                        Kepolisian Republik Indonesia
                    </p>
                    <p class="text-lg mb-8 text-gray-400 leading-relaxed">
                        Laporkan kejadian dengan mudah, cepat, dan aman. Kami siap melindungi, mengayomi, dan melayani masyarakat dengan sepenuh hati.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        @auth
                            <a href="{{ route('pengaduan.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold px-8 py-4 rounded-lg transition-colors shadow-lg inline-flex items-center">
                                <i class="fas fa-plus-circle mr-2"></i> Buat Laporan
                            </a>
                            <a href="{{ route('pengaduan.index') }}" class="bg-white hover:bg-gray-100 text-gray-900 font-bold px-8 py-4 rounded-lg transition-colors shadow-lg inline-flex items-center">
                                <i class="fas fa-search mr-2"></i> Cek Status
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold px-8 py-4 rounded-lg transition-colors shadow-lg inline-flex items-center">
                                <i class="fas fa-sign-in-alt mr-2"></i> Login
                            </a>
                            <a href="{{ route('chatbot.index') }}" class="bg-white hover:bg-gray-100 text-gray-900 font-bold px-8 py-4 rounded-lg transition-colors shadow-lg inline-flex items-center">
                                <i class="fas fa-comments mr-2"></i> Chat dengan AI
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8 border border-white border-opacity-20">
                        <div class="text-center flex items-center justify-center mb-6">
                <img src="/storage/logoPolda.png" alt="Logo Polisi" class="w-20 h-23">
                        </div>
                        <h3 class="text-2xl font-bold text-center mb-4">Visi Kami</h3>
                        <p class="text-center text-gray-300 leading-relaxed">
                            Terwujudnya Indonesia yang Aman dan Tertib melalui pelayanan pengaduan masyarakat yang cepat, transparan, dan terpercaya.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Quick Access Cards - Background Abu Terang seperti SKCK --}}
<section class="py-16 px-4 bg-gray-50">
    <div class="container mx-auto max-w-6xl">
        <div class="grid md:grid-cols-3 gap-8">
            {{-- Card 1 - Warna Kuning untuk Aksen --}}
            <a href="{{ route('chatbot.index') }}" class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                <div class="relative h-48 bg-gradient-to-br from-yellow-500 to-yellow-600 flex items-center justify-center">
                    <i class="fas fa-comments text-white text-6xl group-hover:scale-110 transition-transform"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Chatbot AI</h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Dapatkan jawaban cepat untuk pertanyaan umum seputar layanan pengaduan masyarakat
                    </p>
                    <div class="text-yellow-600 font-semibold group-hover:text-yellow-700">
                        Mulai Chat <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
            </a>

            {{-- Card 2 - Warna Gelap --}}
            <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="relative h-48 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                    <i class="fas fa-file-alt text-white text-6xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Buat Laporan</h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Laporkan kejadian dengan detail lengkap dan lampirkan foto bukti pendukung
                    </p>
                    @auth
                        <a href="{{ route('pengaduan.create') }}" class="text-gray-800 font-semibold hover:text-gray-900">
                            Buat Laporan <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-800 font-semibold hover:text-gray-900">
                            Login Dulu <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Card 3 - Warna Kuning Alternatif --}}
            <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="relative h-48 bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center">
                    <i class="fas fa-search text-white text-6xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Lacak Status</h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Pantau perkembangan dan status tindak lanjut dari laporan pengaduan Anda
                    </p>
                    @auth
                        <a href="{{ route('pengaduan.index') }}" class="text-yellow-600 font-semibold hover:text-yellow-700">
                            Lihat Status <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-yellow-600 font-semibold hover:text-yellow-700">
                            Login Dulu <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Informasi Section dengan Background Kuning seperti SKCK --}}
<section class="py-16 px-4 bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600">
    <div class="container mx-auto max-w-6xl">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-900">
            Tentang Sistem Pengaduan
        </h2>
        
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white bg-opacity-90 rounded-lg p-8 shadow-md">
                <div class="flex items-start mb-4">
                    <div class="bg-yellow-100 rounded-full p-4 mr-4">
                        <i class="fas fa-info-circle text-yellow-600 text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Apa itu Sistem Pengaduan?</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Sistem Pengaduan Masyarakat adalah layanan resmi yang diterbitkan oleh Polri untuk menerima, memproses, dan menindaklanjuti laporan kejadian dari masyarakat secara cepat dan transparan.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white bg-opacity-90 rounded-lg p-8 shadow-md">
                <div class="flex items-start mb-4">
                    <div class="bg-yellow-100 rounded-full p-4 mr-4">
                        <i class="fas fa-clock text-yellow-600 text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Masa Berlaku Laporan</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Masa berlaku laporan hingga 6 (enam) bulan sejak tanggal diterbitkan. Jika telah melewati masa berlaku dan bila dirasa perlu, laporan dapat diperpanjang.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Tata Cara Section - Background Putih --}}
<section class="py-16 px-4 bg-white">
    <div class="container mx-auto max-w-6xl">
        <h2 class="text-4xl font-bold text-center mb-4 text-gray-800">
            Tata Cara Permohonan
        </h2>
        <p class="text-center text-gray-600 mb-12 text-lg">
            Ikuti langkah-langkah berikut untuk mengajukan pengaduan
        </p>
        
        <div class="grid md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="bg-gray-800 text-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg text-3xl font-bold">
                    1
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md border-t-4 border-yellow-500">
                    <i class="fas fa-user-plus text-yellow-600 text-4xl mb-4"></i>
                    <h4 class="font-bold text-lg mb-3 text-gray-800">Daftar / Login</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Buat akun baru atau masuk ke sistem menggunakan akun yang telah terdaftar
                    </p>
                </div>
            </div>
            
            <div class="text-center">
                <div class="bg-gray-800 text-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg text-3xl font-bold">
                    2
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md border-t-4 border-yellow-500">
                    <i class="fas fa-edit text-yellow-600 text-4xl mb-4"></i>
                    <h4 class="font-bold text-lg mb-3 text-gray-800">Buat Laporan</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Isi formulir pengaduan dengan lengkap dan lampirkan foto bukti yang diperlukan
                    </p>
                </div>
            </div>
            
            <div class="text-center">
                <div class="bg-gray-800 text-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg text-3xl font-bold">
                    3
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md border-t-4 border-yellow-500">
                    <i class="fas fa-clock text-yellow-600 text-4xl mb-4"></i>
                    <h4 class="font-bold text-lg mb-3 text-gray-800">Tunggu Proses</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Petugas kami akan memverifikasi dan menindaklanjuti laporan Anda dengan segera
                    </p>
                </div>
            </div>
            
            <div class="text-center">
                <div class="bg-gray-800 text-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg text-3xl font-bold">
                    4
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md border-t-4 border-yellow-500">
                    <i class="fas fa-check-circle text-yellow-600 text-4xl mb-4"></i>
                    <h4 class="font-bold text-lg mb-3 text-gray-800">Cek Status</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Pantau perkembangan dan hasil tindak lanjut dari laporan yang telah diajukan
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection