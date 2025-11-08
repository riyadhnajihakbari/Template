import Dexie from 'dexie';

// Initialize IndexedDB
export const db = new Dexie('WebKasirDB');

db.version(1).stores({
    menu: '++id, name, category, price, stock, is_active',
    cart: '++id, menu_item_id, qty, unit_price, subtotal',
    orders: '++id, order_number, synced, created_at',
    transactions: '++id, order_id, synced, created_at'
});

// Cache menu items
export async function cacheMenuItems(items) {
    await db.menu.clear();
    await db.menu.bulkAdd(items);
}

// Get cached menu items
export async function getCachedMenu() {
    return await db.menu.where('is_active').equals(1).toArray();
}

// Get unsynced orders
export async function getUnsyncedOrders() {
    return await db.orders.where('synced').equals(false).toArray();
}
