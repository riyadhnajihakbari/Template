

<?php $__env->startSection('title', 'Menu & Harga'); ?>

<?php $__env->startSection('content'); ?>
<div class="fade-in-up">
    <!-- Welcome Banner -->
    <div class="mb-8 text-center">
        <h2 class="text-5xl font-bold text-white mb-2 drop-shadow-lg">
            Selamat Datang! 👋
        </h2>
        <p class="text-xl text-gray-200">
            Lihat menu dan harga kami di bawah ini
        </p>
    </div>

    <!-- Search & Filter -->
    <div class="mb-8 space-y-4">
        <!-- Search -->
        <div class="max-w-2xl mx-auto">
            <input type="text" 
                   id="search-menu" 
                   placeholder="🔍 Cari menu..." 
                   class="search-box w-full text-lg">
        </div>

        <!-- Category Filter -->
        <div class="flex flex-wrap justify-center gap-3">
            <button onclick="filterCategory('all')" 
                    class="category-btn active" 
                    data-category="all">
                Semua Menu
            </button>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button onclick="filterCategory('<?php echo e($category->id); ?>')" 
                    class="category-btn" 
                    data-category="<?php echo e($category->id); ?>">
                <?php echo e($category->name); ?>

            </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Menu Grid -->
    <div id="menu-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="menu-card menu-item" 
             data-category="<?php echo e($item->category_id); ?>" 
             data-name="<?php echo e(strtolower($item->name)); ?>"
             style="animation: fadeInUp 0.6s ease-out <?php echo e($loop->index * 0.1); ?>s both;">
            <!-- Image -->
            <?php if($item->photo_url): ?>
            <img src="<?php echo e(asset($item->photo_url)); ?>" 
                 alt="<?php echo e($item->name); ?>" 
                 class="menu-image"
                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'menu-placeholder\'>🍽️</div>';">
            <?php else: ?>
            <div class="menu-placeholder">
                🍽️
            </div>
            <?php endif; ?>

            <!-- Content -->
            <div class="menu-content">
                <h3 class="menu-name"><?php echo e($item->name); ?></h3>
                
                <?php if($item->description): ?>
                <p class="text-sm text-gray-300 mb-3 line-clamp-2"><?php echo e($item->description); ?></p>
                <?php endif; ?>

                <div class="menu-price">
                    Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?>

                </div>

                <!-- Stock Status -->
                <div class="mb-3">
                    <?php if($item->stock > 10): ?>
                    <span class="menu-stock stock-available">
                        ✓ Tersedia
                    </span>
                    <?php elseif($item->stock > 0): ?>
                    <span class="menu-stock stock-low">
                        ⚠️ Stok Terbatas (<?php echo e($item->stock); ?>)
                    </span>
                    <?php else: ?>
                    <span class="menu-stock stock-out">
                        ✕ Habis
                    </span>
                    <?php endif; ?>
                </div>

                <!-- Category Badge -->
                <div class="flex items-center justify-between">
                    <span class="inline-block px-3 py-1 text-xs rounded-full font-semibold"
                          style="background: rgba(255, 107, 53, 0.2); color: #FF8C61; border: 1px solid rgba(255, 107, 53, 0.3);">
                        <?php echo e($item->category->name); ?>

                    </span>
                    
                    <?php if($item->is_active): ?>
                    <span class="text-green-400 text-xs font-semibold">● Aktif</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full text-center py-20">
            <div class="bg-black/50 backdrop-blur-md rounded-2xl p-12 border-2 border-white/20 inline-block">
                <div class="text-6xl mb-4">🍽️</div>
                <p class="text-2xl font-bold text-white mb-2">Belum Ada Menu</p>
                <p class="text-gray-300">Menu akan ditampilkan di sini</p>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Empty State for Search -->
    <div id="no-results" class="hidden text-center py-20">
        <div class="bg-black/50 backdrop-blur-md rounded-2xl p-12 border-2 border-white/20 inline-block">
            <div class="text-6xl mb-4">🔍</div>
            <p class="text-2xl font-bold text-white mb-2">Menu Tidak Ditemukan</p>
            <p class="text-gray-300">Coba kata kunci lain</p>
        </div>
    </div>

    <!-- Total Menu Info -->
    <div class="mt-12 text-center">
        <div class="inline-block px-8 py-4 bg-black/50 backdrop-blur-md rounded-2xl border-2 border-white/20">
            <p class="text-sm text-gray-300 mb-1">Total Menu Tersedia</p>
            <p class="text-4xl font-bold" style="background: linear-gradient(135deg, #FF6B35 0%, #FF8C61 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <?php echo e($menuItems->count()); ?>

            </p>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Filter by category
function filterCategory(categoryId) {
    const items = document.querySelectorAll('.menu-item');
    const buttons = document.querySelectorAll('.category-btn');
    const noResults = document.getElementById('no-results');
    const menuGrid = document.getElementById('menu-grid');
    
    // Update button styles
    buttons.forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Filter items
    let visibleCount = 0;
    items.forEach(item => {
        if (categoryId === 'all' || item.dataset.category === categoryId) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    // Show/hide no results
    if (visibleCount === 0) {
        menuGrid.style.display = 'none';
        noResults.classList.remove('hidden');
    } else {
        menuGrid.style.display = 'grid';
        noResults.classList.add('hidden');
    }
}

// Search menu
document.getElementById('search-menu')?.addEventListener('input', (e) => {
    const search = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.menu-item');
    const noResults = document.getElementById('no-results');
    const menuGrid = document.getElementById('menu-grid');
    
    let visibleCount = 0;
    items.forEach(item => {
        const name = item.dataset.name;
        
        // Check current category filter
        const activeCategory = document.querySelector('.category-btn.active');
        const currentCategory = activeCategory ? activeCategory.dataset.category : 'all';
        const itemCategory = item.dataset.category;
        
        // Show if matches search AND category
        if (name.includes(search) && (currentCategory === 'all' || itemCategory === currentCategory)) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    // Show/hide no results
    if (visibleCount === 0) {
        menuGrid.style.display = 'none';
        noResults.classList.remove('hidden');
    } else {
        menuGrid.style.display = 'grid';
        noResults.classList.add('hidden');
    }
});

// Auto refresh every 30 seconds to get latest menu updates
setInterval(() => {
    if (document.hidden) return; // Don't refresh if tab is not active
    
    console.log('Checking for menu updates...');
    // You can add AJAX call here to refresh menu without page reload
}, 30000);

// Add smooth scroll behavior
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.customer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Pribadi\LYNK\Template\web-kasir-makanan\resources\views/customer/menu.blade.php ENDPATH**/ ?>