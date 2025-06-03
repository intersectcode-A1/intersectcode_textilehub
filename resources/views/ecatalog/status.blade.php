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
            <div class="space-y-6">
                @foreach ($orders as $order)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Order #{{ $order->id }}</h3>
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($order->status === 'completed')
                                    bg-green-100 text-green-800
                                @elseif($order->status === 'processing')
                                    bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'cancelled')
                                    bg-red-100 text-red-800
                                @else
                                    bg-gray-100 text-gray-800
                                @endif">
                                {{ $order->status_label }}
                            </span>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="space-y-2">
                                @foreach($order->items as $item)
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-medium">{{ $item->product_name }}</p>
                                            <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                        <p class="font-semibold">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold">Total</span>
                                    <span class="text-lg font-bold text-green-600">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-between items-center">
                            <a href="{{ route('order.status.detail', $order->id) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium hover:underline">
                                Lihat Detail &rarr;
                            </a>

                            @if ($order->status === 'pending')
                                <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')"
                                        class="text-red-600 hover:text-red-800 font-semibold hover:underline">
                                        Batalkan Pesanan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-gray-600 text-lg mb-4">Belum ada pesanan</p>
                <a href="{{ route('ecatalog.index') }}" 
                   class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</x-layouts.catalog>
