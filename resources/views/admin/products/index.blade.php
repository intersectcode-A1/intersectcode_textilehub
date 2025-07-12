@extends('components.layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white">Produk</h1>
    <x-breadcrumb :items="[['text' => 'Home', 'link' => route('admin.dashboard')], ['text' => 'Produk', 'link' => route('products.index')], ['text' => 'Daftar Produk']]" />
</div>

<div x-data="{ showFilters: false }">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 sm:mb-8 gap-2 sm:gap-3">
        <p class="text-xs sm:text-lg text-gray-600 dark:text-gray-400">Kelola semua produk dalam satu tempat.</p>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
            <a href="{{ route('products.export.stock') }}" 
               class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl shadow-lg backdrop-blur-md border border-white/30 hover:scale-105 hover:brightness-110 hover:shadow-xl transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-green-400">
                <i data-lucide="file-spreadsheet" class="w-5 h-5 mr-2"></i>
                Export Laporan Stok
            </a>
            <a href="{{ route('products.create') }}" 
               class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-xl shadow-lg backdrop-blur-md border border-white/30 hover:scale-105 hover:brightness-110 hover:shadow-xl transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                Tambah Produk
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 sm:mb-6 animate-fade-in-down">
        <div class="bg-green-100 dark:bg-green-500/20 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-3 sm:p-4 rounded-r-lg" role="alert">
            <p class="font-medium text-sm sm:text-base">Sukses!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
        </div>
    @endif

    <!-- Filter dan Pencarian -->
    <div class="bg-white/70 dark:bg-gray-800/80 glass rounded-2xl shadow-2xl p-6 mb-6 border border-white/20 dark:border-gray-700">
        <form action="{{ route('products.index') }}" method="GET">
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Cari nama produk..." value="{{ request('search') }}"
                           class="pl-10 sm:pl-12 w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition-all duration-200 text-sm"/>
                        <i data-lucide="search" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2"></i>
                    </div>
                </div>
                <div class="flex gap-2 sm:gap-3">
                    <button type="button" @click="showFilters = !showFilters"
                        class="px-4 sm:px-6 py-2 sm:py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 flex items-center gap-2 text-sm">
                        <i data-lucide="filter" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                        <span x-text="showFilters ? 'Tutup' : 'Filter'" class="hidden sm:inline"></span>
                    </button>
                    <button type="submit" 
                        class="px-6 sm:px-8 py-2 sm:py-3 bg-blue-600 text-white text-sm sm:text-base font-medium rounded-lg border border-transparent hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Cari
                    </button>
                </div>
            </div>

            <div x-show="showFilters" x-transition class="border-t border-gray-200 dark:border-gray-700 pt-4 sm:pt-6 mt-4 sm:mt-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    <div>
                        <label for="category" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Kategori</label>
                        <select name="category" id="category" class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 text-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="sort" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Urutkan</label>
                        <select name="sort" id="sort" class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 text-sm">
                            <option value="">Default</option>
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="stock_low" {{ request('sort') == 'stock_low' ? 'selected' : '' }}>Stok Terendah</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if($semuaKosong)
        <div class="mb-4 sm:mb-8 animate-fade-in-down">
            <div class="bg-amber-500/10 border-l-4 border-amber-500 text-amber-600 dark:text-amber-400 p-3 sm:p-4 rounded-r-lg sm:rounded-r-xl" role="alert">
                <p class="font-medium text-sm sm:text-base">Perhatian!</p>
                <p class="mt-1 text-sm">Stok semua barang kosong atau belum tersedia.</p>
            </div>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-xs sm:text-sm rounded-2xl overflow-hidden">
                <thead class="bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-blue-900 dark:to-indigo-900 border-b-2 border-blue-200 dark:border-blue-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">Info Produk</th>
                        <th class="hidden md:table-cell px-6 py-4 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">Stok & Varian</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                @if($product->foto)
                                    <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}" class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-lg sm:rounded-xl shadow-md ring-1 ring-gray-200 dark:ring-gray-700">
                                @else
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 dark:bg-gray-700/50 rounded-lg sm:rounded-xl flex items-center justify-center ring-1 ring-gray-200 dark:ring-gray-600">
                                        <i data-lucide="image" class="w-6 h-6 sm:w-10 sm:h-10 text-gray-400 dark:text-gray-500"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="space-y-1 sm:space-y-2">
                                    <h3 class="text-sm sm:text-base font-semibold text-gray-800 dark:text-gray-200">{{ $product->nama }}</h3>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Kategori:</span>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold shadow bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 dark:from-blue-900 dark:to-indigo-900 dark:text-blue-200">{{ $product->category->name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:items-baseline sm:space-x-4 pt-1 gap-1 sm:gap-0">
                                        <div>
                                            <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Harga:</span>
                                            <span class="text-sm sm:text-base font-semibold text-blue-600 dark:text-blue-400 ml-1">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                        </div>
                                        <div>
                                            <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Satuan:</span>
                                            <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 ml-1">{{ $product->satuan }}</span>
                                        </div>
                                    </div>
                                    <!-- Mobile: Show stock info -->
                                    <div class="md:hidden flex items-center space-x-4 pt-2">
                                        <div class="text-center">
                                            <span class="text-xs text-gray-500 dark:text-gray-400 block mb-1">Stok</span>
                                            <span class="w-8 h-8 flex items-center justify-center text-xs font-bold rounded-full bg-gradient-to-r from-green-200 to-emerald-400 text-green-900 dark:from-green-900 dark:to-emerald-800 dark:text-green-200">{{ $product->stok }}</span>
                                        </div>
                                        <div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 block mb-1">Varian</span>
                                            @if($product->variants && $product->variants->count() > 0)
                                                <span class="inline-flex items-center px-2 py-1 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 dark:from-blue-900 dark:to-indigo-900 dark:text-blue-200 rounded text-xs">{{ $product->variants->count() }} Varian</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 bg-gray-100 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 text-xs rounded">Tidak ada</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden md:table-cell px-6 py-4 align-top">
                                <div class="flex items-start space-x-4 sm:space-x-6">
                                    <div class="text-center">
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block mb-1">Stok</span>
                                        <span class="w-10 h-10 flex items-center justify-center text-sm font-bold rounded-full bg-gradient-to-r from-green-200 to-emerald-400 text-green-900 dark:from-green-900 dark:to-emerald-800 dark:text-green-200">{{ $product->stok }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block mb-1">Varian</span>
                                        @if($product->variants && $product->variants->count() > 0)
                                            <div x-data="{ open: false }" class="relative">
                                                <button @click="open = !open" class="inline-flex items-center px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">
                                                    <span class="text-sm font-medium mr-2">{{ $product->variants->count() }} Varian</span>
                                                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}"></i>
                                                </button>
                                                <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 z-50 mt-2 w-72 rounded-xl shadow-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 divide-y divide-gray-100 dark:divide-gray-700">
                                                    @foreach($product->variants as $variant)
                                                        <div class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700/60 flex justify-between items-center">
                                                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $variant->name }}</span>
                                                            <span class="text-sm text-gray-600 dark:text-gray-300">Stok: {{ $variant->stock }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 text-sm rounded-lg">Tidak ada</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex flex-row items-center justify-end space-x-2">
                                    <a href="{{ route('products.edit', $product) }}" class="p-2 bg-blue-100 hover:bg-blue-400 text-blue-600 hover:text-white rounded-full shadow transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-100 hover:bg-red-400 text-red-600 hover:text-white rounded-full shadow transition-all duration-200">
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
                            <td colspan="4" class="text-center py-8 sm:py-16">
                                <div class="text-gray-500 dark:text-gray-400 flex flex-col items-center">
                                    <i data-lucide="package-x" class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600"></i>
                                    <h3 class="mt-2 text-lg font-bold text-gray-800 dark:text-white">Tidak ada produk ditemukan</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Coba ubah filter atau tambahkan produk baru.</p>
                                    <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 mt-4 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-150">
                                        <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                                        Tambah Produk
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="p-3 sm:p-6 bg-white dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
