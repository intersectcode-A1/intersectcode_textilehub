<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Usaha Muda</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-800 font-sans flex flex-col items-center p-6 lg:p-8">

    <!-- Navbar -->
    <header class="w-full text-sm mb-6">
        <div class="max-w-7xl mx-auto px-6">
            @if (Route::has('login'))
            <nav class="flex justify-between items-center">
                <!-- Logo Toko Usaha Muda -->
                <div class="text-2xl font-bold text-blue-500">
                    <a href="/">Toko Usaha Muda</a>
                </div>
                <!-- Navbar Links -->
                <div class="hidden md:flex space-x-6">
                    <a href="#produk" class="px-4 py-2 hover:bg-gray-100 rounded">Produk</a>
                    <a href="#testimoni" class="px-4 py-2 hover:bg-gray-100 rounded">Testimoni</a>
                    <a href="#hubungi" class="px-4 py-2 hover:bg-gray-100 rounded">Hubungi Kami</a>
                    @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-1.5 border border-gray-300 rounded hover:bg-gray-100 hover:scale-105 transition"> Dashboard </a>
                    @else
                    <a href="{{ route('login') }}" class="px-5 py-1.5 border border-gray-300 rounded hover:bg-blue-500 hover:scale-105 transition"> Log in </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-5 py-1.5 border border-gray-300 rounded hover:bg-blue-500 hover:scale-105 transition"> Register </a>
                    @endif
                    @endauth
                </div>
                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </nav>
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <main class="text-center">
        <!-- Hero Section -->
        <section class="relative bg-cover bg-center bg-no-repeat text-white py-24 px-6 rounded-xl shadow mb-10 overflow-hidden" style="background-image: url('/image/ceo.jpg');">
            <div class="absolute inset-0 bg-black/60 rounded-xl"></div>
            <div class="relative z-10 max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white drop-shadow-lg animate-fadeIn">
                    Selamat datang di Toko Usaha Muda
                </h1>
                <p class="text-lg md:text-xl italic mb-6 text-white">Temukan produk berkualitas dari Kami</p>
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-blue-400 animate-bounce mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 8 4-16 3 8h4" /></svg>
                <p class="text-base text-gray-100 leading-relaxed">
                    Kami hadir untuk membantu Anda menemukan berbagai produk yang berkualitas, berbahan dasar lembut.
                </p>
            </div>
        </section>

        <!-- Produk Section -->
        <section id="produk" class="mt-20 px-4">
            <h2 class="text-2xl font-semibold mb-6 text-center relative after:content-[''] after:block after:w-20 after:h-1 after:bg-blue-500 after:mx-auto after:rounded-full after:mt-2 after:transition-all after:duration-400 after:mb-4 hover:after:w-32"> Produk Unggulan </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
                <div class="bg-gray-100 p-4 rounded-xl shadow hover:shadow-lg transition flex flex-col items-center">
                    <img src="/image/BenangObras.png" alt="Benang Obras" class="w-full h-48 object-cover rounded mb-3">
                    <p class="text-lg font-medium text-center">Benang Obras</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-xl shadow hover:shadow-lg transition flex flex-col items-center">
                    <img src="/image/KainKatun.png" alt="Kain Katun" class="w-full h-48 object-cover rounded mb-3">
                    <p class="text-lg font-medium text-center">Kain Katun</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-xl shadow hover:shadow-lg transition flex flex-col items-center">
                    <img src="/image/Renda.png" alt="Renda" class="w-full h-48 object-cover rounded mb-3">
                    <p class="text-lg font-medium text-center">Renda</p>
                </div>
            </div>
        </section>

        <!-- Testimoni Section -->
        <section class="mt-20 px-4">
            <h2 class="text-2xl font-semibold mb-6">Apa Kata Mereka?</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
                <div class="bg-blue-100 p-4 rounded-xl shadow hover:shadow-lg transition flex flex-col items-center">
                    <img src="/image/Akbar.jpg" alt="Akbar" class="w-24 h-24 object-cover object-center rounded-full mb-3 ring-4 ring-white">
                    <p class="italic text-gray-600">“Produknya keren banget dan pengirimannya cepat. Mantap!”</p>
                    <div class="mt-2 text-sm text-gray-500">— Akbar, Padang</div>
                </div>
                <div class="bg-blue-100 p-4 rounded-xl shadow hover:shadow-lg transition flex flex-col items-center">
                    <img src="/image/Dini.jpg" alt="Dini" class="w-24 h-24 object-cover object-center rounded-full mb-3 ring-4 ring-white">
                    <p class="italic text-gray-600">“Saya sangat puas dengan produknya dan pelayanannya. Terimakasih!”</p>
                    <div class="mt-2 text-sm text-gray-500">— Dini, Solok</div>
                </div>
                <div class="bg-blue-100 p-4 rounded-xl shadow hover:shadow-lg transition flex flex-col items-center">
                    <img src="/image/wahyu.jpg" alt="Wahyu" class="w-24 h-24 object-cover object-center rounded-full mb-3 ring-4 ring-white">
                    <p class="italic text-gray-600">“Produknya sangat berkualitas dan harganya terjangkau. Saya sangat merekomendasikan!”</p>
                    <div class="mt-2 text-sm text-gray-500">— Wahyu, Solok</div>
                </div>
            </div>
        </section>

        <!-- Hubungi Kami Section -->
        <section class="mt-20 max-w-3xl mx-auto">
            <h2 class="text-2xl font-semibold mb-4">Hubungi Kami</h2>
            <form onsubmit="submitForm(event)" class="flex flex-col gap-4">
                <input type="text" placeholder="Nama Anda" required class="p-3 border rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="email" placeholder="Email Anda" required class="p-3 border rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500">
                <textarea placeholder="Pesan Anda" required class="p-3 border rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4"></textarea>
                <button type="submit" class="bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600">Kirim Pesan</button>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <footer class="w-full mt-12 py-4 text-center bg-gray-800 text-white">
        <p>&copy; 2025 Toko Usaha Muda. All Rights Reserved.</p>
    </footer>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="md:hidden fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex justify-end p-6">
            <button id="closeMenuBtn" class="text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex flex-col items-center space-y-6 text-white">
            <a href="#produk" class="hover:bg-gray-700 px-6 py-2 rounded">Produk</a>
            <a href="#testimoni" class="hover:bg-gray-700 px-6 py-2 rounded">Testimoni</a>
            <a href="#hubungi" class="hover:bg-gray-700 px-6 py-2 rounded">Hubungi Kami</a>
            @auth
            <a href="{{ url('/dashboard') }}" class="px-6 py-2 rounded bg-blue-600 hover:bg-blue-500">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="px-6 py-2 rounded bg-blue-600 hover:bg-blue-500">Login</a>
            <a href="{{ route('register') }}" class="px-6 py-2 rounded bg-blue-600 hover:bg-blue-500">Register</a>
            @endauth
        </div>
    </div>

    <script>
        // Open and close the mobile menu
        document.getElementById('mobileMenuBtn').onclick = function() {
            document.getElementById('mobileMenu').classList.remove('hidden');
        }
        document.getElementById('closeMenuBtn').onclick = function() {
            document.getElementById('mobileMenu').classList.add('hidden');
        }
    </script>
</body>

</html>
