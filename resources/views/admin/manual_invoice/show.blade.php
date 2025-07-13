@extends('components.layouts.admin')

@section('title', 'Detail Invoice Manual')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-8 mt-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Invoice Manual</h2>
        <a href="{{ route('admin.manual-invoice.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-gray-700 text-sm font-medium">
            &larr; Kembali
        </a>
    </div>

    <!-- Info Invoice -->
    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <p class="text-gray-600">Nama Penerima</p>
            <p class="font-semibold text-lg">{{ $invoice->user_name ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-600">Tanggal</p>
            <p class="font-semibold">{{ $invoice->created_at ? $invoice->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') : '-' }} WIB</p>
        </div>
    </div>

    <!-- Tabel Item Invoice -->
    <div class="overflow-x-auto mb-6">
        <table class="min-w-full bg-white border rounded">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="px-4 py-2 text-left">Produk</th>
                    <th class="px-4 py-2 text-right">Qty</th>
                    <th class="px-4 py-2 text-right">Harga</th>
                    <th class="px-4 py-2 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoice->items ?? [] as $item)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $item->product_name ?? '-' }}</td>
                    <td class="px-4 py-2 text-right">{{ $item->quantity ?? 0 }}</td>
                    <td class="px-4 py-2 text-right">Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 text-right">Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-gray-400">Tidak ada item.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Total & Catatan -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div>
            <p class="text-gray-600">Catatan</p>
            <p class="text-gray-800">{{ $invoice->note ?? '-' }}</p>
        </div>
        <div class="text-right">
            <p class="text-gray-600">Total</p>
            <p class="text-2xl font-bold text-blue-700">Rp {{ number_format($invoice->total ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>
</div>
@endsection 