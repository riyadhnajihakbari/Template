import './bootstrap';
import { db } from './db';
import { syncOfflineTransactions } from './sync';

// PWA Registration
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js')
            .then(registration => {
                console.log('SW registered: ', registration);
            })
            .catch(registrationError => {
                console.log('SW registration failed: ', registrationError);
            });
    });
}

// Online/Offline Status - HANYA UPDATE CARD, TIDAK ADA BANNER
window.addEventListener('online', () => {
    // Update status di dashboard jika ada
    if (typeof updateSystemStatus === 'function') {
        updateSystemStatus();
    }
    
    // Update dot di sidebar
    const connectionDot = document.getElementById('connection-status');
    if (connectionDot) {
        connectionDot.className = 'w-2 h-2 bg-green-500 rounded-full animate-pulse';
    }
    
    // Sync offline transactions
    syncOfflineTransactions();
    
    // Show toast
    if (typeof Toast !== 'undefined') {
        Toast.success('Koneksi kembali online! Data akan disinkronkan.');
    }
});

window.addEventListener('offline', () => {
    // Update status di dashboard jika ada
    if (typeof updateSystemStatus === 'function') {
        updateSystemStatus();
    }
    
    // Update dot di sidebar
    const connectionDot = document.getElementById('connection-status');
    if (connectionDot) {
        connectionDot.className = 'w-2 h-2 bg-red-500 rounded-full animate-pulse';
    }
    
    // Show toast
    if (typeof Toast !== 'undefined') {
        Toast.warning('Koneksi terputus. Mode offline aktif.');
    }
});

// Check initial status
if (!navigator.onLine) {
    const connectionDot = document.getElementById('connection-status');
    if (connectionDot) {
        connectionDot.className = 'w-2 h-2 bg-red-500 rounded-full animate-pulse';
    }
}

// Format currency helper - Make it global
window.formatRupiah = function(amount) {
    const num = parseFloat(amount) || 0;
    return new Intl.NumberFormat('id-ID').format(num);
}

