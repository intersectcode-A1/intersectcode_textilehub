<div class="flex items-center justify-between px-6 py-3 bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
    <!-- Kiri: menu & search -->
    <div class="flex items-center gap-4">
        <button id="sidebarToggleBtn" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none" title="Menu">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
        <button class="ml-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none" title="Cari">
            <i data-lucide="search" class="w-5 h-5"></i>
        </button>
    </div>
    <!-- Kanan: sun, settings, bell, user -->
    <div class="flex items-center gap-5">
        <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none rounded-lg text-sm p-2.5">
            <i data-lucide="moon" class="hidden w-5 h-5" id="theme-toggle-dark-icon"></i>
            <i data-lucide="sun" class="hidden w-5 h-5" id="theme-toggle-light-icon"></i>
        </button>
        <button class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none" title="Pengaturan">
            <i data-lucide="settings" class="w-5 h-5"></i>
        </button>
        
        <!-- Notifikasi Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none" title="Notifikasi">
                <i data-lucide="bell" class="w-5 h-5"></i>
                @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
                    <span class="absolute -top-2 -right-2 flex items-center justify-center h-4 w-4 bg-red-500 text-white text-[10px] font-bold rounded-full">{{ $unreadNotifications->count() }}</span>
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
                 class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border dark:border-gray-700 origin-top-right z-50">
                <div class="px-4 py-2 flex justify-between items-center border-b dark:border-gray-700">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200">Notifikasi</h3>
                    <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Tandai semua dibaca</a>
                </div>
                <div class="py-1 max-h-96 overflow-y-auto">
                    @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
                        @foreach($unreadNotifications as $notification)
                            <a href="{{ route('notifications.read', ['notification' => $notification->id]) }}" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700/60">
                                <p class="font-medium text-gray-800 dark:text-gray-300">Pesanan Baru Diterima</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Pesanan #{{ $notification->data['order_number'] ?? $notification->data['order_id'] }} senilai Rp {{ number_format($notification->data['total'], 0, ',', '.') }} telah dibuat.
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </a>
                        @endforeach
                    @else
                        <p class="text-center py-4 text-gray-500 dark:text-gray-400">Tidak ada notifikasi baru.</p>
                    @endif
                </div>
            </div>
        </div>

        <button class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none" title="Profil">
            <i data-lucide="user" class="w-5 h-5"></i>
        </button>
    </div>
</div>
