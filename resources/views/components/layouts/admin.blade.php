<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white shadow-lg h-screen sticky top-0">
        <div class="p-6 font-bold text-lg text-blue-600">
            Toko Usaha Muda
        </div>
        <nav class="px-6">
            <ul class="space-y-3">
                <li><a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline">Dashboard</a></li>
                <li><a href="{{ route('products.index') }}" class="text-blue-500 hover:underline">Products</a></li>
                <li><a href="{{ route('categories.index') }}" class="text-blue-500 hover:underline">Categories</a></li>
                <li><a href="{{ route('orders.index') }}" class="text-blue-500 hover:underline">Orders</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-500 hover:underline">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 overflow-y-auto">
        <div class="bg-white shadow px-6 py-4">
            <h1 class="text-2xl font-bold text-gray-800">Admin Panel</h1>
        </div>
        <div class="px-6 py-4">
            @yield('content')
        </div>
    </main>

</body>
</html>
