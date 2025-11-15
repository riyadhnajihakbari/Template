<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SportifyX</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="hidden lg:flex lg:flex-shrink-0">
            <div class="w-64 bg-gray-900 text-white flex flex-col">
                <!-- Logo -->
                <div class="p-6 border-b border-gray-800">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <span class="text-xl">⚽</span>
                        </div>
                        <span class="text-lg font-bold">SportifyX <span class="text-xs text-gray-400">Admin</span></span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto py-4">
                    <div class="px-4 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            <span class="w-6">📊</span>
                            <span class="ml-3">Dashboard</span>
                        </a>

                        <div class="pt-4">
                            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Konten</p>
                        </div>

                        <a href="{{ route('admin.events.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.events.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            <span class="w-6">🎫</span>
                            <span class="ml-3">Events</span>
                        </a>
                        <a href="{{ route('admin.news.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.news.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            <span class="w-6">📰</span>
                            <span class="ml-3">Berita</span>
                        </a>
                        <a href="{{ route('admin.matches.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.matches.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            <span class="w-6">🏆</span>
                            <span class="ml-3">Hasil Pertandingan</span>
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            <span class="w-6">🛍️</span>
                            <span class="ml-3">Produk Store</span>
                        </a>

                        <div class="pt-4">
                            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Transaksi</p>
                        </div>

                        <a href="{{ route('admin.orders.tickets') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.orders.tickets') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            <span class="w-6">🎟️</span>
                            <span class="ml-3">Order Tiket</span>
                        </a>
                        <a href="{{ route('admin.orders.store') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.orders.store') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            <span class="w-6">📦</span>
                            <span class="ml-3">Order Store</span>
                        </a>
                        </div>
                        <div class="pt-4">
                            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengaturan</p>
                        </div>

                        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            <span class="w-6">👥</span>
                            <span class="ml-3">Users</span>
                        </a>
                        <a href="{{ route('admin.payment-methods.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.payment-methods.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            <span class="w-6">💳</span>
                            <span class="ml-3">Payment Methods</span>
                        </a>
                        <a href="{{ route('admin.scan.page') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.scan.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                        <span class="w-6">📷</span>
                        <span class="ml-3">Scan Tiket</span>
                        </a>
                </nav>

                <!-- User -->
                <div class="p-4 border-t border-gray-800">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <span class="font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400">Administrator</p>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="mt-4 block text-center py-2 bg-gray-800 hover:bg-gray-700 rounded-lg text-sm">
                        ← Kembali ke Site
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h1 class="text-xl font-semibold text-gray-900">@yield('header', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">{{ now()->format('d M Y') }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-red-600 text-sm">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center">
                        <span class="mr-3">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center">
                        <span class="mr-3">✕</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>