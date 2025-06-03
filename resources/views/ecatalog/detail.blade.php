<x-layouts.catalog>
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-3">Detail Produk</h1>
        <p class="text-gray-500 text-lg">Lihat detail lengkap dari produk pilihan kamu</p>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="max-w-4xl mx-auto mb-8">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-4xl mx-auto mb-8">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start p-6 bg-white rounded-2xl shadow-lg">
        <div class="overflow-hidden rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
            @if($product->foto)
                <img 
                    src="{{ asset('storage/' . $product->foto) }}" 
                    alt="{{ $product->nama }}" 
                    class="w-full max-h-[450px] object-cover transform hover:scale-105 transition duration-300"
                >
            @else
                <div class="w-full h-[450px] bg-gray-200 flex items-center justify-center text-gray-600 text-xl">
                    Tidak ada gambar
                </div>
            @endif
        </div>

        <div class="flex flex-col justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->nama }}</h2>
                <p class="text-gray-700 text-lg leading-relaxed mb-6">
                    {{ $product->deskripsi ?? 'Tidak ada deskripsi untuk produk ini.' }}
                </p>
                <div class="text-2xl font-bold text-green-700 mb-8">
                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('checkout.direct', $product->id) }}"
                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md py-3 text-center transition">
                    Pesan Sekarang
                </a>
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit"
                            class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md py-3 transition">
                        + Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-10 text-center">
        <a href="{{ route('ecatalog.index') }}" class="inline-block text-blue-600 hover:text-blue-800 hover:underline text-lg font-medium transition-colors duration-300">
            &larr; Kembali ke Katalog
        </a>
    </div>
</x-layouts.catalog>
