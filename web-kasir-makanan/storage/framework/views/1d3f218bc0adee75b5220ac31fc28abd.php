

<?php $__env->startSection('title', 'Tambah User'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6 max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="<?php echo e(route('users.index')); ?>" class="text-orange-600 hover:text-orange-700 font-semibold mb-4 inline-flex items-center gap-2">
            ← Kembali
        </a>
        <h2 class="text-4xl font-bold bg-gradient-to-r from-orange-500 via-orange-600 to-red-500 bg-clip-text text-transparent mb-2">
            Tambah User Baru
        </h2>
        <p class="text-gray-600">Buat akun pengguna baru untuk sistem</p>
    </div>

    <!-- Form -->
    <div class="modern-card p-8">
        <form method="POST" action="<?php echo e(route('users.store')); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="<?php echo e(old('name')); ?>" 
                       required
                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       placeholder="Masukkan nama lengkap">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       value="<?php echo e(old('email')); ?>" 
                       required
                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       placeholder="email@example.com">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-bold text-gray-700 mb-2">
                    Role / Jabatan <span class="text-red-500">*</span>
                </label>
                <select name="role" 
                        id="role" 
                        required
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">Pilih Role</option>
                    <option value="admin" <?php echo e(old('role') === 'admin' ? 'selected' : ''); ?>>👑 Admin - Akses Penuh</option>
                    <option value="manajer" <?php echo e(old('role') === 'manajer' ? 'selected' : ''); ?>>📊 Manajer - Kelola Menu & Laporan</option>
                    <option value="kasir" <?php echo e(old('role') === 'kasir' ? 'selected' : ''); ?>>💰 Kasir - POS & Transaksi</option>
                    <option value="koki" <?php echo e(old('role') === 'koki' ? 'selected' : ''); ?>>👨‍🍳 Koki - Dapur</option>
                    <option value="pelanggan" <?php echo e(old('role') === 'pelanggan' ? 'selected' : ''); ?>>👤 Pelanggan - Lihat Menu & Harga</option>
                </select>
                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       placeholder="Minimal 8 karakter">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                        <h3 class="text-sm font-semibold text-blue-800 mb-2">Informasi Role:</h3>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li><strong>👑 Admin:</strong> Akses penuh ke semua fitur sistem</li>
                            <li><strong>📊 Manajer:</strong> Kelola menu, laporan, dan manajemen user</li>
                            <li><strong>💰 Kasir:</strong> Akses POS untuk transaksi dan penjualan</li>
                            <li><strong>👨‍🍳 Koki:</strong> Melihat pesanan dapur dan status menu</li>
                            <li><strong>👤 Pelanggan:</strong> Hanya dapat melihat menu dan harga (tidak ada akses POS)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4">
                <a href="<?php echo e(route('users.index')); ?>" 
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

<?php $__env->startPush('scripts'); ?>
<script>
// Auto-fill email domain for pelanggan
document.getElementById('role')?.addEventListener('change', function() {
    const emailInput = document.getElementById('email');
    if (this.value === 'pelanggan' && emailInput && !emailInput.value) {
        // Optional: bisa ditambahkan logic untuk auto-suggest email format
        emailInput.placeholder = 'contoh: pelanggan@email.com';
    } else if (emailInput) {
        emailInput.placeholder = 'email@example.com';
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Pribadi\LYNK\Template\web-kasir-makanan\resources\views/users/create.blade.php ENDPATH**/ ?>