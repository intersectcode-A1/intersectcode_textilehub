@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Laporan Keuangan</h2>

    <form method="POST" action="{{ route('laporan.filter') }}" class="mb-6 space-y-4">
        @csrf
        <div>
            <label class="block font-semibold">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="border p-2 w-full" required>
        </div>
        <div>
            <label class="block font-semibold">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" class="border p-2 w-full" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tampilkan</button>
    </form>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ $errors->first() }}</div>
    @endif

    @if(isset($laporan))
        @if($laporan->isEmpty())
            <p class="text-gray-500">⚠️ Tidak ada data dalam rentang waktu yang dipilih.</p>
        @else
            <table class="w-full table-auto border border-collapse mt-4">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">Tanggal</th>
                        <th class="border px-4 py-2">Deskripsi</th>
                        <th class="border px-4 py-2">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporan as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->tanggal }}</td>
                            <td class="border px-4 py-2">{{ $item->deskripsi }}</td>
                            <td class="border px-4 py-2">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif
</div>
@endsection
