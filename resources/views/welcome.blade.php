<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Tambahan: Background gradient & animasi -->
<style>
    body {
        background: linear-gradient(to bottom right, #1e293b, #0f172a);
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
        <h1 class="text-3xl font-bold mb-4 text-blue-700 transition-opacity duration-1000" id="mainTitle">
            Selamat datang di Toko Usaha Muda
        </h1>
        <p id="thanksMessage" class="mt-4 text-green-600 font-semibold hidden">Terima kasih! 🎉</p>
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
</body>
</html>