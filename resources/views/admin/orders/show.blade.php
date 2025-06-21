@extends('components.layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Detail Pesanan #{{ $order->order_number }}</h1>
    <nav class="text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-gray-700">Pesanan</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Detail Pesanan</a>
            </li>
        </ol>
    </nav>
</div>

        <div class="flex justify-between items-center mb-6">
    <p class="text-lg text-gray-600 dark:text-gray-400">Informasi lengkap pesanan pelanggan.</p>
    <a href="{{ route('orders.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200">
        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>

        @if(session('success'))
    <div class="mb-6 animate-fade-in-down">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg" role="alert">
            <p class="font-medium">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Informasi Pembeli --}}
            <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
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
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
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
                            <span class="text-gray-700 dark:text-gray-200 font-medium">Status Pesanan</span>
                            <select name="status" class="mt-2 w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </label>
                        <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200">
                                    Update Status Pesanan
                                </button>
                            </form>
                        </div>

                        {{-- Status Pembayaran --}}
                        <div>
                            <form action="{{ route('orders.verifyPayment', $order->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <label class="block">
                            <span class="text-gray-700 dark:text-gray-200 font-medium">Status Pembayaran</span>
                            <select name="payment_status" class="mt-2 w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200">
                                        <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                                    </select>
                                </label>
                        <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all duration-200">
                                    Update Status Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bukti Pembayaran --}}
            <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
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
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 p-6 border-b border-gray-200 dark:border-gray-700">
                <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Daftar Produk
            </h2>
            <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga Satuan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($order->items as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $item->product_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
            <tfoot class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                    <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900 dark:text-white">Total Keseluruhan:</td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white">Rp{{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
        </div>
    </div>
@endsection
