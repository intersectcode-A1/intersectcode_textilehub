@extends('components.layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="mb-4 sm:mb-6">
    <h1 class="text-2xl font-extrabold text-blue-900 dark:text-blue-200 mb-2">Edit Kategori</h1>
    <nav class="text-xs sm:text-sm font-medium text-blue-700 dark:text-blue-300 bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-blue-900 dark:to-indigo-900 rounded-xl px-4 py-2 shadow mb-2 inline-block glass">
        <ol class="list-none p-0 inline-flex flex-wrap">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-700">Kategori</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Edit Kategori</a>
            </li>
        </ol>
    </nav>
</div>

@if($errors->any())
    <div class="mb-4 sm:mb-6">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 sm:p-4 rounded-r-lg" role="alert">
            <p class="font-semibold text-sm sm:text-base">Terjadi Kesalahan</p>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="bg-white/70 dark:bg-gray-800/80 glass rounded-2xl shadow-2xl p-8 border border-white/20 dark:border-gray-700">
    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block text-base font-bold text-blue-900 dark:text-blue-200 mb-1">
                Nama Kategori <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                class="w-full px-4 py-3 rounded-xl bg-white/60 dark:bg-gray-900 border-2 border-blue-100 dark:border-gray-700 text-blue-900 dark:text-blue-100 placeholder-blue-300 dark:placeholder-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-all duration-200 shadow-sm"
                required placeholder="Masukkan nama kategori">
            @error('name')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex flex-col sm:flex-row justify-end gap-4 pt-8 border-t-2 border-blue-100 dark:border-blue-900 mt-8">
            <a href="{{ route('categories.index') }}" class="px-6 py-3 bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-700 transition-all duration-200 text-base font-bold text-center">Batal</a>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400 text-base">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
