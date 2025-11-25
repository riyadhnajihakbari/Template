@extends('layouts.app')

@section('title', 'Events - SportifyX')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Semua Event</h1>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('events.index') }}" id="filterForm" class="grid md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Kategori Olahraga</label>
                <select name="sport" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    @foreach($sports as $sport)
                        <option value="{{ $sport->slug }}" {{ request('sport') == $sport->slug ? 'selected' : '' }}>
                            {{ $sport->icon }} {{ $sport->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Provinsi</label>
                <select name="province" id="provinceSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Provinsi</option>
                    @foreach($provinces as $code => $name)
                        <option value="{{ $code }}" {{ request('province') == $code ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Kota/Kabupaten</label>
                <select name="city" id="citySelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" {{ !request('province') ? 'disabled' : '' }}>
                    <option value="">Pilih Provinsi Dulu</option>
                    @if(request('province') && isset($cities))
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 rounded-lg hover:from-blue-700 hover:to-purple-700 transition font-medium">
                    🔍 Filter
                </button>
                <a href="{{ route('events.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    ✕
                </a>
            </div>
        </form>
    </div>

    <!-- Active Filters Display -->
    @if(request()->hasAny(['sport', 'date', 'province', 'city']))
        <div class="mb-6 flex flex-wrap gap-2">
            <span class="text-sm text-gray-600">Filter aktif:</span>
            
            @if(request('sport'))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                    Olahraga: {{ collect($sports)->where('slug', request('sport'))->first()->name ?? request('sport') }}
                    <a href="{{ route('events.index', array_diff_key(request()->all(), ['sport' => ''])) }}" class="ml-2 text-blue-600 hover:text-blue-800">×</a>
                </span>
            @endif
            
            @if(request('date'))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                    Tanggal: {{ \Carbon\Carbon::parse(request('date'))->format('d M Y') }}
                    <a href="{{ route('events.index', array_diff_key(request()->all(), ['date' => ''])) }}" class="ml-2 text-green-600 hover:text-green-800">×</a>
                </span>
            @endif
            
            @if(request('province'))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-purple-100 text-purple-800">
                    Provinsi: {{ $provinces[request('province')] ?? request('province') }}
                    <a href="{{ route('events.index', array_diff_key(request()->all(), ['province' => '', 'city' => ''])) }}" class="ml-2 text-purple-600 hover:text-purple-800">×</a>
                </span>
            @endif
            
            @if(request('city'))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-pink-100 text-pink-800">
                    Kota: {{ request('city') }}
                    <a href="{{ route('events.index', array_diff_key(request()->all(), ['city' => ''])) }}" class="ml-2 text-pink-600 hover:text-pink-800">×</a>
                </span>
            @endif
        </div>
    @endif

    <!-- Results Count -->
    <div class="mb-4 text-gray-600">
        Menampilkan <strong>{{ $events->total() }}</strong> event
    </div>

    <!-- Events Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                @if($event->poster)
                    <div class="relative">
                        <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                        <div class="absolute top-3 left-3">
                            <span class="bg-white/95 backdrop-blur-sm text-blue-600 px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                {{ $event->sport->icon }} {{ $event->sport->name }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="relative w-full h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        <span class="text-7xl opacity-70">{{ $event->sport->icon }}</span>
                        <div class="absolute top-3 left-3">
                            <span class="bg-white/95 backdrop-blur-sm text-blue-600 px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                {{ $event->sport->name }}
                            </span>
                        </div>
                    </div>
                @endif
                
                <div class="p-5">
                    <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 hover:text-blue-600 transition-colors">
                        {{ $event->title }}
                    </h3>
                    
                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                        <div class="flex items-center">
                            <span class="w-5 flex-shrink-0">📅</span>
                            <span class="ml-1">{{ $event->tanggal_mulai->format('d M Y, H:i') }} WIB</span>
                        </div>
                        <div class="flex items-start">
                            <span class="w-5 flex-shrink-0 mt-0.5">📍</span>
                            <span class="ml-1 line-clamp-2">{{ $event->lokasi }}</span>
                        </div>
                    </div>
                    
                    @if($event->tickets->count() > 0)
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                            <div>
                                <span class="text-xs text-gray-500 block">Mulai dari</span>
                                <span class="text-lg font-bold text-emerald-600">
                                    Rp {{ number_format($event->tickets->min('harga'), 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-gray-500 block">Tersedia</span>
                                <span class="text-sm font-semibold text-gray-700">
                                    {{ $event->tickets->sum('kuota') }} tiket
                                </span>
                            </div>
                        </div>
                    @endif
                    
                    <a href="{{ route('events.show', $event) }}" 
                       class="block text-center bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2.5 rounded-lg hover:from-blue-700 hover:to-purple-700 transition font-medium shadow-md hover:shadow-lg">
                        Lihat Detail & Beli Tiket
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <div class="text-6xl mb-4">🔍</div>
                <p class="text-xl text-gray-700 font-medium mb-2">Tidak ada event yang ditemukan</p>
                <p class="text-gray-500 mb-6">Coba ubah filter pencarian Anda</p>
                <a href="{{ route('events.index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Reset Filter
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($events->hasPages())
        <div class="mt-8">
            {{ $events->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- JavaScript for Dynamic City Dropdown -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('provinceSelect');
    const citySelect = document.getElementById('citySelect');
    
    // Data kota per provinsi
    const citiesData = {!! json_encode($allCities ?? []) !!};
    
    provinceSelect.addEventListener('change', function() {
        const selectedProvince = this.value;
        
        // Reset city dropdown
        citySelect.innerHTML = '<option value="">Semua Kota/Kabupaten</option>';
        
        if (selectedProvince && citiesData[selectedProvince]) {
            // Enable city dropdown
            citySelect.disabled = false;
            
            // Populate cities
            citiesData[selectedProvince].forEach(city => {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                citySelect.appendChild(option);
            });
        } else {
            citySelect.disabled = true;
            citySelect.innerHTML = '<option value="">Pilih Provinsi Dulu</option>';
        }
    });
    
    // Trigger change event if province is already selected (for page reload)
    if (provinceSelect.value) {
        provinceSelect.dispatchEvent(new Event('change'));
        
        // Set selected city if exists
        const selectedCity = '{{ request("city") }}';
        if (selectedCity) {
            setTimeout(() => {
                citySelect.value = selectedCity;
            }, 100);
        }
    }
});
</script>
@endsection