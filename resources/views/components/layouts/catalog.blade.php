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

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { 
            display: none !important; 
        }
        body {
            font-family: 'Inter', sans-serif;
        }
        .product-card:hover {
            transform: translateY(-4px);
        }
    </style>

    @livewireStyles
</head>
<body class="min-h-screen flex flex-col bg-gray-50">
    {{-- HEADER --}}
    <header class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Top Navigation --}}
            <div class="flex justify-between items-center h-20">
                {{-- Logo --}}
                <a href="/" class="flex items-center space-x-3 group">
                    <img class="h-12 transition-transform duration-300 group-hover:scale-110" 
                         src="{{ asset('image/img_logo_tokousahamuda.png') }}" 
                         alt="Toko Usaha Muda">
                    <span class="text-2xl font-bold text-white font-serif tracking-tight">
                        Toko Usaha Muda
                    </span>
                </a>

                {{-- Navigation --}}
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="/" class="text-white hover:text-blue-100 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out hover:bg-blue-700/50">
                        Beranda
                    </a>
                    @auth
                        {{-- Cart Icon --}}
                        <x-cart-icon />

                        {{-- User Menu --}}
                        <div class="relative" x-data="{ open: false }" x-cloak>
                            <button @click="open = !open" 
                                    class="flex items-center text-white hover:text-blue-100 focus:outline-none transition duration-150 ease-in-out">
                                <div class="flex items-center space-x-3">
                                    @if(auth()->user()->profile_photo)
                                        <img class="h-10 w-10 rounded-full border-2 border-white object-cover shadow-md hover:shadow-lg transition-shadow duration-300" 
                                             src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                             alt="{{ auth()->user()->name }}">
                                    @else
                                        <img class="h-10 w-10 rounded-full border-2 border-white shadow-md hover:shadow-lg transition-shadow duration-300" 
                                             src="https://i.pravatar.cc/100?u={{ auth()->user()->email }}" 
                                             alt="{{ auth()->user()->name }}">
                                    @endif
                                    <div class="hidden sm:block text-left">
                                        <div class="text-sm font-semibold">{{ auth()->user()->name }}</div>
                                        <div class="text-xs text-blue-200">{{ auth()->user()->email }}</div>
                                    </div>
                                    <i class="fas fa-chevron-down text-xs ml-2"></i>
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
                                 class="absolute right-0 mt-3 w-64 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none transform origin-top">
                                <div class="py-2">
                                    <a href="{{ route('profile.show') }}" 
                                       class="group flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 transition duration-150">
                                        <i class="fas fa-user mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                        <div>
                                            <div class="font-medium">Profil Saya</div>
                                            <div class="text-xs text-gray-500">Pengaturan akun dan preferensi</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('purchase.history') }}" 
                                       class="group flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 transition duration-150">
                                        <i class="fas fa-history mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                        <div>
                                            <div class="font-medium">Riwayat Pembelian</div>
                                            <div class="text-xs text-gray-500">Lihat status dan riwayat pesanan</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="py-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="group flex w-full items-center px-4 py-3 text-sm text-red-700 hover:bg-red-50 transition duration-150">
                                            <i class="fas fa-sign-out-alt mr-3 text-red-400 group-hover:text-red-500"></i>
                                            <div>
                                                <div class="font-medium">Keluar</div>
                                                <div class="text-xs text-gray-500">Akhiri sesi login Anda</div>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-white hover:text-blue-100 px-4 py-2 rounded-lg text-sm font-medium border border-white/30 hover:bg-white/10 transition duration-150">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-white text-blue-600 hover:bg-blue-50 px-6 py-2 rounded-lg text-sm font-medium shadow-md hover:shadow-lg transition duration-150">
                            Daftar
                        </a>
                    @endauth
                </nav>

                {{-- Mobile menu button --}}
                <div class="md:hidden">
                    <button type="button" 
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="text-white hover:text-blue-100 focus:outline-none p-2 rounded-lg hover:bg-blue-700/50 transition duration-150">
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
        <div class="px-4 py-3 space-y-2">
            <a href="/" class="block px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150">
                <i class="fas fa-home mr-3 text-gray-400"></i>
                Beranda
            </a>
            @auth
                <a href="{{ route('profile.show') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150">
                    <i class="fas fa-user mr-3 text-gray-400"></i>
                    Profil Saya
                </a>
                <a href="{{ route('purchase.history') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150">
                    <i class="fas fa-history mr-3 text-gray-400"></i>
                    Riwayat Pembelian
                </a>
                <form method="POST" action="{{ route('logout') }}" class="border-t mt-2 pt-2">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-3 rounded-lg text-base font-medium text-red-600 hover:text-red-700 hover:bg-red-50 transition duration-150">
                        <i class="fas fa-sign-out-alt mr-3 text-red-400"></i>
                        Keluar
                    </button>
                </form>
            @else
                <div class="grid grid-cols-2 gap-3 mt-4">
                    <a href="{{ route('login') }}" class="text-center px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 border border-gray-200 hover:border-blue-600 transition duration-150">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-center px-4 py-3 rounded-lg text-base font-medium text-white bg-blue-600 hover:bg-blue-700 transition duration-150">
                        Daftar
                    </a>
                </div>
            @endauth
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="bg-white border-t mt-auto">
        <div class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="space-y-4">
                    <img class="h-10" src="{{ asset('image/img_logo_tokousahamuda.png') }}" alt="Toko Usaha Muda">
                    <p class="text-sm text-gray-600">Temukan produk terbaik untuk kebutuhan Anda dengan harga terjangkau.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Layanan</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-blue-600">Cara Berbelanja</a></li>
                        <li><a href="#" class="hover:text-blue-600">Metode Pembayaran</a></li>
                        <li><a href="#" class="hover:text-blue-600">Pengiriman</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Tentang Kami</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-blue-600">Profil Perusahaan</a></li>
                        <li><a href="#" class="hover:text-blue-600">Kontak</a></li>
                        <li><a href="#" class="hover:text-blue-600">Karir</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition duration-150">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition duration-150">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition duration-150">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t mt-8 pt-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Toko Usaha Muda. All rights reserved.
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
