<!-- Hero Section with Colorful Animation -->
<section id="hero-section" class="relative bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 text-gray-900 overflow-hidden min-h-screen">
    <!-- Animated colorful blobs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Large gradient orbs -->
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-blue-400/40 via-purple-400/40 to-pink-400/40 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-tr from-amber-400/40 via-orange-400/40 to-red-400/40 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-green-400/30 via-teal-400/30 to-blue-400/30 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <!-- Animated light rays -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute h-px bg-gradient-to-r from-transparent via-blue-400/60 to-transparent animate-ray" style="width: 50%; top: 20%; left: -25%; transform: rotate(-15deg);"></div>
        <div class="absolute h-px bg-gradient-to-r from-transparent via-purple-400/60 to-transparent animate-ray" style="width: 60%; top: 40%; left: -30%; transform: rotate(-10deg); animation-delay: 1s;"></div>
        <div class="absolute h-px bg-gradient-to-r from-transparent via-pink-400/60 to-transparent animate-ray" style="width: 55%; top: 60%; left: -27%; transform: rotate(-12deg); animation-delay: 2s;"></div>
        <div class="absolute h-px bg-gradient-to-r from-transparent via-amber-400/60 to-transparent animate-ray" style="width: 65%; top: 80%; left: -32%; transform: rotate(-8deg); animation-delay: 3s;"></div>
    </div>

    <!-- Floating sparkles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        @for($i = 0; $i < 40; $i++)
            @php
                $colors = ['bg-blue-400', 'bg-purple-400', 'bg-pink-400', 'bg-amber-400', 'bg-teal-400'];
                $color = $colors[$i % 5];
            @endphp
            <div class="absolute rounded-full {{ $color }} opacity-60 animate-sparkle"
                 style="
                    width: {{ rand(3, 8) }}px;
                    height: {{ rand(3, 8) }}px;
                    left: {{ rand(0, 100) }}%;
                    top: {{ rand(0, 100) }}%;
                    animation-delay: {{ rand(0, 5000) }}ms;
                    animation-duration: {{ rand(3, 8) }}s;
                 "></div>
        @endfor
    </div>

    <!-- Geometric shapes floating -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-20">
        <div class="absolute w-32 h-32 border-4 border-blue-400 rounded-xl rotate-12 animate-float-shape" style="top: 10%; right: 15%;"></div>
        <div class="absolute w-24 h-24 border-4 border-purple-400 rounded-full animate-float-shape animation-delay-2000" style="bottom: 20%; left: 10%;"></div>
        <div class="absolute w-28 h-28 border-4 border-pink-400 rounded-lg -rotate-12 animate-float-shape animation-delay-4000" style="top: 60%; right: 20%;"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            
            <!-- Left side - Text content -->
            <div class="space-y-6 animate-fade-in-up order-2 lg:order-1 text-center lg:text-left">
                <div class="inline-block px-4 py-2 bg-gradient-to-r from-blue-100 via-purple-100 to-pink-100 rounded-full border border-blue-200/50 shadow-lg shadow-blue-200/50">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 font-semibold text-sm">
                        ✨ Premium Ticketing Platform
                    </span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
                    Beli Tiket Olahraga
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 mt-2 animate-gradient">
                        Lebih Mudah & Cepat
                    </span>
                </h1>

                <p class="text-lg sm:text-xl text-gray-700 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Platform terlengkap untuk membeli tiket event olahraga, membaca berita terkini, dan belanja merchandise resmi.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 pt-4 justify-center lg:justify-start">
                    <a href="{{ route('events.index') }}" class="group relative inline-flex items-center justify-center bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white px-8 py-4 rounded-xl font-semibold overflow-hidden transition-all duration-300 transform hover:scale-105 shadow-lg shadow-purple-500/50 hover:shadow-xl hover:shadow-purple-500/60">
                        <div class="absolute inset-0 bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <span class="relative mr-2">🎫</span>
                        <span class="relative">Lihat Event</span>
                    </a>
                    <a href="{{ route('store.index') }}" class="inline-flex items-center justify-center bg-white/90 backdrop-blur-sm border-2 border-purple-300 text-purple-700 px-8 py-4 rounded-xl font-semibold hover:bg-purple-50 hover:border-purple-400 transition-all duration-300 shadow-lg shadow-purple-200/50">
                        <span class="mr-2">🛍️</span> Kunjungi Store
                    </a>
                </div>

                <!-- Stats with colorful backgrounds -->
                <div class="grid grid-cols-3 gap-4 sm:gap-6 pt-8 max-w-md mx-auto lg:mx-0">
                    <div class="text-center bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl p-4 shadow-lg border border-blue-200/50 transform hover:scale-105 transition-transform">
                        <div class="text-2xl sm:text-3xl font-bold text-blue-600">1000+</div>
                        <div class="text-xs sm:text-sm text-blue-700 mt-1 font-medium">Events</div>
                    </div>
                    <div class="text-center bg-gradient-to-br from-purple-100 to-purple-50 rounded-2xl p-4 shadow-lg border border-purple-200/50 transform hover:scale-105 transition-transform">
                        <div class="text-2xl sm:text-3xl font-bold text-purple-600">50K+</div>
                        <div class="text-xs sm:text-sm text-purple-700 mt-1 font-medium">Users</div>
                    </div>
                    <div class="text-center bg-gradient-to-br from-pink-100 to-pink-50 rounded-2xl p-4 shadow-lg border border-pink-200/50 transform hover:scale-105 transition-transform">
                        <div class="text-2xl sm:text-3xl font-bold text-pink-600">100K+</div>
                        <div class="text-xs sm:text-sm text-pink-700 mt-1 font-medium">Tickets</div>
                    </div>
                </div>
            </div>

            <!-- Right side - Floating tickets with colorful gradients -->
            <div class="relative h-[400px] sm:h-[500px] lg:h-[600px] order-1 lg:order-2">
                <!-- Central glow with multiple colors -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-br from-blue-300/40 via-purple-300/40 to-pink-300/40 rounded-full blur-3xl animate-pulse-slow"></div>

                <!-- Floating ticket 1 - Football (Blue-Purple) -->
                <div class="absolute animate-float-ticket-1 z-10" style="left: 5%; top: 10%;">
                    <div class="ticket-card bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 hover:from-blue-600 hover:via-purple-600 hover:to-indigo-700">
                        <div class="ticket-holes-top">
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                        </div>
                        <div class="ticket-icon-wrapper">
                            <div class="text-5xl sm:text-6xl lg:text-7xl filter drop-shadow-2xl">⚽</div>
                        </div>
                        <div class="ticket-content">
                            <div class="ticket-type">Football</div>
                            <div class="ticket-subtitle">Premier League</div>
                        </div>
                        <div class="ticket-holes-bottom">
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                        </div>
                        <div class="ticket-shine"></div>
                        <div class="ticket-glow"></div>
                    </div>
                </div>

                <!-- Floating ticket 2 - Basketball (Orange-Red) -->
                <div class="absolute animate-float-ticket-2 z-10" style="right: 5%; top: 5%;">
                    <div class="ticket-card bg-gradient-to-br from-orange-500 via-red-500 to-pink-600 hover:from-orange-600 hover:via-red-600 hover:to-pink-700">
                        <div class="ticket-holes-top">
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                        </div>
                        <div class="ticket-icon-wrapper">
                            <div class="text-5xl sm:text-6xl lg:text-7xl filter drop-shadow-2xl">🏀</div>
                        </div>
                        <div class="ticket-content">
                            <div class="ticket-type">Basketball</div>
                            <div class="ticket-subtitle">NBA Finals</div>
                        </div>
                        <div class="ticket-holes-bottom">
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                        </div>
                        <div class="ticket-shine"></div>
                        <div class="ticket-glow"></div>
                    </div>
                </div>

                <!-- Floating ticket 3 - Badminton (Purple-Pink) -->
                <div class="absolute animate-float-ticket-3 z-10 hidden sm:block" style="left: 10%; bottom: 8%;">
                    <div class="ticket-card bg-gradient-to-br from-purple-500 via-pink-500 to-rose-600 hover:from-purple-600 hover:via-pink-600 hover:to-rose-700">
                        <div class="ticket-holes-top">
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                        </div>
                        <div class="ticket-icon-wrapper">
                            <div class="text-5xl sm:text-6xl lg:text-7xl filter drop-shadow-2xl">🏸</div>
                        </div>
                        <div class="ticket-content">
                            <div class="ticket-type">Badminton</div>
                            <div class="ticket-subtitle">World Tour</div>
                        </div>
                        <div class="ticket-holes-bottom">
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                        </div>
                        <div class="ticket-shine"></div>
                        <div class="ticket-glow"></div>
                    </div>
                </div>

                <!-- Floating ticket 4 - Tennis (Green-Teal) -->
                <div class="absolute animate-float-ticket-4 z-10 hidden lg:block" style="right: 10%; bottom: 12%;">
                    <div class="ticket-card bg-gradient-to-br from-teal-500 via-cyan-500 to-blue-600 hover:from-teal-600 hover:via-cyan-600 hover:to-blue-700">
                        <div class="ticket-holes-top">
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                        </div>
                        <div class="ticket-icon-wrapper">
                            <div class="text-5xl sm:text-6xl lg:text-7xl filter drop-shadow-2xl">🎾</div>
                        </div>
                        <div class="ticket-content">
                            <div class="ticket-type">Tennis</div>
                            <div class="ticket-subtitle">Grand Slam</div>
                        </div>
                        <div class="ticket-holes-bottom">
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                        </div>
                        <div class="ticket-shine"></div>
                        <div class="ticket-glow"></div>
                    </div>
                </div>

                <!-- Orbiting colorful dots -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-spin-slow" style="width: 220px; height: 220px; animation-duration: 20s;">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-3 h-3 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full shadow-lg shadow-blue-400/50 animate-pulse"></div>
                </div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-spin-slow" style="width: 300px; height: 300px; animation-duration: 25s; animation-delay: -5s;">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-3 h-3 bg-gradient-to-br from-pink-500 to-red-500 rounded-full shadow-lg shadow-pink-400/50 animate-pulse animation-delay-2000"></div>
                </div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-spin-slow hidden lg:block" style="width: 380px; height: 380px; animation-duration: 30s; animation-delay: -10s;">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-3 h-3 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-full shadow-lg shadow-teal-400/50 animate-pulse animation-delay-4000"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom gradient overlay -->
    <div class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-white via-white/80 to-transparent pointer-events-none"></div>
</section>

<style>
/* Ticket Card Base Styles */
.ticket-card {
    width: 9rem;
    height: 12rem;
    border-radius: 1rem;
    padding: 1rem;
    backdrop-filter: blur(8px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

@media (min-width: 640px) {
    .ticket-card {
        width: 11rem;
        height: 14rem;
        padding: 1.25rem;
    }
}

@media (min-width: 1024px) {
    .ticket-card {
        width: 13rem;
        height: 17rem;
        padding: 1.5rem;
    }
}

.ticket-card:hover {
    transform: scale(1.08) rotate(0deg) !important;
    box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.4);
    z-index: 30 !important;
}

.ticket-holes-top,
.ticket-holes-bottom {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
}

.ticket-holes-bottom {
    margin-bottom: 0;
    margin-top: auto;
}

.ticket-hole {
    width: 0.625rem;
    height: 0.625rem;
    background: rgba(255, 255, 255, 0.4);
    border-radius: 50%;
}

.ticket-icon-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    flex: 1;
    margin: 0.5rem 0;
}

.ticket-content {
    text-align: center;
    color: white;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.ticket-type {
    font-weight: 700;
    font-size: 1.125rem;
    margin-bottom: 0.25rem;
}

@media (min-width: 640px) {
    .ticket-type {
        font-size: 1.25rem;
        margin-bottom: 0.375rem;
    }
}

.ticket-subtitle {
    font-size: 0.75rem;
    opacity: 0.9;
}

@media (min-width: 640px) {
    .ticket-subtitle {
        font-size: 0.875rem;
    }
}

.ticket-shine {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, transparent 0%, rgba(255, 255, 255, 0.15) 50%, transparent 100%);
    border-radius: 1rem;
    pointer-events: none;
}

.ticket-glow {
    position: absolute;
    inset: -2px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), transparent);
    border-radius: 1rem;
    opacity: 0;
    transition: opacity 0.4s;
    pointer-events: none;
    z-index: -1;
    filter: blur(8px);
}

.ticket-card:hover .ticket-glow {
    opacity: 1;
}

/* Animation Keyframes */
@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    25% { transform: translate(20px, -50px) scale(1.1); }
    50% { transform: translate(-20px, 20px) scale(0.9); }
    75% { transform: translate(50px, 50px) scale(1.05); }
}

@keyframes ray {
    0% { transform: translateX(-100%) rotate(-15deg); opacity: 0; }
    20% { opacity: 0.6; }
    80% { opacity: 0.6; }
    100% { transform: translateX(300%) rotate(-15deg); opacity: 0; }
}

@keyframes sparkle {
    0%, 100% { 
        transform: translateY(0px) translateX(0px) scale(1); 
        opacity: 0.6; 
    }
    25% { 
        transform: translateY(-30px) translateX(20px) scale(1.2); 
        opacity: 0.8; 
    }
    50% { 
        transform: translateY(-15px) translateX(-15px) scale(0.8); 
        opacity: 0.4; 
    }
    75% { 
        transform: translateY(-40px) translateX(10px) scale(1.1); 
        opacity: 0.7; 
    }
}

