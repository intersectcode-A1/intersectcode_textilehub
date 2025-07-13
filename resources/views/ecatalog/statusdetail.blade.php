<x-layouts.catalog>
    <div class="max-w-4xl mx-auto py-10 px-6">
        <a href="{{ route('ecatalog.index') }}" class="inline-flex items-center mb-8 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            Kembali ke E-Catalog
        </a>

        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 animate-fade-in">
            <div class="flex flex-col sm:flex-row justify-between items-start mb-8 gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-blue-900 mb-2">Detail Pesanan #{{ $order->id }}</h1>
                    <p class="text-blue-700">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold shadow animate-fade-in
                    @if($order->status === 'completed') bg-green-100 text-green-700 border border-green-200
                    @elseif($order->status === 'processing' || $order->status === 'pending') bg-blue-100 text-blue-700 border border-blue-200
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-700 border border-red-200
                    @else bg-gray-100 text-gray-700 border border-gray-200 @endif">
                    {{ $order->status_label }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h2 class="text-lg font-semibold text-blue-900 mb-4">Informasi Pemesan</h2>
                    <div class="space-y-3">
                        <p class="text-blue-700">
                            <span class="font-medium">Nama:</span> {{ $order->user_name }}
                        </p>
                        <p class="text-blue-700">
                            <span class="font-medium">Email:</span> {{ $order->email }}
                        </p>
                        <p class="text-blue-700">
                            <span class="font-medium">Telepon:</span> {{ $order->telepon }}
                        </p>
                        <p class="text-blue-700">
                            <span class="font-medium">Alamat:</span><br>
                            {{ $order->alamat }}
                        </p>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-blue-900 mb-4">Rincian Pesanan</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-start border-b border-blue-100 pb-4 last:border-0">
                                <div>
                                    <h3 class="font-medium text-blue-900">{{ $item->product_name }}</h3>
                                    <p class="text-sm text-blue-700">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-semibold text-blue-900">
                                    Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="border-t border-blue-100 pt-6">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-blue-900">Total Pesanan</span>
                    <span class="text-2xl font-bold text-green-600">
                        Rp{{ number_format($order->total, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            @if($order->status === 'pending')
                <div class="mt-8 border-t border-blue-100 pt-6">
                    <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="text-right">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl shadow focus:outline-none focus:ring-2 focus:ring-red-400 transition-all duration-200">
                            Batalkan Pesanan
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-layouts.catalog>
