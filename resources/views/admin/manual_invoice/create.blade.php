@extends('components.layouts.admin')

@section('title', 'Buat Invoice Manual')

@section('content')
<div class="mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i data-lucide="file-text" class="w-6 h-6"></i> Buat Invoice Manual
    </h1>
    <nav class="text-xs sm:text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex flex-wrap">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="{{ route('admin.manual-invoice.index') }}" class="text-gray-500 hover:text-gray-700">Invoice Manual</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Buat Invoice Manual</a>
            </li>
        </ol>
    </nav>
</div>
<p class="text-xs sm:text-lg text-gray-600 dark:text-gray-400 mb-4">Form untuk membuat invoice manual oleh admin. Pastikan data yang diinput sudah benar sebelum disimpan.</p>
@if(session('success'))
<div class="mb-4 sm:mb-6 animate-fade-in-down">
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 sm:p-4 rounded-r-lg" role="alert">
        <p class="font-medium text-sm sm:text-base">Sukses!</p>
        <p class="text-sm">{{ session('success') }}</p>
    </div>
</div>
@endif
@if($errors->any())
<div class="mb-4 sm:mb-6 animate-fade-in-down">
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 sm:p-4 rounded-r-lg" role="alert">
        <p class="font-medium text-sm sm:text-base">Error!</p>
        <ul class="list-disc pl-5 text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sm:p-8">
    <form action="{{ route('admin.manual-invoice.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block font-semibold mb-1 text-gray-700 dark:text-white">Nama Penerima</label>
                <input type="text" name="user_name" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 dark:bg-gray-900 dark:border-gray-600 dark:text-white" required placeholder="Nama lengkap" autofocus value="{{ old('user_name') }}">
            </div>
            <div>
                <label class="block font-semibold mb-1 text-gray-700 dark:text-white">Alamat</label>
                <input type="text" name="alamat" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 dark:bg-gray-900 dark:border-gray-600 dark:text-white" required placeholder="Alamat lengkap" value="{{ old('alamat') }}">
            </div>
            <div>
                <label class="block font-semibold mb-1 text-gray-700 dark:text-white">Telepon</label>
                <input type="text" name="telepon" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 dark:bg-gray-900 dark:border-gray-600 dark:text-white" required placeholder="08xxxxxxxxxx" value="{{ old('telepon') }}">
            </div>
            <div>
                <label class="block font-semibold mb-1 text-gray-700 dark:text-white">Tanggal</label>
                <input type="date" name="tanggal" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 dark:bg-gray-900 dark:border-gray-600 dark:text-white" required value="{{ old('tanggal', date('Y-m-d')) }}">
            </div>
        </div>
        <div class="mb-8">
            <h2 class="font-semibold mb-3 text-lg text-gray-800 dark:text-white">Daftar Produk</h2>
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 dark:border-gray-700 mb-2 bg-white dark:bg-gray-900 text-sm rounded-lg shadow-sm overflow-hidden">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white uppercase text-xs font-bold">
                            <th class="border-b border-gray-300 dark:border-gray-700 px-4 py-2">Nama Produk</th>
                            <th class="border-b border-gray-300 dark:border-gray-700 px-4 py-2">Varian</th>
                            <th class="border-b border-gray-300 dark:border-gray-700 px-4 py-2">Qty</th>
                            <th class="border-b border-gray-300 dark:border-gray-700 px-4 py-2">Harga</th>
                            <th class="border-b border-gray-300 dark:border-gray-700 px-4 py-2">Subtotal</th>
                            <th class="border-b border-gray-300 dark:border-gray-700 px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="items-table-body">
                        <tr class="even:bg-gray-50 odd:bg-white dark:even:bg-gray-800 dark:odd:bg-gray-900 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <td><input type="text" name="items[0][product_name]" class="border rounded px-4 py-2 w-full dark:bg-gray-900 dark:border-gray-600 dark:text-white text-sm" required placeholder="Nama produk"></td>
                            <td><input type="text" name="items[0][variant]" class="border rounded px-4 py-2 w-full dark:bg-gray-900 dark:border-gray-600 dark:text-white text-sm" placeholder="Varian (opsional)"></td>
                            <td><input type="number" name="items[0][quantity]" class="border rounded px-4 py-2 w-full qty-input dark:bg-gray-900 dark:border-gray-600 dark:text-white text-sm" min="1" value="1" required></td>
                            <td><input type="number" name="items[0][price]" class="border rounded px-4 py-2 w-full price-input dark:bg-gray-900 dark:border-gray-600 dark:text-white text-sm" min="0" required></td>
                            <td><input type="number" name="items[0][subtotal]" class="border rounded px-4 py-2 w-full subtotal-input bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-white text-sm" min="0" readonly></td>
                            <td><button type="button" onclick="removeRow(this)" class="text-red-500 font-bold text-sm">Hapus</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="button" onclick="addRow()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded shadow mb-2 mt-1 text-xs sm:text-sm">+ Tambah Produk</button>
            <div class="flex justify-end mt-2">
                <div class="text-lg font-bold text-gray-700 dark:text-white">Total: Rp <span id="grand-total">0</span></div>
            </div>
        </div>
        <div class="mt-8 text-right">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-2 rounded font-semibold shadow text-base sm:text-lg">Buat Invoice</button>
        </div>
    </form>
