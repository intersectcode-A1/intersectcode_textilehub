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
        <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" onclick="closeMobileSidebar()"></div>
        
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:relative lg:flex lg:flex-shrink-0 bg-gray-800 shadow-lg h-screen lg:sticky lg:top-0 transition-all duration-300 flex flex-col z-50 transform -translate-x-full lg:translate-x-0">
            @include('components.navigation.admin-sidebar')
        </aside>
        
        <!-- Main Content -->
        <div id="main-content" class="flex-1 flex flex-col transition-all duration-300 w-full h-screen overflow-hidden">
            <!-- Fixed Top Navbar -->
            <div class="sticky top-0 z-40 bg-white dark:bg-gray-800">
                @include('components.navigation.admin-topsider')
            </div>
            <!-- Scrollable Main Content -->
            <main id="main-content-inner" class="flex-1 p-3 sm:p-4 lg:p-6 overflow-y-auto bg-gray-100 dark:bg-gray-900 transition-all duration-300">
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
            const mobileOverlay = document.getElementById('mobile-overlay');
            const mainContentInner = document.getElementById('main-content-inner');

            const applySidebarState = (state) => {
                const isCollapsed = state === 'collapsed';
                const isMobile = window.innerWidth < 1024; // lg breakpoint
                
                if (sidebar) {
                    if (isMobile) {
                        // Mobile behavior
                        if (state === 'open') {
                            sidebar.classList.remove('-translate-x-full');
                            mobileOverlay.classList.remove('hidden');
                        } else {
                            sidebar.classList.add('-translate-x-full');
                            mobileOverlay.classList.add('hidden');
                        }
                    } else {
                        // Desktop behavior
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
                }
                
                if (!isMobile) {
                    localStorage.setItem('sidebar-state', state);
                }

                // HAPUS: Tidak perlu margin kiri pada main content
            };

            // Close mobile sidebar function
            window.closeMobileSidebar = function() {
                applySidebarState('closed');
            };

            if (sidebarToggleBtn) {
                sidebarToggleBtn.addEventListener('click', () => {
                    const isMobile = window.innerWidth < 1024;
                    if (isMobile) {
                        const isOpen = !sidebar.classList.contains('-translate-x-full');
                        applySidebarState(isOpen ? 'closed' : 'open');
                    } else {
                        applySidebarState(localStorage.getItem('sidebar-state') === 'collapsed' ? 'expanded' : 'collapsed');
                    }
                });
            }
            
            // Handle window resize
            window.addEventListener('resize', () => {
                const isMobile = window.innerWidth < 1024;
                if (isMobile) {
                    applySidebarState('closed');
                } else {
                    applySidebarState(localStorage.getItem('sidebar-state') || 'expanded');
                }
            });
            
            // Initialize sidebar state
            const isMobile = window.innerWidth < 1024;
            if (isMobile) {
                applySidebarState('closed');
            } else {
                applySidebarState(localStorage.getItem('sidebar-state') || 'expanded');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
