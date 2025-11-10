@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-4xl font-bold bg-gradient-to-r from-orange-500 via-orange-600 to-red-500 bg-clip-text text-transparent mb-2">
                    Edit Menu
                </h2>
                <p class="text-gray-600">Ubah informasi menu: {{ $menuItem->name }}</p>
            </div>
            <a href="{{ route('menu.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors font-semibold">
                ← Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="modern-card p-8 max-w-3xl">
        <form action="{{ route('menu.update', $menuItem->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Foto Menu -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">
                    📸 Foto Menu
                </label>
                
                <!-- Current Image -->
                @if($menuItem->photo_url)
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                    <div class="relative inline-block">
                        <img src="{{ asset($menuItem->photo_url) }}" 
                             alt="{{ $menuItem->name }}" 
                             id="current-image"
                             class="w-full max-w-md h-64 object-cover rounded-lg border-2 border-gray-300"
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=No+Image';">
                        <div class="absolute top-2 right-2">
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                ✓ Foto Ada
                            </span>
                        </div>
                    </div>
                </div>
                @else
                <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-yellow-800 text-sm">
                        ⚠️ Menu ini belum memiliki foto. Upload foto untuk tampilan lebih menarik!
                    </p>
                </div>
                @endif

                <!-- Image Preview (New Upload) -->
                <div id="image-preview" class="hidden mb-4">
                    <p class="text-sm text-gray-600 mb-2">Preview foto baru:</p>
                    <img id="preview-img" src="" alt="Preview" class="w-full max-w-md h-64 object-cover rounded-lg border-2 border-orange-500">
                    <button type="button" onclick="removeImage()" class="mt-2 text-red-600 hover:text-red-800 font-semibold text-sm">
                        ✕ Batal Ganti Foto
                    </button>
                </div>
                
                <!-- Upload Area -->
                <div id="upload-area" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-orange-500 transition-colors cursor-pointer">
                    <div class="text-4xl mb-2">📷</div>
                    <p class="text-gray-600 mb-2">
                        <span class="font-semibold text-orange-600">Klik untuk {{ $menuItem->photo_url ? 'ganti' : 'upload' }} foto</span>
                    </p>
                    <p class="text-sm text-gray-500">
                        Format: JPG, PNG, WEBP (Max: 2MB)
                    </p>
                </div>

                <input type="file" 
                       name="photo" 
                       id="photo" 
                       accept="image/jpeg,image/png,image/jpg,image/webp"
                       class="hidden"
                       onchange="previewImage(event)">
                
                @error('photo')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror

                <div class="mt-2 text-xs text-gray-500">
                    💡 Kosongkan jika tidak ingin mengubah foto
                </div>
            </div>

            <!-- Nama Menu -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">
                    Nama Menu
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name', $menuItem->name) }}"
                       placeholder="Contoh: Nasi Goreng Spesial"
                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all"
                       required>
                @error('name')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">
                    Kategori
                    <span class="text-red-500">*</span>
                </label>
                <select name="category_id" 
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all"
                        required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                            {{ old('category_id', $menuItem->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">
                    Harga
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-3 text-gray-600 font-semibold">Rp</span>
                    <input type="number" 
                           name="price" 
                           value="{{ old('price', $menuItem->price) }}"
                           placeholder="25000"
                           class="w-full pl-12 pr-4 py-3 rounded-lg border-2 border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all"
                           min="0"
                           step="1000"
                           required>
                </div>
                @error('price')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stok -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">
                    Stok
                    <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="stock" 
                       value="{{ old('stock', $menuItem->stock) }}"
                       placeholder="100"
                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all"
                       min="0"
                       required>
                @error('stock')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">
                    Deskripsi (Opsional)
                </label>
                <textarea name="description" 
                          rows="4"
                          placeholder="Deskripsi menu, bahan, atau informasi tambahan..."
                          class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all resize-none">{{ old('description', $menuItem->description) }}</textarea>
                @error('description')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Aktif -->
            <div class="mb-6">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', $menuItem->is_active) ? 'checked' : '' }}
                           class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500">
                    <span class="ml-3 text-gray-700 font-semibold">Menu Aktif (Tampil di POS)</span>
                </label>
            </div>

            <!-- Info Update -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
                    <strong>ℹ️ Info:</strong> Menu ini terakhir diupdate pada 
                    <strong>{{ $menuItem->updated_at->format('d M Y, H:i') }}</strong>
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-between pt-6 border-t">
                <a href="{{ route('menu.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors font-semibold">
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    💾 Update Menu
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Image preview function
function previewImage(event) {
    const file = event.target.files[0];
    const previewDiv = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const currentImage = document.getElementById('current-image');
    
    if (file) {
        // Validate file size (2MB = 2048KB)
        if (file.size > 2048 * 1024) {
            alert('⚠️ File terlalu besar! Maksimal 2MB.');
            event.target.value = '';
            return;
        }
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('⚠️ Format file tidak didukung! Gunakan JPG, PNG, atau WEBP.');
            event.target.value = '';
            return;
        }
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewDiv.classList.remove('hidden');
            
            // Hide current image if exists
            if (currentImage) {
                currentImage.parentElement.style.opacity = '0.5';
            }
        };
        reader.readAsDataURL(file);
    }
}

// Remove image function
function removeImage() {
    const fileInput = document.getElementById('photo');
    const previewDiv = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const currentImage = document.getElementById('current-image');
    
    fileInput.value = '';
    previewImg.src = '';
    previewDiv.classList.add('hidden');
    
    // Show current image again
    if (currentImage) {
        currentImage.parentElement.style.opacity = '1';
    }
}

// Click upload area to trigger file input
document.getElementById('upload-area')?.addEventListener('click', function() {
    document.getElementById('photo').click();
});

// Drag & drop functionality
const uploadArea = document.getElementById('upload-area');

uploadArea?.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('border-orange-500', 'bg-orange-50');
});

uploadArea?.addEventListener('dragleave', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('border-orange-500', 'bg-orange-50');
});

uploadArea?.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('border-orange-500', 'bg-orange-50');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        const fileInput = document.getElementById('photo');
        fileInput.files = files;
        
        // Trigger preview
        const event = new Event('change', { bubbles: true });
        fileInput.dispatchEvent(event);
    }
});
</script>
@endpush
@endsection