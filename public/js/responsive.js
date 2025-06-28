// Responsive JavaScript Utilities

class ResponsiveManager {
    constructor() {
        this.isMobile = window.innerWidth < 768;
        this.isTablet = window.innerWidth >= 768 && window.innerWidth < 1024;
        this.isDesktop = window.innerWidth >= 1024;
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.setupResponsiveTables();
        this.setupResponsiveNavigation();
        this.setupResponsiveModals();
    }
    
    setupEventListeners() {
        window.addEventListener('resize', () => {
            this.handleResize();
        });
        
        window.addEventListener('orientationchange', () => {
            setTimeout(() => {
                this.handleResize();
            }, 100);
        });
    }
    
    handleResize() {
        const wasMobile = this.isMobile;
        const wasTablet = this.isTablet;
        const wasDesktop = this.isDesktop;
        
        this.isMobile = window.innerWidth < 768;
        this.isTablet = window.innerWidth >= 768 && window.innerWidth < 1024;
        this.isDesktop = window.innerWidth >= 1024;
        
        if (wasMobile !== this.isMobile) {
            this.onMobileChange();
        }
        
        if (wasTablet !== this.isTablet) {
            this.onTabletChange();
        }
        
        if (wasDesktop !== this.isDesktop) {
            this.onDesktopChange();
        }
        
        this.updateResponsiveClasses();
    }
    
    onMobileChange() {
        this.closeSidebar();
        this.hideDesktopElements();
        this.showMobileElements();
    }
    
    onTabletChange() {
        this.showTabletElements();
    }
    
    onDesktopChange() {
        this.showDesktopElements();
        this.hideMobileElements();
    }
    
    updateResponsiveClasses() {
        const body = document.body;
        body.classList.remove('is-mobile', 'is-tablet', 'is-desktop');
        
        if (this.isMobile) {
            body.classList.add('is-mobile');
        } else if (this.isTablet) {
            body.classList.add('is-tablet');
        } else {
            body.classList.add('is-desktop');
        }
    }
    
    setupResponsiveTables() {
        const tables = document.querySelectorAll('table');
        
        tables.forEach(table => {
            if (this.isMobile) {
                this.makeTableResponsive(table);
            }
        });
    }
    
    makeTableResponsive(table) {
        const wrapper = document.createElement('div');
        wrapper.className = 'table-responsive-wrapper';
        wrapper.style.cssText = 'overflow-x: auto; -webkit-overflow-scrolling: touch;';
        
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    }
    
    setupResponsiveNavigation() {
        const sidebarToggle = document.getElementById('sidebarToggleBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');
        
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => {
                this.toggleSidebar();
            });
        }
        
        if (overlay) {
            overlay.addEventListener('click', () => {
                this.closeSidebar();
            });
        }
    }
    
    toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        
        if (this.isMobile) {
            if (sidebar.classList.contains('-translate-x-full')) {
                this.openSidebar();
            } else {
                this.closeSidebar();
            }
        } else {
            const isCollapsed = sidebar.classList.contains('w-20');
            if (isCollapsed) {
                this.expandSidebar();
            } else {
                this.collapseSidebar();
            }
        }
    }
    
    openSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');
        
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');
        
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }
    
    expandSidebar() {
        const sidebar = document.getElementById('sidebar');
        const labels = sidebar.querySelectorAll('.sidebar-label');
        
        sidebar.classList.remove('w-20');
        sidebar.classList.add('w-64');
        
        labels.forEach(label => {
            label.classList.remove('hidden');
        });
        
        localStorage.setItem('sidebar-state', 'expanded');
    }
    
    collapseSidebar() {
        const sidebar = document.getElementById('sidebar');
        const labels = sidebar.querySelectorAll('.sidebar-label');
        
        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-20');
        
        labels.forEach(label => {
            label.classList.add('hidden');
        });
        
        localStorage.setItem('sidebar-state', 'collapsed');
    }
    
    setupResponsiveModals() {
        const modals = document.querySelectorAll('[x-data]');
        
        modals.forEach(modal => {
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    // Close modal logic here
                }
            });
        });
    }
    
    hideDesktopElements() {
        const desktopElements = document.querySelectorAll('.desktop-only');
        desktopElements.forEach(el => {
            el.style.display = 'none';
        });
    }
    
    showDesktopElements() {
        const desktopElements = document.querySelectorAll('.desktop-only');
        desktopElements.forEach(el => {
            el.style.display = '';
        });
    }
    
    hideMobileElements() {
        const mobileElements = document.querySelectorAll('.mobile-only');
        mobileElements.forEach(el => {
            el.style.display = 'none';
        });
    }
    
    showMobileElements() {
        const mobileElements = document.querySelectorAll('.mobile-only');
        mobileElements.forEach(el => {
            el.style.display = '';
        });
    }
    
    showTabletElements() {
        const tabletElements = document.querySelectorAll('.tablet-only');
        tabletElements.forEach(el => {
            el.style.display = '';
        });
    }
    
    getDeviceType() {
        if (this.isMobile) return 'mobile';
        if (this.isTablet) return 'tablet';
        return 'desktop';
    }
}

// Initialize responsive manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.responsiveManager = new ResponsiveManager();
}); 