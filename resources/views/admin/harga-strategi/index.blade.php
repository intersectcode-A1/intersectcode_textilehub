@extends('components.layouts.admin')

@section('title', 'Strategi Harga')

@section('content')
<div class="mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white">Strategi Harga</h1>
    <nav class="text-xs sm:text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex flex-wrap">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="#" class="text-gray-500 hover:text-gray-700">Strategi</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Strategi Harga</a>
            </li>
        </ol>
    </nav>
</div>

<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-2 sm:mb-6 gap-2 sm:gap-3">
    <p class="text-xs sm:text-lg text-gray-600 dark:text-gray-400">Kelola strategi harga dan margin produk.</p>
            <div class="flex gap-2">
        <a href="{{ route('admin.harga-strategi.export') }}" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-green-600 text-white text-xs sm:text-base font-medium rounded-lg sm:rounded-xl hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-sm w-full sm:w-auto justify-center">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
                    Export
                </a>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 sm:mb-6 animate-fade-in-down">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 sm:p-4 rounded-r-lg" role="alert">
            <p class="font-medium text-sm sm:text-base">Sukses!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mb-4 sm:mb-6 animate-fade-in-down">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 sm:p-4 rounded-r-lg" role="alert">
            <p class="font-medium text-sm sm:text-base">Error!</p>
            <p class="text-sm">{{ session('error') }}</p>
        </div>
    </div>
@endif

<!-- Filter dan Pencarian -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Cari Produk</label>
            <input type="text" id="searchInput" placeholder="Cari produk..." class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm" />
        </div>
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Filter Kategori</label>
            <select id="filterKategori" class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
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
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs sm:text-sm">
            <thead class="bg-gradient-to-r from-blue-50 to-indigo-100 border-b-2 border-blue-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Harga</th>
                    <th class="hidden sm:table-cell px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Diskon</th>
                    <th class="hidden md:table-cell px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Harga Setelah Diskon</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-blue-700 uppercase tracking-wider w-32">Aksi</th>
                </tr>
            </thead>
            <tbody id="productTableBody" class="bg-white divide-y divide-blue-100">
                @foreach($products as $product)
                <tr class="hover:bg-blue-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-normal break-all font-medium text-gray-900">
                        {{ $product->nama }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-blue-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap">
                        <span class="font-semibold {{ $product->discount > 0 ? 'text-green-600' : 'text-gray-600' }}">
                            {{ $product->discount ? number_format($product->discount, 1) : '0' }}%
                        </span>
                    </td>
                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap font-semibold text-blue-600">
                        Rp {{ number_format($product->harga_setelah_diskon, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right w-32">
                        <div class="flex flex-row items-center justify-end space-x-2">
                            <a href="{{ route('admin.harga-strategi.edit', $product->id) }}" class="p-2 bg-blue-100 hover:bg-blue-400 text-blue-600 hover:text-white rounded-full shadow transition-all duration-200" title="Edit harga produk">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"/>
                                </svg>
                            </a>
                            <button class="p-2 bg-gray-100 hover:bg-gray-300 text-gray-600 hover:text-white rounded-full shadow transition-all duration-200 history-btn" data-id="{{ $product->id }}" data-nama="{{ $product->nama }}" title="Lihat riwayat harga">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 2a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19z"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@if ($products->hasPages())
    <div class="p-3 sm:p-6 bg-white dark:bg-gray-800 border-t border-blue-200 dark:border-blue-700">
        {{ $products->links('vendor.pagination.modern') }}
    </div>
@endif

<!-- Modal Riwayat Harga -->
<div id="historyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-4 sm:p-6 relative">
        <button id="closeHistoryModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">&times;</button>
        <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4 text-gray-800 dark:text-white">Riwayat Harga <span id="historyProductName"></span></h2>
        <div id="historyLoading" class="text-center text-gray-500 dark:text-gray-400 text-sm">Memuat...</div>
        <div class="overflow-x-auto">
        <table id="historyTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 hidden">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                        <th class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Tanggal</th>
                        <th class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Harga Lama</th>
                        <th class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Harga Baru</th>
                        <th class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">User</th>
                </tr>
            </thead>
                <tbody id="historyTableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-300 text-xs sm:text-sm"></tbody>
        </table>
        </div>
        <div id="historyEmpty" class="text-center text-gray-500 dark:text-gray-400 text-sm hidden">Belum ada riwayat perubahan harga.</div>
    </div>
</div>

<!-- Toast -->
<div id="successToast" class="fixed bottom-4 right-4 hidden z-50 transition-all duration-300">
    <div class="bg-green-500 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-lg flex items-center text-sm">
        <span id="toastMsg">Harga berhasil diperbarui!</span>
    </div>
</div>

<!-- Toast Error -->
<div id="errorToast" class="fixed bottom-4 right-4 hidden z-50 transition-all duration-300">
    <div class="bg-red-500 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-lg flex items-center text-sm">
        <span id="errorToastMsg">Terjadi kesalahan saat menyimpan data</span>
    </div>
</div>

@if(session('success'))
    <div id="jsToastSuccess" data-message="{{ session('success') }}"></div>
@endif
@if(session('error'))
    <div id="jsToastError" data-message="{{ session('error') }}"></div>
@endif

@endsection

@push('styles')
<style>
.chart-container {
    position: relative;
    width: 100%;
}

/* Responsive chart adjustments */
@media (max-width: 640px) {
    .chart-container {
        height: 250px !important;
    }
}

@media (min-width: 641px) and (max-width: 1024px) {
    .chart-container {
        height: 300px !important;
    }
}
</style>
@endpush

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
});
</script>
@endpush 