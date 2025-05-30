@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Daftar Pesanan</h1>

    @if(session('success'))
        <div class="bg-green-200 p-3 rounded mb-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="py-2 px-4">#</th>
                    <th class="py-2 px-4">Nama</th>
                    <th class="py-2 px-4">Email</th>
                    <th class="py-2 px-4">Total</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
<<<<<<< Updated upstream
                @forelse($orders as $order)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $order->id }}</td>
                    <td class="py-2 px-4">{{ $order->user_name }}</td>
                    <td class="py-2 px-4">{{ $order->email }}</td>
                    <td class="py-2 px-4">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="py-2 px-4">{{ ucfirst($order->status) }}</td>
                    <td class="py-2 px-4">
                        <a href="{{ route('orders.show', $order->id) }}" class="text-blue-500 hover:underline">Lihat</a>
                    </td>
                </tr>
=======
                @forelse ($orders as $order)
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-4 py-2">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->user_name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $order->produk ?? '-' }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($order->harga ?? 0, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <span class="inline-block px-2 py-1 text-xs rounded
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
                        </td>
                        <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 hover:underline">Detail</a>
                        </td>
                    </tr>
>>>>>>> Stashed changes
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">Belum ada pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
