<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('image/img_logo_tokousahamuda.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
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

                const applyTheme = (theme) => {
                    document.documentElement.classList.toggle('dark', theme === 'dark');
                    themeToggleLightIcon.classList.toggle('hidden', theme === 'dark');
                    themeToggleDarkIcon.classList.toggle('hidden', theme !== 'dark');
                    localStorage.setItem('color-theme', theme);
                };

                themeToggleBtn.addEventListener('click', () => {
                    applyTheme(localStorage.getItem('color-theme') === 'dark' ? 'light' : 'dark');
                });
                
                applyTheme(localStorage.getItem('color-theme') || 'light');
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
