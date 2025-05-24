@extends('components.layouts.dashboard')

@section('content')
<div class="p-6 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-4 text-white">Tambah Supplier Baru</h1>

    <form action="{{ route('supplier.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="nama" class="block text-white font-semibold">Nama Supplier</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="w-full border border-gray-300 rounded px-3 py-2 text-black bg-white" required>
            @error('nama')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="alamat" class="block text-white font-semibold">Alamat</label>
            <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" class="w-full border border-gray-300 rounded px-3 py-2 text-black bg-white" required>
            @error('alamat')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="kontak" class="block text-white font-semibold">Kontak</label>
            <input type="text" name="kontak" id="kontak" value="{{ old('kontak') }}" class="w-full border border-gray-300 rounded px-3 py-2 text-black bg-white" required>
            @error('kontak')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="produk" class="block text-white font-semibold">Produk yang Disediakan</label>
            <input type="text" name="produk" id="produk" value="{{ old('produk') }}" class="w-full border border-gray-300 rounded px-3 py-2 text-black bg-white" required>
            @error('produk')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
            <a href="{{ route('supplier.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
        </div>
    </form>
</div>
@endsection
