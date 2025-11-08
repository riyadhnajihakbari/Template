@extends('layouts.app')

@section('title', 'Laporan Stok')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Laporan Stok Barang</h2>
        <button onclick="window.print()" class="btn-primary no-print">
            🖨️ Cetak Laporan
        </button>
    </div>

    <!-- Alert Low Stock -->
    @if($lowStock > 0)
    <div class="bg-orange-100 border border-orange-400 text-orange-700 px-4 py-3 rounded mb-6 no-print">
        <strong>⚠️ Peringatan:</strong> Ada {{ $lowStock }} item dengan stok rendah (di bawah 10)
    </div>
    @endif

    <!-- Inventory Table -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Menu</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($menuItems as $item)
                    <tr class="hover:bg-gray-50 {{ $item->stock < 10 ? 'bg-orange-50' : '' }}">
                        <td class="px-6 py-4">
                            @if($item->photo_url)
                            <img src="{{ asset('storage/' . $item->photo_url) }}" 
                                 alt="{{ $item->name }}" 
                                 class="w-12 h-12 object-cover rounded-lg">
                            @else
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-xl">
                                🍽️
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            {{ $item->name }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                {{ $item->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($item->stock == 0)
                                <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                <span class="text-red-600 font-bold">{{ $item->stock }}</span>
                                @elseif($item->stock < 10)
                                <span class="w-3 h-3 bg-orange-500 rounded-full mr-2"></span>
                                <span class="text-orange-600 font-bold">{{ $item->stock }}</span>
                                @else
                                <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                <span class="text-green-600 font-bold">{{ $item->stock }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($item->stock == 0)
                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                Habis
                            </span>
                            @elseif($item->stock < 10)
                            <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-semibold">
                                Stok Rendah
                            </span>
                            @else
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                Tersedia
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 no-print">
                            <a href="{{ route('menu.edit', $item) }}" 
                               class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                Update Stok
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <div class="text-5xl mb-4">📦</div>
                            <div class="text-lg font-semibold">Belum ada data stok</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
        <div class="card bg-gradient-to-br from-gray-500 to-gray-600 text-white">
            <div class="text-gray-100 text-sm mb-1">Total Item</div>
            <div class="text-3xl font-bold">{{ $menuItems->count() }}</div>
        </div>

        <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white">
            <div class="text-green-100 text-sm mb-1">Stok Aman</div>
            <div class="text-3xl font-bold">{{ $menuItems->where('stock', '>=', 10)->count() }}</div>
        </div>

        <div class="card bg-gradient-to-br from-orange-500 to-orange-600 text-white">
            <div class="text-orange-100 text-sm mb-1">Stok Rendah</div>
            <div class="text-3xl font-bold">{{ $menuItems->where('stock', '>', 0)->where('stock', '<', 10)->count() }}</div>
        </div>

        <div class="card bg-gradient-to-br from-red-500 to-red-600 text-white">
            <div class="text-red-100 text-sm mb-1">Habis</div>
            <div class="text-3xl font-bold">{{ $menuItems->where('stock', 0)->count() }}</div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white;
    }
    
    .card {
        box-shadow: none !important;
        page-break-inside: avoid;
    }
}
</style>
@endsection