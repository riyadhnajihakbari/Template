<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\StoreOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function tickets()
    {
        $orders = Order::with(['user', 'event', 'ticket', 'paymentMethod'])->latest()->paginate(20);
        return view('admin.orders.tickets', compact('orders'));
    }

    public function store()
    {
        $orders = StoreOrder::with(['user', 'product', 'paymentMethod'])->latest()->paginate(20);
        return view('admin.orders.store', compact('orders'));
    }

    public function updateTicketStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled,expired'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status order tiket berhasil diupdate');
    }

    public function updateStoreStatus(Request $request, StoreOrder $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status order store berhasil diupdate');
    }

    // Halaman Scan QR Code
    public function scanPage()
    {
        return view('admin.scan.index');
    }

    // Verifikasi QR Code
    public function verifyTicket(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $order = Order::with(['user', 'event', 'ticket'])
            ->where('qr_code', $request->qr_code)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid! Tiket tidak ditemukan.',
            ]);
        }

        if ($order->status !== 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Tiket belum dibayar! Status: ' . ucfirst($order->status),
                'order' => $order
            ]);
        }

        // Cek apakah event sudah lewat
        if ($order->event->tanggal_selesai < now()) {
            return response()->json([
                'success' => false,
                'message' => 'Event sudah selesai!',
                'order' => $order
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tiket VALID! ✓',
            'order' => [
                'id' => $order->id,
                'user_name' => $order->user->name,
                'event_title' => $order->event->title,
                'event_date' => $order->event->tanggal_mulai->format('d M Y, H:i'),
                'ticket_category' => $order->ticket->kategori,
                'quantity' => $order->jumlah,
                'status' => $order->status,
            ]
        ]);
    }
}