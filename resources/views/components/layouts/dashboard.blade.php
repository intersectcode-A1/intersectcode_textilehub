@extends('components.layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="p-4 bg-white dark:bg-gray-700 rounded shadow">
        <h2 class="text-lg font-semibold">Total Users</h2>
        <p class="text-2xl mt-2">{{ $totalUsers ?? 120 }}</p>
    </div>
    <div class="p-4 bg-white dark:bg-gray-700 rounded shadow">
        <h2 class="text-lg font-semibold">Total Orders</h2>
        <p class="text-2xl mt-2">{{ $totalOrders ?? 85 }}</p>
    </div>
    <div class="p-4 bg-white dark:bg-gray-700 rounded shadow">
        <h2 class="text-lg font-semibold">Total Products</h2>
        <p class="text-2xl mt-2">{{ $totalProducts ?? 40 }}</p>
    </div>
</div>

<div class="bg-white dark:bg-gray-700 rounded shadow p-4">
    <h2 class="text-xl font-semibold mb-4">Statistik Penjualan</h2>
    <canvas id="salesChart" height="100"></canvas>
</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('salesChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                label: 'Penjualan',
                data: [12, 19, 3, 5, 2],
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
