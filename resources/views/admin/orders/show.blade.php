@extends('components.layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="max-w-7xl mx-auto py-6 space-y-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Detail Pesanan #{{ $order->order_number }}</h1>
            <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Informasi Pembeli --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4 pb-2 border-b">
                        <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Informasi Pembeli
                    </h2>
                    <div class="grid md:grid-cols-2 gap-4 text-gray-800 dark:text-gray-100">
                        <p><span class="font-medium">Nama:</span> {{ $order->user_name ?? '-' }}</p>
                        <p><span class="font-medium">Email:</span> {{ $order->email ?? '-' }}</p>
                        <p><span class="font-medium">Telepon:</span> {{ $order->telepon ?? '-' }}</p>
                        <p><span class="font-medium">Alamat:</span> {{ $order->alamat ?? '-' }}</p>
                        <p><span class="font-medium">Tanggal Pesan:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                {{-- Status Pesanan dan Pembayaran --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4 pb-2 border-b">
                        <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Status Pesanan
                    </h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        {{-- Status Pesanan --}}
                        <div>
                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <label class="block">
                                    <span class="text-gray-700 dark:text-gray-200">Status Pesanan</span>
                                    <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </label>
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                                    Update Status Pesanan
                                </button>
                            </form>
                        </div>

                        {{-- Status Pembayaran --}}
                        <div>
                            <form action="{{ route('orders.verifyPayment', $order->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <label class="block">
                                    <span class="text-gray-700 dark:text-gray-200">Status Pembayaran</span>
                                    <select name="payment_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                                    </select>
                                </label>
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                                    Update Status Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bukti Pembayaran --}}
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4 pb-2 border-b">
                        <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Bukti Pembayaran
                    </h2>
                    @if($order->payment_proof)
                        <div class="relative aspect-w-16 aspect-h-9">
                            <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran" class="rounded-lg object-cover w-full h-full">
                        </div>
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="mt-4 inline-block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg transition">
                            Lihat Gambar Lengkap
                        </a>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p>Belum ada bukti pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tabel Produk --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 p-6 border-b">
                <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Daftar Produk
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase">
                        <tr>
                            <th class="px-6 py-3">Produk</th>
                            <th class="px-6 py-3">Harga Satuan</th>
                            <th class="px-6 py-3">Jumlah</th>
                            <th class="px-6 py-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($order->items as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4">{{ $item->product_name }}</td>
                                <td class="px-6 py-4">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">{{ $item->quantity }}</td>
                                <td class="px-6 py-4">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 dark:bg-gray-700 font-semibold text-gray-900 dark:text-white">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right">Total Keseluruhan:</td>
                            <td class="px-6 py-4">Rp{{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
