@extends('components.layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Daftar Produk</h1>

    <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Produk</a>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full table-auto bg-white rounded shadow">
        <thead>
            <tr>
                <th class="border px-4 py-2">Nama</th>
                <th class="border px-4 py-2">Harga</th>
                <th class="border px-4 py-2">Stok</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td class="border px-4 py-2">{{ $product->nama }}</td>
                <td class="border px-4 py-2">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                <td class="border px-4 py-2">{{ $product->stok }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 mr-2">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus?')" class="text-red-600">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
