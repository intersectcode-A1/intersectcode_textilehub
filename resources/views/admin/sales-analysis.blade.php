@extends('components.layouts.admin') 
@section('title', 'Analisis Penjualan')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Analisis Penjualan</h1>

    <div class="mb-8 p-6 bg-white dark:bg-gray-800 rounded shadow">
        <h2 class="text-xl font-semibold mb-2">Total Pendapatan</h2>
        <p class="text-3xl font-bold text-green-600 dark:text-green-400">
            Rp{{ number_format($totalRevenue, 0, ',', '.') }}
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
        <canvas id="salesChart" class="w-full h-64"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($sales->pluck('tanggal'));
    const data = @json($sales->pluck('total'));

    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan Harian',
                data: data,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: getComputedStyle(document.documentElement).getPropertyValue('--tw-text-opacity') > 0 ? '#fff' : '#000'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // Format angka di sumbu Y menjadi ribuan
                        callback: function(value) {
                            return 'Rp' + value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    ticks: {
                        color: getComputedStyle(document.documentElement).getPropertyValue('--tw-text-opacity') > 0 ? '#fff' : '#000'
                    }
                }
            }
        }
    });
</script>
@endsection