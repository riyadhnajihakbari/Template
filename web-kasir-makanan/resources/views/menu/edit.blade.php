@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="p-6">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('menu.index') }}" class="text-pos-primary hover:text-orange-700 font-semibold inline-flex items-center gap-2 transition-colors">
                ← Kembali ke Daftar Menu
            </a>
        </div>

        <div class="card">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Menu: {{ $menuItem->name }}</h2>

            @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">⚠️</span>
                    </div>
                    <div class="ml-3">
                        <h3 class="font-semibold mb-2">Terdapat kesalahan:</h3>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form id="edit-form" action="{{ route('menu.update', $menuItem->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Menu -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Menu <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $menuItem->name) }}" 
                               class="input-field @error('name') border-red-500 @enderror" required>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" class="input-field @error('category_id') border-red-500 @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ old('category_id', $menuItem->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="price" value="{{ old('price', $menuItem->price) }}" 
                               class="input-field @error('price') border-red-500 @enderror" min="0" step="1000" required>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', $menuItem->stock) }}" 
                               class="input-field @error('stock') border-red-500 @enderror" min="0" required>
                    </div>

                    <!-- Foto Saat Ini -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Foto Saat Ini
                        </label>
                        @if($menuItem->photo_url)
                        <img src="{{ asset($menuItem->photo_url) }}" 
                             alt="{{ $menuItem->name }}" 
                             class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300 shadow-sm"
                             onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center text-4xl\'>🍽️</div>';">
                        @else
                        <div class="w-32 h-32 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center text-4xl shadow-sm">
                            🍽️
                        </div>
                        @endif
                    </div>

                    <!-- Upload Foto Baru -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Ganti Foto (Opsional)
                        </label>
                        <input type="file" name="photo" accept="image/*" 
                               class="input-field @error('photo') border-red-500 @enderror" 
                               onchange="previewImage(event)">
                        <p class="text-xs text-gray-600 mt-1">Max 2MB (JPG, PNG)</p>
                        
                        <!-- Preview Foto Baru -->
                        <div id="photo-preview" class="hidden mt-2">
                            <p class="text-sm font-semibold text-gray-700 mb-1">Preview Foto Baru:</p>
                            <img id="preview-img" src="" alt="Preview" 
                                 class="w-32 h-32 object-cover rounded-lg border-2 border-blue-300 shadow-sm">
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="description" rows="4" 
                                  class="input-field @error('description') border-red-500 @enderror" 
                                  placeholder="Deskripsi menu (opsional)">{{ old('description', $menuItem->description) }}</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-8 pt-6 border-t-2 border-gray-200">
                    <button type="button" onclick="confirmDeleteMenu()" class="px-6 py-3 rounded-lg bg-red-100 text-red-600 font-bold hover:bg-red-200 transition-all">
                        🗑️ Hapus Menu
                    </button>

                    <div class="flex items-center space-x-4">
                        <a href="{{ route('menu.index') }}" class="btn-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn-primary">
                            💾 Update Menu
                        </button>
                    </div>
                </div>
            </form>

            <!-- Hidden delete form -->
            <form id="delete-form" action="{{ route('menu.destroy', $menuItem->id) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Preview image
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        // Check file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File Terlalu Besar',
                text: 'Ukuran file maksimal 2MB',
                confirmButtonText: 'OK'
            });
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('photo-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Confirm delete menu
function confirmDeleteMenu() {
    Swal.fire({
        title: 'Hapus Menu?',
        html: `Yakin ingin menghapus menu <strong>{{ $menuItem->name }}</strong>?<br><small class="text-gray-500">Tindakan ini tidak dapat dibatalkan</small>`,
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
            
            // Submit delete form
            document.getElementById('delete-form').submit();
        }
    });
}

// Show success/error messages
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000,
        toast: true,
        position: 'top-end',
        timerProgressBar: true
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        confirmButtonText: 'OK'
    });
@endif

// Form submit with loading
document.getElementById('edit-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Menyimpan...',
        html: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Submit form after showing loading
    setTimeout(() => {
        this.submit();
    }, 500);
});
</script>
@endpush
@endsection