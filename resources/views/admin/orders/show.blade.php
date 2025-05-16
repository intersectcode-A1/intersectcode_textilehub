@extends('components.layouts.dashboard')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Detail Pesanan #{{ $order->id }}</h1>

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
@endsection