// Global POS Functions
window.POS = {
    currentOrderType: 'takeaway',
    lastOrderId: null, // Track last order for receipt preview
    
    setOrderType: function(type) {
        this.currentOrderType = type;
        
        const btnDineIn = document.getElementById('btn-dine-in');
        const btnTakeaway = document.getElementById('btn-takeaway');
        const tableLabel = document.getElementById('table-label');
        const tableInput = document.getElementById('table-number');
        
        if (type === 'dine_in') {
            btnDineIn.className = 'px-4 py-3 rounded-lg border-2 border-pos-primary bg-pos-primary bg-opacity-10 transition-all';
            btnTakeaway.className = 'px-4 py-3 rounded-lg border-2 border-gray-300 hover:border-pos-primary transition-all';
            tableLabel.textContent = 'Nomor Meja';
            tableInput.placeholder = 'Contoh: Meja 5';
            tableInput.value = '';
        } else {
            btnDineIn.className = 'px-4 py-3 rounded-lg border-2 border-gray-300 hover:border-pos-primary transition-all';
            btnTakeaway.className = 'px-4 py-3 rounded-lg border-2 border-pos-primary bg-pos-primary bg-opacity-10 transition-all';
            tableLabel.textContent = 'Nama Pelanggan';
            tableInput.placeholder = 'Nama pelanggan';
            tableInput.value = '';
        }
    },
    
    cart: {
        clear: async function() {
            if (confirm('Yakin ingin mengosongkan keranjang?')) {
                await db.cart.clear();
                window.POS.updateCartDisplay();
                Toast.info('Keranjang telah dikosongkan');
            }
        }
    },
    
    addToCart: async function(menuItem) {
        const cart = await db.cart.toArray();
        const existing = cart.find(item => item.menu_item_id === menuItem.id);
        
        if (existing) {
            await db.cart.update(existing.id, { 
                qty: existing.qty + 1,
                subtotal: (existing.qty + 1) * existing.unit_price
            });
        } else {
            await db.cart.add({
                menu_item_id: menuItem.id,
                name: menuItem.name,
                unit_price: parseFloat(menuItem.price),
                qty: 1,
                subtotal: parseFloat(menuItem.price),
                notes: ''
            });
        }
        
        this.updateCartDisplay();
    },
    
    removeFromCart: async function(cartItemId) {
        await db.cart.delete(cartItemId);
        this.updateCartDisplay();
    },
    
    updateCartQty: async function(cartItemId, qty) {
        if (qty <= 0) {
            await this.removeFromCart(cartItemId);
            return;
        }
        
        const item = await db.cart.get(cartItemId);
        await db.cart.update(cartItemId, {
            qty: qty,
            subtotal: qty * item.unit_price
        });
        
        this.updateCartDisplay();
    },
    
    updateCartDisplay: async function() {
        const cart = await db.cart.toArray();
        const cartContainer = document.getElementById('cart-items');
        const totalElement = document.getElementById('cart-total');
        
        if (!cartContainer) return;
        
        let total = 0;
        cartContainer.innerHTML = '';
        
        if (cart.length === 0) {
            cartContainer.innerHTML = '<div class="p-4 text-center text-gray-500">Keranjang kosong</div>';
        }
        
        cart.forEach(item => {
            total += parseFloat(item.subtotal) || 0;
            
            const itemElement = document.createElement('div');
            itemElement.className = 'flex justify-between items-center p-3 border-b hover:bg-gray-50 transition-colors';
            itemElement.innerHTML = `
                <div class="flex-1">
                    <div class="font-semibold text-gray-800">${item.name}</div>
                    <div class="text-sm text-gray-600">Rp ${window.formatRupiah(item.unit_price)}</div>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="POS.updateCartQty(${item.id}, ${item.qty - 1})" 
                            class="bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded transition-colors font-bold">-</button>
                    <span class="w-8 text-center font-semibold">${item.qty}</span>
                    <button onclick="POS.updateCartQty(${item.id}, ${item.qty + 1})" 
                            class="bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded transition-colors font-bold">+</button>
                    <button onclick="POS.removeFromCart(${item.id})" 
                            class="bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded ml-2 transition-colors font-bold">×</button>
                </div>
                <div class="ml-4 font-bold text-gray-800">Rp ${window.formatRupiah(item.subtotal)}</div>
            `;
            cartContainer.appendChild(itemElement);
        });
        
        if (totalElement) {
            totalElement.textContent = `Rp ${window.formatRupiah(total)}`;
        }
        
        const checkoutBtn = document.getElementById('checkout-btn');
        const checkoutQrisBtn = document.getElementById('checkout-qris-btn');
        
        if (checkoutBtn) {
            checkoutBtn.disabled = cart.length === 0;
            checkoutBtn.className = cart.length === 0 
                ? 'btn-success w-full opacity-50 cursor-not-allowed' 
                : 'btn-success w-full';
        }
        if (checkoutQrisBtn) {
            checkoutQrisBtn.disabled = cart.length === 0;
            checkoutQrisBtn.className = cart.length === 0 
                ? 'btn-primary w-full opacity-50 cursor-not-allowed' 
                : 'btn-primary w-full';
        }
    },
    
    processPayment: async function(paymentMethod = 'cash', paidAmount = 0) {
        const cart = await db.cart.toArray();
        
        if (cart.length === 0) {
            Toast.error('Keranjang kosong!');
            return;
        }
        
        const total = cart.reduce((sum, item) => sum + (parseFloat(item.subtotal) || 0), 0);
        
        if (paymentMethod === 'cash' && paidAmount < total) {
            Toast.error('Jumlah bayar kurang!');
            return;
        }
        
        const tableNumber = document.getElementById('table-number')?.value || 
                           (this.currentOrderType === 'takeaway' ? 'Takeaway' : 'Meja');
        
        const order = {
            order_number: 'ORD-' + Date.now(),
            table_number: tableNumber,
            order_type: this.currentOrderType,
            items: cart,
            total_amount: total,
            paid_amount: paidAmount,
            change_amount: paidAmount - total,
            payment_method: paymentMethod,
            status: 'completed',
            synced: false,
            created_at: new Date().toISOString()
        };
        
        const orderId = await db.orders.add(order);
        this.lastOrderId = orderId;
        
        await db.cart.clear();
        this.updateCartDisplay();
        
        // Show receipt preview
        this.showReceiptPreview(orderId);
        
        // Try to sync if online
        if (navigator.onLine) {
            syncOfflineTransactions();
        }
        
        Toast.success('Pembayaran berhasil!');
        
        return orderId;
    },
    
    // NEW: Show receipt preview in page
    showReceiptPreview: async function(orderId) {
        const order = await db.orders.get(orderId);
        const previewContainer = document.getElementById('receipt-preview');
        
        if (!previewContainer) return;
        
        const orderTypeLabel = order.order_type === 'dine_in' ? 'Dine In' : 'Take Away';
        const orderTypeIcon = order.order_type === 'dine_in' ? '🍽️' : '🥡';
        
        const receiptHTML = `
            <div class="bg-white rounded-xl p-6 shadow-lg border-2 border-orange-200">
                <div class="text-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Preview Struk</h3>
                    <div class="inline-block bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-2 rounded-lg font-bold">
                        ${orderTypeIcon} ${orderTypeLabel}
                    </div>
                </div>
                
                <div class="border-t-2 border-dashed border-gray-300 my-4"></div>
                
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">No. Order:</span>
                        <span class="font-mono font-bold">${order.order_number}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">${order.order_type === 'dine_in' ? 'Meja' : 'Nama'}:</span>
                        <span class="font-semibold">${order.table_number}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Waktu:</span>
                        <span class="font-semibold">${new Date(order.created_at).toLocaleString('id-ID')}</span>
                    </div>
                </div>
                
                <div class="border-t-2 border-dashed border-gray-300 my-4"></div>
                
                <div class="space-y-3 mb-4">
                    ${order.items.map(item => `
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800">${item.name}</div>
                                <div class="text-sm text-gray-600">
                                    ${item.qty} x Rp ${window.formatRupiah(item.unit_price)}
                                </div>
                            </div>
                            <div class="font-bold text-gray-800">
                                Rp ${window.formatRupiah(item.subtotal)}
                            </div>
                        </div>
                    `).join('')}
                </div>
                
                <div class="border-t-2 border-dashed border-gray-300 my-4"></div>
                
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-lg font-bold">
                        <span>TOTAL:</span>
                        <span class="text-orange-600">Rp ${window.formatRupiah(order.total_amount)}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Bayar (${order.payment_method}):</span>
                        <span class="font-semibold">Rp ${window.formatRupiah(order.paid_amount)}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Kembalian:</span>
                        <span class="font-semibold text-green-600">Rp ${window.formatRupiah(order.change_amount)}</span>
                    </div>
                </div>
                
                <div class="border-t-2 border-dashed border-gray-300 my-4"></div>
                
                <div class="text-center space-y-2">
                    <p class="text-sm text-gray-600">Terima Kasih</p>
                    <p class="font-semibold text-gray-800">
                        ${order.order_type === 'dine_in' ? 'Selamat Makan! 😊' : 'Selamat Menikmati! 😊'}
                    </p>
                </div>
                
                <div class="mt-6 flex gap-2">
                    <button onclick="POS.printReceipt(${orderId})" class="btn-primary flex-1">
                        🖨️ Print Struk
                    </button>
                    <button onclick="POS.hideReceiptPreview()" class="btn-secondary flex-1">
                        ✓ Selesai
                    </button>
                </div>
            </div>
        `;
        
        previewContainer.innerHTML = receiptHTML;
        previewContainer.classList.remove('hidden');
        previewContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    },
    
    hideReceiptPreview: function() {
        const previewContainer = document.getElementById('receipt-preview');
        if (previewContainer) {
            previewContainer.classList.add('hidden');
            previewContainer.innerHTML = '';
        }
    },
    
    // Print receipt - RAPI
    printReceipt: async function(orderId) {
        const order = await db.orders.get(orderId);
        
        const orderTypeLabel = order.order_type === 'dine_in' ? 'Dine In' : 'Take Away';
        const orderTypeIcon = order.order_type === 'dine_in' ? '🍽️' : '🥡';
        
        const receiptWindow = window.open('', '_blank');
        receiptWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Struk #${order.order_number}</title>
                <style>
                    @page {
                        size: 80mm auto;
                        margin: 0;
                    }
                    
                    * {
                        margin: 0;
                        padding: 0;
                        box-sizing: border-box;
                    }
                    
                    body {
                        font-family: 'Courier New', monospace;
                        width: 80mm;
                        padding: 10mm;
                        font-size: 11pt;
                        line-height: 1.4;
                    }
                    
                    .header {
                        text-align: center;
                        margin-bottom: 10px;
                        padding-bottom: 10px;
                    }
                    
                    .header .shop-name {
                        font-size: 16pt;
                        font-weight: bold;
                        margin-bottom: 5px;
                    }
                    
                    .header .shop-info {
                        font-size: 9pt;
                        line-height: 1.3;
                    }
                    
                    .divider {
                        border-top: 1px dashed #000;
                        margin: 10px 0;
                    }
                    
                    .divider-solid {
                        border-top: 2px solid #000;
                        margin: 10px 0;
                    }
                    
                    .order-type {
                        text-align: center;
                        font-size: 14pt;
                        font-weight: bold;
                        padding: 8px;
                        background: #f0f0f0;
                        border-radius: 5px;
                        margin: 10px 0;
                    }
                    
                    .info-row {
                        display: flex;
                        justify-content: space-between;
                        margin: 3px 0;
                        font-size: 10pt;
                    }
                    
                    .info-label {
                        font-weight: normal;
                    }
                    
                    .info-value {
                        font-weight: bold;
                        text-align: right;
                    }
                    
                    .items {
                        margin: 10px 0;
                    }
                    
                    .item {
                        margin: 8px 0;
                    }
                    
                    .item-name {
                        font-weight: bold;
                        margin-bottom: 2px;
                    }
                    
                    .item-detail {
                        display: flex;
                        justify-content: space-between;
                        font-size: 10pt;
                    }
                    
                    .total-section {
                        margin-top: 10px;
                    }
                    
                    .total-row {
                        display: flex;
                        justify-content: space-between;
                        margin: 5px 0;
                        font-size: 11pt;
                    }
                    
                    .total-row.main {
                        font-size: 13pt;
                        font-weight: bold;
                        padding-top: 5px;
                    }
                    
                    .footer {
                        text-align: center;
                        margin-top: 15px;
                        font-size: 10pt;
                    }
                    
                    .footer-message {
                        margin: 5px 0;
                    }
                    
                    @media print {
                        body {
                            padding: 5mm;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <div class="shop-name">RUMAH MAKAN SEDERHANA</div>
                    <div class="shop-info">
                        Jl. Contoh No. 123<br>
                        Telp: 0812-3456-7890
                    </div>
                </div>
                
                <div class="divider-solid"></div>
                
                <div class="order-type">
                    ${orderTypeIcon} ${orderTypeLabel}
                </div>
                
                <div class="divider"></div>
                
                <div class="info-row">
                    <span class="info-label">No. Order</span>
                    <span class="info-value">${order.order_number}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">${order.order_type === 'dine_in' ? 'Meja' : 'Nama'}</span>
                    <span class="info-value">${order.table_number}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal</span>
                    <span class="info-value">${new Date(order.created_at).toLocaleString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    })}</span>
                </div>
                
                <div class="divider"></div>
                
                <div class="items">
                    ${order.items.map(item => `
                        <div class="item">
                            <div class="item-name">${item.name}</div>
                            <div class="item-detail">
                                <span>${item.qty} x Rp ${new Intl.NumberFormat('id-ID').format(item.unit_price)}</span>
                                <span>Rp ${new Intl.NumberFormat('id-ID').format(item.subtotal)}</span>
                            </div>
                        </div>
                    `).join('')}
                </div>
                
                <div class="divider-solid"></div>
                
                <div class="total-section">
                    <div class="total-row main">
                        <span>TOTAL</span>
                        <span>Rp ${new Intl.NumberFormat('id-ID').format(order.total_amount)}</span>
                    </div>
                    <div class="total-row">
                        <span>Bayar (${order.payment_method})</span>
                        <span>Rp ${new Intl.NumberFormat('id-ID').format(order.paid_amount)}</span>
                    </div>
                    <div class="total-row">
                        <span>Kembalian</span>
                        <span>Rp ${new Intl.NumberFormat('id-ID').format(order.change_amount)}</span>
                    </div>
                </div>
                
                <div class="divider"></div>
                
                <div class="footer">
                    <div class="footer-message">Terima Kasih</div>
                    <div class="footer-message" style="font-weight: bold;">
                        ${order.order_type === 'dine_in' ? 'Selamat Makan! 😊' : 'Selamat Menikmati! 😊'}
                    </div>
                </div>
            </body>
            </html>
        `);
        
        receiptWindow.document.close();
        
        setTimeout(() => {
            receiptWindow.print();
            receiptWindow.close();
        }, 500);
    }
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    if (typeof POS !== 'undefined') {
        POS.updateCartDisplay();
        POS.setOrderType('takeaway');
    }
});