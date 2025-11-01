@extends('layouts.app')

@section('title', 'Daftar - Pengaduan Polisi')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">
            <i class="fas fa-user-plus text-purple-600 mr-2"></i>Daftar Akun Baru
        </h2>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-user mr-2"></i>Nama Lengkap
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                        placeholder="John Doe">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-id-card mr-2"></i>NIK (16 Digit)
                    </label>
                    <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16" pattern="[0-9]{16}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                        placeholder="3174012345678901">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-envelope mr-2"></i>Email
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                    placeholder="email@contoh.com">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-phone mr-2"></i>Nomor Telepon
                </label>
                <input type="tel" name="phone" value="{{ old('phone') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                    placeholder="08123456789">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-map-marker-alt mr-2"></i>Alamat
                </label>
                <textarea name="address" required rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                    placeholder="Jl. Contoh No. 123, Jakarta">{{ old('address') }}</textarea>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <input type="password" name="password" required minlength="8"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                        placeholder="Min. 8 karakter">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2"></i>Konfirmasi Password
                    </label>
                    <input type="password" name="password_confirmation" required minlength="8"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                        placeholder="Ulangi password">
                </div>
            </div>

            <button type="submit" class="w-full gradient-bg text-white py-3 rounded-lg hover:opacity-90 transition font-semibold">
                <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
            </button>
        </form>

        <p class="text-center mt-6 text-gray-600">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-800 font-semibold">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection