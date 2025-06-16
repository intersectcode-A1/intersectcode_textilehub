@extends('components.layouts.admin')

@section('title', 'Edit Harga Produk')

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 p-8 mt-8">
            <h1 class="text-2xl font-bold mb-6 text-white">Edit Harga Produk</h1>
            @if(session('success'))
                <div class="mb-4 p-3 bg-emerald-500/10 border-l-4 border-emerald-500 text-emerald-200 rounded-r-xl">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-4 p-3 bg-rose-500/10 border-l-4 border-rose-500 text-rose-200 rounded-r-xl">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('admin.harga-strategi.update', $product->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-base font-semibold text-gray-300 mb-1">Nama Produk</label>
                    <input type="text" value="{{ $product->nama }}" class="block w-full border-gray-600 rounded-md bg-gray-700/50 text-gray-100 font-medium" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text-base font-semibold text-gray-300 mb-1">Kategori</label>
                    <input type="text" value="{{ $product->category->nama ?? '-' }}" class="block w-full border-gray-600 rounded-md bg-gray-700/50 text-gray-100 font-medium" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text-base font-semibold text-gray-300 mb-1">Harga Lama</label>
                    <div class="flex items-center gap-2">
                        <input type="text" value="Rp {{ number_format($product->harga, 0, ',', '.') }}" class="block w-full border-gray-600 rounded-md bg-gray-700/50 text-indigo-300 font-semibold" readonly>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="harga" class="block text-base font-semibold text-gray-300 mb-1">Harga Baru</label>
                    <input type="number" name="new_price" id="harga" value="{{ old('new_price', $product->harga) }}" maxlength="19" min="0" class="block w-full border-gray-600 rounded-md bg-gray-700/50 text-gray-100 font-medium" required>
                    <small class="text-gray-400">Maksimal 19 digit angka</small>
                    @error('new_price')
                        <div class="text-rose-400 mt-1 text-sm font-semibold">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('admin.harga-strategi.index') }}" class="px-4 py-2 bg-gray-700/50 text-gray-300 rounded-xl border-2 border-gray-600 hover:bg-gray-600/50 transition-all duration-200">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl border-2 border-transparent hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-indigo-500 transition-all duration-200">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 