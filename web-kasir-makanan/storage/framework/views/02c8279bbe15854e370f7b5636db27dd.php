<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Web Kasir Makanan'); ?></title>
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#3b82f6">
    <link rel="manifest" href="/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-100">
    <!-- Offline Indicator -->
    <div id="offline-indicator" class="offline-indicator hidden">
        ⚠️ Mode Offline - Data akan disinkronkan otomatis saat online
    </div>

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <?php if(auth()->guard()->check()): ?>
        <aside class="w-64 bg-white shadow-lg no-print">
            <div class="p-6 border-b">
                <h1 class="text-xl font-bold text-pos-primary">🍽️ Kasir Makanan</h1>
                <p class="text-sm text-gray-600"><?php echo e(auth()->user()->name); ?></p>
                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded"><?php echo e(ucfirst(auth()->user()->role)); ?></span>
            </div>
            
            <nav class="p-4">
                <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('dashboard') ? 'bg-pos-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>
                
                <a href="<?php echo e(route('pos.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg mt-2 <?php echo e(request()->routeIs('pos.*') ? 'bg-pos-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <span>💰</span>
                    <span>POS / Kasir</span>
                </a>
                
                <?php if(auth()->user()->isManajer() || auth()->user()->isAdmin()): ?>
                <a href="<?php echo e(route('menu.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg mt-2 <?php echo e(request()->routeIs('menu.*') ? 'bg-pos-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <span>🍔</span>
                    <span>Kelola Menu</span>
                </a>
                
                <a href="<?php echo e(route('reports.sales')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg mt-2 <?php echo e(request()->routeIs('reports.*') ? 'bg-pos-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <span>📈</span>
                    <span>Laporan</span>
                </a>
                <?php endif; ?>
                
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-4">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 w-full">
                        <span>🚪</span>
                        <span>Keluar</span>
                    </button>
                </form>
            </nav>
        </aside>
        <?php endif; ?>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto">
            <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded m-4 no-print">
                <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>
            
            <?php if(session('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded m-4 no-print">
                <?php echo e(session('error')); ?>

            </div>
            <?php endif; ?>
            
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Pribadi\LYNK\Template\web-kasir-makanan\resources\views/layouts/app.blade.php ENDPATH**/ ?>