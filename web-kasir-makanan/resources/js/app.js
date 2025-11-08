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

// Online/Offline Status
window.addEventListener('online', () => {
    document.getElementById('offline-indicator')?.classList.add('hidden');
    syncOfflineTransactions();
});

window.addEventListener('offline', () => {
    const indicator = document.getElementById('offline-indicator');
    if (indicator) {
        indicator.classList.remove('hidden');
    }
});

// Check initial status
if (!navigator.onLine) {
    document.getElementById('offline-indicator')?.classList.remove('hidden');
}

// Format currency helper - Make it global
window.formatRupiah = function(amount) {
    const num = parseFloat(amount) || 0;
    return new Intl.NumberFormat('id-ID').format(num);
}

// Global POS Functions
window.POS = {
    currentOrderType: 'takeaway', // Default order type
    
    // NEW: Set order type
    setOrderType: function(type) {
        this.currentOrderType = type;
        
        // Update button styles
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
            }
        }
    },
    
    // Add item to cart
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
    
    // Remove item from cart
    removeFromCart: async function(cartItemId) {
        await db.cart.delete(cartItemId);
        this.updateCartDisplay();
    },
    
    // Update cart quantity
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
    
    // Update cart display
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
            itemElement.className = 'flex justify-between items-center p-3 border-b';
            itemElement.innerHTML = `
                <div class="flex-1">
                    <div class="font-semibold">${item.name}</div>
                    <div class="text-sm text-gray-600">Rp ${window.formatRupiah(item.unit_price)}</div>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="POS.updateCartQty(${item.id}, ${item.qty - 1})" 
                            class="bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded">-</button>
                    <span class="w-8 text-center">${item.qty}</span>
                    <button onclick="POS.updateCartQty(${item.id}, ${item.qty + 1})" 
                            class="bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded">+</button>
                    <button onclick="POS.removeFromCart(${item.id})" 
                            class="bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded ml-2">×</button>
                </div>
                <div class="ml-4 font-semibold">Rp ${window.formatRupiah(item.subtotal)}</div>
            `;
            cartContainer.appendChild(itemElement);
        });
        
        if (totalElement) {
            totalElement.textContent = `Rp ${window.formatRupiah(total)}`;
        }
        
        // Update button state
        const checkoutBtn = document.getElementById('checkout-btn');
        const checkoutQrisBtn = document.getElementById('checkout-qris-btn');
        
        if (checkoutBtn) {
            checkoutBtn.disabled = cart.length === 0;
        }
        if (checkoutQrisBtn) {
            checkoutQrisBtn.disabled = cart.length === 0;
        }
    },
    
    // Process payment
    processPayment: async function(paymentMethod = 'cash', paidAmount = 0) {
        const cart = await db.cart.toArray();
        
        if (cart.length === 0) {
            alert('Keranjang kosong!');
            return;
        }
        
        const total = cart.reduce((sum, item) => sum + (parseFloat(item.subtotal) || 0), 0);
        
        if (paymentMethod === 'cash' && paidAmount < total) {
            alert('Jumlah bayar kurang!');
            return;
        }
        
        const tableNumber = document.getElementById('table-number')?.value || 
                           (this.currentOrderType === 'takeaway' ? 'Takeaway' : 'Meja');
        
        const order = {
            order_number: 'ORD-' + Date.now(),
            table_number: tableNumber,
            order_type: this.currentOrderType, // NEW: Save order type
            items: cart,
            total_amount: total,
            paid_amount: paidAmount,
            payment_method: paymentMethod,
            status: 'completed',
            synced: false,
            created_at: new Date().toISOString()
        };
        
        // Save to IndexedDB
        const orderId = await db.orders.add(order);
        
        // Clear cart
        await db.cart.clear();
        this.updateCartDisplay();
        
        // Print receipt
        this.printReceipt(orderId);
        
        // Try to sync if online
        if (navigator.onLine) {
            syncOfflineTransactions();
        }
        
        alert('Pembayaran berhasil!');
        
        return orderId;
    },
    
    // Print receipt - UPDATED with order type
    printReceipt: async function(orderId) {
        const order = await db.orders.get(orderId);
        
        // Get order type label
        const orderTypeLabel = order.order_type === 'dine_in' ? 'Dine In' : 'Take Away';
        const orderTypeIcon = order.order_type === 'dine_in' ? '🍽️' : '🥡';
        
        const receiptWindow = window.open('', '_blank', 'fullscreen=yes,scrollbars=yes');
        receiptWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Struk #${order.order_number}</title>
                <style>
                    body {
                        font-family: 'Courier New', monospace;
                        width: 58mm;
                        margin: 0;
                        padding: 10px;
                        font-size: 12px;
                    }
                    .header { text-align: center; margin-bottom: 10px; }
                    .divider { border-top: 1px dashed #000; margin: 10px 0; }
                    table { width: 100%; }
                    .right { text-align: right; }
                    .bold { font-weight: bold; }
                    .order-type { 
                        text-align: center; 
                        font-size: 14px; 
                        font-weight: bold; 
                        margin: 10px 0;
                        padding: 5px;
                        background: #f0f0f0;
                        border-radius: 5px;
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <div class="bold" style="font-size: 14px;">RUMAH MAKAN SEDERHANA</div>
                    <div>Jl. Contoh No. 123</div>
                    <div>Telp: 0812-3456-7890</div>
                </div>
                <div class="divider"></div>
                
                <!-- NEW: Order Type Display -->
                <div class="order-type">
                    ${orderTypeIcon} ${orderTypeLabel}
                </div>
                
                <div>
                    <div>No: ${order.order_number}</div>
                    <div>${order.order_type === 'dine_in' ? 'Meja' : 'Nama'}: ${order.table_number}</div>
                    <div>Tanggal: ${new Date(order.created_at).toLocaleString('id-ID')}</div>
                </div>
                <div class="divider"></div>
                <table>
                    ${order.items.map(item => `
                        <tr>
                            <td colspan="2">${item.name}</td>
                        </tr>
                        <tr>
                            <td>${item.qty} x ${new Intl.NumberFormat('id-ID').format(item.unit_price)}</td>
                            <td class="right">${new Intl.NumberFormat('id-ID').format(item.subtotal)}</td>
                        </tr>
                    `).join('')}
                </table>
                <div class="divider"></div>
                <table>
                    <tr>
                        <td class="bold">TOTAL</td>
                        <td class="right bold">Rp ${new Intl.NumberFormat('id-ID').format(order.total_amount)}</td>
                    </tr>
                    <tr>
                        <td>Bayar (${order.payment_method})</td>
                        <td class="right">Rp ${new Intl.NumberFormat('id-ID').format(order.paid_amount)}</td>
                    </tr>
                    <tr>
                        <td>Kembalian</td>
                        <td class="right">Rp ${new Intl.NumberFormat('id-ID').format(order.paid_amount - order.total_amount)}</td>
                    </tr>
                </table>
                <div class="divider"></div>
                <div class="header">
                    <div>Terima Kasih</div>
                    <div>${order.order_type === 'dine_in' ? 'Selamat Makan!' : 'Selamat Menikmati!'}</div>
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
        // Set default order type to takeaway
        POS.setOrderType('takeaway');
    }
});