<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title'); ?> - <?php echo e(config('app.name')); ?></title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url('<?php echo e(asset('uploads/images/backgroundlogin.jpeg')); ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
        }
        
        /* Overlay gelap */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 0;
        }
        
        /* Custom color theme - Orange seperti login */
        :root {
            --primary: #FF6B35;
            --primary-hover: #E55A2B;
            --primary-light: #FFF5F2;
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
        
        /* Menu Card - Glass morphism seperti login box */
        .menu-card {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(255, 107, 53, 0.3);
            border-color: var(--primary);
        }
        
        .menu-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .menu-placeholder {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.3) 0%, rgba(229, 90, 43, 0.3) 100%);
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
            color: #ffffff;
            margin-bottom: 0.5rem;
        }
        
        .menu-price {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary) 0%, #FF8C61 100%);
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
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        
        .stock-low {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }
        
        .stock-out {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        /* Category Button - Orange theme */
        .category-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .category-btn:hover {
            background: rgba(255, 107, 53, 0.3);
            border-color: var(--primary);
            transform: translateY(-2px);
        }
        
        .category-btn.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.4);
        }
        
        /* Search Box */
        .search-box {
            padding: 1rem 1.5rem;
            border-radius: 50px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .search-box::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .search-box:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2);
        }
        
        /* Navbar - Glass morphism */
        .navbar {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Partikel lembut */
        .particle {
            position: fixed;
            border-radius: 50%;
            background: rgba(255, 107, 53, 0.3);
            animation: float 12s infinite ease-in-out;
            pointer-events: none;
            z-index: 1;
        }

        @keyframes float {
            0% { transform: translateY(0) translateX(0); opacity: 0.8; }
            50% { transform: translateY(-40px) translateX(20px); opacity: 0.4; }
            100% { transform: translateY(0) translateX(0); opacity: 0.8; }
        }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Partikel lembut -->
    <div class="fixed inset-0 pointer-events-none" style="z-index: 1;">
        <?php for($i = 0; $i < 15; $i++): ?>
            <div class="particle" 
                style="
                    width: <?php echo e(rand(4,10)); ?>px; 
                    height: <?php echo e(rand(4,10)); ?>px; 
                    top: <?php echo e(rand(0,100)); ?>%; 
                    left: <?php echo e(rand(0,100)); ?>%; 
                    animation-delay: <?php echo e(rand(0,10) / 2); ?>s;
                ">
            </div>
        <?php endfor; ?>
    </div>

    <!-- Navbar -->
    <nav class="navbar sticky top-0 z-50 mb-8">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center text-2xl border-2 border-white/20">
                        <img src="<?php echo e(asset('uploads/images/Logo.png')); ?>" alt="Logo" class="w-10 h-10 animate-pulse">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Rumah Makan</h1>
                        <p class="text-sm text-gray-300">Menu & Harga</p>
                    </div>
                </div>
                
                <!-- User Info -->
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm text-gray-300">Selamat Datang,</p>
                        <p class="font-semibold text-white"><?php echo e(Auth::user()->name); ?></p>
                    </div>
                    
                    <!-- Logout -->
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-4 py-2 rounded-lg font-semibold transition-all"
                                style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%); color: white; border: 2px solid rgba(255, 255, 255, 0.3);">
                            🚪 Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 pb-12 relative z-10">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 mt-12 py-8 text-center text-white">
        <div class="container mx-auto px-4">
            <div class="bg-black/50 backdrop-blur-md rounded-2xl p-6 border border-white/20 inline-block">
                <p class="text-sm opacity-75">
                    © <?php echo e(date('Y')); ?> Rumah Makan Sederhana. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\Pribadi\LYNK\Template\web-kasir-makanan\resources\views/layouts/customer.blade.php ENDPATH**/ ?>