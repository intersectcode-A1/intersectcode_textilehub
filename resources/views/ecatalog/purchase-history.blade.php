<x-layouts.catalog>
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Tombol Kembali ke E-Catalog (paling atas) --}}
        <a href="{{ route('ecatalog.index') }}" class="inline-flex items-center mb-8 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            Kembali ke E-Catalog
        </a>

        <div class="text-center max-w-2xl mx-auto mb-10">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-blue-900 dark:text-white mb-2">Riwayat Pembelian</h1>
            <p class="text-lg text-blue-700 dark:text-blue-200">Lihat riwayat pembelian Anda yang telah selesai</p>
        </div>

        {{-- Navigation Tabs --}}
        <div class="flex justify-center space-x-4 mb-8">
            <a href="{{ route('order.status') }}" 
               class="px-6 py-2 rounded-xl font-bold bg-white dark:bg-gray-900 border border-blue-200 dark:border-blue-700 text-blue-700 dark:text-blue-200 shadow hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">
                Status Pemesanan
            </a>
            <a href="{{ route('purchase.history') }}" 
               class="px-6 py-2 rounded-xl font-bold bg-blue-600 text-white shadow hover:bg-blue-700 transition-all duration-200">
                Riwayat Pembelian
            </a>
            <a href="{{ route('bantuan.pengiriman') }}"
               class="px-6 py-2 rounded-xl font-bold bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow hover:from-green-600 hover:to-emerald-600 transition-all duration-200">
                Bantuan Pengiriman
            </a>
        </div>

        {{-- Filter Section --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow p-6 mb-8 border border-gray-100 dark:border-gray-800 animate-fade-in">
            <form action="{{ route('purchase.history') }}" method="GET" class="flex flex-col md:flex-row md:items-end md:space-x-4">
                <div class="flex flex-row w-full gap-2 md:gap-3">
                    <div class="flex flex-col w-1/2">
                        <label class="block text-sm font-bold text-blue-800 dark:text-blue-200 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                               class="w-full border border-blue-200 dark:border-blue-700 rounded-xl px-4 py-2 bg-white dark:bg-gray-800 text-blue-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-400 h-11 transition-colors duration-200" />
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label class="block text-sm font-bold text-blue-800 dark:text-blue-200 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                               class="w-full border border-blue-200 dark:border-blue-700 rounded-xl px-4 py-2 bg-white dark:bg-gray-800 text-blue-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-400 h-11 transition-colors duration-200" />
                    </div>
                </div>
                <div class="flex md:justify-end items-center mt-3 md:mt-0 md:ml-4">
                    <button type="submit" class="btn btn-primary px-8 py-2 text-base font-bold h-11 w-full md:w-auto">Filter</button>
                </div>
            </form>
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
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">Status Pembayaran</th>
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
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full shadow animate-fade-in
                                        @if($order->status === 'cancelled') bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-700
                                        @elseif($order->payment_status === 'paid') bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-700
                                        @elseif($order->payment_status === 'unpaid') bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-700
                                        @else bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-700 @endif">
                                        @if($order->status === 'cancelled')
                                            <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2" class="stroke-red-500"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" class="stroke-red-700"/></svg>
                                            Dibatalkan
                                        @elseif($order->payment_status === 'paid')
                                            <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2" class="stroke-green-500"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" class="stroke-green-700"/></svg>
                                            Lunas
                                        @elseif($order->payment_status === 'unpaid')
                                            <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2" class="stroke-yellow-500"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" class="stroke-yellow-700"/></svg>
                                            Belum Bayar
                                        @else
                                            <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2" class="stroke-red-500"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" class="stroke-red-700"/></svg>
                                            Gagal
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('order.detail', $order->id) }}" class="btn-link text-blue-700 font-bold">Detail</a>

                                        @if($order->payment_status === 'paid')
                                            <a href="{{ route('order.invoice.pdf', $order->id) }}" target="_blank"
                                               class="inline-flex items-center px-4 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow border border-blue-200 dark:border-blue-700 hover:scale-105 hover:shadow-lg active:scale-100 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400 h-9 ml-4">
                                                <svg class="w-4 h-4 mr-1 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2V7a2 2 0 00-2-2h-3.5a.5.5 0 01-.5-.5V3.5a.5.5 0 00-.5-.5H9a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                Download Invoice
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
                                        <span class="text-blue-400 dark:text-blue-600 font-semibold">Belum ada riwayat pembelian</span>
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

        {{-- Messages --}}
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