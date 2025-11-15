@extends('layouts.admin')

@section('title', 'Order Store')
@section('header', 'Daftar Order Merchandise')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Order ID</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">User</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Qty</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Metode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
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
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($order->product->image)
                                    <img src="{{ Storage::url($order->product->image) }}" class="w-10 h-10 rounded object-cover mr-3">
                                @endif
                                <span class="text-sm">{{ Str::limit($order->product->name, 25) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $order->qty }}</td>
                        <td class="px-6 py-4 font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($order->paymentMethod)
                                <span class="font-medium">{{ $order->paymentMethod->name }}</span>
                                <div class="text-xs text-gray-500">{{ $order->paymentMethod->account_number }}</div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 
                                   ($order->status === 'shipped' ? 'bg-blue-100 text-blue-800' : 
                                   ($order->status === 'paid' ? 'bg-green-100 text-green-800' : 
                                   ($order->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800'))) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <!-- Update Status -->
                            <form method="POST" action="{{ route('admin.orders.store.status', $order) }}" class="flex items-center space-x-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="text-xs border border-gray-300 rounded px-2 py-1">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid ✓</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500">Belum ada order merchandise.</td>
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