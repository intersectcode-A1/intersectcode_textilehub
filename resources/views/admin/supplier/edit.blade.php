@extends('components.layouts.admin')

@section('title', 'Edit Supplier')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Edit Supplier</h1>
    <nav class="text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="{{ route('supplier.index') }}" class="text-gray-500 hover:text-gray-700">Supplier</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Edit Supplier</a>
            </li>
        </ol>
    </nav>
</div>

@if($errors->any())
    <div class="mb-6">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg" role="alert">
            <p class="font-semibold">Terjadi Kesalahan</p>
            <ul class="mt-2 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
    <form action="{{ route('supplier.update', $supplier->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="nama" class="block text-base font-medium text-gray-700 dark:text-gray-300">
                Nama Supplier <span class="text-red-500">*</span>
            </label>
            <div class="mt-2">
                <input type="text" name="nama" id="nama" value="{{ old('nama', $supplier->nama) }}" class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200" required>
            </div>
            @error('nama')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="alamat" class="block text-base font-medium text-gray-700 dark:text-gray-300">Alamat</label>
            <div class="mt-2">
                <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $supplier->alamat) }}" class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200">
            </div>
            @error('alamat')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="kontak" class="block text-base font-medium text-gray-700 dark:text-gray-300">
                Kontak <span class="text-red-500">*</span>
            </label>
            <div class="mt-2">
                <input type="text" name="kontak" id="kontak" value="{{ old('kontak', $supplier->kontak) }}" class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200" required>
            </div>
            @error('kontak')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="produk" class="block text-base font-medium text-gray-700 dark:text-gray-300">Produk yang Disediakan</label>
            <div class="mt-2">
                <input type="text" name="produk" id="produk" value="{{ old('produk', $supplier->produk) }}" class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200">
            </div>
            @error('produk')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="harga_modal" class="block text-gray-700 font-bold mb-2">Harga Modal / Satuan</label>
            <div class="mt-2 relative rounded-lg">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <span class="text-gray-400">Rp</span>
                </div>
                <input type="number"
                    name="harga_modal"
                    id="harga_modal"
                    value="{{ old('harga_modal', $supplier->harga_modal ?? '') }}"
                    class="w-full pl-12 pr-4 py-3 rounded-lg bg-gray-100 border-2 border-gray-200 text-gray-800 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200"
                    placeholder="0"
                    min="0"
                    step="1000"
                    required>
            </div>
        </div>
        <div class="mb-4">
            <label for="satuan" class="block text-gray-700 font-bold mb-2">Satuan</label>
            <input type="text"
                name="satuan"
                id="satuan"
                value="{{ old('satuan', $supplier->satuan ?? '') }}"
                class="w-full px-4 py-3 rounded-lg bg-gray-100 border-2 border-gray-200 text-gray-800 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200"
                placeholder="Contoh: Pcs, Lusin, Kg"
                required>
        </div>
        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('deskripsi', $supplier->deskripsi ?? '') }}</textarea>
        </div>

        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('supplier.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
