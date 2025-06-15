@extends('components.layouts.admin')

@section('title', 'Strategi Harga')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Strategi Harga</h1>
        <div class="flex gap-2">
            <input type="text" id="searchInput" placeholder="Cari produk..." class="border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
            <select id="filterKategori" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->nama }}">{{ $cat->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody id="productTableBody" class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $product->nama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.harga-strategi.edit', $product->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none" title="Edit harga produk">
                            Edit Harga
                        </a>
                        <button class="history-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none ml-2"
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
            <tbody id="historyTableBody" class="bg-white divide-y divide-gray-200"></tbody>
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtns = document.querySelectorAll('.edit-btn');
    const editModal = document.getElementById('editModal');
    const closeModal = document.getElementById('closeModal');
    const modalProductName = document.getElementById('modalProductName');
    const modalProductId = document.getElementById('modalProductId');
    const modalNewPrice = document.getElementById('modalNewPrice');
    const modalPriceError = document.getElementById('modalPriceError');
    const editPriceForm = document.getElementById('editPriceForm');
    const successToast = document.getElementById('successToast');
    const toastMsg = document.getElementById('toastMsg');
    const saveBtn = document.getElementById('saveBtn');
    const saveBtnText = document.getElementById('saveBtnText');
    const saveSpinner = document.getElementById('saveSpinner');

    // Modal edit harga: fokus otomatis, esc close, enter submit
    function openEditModal() {
        editModal.classList.remove('hidden');
        setTimeout(() => { modalNewPrice.focus(); }, 100);
    }
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            modalProductName.textContent = btn.getAttribute('data-nama');
            modalProductId.value = btn.getAttribute('data-id');
            modalNewPrice.value = btn.getAttribute('data-harga');
            modalPriceError.classList.add('hidden');
            openEditModal();
        });
    });
    closeModal.addEventListener('click', function() {
        editModal.classList.add('hidden');
    });
    editModal.addEventListener('click', function(e) {
        if (e.target === editModal) editModal.classList.add('hidden');
    });
    document.addEventListener('keydown', function(e) {
        if (!editModal.classList.contains('hidden')) {
            if (e.key === 'Escape') editModal.classList.add('hidden');
            if (e.key === 'Enter' && document.activeElement === modalNewPrice) {
                e.preventDefault();
                editPriceForm.requestSubmit();
            }
        }
        if (!historyModal.classList.contains('hidden') && e.key === 'Escape') {
            historyModal.classList.add('hidden');
        }
    });
    // Loading spinner saat simpan
    editPriceForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const id = modalProductId.value;
        const price = parseInt(modalNewPrice.value.replace(/\D/g, ''));
        if (isNaN(price) || price < 0) {
            modalPriceError.textContent = 'Harga tidak valid';
            modalPriceError.classList.remove('hidden');
            return;
        }
        saveBtn.disabled = true;
        saveBtnText.textContent = 'Menyimpan...';
        saveSpinner.classList.remove('hidden');
        fetch(`/admin/harga-strategi/${id}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ new_price: price })
        })
        .then(response => response.json())
        .then(data => {
            saveBtn.disabled = false;
            saveBtnText.textContent = 'Simpan';
            saveSpinner.classList.add('hidden');
            if (data.success) {
                editModal.classList.add('hidden');
                toastMsg.textContent = data.message;
                successToast.classList.remove('hidden');
                setTimeout(() => { window.location.reload(); }, 1200);
            } else {
                throw new Error(data.message || 'Terjadi kesalahan saat menyimpan data');
            }
        })
        .catch(error => {
            saveBtn.disabled = false;
            saveBtnText.textContent = 'Simpan';
            saveSpinner.classList.add('hidden');
            errorToastMsg.textContent = error.message || 'Terjadi kesalahan saat menyimpan data';
            errorToast.classList.remove('hidden');
            setTimeout(() => { errorToast.classList.add('hidden'); }, 2000);
        });
    });

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