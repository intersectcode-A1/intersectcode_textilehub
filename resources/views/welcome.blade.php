<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
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
                    <a href="{{ route('login') }}" class="px-5 py-1.5 text-gray-700 hover:text-blue-600 text-sm">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-5 py-1.5 border text-gray-700 border-gray-300 hover:border-blue-400 rounded-sm text-sm">Register</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <main class="text-center">
        <h1 class="text-3xl font-bold mb-4 text-blue-700 transition-opacity duration-1000" id="mainTitle">
            Selamat datang di Laravel
        </h1>
        <form onsubmit="submitForm(event)" class="flex flex-col sm:flex-row items-center gap-2">
            <input type="email" placeholder="Masukkan email..." class="px-4 py-2 border border-gray-300 rounded w-64" required />
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Kirim
            </button>
        </form>

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
