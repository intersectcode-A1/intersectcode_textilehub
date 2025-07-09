<div id="sidebar" class="flex-shrink-0 bg-gray-800 shadow-lg h-screen sticky top-0 transition-all duration-300 flex flex-col z-50 backdrop-blur-lg" role="navigation" aria-label="Sidebar Admin">
    <!-- Mobile Header -->
    <div class="lg:hidden flex items-center justify-between p-4 border-b border-gray-700">
        <div class="flex items-center gap-3">
            <img src="{{ asset('image/img_logo_tokousahamuda.png') }}" alt="Toko Usaha Muda" class="h-8 w-auto rounded-full">
            <span class="font-bold text-lg text-white">Toko Usaha Muda</span>
        </div>
        <button onclick="closeMobileSidebar()" class="text-gray-400 hover:text-white focus:outline-none" aria-label="Tutup Menu Sidebar">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-700/50 scrollbar-track-transparent">
        <!-- Desktop Logo -->
        <div class="hidden lg:flex items-center gap-3 p-2 mb-4 border-b border-gray-700 pb-4">
            <img src="{{ asset('image/img_logo_tokousahamuda.png') }}" alt="Toko Usaha Muda" class="h-10 w-auto rounded-full">
            <span class="font-bold text-xl text-white sidebar-label tracking-wide">Toko Usaha Muda</span>
        </div>
        
        <div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'flex items-center gap-3 py-2 px-3 rounded-lg text-white font-semibold bg-gray-700 border-l-4 border-blue-500' : 'flex items-center gap-3 py-2 px-3 rounded-lg text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors duration-200">
                <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                <span class="sidebar-label">Dashboard</span>
            </a>
        </div>
        <div>
            <h3 class="text-xs text-gray-400 font-semibold mb-2 pl-2 uppercase tracking-wider sidebar-label">Master Data</h3>
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'flex items-center gap-3 py-2 px-3 rounded-lg text-white font-semibold bg-gray-700 border-l-4 border-blue-500' : 'flex items-center gap-3 py-2 px-3 rounded-lg text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors duration-200">
                <i data-lucide="package" class="w-5 h-5 flex-shrink-0"></i>
                <span class="sidebar-label">Produk</span>
            </a>
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'flex items-center gap-3 py-2 px-3 rounded-lg text-white font-semibold bg-gray-700 border-l-4 border-blue-500' : 'flex items-center gap-3 py-2 px-3 rounded-lg text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors duration-200">
                <i data-lucide="layers" class="w-5 h-5 flex-shrink-0"></i>
                <span class="sidebar-label">Kategori</span>
            </a>
            <a href="{{ route('supplier.index') }}" class="{{ request()->routeIs('supplier.*') ? 'flex items-center gap-3 py-2 px-3 rounded-lg text-white font-semibold bg-gray-700 border-l-4 border-blue-500' : 'flex items-center gap-3 py-2 px-3 rounded-lg text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors duration-200">
                <i data-lucide="truck" class="w-5 h-5 flex-shrink-0"></i>
                <span class="sidebar-label">Kelola Supplier</span>
            </a>
        </div>
        <div>
            <h3 class="text-xs text-gray-400 font-semibold mb-2 pl-2 uppercase tracking-wider sidebar-label">Transaksi</h3>
            <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'flex items-center gap-3 py-2 px-3 rounded-lg text-white font-semibold bg-gray-700 border-l-4 border-blue-500' : 'flex items-center gap-3 py-2 px-3 rounded-lg text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors duration-200">
                <i data-lucide="shopping-cart" class="w-5 h-5 flex-shrink-0"></i>
                <span class="sidebar-label">Pesanan</span>
            </a>
            <a href="{{ route('admin.harga-strategi.index') }}" class="{{ request()->routeIs('admin.harga-strategi.*') ? 'flex items-center gap-3 py-2 px-3 rounded-lg text-white font-semibold bg-gray-700 border-l-4 border-blue-500' : 'flex items-center gap-3 py-2 px-3 rounded-lg text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors duration-200">
                <i data-lucide="trending-up" class="w-5 h-5 flex-shrink-0"></i>
                <span class="sidebar-label">Strategi Harga</span>
            </a>
        </div>
        <div>
            <h3 class="text-xs text-gray-400 font-semibold mb-2 pl-2 uppercase tracking-wider sidebar-label">Pelaporan</h3>
            <a href="{{ route('admin.sales.analysis') }}" class="{{ request()->routeIs('admin.sales.analysis') ? 'flex items-center gap-3 py-2 px-3 rounded-lg text-white font-semibold bg-gray-700 border-l-4 border-blue-500' : 'flex items-center gap-3 py-2 px-3 rounded-lg text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors duration-200">
                <i data-lucide="bar-chart-3" class="w-5 h-5 flex-shrink-0"></i>
                <span class="sidebar-label">Analisis Penjualan</span>
            </a>
            <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'flex items-center gap-3 py-2 px-3 rounded-lg text-white font-semibold bg-gray-700 border-l-4 border-blue-500' : 'flex items-center gap-3 py-2 px-3 rounded-lg text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors duration-200">
                <i data-lucide="bar-chart-2" class="w-5 h-5 flex-shrink-0"></i>
                <span class="sidebar-label">Laporan Keuangan</span>
            </a>
            <a href="{{ route('admin.manual-invoice.index') }}" class="{{ request()->routeIs('admin.manual-invoice.*') ? 'flex items-center gap-3 py-2 px-3 rounded-lg text-white font-semibold bg-gray-700 border-l-4 border-blue-500' : 'flex items-center gap-3 py-2 px-3 rounded-lg text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors duration-200">
                <i data-lucide="file-text" class="w-5 h-5 flex-shrink-0"></i>
                <span class="sidebar-label">Invoice Manual</span>
            </a>
        </div>
    </nav>
    <div class="p-4 border-t border-gray-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 py-2 px-3 rounded-lg text-red-400 hover:bg-gray-700 transition w-full">
                <i data-lucide="log-out" class="w-5 h-5 flex-shrink-0"></i>
                <span class="sidebar-label">Keluar</span>
            </button>
        </form>
    </div>
</div>
<style>
/* Custom scrollbar for sidebar */
#sidebar nav::-webkit-scrollbar {
    width: 6px;
}
#sidebar nav::-webkit-scrollbar-thumb {
    background: rgba(107, 114, 128, 0.5); 
    border-radius: 4px;
}
#sidebar nav::-webkit-scrollbar-track {
    background: transparent;
}

/* Mobile responsive adjustments */
@media (max-width: 1023px) {
    #sidebar {
        width: 280px;
    }
}
</style> 