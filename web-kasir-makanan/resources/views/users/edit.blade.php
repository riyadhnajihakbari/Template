@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('users.index') }}" class="text-orange-600 hover:text-orange-700 font-semibold mb-4 inline-flex items-center gap-2">
            ← Kembali
        </a>
        <h2 class="text-4xl font-bold bg-gradient-to-r from-orange-500 via-orange-600 to-red-500 bg-clip-text text-transparent mb-2">
            Edit User
        </h2>
        <p class="text-gray-600">Perbarui informasi pengguna</p>
    </div>

    <!-- Form -->
    <div class="modern-card p-8">
        <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $user->name) }}" 
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
                       value="{{ old('email', $user->email) }}" 
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
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>👑 Admin - Akses Penuh</option>
                    <option value="manajer" {{ old('role', $user->role) === 'manajer' ? 'selected' : '' }}>📊 Manajer - Kelola Menu & Laporan</option>
                    <option value="kasir" {{ old('role', $user->role) === 'kasir' ? 'selected' : '' }}>💰 Kasir - POS & Transaksi</option>
                    <option value="koki" {{ old('role', $user->role) === 'koki' ? 'selected' : '' }}>👨‍🍳 Koki - Dapur</option>
                </select>
                @error('role')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password (Optional) -->
            <div class="border-t-2 border-gray-200 pt-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Ubah Password (Opsional)</h3>
                <p class="text-sm text-gray-600 mb-4">Biarkan kosong jika tidak ingin mengubah password</p>
                
                <div class="space-y-4">
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all @error('password') border-red-500 @enderror"
                               placeholder="Minimal 8 karakter">
                        @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">
                            Konfirmasi Password Baru
                        </label>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all"
                               placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

            <!-- Current Info Box -->
            <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">👤</span>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-orange-800 mb-1">Informasi User:</h3>
                        <ul class="text-sm text-orange-700 space-y-1">
                            <li><strong>Bergabung:</strong> {{ $user->created_at->format('d F Y') }}</li>
                            <li><strong>Terakhir Update:</strong> {{ $user->updated_at->format('d F Y H:i') }}</li>
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
                    ✓ Update User
                </button>
            </div>
        </form>

        <!-- Delete Button -->
        @if($user->id !== auth()->id())
        <div class="mt-8 pt-8 border-t-2 border-gray-200">
            <h3 class="text-lg font-bold text-red-600 mb-4">Danger Zone</h3>
            <form method="POST" action="{{ route('users.destroy', $user) }}" 
                  onsubmit="return confirm('Yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan!')" 
                  class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-6 py-3 rounded-lg bg-red-100 text-red-600 font-bold hover:bg-red-200 transition-all">
                    🗑️ Hapus User
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection