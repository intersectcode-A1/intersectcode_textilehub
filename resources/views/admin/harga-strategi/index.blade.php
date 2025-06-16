@extends('components.layouts.admin')

@section('title', 'Strategi Harga')

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-white">Strategi Harga</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.harga-strategi.export') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-xl border-2 border-transparent hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-emerald-500 transition-all duration-200 shadow-sm">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Export
                </a>
                <input type="text" id="searchInput" placeholder="Cari produk..." class="border border-gray-600 rounded-xl px-3 py-2 bg-gray-700/50 text-gray-100 placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500" />
                <select id="filterKategori" class="border border-gray-600 rounded-xl px-3 py-2 bg-gray-700/50 text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->nama }}">{{ $cat->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Margin</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Rekomendasi Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="productTableBody" class="divide-y divide-gray-700">
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-700/50 transition-all duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-100 font-medium">{{ $product->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-indigo-300 font-semibold">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-semibold {{ $product->margin >= 30 ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ number_format($product->margin, 1) }}%
                            </span>
                            @if($product->margin < 30)
                                <span class="ml-2 px-2 py-1 bg-rose-500/10 text-rose-400 rounded-full text-xs">Perlu Optimasi</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-indigo-300 font-semibold">
                            Rp {{ number_format($product->recommended_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.harga-strategi.edit', $product->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition-all duration-200" title="Edit harga produk">
                                Edit Harga
                            </a>
                            <button class="history-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl text-white bg-gray-700 hover:bg-gray-600 focus:outline-none ml-2 transition-all duration-200"
                                data-id="{{ $product->id }}" data-nama="{{ $product->nama }}" title="Lihat riwayat harga">
                                Riwayat
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Riwayat Harga -->
<div id="historyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <button id="closeHistoryModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">&times;</button>
        <h2 class="text-xl font-semibold mb-4">Riwayat Harga <span id="historyProductName"></span></h2>
        <div id="historyLoading" class="text-center text-gray-500">Memuat...</div>
        <table id="historyTable" class="min-w-full divide-y divide-gray-200 hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Tanggal</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Harga Lama</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Harga Baru</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">User</th>
                </tr>
            </thead>
            <tbody id="historyTableBody" class="bg-white divide-y divide-gray-200 text-gray-700"></tbody>
        </table>
        <div id="historyEmpty" class="text-center text-gray-500 hidden">Belum ada riwayat perubahan harga.</div>
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
<div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 mt-8 p-6">
    <div class="flex items-center gap-4 mb-4">
        <label for="selectChartProduct" class="text-gray-300 font-semibold">Pilih Produk untuk Grafik Tren Harga:</label>
        <select id="selectChartProduct" class="border border-gray-600 rounded-xl px-3 py-2 bg-gray-700/50 text-gray-100">
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->nama }}</option>
            @endforeach
        </select>
    </div>
    <canvas id="priceChart" height="120"></canvas>
    <div id="chartLoading" class="text-center text-gray-500 mt-4">Memuat grafik...</div>
    <div id="chartEmpty" class="text-center text-gray-500 mt-4 hidden">Belum ada data riwayat harga.</div>
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
                            borderColor: '#6366f1',
                            backgroundColor: 'rgba(99,102,241,0.1)',
                            fill: true,
                            tension: 0.3,
                            pointRadius: 4,
                            pointBackgroundColor: '#6366f1',
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
                                    color: '#6366f1',
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