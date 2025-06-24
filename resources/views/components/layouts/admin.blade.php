<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('image/img_logo_tokousahamuda.png') }}">

    @vite('resources/css/app.css')
    
    <script>
        // Skrip ini ditempatkan di <head> untuk mencegah FOUC (Flash of Unstyled Content)
        if (localStorage.getItem('color-theme') === 'dark' || 
           (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">
    <div class="flex min-h-screen">
        @include('components.navigation.admin-sidebar')
        <div id="main-content" class="flex-1 flex flex-col transition-all duration-300">
            @include('components.navigation.admin-topsider')
            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            // THEME TOGGLE SCRIPT
            const themeToggleBtn = document.getElementById('theme-toggle');
            if (themeToggleBtn) {
                const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
                const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

                // Tampilkan ikon yang benar saat halaman dimuat
                if (document.documentElement.classList.contains('dark')) {
                    themeToggleLightIcon.classList.remove('hidden');
                } else {
                    themeToggleDarkIcon.classList.remove('hidden');
                }

                themeToggleBtn.addEventListener('click', () => {
                    // Toggle ikon
                    themeToggleDarkIcon.classList.toggle('hidden');
                    themeToggleLightIcon.classList.toggle('hidden');

                    // Toggle kelas dark di <html>
                    const isDark = document.documentElement.classList.toggle('dark');
                    
                    // Simpan preferensi ke localStorage
                    localStorage.setItem('color-theme', isDark ? 'dark' : 'light');
                });
            }

            // SIDEBAR TOGGLE SCRIPT
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            const sidebar = document.getElementById('sidebar');

            const applySidebarState = (state) => {
                const isCollapsed = state === 'collapsed';
                if (sidebar) {
                    sidebar.classList.toggle('w-64', !isCollapsed);
                    sidebar.classList.toggle('w-20', isCollapsed);

                    sidebar.querySelectorAll('.sidebar-label').forEach(label => {
                        label.classList.toggle('hidden', isCollapsed);
                    });

                    const sidebarIcon = sidebarToggleBtn.querySelector('i');
                    if (sidebarIcon) {
                        sidebarIcon.setAttribute('data-lucide', isCollapsed ? 'menu' : 'panel-left-close');
                        lucide.createIcons();
                    }
                }
                localStorage.setItem('sidebar-state', state);
            };

            if (sidebarToggleBtn) {
                sidebarToggleBtn.addEventListener('click', () => {
                    applySidebarState(localStorage.getItem('sidebar-state') === 'collapsed' ? 'expanded' : 'collapsed');
                });
            }
            
            applySidebarState(localStorage.getItem('sidebar-state') || 'expanded');
        });
    </script>
    @stack('scripts')
</body>
</html>
