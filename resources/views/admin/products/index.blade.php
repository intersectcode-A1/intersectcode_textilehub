@extends('components.layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Daftar Produk</h1>

    <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Produk</a>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mt-4">
            {{ session('success') }}
        </div>
    @endif

    @if($semuaKosong)
        <div class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded mt-4">
            Stok semua barang kosong atau belum tersedia.
        </div>
    @endif

    <div class="overflow-x-auto mt-6 bg-white dark:bg-gray-800 rounded shadow">
        <table class="table-auto w-full text-left border border-gray-300 dark:border-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700 text-sm uppercase text-gray-600 dark:text-gray-300 text-center">
                <tr>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-3">Foto</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-3">Nama</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-3">Harga</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-3">Stok</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-3">Kategori</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-3">Deskripsi</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="text-center hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                            @if($product->foto)
                                <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}" class="w-16 h-16 object-cover rounded mx-auto">
                            @else
                                <span class="text-gray-400 italic">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                            {{ $product->nama }}
                        </td>
                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </td>
                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                            {{ $product->stok }}
                        </td>
                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                            {{ $product->category->name ?? '-' }}
                        </td>
                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                            {{ $product->deskripsi }}
                        </td>
                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('products.edit', $product) }}">
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                        Edit
                                    </button>
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-6 italic border border-gray-300 dark:border-gray-700">
                            Belum ada produk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links('pagination::tailwind') }}
    </div>
</div>
@endsection
