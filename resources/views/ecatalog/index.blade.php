<x-layouts.catalog>
    {{-- Page Header with Breadcrumb --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Breadcrumb --}}
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-blue-100 hover:text-white">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-1 text-blue-100 md:ml-2">E-Catalog</span>
                        </div>
                    </li>
                    @if(request('category'))
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-1 text-white font-medium md:ml-2">
                                    {{ $categories->firstWhere('id', request('category'))->name }}
                                </span>
                            </div>
                        </li>
                    @endif
                </ol>
            </nav>

            {{-- Page Title --}}
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">Katalog Produk</h1>
                <p class="text-blue-100">Temukan produk terbaik untuk kebutuhan Anda</p>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Sidebar --}}
            <div class="lg:w-1/4">
                {{-- Mobile Category Toggle --}}
                <div class="lg:hidden mb-4">
                    <button @click="showMobileCategories = !showMobileCategories"
                            class="w-full flex items-center justify-between px-4 py-2 bg-white rounded-lg shadow">
                        <span class="font-medium text-gray-700">Kategori</span>
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  :d="showMobileCategories ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'"/>
                        </svg>
                    </button>
                </div>

                {{-- Category Navigation --}}
                <div :class="{'hidden': !showMobileCategories}" class="lg:block sticky top-4">
                    <x-category-nav :categories="$categories" :currentCategory="request('category')"/>
                </div>
            </div>

            {{-- Main Content Area --}}
            <div class="lg:w-3/4">
                {{-- Search & Filter Section --}}
                <div x-data="{ showFilters: false }" class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <form method="GET" action="{{ route('ecatalog.index') }}" class="space-y-4">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <input type="text" 
                                       name="search" 
                                       placeholder="Cari produk..." 
                                       value="{{ request('search') }}"
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"/>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" 
                                        @click="showFilters = !showFilters"
                                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                    </svg>
                                    Filter
                                </button>
                                <button type="submit"
                                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Cari
                                </button>
                            </div>
                        </div>

                        {{-- Filter Panel --}}
                        <div x-show="showFilters" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-2"
                             class="border-t border-gray-200 pt-4 mt-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                    <select name="sort" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Rentang Harga</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="number" 
                                               name="min_price" 
                                               placeholder="Min" 
                                               value="{{ request('min_price') }}"
                                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"/>
                                        <input type="number" 
                                               name="max_price" 
                                               placeholder="Max" 
                                               value="{{ request('max_price') }}"
                                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Products Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($products as $product)
                        {{-- Product Card --}}
                        <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                            {{-- Product Image --}}
                            <div class="relative pt-[75%]">
                                @if($product->foto)
                                    <img src="{{ asset('storage/' . $product->foto) }}" 
                                         alt="{{ $product->nama }}"
                                         class="absolute inset-0 w-full h-full object-cover"/>
                                @else
                                    <div class="absolute inset-0 bg-gray-100 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Stock Badge --}}
                                <div class="absolute top-2 right-2">
                                    @if($product->stok > 10)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1 rounded-full">
                                            Stok: {{ $product->stok }}
                                        </span>
                                    @elseif($product->stok > 0)
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-1 rounded-full">
                                            Sisa: {{ $product->stok }}
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-1 rounded-full">
                                            Stok Habis
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Product Info --}}
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->nama }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                                <div class="text-xl font-bold text-green-600 mb-4">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </div>

                                {{-- Action Buttons --}}
                                <div class="grid grid-cols-2 gap-2">
                                    @if($product->stok > 0)
                                        <a href="{{ route('checkout.direct', $product->id) }}"
                                           class="flex items-center justify-center bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                                            Checkout
                                        </a>
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full flex items-center justify-center bg-yellow-500 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-200">
                                                + Keranjang
                                            </button>
                                        </form>
                                    @else
                                        <div class="col-span-2">
                                            <div class="bg-gray-100 text-gray-500 text-sm text-center py-2 rounded-lg">
                                                Stok Tidak Tersedia
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <a href="{{ route('ecatalog.detail', $product->id) }}"
                                   class="block text-center text-blue-600 hover:text-blue-800 text-sm font-medium mt-4">
                                    Lihat Detail
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full flex flex-col items-center justify-center py-12">
                            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-xl text-gray-600 font-medium">Tidak ada produk yang ditemukan</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.catalog>
