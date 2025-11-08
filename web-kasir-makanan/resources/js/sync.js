import { db, getUnsyncedOrders } from './db';

export async function syncOfflineTransactions() {
    if (!navigator.onLine) {
        console.log('Offline - sync ditunda');
        return;
    }
    
    const unsyncedOrders = await getUnsyncedOrders();
    
    if (unsyncedOrders.length === 0) {
        console.log('Tidak ada transaksi yang perlu disinkronkan');
        return;
    }
    
    console.log(`Sinkronisasi ${unsyncedOrders.length} transaksi...`);
    
    for (const order of unsyncedOrders) {
        try {
            const response = await window.axios.post('/api/sync/offline-transactions', {
                order: order
            });
            
            if (response.data.success) {
                // Mark as synced
                await db.orders.update(order.id, { synced: true });
                console.log(`Order ${order.order_number} berhasil disinkronkan`);
            }
        } catch (error) {
            console.error(`Gagal sync order ${order.order_number}:`, error);
        }
    }
    
    console.log('Sinkronisasi selesai');
}

// Auto sync every 5 minutes if online
setInterval(() => {
    if (navigator.onLine) {
        syncOfflineTransactions();
    }
}, 5 * 60 * 1000);
