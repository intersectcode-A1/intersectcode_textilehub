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
        <!-- Mobile Overlay -->
        <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden transition-opacity duration-300" onclick="closeMobileSidebar()"></div>
        
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-gray-800 shadow-lg z-50 transform -translate-x-full lg:translate-x-0 lg:relative lg:flex lg:flex-shrink-0 lg:w-64 transition-transform duration-300 ease-in-out flex flex-col">
            @include('components.navigation.admin-sidebar')
        </aside>
        
        <!-- Main Content -->
        <div id="main-content" class="flex-1 min-w-0 flex flex-col transition-all duration-300 w-full">
            @include('components.navigation.admin-topsider')
            <main class="flex-1 p-2 sm:p-3 md:p-4 lg:p-6 overflow-y-auto">
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

                if (document.documentElement.classList.contains('dark')) {
                    themeToggleLightIcon.classList.remove('hidden');
                } else {
                    themeToggleDarkIcon.classList.remove('hidden');
                }

                themeToggleBtn.addEventListener('click', () => {
                    themeToggleDarkIcon.classList.toggle('hidden');
                    themeToggleLightIcon.classList.toggle('hidden');
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('color-theme', isDark ? 'dark' : 'light');
                });
            }

            // SIDEBAR TOGGLE SCRIPT
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            const sidebar = document.getElementById('sidebar');
            const mobileOverlay = document.getElementById('mobile-overlay');

            function setSidebarDesktopState(state) {
                if (!sidebar) return;
                if (state === 'collapsed') {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-20');
                    sidebar.querySelectorAll('.sidebar-label').forEach(label => label.classList.add('hidden'));
                    if (sidebarToggleBtn) {
                        const icon = sidebarToggleBtn.querySelector('i');
                        if (icon) { icon.setAttribute('data-lucide', 'menu'); lucide.createIcons(); }
                    }
                } else {
                    sidebar.classList.add('w-64');
                    sidebar.classList.remove('w-20');
                    sidebar.querySelectorAll('.sidebar-label').forEach(label => label.classList.remove('hidden'));
                    if (sidebarToggleBtn) {
                        const icon = sidebarToggleBtn.querySelector('i');
                        if (icon) { icon.setAttribute('data-lucide', 'panel-left-close'); lucide.createIcons(); }
                    }
                }
                localStorage.setItem('sidebar-state', state);
            }

            function setSidebarMobileState(open) {
                if (!sidebar || !mobileOverlay) return;
                if (open) {
                    sidebar.classList.remove('-translate-x-full');
                    mobileOverlay.classList.remove('hidden');
                    setTimeout(() => mobileOverlay.classList.add('opacity-100'), 10);
                } else {
                    sidebar.classList.add('-translate-x-full');
                    mobileOverlay.classList.remove('opacity-100');
                    setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
                }
            }

            if (sidebarToggleBtn) {
                sidebarToggleBtn.addEventListener('click', function() {
                    const isMobile = window.innerWidth < 1024;
                    if (isMobile) {
                        const isOpen = !sidebar.classList.contains('-translate-x-full');
                        setSidebarMobileState(!isOpen);
                    } else {
                        const isCollapsed = sidebar.classList.contains('w-20');
                        setSidebarDesktopState(isCollapsed ? 'expanded' : 'collapsed');
                    }
                });
            }
            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', function() {
                    setSidebarMobileState(false);
                });
            }

            window.addEventListener('resize', function() {
                const isMobile = window.innerWidth < 1024;
                if (isMobile) {
                    setSidebarMobileState(false);
                } else {
                    setSidebarDesktopState(localStorage.getItem('sidebar-state') || 'expanded');
                }
            });

            // Init state on load
            const isMobile = window.innerWidth < 1024;
            if (isMobile) {
                setSidebarMobileState(false);
            } else {
                setSidebarDesktopState(localStorage.getItem('sidebar-state') || 'expanded');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
