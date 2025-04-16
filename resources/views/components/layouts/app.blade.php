<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Sistem Aplikasi' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    {{-- HEADER --}}
    <header class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-600">Sistem Aplikasi</h1>
            <nav>
                <a href="/" class="text-sm mx-2 hover:text-blue-500">Beranda</a>
                <a href="/login" class="text-sm mx-2 hover:text-blue-500">Login</a>
                <a href="/register" class="text-sm mx-2 hover:text-blue-500">Register</a>
            </nav>
        </div>
    </header>

    {{-- CONTENT --}}
    <main class="flex-grow container mx-auto p-6">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="bg-white border-t p-4 mt-6">
        <div class="container mx-auto text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Sistem Aplikasi by Abid Mustaghfirin. All rights reserved.
        </div>
    </footer>

    @livewireScripts
</body>
</html>
