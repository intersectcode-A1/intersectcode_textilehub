@extends('components.layouts.admin')

@section('title', 'Analisis Produk')

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('admin.harga-strategi.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali ke Strategi Harga
        </a>
    </div>

    @if($product)
        <!-- Info Produk -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informasi Dasar -->
                <div class="space-y-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $product->nama }}</h2>
                        <div class="mt-2 flex items-center gap-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium {{ $product->category ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $product->category->nama ?? 'Tanpa Kategori' }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium {{ $product->margin_percentage >= 30 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                Margin: {{ number_format($product->margin_percentage, 1) }}%
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Harga Saat Ini</p>
                            <p class="text-xl font-semibold text-gray-900">Rp {{ number_format($product->harga_current, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Stok</p>
                            <p class="text-xl font-semibold {{ $product->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->stok }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Statistik Penjualan -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <p class="text-sm text-gray-600">Total Terjual</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $product->total_terjual }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <p class="text-sm text-gray-600">Rata-rata Harga</p>
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($product->avg_harga, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <p class="text-sm text-gray-600">Harga Terendah</p>
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($product->min_harga, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <p class="text-sm text-gray-600">Harga Tertinggi</p>
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($product->max_harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik dan Analisis -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Grafik Penjualan -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tren Penjualan (6 Bulan Terakhir)</h3>
                <canvas id="salesChart" height="300"></canvas>
            </div>

            <!-- Grafik Harga -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Perubahan Harga</h3>
                <canvas id="priceChart" height="300"></canvas>
            </div>
        </div>

        <!-- Rekomendasi Harga -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Rekomendasi Harga</h3>
                <button type="button"
                        id="btnUpdateHarga"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                    Update Harga
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-green-50 rounded-lg p-4">
                    <p class="text-sm font-medium text-green-600">Harga Optimal</p>
                    <p class="text-2xl font-bold text-green-900">Rp {{ number_format($product->recommended_price, 0, ',', '.') }}</p>
                    <p class="text-sm text-green-600 mt-1">Margin: {{ number_format($product->recommended_margin, 1) }}%</p>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4">
                    <p class="text-sm font-medium text-yellow-600">Harga Minimum</p>
                    <p class="text-2xl font-bold text-yellow-900">Rp {{ number_format($product->min_recommended_price, 0, ',', '.') }}</p>
                    <p class="text-sm text-yellow-600 mt-1">Margin: 20%</p>
                </div>
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-sm font-medium text-blue-600">Harga Kompetitif</p>
                    <p class="text-2xl font-bold text-blue-900">Rp {{ number_format($product->competitive_price, 0, ',', '.') }}</p>
                    <p class="text-sm text-blue-600 mt-1">Berdasarkan harga pasar</p>
                </div>
            </div>
        </div>

        <!-- Riwayat Perubahan Harga -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Riwayat Perubahan Harga</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga Lama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga Baru</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perubahan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diubah Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($product->priceHistory as $history)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $history->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp {{ number_format($history->old_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp {{ number_format($history->new_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $percentChange = $history->old_price ? (($history->new_price - $history->old_price) / $history->old_price) * 100 : 0;
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $percentChange >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $percentChange >= 0 ? '+' : '' }}{{ number_format($percentChange, 1) }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $history->user->name ?? 'User tidak ditemukan' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada riwayat perubahan harga
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Update Harga -->
        <div id="updateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Update Harga Produk</h3>
                    <button type="button" 
                            id="btnCloseModal"
                            class="text-gray-500 hover:text-gray-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <form id="updateForm" method="POST" action="{{ route('admin.harga-strategi.update', $product->id) }}" onsubmit="return validateForm()">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="productName">
                                Nama Produk
                            </label>
                            <input type="text" id="productName" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-gray-900 bg-gray-50"
                                   value="{{ $product->nama }}"
                                   readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="harga_baru">
                                Harga Baru
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="harga_baru" id="harga_baru" 
                                       class="block w-full pl-12 pr-12 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" 
                                       value="{{ $product->harga_current }}"
                                       min="{{ $product->min_recommended_price }}"
                                       step="100"
                                       required>
                                <div id="hargaError" class="mt-1 text-sm text-red-600 hidden"></div>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Harga Optimal:</span>
                                <span class="font-medium text-gray-900">Rp {{ number_format($product->recommended_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Harga Minimum:</span>
                                <span class="font-medium text-gray-900">Rp {{ number_format($product->min_recommended_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Harga Kompetitif:</span>
                                <span class="font-medium text-gray-900">Rp {{ number_format($product->competitive_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" 
                                    id="btnBatalUpdate"
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
    @else
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i data-lucide="alert-triangle" class="h-5 w-5 text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Data produk tidak ditemukan.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>

@if(session('success'))
    <!-- Notifikasi Sukses -->
    <div id="successNotification" 
         class="fixed bottom-4 right-4 bg-green-50 border-l-4 border-green-400 p-4 shadow-lg rounded-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <i data-lucide="check-circle" class="h-5 w-5 text-green-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">
                    {{ session('success') }}
                </p>
            </div>
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button onclick="closeNotification()" class="text-green-500 hover:text-green-600">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Initialize everything when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Modal functions
        const modal = document.getElementById('updateModal');
        const btnUpdateHarga = document.getElementById('btnUpdateHarga');
        const btnCloseModal = document.getElementById('btnCloseModal');
        const btnBatalUpdate = document.getElementById('btnBatalUpdate');
        const hargaBaruInput = document.getElementById('harga_baru');
        const hargaError = document.getElementById('hargaError');

        function openModal() {
            if (modal) {
                modal.classList.remove('hidden');
                if (hargaBaruInput) {
                    hargaBaruInput.value = '{{ $product->harga_current }}';
                    validateHarga();
                }
            }
        }

        function closeModal() {
            if (modal) {
                modal.classList.add('hidden');
                if (hargaError) hargaError.classList.add('hidden');
            }
        }

        function validateHarga() {
            const value = parseFloat(hargaBaruInput.value);
            const minPrice = {{ $product->min_recommended_price }};
            
            if (value < minPrice) {
                hargaError.textContent = `Harga minimum adalah Rp ${minPrice.toLocaleString('id-ID')}`;
                hargaError.classList.remove('hidden');
                return false;
            } else {
                hargaError.classList.add('hidden');
                return true;
            }
        }

        window.validateForm = function() {
            return validateHarga();
        }

        // Add click event listeners
        if (btnUpdateHarga) {
            btnUpdateHarga.addEventListener('click', openModal);
        }

        if (btnCloseModal) {
            btnCloseModal.addEventListener('click', closeModal);
        }

        if (btnBatalUpdate) {
            btnBatalUpdate.addEventListener('click', closeModal);
        }

        // Handle click outside modal
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        }

        // Handle escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Validasi input harga
        if (hargaBaruInput) {
            hargaBaruInput.addEventListener('input', validateHarga);
        }

        // Auto hide notification after 5 seconds
        @if(session('success'))
            setTimeout(closeNotification, 5000);
        @endif

        // Initialize charts
        @if(isset($sales_data) && isset($price_history))
            // Inisialisasi grafik penjualan
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: @json($sales_data->pluck('month')),
                    datasets: [{
                        label: 'Jumlah Terjual',
                        data: @json($sales_data->pluck('total')),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4
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
                            padding: 12
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

            // Inisialisasi grafik harga
            const priceCtx = document.getElementById('priceChart').getContext('2d');
            new Chart(priceCtx, {
                type: 'line',
                data: {
                    labels: @json($price_history->pluck('date')),
                    datasets: [{
                        label: 'Harga Produk',
                        data: @json($price_history->pluck('price')),
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4
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
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
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
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
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
        @endif

        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    function closeNotification() {
        const notification = document.getElementById('successNotification');
        if (notification) {
            notification.remove();
        }
    }
</script>
@endpush 