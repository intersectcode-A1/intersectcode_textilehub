@extends('components.layouts.admin')

@section('title', 'Manajemen Supplier')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Supplier</h1>
    <nav class="text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="#" class="text-gray-500 hover:text-gray-700">Supplier</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Daftar Supplier</a>
            </li>
        </ol>
    </nav>
</div>

<div class="flex justify-between items-center mb-6">
    <p class="text-lg text-gray-600 dark:text-gray-400">Kelola semua data supplier.</p>
    <a href="{{ route('supplier.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-base font-medium rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Tambah Supplier
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-8">
    <form action="{{ route('supplier.index') }}" method="GET">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" placeholder="Cari nama, alamat, atau produk supplier..." value="{{ request('search') }}"
                        class="pl-12 w-full px-4 py-3 rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition-all duration-200" />
                    <i data-lucide="search" class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit"
                    class="px-8 py-3 bg-blue-600 text-white text-base font-medium rounded-lg border border-transparent hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    Cari
                </button>
            </div>
        </div>
    </form>
</div>

@if(request('search') && $suppliers->isEmpty())
    <div class="mb-6 text-center text-red-600 font-semibold">
        Data tidak dapat ditemukan.
    </div>
@endif

    @if(session('success'))
    <div class="mb-6 animate-fade-in-down">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg" role="alert">
            <p class="font-medium">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
        </div>
    @endif

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs md:text-sm">
        <thead class="bg-gray-50 dark:bg-gray-700/50">
            <tr>
                <th scope="col" class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                <th scope="col" class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                <th scope="col" class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider max-w-[120px] truncate">Alamat</th>
                <th scope="col" class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kontak</th>
                <th scope="col" class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk</th>
                <th scope="col" class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga Modal</th>
                <th scope="col" class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider max-w-[120px] truncate">Deskripsi</th>
                <th scope="col" class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Satuan</th>
                <th scope="col" class="px-3 py-2 text-right font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($suppliers as $supplier)
                <tr>
                    <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-gray-500 dark:text-gray-300">{{ $supplier->nama }}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-gray-500 dark:text-gray-300 max-w-[120px] truncate" title="{{ $supplier->alamat }}">{{ $supplier->alamat }}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-gray-500 dark:text-gray-300">{{ $supplier->kontak }}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-gray-500 dark:text-gray-300">{{ $supplier->produk }}</td>
                    <td class="px-3 py-2 whitespace-nowrap">Rp {{ number_format($supplier->harga_modal, 2, ',', '.') }}</td>
                    <td class="px-3 py-2 whitespace-nowrap max-w-[120px] truncate" title="{{ $supplier->deskripsi }}">{{ $supplier->deskripsi }}</td>
                    <td class="px-3 py-2 whitespace-nowrap">{{ $supplier->satuan }}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('supplier.edit', $supplier) }}" class="p-2 text-gray-500 hover:text-blue-600 bg-gray-100 hover:bg-blue-100 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"/>
                                </svg>
                            </a>
                            <form action="{{ route('supplier.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-500 hover:text-red-600 bg-gray-100 hover:bg-red-100 rounded-lg transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-12">
                        <div class="text-gray-500 dark:text-gray-400">
                             <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-800 dark:text-white">Tidak ada supplier</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan data supplier baru.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
