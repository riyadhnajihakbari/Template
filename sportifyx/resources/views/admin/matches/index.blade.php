@extends('layouts.admin')

@section('title', 'Manage Hasil Pertandingan')
@section('header', 'Manage Hasil Pertandingan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-600">Total {{ $matches->total() }} pertandingan</p>
    <a href="{{ route('admin.matches.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
        + Tambah Hasil
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Pertandingan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Sport</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Skor</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Lokasi</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($matches as $match)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $match->team_a }} vs {{ $match->team_b }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $match->sport->icon }} {{ $match->sport->name }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-lg">{{ $match->score_a }} - {{ $match->score_b }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $match->tanggal->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $match->lokasi }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.matches.edit', $match) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.matches.destroy', $match) }}" class="inline" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada hasil pertandingan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $matches->links() }}
</div>
@endsection