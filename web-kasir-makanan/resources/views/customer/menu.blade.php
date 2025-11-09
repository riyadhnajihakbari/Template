@extends('layouts.customer')

@section('title', 'Menu & Harga')

@section('content')
<div class="fade-in-up">
    <!-- Welcome Banner -->
    <div class="mb-8 text-center">
        <h2 class="text-4xl font-bold text-white mb-2">
            Selamat Datang! 👋
        </h2>
        <p class="text-xl text-gray-300">
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
            @foreach($categories as $category)
            <button onclick="filterCategory('{{ $category->id }}')" 
                    class="category-btn" 
                    data-category="{{ $category->id }}">
                {{ $category->name }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Menu Grid -->
    <div id="menu-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($menuItems as $item)
        <div class="menu-card menu-item" 
             data-category="{{ $item->category_id }}" 
             data-name="{{ strtolower($item->name) }}"
             style="animation: fadeInUp 0.6s ease-out {{ $loop->index * 0.1 }}s both;">
            <!-- Image -->
            @if($item->photo_url)
            <img src="{{ asset('storage/' . $item->photo_url) }}" 
                 alt="{{ $item->name }}" 
                 class="menu-image">
            @else
            <div class="menu-placeholder">
                🍽️
            </div>
            @endif

            <!-- Content -->
            <div class="menu-content">
                <h3 class="menu-name">{{ $item->name }}</h3>
                
                @if($item->description)
                <p class="text-sm text-gray-400 mb-3">{{ $item->description }}</p>
                @endif

                <div class="menu-price">
                    Rp {{ number_format($item->price, 0, ',', '.') }}
                </div>

                <!-- Stock Status -->
                @if($item->stock > 10)
                <span class="menu-stock stock-available">
                    ✓ Tersedia
                </span>
                @elseif($item->stock > 0)
                <span class="menu-stock stock-low">
                    ⚠️ Stok Terbatas ({{ $item->stock }})
                </span>
                @else
                <span class="menu-stock stock-out">
                    ✕ Habis
                </span>
                @endif

                <!-- Category Badge -->
                <div class="mt-3">
                    <span class="inline-block px-3 py-1 bg-white/10 text-white text-xs rounded-full">
                        {{ $item->category->name }}
                    </span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-20">
            <div class="text-6xl mb-4">🍽️</div>
            <p class="text-2xl font-bold text-white mb-2">Belum Ada Menu</p>
            <p class="text-gray-400">Menu akan ditampilkan di sini</p>
        </div>
        @endforelse
    </div>

    <!-- Empty State for Search -->
    <div id="no-results" class="hidden text-center py-20">
        <div class="text-6xl mb-4">🔍</div>
        <p class="text-2xl font-bold text-white mb-2">Menu Tidak Ditemukan</p>
        <p class="text-gray-400">Coba kata kunci lain</p>
    </div>

    <!-- Total Menu Info -->
    <div class="mt-12 text-center">
        <div class="inline-block px-8 py-4 bg-white/10 backdrop-blur-sm rounded-2xl border-2 border-white/20">
            <p class="text-sm text-gray-300 mb-1">Total Menu Tersedia</p>
            <p class="text-4xl font-bold text-white">{{ $menuItems->count() }}</p>
        </div>
    </div>
</div>

@push('scripts')
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
</script>
@endpush
@endsection