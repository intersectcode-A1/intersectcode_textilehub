@extends('components.layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-900 py-8" x-data="{ showFilters: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white">Manajemen Produk</h1>
                <p class="mt-2 text-lg text-gray-400">Kelola semua produk dalam satu tempat</p>
            </div>
            <a href="{{ route('products.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white text-base font-medium rounded-xl border-2 border-transparent hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-indigo-500 transition-all duration-200 shadow-sm">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Produk
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 animate-fade-in-down">
                <div class="bg-emerald-500/10 border-l-4 border-emerald-500 text-emerald-200 p-4 rounded-r-xl" role="alert">
                    <p class="font-medium text-base">Sukses!</p>
                    <p class="mt-1">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Filter dan Pencarian -->
        <div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 p-8 mb-8">
            <form action="{{ route('products.index') }}" method="GET">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   placeholder="Cari nama produk..." 
                                   value="{{ request('search') }}"
                                   class="pl-12 w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200"/>
                            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" 
                                @click="showFilters = !showFilters"
                                class="px-6 py-3 bg-gray-700/50 text-gray-300 rounded-xl border-2 border-gray-600 hover:bg-gray-600/50 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            <span x-text="showFilters ? 'Tutup Filter' : 'Tampilkan Filter'"></span>
                        </button>
                        <button type="submit" 
                                class="px-6 py-3 bg-indigo-600 text-white text-base font-medium rounded-xl border-2 border-transparent hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-indigo-500 transition-all duration-200">
                            <svg class="w-5 h-5 inline-block mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Cari
                        </button>
                    </div>
                </div>

                <!-- Panel Filter -->
                <div x-show="showFilters" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="border-t border-gray-600 pt-6 mt-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="category" class="block text-base font-medium text-gray-300 mb-2">Kategori</label>
                            <select name="category" 
                                    id="category" 
                                    class="w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="sort" class="block text-base font-medium text-gray-300 mb-2">Urutkan</label>
                            <select name="sort" 
                                    id="sort" 
                                    class="w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200">
                                <option value="">Urutan Default</option>
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="stock_low" {{ request('sort') == 'stock_low' ? 'selected' : '' }}>Stok Terendah</option>
                                <option value="stock_high" {{ request('sort') == 'stock_high' ? 'selected' : '' }}>Stok Tertinggi</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if($semuaKosong)
            <div class="mb-8 animate-fade-in-down">
                <div class="bg-amber-500/10 border-l-4 border-amber-500 text-amber-200 p-4 rounded-r-xl" role="alert">
                    <p class="font-medium text-base">Perhatian!</p>
                    <p class="mt-1">Stok semua barang kosong atau belum tersedia.</p>
                </div>
            </div>
        @endif

        <div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead>
                        <tr class="bg-gray-900/50">
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider w-[100px]">Foto</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Info Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Stok & Varian</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-400 uppercase tracking-wider w-[150px]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-700/50 transition-all duration-200">
                                <!-- Foto -->
                                <td class="px-6 py-4">
                                    @if($product->foto)
                                        <img src="{{ asset('storage/' . $product->foto) }}" 
                                             alt="{{ $product->nama }}" 
                                             class="w-20 h-20 object-cover rounded-xl shadow-sm ring-2 ring-gray-700">
                                    @else
                                        <div class="w-20 h-20 bg-gray-700/50 rounded-xl flex items-center justify-center ring-2 ring-gray-600">
                                            <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </td>

                                <!-- Info Produk -->
                                <td class="px-6 py-4">
                                    <div class="space-y-2">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-200">{{ $product->nama }}</h3>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="text-gray-400">Kategori:</span>
                                                <span class="px-2.5 py-0.5 rounded-full text-sm bg-gray-700/50 text-gray-300">
                                                    {{ $product->category->name ?? 'Tanpa Kategori' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div>
                                                <span class="text-gray-400 text-sm">Harga:</span>
                                                <span class="text-lg font-medium text-indigo-300 ml-1">
                                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                                </span>
                                            </div>
                                            <div>
                                                <span class="text-gray-400 text-sm">Satuan:</span>
                                                <span class="text-gray-300 ml-1">{{ $product->satuan }}</span>
                                            </div>
                                        </div>
                                        @if($product->deskripsi)
                                            <div class="text-sm text-gray-400 max-w-xl">
                                                {{ Str::limit($product->deskripsi, 100) }}
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Stok & Varian -->
                                <td class="px-6 py-4">
                                    <div class="space-y-3">
                                        <!-- Stok -->
                                        <div>
                                            <span class="text-gray-400 text-sm">Stok Utama:</span>
                                            <span class="px-4 py-1.5 ml-2 inline-flex text-sm leading-5 font-medium rounded-full {{ $product->stok > 0 ? 'bg-emerald-500/10 text-emerald-300' : 'bg-rose-500/10 text-rose-300' }}">
                                                {{ $product->stok }}
                                            </span>
                                        </div>

                                        <!-- Varian -->
                                        <div>
                                            <span class="text-gray-400 text-sm block mb-2">Varian Produk:</span>
                                            @if($product->variants && $product->variants->count() > 0)
                                                <div x-data="{ open: false }" class="relative">
                                                    <button @click="open = !open" 
                                                            class="inline-flex items-center px-3 py-1.5 bg-gray-700/50 text-gray-300 rounded-lg hover:bg-gray-600/50 transition-all duration-200">
                                                        <span class="text-sm font-medium mr-2">{{ $product->variants->count() }} Varian</span>
                                                        <svg class="w-4 h-4 transition-transform duration-200" 
                                                             :class="{'rotate-180': open}"
                                                             fill="none" 
                                                             stroke="currentColor" 
                                                             viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                        </svg>
                                                    </button>
                                                    
                                                    <!-- Dropdown Panel -->
                                                    <div x-show="open"
                                                         x-transition:enter="transition ease-out duration-100"
                                                         x-transition:enter-start="transform opacity-0 scale-95"
                                                         x-transition:enter-end="transform opacity-100 scale-100"
                                                         x-transition:leave="transition ease-in duration-75"
                                                         x-transition:leave-start="transform opacity-100 scale-100"
                                                         x-transition:leave-end="transform opacity-0 scale-95"
                                                         @click.away="open = false"
                                                         class="absolute left-0 z-50 mt-2 w-72 rounded-xl shadow-lg bg-gray-800 border-2 border-gray-700 divide-y divide-gray-700">
                                                        <div class="py-2 max-h-60 overflow-y-auto">
                                                            @foreach($product->variants as $variant)
                                                                <div class="px-4 py-3 hover:bg-gray-700/50 transition-colors duration-150">
                                                                    <div class="flex items-center justify-between">
                                                                        <div class="flex items-center space-x-3">
                                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $variant->type === 'color' ? 'bg-purple-500/10 text-purple-300' : 'bg-blue-500/10 text-blue-300' }}">
                                                                                {{ $variant->type === 'color' ? 'Warna' : 'Ukuran' }}
                                                                            </span>
                                                                            <span class="text-gray-300 font-medium">{{ $variant->name }}</span>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <div class="text-sm text-gray-300">Stok: {{ $variant->stock }}</div>
                                                                            @if($variant->additional_price > 0)
                                                                                <div class="text-xs text-indigo-300">+Rp {{ number_format($variant->additional_price, 0, ',', '.') }}</div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1.5 bg-gray-700/30 text-gray-400 text-sm rounded-lg">
                                                    Tidak ada varian
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex flex-col space-y-2">
                                        <a href="{{ route('products.edit', $product) }}" 
                                           class="inline-flex items-center justify-center px-4 py-2 bg-indigo-500/10 text-indigo-300 hover:bg-indigo-500/20 rounded-xl transition-all duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" 
                                              method="POST" 
                                              class="inline-block"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center justify-center w-full px-4 py-2 bg-rose-500/10 text-rose-300 hover:bg-rose-500/20 rounded-xl transition-all duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center py-12">
                                        <svg class="w-20 h-20 text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <p class="text-2xl font-medium text-gray-200 mb-2">Tidak ada produk yang tersedia</p>
                                        <p class="text-lg text-gray-400">Silakan tambahkan produk baru untuk memulai</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
