@extends('layouts.admin')

@section('title', 'Tambah Hasil Pertandingan')
@section('header', 'Tambah Hasil Pertandingan')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('admin.matches.store') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Olahraga</label>
                <select name="sport_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Olahraga</option>
                    @foreach($sports as $sport)
                        <option value="{{ $sport->id }}">{{ $sport->icon }} {{ $sport->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tim A</label>
                    <input type="text" name="team_a" value="{{ old('team_a') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                           placeholder="Nama Tim A">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tim B</label>
                    <input type="text" name="team_b" value="{{ old('team_b') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                           placeholder="Nama Tim B">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Skor Tim A</label>
                    <input type="number" name="score_a" value="{{ old('score_a', 0) }}" required min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Skor Tim B</label>
                    <input type="number" name="score_b" value="{{ old('score_b', 0) }}" required min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal & Waktu</label>
                    <input type="datetime-local" name="tanggal" value="{{ old('tanggal') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                           placeholder="Nama Stadion">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">URL Highlight (Opsional)</label>
                <input type="url" name="highlight_url" value="{{ old('highlight_url') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                       placeholder="https://youtube.com/...">
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.matches.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg font-medium hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                    Simpan Hasil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection