<!-- resources/views/dashboard.blade.php -->
@extends('components.layouts.admin')

@section('content')
<div class="p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-4 bg-blue-100 rounded">
            <h2 class="text-lg font-semibold">Total Users</h2>
            <p class="text-3xl font-bold">{{ $totalUsers }}</p>
        </div>
        <div class="p-4 bg-green-100 rounded">
            <h2 class="text-lg font-semibold">Total Orders</h2>
            <p class="text-3xl font-bold">{{ $totalOrders }}</p>
        </div>
        <div class="p-4 bg-yellow-100 rounded">
            <h2 class="text-lg font-semibold">Total Products</h2>
            <p class="text-3xl font-bold">{{ $totalProducts }}</p>
        </div>
    </div>
</div>
@endsection
