<?php

namespace App\Http\Controllers;

use App\Models\StoreProduct;
use App\Models\StoreOrder;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Tambahkan ini

class StoreController extends Controller
{
    use AuthorizesRequests; // Tambahkan ini

    public function index()
    {
        $products = StoreProduct::paginate(12);
        return view('store.index', compact('products'));
    }

    public function show(StoreProduct $product)
    {
        return view('store.show', compact('product'));
    }

    public function checkout(StoreProduct $product)
    {
        return view('store.checkout', compact('product'));
    }

    public function payment(Request $request, StoreProduct $product)
    {
        $request->validate([
            'qty' => 'required|integer|min:1|max:' . $product->stock,
        ]);

        $qty = $request->qty;
        $totalPrice = $product->final_price * $qty;
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('store.payment', compact('product', 'qty', 'totalPrice', 'paymentMethods'));
    }

    public function processOrder(Request $request, StoreProduct $product)
    {
        $request->validate([
            'qty' => 'required|integer|min:1|max:' . $product->stock,
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $totalPrice = $product->final_price * $request->qty;

        $order = StoreOrder::create([
            'user_id' => auth()->id(),
            'store_product_id' => $product->id,
            'qty' => $request->qty,
            'total_price' => $totalPrice,
            'payment_method_id' => $request->payment_method_id,
            'status' => 'pending',
        ]);

        $product->decrement('stock', $request->qty);

        return redirect()->route('store.order.detail', $order)
            ->with('success', 'Pesanan berhasil dibuat! Silakan transfer sesuai instruksi.');
    }

    public function orderDetail(StoreOrder $order)
    {
        $this->authorize('view', $order);
        $order->load(['product', 'paymentMethod']);
        return view('store.order-detail', compact('order'));
    }

    public function history()
    {
        $orders = auth()->user()->storeOrders()
            ->with(['product', 'paymentMethod'])
            ->latest()
            ->paginate(10);

        return view('store.history', compact('orders'));
    }
}