<x-layouts.catalog>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center p-6 bg-white rounded-lg shadow-lg">
        <div class="overflow-hidden rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
            <img 
                src="{{ asset('image/benang1.jpg') }}" 
                alt="Produk {{ $id }}" 
                class="w-full max-h-96 object-cover transform hover:scale-105 transition-transform duration-300"
            >
        </div>
        <div>
            <h1 class="text-4xl font-extrabold mb-6 text-gray-900">Produk {{ $id }}</h1>
            <p class="text-gray-600 mb-6 leading-relaxed text-lg">
                Ini adalah deskripsi detail untuk produk dengan ID: {{ $id }}. Tambahkan info bahan, ukuran, dan lainnya agar pembeli lebih yakin dengan produk ini.
            </p>
            <div class="text-2xl font-bold text-green-700 mb-8">Rp 250.000</div>
            
            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $id }}">
                <input type="hidden" name="product_name" value="Produk {{ $id }}">
                <input type="hidden" name="price" value="250000">
                
                <button 
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold shadow-md hover:bg-blue-700 hover:shadow-lg transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                >
                    Tambah ke Keranjang & Checkout
                </button>
            </form>
        </div>
    </div>

    <div class="mt-10 text-center">
        <a href="{{ url('/ecatalog') }}" class="inline-block text-blue-600 hover:text-blue-800 hover:underline text-lg font-medium transition-colors duration-300">
            &larr; Kembali ke katalog
        </a>
    </div>
</x-layouts.catalog>
