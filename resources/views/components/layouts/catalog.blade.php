<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Toko Usaha Muda - E-Catalog' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Temukan produk berkualitas tinggi untuk kebutuhan bisnis Anda di Toko Usaha Muda">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('image/img_logo_tokousahamuda.png') }}">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { 
            display: none !important; 
        }
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom Styles */
        .product-card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
        }
        
        .btn-primary {
            @apply bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 focus:ring-blue-500;
        }
        
        .btn-secondary {
            @apply bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-gray-500;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Smooth Animations */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Glass Effect */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>

    @livewireStyles
</head>
<body class="min-h-screen flex flex-col bg-gray-50" x-data="{ mobileMenuOpen: false }">
    {{-- HEADER --}}
    <header class="bg-white shadow-lg border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Top Navigation --}}
            <div class="flex justify-between items-center h-16">
                {{-- Logo --}}
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <img class="h-10 w-auto group-hover:scale-105 transition-transform duration-200" 
                             src="{{ asset('image/img_logo_tokousahamuda.png') }}" 
                             alt="Toko Usaha Muda">
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Toko Usaha Muda
                        </span>
                        <p class="text-xs text-gray-500 -mt-1">E-Catalog</p>
                    </div>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="/" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-blue-50">
                        <i class="fas fa-home mr-2"></i>
                        Beranda
                    </a>
                    
                    @auth
                        {{-- Cart Icon --}}
                        <div class="relative">
                        <x-cart-icon />
                        </div>

                        {{-- Order Status Icon --}}
                        <div class="relative">
                        <x-order-status-icon />
                        </div>

                        {{-- User Menu --}}
                        <div class="relative" x-data="{ open: false }" x-cloak>
                            <button @click="open = !open" 
                                    class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none transition-all duration-200">
                                <div class="flex items-center space-x-3 p-2 rounded-lg hover:bg-blue-50">
                                    @if(auth()->user()->profile_photo)
                                        <img class="h-8 w-8 rounded-full border-2 border-gray-200 object-cover shadow-sm" 
                                             src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                             alt="{{ auth()->user()->name }}">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="hidden lg:block text-left">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500">Pelanggan</p>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" 
                                         :class="{'rotate-180': open}"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div x-show="open" 
                                 @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 transform scale-95 -translate-y-2"
                                 class="absolute right-0 mt-2 w-64 rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50 border border-gray-100">
                                
                                <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-xl">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                                
                                <div class="py-2">
                                    <a href="{{ route('profile.show') }}" 
                                       class="group flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200">
                                        <i class="fas fa-user mr-3 text-gray-400 group-hover:text-blue-500 transition-colors duration-200"></i>
                                        <span class="font-medium">Profil Saya</span>
                                    </a>
                                    <a href="{{ route('purchase.history') }}" 
                                       class="group flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200">
                                        <i class="fas fa-history mr-3 text-gray-400 group-hover:text-blue-500 transition-colors duration-200"></i>
                                        <span class="font-medium">Riwayat Pembelian</span>
                                    </a>
                                    <a href="{{ route('wishlist.index') }}" 
                                       class="group flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200">
                                        <i class="fas fa-heart mr-3 text-gray-400 group-hover:text-blue-500 transition-colors duration-200"></i>
                                        <span class="font-medium">Wishlist</span>
                                    </a>
                                </div>
                                
                                <div class="py-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="group flex w-full items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-all duration-200">
                                            <i class="fas fa-sign-out-alt mr-3 text-red-400 group-hover:text-red-500 transition-colors duration-200"></i>
                                            <span class="font-medium">Keluar</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-gray-700 hover:text-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-blue-50">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-user-plus mr-2"></i>
                            Daftar
                        </a>
                    @endauth
                </nav>

                {{-- Mobile menu button --}}
                <div class="md:hidden">
                    <button type="button" 
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="text-gray-700 hover:text-blue-600 focus:outline-none p-2 rounded-lg hover:bg-blue-50 transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    {{-- Mobile Navigation Menu --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-4"
         x-cloak
         class="md:hidden bg-white border-b border-gray-200 shadow-lg">
        <div class="px-4 py-6 space-y-4">
            <a href="/" 
               class="flex items-center px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                <i class="fas fa-home mr-3 text-gray-400"></i>
                Beranda
            </a>
            
            @auth
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex items-center px-4 py-3 mb-4">
                        @if(auth()->user()->profile_photo)
                            <img class="h-10 w-10 rounded-full border-2 border-gray-200 object-cover" 
                                 src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                 alt="{{ auth()->user()->name }}">
                        @else
                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-semibold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('profile.show') }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                        <i class="fas fa-user mr-3 text-gray-400"></i>
                    Profil Saya
                </a>
                    <a href="{{ route('purchase.history') }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                        <i class="fas fa-history mr-3 text-gray-400"></i>
                    Riwayat Pembelian
                </a>
                    <a href="{{ route('wishlist.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                        <i class="fas fa-heart mr-3 text-gray-400"></i>
                        Wishlist
                    </a>
                    
                    <div class="border-t border-gray-200 mt-4 pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                            <button type="submit" 
                                    class="flex w-full items-center px-4 py-3 rounded-xl text-base font-medium text-red-600 hover:text-red-700 hover:bg-red-50 transition-all duration-200">
                                <i class="fas fa-sign-out-alt mr-3 text-red-400"></i>
                        Keluar
                    </button>
                </form>
                    </div>
                </div>
            @else
                <div class="space-y-3 pt-4">
                    <a href="{{ route('login') }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                        <i class="fas fa-sign-in-alt mr-3 text-gray-400"></i>
                    Masuk
                </a>
                    <a href="{{ route('register') }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-base font-medium bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 transition-all duration-200">
                        <i class="fas fa-user-plus mr-3"></i>
                    Daftar
                </a>
                </div>
            @endauth
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main class="flex-grow animate-fade-in">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Company Info --}}
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <img class="h-8 w-auto" src="{{ asset('image/img_logo_tokousahamuda.png') }}" alt="Toko Usaha Muda">
                        <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Toko Usaha Muda
                        </span>
                    </div>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Menyediakan produk berkualitas tinggi untuk memenuhi kebutuhan bisnis Anda. 
                        Kami berkomitmen memberikan layanan terbaik dengan harga yang kompetitif.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors duration-200">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors duration-200">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors duration-200">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Layanan</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="/" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('ecatalog.index') }}" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                E-Catalog
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                Keranjang
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('order.status') }}" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                Status Pesanan
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Contact Info --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Kontak</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-map-marker-alt mr-3 text-blue-500"></i>
                            <span>Jl. Pasar Raya A No.24F, Kp. Jao, Kec. Padang Bar. Kota Padang Sumatera Barat</span>
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-phone mr-3 text-blue-500"></i>
                            <span>+62 811-6655-050</span>
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-envelope mr-3 text-blue-500"></i>
                            <span>tokousahamuda@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Bottom Footer --}}
            <div class="border-t border-gray-200 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} Toko Usaha Muda. All rights reserved.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-500 hover:text-blue-600 text-sm transition-colors duration-200">
                            Kebijakan Privasi
                        </a>
                        <a href="#" class="text-gray-500 hover:text-blue-600 text-sm transition-colors duration-200">
                            Syarat & Ketentuan
                        </a>
                        <a href="#" class="text-gray-500 hover:text-blue-600 text-sm transition-colors duration-200">
                            Bantuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>