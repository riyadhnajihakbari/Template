<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Web Kasir Makanan')</title>
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#FF6B35">
    <link rel="manifest" href="/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Custom Theme Colors */
        :root {
            --primary: #FF6B35;
            --primary-hover: #E55A2B;
            --primary-light: #FFE5DC;
            --dark-bg: #1a1a1a;
            --dark-card: #2d2d2d;
            --dark-border: #404040;
        }

        body {
            background-color: var(--dark-bg);
            color: #e5e5e5;
        }

        /* Glassmorphism Effect */
        .glass-card {
            background: rgba(45, 45, 45, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Primary Button */
        .btn-primary {
            background-color: var(--primary);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.4);
        }

        /* Sidebar Active State */
        .nav-active {
            background-color: var(--primary);
            color: white;
        }
        .nav-link {
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            background-color: rgba(255, 107, 53, 0.1);
            transform: translateX(5px);
        }

        /* Card Styles */
        .dashboard-card {
            background: linear-gradient(135deg, rgba(45, 45, 45, 0.9), rgba(30, 30, 30, 0.9));
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        /* Stat Cards */
        .stat-card-orange {
            background: linear-gradient(135deg, #FF6B35, #E55A2B);
        }
        .stat-card-green {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        .stat-card-purple {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }
        .stat-card-blue {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        /* Table Styles */
        .dark-table {
            background-color: rgba(45, 45, 45, 0.5);
        }
        .dark-table thead {
            background-color: rgba(30, 30, 30, 0.8);
            border-bottom: 2px solid var(--primary);
        }
        .dark-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: background-color 0.2s ease;
        }
        .dark-table tbody tr:hover {
            background-color: rgba(255, 107, 53, 0.05);
        }

        /* Status Badges */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-done {
            background-color: rgba(16, 185, 129, 0.2);
            color: #10b981;
            border: 1px solid #10b981;
        }
        .status-process {
            background-color: rgba(255, 107, 53, 0.2);
            color: #FF6B35;
            border: 1px solid #FF6B35;
        }
        .status-new {
            background-color: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
            border: 1px solid #3b82f6;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-hover);
        }

        /* Offline Indicator */
        .offline-indicator {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #ef4444;
            color: white;
            padding: 0.75rem;
            text-align: center;
            z-index: 9999;
            font-weight: 600;
        }

        /* Print Styles */
        @media print {
            .no-print {
                display: none !important;
            }
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .slide-in {
            animation: slideIn 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gray-900">
    <!-- Offline Indicator -->
    <div id="offline-indicator" class="offline-indicator hidden">
        ⚠️ Mode Offline - Data akan disinkronkan otomatis saat online
    </div>

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @auth
        <aside class="w-64 glass-card shadow-2xl no-print border-r border-white/10">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br flex items-center justify-center text-2xl animate-pulse">
                        <img src="{{ asset('uploads/images/Logo.png') }}" alt="Logo" class="w-16 h-16 animate-pulse">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Kasir Makanan</h1>
                    </div>
                </div>
                <div class="rounded-lg p-3 mt-3">
                    <p class="text-sm text-gray-300 font-semibold">{{ auth()->user()->name }}</p>
                    <span class="inline-block text-xs px-2 py-1 mt-1 rounded-full" 
                          style="background-color: rgba(255, 107, 53, 0.2); color: #FF6B35; border: 1px solid #FF6B35;">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
            </div>
            
            <nav class="p-4 space-y-2">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'nav-active' : 'nav-link text-gray-300' }}">
                    <span class="text-xl">📊</span>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('pos.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('pos.*') ? 'nav-active' : 'nav-link text-gray-300' }}">
                    <span class="text-xl">💰</span>
                    <span class="font-medium">POS / Kasir</span>
                </a>
                
                @if(auth()->user()->isManajer() || auth()->user()->isAdmin())
                <a href="{{ route('menu.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('menu.*') ? 'nav-active' : 'nav-link text-gray-300' }}">
                    <span class="text-xl">🍔</span>
                    <span class="font-medium">Kelola Menu</span>
                </a>
                
                <a href="{{ route('reports.sales') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('reports.*') ? 'nav-active' : 'nav-link text-gray-300' }}">
                    <span class="text-xl">📈</span>
                    <span class="font-medium">Laporan</span>
                </a>
                @endif
                
                <div class="pt-4 mt-4 border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="flex items-center space-x-3 px-4 py-3 rounded-lg text-red-400 hover:bg-red-500/10 w-full transition-all duration-300">
                            <span class="text-xl">🚪</span>
                            <span class="font-medium">Keluar</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>
        @endauth

        <!-- Main Content -->
        <main class="flex-1 overflow-auto">
            <!-- Notifications -->
            <div class="no-print">
                @if(session('success'))
                <div class="m-4 p-4 rounded-lg bg-green-500/20 border border-green-500 text-green-300 slide-in">
                    <div class="flex items-center space-x-2">
                        <span class="text-xl">✅</span>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
                @endif
                
                @if(session('error'))
                <div class="m-4 p-4 rounded-lg bg-red-500/20 border border-red-500 text-red-300 slide-in">
                    <div class="flex items-center space-x-2">
                        <span class="text-xl">❌</span>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
                @endif
            </div>
            
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>