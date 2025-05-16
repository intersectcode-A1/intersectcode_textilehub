@extends('components.layouts.admin')

@section('content')
    <div class="p-6">
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow p-5 border">
                <h2 class="text-xl font-semibold text-gray-700">Total Users</h2>
                <p class="text-3xl font-bold text-blue-500">{{ $totalUsers }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5 border">
                <h2 class="text-xl font-semibold text-gray-700">Total Orders</h2>
                <p class="text-3xl font-bold text-green-500">{{ $totalOrders }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5 border">
                <h2 class="text-xl font-semibold text-gray-700">Total Products</h2>
                <p class="text-3xl font-bold text-purple-500">{{ $totalProducts }}</p>
            </div>
        </div>
    </div>
@endsection
