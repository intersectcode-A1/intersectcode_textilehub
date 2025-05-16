@extends('components.layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Produk</h1>

    <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block font-medium">Nama Produk</label>
            <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div>
            <label for="price" class="block font-medium">Harga (Rp)</label>
            <input type="number" name="price" id="price" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div>
            <label for="stock" class="block font-medium">Stok</label>
            <input type="number" name="stock" id="stock" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <button type="submit" class="bg-green-500 text-white px-5 py-2 rounded hover:bg-green-600">Simpan</button>
        <a href="{{ route('products.index') }}" class="ml-3 text-gray-600 hover:underline">Kembali</a>
    </form>
</div>
@endsection
