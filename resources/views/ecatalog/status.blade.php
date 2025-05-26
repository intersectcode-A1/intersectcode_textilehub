<x-layouts.catalog>
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">
            Status Pemesanan Saya
        </h1>

        @if ($orders->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($orders as $order)
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">Pesanan #{{ $order->id }}</h2>
                            <span class="text-sm font-medium uppercase tracking-wide
                                @if ($order->status === 'selesai') text-green-600
                                @elseif ($order->status === 'diproses') text-yellow-500
                                @elseif ($order->status === 'dibatalkan') text-red-600
                                @else text-gray-500 @endif">
                                {{ ucfirst($order->status ?? 'diproses') }}
                            </span>
                        </div>

                        <p class="text-gray-700 mb-2"><span class="font-medium">Nama Produk:</span> {{ $order->produk }}</p>
                        <p class="text-gray-700 mb-2"><span class="font-medium">Harga:</span> Rp {{ number_format($order->harga, 0, ',', '.') }}</p>
                        <p class="text-gray-700 mb-2"><span class="font-medium">Nama Pemesan:</span> {{ $order->user_name }}</p>
                        <p class="text-gray-700 mb-2"><span class="font-medium">Telepon:</span> {{ $order->telepon }}</p>
                        <p class="text-gray-700 mb-2"><span class="font-medium">Alamat:</span> {{ $order->alamat }}</p>
                        <p class="text-gray-700"><span class="font-medium">Tanggal:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>

                        <a href="{{ route('order.status.detail', $order->id) }}" class="text-blue-600 hover:underline mt-4 inline-block">
                            Lihat Detail
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="py-16">
                <p class="text-center text-gray-400 italic text-lg">
                    Belum ada pesanan yang ditemukan.
                </p>
            </div>
        @endif
    </div>
</x-layouts.catalog>
