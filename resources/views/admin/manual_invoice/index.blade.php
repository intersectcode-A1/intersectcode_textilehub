@extends('components.layouts.admin')

@section('title', 'Invoice Manual')

@section('content')
<div class="mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i data-lucide="file-text" class="w-6 h-6"></i> Invoice Manual
    </h1>
    <nav class="text-xs sm:text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex flex-wrap">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Invoice Manual</a>
            </li>
        </ol>
    </nav>
</div>
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-2 sm:mb-6 gap-2 sm:gap-3">
    <p class="text-xs sm:text-lg text-gray-600 dark:text-gray-400">Kelola semua invoice manual yang dibuat admin.</p>
    <a href="{{ route('admin.manual-invoice.create') }}" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-blue-600 text-white text-xs sm:text-base font-medium rounded-lg sm:rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm w-full sm:w-auto justify-center">
        <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Buat Invoice Manual
    </a>
</div>
@if(session('success'))
<div class="mb-4 sm:mb-6 animate-fade-in-down">
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 sm:p-4 rounded-r-lg" role="alert">
        <p class="font-medium text-sm sm:text-base">Sukses!</p>
        <p class="text-sm">{{ session('success') }}</p>
    </div>
</div>
@endif
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700 text-xs sm:text-sm border border-gray-300 dark:border-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b border-gray-300 dark:border-gray-700">No</th>
                    <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b border-gray-300 dark:border-gray-700">Nama Penerima</th>
                    <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b border-gray-300 dark:border-gray-700">Tanggal</th>
                    <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b border-gray-300 dark:border-gray-700">Total</th>
                    <th class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b border-gray-300 dark:border-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-300 dark:divide-gray-700">
                @forelse($invoices as $invoice)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900 dark:text-white border-b border-gray-300 dark:border-gray-700">{{ $loop->iteration }}</td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 dark:text-gray-300 border-b border-gray-300 dark:border-gray-700">{{ $invoice->user_name }}</td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 dark:text-gray-300 border-b border-gray-300 dark:border-gray-700">{{ $invoice->tanggal }}</td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900 dark:text-white border-b border-gray-300 dark:border-gray-700">Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium border-b border-gray-300 dark:border-gray-700">
                            <a href="{{ route('admin.manual-invoice.download', $invoice->id) }}" class="inline-flex items-center px-2 sm:px-3 py-1.5 sm:py-2 border border-gray-300 shadow-sm text-xs sm:text-sm leading-4 font-medium rounded-lg text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                <i data-lucide="download" class="w-4 h-4 mr-1.5"></i>Download
                            </a>
                            <a href="{{ route('admin.manual-invoice.show', $invoice->id) }}" class="inline-flex items-center px-2 sm:px-3 py-1.5 sm:py-2 border border-gray-300 shadow-sm text-xs sm:text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 ml-1">
                                <i data-lucide="eye" class="w-4 h-4 mr-1.5"></i>Detail
                            </a>
                            <form action="{{ route('admin.manual-invoice.destroy', $invoice->id) }}" method="POST" class="inline-block ml-1" onsubmit="return confirm('Yakin ingin menghapus invoice ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-2 sm:px-3 py-1.5 sm:py-2 border border-gray-300 shadow-sm text-xs sm:text-sm leading-4 font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-1.5"></i>Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 sm:py-12">
                            <div class="text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-800 dark:text-white">Tidak ada invoice manual</h3>
                                <p class="mt-1 text-xs sm:text-sm text-gray-500">Belum ada invoice manual yang dibuat.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>lucide.createIcons();</script>
@endsection 