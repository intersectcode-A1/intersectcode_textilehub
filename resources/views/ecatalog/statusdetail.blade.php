<x-layouts.catalog>
    <div class="max-w-4xl mx-auto py-10 px-6">
        <div class="mb-8">
            <a href="{{ route('order.status') }}" class="text-blue-600 hover:text-blue-800 font-medium hover:underline">
                &larr; Kembali ke Daftar Pesanan
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Pesanan #{{ $order->id }}</h1>
                    <p class="text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pemesan</h2>
                    <div class="space-y-3">
                        <p class="text-gray-600">
                            <span class="font-medium">Nama:</span> {{ $order->user_name }}
                        </p>
                        <p class="text-gray-600">
                            <span class="font-medium">Email:</span> {{ $order->email }}
                        </p>
                        <p class="text-gray-600">
                            <span class="font-medium">Telepon:</span> {{ $order->telepon }}
                        </p>
                        <p class="text-gray-600">
                            <span class="font-medium">Alamat:</span><br>
                            {{ $order->alamat }}
                        </p>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Rincian Pesanan</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-start border-b border-gray-200 pb-4 last:border-0">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $item->product_name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-semibold text-gray-800">
                                    Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-800">Total Pesanan</span>
                    <span class="text-2xl font-bold text-green-600">
                        Rp{{ number_format($order->total, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            @if($order->status === 'pending')
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="text-right">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')"
                            class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                            Batalkan Pesanan
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-layouts.catalog>
