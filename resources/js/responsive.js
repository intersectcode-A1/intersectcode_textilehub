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
        this.setupResponsiveCharts();
    }
    
    setupEventListeners() {
        // Handle window resize
        window.addEventListener('resize', () => {
            this.handleResize();
        });
        
        // Handle orientation change
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
        
        // Trigger resize events
        if (wasMobile !== this.isMobile) {
            this.onMobileChange();
        }
        
        if (wasTablet !== this.isTablet) {
            this.onTabletChange();
        }
        
        if (wasDesktop !== this.isDesktop) {
            this.onDesktopChange();
        }
        
        // Update responsive classes
        this.updateResponsiveClasses();
    }
    
    onMobileChange() {
        console.log('Device changed to mobile');
        this.closeSidebar();
        this.hideDesktopElements();
        this.showMobileElements();
    }
    
    onTabletChange() {
        console.log('Device changed to tablet');
        this.showTabletElements();
    }
    
    onDesktopChange() {
        console.log('Device changed to desktop');
        this.showDesktopElements();
        this.hideMobileElements();
    }
    
    updateResponsiveClasses() {
        const body = document.body;
        
        // Remove existing responsive classes
        body.classList.remove('is-mobile', 'is-tablet', 'is-desktop');
        
        // Add current responsive class
        if (this.isMobile) {
            body.classList.add('is-mobile');
        } else if (this.isTablet) {
            body.classList.add('is-tablet');
        } else {
            body.classList.add('is-desktop');
        }
    }
    
    setupResponsiveTables() {
        const tables = document.querySelectorAll('.responsive-table');
        
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
        
        // Add scroll indicator
        const indicator = document.createElement('div');
        indicator.className = 'table-scroll-indicator';
        indicator.innerHTML = '← Scroll untuk melihat lebih banyak →';
        indicator.style.cssText = `
            text-align: center;
            padding: 0.5rem;
            background: #f3f4f6;
            color: #6b7280;
            font-size: 0.875rem;
            border-top: 1px solid #e5e7eb;
        `;
        
        wrapper.appendChild(indicator);
        
        // Hide indicator if table doesn't scroll
        const checkScroll = () => {
            if (table.scrollWidth <= wrapper.clientWidth) {
                indicator.style.display = 'none';
            } else {
                indicator.style.display = 'block';
            }
        };
        
        checkScroll();
        window.addEventListener('resize', checkScroll);
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
        
        // Close sidebar when clicking on links (mobile)
        const sidebarLinks = sidebar?.querySelectorAll('a');
        if (sidebarLinks) {
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (this.isMobile) {
                        this.closeSidebar();
                    }
                });
            });
        }
    }
    
    toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');
        
        if (this.isMobile) {
            if (sidebar.classList.contains('-translate-x-full')) {
                this.openSidebar();
            } else {
                this.closeSidebar();
            }
        } else {
            // Desktop behavior - toggle collapsed state
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
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }
    
    closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');
        
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        
        // Restore body scroll
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
        
        // Update toggle button icon
        const toggleBtn = document.getElementById('sidebarToggleBtn');
        const icon = toggleBtn?.querySelector('i');
        if (icon) {
            icon.setAttribute('data-lucide', 'panel-left-close');
            if (window.lucide) {
                lucide.createIcons();
            }
        }
        
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
        
        // Update toggle button icon
        const toggleBtn = document.getElementById('sidebarToggleBtn');
        const icon = toggleBtn?.querySelector('i');
        if (icon) {
            icon.setAttribute('data-lucide', 'menu');
            if (window.lucide) {
                lucide.createIcons();
            }
        }
        
        localStorage.setItem('sidebar-state', 'collapsed');
    }
    
    setupResponsiveModals() {
        const modals = document.querySelectorAll('.responsive-modal');
        
        modals.forEach(modal => {
            // Close modal on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    this.closeModal(modal);
                }
            });
            
            // Close modal on overlay click
            const overlay = modal.querySelector('.modal-overlay');
            if (overlay) {
                overlay.addEventListener('click', () => {
                    this.closeModal(modal);
                });
            }
        });
    }
    
    openModal(modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Focus first input in modal
        const firstInput = modal.querySelector('input, textarea, select, button');
        if (firstInput) {
            firstInput.focus();
        }
    }
    
    closeModal(modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
    
    setupResponsiveCharts() {
        const charts = document.querySelectorAll('.responsive-chart');
        
        charts.forEach(chart => {
            // Resize chart on window resize
            window.addEventListener('resize', () => {
                if (chart.chart) {
                    chart.chart.resize();
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
    
    // Utility methods
    getDeviceType() {
        if (this.isMobile) return 'mobile';
        if (this.isTablet) return 'tablet';
        return 'desktop';
    }
    
    isTouchDevice() {
        return 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    }
    
    // Responsive image loading
    setupResponsiveImages() {
        const images = document.querySelectorAll('img[data-src]');
        
        images.forEach(img => {
            const src = this.isMobile ? img.dataset.srcMobile : 
                       this.isTablet ? img.dataset.srcTablet : 
                       img.dataset.srcDesktop;
            
            if (src) {
                img.src = src;
            }
        });
    }
    
    // Responsive form handling
    setupResponsiveForms() {
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            // Add responsive classes
            form.classList.add('responsive-form');
            
            // Handle form submission on mobile
            if (this.isMobile) {
                form.addEventListener('submit', (e) => {
                    // Show loading state
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="loading-spinner"></span> Mengirim...';
                    }
                });
            }
        });
    }
    
    // Responsive data handling
    setupResponsiveData() {
        // Limit data on mobile for better performance
        if (this.isMobile) {
            const dataTables = document.querySelectorAll('.data-table');
            dataTables.forEach(table => {
                const rows = table.querySelectorAll('tbody tr');
                if (rows.length > 10) {
                    // Show only first 10 rows on mobile
                    rows.forEach((row, index) => {
                        if (index >= 10) {
                            row.style.display = 'none';
                        }
                    });
                    
                    // Add "Show more" button
                    const showMoreBtn = document.createElement('button');
                    showMoreBtn.textContent = 'Tampilkan Lebih Banyak';
                    showMoreBtn.className = 'btn btn-primary mt-4';
                    showMoreBtn.addEventListener('click', () => {
                        rows.forEach(row => {
                            row.style.display = '';
                        });
                        showMoreBtn.remove();
                    });
                    
                    table.parentNode.appendChild(showMoreBtn);
                }
            });
        }
    }
}

// Initialize responsive manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.responsiveManager = new ResponsiveManager();
});

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ResponsiveManager;
} 