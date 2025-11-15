<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;

    // Step 1: Checkout - Pilih jumlah tiket
    public function checkout(Event $event, Ticket $ticket)
    {
        if ($ticket->availableQuota() <= 0) {
            return back()->with('error', 'Tiket sudah habis');
        }

        return view('orders.checkout', compact('event', 'ticket'));
    }

    // Step 2: Payment - Pilih metode pembayaran
    public function payment(Request $request, Event $event, Ticket $ticket)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1|max:' . $ticket->availableQuota(),
        ]);

        $jumlah = $request->jumlah;
        $totalHarga = $ticket->harga * $jumlah;
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('orders.payment', compact('event', 'ticket', 'jumlah', 'totalHarga', 'paymentMethods'));
    }

    // Step 3: Process - Buat order dengan status PENDING
    public function processOrder(Request $request, Event $event, Ticket $ticket)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1|max:' . $ticket->availableQuota(),
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $totalHarga = $ticket->harga * $request->jumlah;

        $order = Order::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'ticket_id' => $ticket->id,
            'jumlah' => $request->jumlah,
            'total_harga' => $totalHarga,
            'payment_method_id' => $request->payment_method_id,
            'qr_code' => Str::uuid(),
            'status' => 'pending', // Status PENDING
        ]);

        // Update sold count
        $ticket->increment('sold', $request->jumlah);

        return redirect()->route('tickets.order.detail', $order)
            ->with('success', 'Pesanan tiket berhasil! Silakan transfer sesuai instruksi.');
    }

    // Detail order dengan instruksi pembayaran
    public function orderDetail(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['event', 'ticket', 'paymentMethod']);
        return view('orders.order-detail', compact('order'));
    }

    public function myTickets()
    {
        $orders = auth()->user()->orders()
            ->with(['event', 'ticket', 'paymentMethod'])
            ->latest()
            ->paginate(10);

        return view('orders.my-tickets', compact('orders'));
    }
}