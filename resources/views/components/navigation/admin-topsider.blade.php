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
        <div class="relative">
            <button class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none" title="Notifikasi">
                <i data-lucide="bell" class="w-5 h-5"></i>
            </button>
            <span class="absolute -top-2 -right-2 flex items-center justify-center h-4 w-4 bg-teal-500 text-white text-[10px] font-bold rounded-full">3</span>
        </div>
        <button class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none" title="Profil">
            <i data-lucide="user" class="w-5 h-5"></i>
        </button>
    </div>
</div>
