@extends('layouts.app')

@section('title', 'Kelola Menu')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Kelola Menu</h2>
        <a href="{{ route('menu.create') }}" class="btn-primary">
            ➕ Tambah Menu Baru
        </a>
    </div>

    <!-- Filter by Category -->
    <div class="card mb-6">
        <div class="flex items-center space-x-2 overflow-x-auto">
            <a href="{{ route('menu.index') }}" 
               class="px-4 py-2 rounded-lg {{ !request('category') ? 'bg-pos-primary text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }} whitespace-nowrap transition-all">
                Semua
            </a>
            @foreach($categories as $category)
            <a href="{{ route('menu.index', ['category' => $category->id]) }}" 
               class="px-4 py-2 rounded-lg {{ request('category') == $category->id ? 'bg-pos-primary text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }} whitespace-nowrap transition-all">
                {{ $category->name }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- Menu Table -->
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
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($menuItems as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            @if($item->photo_url)
                            <img src="{{ asset($item->photo_url) }}" 
                                 alt="{{ $item->name }}" 
                                 class="w-16 h-16 object-cover rounded-lg shadow-sm"
                                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-2xl\'>🍽️</div>';">
                            @else
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center text-2xl shadow-sm">
                                🍽️
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">{{ $item->name }}</div>
                            @if($item->description)
                            <div class="text-sm text-gray-600">{{ Str::limit($item->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                {{ $item->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($item->stock > 10)
                            <span class="text-green-600 font-semibold">{{ $item->stock }}</span>
                            @elseif($item->stock > 0)
                            <span class="text-orange-600 font-semibold">{{ $item->stock }}</span>
                            @else
                            <span class="text-red-600 font-semibold">Habis</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('menu.toggle-status', $item->id) }}" method="POST" class="toggle-status-form">
                                @csrf
                                <button type="submit" class="px-3 py-1 rounded-full text-sm font-semibold transition-all {{ $item->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                    {{ $item->is_active ? '✓ Aktif' : '✗ Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('menu.edit', $item->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                                    ✏️ Edit
                                </a>
                                <button onclick="confirmDelete('{{ $item->id }}', '{{ $item->name }}')" 
                                        class="text-red-600 hover:text-red-800 font-semibold transition-colors">
                                    🗑️ Hapus
                                </button>
                                <form id="delete-form-{{ $item->id }}" 
                                      action="{{ route('menu.destroy', $item->id) }}" 
                                      method="POST" 
                                      class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <div class="text-5xl mb-4">🍽️</div>
                            <div class="text-lg font-semibold">Belum ada menu</div>
                            <div class="text-sm mt-2">
                                <a href="{{ route('menu.create') }}" class="text-pos-primary hover:underline">
                                    Tambah menu pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($menuItems->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $menuItems->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

// Confirm delete with SweetAlert2
function confirmDelete(menuId, menuName) {
    Swal.fire({
        title: 'Hapus Menu?',
        html: `Yakin ingin menghapus menu <strong>${menuName}</strong>?<br><small class="text-gray-500">Tindakan ini tidak dapat dibatalkan</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '🗑️ Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Submit form
            document.getElementById('delete-form-' + menuId).submit();
        }
    });
}

// Handle toggle status with AJAX
document.querySelectorAll('.toggle-status-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const url = this.action;
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Status menu berhasil diubah',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true,
                    position: 'top-end'
                });
                
                // Reload page after 1 second
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message || 'Gagal mengubah status menu',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat mengubah status',
                confirmButtonText: 'OK'
            });
        });
    });
});
</script>
@endpush
@endsection