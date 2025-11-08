<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Login - Web Kasir Makanan</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
</head>
<body class="bg-gradient-to-br from-blue-500 to-blue-700 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-pos-primary mb-2">🍽️</h1>
                <h2 class="text-2xl font-bold text-gray-800">Web Kasir Makanan</h2>
                <p class="text-gray-600">Offline-First POS System</p>
            </div>

            <?php if($errors->any()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                           class="input-field" placeholder="email@example.com">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" name="password" required
                           class="input-field" placeholder="••••••••">
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2">
                        <span class="text-sm text-gray-600">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="btn-primary w-full">
                    Login
                </button>
            </form>

            <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 font-semibold mb-2">Demo Accounts:</p>
                <div class="text-xs text-gray-600 space-y-1">
                    <p><strong>Admin:</strong> admin@kasir.com / password</p>
                    <p><strong>Manajer:</strong> manajer@kasir.com / password</p>
                    <p><strong>Kasir:</strong> kasir@kasir.com / password</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4 text-white text-sm">
            <p>© 2024 Web Kasir Makanan. PWA Ready.</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\Pribadi\LYNK\Template\web-kasir-makanan\resources\views/auth/login.blade.php ENDPATH**/ ?>