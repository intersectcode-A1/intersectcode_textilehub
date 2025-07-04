@extends('components.layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white">Kategori</h1>
    <nav class="text-xs sm:text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex flex-wrap">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="#" class="text-gray-500 hover:text-gray-700">Kategori</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Daftar Kategori</a>
            </li>
        </ol>
    </nav>
</div>

<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-2 sm:mb-6 gap-2 sm:gap-3">
    <p class="text-xs sm:text-lg text-gray-600 dark:text-gray-400">Kelola semua kategori produk Anda.</p>
    <a href="{{ route('categories.create') }}" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-blue-600 text-white text-xs sm:text-base font-medium rounded-lg sm:rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm w-full sm:w-auto justify-center">
        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Tambah Kategori
    </a>
</div>

@if(session('success'))
    <div class="mb-4 sm:mb-6 animate-fade-in-down">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 sm:p-4 rounded-r-lg" role="alert">
            <p class="font-medium text-sm sm:text-base">Sukses!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    </div>
@endif

<div class="bg-gradient-to-r from-blue-400 to-blue-200 rounded-t-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-blue-200 text-xs sm:text-sm">
            <thead class="bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-blue-900 dark:to-indigo-900 border-b-2 border-blue-200 dark:border-blue-700">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">NO</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">NAMA KATEGORI</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">AKSI</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-blue-100">
                @forelse ($categories as $index => $category)
                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-block px-3 py-1 rounded-full bg-gradient-to-r from-blue-400 to-blue-300 text-white font-bold shadow">{{ $index + 1 }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-normal break-all">
                            <span class="font-semibold text-gray-800">{{ $category->name }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex flex-row items-center justify-end space-x-2">
                                <a href="{{ route('categories.edit', $category->id) }}" class="p-2 bg-blue-100 hover:bg-blue-400 text-blue-600 hover:text-white rounded-full shadow transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-100 hover:bg-red-400 text-red-600 hover:text-white rounded-full shadow transition-all duration-200">
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
                        <td colspan="3" class="text-center py-8 sm:py-12">
                            <div class="text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm sm:text-base font-medium text-gray-800 dark:text-white">Tidak ada kategori</h3>
                                <p class="mt-1 text-xs sm:text-sm text-gray-500">Mulai dengan menambahkan kategori baru.</p>
                                <div class="mt-4 sm:mt-6">
                                    <a href="{{ route('categories.create') }}" class="inline-flex items-center px-3 sm:px-4 py-2 border border-transparent shadow-sm text-xs sm:text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Tambah Kategori
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($categories->hasPages())
        <div class="p-3 sm:p-6 bg-white border-t border-blue-200">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
