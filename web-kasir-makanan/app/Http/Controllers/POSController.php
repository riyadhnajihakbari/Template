<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class POSController extends Controller
{
    public function index()
    {
        $categories = Category::active()->with(['menuItems' => function($query) {
            $query->active()->inStock();
        }])->get();

        return view('pos.index', compact('categories'));
    }

    public function getMenu()
    {
        $menuItems = MenuItem::active()->inStock()->with('category')->get();
        
        return response()->json($menuItems);
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'table_number' => 'nullable|string',
            'order_type' => 'required|in:dine_in,takeaway', // NEW: validation for order type
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric',
            'payment_method' => 'required|string',
            'paid_amount' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            // Calculate total
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $totalAmount += $item['qty'] * $item['unit_price'];
            }

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'table_number' => $request->table_number ?? ($request->order_type === 'takeaway' ? 'Takeaway' : null),
                'order_type' => $request->order_type, // NEW: save order type
                'status' => 'completed',
                'total_amount' => $totalAmount,
                'paid_amount' => $request->paid_amount,
                'payment_method' => $request->payment_method,
                'created_by' => Auth::id(),
            ]);

            // Create order items
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['menu_item_id'],
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['qty'] * $item['unit_price'],
                    'notes' => $item['notes'] ?? null,
                ]);

                // Update stock
                $menuItem = MenuItem::find($item['menu_item_id']);
                if ($menuItem->stock > 0) {
                    $menuItem->decrement('stock', $item['qty']);
                }
            }

            // Create transaction
            Transaction::create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'method' => $request->payment_method,
                'status' => 'success',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'message' => 'Pesanan berhasil dibuat',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function syncOfflineTransactions(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.order_number' => 'required|string',
            'order.items' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $orderData = $request->order;

            // Check if order already exists
            $existingOrder = Order::where('order_number', $orderData['order_number'])->first();
            if ($existingOrder) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order sudah ada',
                ]);
            }

            // Create order
            $order = Order::create([
                'order_number' => $orderData['order_number'],
                'table_number' => $orderData['table_number'] ?? 'Takeaway',
                'order_type' => $orderData['order_type'] ?? 'takeaway', // NEW: handle order_type in sync
                'status' => 'completed',
                'total_amount' => $orderData['total_amount'],
                'paid_amount' => $orderData['paid_amount'],
                'payment_method' => $orderData['payment_method'],
                'created_by' => Auth::id(),
                'created_at' => $orderData['created_at'],
            ]);

            // Create order items
            foreach ($orderData['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['menu_item_id'],
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            // Create transaction
            Transaction::create([
                'order_id' => $order->id,
                'amount' => $orderData['total_amount'],
                'method' => $orderData['payment_method'],
                'status' => 'success',
                'synced' => true,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi offline berhasil disinkronkan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal sinkronisasi: ' . $e->getMessage(),
            ], 500);
        }
    }
}