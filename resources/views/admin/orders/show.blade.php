@extends('components.layouts.dashboard')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Detail Pesanan #{{ $order->id }}</h1>

<<<<<<< Updated upstream
    <div class="bg-white p-4 rounded shadow mb-6">
        <p><strong>Nama:</strong> {{ $order->user_name }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    </div>

    <div class="bg-white p-4 rounded shadow mb-6">
        <h2 class="text-xl font-semibold mb-2">Produk:</h2>
        <ul class="list-disc pl-6">
            @foreach($order->items as $item)
                <li>{{ $item->product_name }} - {{ $item->quantity }}x (Rp {{ number_format($item->price, 0, ',', '.') }})</li>
            @endforeach
        </ul>
    </div>

    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="inline-block">
        @csrf
        <label for="status" class="block mb-2 font-medium">Ubah Status:</label>
        <select name="status" id="status" class="border p-2 rounded mr-2">
            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="proses" {{ $order->status === 'proses' ? 'selected' : '' }}>Diproses</option>
            <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
    </form>
</div>
=======
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Informasi Pembeli</h2>
        <p><strong>Nama:</strong> {{ $order->user_name ?? '-' }}</p>
        <p><strong>Email:</strong> {{ $order->email ?? '-' }}</p>
        <p><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Daftar Produk</h2>
        <table class="w-full table-auto text-left mb-4">
            <thead class="bg-gray-100 dark:bg-gray-700 text-sm uppercase text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-2">Produk</th>
                    <th class="px-4 py-2">Harga</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-4 py-2">{{ $item->product_name }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $item->quantity }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right font-semibold">
            Total: Rp{{ number_format($total, 0, ',', '.') }}
        </div>
    </div>

    <div class="flex items-center gap-4">
        <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Kembali</a>

        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex items-center">
            @csrf
            <select name="status" class="border rounded px-3 py-2">
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded ml-2">Update</button>
        </form>
    </div>
>>>>>>> Stashed changes
@endsection
