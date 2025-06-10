<x-layouts.catalog>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ route('ecatalog.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Katalog
            </a>
        </div>

        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Status Pemesanan</h1>
            <p class="text-lg text-gray-600">Pantau status pesanan yang sedang diproses</p>
        </div>

        {{-- Navigation Tabs --}}
        <div class="flex justify-center space-x-4 mb-8">
            <a href="{{ route('order.status') }}" 
               class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg">
                Status Pemesanan
            </a>
            <a href="{{ route('purchase.history') }}" 
               class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300">
                Riwayat Pembelian
            </a>
        </div>

        {{-- Status Pesanan --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->order_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($order->status === 'pending')
                                            bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'processing')
                                            bg-blue-100 text-blue-800
                                        @elseif($order->status === 'cancelled')
                                            bg-red-100 text-red-800
                                        @else
                                            bg-green-100 text-green-800
                                        @endif">
                                        @if($order->status === 'pending')
                                            Menunggu Konfirmasi
                                        @elseif($order->status === 'processing')
                                            Sedang Diproses
                                        @elseif($order->status === 'cancelled')
                                            Dibatalkan
                                        @elseif($order->status === 'completed')
                                            Selesai
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('order.detail', $order->id) }}" 
                                           class="text-blue-600 hover:text-blue-900">Detail</a>
                                        @if($order->status === 'pending')
                                            <form method="POST" action="{{ route('order.cancel', $order->id) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada pesanan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

        {{-- Messages --}}
        @if(session('success'))
            <div class="mt-8 rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </section>
</x-layouts.catalog> 