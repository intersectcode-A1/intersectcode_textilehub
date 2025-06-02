<x-layouts.catalog>
    {{-- Header --}}
    <div class="mb-14 text-center max-w-3xl mx-auto">
        <h1 class="text-5xl font-extrabold text-gray-900 mb-2 tracking-tight">Katalog Produk</h1>
        <p class="text-gray-600 text-lg leading-relaxed">Temukan produk terbaik kami di sini</p>
    </div>

    {{-- Action Buttons --}}
    <div class="mb-10 flex justify-end space-x-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('cart.index') }}"
           class="inline-flex items-center space-x-2 px-6 py-3 bg-yellow-500 rounded-lg shadow-md text-white font-semibold text-sm hover:bg-yellow-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7H19m-4 6a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span>Lihat Keranjang</span>
        </a>

        <a href="{{ route('order.status') }}"
           class="inline-flex items-center space-x-2 px-6 py-3 bg-green-600 rounded-lg shadow-md text-white font-semibold text-sm hover:bg-green-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2m3-3v2a4 4 0 01-4 4h-2m-3 3H7a2 2 0 00-2 2v1h10v-1a2 2 0 00-2-2z" />
            </svg>
            <span>Status Pemesanan</span>
        </a>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('ecatalog.index') }}" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-4 sm:space-y-0">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari produk..."
                class="flex-grow p-3 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                aria-label="Cari produk"
            />
            <select
                name="category"
                class="w-full sm:w-48 p-3 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                aria-label="Pilih kategori"
            >
                <option value="">Semua Kategori</option>
                @foreach(\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button
                type="submit"
                class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-md shadow-md transition"
            >
                Cari
            </button>
        </div>
    </form>

    {{-- Produk Grid --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
        @forelse($products as $product)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col">
                <div class="relative overflow-hidden rounded-t-xl h-56 bg-gray-100">
                    @if($product->foto)
                        <img
                            src="{{ asset('storage/' . $product->foto) }}"
                            alt="{{ $product->nama }}"
                            class="object-cover w-full h-full transform hover:scale-105 transition-transform duration-300"
                            loading="lazy"
                        />
                    @else
                        <div class="flex items-center justify-center h-full text-gray-400 font-medium text-lg select-none">
                            No Image
                        </div>
                    @endif
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3 leading-snug">{{ $product->nama }}</h3>
                    <p class="text-gray-600 text-sm flex-grow">{{ \Illuminate\Support\Str::limit($product->deskripsi, 90) }}</p>
                    <div class="mt-5 text-xl font-extrabold text-green-700">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </div>
                    <div class="mt-7 flex justify-between items-center">
                        <a href="{{ route('ecatalog.detail', $product->id) }}"
                           class="text-blue-600 font-semibold hover:underline transition text-sm">
                            Lihat Detail
                        </a>
                    </div>
                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('checkout', ['product_name' => $product->nama, 'price' => $product->harga]) }}"
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md py-3 text-center transition">
                            Pesan
                        </a>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1" aria-label="Tambah produk {{ $product->nama }} ke keranjang">
                            @csrf
                            <button
                                type="submit"
                                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md py-3 transition"
                            >
                                + Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500 text-lg mt-20">Produk tidak ditemukan.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
        {{ $products->links() }}
    </div>
</x-layouts.catalog>
