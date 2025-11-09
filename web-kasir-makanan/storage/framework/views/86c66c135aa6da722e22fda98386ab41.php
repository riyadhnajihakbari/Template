<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Login - Web Kasir Makanan</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>

    <style>
        /* Animasi fade-in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 1s ease-out forwards;
        }

        /* Efek partikel lembut */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
            animation: float 12s infinite ease-in-out;
        }

        @keyframes float {
            0% { transform: translateY(0) translateX(0); opacity: 0.8; }
            50% { transform: translateY(-40px) translateX(20px); opacity: 0.4; }
            100% { transform: translateY(0) translateX(0); opacity: 0.8; }
        }

        /* Custom color theme */
        .bg-primary {
            background-color: #FF6B35;
        }
        .bg-primary-hover:hover {
            background-color: #E55A2B;
        }
        .ring-primary:focus {
            --tw-ring-color: #FF6B35;
        }
        .accent-primary {
            accent-color: #FF6B35;
        }
    </style>
</head>
<body 
    class="relative min-h-screen flex items-center justify-center bg-cover bg-center overflow-hidden" 
    style="background-image: url('<?php echo e(asset('uploads/images/backgroundlogin.jpeg')); ?>');"
>
    <!-- Partikel lembut -->
    <div class="absolute inset-0 pointer-events-none">
        <?php for($i = 0; $i < 20; $i++): ?>
            <div class="particle" 
                style="
                    width: <?php echo e(rand(3,8)); ?>px; 
                    height: <?php echo e(rand(3,8)); ?>px; 
                    top: <?php echo e(rand(0,100)); ?>%; 
                    left: <?php echo e(rand(0,100)); ?>%; 
                    animation-delay: <?php echo e(rand(0,10) / 2); ?>s;
                ">
            </div>
        <?php endfor; ?>
    </div>

    <!-- Overlay gelap -->
    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative z-10 w-full max-w-md fade-in">
        <!-- Box login transparan -->
        <div class="bg-black/70 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/20 fade-in">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-2 flex justify-center">
                    <img src="<?php echo e(asset('uploads/images/Logo.png')); ?>" alt="Logo" class="w-16 h-16 animate-pulse">
                </h1>
                <h2 class="text-2xl font-bold text-white">Kasir Makanan</h2>
            </div>

            <?php if($errors->any()): ?>
            <div class="bg-red-500/20 border border-red-400 text-red-200 px-4 py-3 rounded mb-4">
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
                    <label class="block text-white font-semibold mb-2">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                           class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 ring-primary"
                           placeholder="email@example.com">
                </div>

                <div class="mb-6">
                    <label class="block text-white font-semibold mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 ring-primary"
                           placeholder="••••••••">
                </div>

                <div class="mb-6 flex items-center justify-between">
                    <label class="flex items-center text-sm text-gray-200">
                        <input type="checkbox" name="remember" class="mr-2 accent-primary">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="w-full py-2 rounded-lg bg-primary bg-primary-hover text-white font-bold transition duration-300">
                    Login
                </button>
            </form>

            <div class="mt-8 p-4 bg-white/10 rounded-lg text-white text-sm">
                <p class="font-semibold mb-2">Demo Accounts:</p>
                <div class="text-xs space-y-1">
                    <p><strong>Admin:</strong> admin@kasir.com / password</p>
                    <p><strong>Manajer:</strong> manajer@kasir.com / password</p>
                    <p><strong>Kasir:</strong> kasir@kasir.com / password</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4 text-white text-sm drop-shadow-md fade-in">
            <p>© 2024 Web Kasir Makanan. PWA Ready.</p>
        </div>
    </div>
</body>
</html><?php /**PATH D:\Pribadi\LYNK\Template\web-kasir-makanan\resources\views/auth/login.blade.php ENDPATH**/ ?>