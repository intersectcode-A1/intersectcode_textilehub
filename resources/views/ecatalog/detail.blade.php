<x-layouts.catalog>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('ecatalog.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Katalog
            </a>
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

        {{-- Product Detail Section --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Product Image Section --}}
                <div class="relative">
                    @if($product->foto)
                        <img 
                            src="{{ asset('storage/' . $product->foto) }}" 
                            alt="{{ $product->nama }}" 
                            class="w-full h-[500px] object-cover"
                        >
                    @else
                        <div class="w-full h-[500px] bg-gray-100 flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif

                    {{-- Stock Badge --}}
                    <div class="absolute top-4 right-4">
                        @if($product->stok > 10)
                            <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">
                                Stok Tersedia ({{ $product->stok }})
                            </span>
                        @elseif($product->stok > 0)
                            <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full">
                                Stok Terbatas ({{ $product->stok }})
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded-full">
                                Stok Habis
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Product Info Section --}}
                <div class="p-8">
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->nama }}</h1>
                        <p class="text-sm text-gray-500">Kategori: {{ $product->category->name ?? 'Tidak ada kategori' }}</p>
                    </div>

                    <div class="mb-6">
                        <div class="text-3xl font-bold text-green-600 mb-2">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500">Kode Produk:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $product->id }}</span>
                        </div>
                    </div>

                    {{-- Product Description --}}
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi Produk</h2>
                        <div class="prose prose-sm text-gray-600">
                            {{ $product->deskripsi ?? 'Tidak ada deskripsi untuk produk ini.' }}
                        </div>
                    </div>

                    {{-- Product Details/Specifications --}}
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Informasi Produk</h2>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="text-gray-500">Stok</span>
                                <p class="font-medium text-gray-900">{{ $product->stok }} unit</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="text-gray-500">Kategori</span>
                                <p class="font-medium text-gray-900">{{ $product->category->name ?? 'Tidak ada kategori' }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="text-gray-500">Berat</span>
                                <p class="font-medium text-gray-900">{{ $product->berat ?? '0' }} gram</p>
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

                    {{-- Action Buttons --}}
                    @if($product->stok > 0)
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('checkout.direct', $product->id) }}"
                               class="flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Beli Sekarang
                            </a>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg transition duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-gray-100 p-4 rounded-lg text-center">
                            <p class="text-gray-600 font-medium">Maaf, stok produk ini sedang habis</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.catalog>
