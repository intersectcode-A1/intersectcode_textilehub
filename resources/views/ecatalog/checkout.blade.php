<x-layouts.catalog>
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">Form Pemesanan</h2>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form pemesanan --}}
        <form action="{{ route('order.submit') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Data tersembunyi untuk produk --}}
            <input type="hidden" name="produk" value="{{ $productName }}">
            <input type="hidden" name="harga" value="{{ $price }}">
            <input type="hidden" name="product_id" value="{{ $productId }}">

            {{-- Nama pengguna --}}
            <div>
                <label for="user_name" class="block mb-1 font-medium">Nama</label>
                <input id="user_name" type="text" name="user_name" value="{{ old('user_name') }}" required class="w-full border p-2 rounded @error('user_name') border-red-500 @enderror" />
                @error('user_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block mb-1 font-medium">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full border p-2 rounded @error('email') border-red-500 @enderror" />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div>
                <label for="alamat" class="block mb-1 font-medium">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" required class="w-full border p-2 rounded @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Telepon --}}
            <div>
                <label for="telepon" class="block mb-1 font-medium">No. Telepon</label>
                <input id="telepon" type="text" name="telepon" value="{{ old('telepon') }}" required class="w-full border p-2 rounded @error('telepon') border-red-500 @enderror" />
                @error('telepon')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tampilkan produk dan harga (read-only) --}}
            <div>
                <label class="block mb-1 font-medium">Produk</label>
                <input type="text" value="{{ $productName }}" disabled class="w-full border p-2 rounded bg-gray-100" />
            </div>

            <div>
                <label class="block mb-1 font-medium">Harga</label>
                <input type="text" value="Rp {{ number_format($price, 0, ',', '.') }}" disabled class="w-full border p-2 rounded bg-gray-100" />
            </div>

            {{-- Tombol submit --}}
            <div class="text-right">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                    Kirim Pesanan
                </button>
            </div>
        </form>
    </div>
</x-layouts.catalog>
