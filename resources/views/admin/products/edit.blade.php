@extends('components.layouts.dashboard')

@section('content')
<div class="p-6 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-4 text-white">Tambah Produk Baru</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="nama" class="block text-white font-semibold">Nama Produk</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="w-full border border-gray-300 rounded px-3 py-2 text-black bg-white" required>
            @error('nama')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="harga" class="block text-white font-semibold">Harga</label>
            <input type="number" name="harga" id="harga" value="{{ old('harga') }}" class="w-full border border-gray-300 rounded px-3 py-2 text-black bg-white" required>
            @error('harga')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="stok" class="block text-white font-semibold">Stok</label>
            <input type="number" name="stok" id="stok" value="{{ old('stok') }}" class="w-full border border-gray-300 rounded px-3 py-2 text-black bg-white" required>
            @error('stok')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="deskripsi" class="block text-white font-semibold">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="w-full border border-gray-300 rounded px-3 py-2 text-black bg-white">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="foto" class="block text-white font-semibold">Foto Produk</label>
            <input type="file" name="foto" id="foto" class="w-full border border-gray-300 rounded px-3 py-2 text-black bg-white" accept="image/*">
            @error('foto')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
            <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
        </div>
    </form>
</div>
@endsection
