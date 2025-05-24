<x-layouts.catalog>
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-3">Katalog Produk</h1>
        <p class="text-gray-500 text-lg">Temukan produk terbaik kami di sini</p>
    </div>

    <form class="mb-6" method="GET" action="{{ route('ecatalog.index') }}">
        <div class="flex flex-col md:flex-row items-center gap-4">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari produk..."
                class="p-3 rounded-lg border border-gray-300 flex-1 focus:ring-2 focus:ring-blue-500"
            />
            <select name="category" class="p-3 rounded-lg border border-gray-300">
                <option value="">Semua Kategori</option>
                @foreach(\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->nama }}
                    </option>
                @endforeach
            </select>
            <button
                type="submit"
                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition"
            >
                Cari
            </button>
        </div>
    </form>

    {{-- Tombol ke Status Pemesanan User --}}
    <div class="mb-8 text-right">
        <a href="{{ route('order.status') }}"
           class="inline-block bg-green-600 text-white px-5 py-3 rounded-lg hover:bg-green-700 transition text-sm font-semibold"
        >
            🧾 Lihat Status Pemesanan Saya
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @forelse($products as $product)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 flex flex-col">
                <div class="overflow-hidden">
                    @if($product->foto)
                        <img
                            src="{{ asset('storage/' . $product->foto) }}"
                            alt="{{ $product->nama }}"
                            class="w-full h-56 object-cover transform transition-transform duration-300 hover:scale-105"
                        >
                    @else
                        <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                            No Image
                        </div>
                    @endif
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <h3 class="text-xl font-semibold text-gray-800 mb-1">{{ $product->nama }}</h3>
                    <p class="text-gray-600 text-sm mb-2 flex-1">
                        {{ \Illuminate\Support\Str::limit($product->deskripsi, 80) }}
                    </p>
                    <div class="text-lg font-bold text-green-600 mb-4">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </div>
                    <div class="flex justify-between gap-2 mt-auto">
                        <a
                            href="{{ route('ecatalog.detail', $product->id) }}"
                            class="text-sm text-blue-600 font-semibold hover:underline"
                        >
                            Lihat Detail
                        </a>
                        <form method="POST" action="{{ route('checkout') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="product_name" value="{{ $product->nama }}">
                            <input type="hidden" name="price" value="{{ $product->harga }}">
                            <button
                                type="submit"
                                class="text-sm bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition"
                            >
                                Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">Produk tidak ditemukan.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</x-layouts.catalog>
