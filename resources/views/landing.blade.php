<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Toko UsahaMuda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 antialiased">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-600">toko.usahamuda</h1>
            <div class="space-x-4">
                <a href="/login" class="text-sm text-gray-700 hover:text-blue-600">Login</a>
                <a href="/register" class="text-sm text-white bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-blue-50 py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Belanja Kebutuhan Menjahit Jadi Lebih Mudah</h2>
            <p class="text-lg text-gray-600 mb-6">Temukan benang, kain, renda, kancing, dan perlengkapan menjahit lainnya di satu tempat</p>
            <a href="/login" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">Mulai Belanja</a>
        </div>
    </section>

    <!-- Kategori Produk -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Kategori Produk</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white border p-4 rounded-lg shadow text-center">
                    <img src="/images/benang.png" alt="Benang" class="h-20 mx-auto mb-2">
                    <p>Benang</p>
                </div>
                <div class="bg-white border p-4 rounded-lg shadow text-center">
                    <img src="/images/kain.png" alt="Kain" class="h-20 mx-auto mb-2">
                    <p>Kain</p>
                </div>
                <div class="bg-white border p-4 rounded-lg shadow text-center">
                    <img src="/images/renda.png" alt="Renda" class="h-20 mx-auto mb-2">
                    <p>Renda</p>
                </div>
                <div class="bg-white border p-4 rounded-lg shadow text-center">
                    <img src="/images/mesin-jahit.png" alt="Mesin Jahit" class="h-20 mx-auto mb-2">
                    <p>Mesin Jahit</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section class="bg-gray-100 py-16">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Tentang UsahaMuda</h3>
            <p class="text-gray-600">UsahaMuda adalah platform belanja online khusus perlengkapan menjahit, hadir untuk membantu UMKM dan penjahit rumahan mendapatkan bahan dan alat terbaik dengan mudah dan terpercaya.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-600">
            &copy; 2025 UsahaMuda. All rights reserved.
        </div>
    </footer>
</body>
</html>