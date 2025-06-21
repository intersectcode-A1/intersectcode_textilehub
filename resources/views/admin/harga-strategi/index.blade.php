@extends('components.layouts.admin')

@section('title', 'Strategi Harga')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Strategi Harga</h1>
    <nav class="text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="#" class="text-gray-500 hover:text-gray-700">Strategi</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Strategi Harga</a>
            </li>
        </ol>
    </nav>
</div>

<div class="flex justify-between items-center mb-6">
    <p class="text-lg text-gray-600 dark:text-gray-400">Kelola strategi harga dan margin produk.</p>
            <div class="flex gap-2">
        <a href="{{ route('admin.harga-strategi.export') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white text-base font-medium rounded-xl hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-sm">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
                    Export
                </a>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 animate-fade-in-down">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg" role="alert">
            <p class="font-medium">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 animate-fade-in-down">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg" role="alert">
            <p class="font-medium">Error!</p>
            <p>{{ session('error') }}</p>
        </div>
    </div>
@endif

<!-- Filter dan Pencarian -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari Produk</label>
            <input type="text" id="searchInput" placeholder="Cari produk..." class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter Kategori</label>
            <select id="filterKategori" class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->nama }}">{{ $cat->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
</div>

<!-- Tabel Produk -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Margin</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rekomendasi Harga</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
            <tbody id="productTableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($products as $product)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $product->nama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600 dark:text-blue-400">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-semibold {{ $product->margin >= 30 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ number_format($product->margin, 1) }}%
                            </span>
                            @if($product->margin < 30)
                            <span class="ml-2 px-2 py-1 bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-full text-xs">Perlu Optimasi</span>
                            @endif
                        </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600 dark:text-blue-400">
                            Rp {{ number_format($product->recommended_price, 0, ',', '.') }}
                        </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.harga-strategi.edit', $product->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition-all duration-200" title="Edit harga produk">
                                Edit Harga
                            </a>
                            <button class="history-btn inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-all duration-200"
                                data-id="{{ $product->id }}" data-nama="{{ $product->nama }}" title="Lihat riwayat harga">
                                Riwayat
                            </button>
                        </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>

<!-- Modal Riwayat Harga -->
<div id="historyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <button id="closeHistoryModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">&times;</button>
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Riwayat Harga <span id="historyProductName"></span></h2>
        <div id="historyLoading" class="text-center text-gray-500 dark:text-gray-400">Memuat...</div>
        <table id="historyTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 hidden">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Tanggal</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Harga Lama</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Harga Baru</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">User</th>
                </tr>
            </thead>
            <tbody id="historyTableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-300"></tbody>
        </table>
        <div id="historyEmpty" class="text-center text-gray-500 dark:text-gray-400 hidden">Belum ada riwayat perubahan harga.</div>
    </div>
</div>

<!-- Toast -->
<div id="successToast" class="fixed bottom-4 right-4 hidden z-50 transition-all duration-300">
    <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center">
        <span id="toastMsg">Harga berhasil diperbarui!</span>
    </div>
</div>

<!-- Toast Error -->
<div id="errorToast" class="fixed bottom-4 right-4 hidden z-50 transition-all duration-300">
    <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center">
        <span id="errorToastMsg">Terjadi kesalahan saat menyimpan data</span>
    </div>
</div>

@if(session('success'))
    <div id="jsToastSuccess" data-message="{{ session('success') }}"></div>
@endif
@if(session('error'))
    <div id="jsToastError" data-message="{{ session('error') }}"></div>
@endif

