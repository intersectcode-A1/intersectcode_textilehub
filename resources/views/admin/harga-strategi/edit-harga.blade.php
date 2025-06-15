@extends('components.layouts.admin')

@section('title', 'Edit Harga Produk')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-sm p-8 mt-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-900">Edit Harga Produk</h1>
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('admin.harga-strategi.update', $product->id) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-base font-semibold text-gray-900 mb-1">Nama Produk</label>
                <input type="text" value="{{ $product->nama }}" class="block w-full border-gray-300 rounded-md bg-gray-100 text-gray-900 font-medium" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-base font-semibold text-gray-900 mb-1">Kategori</label>
                <input type="text" value="{{ $product->category->nama ?? '-' }}" class="block w-full border-gray-300 rounded-md bg-gray-100 text-gray-900 font-medium" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-base font-semibold text-gray-900 mb-1">Harga Lama</label>
                <input type="text" value="Rp {{ number_format($product->harga, 0, ',', '.') }}" class="block w-full border-gray-300 rounded-md bg-gray-100 text-gray-900 font-medium" readonly>
            </div>
            <div class="mb-4">
                <label for="harga" class="block text-base font-semibold text-gray-900 mb-1">Harga Baru</label>
                <input type="number" name="new_price" id="harga" value="{{ old('new_price', $product->harga) }}" maxlength="19" min="0" class="block w-full border-gray-300 rounded-md text-gray-900 font-medium" required>
                <small class="text-gray-500">Maksimal 19 digit angka</small>
                @error('new_price')
                    <div class="text-red-600 mt-1 text-sm font-semibold">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.harga-strategi.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection 