@extends('components.layouts.admin')

@section('title', 'Daftar Pesanan')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Daftar Pesanan</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
        <table class="w-full table-auto text-left">
            <thead class="bg-gray-100 dark:bg-gray-700 text-sm uppercase text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Nama Pembeli</th>
                    <th class="px-4 py-3">Produk</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-4 py-2">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->user_name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $order->produk ?? '-' }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($order->harga ?? 0, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <span class="inline-block px-2 py-1 text-xs rounded
                                @if($order->status === 'selesai')
                                    bg-green-100 text-green-700
                                @elseif($order->status === 'proses')
                                    bg-yellow-100 text-yellow-700
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
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
@endsection
