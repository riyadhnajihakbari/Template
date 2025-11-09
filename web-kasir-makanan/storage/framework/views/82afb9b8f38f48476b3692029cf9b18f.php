<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-white mb-2">Dashboard</h2>
        <p class="text-gray-400">Selamat datang kembali, <?php echo e(auth()->user()->name); ?>! 👋</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Penjualan Hari Ini -->
        <div class="stat-card-orange text-white rounded-xl shadow-lg p-6 dashboard-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm mb-1 font-medium">Penjualan Hari Ini</p>
                    <h3 class="text-3xl font-bold">Rp <?php echo e(number_format($todaySales, 0, ',', '.')); ?></h3>
                </div>
                <div class="text-6xl opacity-30">💰</div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/20">
                <p class="text-xs text-white/70">📅 <?php echo e(now()->format('d F Y')); ?></p>
            </div>
        </div>

        <!-- Transaksi Hari Ini -->
        <div class="stat-card-green text-white rounded-xl shadow-lg p-6 dashboard-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm mb-1 font-medium">Transaksi Hari Ini</p>
                    <h3 class="text-3xl font-bold"><?php echo e($todayOrders); ?></h3>
                </div>
                <div class="text-6xl opacity-30">📊</div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/20">
                <p class="text-xs text-white/70">Transaksi berhasil</p>
            </div>
        </div>

        <!-- Rata-rata Transaksi -->
        <div class="stat-card-purple text-white rounded-xl shadow-lg p-6 dashboard-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm mb-1 font-medium">Rata-rata Transaksi</p>
                    <h3 class="text-3xl font-bold">
                        Rp <?php echo e($todayOrders > 0 ? number_format($todaySales / $todayOrders, 0, ',', '.') : 0); ?>

                    </h3>
                </div>
                <div class="text-6xl opacity-30">📈</div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/20">
                <p class="text-xs text-white/70">Per transaksi</p>
            </div>
        </div>

        <!-- Status -->
        <div class="stat-card-blue text-white rounded-xl shadow-lg p-6 dashboard-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm mb-1 font-medium">Status Sistem</p>
                    <h3 class="text-2xl font-bold">Aktif</h3>
                </div>
                <div class="text-6xl opacity-30">✅</div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/20">
                <p class="text-xs text-white/70">Semua sistem berjalan normal</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="glass-card rounded-xl shadow-lg p-6 dashboard-card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white flex items-center space-x-2">
                    <span>📋</span>
                    <span>Transaksi Terbaru</span>
                </h3>
                <a href="<?php echo e(route('pos.index')); ?>" class="text-sm font-medium hover:text-white transition-colors" style="color: #FF6B35;">
                    Lihat Semua →
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full dark-table rounded-lg overflow-hidden">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">No. Order</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Meja</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-300 font-medium"><?php echo e($order->order_number); ?></td>
                            <td class="px-4 py-3 text-sm text-gray-300">Meja <?php echo e($order->table_number); ?></td>
                            <td class="px-4 py-3 text-sm font-semibold text-white">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></td>
                            <td class="px-4 py-3">
                                <?php if($order->status == 'completed'): ?>
                                <span class="status-badge status-done">Selesai</span>
                                <?php elseif($order->status == 'processing'): ?>
                                <span class="status-badge status-process">Diproses</span>
                                <?php else: ?>
                                <span class="status-badge status-new">Baru</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center">
                                <div class="text-gray-500">
                                    <div class="text-4xl mb-2">📭</div>
                                    <p>Belum ada transaksi hari ini</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Popular Items -->
        <div class="glass-card rounded-xl shadow-lg p-6 dashboard-card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white flex items-center space-x-2">
                    <span>🔥</span>
                    <span>Menu Populer Hari Ini</span>
                </h3>
                <a href="<?php echo e(route('menu.index')); ?>" class="text-sm font-medium hover:text-white transition-colors" style="color: #FF6B35;">
                    Lihat Menu →
                </a>
            </div>
            
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $popularItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between p-4 rounded-lg transition-all duration-300 hover:bg-white/5" 
                     style="background-color: rgba(45, 45, 45, 0.5);">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-2xl"
                             style="background: linear-gradient(135deg, #FF6B35, #E55A2B);">
                            🍽️
                        </div>
                        <div>
                            <div class="font-semibold text-white"><?php echo e($item->name); ?></div>
                            <div class="text-sm text-gray-400">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold" style="color: #FF6B35;"><?php echo e($item->total_sold); ?></div>
                        <div class="text-xs text-gray-400">terjual</div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-12">
                    <div class="text-gray-500">
                        <div class="text-4xl mb-2">🍽️</div>
                        <p>Belum ada penjualan hari ini</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions (Optional) -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="<?php echo e(route('pos.index')); ?>" class="glass-card rounded-xl p-6 dashboard-card hover:scale-105 transition-transform duration-300">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-full flex items-center justify-center text-3xl"
                     style="background: linear-gradient(135deg, #FF6B35, #E55A2B);">
                    💰
                </div>
                <div>
                    <h4 class="font-bold text-white">Buat Transaksi Baru</h4>
                    <p class="text-sm text-gray-400">Mulai penjualan baru</p>
                </div>
            </div>
        </a>

        <?php if(auth()->user()->isManajer() || auth()->user()->isAdmin()): ?>
        <a href="<?php echo e(route('menu.index')); ?>" class="glass-card rounded-xl p-6 dashboard-card hover:scale-105 transition-transform duration-300">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-full flex items-center justify-center text-3xl"
                     style="background: linear-gradient(135deg, #10b981, #059669);">
                    🍔
                </div>
                <div>
                    <h4 class="font-bold text-white">Kelola Menu</h4>
                    <p class="text-sm text-gray-400">Tambah atau edit menu</p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('reports.sales')); ?>" class="glass-card rounded-xl p-6 dashboard-card hover:scale-105 transition-transform duration-300">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-full flex items-center justify-center text-3xl"
                     style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                    📈
                </div>
                <div>
                    <h4 class="font-bold text-white">Lihat Laporan</h4>
                    <p class="text-sm text-gray-400">Analisis penjualan</p>
                </div>
            </div>
        </a>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Pribadi\LYNK\Template\web-kasir-makanan\resources\views/dashboard/index.blade.php ENDPATH**/ ?>