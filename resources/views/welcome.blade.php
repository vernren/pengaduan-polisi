@extends('layouts.app')

@section('title', 'Selamat Datang - Pengaduan Polisi')

@section('content')
<div class="text-center mb-12">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">
        Sistem Pengaduan Masyarakat
    </h1>
    <p class="text-xl text-gray-600">
        Laporkan kejadian dengan mudah, cepat, dan aman
    </p>
</div>

<div class="grid md:grid-cols-3 gap-8 mb-12">
    <div class="bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition transform hover:-translate-y-1">
        <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-comments text-purple-600 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold mb-2">Chatbot AI</h3>
        <p class="text-gray-600 mb-4">Dapatkan jawaban cepat untuk pertanyaan umum</p>
        <a href="{{ route('chatbot.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold">
            Mulai Chat <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition transform hover:-translate-y-1">
        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-file-alt text-blue-600 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold mb-2">Buat Laporan</h3>
        <p class="text-gray-600 mb-4">Laporkan kejadian dengan detail dan foto</p>
        @auth
            <a href="{{ route('pengaduan.create') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                Buat Laporan <i class="fas fa-arrow-right ml-2"></i>
            </a>
        @else
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                Login Dulu <i class="fas fa-arrow-right ml-2"></i>
            </a>
        @endauth
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition transform hover:-translate-y-1">
        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-clock text-green-600 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold mb-2">Lacak Status</h3>
        <p class="text-gray-600 mb-4">Pantau perkembangan laporan Anda</p>
        @auth
            <a href="{{ route('pengaduan.index') }}" class="text-green-600 hover:text-green-800 font-semibold">
                Lihat Status <i class="fas fa-arrow-right ml-2"></i>
            </a>
        @else
            <a href="{{ route('login') }}" class="text-green-600 hover:text-green-800 font-semibold">
                Login Dulu <i class="fas fa-arrow-right ml-2"></i>
            </a>
        @endauth
    </div>
</div>

<div class="bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold mb-4 text-center">Cara Menggunakan Sistem</h2>
    <div class="grid md:grid-cols-4 gap-6">
        <div class="text-center">
            <div class="bg-purple-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-xl">1</div>
            <h4 class="font-semibold mb-2">Daftar/Login</h4>
            <p class="text-sm text-gray-600">Buat akun atau masuk ke sistem</p>
        </div>
        <div class="text-center">
            <div class="bg-purple-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-xl">2</div>
            <h4 class="font-semibold mb-2">Buat Laporan</h4>
            <p class="text-sm text-gray-600">Isi formulir dan lampirkan foto</p>
        </div>
        <div class="text-center">
            <div class="bg-purple-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-xl">3</div>
            <h4 class="font-semibold mb-2">Tunggu Proses</h4>
            <p class="text-sm text-gray-600">Petugas akan menindaklanjuti</p>
        </div>
        <div class="text-center">
            <div class="bg-purple-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-xl">4</div>
            <h4 class="font-semibold mb-2">Cek Status</h4>
            <p class="text-sm text-gray-600">Pantau perkembangan laporan</p>
        </div>
    </div>
</div>
@endsection