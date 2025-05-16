<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex">

<!-- Sidebar -->
<aside id="sidebar" class="w-64 bg-white dark:bg-gray-800 shadow-lg h-screen sticky top-0 transition-all duration-300 overflow-hidden">
    <div class="flex justify-between items-center p-4 border-b dark:border-gray-700">
        <span class="font-bold text-blue-600 dark:text-blue-400 sidebar-label">Toko Usaha Muda</span>
        <button onclick="toggleSidebar()">
            <i id="sidebar-icon" data-lucide="chevron-left"></i>
        </button>
    </div>
    <nav class="px-4 py-4 space-y-3">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 hover:text-blue-600">
            <i data-lucide="layout-dashboard"></i>
            <span class="sidebar-label">Dashboard</span>
        </a>
        <a href="{{ route('products.index') }}" class="flex items-center gap-2 hover:text-blue-600">
            <i data-lucide="package"></i>
            <span class="sidebar-label">Produk</span>
        </a>
        <a href="{{ route('categories.index') }}" class="flex items-center gap-2 hover:text-blue-600">
            <i data-lucide="layers"></i>
            <span class="sidebar-label">Kategori</span>
        </a>
        <a href="{{ route('orders.index') }}" class="flex items-center gap-2 hover:text-blue-600">
            <i data-lucide="shopping-cart"></i>
            <span class="sidebar-label">Pesanan</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-2 text-red-500 hover:underline">
                <i data-lucide="log-out"></i>
                <span class="sidebar-label">Logout</span>
            </button>
        </form>
    </nav>
</aside>

<!-- Main Content -->
<main class="flex-1">
    <div class="flex justify-between items-center px-6 py-4 bg-white dark:bg-gray-800 shadow">
        <h1 class="text-2xl font-semibold">@yield('title', 'Dashboard')</h1>
        <div class="flex gap-4 items-center">
            <button onclick="toggleDarkMode()"><i data-lucide="moon"></i></button>
            <button id="notifBtn" class="relative">
                <i data-lucide="bell"></i>
                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
        </div>
    </div>

    <div class="px-6 py-4">
        @yield('content')
    </div>
</main>

<script>
    // Inisialisasi ikon
    lucide.createIcons();

    // Toggle Dark Mode
    function toggleDarkMode() {
        document.documentElement.classList.toggle('dark');
        lucide.createIcons();
    }

    // Toggle Sidebar
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const labels = document.querySelectorAll('.sidebar-label');
        const icon = document.getElementById('sidebar-icon');

        const isCollapsed = sidebar.classList.contains('w-16');

        sidebar.classList.toggle('w-64', isCollapsed);
        sidebar.classList.toggle('w-16', !isCollapsed);

        labels.forEach(label => label.classList.toggle('hidden', !isCollapsed));

        icon.setAttribute('data-lucide', isCollapsed ? 'chevron-left' : 'chevron-right');
        lucide.createIcons();
    }
</script>

</body>
</html>
