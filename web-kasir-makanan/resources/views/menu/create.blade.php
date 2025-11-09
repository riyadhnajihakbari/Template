@extends('layouts.app')

@section('title', 'Tambah Menu Baru')

@section('content')
<div class="p-6">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('menu.index') }}" class="text-pos-primary hover:text-orange-700 font-semibold inline-flex items-center gap-2 transition-colors">
                ← Kembali ke Daftar Menu
            </a>
        </div>

        <div class="card">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Menu Baru</h2>

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

            <form id="create-form" action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Menu -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Menu <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                               class="input-field @error('name') border-red-500 @enderror" 
                               placeholder="Contoh: Nasi Goreng Spesial" required>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" class="input-field @error('category_id') border-red-500 @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                        <input type="number" name="price" value="{{ old('price') }}" 
                               class="input-field @error('price') border-red-500 @enderror" 
                               placeholder="25000" min="0" step="1000" required>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', 50) }}" 
                               class="input-field @error('stock') border-red-500 @enderror" 
                               placeholder="50" min="0" required>
                    </div>

                    <!-- Foto -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Foto Menu
                        </label>
                        <input type="file" name="photo" accept="image/*" 
                               class="input-field @error('photo') border-red-500 @enderror" 
                               onchange="previewImage(event)">
                        <p class="text-xs text-gray-600 mt-1">Max 2MB (JPG, PNG)</p>
                    </div>

                    <!-- Preview Foto -->
                    <div id="photo-preview" class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Preview
                        </label>
                        <img id="preview-img" src="" alt="Preview" 
                             class="w-32 h-32 object-cover rounded-lg border-2 border-blue-300 shadow-sm">
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="description" rows="4" 
                                  class="input-field @error('description') border-red-500 @enderror" 
                                  placeholder="Deskripsi menu (opsional)">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t-2 border-gray-200">
                    <a href="{{ route('menu.index') }}" class="btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        💾 Simpan Menu
                    </button>
                </div>
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
document.getElementById('create-form').addEventListener('submit', function(e) {
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