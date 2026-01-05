<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pengaduan Polisi')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .chat-bubble {
            animation: slideUp 0.3s ease-out;
        }
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

<!-- Navigation -->
<nav id="navbar" class="bg-gray-800 shadow-lg fixed top-0 left-0 right-0 z-50 transition-transform duration-300">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <img src="/storage/logoPolda.png" alt="Logo Polisi" class="w-10">
                <span class="text-white font-bold text-xl">Pengaduan Polisi</span>
            </a>
            
            <div class="flex items-center space-x-4">

                @auth
                    @if(auth()->user()->isPetugas())
                        <a href="{{ route('petugas.dashboard') }}" class="text-white hover:text-gray-200 transition">
                            <i class="fas fa-user-shield mr-2"></i>Dashboard Petugas
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-200 transition">
                            <i class="fas fa-home mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('pengaduan.create') }}" class="bg-white text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition font-semibold">
                            <i class="fas fa-plus mr-2"></i>Buat Pengaduan
                        </a>
                    @endif
                    
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-white hover:text-gray-200 transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-gray-200 transition">
                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-white text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition font-semibold">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Spacer untuk mencegah content tertutup navbar -->
<div class="h-20"></div>

<script>
    let lastScrollTop = 0;
    const navbar = document.getElementById('navbar');
    const delta = 5; // Minimum scroll distance untuk trigger
    
    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Pastikan scroll lebih dari delta pixels untuk menghindari jitter
        if (Math.abs(lastScrollTop - scrollTop) <= delta) {
            return;
        }
        
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            // Scroll ke bawah & sudah melewati 100px
            navbar.style.transform = 'translateY(-100%)';
        } else {
            // Scroll ke atas
            navbar.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = scrollTop;
    });
</script>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 flex-grow">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 Pengaduan Polisi. Melayani dengan Integritas.</p>
            <p class="text-sm mt-2">Nomor Darurat: <strong>110</strong></p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
