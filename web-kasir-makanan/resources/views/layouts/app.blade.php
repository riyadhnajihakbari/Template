<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Web Kasir Makanan')</title>
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#3b82f6">
    <link rel="manifest" href="/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <!-- Offline Indicator -->
    <div id="offline-indicator" class="offline-indicator hidden">
        ⚠️ Mode Offline - Data akan disinkronkan otomatis saat online
    </div>

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @auth
        <aside class="w-64 bg-white shadow-lg no-print">
            <div class="p-6 border-b">
                <h1 class="text-xl font-bold text-pos-primary">🍽️ Kasir Makanan</h1>
                <p class="text-sm text-gray-600">{{ auth()->user()->name }}</p>
                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded">{{ ucfirst(auth()->user()->role) }}</span>
            </div>
            
            <nav class="p-4">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-pos-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('pos.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mt-2 {{ request()->routeIs('pos.*') ? 'bg-pos-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span>💰</span>
                    <span>POS / Kasir</span>
                </a>
                
                @if(auth()->user()->isManajer() || auth()->user()->isAdmin())
                <a href="{{ route('menu.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mt-2 {{ request()->routeIs('menu.*') ? 'bg-pos-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span>🍔</span>
                    <span>Kelola Menu</span>
                </a>
                
                <a href="{{ route('reports.sales') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mt-2 {{ request()->routeIs('reports.*') ? 'bg-pos-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span>📈</span>
                    <span>Laporan</span>
                </a>
                @endif
                
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 w-full">
                        <span>🚪</span>
                        <span>Keluar</span>
                    </button>
                </form>
            </nav>
        </aside>
        @endauth

        <!-- Main Content -->
        <main class="flex-1 overflow-auto">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded m-4 no-print">
                {{ session('success') }}
            </div>
            @endif
            
            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded m-4 no-print">
                {{ session('error') }}
            </div>
            @endif
            
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
