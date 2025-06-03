@extends('components.layouts.admin')

@section('title', 'Daftar Pesanan')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Daftar Pesanan</h1>
        <a href="{{ route('orders.export') }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
            Export Excel
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Filter Form --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
        <form action="{{ route('orders.filter') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600">
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
        <table class="w-full table-auto text-sm text-left">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Nama Pembeli</th>
                    <th class="px-4 py-3">Jumlah Item</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-4 py-3">{{ $order->id }}</td>
                        <td class="px-4 py-3">{{ $order->user_name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $order->items->count() }} item</td>
                        <td class="px-4 py-3">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
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
                        </td>
                        <td class="px-4 py-3">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-3">
                                <a href="{{ route('orders.show', $order->id) }}"
                                   class="text-blue-600 hover:text-blue-800 font-semibold transition">
                                    Detail
                                </a>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-800 font-semibold transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@endsection
