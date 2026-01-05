@extends('layouts.app')

@section('title', 'Login - Pengaduan Polisi')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">
            <i class="fas fa-sign-in-alt text-gray-800 mr-2"></i>Masuk ke Akun
        </h2>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
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
                    <i class="fas fa-lock mr-2"></i>Password
                </label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                    placeholder="********">
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <span class="text-gray-700">Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-gray-800 text-white py-3 rounded-lg hover:opacity-90 transition font-semibold">
                <i class="fas fa-sign-in-alt mr-2"></i>Masuk
            </button>
        </form>

        <p class="text-center mt-6 text-gray-600">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-yellow-400 hover:text-yellow-800 font-semibold">Daftar di sini</a>
        </p>

        <div class="mt-6 pt-6 border-t border-gray-200 text-center">
            <p class="text-sm text-gray-600">
                <i class="fas fa-user-shield text-yellow-400 mr-2"></i>
                Login Petugas: <strong>admin@polisi.id</strong> / password
            </p>
        </div>
    </div>
</div>
@endsection