@extends('components.layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10 p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Laporan Keuangan</h2>

    <form method="POST" action="{{ route('laporan.filter') }}" class="mb-6 space-y-4">
        @csrf
        <div>
            <label class="block font-semibold text-gray-700 dark:text-gray-200">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="border border-gray-600 dark:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 p-2 w-full rounded" required>
        </div>
        <div>
            <label class="block font-semibold text-gray-700 dark:text-gray-200">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" class="border border-gray-600 dark:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 p-2 w-full rounded" required>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">Tampilkan</button>
    </form>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 dark:bg-red-200 dark:text-red-800">{{ $errors->first() }}</div>
    @endif

    @if(isset($laporan))
        @if($laporan->isEmpty())
            <p class="text-gray-500 dark:text-gray-300">⚠️ Tidak ada data dalam rentang waktu yang dipilih.</p>
        @else
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
                <table class="w-full table-auto text-left border border-gray-600 dark:border-gray-500 mt-4">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-sm uppercase text-gray-600 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-3 border border-gray-600 dark:border-gray-500">Tanggal</th>
                            <th class="px-4 py-3 border border-gray-600 dark:border-gray-500">Deskripsi</th>
                            <th class="px-4 py-3 border border-gray-600 dark:border-gray-500">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporan as $item)
                            <tr class="border border-gray-600 dark:border-gray-500">
                                <td class="px-4 py-2 border border-gray-600 dark:border-gray-500">{{ $item->tanggal }}</td>
                                <td class="px-4 py-2 border border-gray-600 dark:border-gray-500">{{ $item->deskripsi }}</td>
                                <td class="px-4 py-2 border border-gray-600 dark:border-gray-500">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif
</div>
@endsection
