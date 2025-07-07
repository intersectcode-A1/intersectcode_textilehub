<x-layouts.catalog>
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Tombol Kembali ke E-Catalog (paling atas) --}}
        <a href="{{ route('ecatalog.index') }}" class="inline-flex items-center mb-8 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            Kembali ke E-Catalog
        </a>

        <div class="text-center max-w-2xl mx-auto mb-10">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-blue-900 dark:text-white mb-2">Status Pesanan</h1>
            <p class="text-lg text-blue-700 dark:text-blue-200">Pantau status pesanan Anda</p>
        </div>

        {{-- Orders List --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow overflow-hidden animate-fade-in border border-gray-100 dark:border-gray-800">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-blue-100 dark:divide-gray-800">
                    <thead class="bg-blue-50 dark:bg-gray-800 border-b-2 border-blue-200 dark:border-blue-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">No. Order</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-blue-50 dark:divide-gray-800">
                        @forelse($orders as $order)
                            <tr class="hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-150">
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-bold text-blue-900 dark:text-white">#{{ $order->order_number }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-blue-700 dark:text-blue-200">{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-bold text-blue-900 dark:text-white">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-full shadow animate-fade-in
                                        @if($order->status === 'pending' || $order->status === 'processing') bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-700
                                        @elseif($order->status === 'cancelled') bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-700
                                        @elseif($order->status === 'completed') bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-700
                                        @endif">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('order.detail', $order->id) }}" class="btn-link text-blue-700 dark:text-blue-300 font-bold">Detail</a>
                                        @if($order->canBeCancelled())
                                            <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-link text-red-700 dark:text-red-300 font-bold" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                        @if($order->status === 'completed')
                                            <a href="{{ route('payment.show', $order->id) }}" class="text-green-700 dark:text-green-300 hover:underline font-medium">
                                                Bayar
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-12 h-12 text-blue-200 dark:text-blue-700 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8M12 8v8"/></svg>
                                        <span class="text-blue-400 dark:text-blue-600 font-semibold">Belum ada pesanan</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-blue-100 dark:border-blue-800 bg-white dark:bg-gray-900">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mt-8 rounded-xl bg-green-50 dark:bg-green-900 p-4 border-l-4 border-green-500 dark:border-green-400 shadow animate-fade-in">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 dark:text-green-300 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-green-800 dark:text-green-200 font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif
    </section>
</x-layouts.catalog>
