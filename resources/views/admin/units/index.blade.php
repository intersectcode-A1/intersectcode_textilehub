@extends('components.layouts.admin')

@section('title', 'Manajemen Satuan')

@section('content')
<div class="mb-2 sm:mb-6 flex flex-col sm:flex-row justify-between sm:items-center gap-2 sm:gap-3">
    <div>
        <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white">Manajemen Satuan</h1>
        <nav class="text-xs sm:text-sm font-medium text-gray-500" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex flex-wrap">
                <li class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                    <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                </li>
                <li>
                    <a href="#" class="text-gray-400" aria-current="page">Manajemen Satuan</a>
                </li>
            </ol>
        </nav>
    </div>
    <div>
        <button onclick="Livewire.emit('openModal', 'create-unit')" class="w-full sm:w-auto px-3 sm:px-6 py-2 sm:py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75 transition-all duration-200 text-xs sm:text-sm">
            <svg class="inline-block w-4 h-4 sm:w-5 sm:h-5 -ml-1 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Satuan
        </button>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 sm:p-4 mb-4 sm:mb-6 rounded-md shadow-sm" role="alert">
        <div class="flex">
            <div class="py-1"><svg class="h-4 w-4 sm:h-5 sm:w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg></div>
            <div class="ml-3">
                <p class="text-xs sm:text-sm font-medium">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs sm:text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                    <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Simbol</th>
                    <th scope="col" class="hidden md:table-cell px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Deskripsi</th>
                    <th scope="col" class="hidden sm:table-cell px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah Produk</th>
                    <th scope="col" class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($units as $unit)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900 dark:text-gray-100">
                            <div>
                                <div class="font-medium">{{ $unit->name }}</div>
                                <!-- Mobile: Show symbol -->
                                <div class="md:hidden text-xs text-gray-500 mt-1">Simbol: {{ $unit->symbol }}</div>
                            </div>
                        </td>
                        <td class="hidden md:table-cell px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 dark:text-gray-300">{{ $unit->symbol }}</td>
                        <td class="hidden md:table-cell px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-500 dark:text-gray-300">{{ $unit->description ?? '-' }}</td>
                        <td class="hidden sm:table-cell px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 dark:text-gray-300">{{ $unit->products_count }}</td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                            <div class="flex flex-col sm:flex-row items-center justify-end space-y-1 sm:space-y-0 sm:space-x-2">
                                <button onclick="Livewire.emit('openModal', 'edit-unit', {{ json_encode(['unit' => $unit->id]) }})" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200">
                                    Edit
                                </button>
                                @if($unit->products_count == 0)
                                    <form action="{{ route('units.destroy', $unit) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-200" onclick="return confirm('Apakah Anda yakin ingin menghapus satuan ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 sm:py-12">
                            <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                            <h3 class="mt-2 text-sm sm:text-base font-medium text-gray-900 dark:text-white">Belum ada data satuan</h3>
                            <p class="mt-1 text-xs sm:text-sm text-gray-500">Klik tombol "Tambah Satuan" untuk menambahkan yang baru.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if ($units->hasPages())
        <div class="p-3 sm:p-6 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            {{ $units->links() }}
        </div>
    @endif
</div>
@endsection 