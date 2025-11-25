<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Sport;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Data provinsi dan kota di Indonesia
     */
    private function getProvinces()
    {
        return [
            'aceh' => 'Aceh',
            'sumut' => 'Sumatera Utara',
            'sumbar' => 'Sumatera Barat',
            'riau' => 'Riau',
            'kepri' => 'Kepulauan Riau',
            'jambi' => 'Jambi',
            'sumsel' => 'Sumatera Selatan',
            'babel' => 'Bangka Belitung',
            'bengkulu' => 'Bengkulu',
            'lampung' => 'Lampung',
            'jakarta' => 'DKI Jakarta',
            'jabar' => 'Jawa Barat',
            'banten' => 'Banten',
            'jateng' => 'Jawa Tengah',
            'jogja' => 'DI Yogyakarta',
            'jatim' => 'Jawa Timur',
            'bali' => 'Bali',
            'ntb' => 'Nusa Tenggara Barat',
            'ntt' => 'Nusa Tenggara Timur',
            'kalbar' => 'Kalimantan Barat',
            'kalteng' => 'Kalimantan Tengah',
            'kalsel' => 'Kalimantan Selatan',
            'kaltim' => 'Kalimantan Timur',
            'kaltara' => 'Kalimantan Utara',
            'sulut' => 'Sulawesi Utara',
            'sulteng' => 'Sulawesi Tengah',
            'sulsel' => 'Sulawesi Selatan',
            'sultra' => 'Sulawesi Tenggara',
            'gorontalo' => 'Gorontalo',
            'sulbar' => 'Sulawesi Barat',
            'maluku' => 'Maluku',
            'malut' => 'Maluku Utara',
            'papbar' => 'Papua Barat',
            'papua' => 'Papua',
        ];
    }

    private function getCitiesByProvince()
    {
        return [
            'aceh' => ['Banda Aceh', 'Aceh Besar', 'Aceh Barat', 'Aceh Selatan', 'Aceh Timur', 'Sabang', 'Lhokseumawe', 'Langsa'],
            'sumut' => ['Medan', 'Binjai', 'Tebing Tinggi', 'Pematang Siantar', 'Tanjung Balai', 'Deli Serdang', 'Karo', 'Langkat'],
            'sumbar' => ['Padang', 'Bukittinggi', 'Payakumbuh', 'Padang Panjang', 'Solok', 'Sawahlunto', 'Pariaman'],
            'riau' => ['Pekanbaru', 'Dumai', 'Bengkalis', 'Kampar', 'Rokan Hulu', 'Siak', 'Pelalawan'],
            'kepri' => ['Batam', 'Tanjung Pinang', 'Bintan', 'Karimun', 'Natuna', 'Lingga'],
            'jambi' => ['Jambi', 'Sungai Penuh', 'Batang Hari', 'Bungo', 'Kerinci', 'Merangin', 'Muaro Jambi'],
            'sumsel' => ['Palembang', 'Prabumulih', 'Pagar Alam', 'Lubuk Linggau', 'Banyuasin', 'Musi Banyuasin', 'Ogan Ilir'],
            'babel' => ['Pangkal Pinang', 'Bangka', 'Belitung', 'Bangka Barat', 'Bangka Tengah', 'Bangka Selatan'],
            'bengkulu' => ['Bengkulu', 'Bengkulu Utara', 'Bengkulu Selatan', 'Bengkulu Tengah', 'Kaur', 'Rejang Lebong'],
            'lampung' => ['Bandar Lampung', 'Metro', 'Lampung Selatan', 'Lampung Tengah', 'Lampung Utara', 'Lampung Timur'],
            'jakarta' => ['Jakarta Pusat', 'Jakarta Utara', 'Jakarta Barat', 'Jakarta Selatan', 'Jakarta Timur', 'Kepulauan Seribu'],
            'jabar' => ['Bandung', 'Bekasi', 'Bogor', 'Cirebon', 'Depok', 'Sukabumi', 'Tasikmalaya', 'Cimahi', 'Banjar', 'Bandung Barat', 'Garut', 'Indramayu', 'Karawang', 'Kuningan', 'Majalengka', 'Pangandaran', 'Purwakarta', 'Subang', 'Sumedang'],
            'banten' => ['Serang', 'Tangerang', 'Cilegon', 'Tangerang Selatan', 'Pandeglang', 'Lebak', 'Tangerang (Kab.)'],
            'jateng' => ['Semarang', 'Surakarta', 'Magelang', 'Salatiga', 'Pekalongan', 'Tegal', 'Banyumas', 'Cilacap', 'Kebumen', 'Purworejo', 'Wonosobo', 'Boyolali', 'Klaten', 'Sukoharjo', 'Wonogiri', 'Karanganyar', 'Sragen', 'Blora', 'Grobogan', 'Kudus', 'Jepara', 'Demak', 'Semarang (Kab.)', 'Temanggung', 'Kendal', 'Batang', 'Pekalongan (Kab.)', 'Pemalang', 'Tegal (Kab.)', 'Brebes', 'Magelang (Kab.)', 'Purbalingga', 'Banjarnegara'],
            'jogja' => ['Yogyakarta', 'Sleman', 'Bantul', 'Kulon Progo', 'Gunungkidul'],
            'jatim' => ['Surabaya', 'Malang', 'Batu', 'Blitar', 'Kediri', 'Madiun', 'Mojokerto', 'Pasuruan', 'Probolinggo', 'Gresik', 'Sidoarjo', 'Bangkalan', 'Banyuwangi', 'Bondowoso', 'Jember', 'Lumajang', 'Situbondo', 'Bojonegoro', 'Lamongan', 'Tuban', 'Jombang', 'Nganjuk', 'Ponorogo', 'Tulungagung', 'Trenggalek', 'Pacitan', 'Magetan', 'Ngawi'],
            'bali' => ['Denpasar', 'Badung', 'Gianyar', 'Tabanan', 'Klungkung', 'Bangli', 'Karangasem', 'Buleleng', 'Jembrana'],
            'ntb' => ['Mataram', 'Bima', 'Lombok Barat', 'Lombok Tengah', 'Lombok Timur', 'Lombok Utara', 'Sumbawa', 'Dompu'],
            'ntt' => ['Kupang', 'Ende', 'Alor', 'Belu', 'Flores Timur', 'Lembata', 'Manggarai', 'Ngada', 'Sikka', 'Sumba Barat', 'Sumba Timur', 'Timor Tengah Selatan'],
            'kalbar' => ['Pontianak', 'Singkawang', 'Bengkayang', 'Kapuas Hulu', 'Kayong Utara', 'Ketapang', 'Kubu Raya', 'Landak', 'Melawi', 'Sambas', 'Sanggau', 'Sekadau', 'Sintang'],
            'kalteng' => ['Palangkaraya', 'Barito Selatan', 'Barito Timur', 'Barito Utara', 'Gunung Mas', 'Kapuas', 'Katingan', 'Kotawaringin Barat', 'Kotawaringin Timur', 'Lamandau', 'Murung Raya', 'Pulang Pisau', 'Seruyan', 'Sukamara'],
            'kalsel' => ['Banjarmasin', 'Banjarbaru', 'Banjar', 'Barito Kuala', 'Hulu Sungai Selatan', 'Hulu Sungai Tengah', 'Hulu Sungai Utara', 'Kotabaru', 'Tabalong', 'Tanah Bumbu', 'Tanah Laut', 'Tapin', 'Balangan'],
            'kaltim' => ['Samarinda', 'Balikpapan', 'Bontang', 'Berau', 'Kutai Barat', 'Kutai Kartanegara', 'Kutai Timur', 'Mahakam Ulu', 'Paser', 'Penajam Paser Utara'],
            'kaltara' => ['Tarakan', 'Bulungan', 'Malinau', 'Nunukan', 'Tana Tidung'],
            'sulut' => ['Manado', 'Bitung', 'Tomohon', 'Kotamobagu', 'Bolaang Mongondow', 'Minahasa', 'Minahasa Selatan', 'Minahasa Tenggara', 'Minahasa Utara', 'Kepulauan Sangihe', 'Kepulauan Talaud'],
            'sulteng' => ['Palu', 'Banggai', 'Banggai Kepulauan', 'Buol', 'Donggala', 'Morowali', 'Parigi Moutong', 'Poso', 'Sigi', 'Tojo Una-Una', 'Tolitoli'],
            'sulsel' => ['Makassar', 'Palopo', 'Parepare', 'Bantaeng', 'Barru', 'Bone', 'Bulukumba', 'Enrekang', 'Gowa', 'Jeneponto', 'Kepulauan Selayar', 'Luwu', 'Luwu Timur', 'Luwu Utara', 'Maros', 'Pangkajene Kepulauan', 'Pinrang', 'Sidenreng Rappang', 'Sinjai', 'Soppeng', 'Takalar', 'Tana Toraja', 'Toraja Utara', 'Wajo'],
            'sultra' => ['Kendari', 'Bau-Bau', 'Bombana', 'Buton', 'Kolaka', 'Konawe', 'Konawe Selatan', 'Konawe Utara', 'Muna', 'Wakatobi'],
            'gorontalo' => ['Gorontalo', 'Boalemo', 'Bone Bolango', 'Gorontalo Utara', 'Pohuwato'],
            'sulbar' => ['Mamuju', 'Majene', 'Mamasa', 'Mamuju Utara', 'Polewali Mandar'],
            'maluku' => ['Ambon', 'Tual', 'Buru', 'Buru Selatan', 'Kepulauan Aru', 'Maluku Tengah', 'Maluku Tenggara', 'Maluku Tenggara Barat', 'Seram Bagian Barat', 'Seram Bagian Timur'],
            'malut' => ['Ternate', 'Tidore Kepulauan', 'Halmahera Barat', 'Halmahera Tengah', 'Halmahera Timur', 'Halmahera Selatan', 'Halmahera Utara', 'Kepulauan Sula', 'Pulau Morotai'],
            'papbar' => ['Manokwari', 'Sorong', 'Fakfak', 'Kaimana', 'Manokwari Selatan', 'Maybrat', 'Pegunungan Arfak', 'Raja Ampat', 'Sorong Selatan', 'Tambrauw', 'Teluk Bintuni', 'Teluk Wondama'],
            'papua' => ['Jayapura', 'Asmat', 'Biak Numfor', 'Boven Digoel', 'Deiyai', 'Dogiyai', 'Intan Jaya', 'Jayawijaya', 'Keerom', 'Kepulauan Yapen', 'Lanny Jaya', 'Mamberamo Raya', 'Mamberamo Tengah', 'Mappi', 'Merauke', 'Mimika', 'Nabire', 'Nduga', 'Paniai', 'Pegunungan Bintang', 'Puncak', 'Puncak Jaya', 'Sarmi', 'Supiori', 'Tolikara', 'Waropen', 'Yahukimo', 'Yalimo'],
        ];
    }

    public function index(Request $request)
    {
        $query = Event::with(['sport', 'tickets'])
            ->where('tanggal_mulai', '>=', now())
            ->orderBy('tanggal_mulai', 'asc');

        // Filter by sport
        if ($request->filled('sport')) {
            $query->whereHas('sport', function($q) use ($request) {
                $q->where('slug', $request->sport);
            });
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('tanggal_mulai', $request->date);
        }

        // Filter by province
        if ($request->filled('province')) {
            $provinceName = $this->getProvinces()[$request->province] ?? '';
            $query->where('lokasi', 'LIKE', "%{$provinceName}%");
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->where('lokasi', 'LIKE', "%{$request->city}%");
        }

        $events = $query->paginate(12);
        $sports = Sport::all();
        $provinces = $this->getProvinces();
        $allCities = $this->getCitiesByProvince();
        
        // Get cities for selected province
        $cities = [];
        if ($request->filled('province')) {
            $cities = $allCities[$request->province] ?? [];
        }

        return view('events.index', compact('events', 'sports', 'provinces', 'cities', 'allCities'));
    }

    public function show(Event $event)
    {
        $event->load(['sport', 'tickets']);
        return view('events.show', compact('event'));
    }

    public function bySport($slug)
    {
        $sport = Sport::where('slug', $slug)->firstOrFail();
        
        $events = Event::with(['sport', 'tickets'])
            ->where('sport_id', $sport->id)
            ->where('tanggal_mulai', '>=', now())
            ->orderBy('tanggal_mulai', 'asc')
            ->paginate(12);

        $sports = Sport::all();
        $provinces = $this->getProvinces();
        $allCities = $this->getCitiesByProvince();

        return view('events.index', compact('events', 'sports', 'sport', 'provinces', 'allCities'));
    }

    /**
     * API endpoint untuk mendapatkan kota berdasarkan provinsi (optional, untuk AJAX)
     */
    public function getCities(Request $request)
    {
        $province = $request->get('province');
        $cities = $this->getCitiesByProvince()[$province] ?? [];
        
        return response()->json($cities);
    }
}