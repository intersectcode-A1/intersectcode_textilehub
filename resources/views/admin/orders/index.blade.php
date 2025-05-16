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
