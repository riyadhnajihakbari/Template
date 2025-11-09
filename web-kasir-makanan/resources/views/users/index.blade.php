@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-orange-500 via-orange-600 to-red-500 bg-clip-text text-transparent mb-2">
                Kelola User
            </h2>
            <p class="text-gray-600">Manajemen pengguna sistem</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn-primary">
            ➕ Tambah User
        </a>
    </div>

    <!-- Users Table -->
    <div class="modern-card p-6">
        <div class="overflow-x-auto">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th class="text-left rounded-tl-lg">Nama</th>
                        <th class="text-left">Email</th>
                        <th class="text-left">Role</th>
                        <th class="text-left">Bergabung</th>
                        <th class="text-center rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="font-semibold text-gray-800">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                    <span class="text-xs bg-orange-100 text-orange-600 px-2 py-1 rounded-full ml-1">
                                        Anda
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-sm text-gray-600">{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                            <span class="status-badge" style="background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%); color: #991b1b; border: 1px solid #f87171;">
                                <span class="text-base">👑</span>
                                Admin
                            </span>
                            @elseif($user->role === 'manajer')
                            <span class="status-badge" style="background: linear-gradient(135deg, #c7d2fe 0%, #a5b4fc 100%); color: #3730a3; border: 1px solid #818cf8;">
                                <span class="text-base">📊</span>
                                Manajer
                            </span>
                            @elseif($user->role === 'kasir')
                            <span class="status-badge status-process">
                                <span class="text-base">💰</span>
                                Kasir
                            </span>
                            @else
                            <span class="status-badge status-new">
                                <span class="text-base">👨‍🍳</span>
                                Koki
                            </span>
                            @endif
                        </td>
                        <td class="text-sm text-gray-600">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('users.edit', $user) }}" 
                                   class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors font-semibold text-sm">
                                    ✏️ Edit
                                </a>
                                
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('users.destroy', $user) }}" 
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors font-semibold text-sm">
                                        🗑️ Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center text-4xl">
                                    👥
                                </div>
                                <p class="text-gray-500 font-medium">Belum ada user</p>
                                <a href="{{ route('users.create') }}" class="btn-primary text-sm">
                                    Tambah User Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
        <div class="modern-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total User</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $users->total() }}</h3>
                </div>
                <div class="text-4xl">👥</div>
            </div>
        </div>

        <div class="modern-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Admin</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\User::where('role', 'admin')->count() }}</h3>
                </div>
                <div class="text-4xl">👑</div>
            </div>
        </div>

        <div class="modern-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Manajer</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\User::where('role', 'manajer')->count() }}</h3>
                </div>
                <div class="text-4xl">📊</div>
            </div>
        </div>

        <div class="modern-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Kasir</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\User::where('role', 'kasir')->count() }}</h3>
                </div>
                <div class="text-4xl">💰</div>
            </div>
        </div>
    </div>
</div>
@endsection