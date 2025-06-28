@extends('components.layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-4 sm:mb-6">
        <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white">Dashboard</h1>
        <nav class="text-xs sm:text-sm font-medium text-gray-500" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex flex-wrap">
                <li class="flex items-center">
                    <a href="#" class="text-gray-500 hover:text-gray-700">Home</a>
                    <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                </li>
                <li>
                    <a href="#" class="text-gray-400" aria-current="page">Dashboard</a>
                </li>
            </ol>
        </nav>
    </div>

     <!-- Statistik Utama -->
     <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
        <!-- Total Pesanan -->
        <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-lg border border-transparent hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-300 p-4 sm:p-6 group hover:shadow-2xl hover:-translate-y-1">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600 dark:text-gray-200 font-semibold text-sm sm:text-lg">Total Pesanan</span>
                <span class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-green-100 dark:bg-green-300/20 group-hover:scale-110 transition-transform"></span>
            </div>
            <div class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-green-600 mb-1 group-hover:text-green-700 dark:group-hover:text-green-400 transition-colors">{{ number_format($totalOrders) }}</div>
            <div class="text-gray-500 dark:text-gray-300 text-xs sm:text-sm lg:text-base">Total pesanan masuk</div>
        </div>
        <!-- Total Produk -->
        <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-lg border border-transparent hover:border-purple-400 dark:hover:border-purple-500 transition-all duration-300 p-4 sm:p-6 group hover:shadow-2xl hover:-translate-y-1">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600 dark:text-gray-200 font-semibold text-sm sm:text-lg">Total Produk</span>
                <span class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-purple-100 dark:bg-purple-300/20 group-hover:scale-110 transition-transform"></span>
            </div>
            <div class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-purple-600 mb-1 group-hover:text-purple-700 dark:group-hover:text-purple-400 transition-colors">{{ number_format($totalProducts) }}</div>
            <div class="text-gray-500 dark:text-gray-300 text-xs sm:text-sm lg:text-base">Total produk tersedia</div>
        </div>
    </div>
    
    <!-- Sales Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-4 sm:mb-6">
        <!-- Daily Sales -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6">
            <h5 class="text-gray-500 dark:text-gray-400 font-semibold mb-2 sm:mb-3 text-sm sm:text-base">Penjualan Harian</h5>
            <div class="flex justify-between items-center">
                <div class="flex items-center text-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-6 sm:w-6 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    <span class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800 dark:text-white">Rp {{ number_format($dailySales, 0, ',', '.') }}</span>
                </div>
                <span class="font-semibold text-gray-600 dark:text-gray-300 text-xs sm:text-sm">67%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 sm:h-2 mt-2 sm:mt-3">
                <div class="bg-gradient-to-r from-cyan-400 to-green-500 h-1.5 sm:h-2 rounded-full" style="width: 67%"></div>
            </div>
        </div>
        <!-- Monthly Sales -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6">
            <h5 class="text-gray-500 dark:text-gray-400 font-semibold mb-2 sm:mb-3 text-sm sm:text-base">Penjualan Bulanan</h5>
            <div class="flex justify-between items-center">
                <div class="flex items-center text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-6 sm:w-6 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                    <span class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800 dark:text-white">Rp {{ number_format($monthlySalesTotal, 0, ',', '.') }}</span>
                </div>
                <span class="font-semibold text-gray-600 dark:text-gray-300 text-xs sm:text-sm">36%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 sm:h-2 mt-2 sm:mt-3">
                <div class="bg-purple-500 h-1.5 sm:h-2 rounded-full" style="width: 36%"></div>
            </div>
        </div>
        <!-- Yearly Sales -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6">
            <h5 class="text-gray-500 dark:text-gray-400 font-semibold mb-2 sm:mb-3 text-sm sm:text-base">Penjualan Tahunan</h5>
            <div class="flex justify-between items-center">
                <div class="flex items-center text-green-500">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-6 sm:w-6 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    <span class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800 dark:text-white">Rp {{ number_format($yearlySales, 0, ',', '.') }}</span>
                </div>
                <span class="font-semibold text-gray-600 dark:text-gray-300 text-xs sm:text-sm">80%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 sm:h-2 mt-2 sm:mt-3">
                <div class="bg-gradient-to-r from-teal-400 to-blue-500 h-1.5 sm:h-2 rounded-full" style="width: 80%"></div>
            </div>
        </div>
    </div>

    <!-- Rating and Recent Users -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
        <!-- Rating -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6 min-h-[120px] sm:min-h-[150px]">
            <h5 class="text-gray-600 dark:text-gray-300 font-semibold text-sm sm:text-base">Penilaian</h5>
            <!-- Placeholder for rating content -->
        </div>
        <!-- Recent Users -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6 min-h-[120px] sm:min-h-[150px]">
            <h5 class="text-gray-600 dark:text-gray-300 font-semibold text-sm sm:text-base">Pengguna Terbaru</h5>
            <!-- Placeholder for recent users content -->
        </div>
    </div>
@endsection

