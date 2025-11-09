<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ config('app.name') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .menu-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            border-color: rgba(255, 255, 255, 0.6);
        }
        
        .menu-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .menu-placeholder {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
        }
        
        .menu-content {
            padding: 1.5rem;
        }
        
        .menu-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        
        .menu-price {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
        }
        
        .menu-stock {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .stock-available {
            background: #d1fae5;
            color: #065f46;
        }
        
        .stock-low {
            background: #fed7aa;
            color: #92400e;
        }
        
        .stock-out {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .category-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .category-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        
        .category-btn.active {
            background: white;
            color: #667eea;
            border-color: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        .search-box {
            padding: 1rem 1.5rem;
            border-radius: 50px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .search-box:focus {
            outline: none;
            border-color: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar sticky top-0 z-50 mb-8">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-2xl">
                        🍽️
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Rumah Makan</h1>
                        <p class="text-sm text-gray-200">Menu & Harga</p>
                    </div>
                </div>
                
                <!-- User Info -->
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm text-gray-200">Selamat Datang,</p>
                        <p class="font-semibold text-white">{{ Auth::user()->name }}</p>
                    </div>
                    
                    <!-- Logout -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-all font-semibold border-2 border-white/30">
                            🚪 Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 pb-12">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-12 py-8 text-center text-white">
        <div class="container mx-auto px-4">
            <p class="text-sm opacity-75">
                © {{ date('Y') }} Rumah Makan Sederhana. All rights reserved.
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>