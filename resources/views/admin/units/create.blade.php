@extends('components.layouts.admin')

@section('title', 'Tambah Satuan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Tambah Satuan Baru</h1>
    <nav class="text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="{{ route('units.index') }}" class="text-gray-500 hover:text-gray-700">Manajemen Satuan</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Tambah Satuan</a>
            </li>
        </ol>
    </nav>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <form action="{{ route('units.store') }}" method="POST" class="space-y-6">
            @csrf
                <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Satuan</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                   class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200"
                           placeholder="Contoh: Lusin, Kodi, Meter"
                           required>
                    @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
            <label for="symbol" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Simbol</label>
                    <input type="text" 
                           name="symbol" 
                           id="symbol" 
                           value="{{ old('symbol') }}"
                   class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200"
                           placeholder="Contoh: Lsn, Kd, m"
                           required>
                    @error('symbol')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" 
                              id="description" 
                      rows="4"
                      class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200"
                              placeholder="Deskripsi tambahan tentang satuan ini">{{ old('description') }}</textarea>
                    @error('description')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

        <div class="flex justify-end pt-4">
            <a href="{{ route('units.index') }}" class="px-6 py-3 mr-4 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition-all duration-200">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200">
                        Simpan Satuan
                    </button>
            </div>
        </form>
</div>
@endsection 