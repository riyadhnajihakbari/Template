<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SportifyX')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            transition: opacity 0.3s ease;
        }
        .sidebar-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        .sidebar-menu.open {
            transform: translateX(0);
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-40 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Mobile menu button (LEFT SIDE) -->
                    <button onclick="openSidebar()" class="lg:hidden text-gray-700 hover:text-blue-600 p-2 rounded-lg hover:bg-gray-100 mr-3">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center">
                            <span class="text-white text-xl">⚽</span>
                        </div>
                        <span class="text-xl font-bold text-gray-900 hidden sm:block">Sportify<span class="text-blue-600">X</span></span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}">Home</a>
                    <a href="{{ route('events.index') }}" class="text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('events.*') ? 'text-blue-600 bg-blue-50' : '' }}">Events</a>
                    <a href="{{ route('news.index') }}" class="text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('news.*') ? 'text-blue-600 bg-blue-50' : '' }}">Berita</a>
                    <a href="{{ route('matches.index') }}" class="text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('matches.*') ? 'text-blue-600 bg-blue-50' : '' }}">Hasil</a>
                    <a href="{{ route('store.index') }}" class="text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('store.*') ? 'text-blue-600 bg-blue-50' : '' }}">Store</a>
                </div>

                <!-- Desktop Auth -->
                <div class="hidden lg:flex items-center space-x-3">
                    @auth
                        <a href="{{ route('my-tickets.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">🎫 Tiket Saya</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-medium">Admin</a>
                        @endif
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-red-600 px-3 py-2 text-sm">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-4 py-2 text-sm font-medium">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-medium">Daftar</a>
                    @endauth
                </div>

                <!-- Mobile Auth Buttons -->
                <div class="lg:hidden flex items-center space-x-2">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">Masuk</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="sidebar-overlay fixed inset-0 z-50 hidden lg:hidden" onclick="closeSidebar()"></div>

    <!-- Mobile Sidebar Menu (LEFT SIDE) -->
    <div id="sidebar-menu" class="sidebar-menu fixed top-0 left-0 h-full w-80 max-w-[85vw] bg-white z-50 shadow-2xl lg:hidden overflow-y-auto">
        <!-- Sidebar Header -->
        <div class="bg-gradient-to-br from-blue-600 to-purple-600 p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <button onclick="closeSidebar()" class="text-white/80 hover:text-white p-1">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            @auth
                <div class="flex items-center space-x-3">
                    <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="font-semibold text-lg">{{ auth()->user()->name }}</p>
                        <p class="text-blue-100 text-sm">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            @else
                <div class="text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-3xl">👤</span>
                    </div>
                    <p class="font-semibold">Selamat Datang!</p>
                </div>
            @endauth
        </div>

        <!-- Sidebar Menu Items -->
        <div class="py-4">
            <a href="{{ route('home') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : '' }}">
                <span class="w-8 text-xl">🏠</span>
                <span class="font-medium">Beranda</span>
            </a>
            <a href="{{ route('events.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('events.*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : '' }}">
                <span class="w-8 text-xl">🎫</span>
                <span class="font-medium">Events</span>
            </a>
            <a href="{{ route('news.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('news.*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : '' }}">
                <span class="w-8 text-xl">📰</span>
                <span class="font-medium">Berita</span>
            </a>
            <a href="{{ route('matches.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('matches.*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : '' }}">
                <span class="w-8 text-xl">🏆</span>
                <span class="font-medium">Hasil Pertandingan</span>
            </a>
            <a href="{{ route('store.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('store.*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : '' }}">
                <span class="w-8 text-xl">🛍️</span>
                <span class="font-medium">Store</span>
            </a>

            @auth
                <div class="border-t border-gray-200 my-3"></div>
                <a href="{{ route('my-tickets.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                    <span class="w-8 text-xl">🎟️</span>
                    <span class="font-medium">Tiket Saya</span>
                </a>
                <a href="{{ route('store.history') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                    <span class="w-8 text-xl">📦</span>
                    <span class="font-medium">Riwayat Pembelian</span>
                </a>

                @if(auth()->user()->isAdmin())
                    <div class="border-t border-gray-200 my-3"></div>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-amber-600 hover:bg-amber-50">
                        <span class="w-8 text-xl">⚙️</span>
                        <span class="font-medium">Admin Dashboard</span>
                    </a>
                @endif

                <div class="border-t border-gray-200 my-3"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-6 py-3 text-red-600 hover:bg-red-50">
                        <span class="w-8 text-xl">🚪</span>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            @else
                <div class="border-t border-gray-200 my-3"></div>
                <div class="px-6 space-y-3">
                    <a href="{{ route('login') }}" class="block w-full text-center py-3 border border-blue-600 text-blue-600 rounded-lg font-medium hover:bg-blue-50">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="block w-full text-center py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">
                        Daftar Sekarang
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center">
                <span class="mr-3">✓</span>
                <span class="flex-1">{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 ml-3">&times;</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center">
                <span class="mr-3">✕</span>
                <span class="flex-1">{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 ml-3">&times;</button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <span class="text-white text-xl">⚽</span>
                        </div>
                        <span class="text-xl font-bold text-white">Sportify<span class="text-blue-400">X</span></span>
                    </div>
                    <p class="text-gray-400 text-sm">Platform tiket dan informasi olahraga terlengkap di Indonesia.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Menu</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('events.index') }}" class="hover:text-white">Events</a></li>
                        <li><a href="{{ route('news.index') }}" class="hover:text-white">Berita</a></li>
                        <li><a href="{{ route('matches.index') }}" class="hover:text-white">Hasil Pertandingan</a></li>
                        <li><a href="{{ route('store.index') }}" class="hover:text-white">Store</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>📧 support@sportifyx.com</li>
                        <li>📞 +62 21 1234 5678</li>
                        <li>📍 Jakarta, Indonesia</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center">📘</a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-sky-500 rounded-lg flex items-center justify-center">🐦</a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-pink-600 rounded-lg flex items-center justify-center">📸</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} SportifyX. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function openSidebar() {
            document.getElementById('sidebar-overlay').classList.remove('hidden');
            document.getElementById('sidebar-menu').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            document.getElementById('sidebar-overlay').classList.add('hidden');
            document.getElementById('sidebar-menu').classList.remove('open');
            document.body.style.overflow = '';
        }
    </script>
</body>
</html>