@extends('components.layouts.admin')

@section('title', 'Pelacakan Barang')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Pelacakan Barang</h1>
    <nav class="text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Pelacakan Barang</a>
            </li>
        </ol>
    </nav>
</div>

    @forelse($trackings as $tracking)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md mb-6">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col md:flex-row justify-between md:items-center">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nomor Resi</p>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">{{ $tracking->resi }}</h3>
                </div>
                <div class="mt-4 md:mt-0 text-left md:text-right">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Status Terkini</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        {{ $tracking->status }}
                    </span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">Penerima: {{ $tracking->nama_penerima }}</p>
        </div>
        
        <div class="p-6">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Riwayat Perjalanan</h4>
            <div class="relative border-l-2 border-gray-200 dark:border-gray-600 ml-3">
                    @foreach($tracking->histories as $history)
                    <div class="mb-8 ml-6">
                        <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-white dark:ring-gray-800 dark:bg-blue-900">
                            <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </span>
                        <h5 class="flex items-center mb-1 text-md font-semibold text-gray-900 dark:text-white">{{ $history->status }}</h5>
                        <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::parse($history->waktu)->format('d M Y, H:i') }}</time>
                        <p class="text-base font-normal text-gray-600 dark:text-gray-300">{{ $history->deskripsi }}</p>
                    </div>
                    @endforeach
            </div>
            </div>
        </div>
    @empty
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada data pelacakan</h3>
        <p class="mt-1 text-sm text-gray-500">Saat ini belum ada data pelacakan barang yang tersedia.</p>
    </div>
    @endforelse
@endsection
