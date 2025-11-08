<?php $__env->startSection('title', 'POS - Kasir'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Point of Sale (POS)</h2>
        <div class="flex items-center space-x-2">
            <span id="online-status" class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                🟢 Online
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Menu Items -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="mb-4">
                    <input type="text" id="search-menu" placeholder="Cari menu..." 
                           class="input-field">
                </div>

                <!-- Category Tabs -->
                <div class="flex space-x-2 mb-4 overflow-x-auto">
                    <button onclick="filterCategory('all')" class="category-btn px-4 py-2 rounded-lg bg-pos-primary text-white font-semibold whitespace-nowrap">
                        Semua
                    </button>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button onclick="filterCategory('<?php echo e($category->id); ?>')" class="category-btn px-4 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold whitespace-nowrap hover:bg-gray-300">
                        <?php echo e($category->name); ?>

                    </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Menu Grid -->
                <div id="menu-grid" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $category->menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="menu-item-card" data-category="<?php echo e($category->id); ?>" onclick='POS.addToCart(<?php echo json_encode($item, 15, 512) ?>)'>
                            <?php if($item->photo_url): ?>
                            <img src="<?php echo e(asset('storage/' . $item->photo_url)); ?>" alt="<?php echo e($item->name); ?>" class="w-full h-32 object-cover rounded-lg mb-2">
                            <?php else: ?>
                            <div class="w-full h-32 bg-gray-200 rounded-lg mb-2 flex items-center justify-center text-4xl">
                                🍽️
                            </div>
                            <?php endif; ?>
                            <h3 class="font-semibold text-gray-800"><?php echo e($item->name); ?></h3>
                            <p class="text-pos-primary font-bold">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></p>
                            <?php if($item->stock > 0): ?>
                            <span class="text-xs text-gray-600">Stok: <?php echo e($item->stock); ?></span>
                            <?php else: ?>
                            <span class="text-xs text-red-600 font-semibold">Habis</span>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Cart -->
        <div class="lg:col-span-1">
            <div class="card sticky top-6">
                <h3 class="text-xl font-bold mb-4">Pesanan</h3>
                
                <!-- NEW: Order Type Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Pesanan</label>
                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="POS.setOrderType('dine_in')" id="btn-dine-in" 
                                class="px-4 py-3 rounded-lg border-2 border-gray-300 hover:border-pos-primary transition-all">
                            <div class="text-2xl mb-1">🍽️</div>
                            <div class="font-semibold text-sm">Dine In</div>
                        </button>
                        <button onclick="POS.setOrderType('takeaway')" id="btn-takeaway" 
                                class="px-4 py-3 rounded-lg border-2 border-pos-primary bg-pos-primary bg-opacity-10 transition-all">
                            <div class="text-2xl mb-1">🥡</div>
                            <div class="font-semibold text-sm">Take Away</div>
                        </button>
                    </div>
                </div>

                <!-- Table Number / Customer Name -->
                <div class="mb-4" id="table-number-container">
                    <label class="block text-sm font-semibold text-gray-700 mb-2" id="table-label">
                        Nama Pelanggan
                    </label>
                    <input type="text" id="table-number" placeholder="Nama pelanggan" 
                           class="input-field">
                </div>

                <div id="cart-items" class="border rounded-lg max-h-64 overflow-y-auto mb-4">
                    <!-- Cart items will be inserted here -->
                </div>

                <div class="border-t pt-4 mb-4">
                    <div class="flex justify-between items-center text-xl font-bold">
                        <span>Total:</span>
                        <span id="cart-total" class="text-pos-primary">Rp 0</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <button onclick="openPaymentModal('cash')" id="checkout-btn" disabled
                            class="btn-success w-full">
                        💵 Bayar Tunai
                    </button>
                    <button onclick="openPaymentModal('qris')" id="checkout-qris-btn" disabled
                            class="btn-primary w-full">
                        📱 Bayar QRIS
                    </button>
                    <button onclick="POS.cart.clear()" class="btn-secondary w-full">
                        🗑️ Bersihkan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="payment-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 no-print">
    <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-bold mb-4">Pembayaran</h3>
        
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
            <select id="payment-method" class="input-field">
                <option value="cash">Tunai</option>
                <option value="qris">QRIS</option>
                <option value="debit">Kartu Debit</option>
                <option value="credit">Kartu Kredit</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Total Bayar</label>
            <input type="number" id="paid-amount" class="input-field text-2xl font-bold" placeholder="0">
        </div>

        <div id="change-display" class="hidden mb-4 p-4 bg-green-100 rounded-lg">
            <div class="text-sm text-gray-600">Kembalian:</div>
            <div id="change-amount" class="text-2xl font-bold text-green-600">Rp 0</div>
        </div>

        <div class="flex space-x-2">
            <button onclick="closePaymentModal()" class="btn-secondary flex-1">
                Batal
            </button>
            <button onclick="processPayment()" class="btn-success flex-1">
                Proses
            </button>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let currentPaymentMethod = 'cash';
let currentTotal = 0;

function filterCategory(categoryId) {
    const items = document.querySelectorAll('.menu-item-card');
    const buttons = document.querySelectorAll('.category-btn');
    
    // Reset button styles
    buttons.forEach(btn => {
        btn.className = 'category-btn px-4 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold whitespace-nowrap hover:bg-gray-300';
    });
    
    // Highlight active button
    event.target.className = 'category-btn px-4 py-2 rounded-lg bg-pos-primary text-white font-semibold whitespace-nowrap';
    
    items.forEach(item => {
        if (categoryId === 'all' || item.dataset.category === categoryId) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

function openPaymentModal(method) {
    currentPaymentMethod = method;
    document.getElementById('payment-method').value = method;
    document.getElementById('payment-modal').classList.remove('hidden');
    
    // Get current total
    const totalText = document.getElementById('cart-total').textContent;
    currentTotal = parseInt(totalText.replace(/[^0-9]/g, ''));
    
    // Set paid amount for non-cash
    if (method !== 'cash') {
        document.getElementById('paid-amount').value = currentTotal;
        calculateChange();
    }
}

function closePaymentModal() {
    document.getElementById('payment-modal').classList.add('hidden');
    document.getElementById('paid-amount').value = '';
    document.getElementById('change-display').classList.add('hidden');
}

function calculateChange() {
    const paidAmount = parseInt(document.getElementById('paid-amount').value) || 0;
    const change = paidAmount - currentTotal;
    
    if (change >= 0) {
        document.getElementById('change-amount').textContent = 'Rp ' + change.toLocaleString('id-ID');
        document.getElementById('change-display').classList.remove('hidden');
    } else {
        document.getElementById('change-display').classList.add('hidden');
    }
}

document.getElementById('paid-amount')?.addEventListener('input', calculateChange);

async function processPayment() {
    const paidAmount = parseInt(document.getElementById('paid-amount').value) || 0;
    const paymentMethod = document.getElementById('payment-method').value;
    
    if (paymentMethod === 'cash' && paidAmount < currentTotal) {
        alert('Jumlah bayar kurang dari total!');
        return;
    }
    
    if (paidAmount <= 0) {
        alert('Masukkan jumlah pembayaran!');
        return;
    }
    
    await POS.processPayment(paymentMethod, paidAmount);
    closePaymentModal();
}

// Update online status
window.addEventListener('online', () => {
    document.getElementById('online-status').innerHTML = '🟢 Online';
    document.getElementById('online-status').className = 'px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold';
});

window.addEventListener('offline', () => {
    document.getElementById('online-status').innerHTML = '🔴 Offline';
    document.getElementById('online-status').className = 'px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold';
});

// Search menu
document.getElementById('search-menu')?.addEventListener('input', (e) => {
    const search = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.menu-item-card');
    
    items.forEach(item => {
        const name = item.querySelector('h3').textContent.toLowerCase();
        if (name.includes(search)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Pribadi\LYNK\Template\web-kasir-makanan\resources\views/pos/index.blade.php ENDPATH**/ ?>