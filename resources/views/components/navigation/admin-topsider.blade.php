<div class="flex items-center justify-between px-3 sm:px-4 lg:px-6 py-3 bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
    <!-- Kiri: menu & search -->
    <div class="flex items-center gap-2 sm:gap-4">
        <button id="sidebarToggleBtn" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none p-1" title="Menu">
            <i data-lucide="menu" class="w-5 h-5 sm:w-6 sm:h-6"></i>
        </button>
        <button class="hidden sm:block text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none p-1" title="Cari">
            <i data-lucide="search" class="w-5 h-5"></i>
        </button>
    </div>
    
    <!-- Kanan: sun, settings, bell, user -->
    <div class="flex items-center gap-2 sm:gap-3 lg:gap-5">
        <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none rounded-lg text-sm p-1.5 sm:p-2.5">
            <i data-lucide="moon" class="hidden w-4 h-4 sm:w-5 sm:h-5" id="theme-toggle-dark-icon"></i>
            <i data-lucide="sun" class="hidden w-4 h-4 sm:w-5 sm:h-5" id="theme-toggle-light-icon"></i>
        </button>
        <button class="hidden sm:block text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none p-1" title="Pengaturan">
            <i data-lucide="settings" class="w-5 h-5"></i>
        </button>
        
        <!-- Notifikasi Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none p-1 relative" title="Notifikasi">
                <i data-lucide="bell" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
                    <span class="absolute -top-1 -right-1 sm:-top-2 sm:-right-2 flex items-center justify-center h-3 w-3 sm:h-4 sm:w-4 bg-red-500 text-white text-[8px] sm:text-[10px] font-bold rounded-full">{{ $unreadNotifications->count() }}</span>
                @endif
            </button>

            <div x-show="open" 
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="absolute right-0 mt-2 w-72 sm:w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border dark:border-gray-700 origin-top-right z-50">
                <div class="px-3 sm:px-4 py-2 flex justify-between items-center border-b dark:border-gray-700">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200 text-sm sm:text-base">Notifikasi</h3>
                    <a href="#" class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:underline">Tandai semua dibaca</a>
                </div>
                <div class="py-1 max-h-80 sm:max-h-96 overflow-y-auto">
                    @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
                        @foreach($unreadNotifications as $notification)
                            <a href="{{ route('notifications.read', ['notification' => $notification->id]) }}" class="block px-3 sm:px-4 py-2 sm:py-3 hover:bg-gray-100 dark:hover:bg-gray-700/60">
                                <p class="font-medium text-gray-800 dark:text-gray-300 text-sm">Pesanan Baru Diterima</p>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                    Pesanan #{{ $notification->data['order_number'] ?? $notification->data['order_id'] }} senilai Rp {{ number_format($notification->data['total'], 0, ',', '.') }} telah dibuat.
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </a>
                        @endforeach
                    @else
                        <p class="text-center py-4 text-gray-500 dark:text-gray-400 text-sm">Tidak ada notifikasi baru.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sapaan Personal -->
        <div class="hidden sm:flex items-center gap-2 lg:gap-3 mr-2 px-2 sm:px-3 py-1 rounded-lg bg-gradient-to-r from-blue-50/80 via-white/80 to-purple-50/80 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700 shadow-sm">
            <div class="w-7 h-7 sm:w-8 sm:h-8 lg:w-9 lg:h-9 rounded-full flex items-center justify-center bg-gradient-to-br from-blue-400 to-purple-400 text-white font-bold text-sm sm:text-base lg:text-lg shadow">
                {{ \Illuminate\Support\Str::limit(Auth::user()->name, 2, '') }}
            </div>
            <div class="hidden lg:flex flex-col items-start">
                <span class="text-sm font-semibold text-gray-800 dark:text-gray-100 leading-tight">Halo, {{ Auth::user()->name }}!</span>
                <span class="text-xs text-gray-500 dark:text-gray-300">Admin</span>
            </div>
        </div>
        
        <!-- Mobile User Menu -->
        <div class="sm:hidden relative" x-data="{ open: false }">
            <button @click="open = !open" class="w-8 h-8 rounded-full flex items-center justify-center bg-gradient-to-br from-blue-400 to-purple-400 text-white font-bold text-sm shadow">
                {{ \Illuminate\Support\Str::limit(Auth::user()->name, 1, '') }}
            </button>
            <div x-show="open" 
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border dark:border-gray-700 origin-top-right z-50">
                <div class="px-4 py-3 border-b dark:border-gray-700">
                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-300">Admin</p>
                </div>
                <div class="py-1">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Profil</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Pengaturan</a>
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
