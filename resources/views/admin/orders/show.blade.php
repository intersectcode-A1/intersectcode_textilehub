@extends('components.layouts.admin')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="container px-6 mx-auto">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Pesanan #{{ $order->id }}</h1>
        <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-600 bg-white border rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
        <span class="font-medium">Sukses!</span> {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
        <!-- Informasi Pesanan -->
        <div class="bg-white rounded-lg shadow-md dark:bg-gray-800 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Informasi Pesanan</h2>
                <span class="px-3 py-1 text-xs font-semibold rounded-full
                    @if($order->status === 'completed') bg-green-100 text-green-800
                    @elseif($order->status === 'processing') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                    @elseif($order->status === 'paid') bg-blue-100 text-blue-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal Pesanan</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Pesanan</p>
                    <p class="text-xl font-bold text-gray-800 dark:text-white">Rp{{ number_format($total, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Status Pembayaran</p>
                    <p class="font-medium {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ $order->payment_status === 'paid' ? 'Sudah Dibayar' : 'Belum Dibayar' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Informasi Pelanggan -->
        <div class="bg-white rounded-lg shadow-md dark:bg-gray-800 p-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Informasi Pelanggan</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Nama</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $order->user_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Email</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $order->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Telepon</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $order->telepon }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Alamat Pengiriman</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $order->alamat }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Produk -->
    <div class="bg-white rounded-lg shadow-md dark:bg-gray-800 mb-6">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Detail Produk</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga Satuan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($order->items as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">
                            {{ $item->product_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-600 dark:text-gray-300">
                            Rp{{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-600 dark:text-gray-300">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-800 dark:text-white">
                            Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500 dark:text-gray-300">Total:</td>
                        <td class="px-6 py-4 text-right text-sm font-bold text-gray-800 dark:text-white">Rp{{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Verifikasi Pembayaran -->
    <div class="bg-white rounded-lg shadow-md dark:bg-gray-800 p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Verifikasi Pembayaran</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Bukti Pembayaran -->
            <div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Bukti Pembayaran</h3>
                @if($order->payment_proof)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                             alt="Bukti Pembayaran" 
                             class="rounded-lg shadow-lg max-w-full h-auto">
                    </div>
                @else
                    <div class="p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900">
                        <div class="flex">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <p class="ml-3 text-sm text-yellow-700 dark:text-yellow-200">
                                Bukti pembayaran belum diunggah
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Form Verifikasi -->
            <div>
                <form action="{{ route('orders.verifyPayment', $order->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status Pembayaran
                        </label>
                        <select name="payment_status" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Catatan Pembayaran
                        </label>
                        <textarea name="payment_notes" 
                                  rows="4" 
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                  placeholder="Tambahkan catatan terkait pembayaran...">{{ $order->payment_notes }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Status Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Status Pesanan -->
    <div class="bg-white rounded-lg shadow-md dark:bg-gray-800 p-6 mt-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Update Status Pesanan</h2>
        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-4">
            @csrf
            <select name="status" 
                    class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Update Status
            </button>
        </form>
    </div>
</div>
@endsection
