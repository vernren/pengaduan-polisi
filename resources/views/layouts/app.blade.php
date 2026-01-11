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
        
        /* Mobile Menu Styles */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }
        
        .mobile-menu.active {
            max-height: 500px;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

<!-- Navigation -->
<nav id="navbar" class="bg-gray-800 shadow-lg fixed top-0 left-0 right-0 z-50 transition-transform duration-300">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo dan Judul -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <img src="/storage/logoPolda.png" alt="Logo Polisi" class="w-10">
                <!-- Judul hanya muncul di desktop -->
                <span class="text-white font-bold text-xl">Layanan Kepolisian</span>
            </a>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-4">
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
                            <i class="fas fa-plus mr-2"></i>Buat Laporan
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
            
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
        
        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="mobile-menu md:hidden">
            <div class="py-4 space-y-3 border-t border-gray-700">
                @auth
                    @if(auth()->user()->isPetugas())
                        <a href="{{ route('petugas.dashboard') }}" class="block text-white hover:bg-gray-700 px-4 py-2 rounded transition">
                            <i class="fas fa-user-shield mr-2"></i>Dashboard Petugas
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="block text-white hover:bg-gray-700 px-4 py-2 rounded transition">
                            <i class="fas fa-home mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('pengaduan.create') }}" class="block bg-white text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition font-semibold text-center">
                            <i class="fas fa-plus mr-2"></i>Buat Laporan
                        </a>
                    @endif
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left text-white hover:bg-gray-700 px-4 py-2 rounded transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-white hover:bg-gray-700 px-4 py-2 rounded transition">
                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                    </a>
                    <a href="{{ route('register') }}" class="block bg-white text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition font-semibold text-center">
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
    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = mobileMenuBtn.querySelector('i');
    
    mobileMenuBtn.addEventListener('click', function() {
        mobileMenu.classList.toggle('active');
        
        // Toggle icon antara bars dan times
        if (mobileMenu.classList.contains('active')) {
            menuIcon.classList.remove('fa-bars');
            menuIcon.classList.add('fa-times');
        } else {
            menuIcon.classList.remove('fa-times');
            menuIcon.classList.add('fa-bars');
        }
    });
    
    // Navbar Hide/Show on Scroll
    let lastScrollTop = 0;
    const navbar = document.getElementById('navbar');
    const delta = 5;
    
    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (Math.abs(lastScrollTop - scrollTop) <= delta) {
            return;
        }
        
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            navbar.style.transform = 'translateY(-100%)';
            // Tutup mobile menu saat navbar disembunyikan
            mobileMenu.classList.remove('active');
            menuIcon.classList.remove('fa-times');
            menuIcon.classList.add('fa-bars');
        } else {
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
            <p>&copy; 2025 Layanan Kepolisian. Melayani dengan Integritas.</p>
            <p class="text-sm mt-2">Nomor Darurat: <strong>110</strong></p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>