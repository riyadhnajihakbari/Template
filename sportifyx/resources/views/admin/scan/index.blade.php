@extends('layouts.admin')

@section('title', 'Scan Tiket')
@section('header', 'Scan QR Code Tiket')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold">Scanner Tiket</h2>
            <p class="text-gray-600 mt-1">Scan QR Code tiket untuk verifikasi</p>
        </div>

        <!-- Camera Scanner -->
        <div class="mb-6">
            <div id="reader" class="mx-auto" style="max-width: 500px;"></div>
        </div>

        <!-- Manual Input -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Atau masukkan kode manual:</label>
            <div class="flex gap-3">
                <input type="text" id="manual-code" placeholder="Masukkan QR Code" 
                       class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <button onclick="verifyManual()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                    Verifikasi
                </button>
            </div>
        </div>

        <!-- Result -->
        <div id="result" class="hidden">
            <div id="result-content"></div>
        </div>
    </div>
</div>

<!-- Include HTML5 QR Code Scanner Library -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    let html5QrcodeScanner = null;

    function onScanSuccess(decodedText, decodedResult) {
        // Stop scanning
        html5QrcodeScanner.clear();
        
        // Verify the QR code
        verifyQRCode(decodedText);
    }

    function onScanFailure(error) {
        // Handle scan failure silently
    }

    // Initialize scanner
    html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { 
            fps: 10, 
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0
        },
        false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);

    function verifyManual() {
        const code = document.getElementById('manual-code').value.trim();
        if (code) {
            verifyQRCode(code);
        } else {
            alert('Masukkan kode QR terlebih dahulu');
        }
    }

    function verifyQRCode(qrCode) {
        const resultDiv = document.getElementById('result');
        const resultContent = document.getElementById('result-content');
        
        resultDiv.classList.remove('hidden');
        resultContent.innerHTML = '<div class="text-center py-4"><div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600 mx-auto"></div><p class="mt-2 text-gray-600">Memverifikasi...</p></div>';

        fetch('{{ route("admin.scan.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ qr_code: qrCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                resultContent.innerHTML = `
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6">
                        <div class="text-center mb-4">
                            <div class="text-6xl mb-2">✅</div>
                            <h3 class="text-2xl font-bold text-emerald-800">${data.message}</h3>
                        </div>
                        <div class="bg-white rounded-lg p-4 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order ID</span>
                                <span class="font-semibold">#${data.order.id}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama</span>
                                <span class="font-semibold">${data.order.user_name}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Event</span>
                                <span class="font-semibold">${data.order.event_title}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal</span>
                                <span class="font-semibold">${data.order.event_date}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kategori</span>
                                <span class="font-semibold">${data.order.ticket_category}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jumlah Orang</span>
                                <span class="font-semibold text-lg text-blue-600">${data.order.quantity} orang</span>
                            </div>
                        </div>
                        <button onclick="resetScanner()" class="mt-4 w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-lg font-medium">
                            Scan Tiket Lainnya
                        </button>
                    </div>
                `;
            } else {
                resultContent.innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                        <div class="text-center mb-4">
                            <div class="text-6xl mb-2">❌</div>
                            <h3 class="text-2xl font-bold text-red-800">${data.message}</h3>
                        </div>
                        <button onclick="resetScanner()" class="mt-4 w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg font-medium">
                            Coba Lagi
                        </button>
                    </div>
                `;
            }
        })
        .catch(error => {
            resultContent.innerHTML = `
                <div class="bg-red-50 border border-red-200 rounded-xl p-6 text-center">
                    <div class="text-6xl mb-2">⚠️</div>
                    <h3 class="text-xl font-bold text-red-800">Terjadi Kesalahan</h3>
                    <p class="text-red-600 mt-2">Gagal memverifikasi QR Code. Silakan coba lagi.</p>
                    <button onclick="resetScanner()" class="mt-4 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium">
                        Coba Lagi
                    </button>
                </div>
            `;
        });
    }

    function resetScanner() {
        document.getElementById('result').classList.add('hidden');
        document.getElementById('manual-code').value = '';
        
        // Reinitialize scanner
        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { 
                fps: 10, 
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0
            },
            false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }
</script>
@endsection