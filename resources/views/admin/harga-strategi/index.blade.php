@extends('components.layouts.admin')

@section('title', 'Strategi Harga')

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Strategi & Optimasi Harga</h1>
            <p class="mt-1 text-sm text-gray-600">Analisis dan rekomendasi penetapan harga produk</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="bg-blue-50 p-2 rounded-lg">
                <span class="text-xs text-blue-700 font-medium">Update Terakhir:</span>
                <span class="text-sm text-blue-900">{{ now()->format('d M Y H:i') }}</span>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-700 font-medium">Rata-rata Margin</p>
                    <p class="text-2xl font-bold text-blue-900">{{ number_format(collect($products)->avg('margin_percentage'), 1) }}%</p>
                </div>
                <div class="p-3 bg-blue-200 rounded-lg">
                    <i data-lucide="percent" class="w-6 h-6 text-blue-700"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-xs text-blue-700">
                    Target: 30%
                </div>
                <div class="mt-1 h-2 bg-blue-200 rounded-full">
                    <div class="h-2 bg-blue-600 rounded-full" style="width: {{ min(collect($products)->avg('margin_percentage') / 30 * 100, 100) }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-700 font-medium">Produk Optimal</p>
                    <p class="text-2xl font-bold text-green-900">{{ collect($products)->where('margin_percentage', '>=', 30)->count() }}</p>
                </div>
                <div class="p-3 bg-green-200 rounded-lg">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-700"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-xs text-green-700">
                    Dari {{ count($products) }} Produk
                </div>
                <div class="mt-1 h-2 bg-green-200 rounded-full">
                    <div class="h-2 bg-green-600 rounded-full" style="width: {{ collect($products)->where('margin_percentage', '>=', 30)->count() / count($products) * 100 }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-700 font-medium">Perlu Optimasi</p>
                    <p class="text-2xl font-bold text-purple-900">{{ collect($products)->where('margin_percentage', '<', 30)->count() }}</p>
                </div>
                <div class="p-3 bg-purple-200 rounded-lg">
                    <i data-lucide="alert-circle" class="w-6 h-6 text-purple-700"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-xs text-purple-700">
                    Produk dengan margin < 30%
                </div>
                <div class="mt-1 h-2 bg-purple-200 rounded-full">
                    <div class="h-2 bg-purple-600 rounded-full" style="width: {{ collect($products)->where('margin_percentage', '<', 30)->count() / count($products) * 100 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Kategori -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Analisis Harga per Kategori</h2>
            <div class="flex gap-2">
                <button id="toggleChartBtn"
                        class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 bg-white border rounded-lg hover:bg-gray-50">
                    <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                    <span id="toggleChartText">Lihat Grafik</span>
                </button>
            </div>
        </div>

        <!-- Category Chart -->
        <div id="categoryChart" class="hidden bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-sm p-6 mb-4">
            <canvas id="categoryAnalysisChart" style="height: 300px;"></canvas>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($categoryAnalysis as $category)
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-lg text-gray-900">{{ $category['nama'] }}</h3>
                        <span class="px-2 py-1 text-xs font-medium bg-blue-50 text-blue-700 rounded-full">
                            {{ $category['jumlah_produk'] }} Produk
                        </span>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700">Rata-rata Harga</span>
                                <span class="font-medium text-gray-900">Rp {{ number_format($category['rata_harga'], 0, ',', '.') }}</span>
                            </div>
                            <div class="h-2 bg-gray-100 rounded-full">
                                <div class="h-2 bg-blue-500 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="flex justify-between text-sm text-gray-700">
                            <span>Min: Rp {{ number_format($category['rekomendasi_minimum'], 0, ',', '.') }}</span>
                            <span>Max: Rp {{ number_format($category['rekomendasi_maximum'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Grafik Tren Penjualan -->
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Tren Penjualan (30 Hari Terakhir)</h2>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 text-sm text-gray-700">
                    <i data-lucide="info" class="w-4 h-4"></i>
                    <span>Data diperbarui setiap hari</span>
                </div>
            </div>
        </div>
        <canvas id="salesTrendChart" height="100"></canvas>
    </div>

    <!-- Tabel Produk -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900">Daftar Produk & Analisis Margin</h2>
                <div class="flex gap-2">
                    <button id="filterBtn" 
                            type="button"
                            class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                        <i data-lucide="filter" class="w-4 h-4"></i>
                        Filter
                    </button>
                    <button id="exportBtn"
                            type="button"
                            class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Filter Modal -->
        <div id="filterModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Filter Produk</h3>
                    <button onclick="closeFilterModal()" class="text-gray-500 hover:text-gray-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <form id="filterForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="filterKategori">
                            Kategori
                        </label>
                        <select id="filterKategori" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categoryAnalysis as $category)
                                <option value="{{ $category['nama'] }}">{{ $category['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="filterMargin">
                            Status Margin
                        </label>
                        <select id="filterMargin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="optimal">Optimal (≥30%)</option>
                            <option value="perlu_optimasi">Perlu Optimasi (<30%)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="filterStok">
                            Status Stok
                        </label>
                        <select id="filterStok" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="tersedia">Tersedia</option>
                            <option value="habis">Habis</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeFilterModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="button" onclick="applyFilter()"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="productTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Terjual</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Margin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $product['nama'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $product['kategori'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">Rp {{ number_format($product['harga_current'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs {{ $product['stok'] > 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }} rounded-full">
                                    {{ $product['stok'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $product['terjual'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $product['margin_percentage'] >= 30 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $product['margin_percentage'] }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product['margin_percentage'] >= 30)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i data-lucide="check-circle" class="w-3 h-3"></i>
                                        Optimal
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i data-lucide="alert-circle" class="w-3 h-3"></i>
                                        Perlu Optimasi
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.harga-strategi.analisis', $product['id']) }}" 
                                       class="text-blue-700 hover:text-blue-900">
                                        <i data-lucide="bar-chart" class="w-4 h-4"></i>
                                    </a>
                                    <button onclick="openUpdateModal({{ $product['id'] }}, '{{ $product['nama'] }}', {{ $product['harga_current'] }})"
                                            class="text-gray-700 hover:text-gray-900">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Update Harga -->
<div id="updateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Update Harga Produk</h3>
            <button onclick="closeUpdateModal()" class="text-gray-500 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="updateForm" method="POST" action="">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="productName">
                        Nama Produk
                    </label>
                    <input type="text" id="productName" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-gray-900 bg-gray-50"
                           readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="harga_baru">
                        Harga Baru
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-600 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="harga_baru" id="harga_baru" 
                               class="block w-full pl-12 pr-12 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-900" 
                               required>
                    </div>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeUpdateModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<!-- SheetJS untuk export Excel -->
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Filter functionality
    const filterBtn = document.getElementById('filterBtn');
    const filterModal = document.getElementById('filterModal');
    const exportBtn = document.getElementById('exportBtn');

    filterBtn.addEventListener('click', function() {
        filterModal.classList.remove('hidden');
    });

    function closeFilterModal() {
        filterModal.classList.add('hidden');
    }

    function applyFilter() {
        const kategori = document.getElementById('filterKategori').value;
        const margin = document.getElementById('filterMargin').value;
        const stok = document.getElementById('filterStok').value;
        
        const rows = document.querySelectorAll('#productTable tbody tr');
        
        rows.forEach(row => {
            let show = true;
            
            // Filter by kategori
            if (kategori && row.children[1].textContent.trim() !== kategori) {
                show = false;
            }
            
            // Filter by margin
            if (margin) {
                const marginText = row.children[5].textContent.trim();
                const marginValue = parseFloat(marginText.replace('%', ''));
                if (margin === 'optimal' && marginValue < 30) show = false;
                if (margin === 'perlu_optimasi' && marginValue >= 30) show = false;
            }
            
            // Filter by stok
            if (stok) {
                const stokValue = parseInt(row.children[3].textContent.trim());
                if (stok === 'tersedia' && stokValue <= 0) show = false;
                if (stok === 'habis' && stokValue > 0) show = false;
            }
            
            row.style.display = show ? '' : 'none';
        });

        closeFilterModal();
    }

    // Export functionality
    exportBtn.addEventListener('click', function() {
        const table = document.getElementById('productTable');
        const wb = XLSX.utils.book_new();
        
        // Get visible rows only
        const visibleRows = Array.from(table.rows).filter(row => row.style.display !== 'none');
        
        // Create a new table with only visible rows
        const tempTable = document.createElement('table');
        visibleRows.forEach(row => {
            const newRow = row.cloneNode(true);
            // Remove action buttons from export
            if (newRow.lastElementChild) {
                newRow.removeChild(newRow.lastElementChild);
            }
            tempTable.appendChild(newRow);
        });
        
        // Create worksheet from visible rows
        const ws = XLSX.utils.table_to_sheet(tempTable);
        
        // Add worksheet to workbook
        XLSX.utils.book_append_sheet(wb, ws, 'Produk');
        
        // Generate Excel file
        const filename = `analisis_produk_${new Date().toISOString().split('T')[0]}.xlsx`;
        XLSX.writeFile(wb, filename);
    });

    // Chart functionality
    let categoryChart = null;

    function initCategoryChart() {
        if (categoryChart) {
            categoryChart.destroy();
        }

        const ctxCategory = document.getElementById('categoryAnalysisChart').getContext('2d');
        categoryChart = new Chart(ctxCategory, {
            type: 'bar',
            data: {
                labels: @json($categoryAnalysis->pluck('nama')),
                datasets: [{
                    label: 'Rata-rata Harga',
                    data: @json($categoryAnalysis->pluck('rata_harga')),
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 12
                            },
                            color: '#374151'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#1F2937',
                        bodyColor: '#374151',
                        borderColor: '#E5E7EB',
                        borderWidth: 1,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                return new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                }).format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(156, 163, 175, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#374151',
                            font: {
                                size: 11
                            },
                            callback: function(value) {
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
                        },
                        ticks: {
                            color: '#374151',
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    }

    // Toggle chart visibility
    document.getElementById('toggleChartBtn').addEventListener('click', function() {
        const chartDiv = document.getElementById('categoryChart');
        const toggleText = document.getElementById('toggleChartText');
        const isHidden = chartDiv.classList.contains('hidden');
        
        if (isHidden) {
            chartDiv.classList.remove('hidden');
            toggleText.textContent = 'Sembunyikan Grafik';
            setTimeout(() => {
                initCategoryChart();
            }, 100);
        } else {
            chartDiv.classList.add('hidden');
            toggleText.textContent = 'Lihat Grafik';
        }
    });

    // Initialize icons
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endpush 