@extends('components.layouts.admin')

@section('title', 'Admin')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Total Pengguna</p>
            <p class="text-2xl font-bold text-blue-600">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Total Pesanan</p>
            <p class="text-2xl font-bold text-blue-600">{{ $totalOrders }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Total Produk</p>
            <p class="text-2xl font-bold text-blue-600">{{ $totalProducts }}</p>
        </div>
    </div>
@endsection
