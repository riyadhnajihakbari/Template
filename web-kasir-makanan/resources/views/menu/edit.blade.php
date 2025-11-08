@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="p-6">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('menu.index') }}" class="text-pos-primary hover:underline">
                ← Kembali ke Daftar Menu
            </a>
        </div>

        <div class="card">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Menu: {{ $menuItem->name }}</h2>

            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('menu.update', $menuItem) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Menu -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Menu <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $menuItem->name) }}" 
                               class="input-field" required>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" class="input-field" required>
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
                               class="input-field" min="0" step="1000" required>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', $menuItem->stock) }}" 
                               class="input-field" min="0" required>
                    </div>

                    <!-- Foto Saat Ini -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Foto Saat Ini
                        </label>
                        @if($menuItem->photo_url)
                        <img src="{{ asset('storage/' . $menuItem->photo_url) }}" 
                             alt="{{ $menuItem->name }}" 
                             class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300">
                        @else
                        <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center text-4xl">
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
                               class="input-field" 
                               onchange="previewImage(event)">
                        <p class="text-xs text-gray-600 mt-1">Max 2MB (JPG, PNG)</p>
                        
                        <!-- Preview Foto Baru -->
                        <div id="photo-preview" class="hidden mt-2">
                            <img id="preview-img" src="" alt="Preview" 
                                 class="w-32 h-32 object-cover rounded-lg border-2 border-blue-300">
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="description" rows="4" 
                                  class="input-field" 
                                  placeholder="Deskripsi menu (opsional)">{{ old('description', $menuItem->description) }}</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6 pt-6 border-t">
                    <form action="{{ route('menu.destroy', $menuItem) }}" method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                            🗑️ Hapus Menu
                        </button>
                    </form>

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
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('photo-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection