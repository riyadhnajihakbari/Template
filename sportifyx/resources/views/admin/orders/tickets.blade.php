@extends('layouts.admin')

@section('title', 'Order Tiket')
@section('header', 'Daftar Order Tiket')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">User</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Event</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tiket</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Jml</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Metode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 {{ $order->status === 'pending' ? 'bg-amber-50' : '' }}">
                        <td class="px-6 py-4 font-mono text-sm">#{{ $order->id }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $order->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ Str::limit($order->event->title, 25) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                {{ $order->ticket->kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $order->jumlah }}</td>
                        <td class="px-6 py-4 font-semibold text-sm">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($order->paymentMethod)
                                <span class="font-medium">{{ $order->paymentMethod->name }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $order->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 
                                   ($order->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.orders.ticket.status', $order) }}" class="flex items-center space-x-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="text-xs border border-gray-300 rounded px-2 py-1">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid ✓</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="expired" {{ $order->status === 'expired' ? 'selected' : '' }}>Expired</option>
                                </select>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500">Belum ada order tiket.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $orders->links() }}
</div>
@endsection