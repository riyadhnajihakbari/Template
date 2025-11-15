@extends('layouts.admin')

@section('title', 'Manage Payment Methods')
@section('header', 'Manage Payment Methods')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-600">Total {{ $methods->total() }} metode pembayaran</p>
    <a href="{{ route('admin.payment-methods.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
        + Tambah Metode
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tipe</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No. Rekening</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Atas Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($methods as $method)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-semibold">{{ $method->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $method->type === 'bank' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $method->type === 'bank' ? 'Bank Transfer' : 'E-Wallet' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-mono">{{ $method->account_number }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $method->account_name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $method->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                {{ $method->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.payment-methods.edit', $method) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.payment-methods.destroy', $method) }}" class="inline" onsubmit="return confirm('Yakin hapus metode ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada metode pembayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $methods->links() }}
</div>
@endsection