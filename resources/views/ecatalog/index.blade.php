<x-layouts.catalog>
    {{-- Header Section --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">Katalog Produk</h1>
            <p class="text-lg text-gray-600 leading-relaxed">Temukan produk terbaik kami di sini</p>
        </div>

        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="mb-6">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        {{-- Action Buttons --}}
        <div class="flex flex-wrap justify-end gap-4 mb-8">
            <a href="{{ route('cart.index') }}"
               class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-yellow-500 rounded-lg shadow-md text-white font-semibold text-sm hover:bg-yellow-600 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Lihat Keranjang</span>
            </a>

            <a href="{{ route('order.status') }}"
               class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-blue-600 rounded-lg shadow-md text-white font-semibold text-sm hover:bg-blue-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span>Status Pemesanan</span>
            </a>

            <a href="{{ route('purchase.history') }}"
               class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-green-600 rounded-lg shadow-md text-white font-semibold text-sm hover:bg-green-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <span>Riwayat Pembelian</span>
            </a>
        </div>

        {{-- Search & Filter Section --}}
        <div class="bg-white rounded-xl shadow-md p-6 mb-8" x-data="{ showFilters: false }">
            <form method="GET" action="{{ route('ecatalog.index') }}">
                {{-- Search Bar and Filter Toggle --}}
                <div class="flex items-center space-x-4">
                    <div class="flex-1">
                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="Cari produk..."
                            class="w-full p-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        />
                    </div>
                    <button
                        type="button"
                        @click="showFilters = !showFilters"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                        <span class="ml-1" x-show="!showFilters">({{ count(array_filter(request()->only(['category', 'sort', 'min_price', 'max_price']))) }})</span>
                    </button>
                    <button
                        type="submit"
                        class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </button>
                </div>

                {{-- Collapsible Filter Section --}}
                <div x-show="showFilters" x-transition:enter="transition ease-out duration-200" 
                     x-transition:enter-start="opacity-0 transform -translate-y-2" 
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="mt-4 border-t border-gray-200 pt-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select
                                name="category"
                                id="category"
                                class="w-full p-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            >
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                            <select
                                name="sort"
                                id="sort"
                                class="w-full p-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            >
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2 lg:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Range Harga</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input
                                    type="number"
                                    name="min_price"
                                    placeholder="Min"
                                    value="{{ request('min_price', $priceRange['min']) }}"
                                    min="{{ $priceRange['min'] }}"
                                    max="{{ $priceRange['max'] }}"
                                    class="w-full p-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                />
                                <input
                                    type="number"
                                    name="max_price"
                                    placeholder="Max"
                                    value="{{ request('max_price', $priceRange['max']) }}"
                                    min="{{ $priceRange['min'] }}"
                                    max="{{ $priceRange['max'] }}"
                                    class="w-full p-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                />
                            </div>
                        </div>
                    </div>

                    {{-- Filter Actions --}}
                    <div class="flex items-center justify-end space-x-4 mt-4">
                        <a href="{{ route('ecatalog.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Reset Filter
                        </a>
                        <button
                            type="submit"
                            class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    {{-- Products Grid --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($products as $product)
                <article class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 flex flex-col overflow-hidden">
                    <div class="relative pt-[75%] bg-gray-100 overflow-hidden">
                        @if($product->foto)
                            <img
                                src="{{ asset('storage/' . $product->foto) }}"
                                alt="{{ $product->nama }}"
                                class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-300"
                                loading="lazy"
                            />
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-6 flex flex-col flex-1">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $product->nama }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">
                            {{ $product->deskripsi ?: 'Tidak ada deskripsi' }}
                        </p>
                        <div class="text-2xl font-bold text-green-600 mb-4">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('checkout.direct', $product->id) }}"
                               class="flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition duration-200">
                                Pesan
                            </a>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition duration-200">
                                    + Keranjang
                                </button>
                            </form>
                        </div>
                        
                        <a href="{{ route('ecatalog.detail', $product->id) }}"
                           class="mt-4 text-center text-blue-600 hover:text-blue-800 text-sm font-medium hover:underline transition duration-200">
                            Lihat Detail
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-12 px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-xl text-gray-600 font-medium">Produk tidak ditemukan</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </section>
</x-layouts.catalog>
