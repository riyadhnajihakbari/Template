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

            <!-- Current Role Badge -->
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-200 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Role Saat Ini:</p>
                        <p class="text-xl font-bold text-purple-700">
                            @switch($user->role)
                                @case('admin')
                                    👑 Admin
                                    @break
                                @case('manajer')
                                    📊 Manajer
                                    @break
                                @case('kasir')
                                    💰 Kasir
                                    @break
                                @case('koki')
                                    👨‍🍳 Koki
                                    @break
                                @case('pelanggan')
                                    👤 Pelanggan
                                    @break
                                @default
                                    {{ ucfirst($user->role) }}
                            @endswitch
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Status:</p>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                            ✓ Aktif
                        </span>
                    </div>
                </div>
            </div>

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
                    <option value="pelanggan" {{ old('role', $user->role) === 'pelanggan' ? 'selected' : '' }}>👤 Pelanggan - Lihat Menu & Harga</option>
                </select>
                @error('role')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                @if($user->role !== 'pelanggan' && old('role', $user->role) !== 'pelanggan')
                <p class="mt-2 text-sm text-amber-600 flex items-start gap-2">
                    <span>⚠️</span>
                    <span>Mengubah ke role "Pelanggan" akan membatasi akses user hanya untuk melihat menu</span>
                </p>
                @endif
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
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-semibold text-orange-800 mb-2">Informasi User:</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-orange-700">
                            <div>
                                <strong>Bergabung:</strong> {{ $user->created_at->format('d F Y') }}
                            </div>
                            <div>
                                <strong>Update Terakhir:</strong> {{ $user->updated_at->format('d F Y H:i') }}
                            </div>
                            @if($user->email_verified_at)
                            <div class="col-span-2">
                                <strong>Email Terverifikasi:</strong> 
                                <span class="inline-flex items-center gap-1">
                                    <span class="text-green-600">✓</span> Ya
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role Access Info -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">ℹ️</span>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-blue-800 mb-2">Akses Berdasarkan Role:</h3>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li><strong>👑 Admin:</strong> Dashboard, POS, Menu, Laporan, User Management</li>
                            <li><strong>📊 Manajer:</strong> Dashboard, POS, Menu, Laporan</li>
                            <li><strong>💰 Kasir:</strong> Dashboard, POS</li>
                            <li><strong>👨‍🍳 Koki:</strong> Dashboard, POS (view only)</li>
                            <li><strong>👤 Pelanggan:</strong> Menu & Harga (read only)</li>
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
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">⚠️</span>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-red-800 mb-1">Danger Zone</h3>
                        <p class="text-sm text-red-700">
                            Menghapus user akan menghapus semua data terkait. Tindakan ini tidak dapat dibatalkan!
                        </p>
                    </div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('users.destroy', $user) }}" 
                  onsubmit="return confirm('⚠️ PERINGATAN!\n\nYakin ingin menghapus user {{ $user->name }}?\n\nSemua data transaksi dan aktivitas user ini akan hilang.\n\nTindakan ini TIDAK DAPAT dibatalkan!')" 
                  class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-6 py-3 rounded-lg bg-red-600 text-white font-bold hover:bg-red-700 transition-all shadow-md hover:shadow-lg">
                    🗑️ Hapus User Permanen
                </button>
            </form>
        </div>
        @else
        <div class="mt-8 pt-8 border-t-2 border-gray-200">
            <div class="bg-gray-50 border-l-4 border-gray-400 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">🔒</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700">
                            Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif untuk keamanan sistem.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Warning when changing to pelanggan role
document.getElementById('role')?.addEventListener('change', function() {
    const currentRole = '{{ $user->role }}';
    const newRole = this.value;
    
    if (currentRole !== 'pelanggan' && newRole === 'pelanggan') {
        if (!confirm('⚠️ Perhatian!\n\nMengubah role ke "Pelanggan" akan:\n- Menghapus akses ke Dashboard\n- Menghapus akses ke POS\n- Hanya bisa melihat menu dan harga\n\nLanjutkan?')) {
            this.value = currentRole;
        }
    }
});
</script>
@endpush
@endsection