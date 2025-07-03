<x-layouts.catalog>
    <div class="bg-gradient-to-r from-blue-700 to-blue-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Breadcrumb --}}
            <nav class="flex mb-4" aria-label="Breadcrumb">
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
                            <a href="{{ route('ecatalog.index') }}" class="ml-1 text-blue-100 hover:text-white md:ml-2 transition duration-150">E-Catalog</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-1 text-white font-medium md:ml-2">{{ $product->nama }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
                </div>
            </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden animate-fadeIn">
            <div class="md:flex">
                {{-- Product Image Section --}}
                <div class="md:w-1/2">
                    <div class="relative aspect-w-4 aspect-h-3">
                    @if($product->foto)
                            <img src="{{ asset('storage/' . $product->foto) }}" 
                            alt="{{ $product->nama }}" 
                                 class="object-cover w-full h-full rounded-l-2xl transition-transform duration-300 hover:scale-105">
                    @else
                        <div class="w-full h-[500px] bg-gray-100 flex items-center justify-center rounded-l-2xl">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif

                    {{-- Stock Badge with icon & animation --}}
                    <div class="absolute top-4 right-4">
                        @if($product->stok > 10)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-gradient-to-r from-green-400 to-emerald-500 text-white shadow-lg animate-fadeIn transition-transform duration-300 hover:scale-110">
                                    <svg class="w-4 h-4 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Stok: {{ $product->stok }}
                            </span>
                        @elseif($product->stok > 0)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-gradient-to-r from-yellow-400 to-orange-400 text-white shadow-lg animate-fadeIn transition-transform duration-300 hover:scale-110">
                                    <svg class="w-4 h-4 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01"/></svg>
                                    Stok Terbatas: {{ $product->stok }}
                            </span>
                        @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-gradient-to-r from-red-400 to-pink-500 text-white shadow-lg animate-fadeIn transition-transform duration-300 hover:scale-110">
                                    <svg class="w-4 h-4 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Stok Habis
                            </span>
                        @endif
                        </div>
                    </div>
                </div>

                {{-- Product Info Section --}}
                <div class="md:w-1/2 p-8">
                    @if($product->category)
                        <span class="inline-block bg-primary-100 text-primary-800 text-sm px-3 py-1 rounded-full mb-4 font-medium">
                            {{ $product->category->name }}
                        </span>
                    @endif

                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->nama }}</h1>

                    <div class="mb-6">
                        <span class="text-3xl font-bold text-primary-600">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </span>
                        <span class="text-lg text-gray-500">/{{ $product->unit->symbol ?? $product->satuan ?? 'pcs' }}</span>
                    </div>

                    {{-- Variant Info --}}
                    @if($product->variants && $product->variants->count() > 0)
                        <div class="border-t border-gray-200 pt-4 mb-4">
                            <h3 class="text-lg font-bold text-blue-900 mb-2">Varian Produk</h3>
                            @php $groupedVariants = $product->variants->groupBy('type'); @endphp
                            @foreach($groupedVariants as $type => $variants)
                                <div class="mb-2 flex items-center gap-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide bg-gradient-to-r from-blue-400 to-indigo-400 text-white shadow animate-fadeIn transition-transform duration-300 hover:scale-110">
                                        @if(strtolower($type) === 'warna' || strtolower($type) === 'color')
                                            <svg class="w-3 h-3 mr-1 text-white" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>
                                        @elseif(strtolower($type) === 'ukuran' || strtolower($type) === 'size')
                                            <svg class="w-3 h-3 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2"/></svg>
                                        @else
                                            <svg class="w-3 h-3 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        @endif
                                        {{ ucfirst($type) }}
                                    </span>
                                    @foreach($variants as $variant)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 text-xs text-blue-900 font-semibold border border-blue-100 shadow-sm animate-fadeIn transition-transform duration-300 hover:scale-105">
                                            {{ $variant->name }}
                                            @if($variant->additional_price > 0)
                                                <span class="ml-2 text-green-600 font-bold">(+Rp {{ number_format($variant->additional_price, 0, ',', '.') }})</span>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="border-t border-gray-200 pt-4 mb-4">
                            <span class="text-gray-500">Tidak ada varian untuk produk ini.</span>
                        </div>
                    @endif

                    <div class="prose prose-blue max-w-none mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi Produk</h3>
                        <p class="text-gray-600">{{ $product->deskripsi }}</p>
                    </div>

                    {{-- Product Details/Specifications --}}
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Informasi Produk</h2>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="text-gray-500">Kategori</span>
                                <p class="font-medium text-gray-900">{{ $product->category->name ?? 'Tidak ada kategori' }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="text-gray-500">Kondisi</span>
                                <p class="font-medium text-gray-900">Baru</p>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Info --}}
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Informasi Pengiriman</h2>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <ul class="text-sm text-blue-800 space-y-2">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-1h3.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1V5a1 1 0 00-1-1H3z" />
                                    </svg>
                                    Pengiriman dari Padang, Sumatera Barat
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                    </svg>
                                    Estimasi 1-2 hari pengiriman
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Asuransi pengiriman
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Return Policy --}}
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Kebijakan Pengembalian</h2>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <p class="text-sm text-yellow-800">
                                Produk dapat dikembalikan dalam waktu 7 hari setelah diterima jika terdapat kerusakan atau tidak sesuai dengan deskripsi. Biaya pengiriman pengembalian ditanggung oleh pembeli.
                            </p>
                        </div>
                    </div>

                    @if($product->stok > 0)
                        <div class="space-y-4">
                            @if($product->stok > 0)
                                <x-quantity-modal :product="$product" />
                            @else
                                <div class="bg-gray-100 text-gray-600 text-center py-4 rounded-lg font-medium">
                                    Mohon maaf, stok produk ini sedang habis
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts && $relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-extrabold text-blue-900 mb-8">Produk Terkait</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($relatedProducts->take(3) as $product)
                        <article class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition duration-300 overflow-hidden group animate-fadeIn">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}" class="w-full h-56 object-cover transform group-hover:scale-105 transition duration-300">
                                <div class="absolute top-3 right-3">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-gradient-to-r from-green-400 to-emerald-500 text-white shadow-lg">
                                        Stok: {{ $product->stok }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                @if($product->category)
                                    <span class="inline-block bg-gradient-to-r from-blue-100 to-indigo-200 text-blue-900 text-xs px-3 py-1 rounded-full mb-3 font-bold shadow">
                                        {{ $product->category->name }}
                                    </span>
                                @endif
                                <h3 class="text-xl font-bold text-blue-900 mb-2 leading-tight">
                                    {{ $product->nama }}
                                </h3>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                    {{ Str::limit($product->deskripsi, 80) }}
                                </p>
                                <div class="mb-6">
                                    <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="text-sm text-gray-500 font-semibold">/{{ $product->unit->symbol ?? $product->satuan ?? 'pcs' }}</span>
                                </div>
                                <div class="space-y-3">
                                    <a href="{{ route('ecatalog.show', $product->id) }}" class="btn-secondary w-full flex items-center justify-center transition-all duration-200 hover:scale-105">
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
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.catalog>

