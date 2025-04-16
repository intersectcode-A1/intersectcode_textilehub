<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">

    {{-- HEADER --}}
    <header class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-semibold text-blue-600">Dashboard</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 text-black px-4 py-2 rounded hover:bg-red-600">
                    Logout
                </button>
            </form>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="flex-grow container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Selamat datang di Dashboard</h2>
        <p class="text-gray-700">Ini adalah halaman dashboard setelah login berhasil.</p>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-white border-t p-4">
        <div class="container mx-auto text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Sistem Aplikasi by Abid Mustaghfirin.
        </div>
    </footer>

    @livewireScripts
</body>
</html>
