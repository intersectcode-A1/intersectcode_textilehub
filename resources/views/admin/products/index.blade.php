@extends('components.layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4 text-white">Daftar Produk</h1>

    <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">+ Tambah Produk</a>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mt-4">
            {{ session('success') }}
        </div>
    @endif

    @if($semuaKosong)
        <div class="bg-yellow-500 text-white p-3 rounded mt-4">
            Stok semua barang kosong atau belum tersedia.
        </div>
    @endif

    <div class="overflow-x-auto mt-6">
        <table class="table-auto w-full border-collapse border border-gray-700 text-white">
            <thead>
                <tr class="bg-gray-800">
                    <th class="border border-gray-700 px-4 py-2">Foto</th>
                    <th class="border border-gray-700 px-4 py-2">Nama</th>
                    <th class="border border-gray-700 px-4 py-2">Harga</th>
                    <th class="border border-gray-700 px-4 py-2">Stock</th>
                    <th class="border border-gray-700 px-4 py-2">Kategori</th>
                    <th class="border border-gray-700 px-4 py-2">Deskripsi</th>
                    <th class="border border-gray-700 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="hover:bg-gray-700">
                        <td class="border border-gray-700 px-4 py-2">
                            @if($product->foto)
                                <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}" class="w-20 h-20 object-cover rounded">
                            @else
                                <span class="text-gray-400 italic">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="border border-gray-700 px-4 py-2">{{ $product->nama }}</td>
                        <td class="border border-gray-700 px-4 py-2">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $product->stock }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $product->kategori }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $product->deskripsi }}</td>
                        <td class="border border-gray-700 px-4 py-2">
                            <div class="flex gap-2">
                                <a href="{{ route('products.edit', $product) }}">
                                    <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                        Edit
                                    </button>
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-400 py-6 italic">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 text-white">
        {{ $products->links('pagination::tailwind') }}
    </div>
</div>
@endsection
