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
        /* Custom Theme Colors - Modern Light */
        :root {
            --primary: #FF6B35;
            --primary-hover: #E55A2B;
            --primary-light: #FFF5F2;
            --secondary: #10b981;
            --accent: #8b5cf6;
            --bg-main: #f8fafc;
            --card-white: #ffffff;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            background-attachment: fixed;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        /* Modern Sidebar */
        .modern-sidebar {
            background: linear-gradient(180deg, #ffffff 0%, #fefefe 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.06);
            position: relative;
        }

        .modern-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #FF6B35 0%, #E55A2B 100%);
        }

        /* Navigation Styles */
        .nav-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #FF6B35;
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .nav-link:hover::before {
            transform: scaleY(1);
        }

        .nav-link:hover {
            background: linear-gradient(90deg, #FFF5F2 0%, transparent 100%);
            transform: translateX(8px);
            color: #FF6B35;
        }

        .nav-active {
            background: linear-gradient(90deg, #FF6B35 0%, #E55A2B 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            transform: translateX(8px);
        }

        .nav-active::before {
            transform: scaleY(1);
            background: white;
        }

        /* Modern Cards */
        .modern-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .modern-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #FF6B35 0%, #E55A2B 100%);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .modern-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }

        .modern-card:hover::before {
            transform: scaleX(1);
        }

        /* Gradient Stat Cards */
        .stat-card {
            border-radius: 20px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover::after {
            opacity: 1;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-orange {
            background: linear-gradient(135deg, #FF6B35 0%, #FF8C61 100%);
        }

        .stat-green {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }

        .stat-purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
        }

        .stat-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
        }

        .stat-red {
            background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        }

        /* Modern Table */
        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .modern-table thead th {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            color: #475569;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem;
            border-bottom: 2px solid #FF6B35;
        }

        .modern-table tbody tr {
            transition: all 0.2s ease;
            background: white;
        }

        .modern-table tbody tr:hover {
            background: linear-gradient(90deg, #FFF5F2 0%, white 100%);
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(255, 107, 53, 0.1);
        }

        .modern-table tbody td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.375rem 0.875rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .status-done {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .status-process {
            background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
            color: #9a3412;
            border: 1px solid #fb923c;
        }

        .status-new {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            border: 1px solid #93c5fd;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #FF6B35 0%, #E55A2B 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Scrollbar - DEFAULT STYLE (NO COLOR) */
        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 6px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Animations */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        .slide-in {
            animation: slideInLeft 0.5s ease-out;
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Toast Notification - MODERN */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            pointer-events: none;
        }

        .toast {
            pointer-events: all;
            min-width: 300px;
            max-width: 500px;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideInRight 0.3s ease-out;
            backdrop-filter: blur(10px);
        }

        .toast.hiding {
            animation: slideOutRight 0.3s ease-out forwards;
        }

        .toast-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-left: 4px solid #10b981;
            color: #065f46;
        }

        .toast-error {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }

        .toast-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
            color: #92400e;
        }

        .toast-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-left: 4px solid #3b82f6;
            color: #1e40af;
        }

        .toast-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }

        .toast-message {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .toast-close {
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.2s;
            color: inherit;
            flex-shrink: 0;
        }

        .toast-close:hover {
            opacity: 1;
        }

        /* Print Styles */
        @media print {
            .no-print {
                display: none !important;
            }
        }

        /* User Badge */
        .user-badge {
            background: linear-gradient(135deg, #FFF5F2 0%, #FFE5DC 100%);
            color: #FF6B35;
            border: 1.5px solid #FF6B35;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Logo Animation */
        .logo-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: .8;
                transform: scale(1.05);
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Toast Container -->
    <div id="toast-container" class="toast-container"></div>

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @auth
        <aside class="w-64 modern-sidebar no-print">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl logo-pulse shadow-lg">
                        <img src="{{ asset('uploads/images/Logo.png') }}" alt="Logo" class="w-16 h-16">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">Kasir Makanan</h1>
                    </div>
                </div>
                <div class="user-badge">
                    <div id="connection-status" class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <div>
                        <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                        <span class="text-xs opacity-75">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                </div>
            </div>
            
            <nav class="p-4 space-y-2">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'nav-active' : 'nav-link text-gray-700' }}">
                    <span class="text-xl">📊</span>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('pos.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('pos.*') ? 'nav-active' : 'nav-link text-gray-700' }}">
                    <span class="text-xl">💰</span>
                    <span class="font-medium">POS / Kasir</span>
                </a>
                
                @if(auth()->user()->isManajer() || auth()->user()->isAdmin())
                <a href="{{ route('menu.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('menu.*') ? 'nav-active' : 'nav-link text-gray-700' }}">
                    <span class="text-xl">🍔</span>
                    <span class="font-medium">Kelola Menu</span>
                </a>
                
                <a href="{{ route('reports.sales') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('reports.*') ? 'nav-active' : 'nav-link text-gray-700' }}">
                    <span class="text-xl">📈</span>
                    <span class="font-medium">Laporan</span>
                </a>
                @endif

                @if(auth()->user()->isAdmin())
                <a href="{{ route('users.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('users.*') ? 'nav-active' : 'nav-link text-gray-700' }}">
                    <span class="text-xl">👥</span>
                    <span class="font-medium">Kelola User</span>
                </a>
                @endif
                
                <div class="pt-4 mt-4 border-t border-gray-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="flex items-center space-x-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 w-full transition-all duration-300 nav-link">
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
            @yield('content')
        </main>
    </div>

    <!-- Toast Script -->
    <script>
        window.Toast = {
            show(message, type = 'info', title = null, duration = 4000) {
                const container = document.getElementById('toast-container');
                const toast = document.createElement('div');
                
                const icons = {
                    success: '✅',
                    error: '❌',
                    warning: '⚠️',
                    info: 'ℹ️'
                };

                const titles = {
                    success: title || 'Berhasil!',
                    error: title || 'Terjadi Kesalahan!',
                    warning: title || 'Peringatan!',
                    info: title || 'Informasi'
                };

                toast.className = `toast toast-${type}`;
                toast.innerHTML = `
                    <div class="toast-icon">${icons[type] || icons.info}</div>
                    <div class="toast-content">
                        <div class="toast-title">${titles[type]}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                    <button class="toast-close" onclick="this.parentElement.remove()">×</button>
                `;

                container.appendChild(toast);

                setTimeout(() => {
                    toast.classList.add('hiding');
                    setTimeout(() => toast.remove(), 300);
                }, duration);
            },

            success(message, title) {
                this.show(message, 'success', title);
            },

            error(message, title) {
                this.show(message, 'error', title);
            },

            warning(message, title) {
                this.show(message, 'warning', title);
            },

            info(message, title) {
                this.show(message, 'info', title);
            }
        };

        @if(session('success'))
            Toast.success('{{ session('success') }}');
        @endif

        @if(session('error'))
            Toast.error('{{ session('error') }}');
        @endif

        @if(session('warning'))
            Toast.warning('{{ session('warning') }}');
        @endif

        @if(session('info'))
            Toast.info('{{ session('info') }}');
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                Toast.error('{{ $error }}');
            @endforeach
        @endif
    </script>

    @stack('scripts')
</body>
</html>