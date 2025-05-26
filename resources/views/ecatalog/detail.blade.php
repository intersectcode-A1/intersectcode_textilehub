<x-layouts.catalog>
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-3">Detail Produk</h1>
        <p class="text-gray-500 text-lg">Lihat detail lengkap dari produk pilihan kamu</p>
    </div>

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

            <form method="POST" action="{{ route('checkout') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="product_name" value="{{ $product->nama }}">
                <input type="hidden" name="price" value="{{ $product->harga }}">
                
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold shadow-md hover:bg-blue-700 hover:shadow-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 w-full md:w-auto"
                >
                    Tambah ke Keranjang & Checkout
                </button>
            </form>
        </div>
    </div>

    <div class="mt-10 text-center">
        <a href="{{ route('ecatalog.index') }}" class="inline-block text-blue-600 hover:text-blue-800 hover:underline text-lg font-medium transition-colors duration-300">
            &larr; Kembali ke Katalog
        </a>
    </div>
</x-layouts.catalog>
