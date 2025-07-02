<x-layouts.catalog>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Tombol Kembali ke E-Catalog (paling atas) --}}
        <a href="{{ route('ecatalog.index') }}" class="inline-flex items-center mb-6 px-5 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-bold rounded-xl shadow hover:scale-105 hover:shadow-lg transition-all duration-150">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            Kembali ke E-Catalog
        </a>

        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-4xl font-extrabold text-blue-900 mb-4">Riwayat Pembelian</h1>
            <p class="text-lg text-blue-600">Lihat riwayat pembelian Anda yang telah selesai</p>
        </div>

        {{-- Navigation Tabs --}}
        <div class="flex justify-center space-x-4 mb-8">
            <a href="{{ route('order.status') }}" 
               class="px-6 py-2 rounded-xl font-bold bg-gray-100 text-blue-700 shadow hover:bg-blue-50 transition-all duration-200">
                Status Pemesanan
            </a>
            <a href="{{ route('purchase.history') }}" 
               class="px-6 py-2 rounded-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow hover:from-blue-700 hover:to-indigo-700 transition-all duration-200">
                Riwayat Pembelian
            </a>
        </div>

        {{-- Filter Section --}}
        <div class="bg-white/70 glass rounded-2xl shadow-2xl p-6 mb-6 animate-fadeIn">
            <form action="{{ route('purchase.history') }}" method="GET" class="flex flex-col md:flex-row md:items-end md:space-x-4">
                <div class="flex flex-row w-full gap-2 md:gap-3">
                    <div class="flex flex-col w-1/2">
                        <label class="block text-sm font-bold text-blue-800 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                               class="w-full border border-blue-200 rounded-xl px-4 py-2 focus:ring-blue-500 focus:border-blue-500 h-11" />
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label class="block text-sm font-bold text-blue-800 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                               class="w-full border border-blue-200 rounded-xl px-4 py-2 focus:ring-blue-500 focus:border-blue-500 h-11" />
                    </div>
                </div>
                <div class="flex md:justify-end items-center mt-3 md:mt-0 md:ml-4">
                    <button type="submit" class="btn btn-primary px-8 py-2 text-base font-bold h-11 w-full md:w-auto">Filter</button>
                </div>
            </form>
        </div>

        {{-- Orders List --}}
        <div class="bg-white/80 glass rounded-2xl shadow-2xl overflow-hidden animate-fadeIn">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-blue-100">
                    <thead class="bg-gradient-to-r from-blue-50 to-indigo-100 border-b-2 border-blue-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">No. Order</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Status Pembayaran</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-blue-50">
                        @forelse($orders as $order)
                            <tr class="hover:bg-blue-50 transition-all duration-150">
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-bold text-blue-900">#{{ $order->order_number }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-blue-700">{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-bold text-blue-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full shadow animate-fadeIn
                                        @if($order->status === 'cancelled') bg-gradient-to-r from-red-200 to-pink-400 text-red-900
                                        @elseif($order->payment_status === 'paid') bg-gradient-to-r from-green-200 to-emerald-400 text-green-900
                                        @elseif($order->payment_status === 'unpaid') bg-gradient-to-r from-yellow-200 to-yellow-400 text-yellow-900
                                        @else bg-gradient-to-r from-red-200 to-pink-400 text-red-900 @endif">
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
                                        @if($order->status === 'completed' && $order->payment_status === 'unpaid')
                                            <a href="{{ route('payment.show', $order->id) }}" class="btn-link text-green-700 font-bold">Bayar</a>
                                        @endif
                                        @if($order->payment_status === 'paid')
                                            <a href="{{ route('order.invoice.pdf', $order->id) }}" target="_blank"
                                               class="inline-flex items-center px-4 py-1.5 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-bold text-sm shadow-md backdrop-blur-md border border-white/20 hover:scale-105 hover:brightness-110 hover:shadow-lg active:scale-100 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400 h-9 ml-4">
                                                <svg class="w-4 h-4 mr-1 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2V7a2 2 0 00-2-2h-3.5a.5.5 0 01-.5-.5V3.5a.5.5 0 00-.5-.5H9a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                Download Invoice
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-blue-400">Belum ada riwayat pembelian</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-blue-100">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

        {{-- Messages --}}
        @if(session('success'))
            <div class="mt-8 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 p-4 border-l-4 border-green-500 shadow-lg animate-fadeIn">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-green-800 font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif
    </section>
</x-layouts.catalog> 