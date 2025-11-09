@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('users.index') }}" class="text-orange-600 hover:text-orange-700 font-semibold mb-4 inline-flex items-center gap-2">
            ← Kembali
        </a>
        <h2 class="text-4xl font-bold bg-gradient-to-r from-orange-500 via-orange-600 to-red-500 bg-clip-text text-transparent mb-2">
            Tambah User Baru
        </h2>
        <p class="text-gray-600">Buat akun pengguna baru untuk sistem</p>
    </div>

    <!-- Form -->
    <div class="modern-card p-8">
        <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name') }}" 
                       required
                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all @error('name') border-red-500 @enderror"
                       placeholder="Masukkan nama lengkap">
                @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       value="{{ old('email') }}" 
                       required
                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all @error('email') border-red-500 @enderror"
                       placeholder="email@example.com">
                @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-bold text-gray-700 mb-2">
                    Role / Jabatan <span class="text-red-500">*</span>
                </label>
                <select name="role" 
                        id="role" 
                        required
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all @error('role') border-red-500 @enderror">
                    <option value="">Pilih Role</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>👑 Admin - Akses Penuh</option>
                    <option value="manajer" {{ old('role') === 'manajer' ? 'selected' : '' }}>📊 Manajer - Kelola Menu & Laporan</option>
                    <option value="kasir" {{ old('role') === 'kasir' ? 'selected' : '' }}>💰 Kasir - POS & Transaksi</option>
                    <option value="koki" {{ old('role') === 'koki' ? 'selected' : '' }}>👨‍🍳 Koki - Dapur</option>
                </select>
                @error('role')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       required
                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all @error('password') border-red-500 @enderror"
                       placeholder="Minimal 8 karakter">
                @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">
                    Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       name="password_confirmation" 
                       id="password_confirmation" 
                       required
                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all"
                       placeholder="Ulangi password">
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">ℹ️</span>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-blue-800 mb-1">Informasi Role:</h3>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li><strong>Admin:</strong> Akses penuh ke semua fitur</li>
                            <li><strong>Manajer:</strong> Kelola menu, laporan, dan user</li>
                            <li><strong>Kasir:</strong> Akses POS dan transaksi</li>
                            <li><strong>Koki:</strong> Lihat pesanan dapur</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4">
                <a href="{{ route('users.index') }}" 
                   class="flex-1 py-3 rounded-lg bg-gray-200 text-gray-700 font-bold text-center hover:bg-gray-300 transition-all">
                    Batal
                </a>
                <button type="submit" 
                        class="flex-1 py-3 rounded-lg bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold shadow-md hover:shadow-lg transition-all">
                    ✓ Simpan User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection