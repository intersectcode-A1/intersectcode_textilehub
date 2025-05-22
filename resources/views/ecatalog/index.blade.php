<x-layouts.catalog>
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-3">Katalog Produk</h1>
        <p class="text-gray-500 text-lg">Temukan produk terbaik kami di sini</p>
    </div>

    {{-- Filter/Search --}}
    <form class="mb-8">
        <div class="flex flex-col md:flex-row items-center gap-4">
            <input 
                type="text" 
                placeholder="Cari produk..." 
                class="p-3 rounded-lg border border-gray-300 flex-1 focus:ring-2 focus:ring-blue-500" 
            />
            <select class="p-3 rounded-lg border border-gray-300">
                <option>Semua Kategori</option>
                <option>Pakaian</option>
                <option>Tekstil</option>
                <option>Aksesoris</option>
            </select>
            <button 
                type="submit" 
                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition"
            >
                Cari
            </button>
        </div>
    </form>

    {{-- Produk Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @for ($i = 1; $i <= 6; $i++)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 flex flex-col">
                <div class="overflow-hidden">
                    <img 
                        src="https://picsum.photos/seed/ecom{{ $i }}/400/300" 
                        alt="Produk {{ $i }}" 
                        class="w-full h-56 object-cover transform transition-transform duration-300 hover:scale-105"
                    >
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <h3 class="text-xl font-semibold text-gray-800 mb-1">Produk {{ $i }}</h3>
                    <p class="text-gray-600 text-sm mb-2 flex-1">
                        Deskripsi singkat dari produk {{ $i }}. Material berkualitas dan desain menarik.
                    </p>
                    <div class="text-lg font-bold text-green-600 mb-4">
                        Rp {{ number_format(250000 + ($i * 10000), 0, ',', '.') }}
                    </div>
                    <div class="flex justify-between gap-2 mt-auto">
                        <a 
                            href="{{ url('/ecatalog/' . $i) }}" 
                            class="text-sm text-blue-600 font-semibold hover:underline"
                        >
                            Lihat Detail
                        </a>
                        <form method="POST" action="{{ route('checkout') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $i }}">
                            <input type="hidden" name="product_name" value="Produk {{ $i }}">
                            <input type="hidden" name="price" value="{{ 250000 + ($i * 10000) }}">
                            <button 
                                type="submit" 
                                class="text-sm bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition"
                            >
                                Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</x-layouts.catalog>

