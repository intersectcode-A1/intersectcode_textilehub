<x-layouts.catalog>
    <div class="max-w-3xl mx-auto py-12 px-6">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-10 text-center tracking-tight">
            Detail Pemesanan
        </h1>

        <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-900">
                    Pesanan #{{ $order->id }}
                </h2>
                <span class="text-sm font-semibold uppercase tracking-wide px-3 py-1 rounded-full
                    @if($order->status == 'selesai') bg-green-100 text-green-700
                    @elseif($order->status == 'diproses') bg-yellow-100 text-yellow-700
                    @elseif($order->status == 'dibatalkan') bg-red-100 text-red-700
                    @else bg-gray-100 text-gray-600 @endif
                ">
                    {{ ucfirst($order->status ?? 'Diproses') }}
                </span>
            </div>

            <div class="space-y-4 text-gray-700">
                <p><span class="font-semibold text-gray-900">Nama Produk:</span> {{ $order->produk }}</p>
                <p><span class="font-semibold text-gray-900">Harga:</span> Rp {{ number_format($order->harga, 0, ',', '.') }}</p>
                <p><span class="font-semibold text-gray-900">Nama Pemesan:</span> {{ $order->user_name }}</p>
                <p><span class="font-semibold text-gray-900">Email:</span> {{ $order->email }}</p>
                <p><span class="font-semibold text-gray-900">Telepon:</span> {{ $order->telepon }}</p>
                <p><span class="font-semibold text-gray-900">Alamat:</span> {{ $order->alamat }}</p>
                <p><span class="font-semibold text-gray-900">Tanggal Pesan:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('order.status') }}" 
               class="inline-block text-blue-600 hover:text-blue-800 hover:underline font-semibold transition-colors duration-200">
                ← Kembali ke Status Pemesanan
            </a>
        </div>
    </div>
</x-layouts.catalog>
