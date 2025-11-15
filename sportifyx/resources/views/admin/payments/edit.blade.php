@extends('layouts.admin')

@section('title', 'Edit Metode Pembayaran')
@section('header', 'Edit Metode Pembayaran')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('admin.payment-methods.update', $paymentMethod) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Bank/E-Wallet</label>
                <input type="text" name="name" value="{{ old('name', $paymentMethod->name) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe</label>
                <select name="type" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="bank" {{ $paymentMethod->type == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="ewallet" {{ $paymentMethod->type == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Rekening / Nomor HP</label>
                <input type="text" name="account_number" value="{{ old('account_number', $paymentMethod->account_number) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 font-mono">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Atas Nama</label>
                <input type="text" name="account_name" value="{{ old('account_name', $paymentMethod->account_name) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ $paymentMethod->is_active ? 'checked' : '' }}
                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-3 text-sm font-medium text-gray-700">Aktif (Tampil di halaman pembayaran)</span>
                </label>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.payment-methods.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg font-medium hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                    Update Metode
                </button>
            </div>
        </form>
    </div>
</div>
@endsection