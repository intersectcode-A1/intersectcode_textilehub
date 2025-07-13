<x-layouts.catalog>
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Tombol Kembali ke E-Catalog (paling atas) --}}
        <a href="{{ route('ecatalog.index') }}" class="inline-flex items-center mb-8 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            Kembali ke E-Catalog
        </a>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in border border-gray-100">
            {{-- Header --}}
            <div class="px-8 py-6 border-b border-gray-100 bg-white flex flex-col sm:flex-row sm:justify-between sm:items-center transition-colors duration-300">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-blue-900 mb-1 flex items-center gap-2">
                        <svg class="w-7 h-7 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a1 1 0 001 1h3m10-5h2a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h2"/></svg>
                        Order #{{ $order->order_number }}
                    </h2>
                    <p class="text-sm text-blue-700 mt-1">{{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-bold shadow flex items-center gap-2 animate-fade-in
                    @if($order->status === 'completed') bg-green-100 text-green-700 border border-green-200
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-700 border border-red-200
                    @else bg-yellow-100 text-yellow-700 border border-yellow-200 @endif">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2" class="@if($order->status === 'completed') stroke-green-400 @elseif($order->status === 'cancelled') stroke-red-400 @else stroke-yellow-400 @endif"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" class="@if($order->status === 'completed') stroke-green-500 @else hidden @endif"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" class="@if($order->status === 'cancelled') stroke-red-500 @else hidden @endif"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" class="@if($order->status !== 'completed' && $order->status !== 'cancelled') stroke-yellow-500 @else hidden @endif"/>
                    </svg>
                    {{ $order->status_label }}
                </span>
            </div>

            {{-- Customer Info --}}
            <div class="px-8 py-6 border-b border-gray-100 bg-blue-50 transition-colors duration-300">
                <h3 class="text-lg font-bold text-blue-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Informasi Penerima
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-blue-700 flex items-center gap-1"><svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804"/></svg>Nama:</p>
                        <p class="font-bold text-blue-900">{{ $order->user_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-blue-700 flex items-center gap-1"><svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 01-8 0"/></svg>Email:</p>
                        <p class="font-bold text-blue-900">{{ $order->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-blue-700 flex items-center gap-1"><svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10a1 1 0 011-1h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z"/></svg>Telepon:</p>
                        <p class="font-bold text-blue-900">{{ $order->telepon }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-blue-700 flex items-center gap-1"><svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h5"/></svg>Alamat:</p>
                        <p class="font-bold text-blue-900">{{ $order->alamat }}</p>
                    </div>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="px-8 py-6">
                <h3 class="text-lg font-bold text-blue-900 mb-3">Detail Pesanan</h3>
                <div class="divide-y divide-blue-100">
                    @foreach($order->items as $item)
                        <div class="py-4 flex justify-between items-center">
                            <div class="flex-1">
                                <h4 class="font-bold text-blue-900">{{ $item->product_name }}</h4>
                                @if(!empty($item->variant_info) && count((array)$item->variant_info) > 0)
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @foreach((array)$item->variant_info as $variant)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide bg-blue-500 text-white shadow animate-fade-in">
                                                {{ ucfirst($variant['type'] ?? '') }}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 text-xs text-blue-900 font-semibold border border-blue-100 shadow-sm animate-fade-in">
                                                {{ $variant['name'] ?? '' }}
                                                @if(!empty($variant['additional_price']) && $variant['additional_price'] > 0)
                                                    <span class="ml-2 text-green-600 font-bold">(+Rp {{ number_format($variant['additional_price'], 0, ',', '.') }})</span>
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                                <p class="text-sm text-blue-700 mt-1">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-blue-900 text-lg">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Total --}}
                <div class="mt-8 pt-6 border-t border-blue-100 bg-white rounded-xl shadow flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-6 py-6">
                    <span class="text-xl font-extrabold text-blue-900">Total</span>
                    <span class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-green-500 to-emerald-600 text-right">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>

                @if($order->payment_status === 'paid' && $order->status !== 'waiting')
                    <div class="mt-8 text-center">
                        <a href="{{ route('order.invoice.pdf', $order->id) }}"
                           class="inline-flex items-center justify-center px-8 py-3 text-base font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white shadow focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Download Invoice (PDF)
                        </a>
                    </div>
                @endif

                {{-- Tombol Bayar (hanya muncul jika status completed) --}}
                @if($order->status === 'completed')
                    <div class="mt-8 text-center">
                        <a href="{{ route('payment.show', $order->id) }}" 
                           class="inline-flex items-center justify-center px-8 py-3 text-base font-bold rounded-xl bg-green-600 hover:bg-green-700 text-white shadow focus:outline-none focus:ring-2 focus:ring-green-400 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Bayar Sekarang
                        </a>
                    </div>
                @endif
            </div>

            {{-- Actions --}}
            @if($order->canBeCancelled())
                <div class="px-8 py-6 rounded-b-2xl flex sm:justify-end justify-center">
                    <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="btn btn-danger px-6 py-3 text-base font-bold w-full sm:w-auto rounded-xl shadow focus:outline-none focus:ring-2 focus:ring-red-400 transition-all duration-200 bg-red-600 hover:bg-red-700 text-white border-none"
                                style="min-width:180px;"
                                onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                            Batalkan Pesanan
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Messages --}}
        @if(session('success'))
            <div class="mt-8 rounded-xl bg-green-50 p-4 border-l-4 border-green-500 shadow animate-fade-in">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-green-800 font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mt-8 rounded-xl bg-red-50 p-4 border-l-4 border-red-500 shadow animate-fade-in">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-red-800 font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif
    </section>
</x-layouts.catalog> 