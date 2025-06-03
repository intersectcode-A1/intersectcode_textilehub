<x-layouts.catalog>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ route('ecatalog.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Katalog
            </a>
        </div>

        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Wishlist Saya</h1>
            <p class="text-lg text-gray-600">Daftar produk yang Anda simpan untuk dibeli nanti</p>
        </div>

        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="mb-6">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- Wishlist Items --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($wishlistItems as $item)
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300">
                    <div class="relative">
                        {{-- Product Image --}}
                        <div class="aspect-w-3 aspect-h-2">
                            @if($item->product->foto)
                                <img src="{{ asset('storage/' . $item->product->foto) }}"
                                     alt="{{ $item->product->nama }}"
                                     class="w-full h-full object-center object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Remove from Wishlist Button --}}
                        <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="absolute top-2 right-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-white rounded-full shadow-md hover:bg-red-50 transition duration-200">
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $item->product->nama }}</h3>
                        <p class="text-green-600 text-xl font-bold mb-4">
                            Rp {{ number_format($item->product->harga, 0, ',', '.') }}
                        </p>

                        {{-- Stock Status --}}
                        <div class="mb-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->product->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $item->product->stok > 0 ? 'Stok Tersedia' : 'Stok Habis' }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('ecatalog.detail', $item->product->id) }}"
                               class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-200">
                                Detail
                            </a>
                            @if($item->product->stok > 0)
                                <form action="{{ route('cart.add', $item->product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition duration-200">
                                        + Keranjang
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <p class="text-xl text-gray-500 font-medium mb-4">Wishlist Anda masih kosong</p>
                    <a href="{{ route('ecatalog.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition duration-200">
                        Jelajahi Katalog
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($wishlistItems->hasPages())
            <div class="mt-8">
                {{ $wishlistItems->links() }}
            </div>
        @endif
    </section>
</x-layouts.catalog> 