@keyframes float-shape {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-40px) rotate(10deg); }
}

@keyframes float-ticket-1 {
    0%, 100% { transform: translateY(0px) rotate(8deg); }
    50% { transform: translateY(-35px) rotate(12deg); }
}

@keyframes float-ticket-2 {
    0%, 100% { transform: translateY(0px) rotate(-8deg); }
    50% { transform: translateY(-30px) rotate(-12deg); }
}

@keyframes float-ticket-3 {
    0%, 100% { transform: translateY(0px) rotate(5deg); }
    50% { transform: translateY(-40px) rotate(8deg); }
}

@keyframes float-ticket-4 {
    0%, 100% { transform: translateY(0px) rotate(-5deg); }
    50% { transform: translateY(-32px) rotate(-8deg); }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

/* Animation Classes */
.animate-blob {
    animation: blob 20s ease-in-out infinite;
}

.animate-ray {
    animation: ray 8s ease-in-out infinite;
}

.animate-sparkle {
    animation: sparkle 6s ease-in-out infinite;
}

.animate-float-shape {
    animation: float-shape 8s ease-in-out infinite;
}

.animate-float-ticket-1 {
    animation: float-ticket-1 7s ease-in-out infinite;
}

.animate-float-ticket-2 {
    animation: float-ticket-2 8s ease-in-out infinite;
    animation-delay: 0.5s;
}

.animate-float-ticket-3 {
    animation: float-ticket-3 9s ease-in-out infinite;
    animation-delay: 1s;
}

.animate-float-ticket-4 {
    animation: float-ticket-4 7.5s ease-in-out infinite;
    animation-delay: 1.5s;
}

.animate-fade-in-up {
    animation: fadeInUp 1s ease-out;
}

.animate-spin-slow {
    animation: spin 20s linear infinite;
}

.animate-pulse-slow {
    animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

@keyframes spin {
    from { transform: translate(-50%, -50%) rotate(0deg); }
    to { transform: translate(-50%, -50%) rotate(360deg); }
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.8; transform: scale(1.05); }
}
</style>