</div>
@section('scripts')
<script>lucide.createIcons();</script>
@endsection
<script>
let rowIdx = 1;
function addRow() {
    const tbody = document.getElementById('items-table-body');
    const row = document.createElement('tr');
    row.className = 'even:bg-gray-50 odd:bg-white dark:even:bg-gray-800 dark:odd:bg-gray-900 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors';
    row.innerHTML = `
        <td><input type="text" name="items[${rowIdx}][product_name]" class="border rounded px-4 py-2 w-full dark:bg-gray-900 dark:border-gray-600 dark:text-white text-sm" required placeholder="Nama produk"></td>
        <td><input type="text" name="items[${rowIdx}][variant]" class="border rounded px-4 py-2 w-full dark:bg-gray-900 dark:border-gray-600 dark:text-white text-sm" placeholder="Varian (opsional)"></td>
        <td><input type="number" name="items[${rowIdx}][quantity]" class="border rounded px-4 py-2 w-full qty-input dark:bg-gray-900 dark:border-gray-600 dark:text-white text-sm" min="1" value="1" required></td>
        <td><input type="number" name="items[${rowIdx}][price]" class="border rounded px-4 py-2 w-full price-input dark:bg-gray-900 dark:border-gray-600 dark:text-white text-sm" min="0" required></td>
        <td><input type="number" name="items[${rowIdx}][subtotal]" class="border rounded px-4 py-2 w-full subtotal-input bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-white text-sm" min="0" readonly></td>
        <td><button type="button" onclick="removeRow(this)" class="text-red-500 font-bold text-sm">Hapus</button></td>
    `;
    tbody.appendChild(row);
    rowIdx++;
    attachSubtotalListeners();
}
function removeRow(btn) {
    btn.closest('tr').remove();
    updateGrandTotal();
}
function attachSubtotalListeners() {
    document.querySelectorAll('.qty-input, .price-input').forEach(input => {
        input.removeEventListener('input', subtotalHandler);
        input.addEventListener('input', subtotalHandler);
    });
}
function subtotalHandler(e) {
    const row = e.target.closest('tr');
    const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
    const price = parseFloat(row.querySelector('.price-input').value) || 0;
    const subtotal = qty * price;
    row.querySelector('.subtotal-input').value = subtotal;
    updateGrandTotal();
}
function updateGrandTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal-input').forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    document.getElementById('grand-total').textContent = total.toLocaleString('id-ID');
}
document.addEventListener('DOMContentLoaded', function() {
    attachSubtotalListeners();
});
</script>
@endsection 