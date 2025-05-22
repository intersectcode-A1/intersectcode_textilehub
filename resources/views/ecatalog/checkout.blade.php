<x-layouts.catalog>
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">Form Pemesanan</h2>

        <form action="{{ route('order.submit') }}" method="POST" class="space-y-4">
            @csrf

            <input type="hidden" name="product_id" value="{{ $productId }}">
            <input type="hidden" name="product_name" value="{{ $productName }}">
            <input type="hidden" name="price" value="{{ $price }}">

            <div>
                <label class="block mb-1 font-medium">Nama</label>
                <input type="text" name="nama" required class="w-full border p-2 rounded" />
            </div>

            <div>
                <label class="block mb-1 font-medium">Alamat</label>
                <textarea name="alamat" rows="3" required class="w-full border p-2 rounded"></textarea>
            </div>

            <div>
                <label class="block mb-1 font-medium">No. Telepon</label>
                <input type="text" name="telepon" required class="w-full border p-2 rounded" />
            </div>

            <div>
                <label class="block mb-1 font-medium">Produk</label>
                <input type="text" value="{{ $productName }}" disabled class="w-full border p-2 rounded bg-gray-100" />
            </div>

            <div>
                <label class="block mb-1 font-medium">Harga</label>
                <input type="text" value="Rp {{ number_format($price, 0, ',', '.') }}" disabled class="w-full border p-2 rounded bg-gray-100" />
            </div>

            <div class="text-right">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                    Kirim Pesanan
                </button>
            </div>
        </form>
    </div>
</x-layouts.catalog>
