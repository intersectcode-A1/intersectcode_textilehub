<x-layouts.catalog>
    <div class="max-w-3xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">
            Detail Pemesanan
        </h1>

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Pesanan #{{ $order->id }}</h2>
                <span class="text-sm font-medium 
                    @if($order->status == 'selesai') text-green-600
                    @elseif($order->status == 'diproses') text-yellow-500
                    @elseif($order->status == 'dibatalkan') text-red-600
                    @else text-gray-500 @endif
                    uppercase tracking-wide">
                    {{ ucfirst($order->status ?? 'diproses') }}
                </span>
            </div>

            <div class="space-y-2">
                <p class="text-gray-700"><span class="font-medium">Nama Produk:</span> {{ $order->produk }}</p>
                <p class="text-gray-700"><span class="font-medium">Harga:</span> Rp {{ number_format($order->harga, 0, ',', '.') }}</p>
                <p class="text-gray-700"><span class="font-medium">Nama Pemesan:</span> {{ $order->user_name }}</p>
                <p class="text-gray-700"><span class="font-medium">Email:</span> {{ $order->email }}</p>
                <p class="text-gray-700"><span class="font-medium">Telepon:</span> {{ $order->telepon }}</p>
                <p class="text-gray-700"><span class="font-medium">Alamat:</span> {{ $order->alamat }}</p>
                <p class="text-gray-700"><span class="font-medium">Tanggal Pesan:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('order.status') }}" class="text-blue-600 hover:underline">
                ← Kembali ke Status Pemesanan
            </a>
        </div>
    </div>
</x-layouts.catalog>
