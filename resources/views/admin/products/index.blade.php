@extends('components.layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Produk</h1>
    <nav class="text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="#" class="text-gray-500 hover:text-gray-700">Produk</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Daftar Produk</a>
            </li>
        </ol>
    </nav>
</div>
<div x-data="{ showFilters: false }">
        <div class="flex items-center justify-between mb-8">
        <p class="text-lg text-gray-600 dark:text-gray-400">Kelola semua produk dalam satu tempat.</p>
            <a href="{{ route('products.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-base font-medium rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Produk
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 animate-fade-in-down">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg" role="alert">
                <p class="font-medium">Sukses!</p>
                <p>{{ session('success') }}</p>
            </div>
            </div>
        @endif

        <!-- Filter dan Pencarian -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
            <form action="{{ route('products.index') }}" method="GET">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   placeholder="Cari nama produk..." 
                                   value="{{ request('search') }}"
                               class="pl-12 w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200"/>
                            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" 
                                @click="showFilters = !showFilters"
                            class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                        <span x-text="showFilters ? 'Tutup Filter' : 'Buka Filter'"></span>
                        </button>
                        <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white text-base font-medium rounded-lg border-2 border-transparent hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
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
                 class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                        <label for="category" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                            <select name="category" 
                                    id="category" 
                                class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                        <label for="sort" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Urutkan</label>
                            <select name="sort" 
                                    id="sort" 
                                class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200">
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
                                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">{{ $product->nama }}</h3>
                                            <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-gray-500 dark:text-gray-400">Kategori:</span>
                                            <span class="px-2.5 py-0.5 rounded-full text-sm bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                                    {{ $product->category->name ?? 'Tanpa Kategori' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div>
                                            <span class="text-gray-500 dark:text-gray-400 text-sm">Harga:</span>
                                            <span class="text-lg font-medium text-blue-600 dark:text-blue-400 ml-1">
                                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                                </span>
                                            </div>
                                            <div>
                                            <span class="text-gray-500 dark:text-gray-400 text-sm">Satuan:</span>
                                            <span class="text-gray-700 dark:text-gray-300 ml-1">{{ $product->satuan }}</span>
                                        </div>
                                        </div>
                                        @if($product->deskripsi)
                                        <div class="text-sm text-gray-500 dark:text-gray-400 max-w-xl">
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
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">Stok Utama:</span>
                                        <span class="px-4 py-1.5 ml-2 inline-flex text-sm leading-5 font-medium rounded-full {{ $product->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $product->stok }}
                                            </span>
                                        </div>

                                        <!-- Varian -->
                                        <div>
                                        <span class="text-gray-500 dark:text-gray-400 text-sm block mb-2">Varian Produk:</span>
                                            @if($product->variants && $product->variants->count() > 0)
                                                <div x-data="{ open: false }" class="relative">
                                                    <button @click="open = !open" 
                                                        class="inline-flex items-center px-3 py-1.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-200">
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
                                                     class="absolute left-0 z-50 mt-2 w-72 rounded-xl shadow-lg bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
                                                        <div class="py-2 max-h-60 overflow-y-auto">
                                                            @foreach($product->variants as $variant)
                                                            <div class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                                                                    <div class="flex items-center justify-between">
                                                                        <div class="flex items-center space-x-3">
                                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $variant->type === 'color' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                                                {{ $variant->type === 'color' ? 'Warna' : 'Ukuran' }}
                                                                            </span>
                                                                        <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $variant->name }}</span>
                                                                        </div>
                                                                        <div class="text-right">
                                                                        <div class="text-sm text-gray-600 dark:text-gray-300">Stok: {{ $variant->stock }}</div>
                                                                            @if($variant->additional_price > 0)
                                                                            <div class="text-xs text-blue-600 dark:text-blue-400">+Rp {{ number_format($variant->additional_price, 0, ',', '.') }}</div>
                                                                            @endif
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                    </div>
                                                    </div>
                                                </div>
                                            @else
                                            <span class="inline-flex items-center px-3 py-1.5 bg-gray-100 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 text-sm rounded-lg">
                                                    Tidak ada varian
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('products.edit', $product) }}" 
                                       class="p-2 text-gray-500 hover:text-blue-600 bg-gray-100 hover:bg-blue-100 rounded-lg transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"/>
                                            </svg>
                                        </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="p-2 text-gray-500 hover:text-red-600 bg-gray-100 hover:bg-red-100 rounded-lg transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                            <td colspan="4" class="text-center py-12">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-800 dark:text-white">Tidak ada produk</h3>
                                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan produk baru.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                            Tambah Produk Baru
                                        </a>
                                    </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
        </div>

        @if ($products->hasPages())
            <div class="p-6 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
