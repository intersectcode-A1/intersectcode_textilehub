<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Sistem Aplikasi' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('image/img_logo_tokousahamuda.png') }}">
    
    {{-- Font Awesome for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Tailwind --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- Optional background gradient --}}
    <style>
        body {
            background: linear-gradient(to right, #dbeafe, #93c5fd);
        }
    </style>

    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    {{-- HEADER --}}
    <header class="bg-[#1859E7] shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-white flex items-center font-serif">
                <img class="h-10" src="{{ asset('image/img_logo_tokousahamuda.png') }}" alt="Toko Usaha Muda">
                Toko Usaha Muda
            </h1>
            <nav>
                <a href="/" class="bg-white px-3 py-1 rounded-lg text-sm mx-2 hover:text-blue-500">Beranda</a>
            </nav>
        </div>
    </header>

    {{-- CONTENT --}}
    <main class="flex-grow container mx-auto p-6">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-200 border-t p-4 mt-6">
        <div class="container mx-auto text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} intersectcode. All rights reserved.
        </div>
    </footer>

    @livewireScripts
</body>
</html>
