<x-layouts.catalog>
    <div class="max-w-4xl mx-auto py-10 px-6">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-10 text-center tracking-tight">
            Status Pemesanan Saya
        </h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 p-4 rounded-md mb-6 text-center font-semibold shadow-sm">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 p-4 rounded-md mb-6 text-center font-semibold shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        @if ($orders->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($orders as $order)
                    <div
                        class="bg-white rounded-3xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 flex flex-col justify-between"
                    >
                        <div>
                            <div class="flex justify-between items-center mb-5">
                                <h2 class="text-2xl font-semibold text-gray-900 tracking-wide">Pesanan #{{ $order->id }}</h2>
                                <span
                                    class="text-sm font-bold uppercase tracking-wider px-3 py-1 rounded-full
                                        @if ($order->status === 'selesai') bg-green-100 text-green-700
                                        @elseif ($order->status === 'diproses') bg-yellow-100 text-yellow-600
                                        @elseif ($order->status === 'dibatalkan') bg-red-100 text-red-700
                                        @else bg-gray-100 text-gray-500 @endif"
                                >
                                    {{ ucfirst($order->status ?? 'pending') }}
                                </span>
                            </div>

                            <p class="text-gray-700 mb-3"><span class="font-semibold">Nama Produk:</span> {{ $order->produk }}</p>
                            <p class="text-gray-700 mb-3"><span class="font-semibold">Harga:</span> Rp {{ number_format($order->harga, 0, ',', '.') }}</p>
                            <p class="text-gray-700 mb-3"><span class="font-semibold">Nama Pemesan:</span> {{ $order->user_name }}</p>
                            <p class="text-gray-700 mb-3"><span class="font-semibold">Telepon:</span> {{ $order->telepon }}</p>
                            <p class="text-gray-700 mb-3"><span class="font-semibold">Alamat:</span> {{ $order->alamat }}</p>
                            <p class="text-gray-600 text-sm"><span class="font-semibold">Tanggal:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        <div class="mt-6 flex flex-col space-y-3">
                            <a href="{{ route('order.status.detail', $order->id) }}"
                                class="text-indigo-600 hover:text-indigo-800 font-medium hover:underline self-start"
                            >
                                Lihat Detail &rarr;
                            </a>

                            @if ($order->status === 'pending' || $order->status === null)
                                <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')"
                                        class="text-red-600 hover:text-red-800 font-semibold hover:underline"
                                    >
                                        Batalkan Pesanan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 flex justify-center">
                {{ $orders->links() }}
            </div>
        @else
            <div class="py-20">
                <p class="text-center text-gray-400 italic text-lg select-none">
                    Belum ada pesanan yang ditemukan.
                </p>
            </div>
        @endif
    </div>
</x-layouts.catalog>
