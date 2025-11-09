

<?php $__env->startSection('title', 'Edit Menu'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="<?php echo e(route('menu.index')); ?>" class="text-pos-primary hover:text-orange-700 font-semibold inline-flex items-center gap-2 transition-colors">
                ← Kembali ke Daftar Menu
            </a>
        </div>

        <div class="card">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Menu: <?php echo e($menuItem->name); ?></h2>

            <?php if($errors->any()): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">⚠️</span>
                    </div>
                    <div class="ml-3">
                        <h3 class="font-semibold mb-2">Terdapat kesalahan:</h3>
                        <ul class="list-disc list-inside space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <form id="edit-form" action="<?php echo e(route('menu.update', $menuItem->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Menu -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Menu <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="<?php echo e(old('name', $menuItem->name)); ?>" 
                               class="input-field <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" class="input-field <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">Pilih Kategori</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" 
                                    <?php echo e(old('category_id', $menuItem->category_id) == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="price" value="<?php echo e(old('price', $menuItem->price)); ?>" 
                               class="input-field <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="0" step="1000" required>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock" value="<?php echo e(old('stock', $menuItem->stock)); ?>" 
                               class="input-field <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="0" required>
                    </div>

                    <!-- Foto Saat Ini -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Foto Saat Ini
                        </label>
                        <?php if($menuItem->photo_url): ?>
                        <img src="<?php echo e(asset($menuItem->photo_url)); ?>" 
                             alt="<?php echo e($menuItem->name); ?>" 
                             class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300 shadow-sm"
                             onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center text-4xl\'>🍽️</div>';">
                        <?php else: ?>
                        <div class="w-32 h-32 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center text-4xl shadow-sm">
                            🍽️
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Upload Foto Baru -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Ganti Foto (Opsional)
                        </label>
                        <input type="file" name="photo" accept="image/*" 
                               class="input-field <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
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
                                  class="input-field <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  placeholder="Deskripsi menu (opsional)"><?php echo e(old('description', $menuItem->description)); ?></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-8 pt-6 border-t-2 border-gray-200">
                    <button type="button" onclick="confirmDeleteMenu()" class="px-6 py-3 rounded-lg bg-red-100 text-red-600 font-bold hover:bg-red-200 transition-all">
                        🗑️ Hapus Menu
                    </button>

                    <div class="flex items-center space-x-4">
                        <a href="<?php echo e(route('menu.index')); ?>" class="btn-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn-primary">
                            💾 Update Menu
                        </button>
                    </div>
                </div>
            </form>

            <!-- Hidden delete form -->
            <form id="delete-form" action="<?php echo e(route('menu.destroy', $menuItem->id)); ?>" method="POST" class="hidden">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
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
        html: `Yakin ingin menghapus menu <strong><?php echo e($menuItem->name); ?></strong>?<br><small class="text-gray-500">Tindakan ini tidak dapat dibatalkan</small>`,
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
<?php if(session('success')): ?>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '<?php echo e(session('success')); ?>',
        showConfirmButton: false,
        timer: 2000,
        toast: true,
        position: 'top-end',
        timerProgressBar: true
    });
<?php endif; ?>

<?php if(session('error')): ?>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '<?php echo e(session('error')); ?>',
        confirmButtonText: 'OK'
    });
<?php endif; ?>

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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Pribadi\LYNK\Template\web-kasir-makanan\resources\views/menu/edit.blade.php ENDPATH**/ ?>