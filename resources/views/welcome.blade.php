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

    <!-- Header -->
    <header class="w-full max-w-[335px] lg:max-w-4xl text-sm mb-6">
        @if (Route::has('login'))
        <nav class="flex justify-end items-center gap-4">
            @auth
            <a href="{{ url('/dashboard') }}" class="px-5 py-1.5 border border-gray-300 rounded hover:bg-gray-100 hover:scale-105 transition"> Dashboard </a>
            @else
            <a href="{{ route('login') }}" class="px-5 py-1.5 border border-gray-300 rounded hover:bg-blue-500 hover:scale-105 transition"> Log in </a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="px-5 py-1.5 border border-gray-300 rounded hover:bg-blue-500 hover:scale-105 transition"> Register </a>
            @endif
            @endauth
        </nav>
        @endif
    </header>

    <!-- Main Content -->
    <main class="text-center">
        <h1 class="text-3xl font-bold mb-2 transition duration-1000 transform translate-y-[-10px] opacity-0 animate-fadeIn"> Selamat datang di Toko Usaha Muda </h1>
        <p class="text-lg text-gray-600 italic mb-4">Temukan produk berkualitas dari Kami</p>
        <div class="mt-4 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-20 w-20 text-blue-500 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 8 4-16 3 8h4"/>
            </svg>
        </div>
        <p class="text-base text-gray-700 max-w-2xl mx-auto mb-6">
            Kami hadir untuk membantu Anda menemukan berbagai produk yang berkualitas, berbahan dasar lembut.
        </p>

        <!-- Produk Section -->
        <section id="produk" class="mt-20 px-4">
            <h2 class="text-2xl font-semibold mb-6 relative after:content-[''] after:block after:w-20 after:h-1 after:bg-blue-500 after:mx-auto after:rounded-full after:transition-all after:duration-400 hover:after:w-32"> Produk Unggulan </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
                <div class="bg-gray-100 p-4 rounded-xl shadow hover:shadow-lg transition">
                    <img src="/image/BenangObras.png" alt="Benang Obras" class="w-full h-48 object-cover rounded mb-3">
                    <p class="text-lg font-medium">Benang Obras</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-xl shadow hover:shadow-lg transition">
                    <img src="/image/KainKatun.png" alt="Kain Katun" class="w-full h-48 object-cover rounded mb-3">
                    <p class="text-lg font-medium">Kain Katun</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-xl shadow hover:shadow-lg transition">
                    <img src="/image/Renda.png" alt="Renda" class="w-full h-48 object-cover rounded mb-3">
                    <p class="text-lg font-medium">Renda</p>
                </div>
            </div>
        </section>

        <!-- Testimoni Section -->
        <section class="mt-20 px-4">
            <h2 class="text-2xl font-semibold mb-6">Apa Kata Mereka?</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
                <div class="bg-blue-100 p-4 rounded-xl shadow hover:shadow-lg transition flex flex-col items-center">
                    <img src="/image/Akbar.jpg" alt="Akbar"
                         class="w-24 h-24 object-cover object-center rounded-full mb-3 ring-4 ring-white">
                    <p class="italic text-gray-600">“Produknya keren banget dan pengirimannya cepat. Mantap!”</p>
                    <div class="mt-2 text-sm text-gray-500">— Akbar, Padang</div>
                </div>
                <div class="bg-blue-100 p-4 rounded-xl shadow hover:shadow-lg transition flex flex-col items-center">
                    <img src="/image/Dini.jpg" alt="Dini"
                         class="w-24 h-24 object-cover object-center rounded-full mb-3 ring-4 ring-white">
                    <p class="italic text-gray-600">“Saya sangat puas dengan produknya dan pelayanannya. Terimakasih!”</p>
                    <div class="mt-2 text-sm text-gray-500">— Dini, Solok</div>
                </div>
                <div class="bg-blue-100 p-4 rounded-xl shadow hover:shadow-lg transition flex flex-col items-center">
                    <img src="/image/wahyu.jpg" alt="Wahyu"
                         class="w-24 h-24 object-cover object-center rounded-full mb-3 ring-4 ring-white">
                    <p class="italic text-gray-600">“Produknya sangat berkualitas dan harganya terjangkau. Saya sangat merekomendasikan!”</p>
                    <div class="mt-2 text-sm text-gray-500">— Wahyu, Solok</div>
                </div>
            </div>
        </section>
        

        <!-- Hubungi Kami Section -->
        <section class="mt-20 max-w-xl mx-auto">
            <h2 class="text-2xl font-semibold mb-4">Hubungi Kami</h2>
            <form onsubmit="submitForm(event)" class="flex flex-col gap-4">
                <input type="text" placeholder="Nama Anda" required class="p-2 border rounded">
                <input type="email" placeholder="Email Anda" required class="p-2 border rounded">
                <textarea placeholder="Pesan Anda" required class="p-2 border rounded"></textarea>
                <button type="submit" class="bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">Kirim Pesan</button>
            </form>
            <p id="thanksMessage"class="mt-4 text-green-600 font-semibold opacity-0 transition-opacity duration-500">Terima kasih! 🎉</p>
        </section>
    </main>

    <!-- Footer -->
    <footer class="mt-20 bg-gray-100 p-6 text-center rounded-t-2xl">
        <h3 class="text-xl font-semibold mb-2">Dukung Usaha Muda Indonesia 💡</h3>
        <p class="text-gray-600 mb-4 max-w-xl mx-auto">Follow kami di sosial media & jadilah bagian dari komunitas pengusaha muda.</p>
        <div class="flex justify-center gap-6 flex-wrap">
            <a href="https://www.instagram.com/toko.usahamuda?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="hover:text-blue-600 transition">Instagram</a>
            <a href="#" target="_blank" class="hover:text-blue-600 transition">Facebook</a>
            <a href="#" target="_blank" class="hover:text-blue-600 transition">Twitter</a>
            <a href="https://wa.me/628116655050" target="_blank" class="hover:text-blue-600 transition">WhatsApp</a>
        </div>
    </footer>
    <button id="scrollTopBtn"
        class="hidden fixed bottom-6 right-6 bg-blue-500 text-white w-12 h-12 rounded-full flex items-center justify-center text-2xl shadow hover:bg-blue-600 transition">
        ↑
    </button>
    <script>
        window.addEventListener('load', () => {
            const title = document.querySelector('h1');
            title.classList.remove('translate-y-[-10px]', 'opacity-0');
        });

        function submitForm(event) {
            event.preventDefault();
            const thanksMessage = document.getElementById('thanksMessage');
            thanksMessage.classList.remove('opacity-0');
        }

        window.addEventListener('scroll', () => {
            const scrollTopBtn = document.getElementById('scrollTopBtn');
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.remove('hidden');
            } else {
                scrollTopBtn.classList.add('hidden');
            }
        });

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>

</body>

</html>
