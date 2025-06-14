@extends('components.layouts.admin')

@section('title', 'Admin')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-gray-500">Total Pengguna</p>
                <span class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-users text-blue-600"></i>
                </span>
            </div>
            <p class="text-2xl font-bold text-blue-600">{{ $totalUsers }}</p>
            <p class="text-xs text-gray-500 mt-2">Total pengguna terdaftar</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-gray-500">Total Pesanan</p>
                <span class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-shopping-cart text-green-600"></i>
                </span>
            </div>
            <p class="text-2xl font-bold text-green-600">{{ $totalOrders }}</p>
            <p class="text-xs text-gray-500 mt-2">Total pesanan masuk</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-gray-500">Total Produk</p>
                <span class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-box text-purple-600"></i>
                </span>
            </div>
            <p class="text-2xl font-bold text-purple-600">{{ $totalProducts }}</p>
            <p class="text-xs text-gray-500 mt-2">Total produk tersedia</p>
        </div>
    </div>

    <!-- Grafik Penjualan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Grafik Penjualan Bulanan -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Grafik Penjualan Bulanan</h3>
            <canvas id="monthlySalesChart" height="300"></canvas>
        </div>

        <!-- Grafik Penjualan Mingguan -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Grafik Penjualan Mingguan</h3>
            <canvas id="weeklySalesChart" height="300"></canvas>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk grafik bulanan
    const monthlyData = {
        labels: @json($monthlyLabels),
        datasets: [{
            label: 'Penjualan Bulanan (Rp)',
            data: @json($monthlyData),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            tension: 0.4
        }]
    };

    // Data untuk grafik mingguan
    const weeklyData = {
        labels: @json($weeklyLabels),
        datasets: [{
            label: 'Penjualan Mingguan (Rp)',
            data: @json($weeklyData),
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            tension: 0.4
        }]
    };

    // Konfigurasi umum untuk grafik
    const chartConfig = {
        type: 'line',
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    },
                    ticks: {
                        callback: function(value, index, values) {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                maximumSignificantDigits: 3
                            }).format(value);
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    };

    // Inisialisasi grafik bulanan
    new Chart(
        document.getElementById('monthlySalesChart'),
        {
            ...chartConfig,
            data: monthlyData
        }
    );

    // Inisialisasi grafik mingguan
    new Chart(
        document.getElementById('weeklySalesChart'),
        {
            ...chartConfig,
            data: weeklyData
        }
    );
</script>
@endsection
