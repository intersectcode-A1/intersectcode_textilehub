<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Tambahan: Background gradient & animasi -->
<style>
    body {
    background: linear-gradient(135deg, #1e293b, #3b0764, #2563eb, #0f172a);
    background-size: 400% 400%;
    animation: gradientFlow 15s ease infinite;
}
@keyframes gradientFlow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}


    #mainTitle {
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 1s ease, transform 1s ease;
    }

    #mainTitle.opacity-100 {
        opacity: 1;
        transform: translateY(0);
    }

    /* Tambahan: efek hover tombol */
    nav a:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: scale(1.05);
    }

    nav a {
        transition: all 0.3s ease;
    }

    /* Tambahan: efek teks heading */
    h1::after {
        content: '';
        display: block;
        width: 80px;
        height: 3px;
        background: #3b82f6;
        margin: 8px auto 0;
        border-radius: 9999px;
        transition: width 0.4s ease;
    }

    h1:hover::after {
        width: 120px;
    }

    /* Tambahan: animasi teks terima kasih */
    #thanksMessage {
        transition: opacity 0.6s ease;
    }

    #thanksMessage.hidden {
        opacity: 0;
    }

    #thanksMessage:not(.hidden) {
        opacity: 1;
    }
    
</style>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-gray-800 text-white flex p-6 lg:p-8 items-center lg:justify-center flex-col">

    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-1.5 border text-gray-700 border-gray-300 hover:border-gray-400 rounded-sm text-sm">Dashboard</a>
                @else
                <a href="{{ route('login') }}"
                class="px-5 py-1.5 border border-white text-white-700 hover:text-white-600 text-sm rounded transition duration-200 active:scale-95 ease-in-out hover:bg-white/10">
                Log in</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                    class="px-5 py-1.5 border text-white-700 border-white-300 hover:border-white-400 hover:bg-white/10 rounded-sm text-sm transition duration-200 ease-in-out active:scale-95">
                    Register</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <main class="text-center">
        <h1 class="text-3xl font-bold mb-2 text-black-700 transition-opacity duration-1000" id="mainTitle">
            Selamat datang di Toko Usaha Muda
        </h1>
    
        <!-- Tambahan: Slogan -->
        <p class="text-lg text-gray-300 italic mb-4">Temukan produk berkualitas dari Kami</p>
    
        <!-- Tambahan: Ikon ilustrasi -->
        <div class="mt-4 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-20 w-20 text-black-500 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 8 4-16 3 8h4" />
            </svg>
        </div>
    
        <!-- Tambahan: Sambutan -->
        <p class="text-base text-black-400 max-w-2xl mx-auto mb-6">
            Kami hadir untuk membantu Anda menemukan berbagai produk yang berkualitas,
            berbahan dasar lembut
        </p>
    
        <!-- Tambahan: Tombol CTA -->
        <a href="#produk" class="inline-block px-6 py-2 text-sm bg-blue-600 hover:bg-blue-700 rounded-full text-white shadow-md transition duration-300 ease-in-out animate-pulse">
            Lihat Produk Unggulan
        </a>
    
        <!-- Tetap: Pesan terima kasih -->
        <p id="thanksMessage" class="mt-4 text-green-600 font-semibold hidden">Terima kasih! 🎉</p>

        <section class="mt-20 text-white text-center">
            <h2 class="text-2xl font-semibold mb-6">Apa Kata Mereka?</h2>
            <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto px-4">
                <div class="bg-gray-700 p-4 rounded-xl shadow">
                    <p class="italic text-gray-300">“Produknya keren banget dan pengirimannya cepat. Mantap!”</p>
                    <div class="mt-2 text-sm text-gray-400">— Rina, Jakarta</div>
                </div>
                <div class="bg-gray-700 p-4 rounded-xl shadow">
                    <p class="italic text-gray-300">“Usaha muda yang sangat inspiratif. Aku pasti repeat order!”</p>
                    <div class="mt-2 text-sm text-gray-400">— Budi, Bandung</div>
                </div>
                <div class="bg-gray-700 p-4 rounded-xl shadow">
                    <p class="italic text-gray-300">“Kualitas oke, harga terjangkau. Sukses terus!”</p>
                    <div class="mt-2 text-sm text-gray-400">— Ayu, Surabaya</div>
                </div>
            </div>
        </section>
        
    </main>
    
    
    <script>
        // Fade in on load
        window.addEventListener('load', () => {
            document.getElementById('mainTitle').classList.add('opacity-100');
        });

        // (Optional) Toggle Dark Mode
        function toggleDarkMode() {
            // Disabled dark mode permanently by not toggling class
            alert("Tema gelap dinonaktifkan. Tema saat ini adalah terang.");
        }

        // Submit handler
        function submitForm(event) {
            event.preventDefault();
            document.getElementById('thanksMessage').classList.remove('hidden');
        }
    </script>

<footer class="mt-20 bg-gray-900 p-6 text-center text-white rounded-t-2xl">
    <h3 class="text-xl font-semibold mb-2">Dukung Usaha Muda Indonesia 💡</h3>
    <p class="text-gray-400 mb-4">Follow kami di sosial media & jadilah bagian dari komunitas pengusaha muda.</p>
    <div class="flex justify-center gap-4">
        <a href="#" class="hover:text-blue-400 transition">Instagram</a>
        <a href="#" class="hover:text-blue-400 transition">Facebook</a>
        <a href="#" class="hover:text-blue-400 transition">Twitter</a>
    </div>
</footer>

</body>
</html>