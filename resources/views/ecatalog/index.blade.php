<x-layouts.catalog>
    {{-- Page Header with Breadcrumb --}}
    <div class="bg-gradient-to-r from-blue-700 to-blue-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            {{-- Breadcrumb --}}
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-blue-100 hover:text-white transition duration-150">
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
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4 leading-tight">Katalog Produk</h1>
                <p class="text-xl text-blue-100 font-light">Temukan produk terbaik untuk kebutuhan Anda</p>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="mb-8">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg relative" role="alert">
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg relative" role="alert">
                    <span class="block sm:inline font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        {{-- Action Buttons --}}
        <div class="flex flex-wrap justify-end gap-4 mb-12">
            <a href="{{ route('cart.index') }}"
               class="inline-flex items-center justify-center space-x-3 px-6 py-3 bg-yellow-500 rounded-lg shadow-lg text-white font-semibold text-sm hover:bg-yellow-600 transition duration-200 transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Lihat Keranjang</span>
            </a>

            <a href="{{ route('order.status') }}"
               class="inline-flex items-center justify-center space-x-3 px-6 py-3 bg-blue-600 rounded-lg shadow-lg text-white font-semibold text-sm hover:bg-blue-700 transition duration-200 transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span>Status Pemesanan</span>
            </a>

            <a href="{{ route('purchase.history') }}"
               class="inline-flex items-center justify-center space-x-3 px-6 py-3 bg-green-600 rounded-lg shadow-lg text-white font-semibold text-sm hover:bg-green-700 transition duration-200 transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <span>Riwayat Pembelian</span>
            </a>
        </div>

        <div class="flex flex-col lg:flex-row gap-12">
            {{-- Sidebar --}}
            <div class="lg:w-1/4">
                {{-- Mobile Category Toggle --}}
                <div class="lg:hidden mb-6">
                    <button @click="showMobileCategories = !showMobileCategories"
                            class="w-full flex items-center justify-between px-6 py-3 bg-white rounded-lg shadow-md hover:shadow-lg transition duration-200">
                        <span class="font-medium text-gray-800">Kategori</span>
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <div x-data="{ showFilters: false }" class="bg-white rounded-xl shadow-lg p-8 mb-12">
                    <form method="GET" action="{{ route('ecatalog.index') }}" class="space-y-6">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <input type="text" 
                                       name="search" 
                                       placeholder="Cari produk..." 
                                       value="{{ request('search') }}"
                                       class="w-full px-5 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 placeholder-gray-400"/>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" 
                                        @click="showFilters = !showFilters"
                                        class="px-5 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 flex items-center gap-2 transition duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                    </svg>
                                    Filter
                                </button>
                                <button type="submit"
                                        class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2 transition duration-200 shadow-md hover:shadow-lg">
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
                             class="border-t border-gray-200 pt-6 mt-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                                    <select name="sort" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 py-3">
                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Harga</label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <input type="number" 
                                               name="min_price" 
                                               placeholder="Min" 
                                               value="{{ request('min_price') }}"
                                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 py-3"/>
                                        <input type="number" 
                                               name="max_price" 
                                               placeholder="Max" 
                                               value="{{ request('max_price') }}"
                                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 py-3"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Products Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($products as $product)
                        {{-- Product Card --}}
                        <article class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden group">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $product->foto) }}" 
                                     alt="{{ $product->nama }}"
                                     class="w-full h-56 object-cover transform group-hover:scale-105 transition duration-300">
                                <div class="absolute top-3 right-3">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Stok: {{ $product->stok }} {{ $product->satuan }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-6">
                                @if($product->category)
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full mb-3 font-medium">
                                        {{ $product->category->name }}
                                    </span>
                                @endif

                                <h3 class="text-xl font-semibold text-gray-900 mb-2 leading-tight">
                                    {{ $product->nama }}
                                </h3>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                    {{ Str::limit($product->deskripsi, 80) }}
                                </p>

                                <div class="mb-6">
                                    <span class="text-2xl font-bold text-blue-600">
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="text-sm text-gray-500">/{{ $product->satuan }}</span>
                                </div>

                                <div class="space-y-3">
                                    <a href="{{ route('ecatalog.show', $product->id) }}" 
                                       class="btn-secondary w-full flex items-center justify-center">
                                        <i class="fas fa-eye mr-2"></i>
                                        Lihat Detail
                                    </a>

                                    @if($product->stok > 0)
                                        <x-quantity-modal :product="$product" />
                                    @else
                                        <div class="bg-gray-100 text-gray-600 text-sm text-center py-3 rounded-lg font-medium">
                                            Stok Habis
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full text-center py-16">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-6">
                                <i class="fas fa-box-open text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada produk</h3>
                            <p class="text-gray-600">Tidak ada produk yang ditemukan dengan kriteria pencarian ini.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-16">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.catalog>
