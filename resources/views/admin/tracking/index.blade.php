@extends('components.layouts.admin')

@section('title', 'Pelacakan Barang')

@section('content')
<div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Status Pelacakan</h2>

    @forelse($trackings as $tracking)
        <div class="mb-6 p-4 border border-gray-300 dark:border-gray-700 rounded">
            <h3 class="text-lg font-semibold">Resi: {{ $tracking->resi }}</h3>
            <p>Penerima: {{ $tracking->nama_penerima }}</p>
            <p>Status Saat Ini: <span class="font-bold text-blue-500">{{ $tracking->status }}</span></p>

            <div class="mt-4">
                <h4 class="font-semibold">Riwayat:</h4>
                <ul class="mt-2 space-y-2">
                    @foreach($tracking->histories as $history)
                        <li class="border-l-4 border-blue-500 pl-4">
                            <p class="text-sm">{{ $history->waktu }} - <span class="font-bold">{{ $history->status }}</span></p>
                            <p class="text-xs text-gray-400">{{ $history->deskripsi }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @empty
        <p class="text-gray-500 italic">Belum ada data pelacakan.</p>
    @endforelse
</div>
@endsection
