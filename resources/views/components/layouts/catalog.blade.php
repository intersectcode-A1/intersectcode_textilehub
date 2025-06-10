<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Sistem Aplikasi' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('image/img_logo_tokousahamuda.png') }}">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { 
            display: none !important; 
        }
        
        /* Custom Styles */
        .product-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        
        .product-card:hover {
            transform: translateY(-4px);
        }
        
        .btn-primary {
            @apply bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500;
        }
        
        .btn-secondary {
            @apply bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-gray-500;
        }
    </style>

    @livewireStyles
</head>
<body class="min-h-screen flex flex-col bg-gray-50">
    {{-- HEADER --}}
    <header class="bg-primary-600 shadow-md">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Top Navigation --}}
            <div class="flex justify-between items-center h-16">
                {{-- Logo --}}
                <a href="/" class="flex items-center space-x-3">
                    <img class="h-10" src="{{ asset('image/img_logo_tokousahamuda.png') }}" alt="Toko Usaha Muda">
                    <span class="text-xl font-bold text-white font-serif">Toko Usaha Muda</span>
                </a>

                {{-- Navigation --}}
                <nav class="hidden md:flex items-center space-x-4">
                    <a href="/" class="text-white hover:text-blue-100 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                        Beranda
                    </a>
                    @auth
                        {{-- Cart Icon --}}
                        <x-cart-icon />

                        {{-- Order Status Icon --}}
                        <x-order-status-icon />

                        {{-- User Menu --}}
                        <div class="relative" x-data="{ open: false }" x-cloak>
                            <button @click="open = !open" class="flex items-center text-white hover:text-blue-100 focus:outline-none">
                                <div class="flex items-center space-x-2">
                                    @if(auth()->user()->profile_photo)
                                        <img class="h-8 w-8 rounded-full border-2 border-white object-cover" 
                                             src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                             alt="{{ auth()->user()->name }}">
                                    @else
                                        <img class="h-8 w-8 rounded-full border-2 border-white" 
                                             src="https://i.pravatar.cc/100?u={{ auth()->user()->email }}" 
                                             alt="{{ auth()->user()->name }}">
                                    @endif
                                    <span class="hidden sm:inline text-sm">{{ auth()->user()->name }}</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div x-show="open" 
                                 @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50">
                                <div class="py-1">
                                    <a href="{{ route('profile.show') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50">
                                        <i class="fas fa-user mr-3 text-gray-400 group-hover:text-primary-500"></i>
                                        Profil Saya
                                    </a>
                                    <a href="{{ route('purchase.history') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50">
                                        <i class="fas fa-history mr-3 text-gray-400 group-hover:text-primary-500"></i>
                                        Riwayat Pembelian
                                    </a>
                                </div>
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="group flex w-full items-center px-4 py-2 text-sm text-red-700 hover:bg-red-50">
                                            <i class="fas fa-sign-out-alt mr-3 text-red-400 group-hover:text-red-500"></i>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-blue-100 px-3 py-2 rounded-md text-sm font-medium">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-white text-primary-600 hover:bg-blue-50 px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                            Daftar
                        </a>
                    @endauth
                </nav>

                {{-- Mobile menu button --}}
                <div class="md:hidden">
                    <button type="button" 
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="text-white hover:text-blue-100 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    {{-- Mobile Navigation Menu --}}
    <div x-data="{ mobileMenuOpen: false }" 
         x-show="mobileMenuOpen" 
         x-cloak
         class="md:hidden bg-white border-b shadow-lg">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                Beranda
            </a>
            @auth
                <a href="{{ route('profile.show') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Profil Saya
                </a>
                <a href="{{ route('purchase.history') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Riwayat Pembelian
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-700 hover:text-red-900 hover:bg-red-50">
                        Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-primary-600 hover:text-primary-700 hover:bg-primary-50">
                    Daftar
                </a>
            @endauth
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="bg-white border-t mt-auto">
        <div class="container mx-auto px-4 py-6">
            <div class="text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Toko Usaha Muda. All rights reserved.
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>