{{-- Grafik Tren Harga --}}
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md mt-8 p-6">
    <div class="flex items-center gap-4 mb-4">
        <label for="selectChartProduct" class="text-gray-700 dark:text-gray-300 font-semibold">Pilih Produk untuk Grafik Tren Harga:</label>
        <select id="selectChartProduct" class="px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200">
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->nama }}</option>
            @endforeach
        </select>
    </div>
    <canvas id="priceChart" height="120"></canvas>
    <div id="chartLoading" class="text-center text-gray-500 dark:text-gray-400 mt-4">Memuat grafik...</div>
    <div id="chartEmpty" class="text-center text-gray-500 dark:text-gray-400 mt-4 hidden">Belum ada data riwayat harga.</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pencarian produk real-time
    const searchInput = document.getElementById('searchInput');
    const productTableBody = document.getElementById('productTableBody');
    searchInput.addEventListener('input', function() {
        const keyword = this.value.toLowerCase();
        productTableBody.querySelectorAll('tr').forEach(row => {
            const nama = row.querySelector('td').textContent.toLowerCase();
            row.style.display = nama.includes(keyword) ? '' : 'none';
        });
    });

    // Filter kategori
    const filterKategori = document.getElementById('filterKategori');
    filterKategori.addEventListener('change', function() {
        const kategori = this.value.toLowerCase();
        productTableBody.querySelectorAll('tr').forEach(row => {
            const rowKategori = row.querySelectorAll('td')[2]?.textContent?.toLowerCase() || '';
            row.style.display = (!kategori || rowKategori === kategori) ? '' : 'none';
        });
    });

    // Riwayat harga
    const historyBtns = document.querySelectorAll('.history-btn');
    const historyModal = document.getElementById('historyModal');
    const closeHistoryModal = document.getElementById('closeHistoryModal');
    const historyProductName = document.getElementById('historyProductName');
    const historyLoading = document.getElementById('historyLoading');
    const historyTable = document.getElementById('historyTable');
    const historyTableBody = document.getElementById('historyTableBody');
    const historyEmpty = document.getElementById('historyEmpty');

    historyBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = btn.getAttribute('data-id');
            historyProductName.textContent = btn.getAttribute('data-nama');
            historyModal.classList.remove('hidden');
            historyLoading.classList.remove('hidden');
            historyTable.classList.add('hidden');
            historyEmpty.classList.add('hidden');
            fetch(`/admin/harga-strategi/${id}/history`)
                .then(res => res.json())
                .then(data => {
                    historyLoading.classList.add('hidden');
                    if (data.history.length === 0) {
                        historyEmpty.classList.remove('hidden');
                        return;
                    }
                    historyTable.classList.remove('hidden');
                    historyTableBody.innerHTML = '';
                    data.history.forEach(h => {
                        historyTableBody.innerHTML += `<tr>
                            <td class='px-4 py-2 whitespace-nowrap'>${h.created_at}</td>
                            <td class='px-4 py-2 whitespace-nowrap'>Rp ${parseInt(h.old_price).toLocaleString('id-ID')}</td>
                            <td class='px-4 py-2 whitespace-nowrap'>Rp ${parseInt(h.new_price).toLocaleString('id-ID')}</td>
                            <td class='px-4 py-2 whitespace-nowrap'>${h.user}</td>
                        </tr>`;
                    });
                });
        });
    });
    closeHistoryModal.addEventListener('click', function() {
        historyModal.classList.add('hidden');
    });
    historyModal.addEventListener('click', function(e) {
        if (e.target === historyModal) historyModal.classList.add('hidden');
    });

    // Toast notifikasi dari session flash (redirect)
    const jsToastSuccess = document.getElementById('jsToastSuccess');
    const jsToastError = document.getElementById('jsToastError');
    if (jsToastSuccess) {
        toastMsg.textContent = jsToastSuccess.dataset.message;
        successToast.classList.remove('hidden');
        setTimeout(() => { successToast.classList.add('hidden'); }, 2000);
    }
    if (jsToastError) {
        errorToastMsg.textContent = jsToastError.dataset.message;
        errorToast.classList.remove('hidden');
        setTimeout(() => { errorToast.classList.add('hidden'); }, 2000);
    }

    // Grafik tren harga statis di halaman
    const selectChartProduct = document.getElementById('selectChartProduct');
    const chartLoading = document.getElementById('chartLoading');
    const chartEmpty = document.getElementById('chartEmpty');
    let priceChartInstance = null;
    function loadChart(productId) {
        chartLoading.classList.remove('hidden');
        chartEmpty.classList.add('hidden');
        if (priceChartInstance) priceChartInstance.destroy();
        fetch(`/admin/harga-strategi/${productId}/history`)
            .then(res => res.json())
            .then(data => {
                chartLoading.classList.add('hidden');
                if (!data.history || data.history.length === 0) {
                    chartEmpty.classList.remove('hidden');
                    return;
                }
                const ctx = document.getElementById('priceChart').getContext('2d');
                const labels = data.history.map(h => h.created_at);
                const prices = data.history.map(h => h.new_price);
                priceChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Harga',
                            data: prices,
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37,99,235,0.1)',
                            fill: true,
                            tension: 0.3,
                            pointRadius: 4,
                            pointBackgroundColor: '#2563eb',
                            pointBorderColor: '#fff',
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + parseInt(context.parsed.y).toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    },
                                    color: '#6b7280',
                                },
                                grid: { color: '#e5e7eb' }
                            },
                            x: {
                                ticks: { color: '#6b7280' },
                                grid: { color: '#e5e7eb' }
                            }
                        }
                    }
                });
            });
    }
    // Load chart for first product on page load
    if (selectChartProduct) {
        loadChart(selectChartProduct.value);
        selectChartProduct.addEventListener('change', function() {
            loadChart(this.value);
        });
    }
});
</script>
@endpush 