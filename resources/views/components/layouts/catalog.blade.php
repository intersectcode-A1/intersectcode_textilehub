<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Sistem Aplikasi' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
            <h1 class="text-xl font-bold text-white flex items-center font-serif gap-2">
                <img class="h-10" src="{{ asset('image/img_logo_tokousahamuda.png') }}" alt="Toko Usaha Muda">
                Toko Usaha Muda
            </h1>

            {{-- Navigation --}}
            <nav class="flex items-center space-x-4">
                <a href="/" class="text-white text-sm px-3 py-2 rounded-md hover:bg-blue-600 transition duration-150 ease-in-out">Beranda</a>


                @auth
                {{-- Dropdown Akun --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-white focus:outline-none">
                        <img class="h-8 w-8 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?u={{ auth()->user()->email }}" alt="User">
                        <span class="ml-2 hidden sm:inline">{{ auth()->user()->name }}</span>
                        <i class="fa fa-caret-down ml-1"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg z-50 overflow-hidden">
                        <div class="p-4 border-b">
                            <p class="font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                        </div>
                        <ul class="divide-y text-sm text-gray-700">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100"><i class="fa fa-user mr-2"></i>My Account</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100"><i class="fa fa-cog mr-2"></i>Settings</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100"><i class="fa fa-life-ring mr-2"></i>Support</a></li>
                        </ul>
                        <form method="POST" action="{{ route('logout') }}" class="border-t">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 font-semibold">
                                <i class="fa fa-sign-out-alt mr-2"></i>Log Out
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="text-white text-sm hover:underline">Login</a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
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
