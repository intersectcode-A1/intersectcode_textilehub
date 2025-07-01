<x-layouts.catalog>
    {{-- Hero Section dengan Background Modern --}}
    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 bg-black opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            {{-- Breadcrumb Navigation --}}
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 md:space-x-4">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-blue-200 hover:text-white transition duration-200 group">
                            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            <span class="text-sm font-medium">Beranda</span>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-300 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-blue-100 text-sm font-medium">E-Catalog</span>
                        </div>
                    </li>
                    @if(request('category'))
                        <li>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-300 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-white text-sm font-semibold">
                                    {{ request('category') }}
                                </span>
                            </div>
                        </li>
                    @endif
                </ol>
            </nav>
            {{-- Hero Content --}}
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                    Katalog <span class="text-blue-300">Produk</span>
                </h1>
                <p class="text-xl sm:text-2xl text-blue-100 font-light mb-8 leading-relaxed">
                    Temukan produk berkualitas tinggi untuk memenuhi kebutuhan bisnis Anda
                </p>
                {{-- Quick Stats --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-2xl mx-auto">
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4 border border-white border-opacity-20">
                        <div class="text-2xl font-bold text-white">{{ $products->total() ?? 0 }}</div>
                        <div class="text-blue-200 text-sm">Total Produk</div>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4 border border-white border-opacity-20">
                        <div class="text-2xl font-bold text-white">{{ $categories->count() ?? 0 }}</div>
                        <div class="text-blue-200 text-sm">Kategori</div>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4 border border-white border-opacity-20">
                        <div class="text-2xl font-bold text-white">24/7</div>
                        <div class="text-blue-200 text-sm">Layanan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Main Content Section --}}
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="mb-8">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-xl shadow-lg relative" role="alert">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-8">
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-xl shadow-lg relative" role="alert">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                </div>
            @endif
            {{-- Action Buttons --}}
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <a href="{{ route('cart.index') }}"
                   class="group inline-flex items-center justify-center space-x-3 px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl shadow-xl text-white font-semibold text-sm hover:from-yellow-600 hover:to-orange-600 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Lihat Keranjang</span>
                </a>
                <a href="{{ route('order.status') }}"
                   class="group inline-flex items-center justify-center space-x-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-xl text-white font-semibold text-sm hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>Status Pemesanan</span>
                </a>
                <a href="{{ route('purchase.history') }}"
                   class="group inline-flex items-center justify-center space-x-3 px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl shadow-xl text-white font-semibold text-sm hover:from-green-700 hover:to-emerald-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <span>Riwayat Pembelian</span>
                </a>
            </div>
            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Sidebar Categories --}}
                <div class="lg:w-1/4">
                    {{-- Mobile Category Toggle (hanya tampil di mobile) --}}
                    <div class="lg:hidden mb-6">
                        <button @click="showMobileCategories = !showMobileCategories"
                                class="w-full flex items-center justify-between px-6 py-4 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                            <span class="font-semibold text-gray-800">Pilih Kategori</span>
                            <svg class="w-5 h-5 text-gray-600 transition-transform duration-200" 
                                 :class="{'rotate-180': showMobileCategories}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </div>
                    {{-- Category Navigation --}}
                    <div :class="{'hidden': !showMobileCategories}" class="lg:block">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <x-category-nav :categories="$categories" :currentCategory="request('category')"/>
                        </div>
                    </div>
                </div>
                {{-- Main Content Area --}}
                <div class="lg:w-3/4">
                    {{-- Search & Filter Section --}}
                    <div x-data="{ showFilters: false }" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-8">
                        <form method="GET" action="{{ route('ecatalog.index') }}" class="space-y-6">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="flex-1 relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="search" 
                                           placeholder="Cari produk yang Anda butuhkan..." 
                                           value="{{ request('search') }}"
                                           class="w-full pl-12 pr-4 py-4 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 placeholder-gray-400 transition-all duration-200"/>
                                </div>
                                <div class="flex gap-3">
                                    <button type="button" 
                                            @click="showFilters = !showFilters"
                                            class="px-6 py-4 bg-gray-50 text-gray-700 rounded-xl hover:bg-gray-100 flex items-center gap-2 transition-all duration-200 border border-gray-200 hover:border-gray-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                        </svg>
                                        <span class="font-medium">Filter</span>
                                    </button>
                                    <button type="submit"
                                            class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 flex items-center gap-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        <span class="font-semibold">Cari</span>
                                    </button>
                                </div>
                            </div>
                            {{-- Filter Panel --}}
                            <div x-show="showFilters" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-4"
                                 class="border-t border-gray-200 pt-6 mt-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Urutkan Berdasarkan</label>
                                        <select name="sort" class="w-full rounded-xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 py-3 px-4 transition-all duration-200">
                                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>🕒 Terbaru</option>
                                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>💰 Harga Terendah</option>
                                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>💎 Harga Tertinggi</option>
                                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>📝 Nama (A-Z)</option>
                                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>📝 Nama (Z-A)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Rentang Harga</label>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="relative">
                                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                                                <input type="number" 
                                                       name="min_price" 
                                                       placeholder="Min" 
                                                       value="{{ request('min_price') }}"
                                                       class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"/>
                                            </div>
                                            <div class="relative">
                                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                                                <input type="number" 
                                                       name="max_price" 
                                                       placeholder="Max" 
                                                       value="{{ request('max_price') }}"
                                                       class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- Products Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($products as $product)
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
                                        <div x-data="{ 
                                            selectedVariants: {},
                                            additionalPrice: 0,
                                            updatePrice() {
                                                this.additionalPrice = Object.values(this.selectedVariants)
                                                    .reduce((sum, variant) => sum + parseFloat(variant.additional_price), 0);
                                            }
                                        }">
                                            <span class="text-2xl font-bold text-blue-600">
                                                Rp <span x-text="({{ $product->harga }} + additionalPrice).toLocaleString('id-ID')"></span>
                                            </span>
                                            <span class="text-sm text-gray-500">/{{ $product->satuan }}</span>
                                            @if($product->variants->isNotEmpty())
                                                <div class="mt-2 space-y-2">
                                                    @foreach($product->variants->groupBy('type') as $type => $variants)
                                                        <div class="flex flex-wrap gap-2">
                                                            @foreach($variants as $variant)
                                                                <button type="button"
                                                                        @click="
                                                                            if (selectedVariants['{{ $type }}']?.id === {{ $variant->id }}) {
                                                                                delete selectedVariants['{{ $type }}'];
                                                                            } else {
                                                                                selectedVariants['{{ $type }}'] = {
                                                                                    id: {{ $variant->id }},
                                                                                    name: '{{ $variant->name }}',
                                                                                    additional_price: {{ $variant->additional_price }}
                                                                                };
                                                                            }
                                                                            updatePrice();
                                                                        "
                                                                        :class="{
                                                                            'ring-2 ring-blue-500 border-blue-300 bg-blue-50': selectedVariants['{{ $type }}']?.id === {{ $variant->id }},
                                                                            'hover:border-blue-400 hover:bg-gray-50': selectedVariants['{{ $type }}']?.id !== {{ $variant->id }}
                                                                        }"
                                                                        class="px-2 py-1 text-xs border rounded-lg transition-all duration-200">
                                                                    {{ $variant->name }}
                                                                    @if($variant->additional_price > 0)
                                                                        <span class="text-green-600">+{{ number_format($variant->additional_price, 0, ',', '.') }}</span>
                                                                    @endif
                                                                </button>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
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
                    @if($products->hasPages())
                        <div class="mt-16">
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                                {{ $products->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.catalog>
