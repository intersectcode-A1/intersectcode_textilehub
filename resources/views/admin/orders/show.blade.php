@extends('components.layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Detail Pesanan</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Informasi Pembeli --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4 border-b pb-2">Informasi Pembeli</h2>
            <div class="grid md:grid-cols-2 gap-4 text-gray-800 dark:text-gray-100">
                <p><span class="font-medium">Nama:</span> {{ $order->user_name ?? '-' }}</p>
                <p><span class="font-medium">Email:</span> {{ $order->email ?? '-' }}</p>
                <p><span class="font-medium">Telepon:</span> {{ $order->telepon ?? '-' }}</p>
                <p><span class="font-medium">Alamat:</span> {{ $order->alamat ?? '-' }}</p>
                <p><span class="font-medium">Tanggal Pesan:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>
                <p><span class="font-medium">Status:</span> 
                    <span class="inline-block px-2 py-1 text-xs rounded font-medium
                        @if($order->status === 'completed')
                            bg-green-100 text-green-700
                        @elseif($order->status === 'processing')
                            bg-yellow-100 text-yellow-700
                        @elseif($order->status === 'cancelled')
                            bg-red-100 text-red-700
                        @else
                            bg-gray-200 text-gray-800
                        @endif
                    ">
                    {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>
        </div>

        {{-- Tabel Produk --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 p-6 border-b">Daftar Produk</h2>
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-sm text-left">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase">
                        <tr>
                            <th class="px-4 py-3">Produk</th>
                            <th class="px-4 py-3">Harga Satuan</th>
                            <th class="px-4 py-3">Jumlah</th>
                            <th class="px-4 py-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-4 py-3">{{ $item->product_name }}</td>
                                <td class="px-4 py-3">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ $item->quantity }}</td>
                                <td class="px-4 py-3">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Total keseluruhan --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
            <div class="text-right text-xl font-bold text-gray-800 dark:text-gray-100">
                Total Keseluruhan: Rp{{ number_format($total, 0, ',', '.') }}
            </div>
        </div>

        {{-- Tombol Kembali dan Update Status --}}
        <div class="flex flex-col md:flex-row items-start md:items-center gap-4 mt-6">
            <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-md transition">
                ← Kembali
            </a>

            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-3">
                @csrf
                <select name="status" class="border rounded px-4 py-2 bg-white dark:bg-gray-900 dark:text-white dark:border-gray-600">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md transition">
                    Update Status
                </button>
            </form>
        </div>
    </div>
@endsection
