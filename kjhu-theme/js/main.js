/**
 * Kjhu Theme - JavaScript
 * Dark Purple Gradient Design for Pterodactyl Panel
 */

(function() {
    'use strict';

    // Theme Configuration
    const KjhuTheme = {
        config: {
            sidebarCollapsed: false,
            darkMode: true,
            animations: true,
            notifications: {
                enabled: true,
                sound: false
            }
        },

        // Initialize theme
        init() {
            this.loadConfig();
            this.setupSidebar();
            this.setupTooltips();
            this.setupDropdowns();
            this.setupNotifications();
            this.setupAnimations();
            this.setupConsoleAutoScroll();
        },

        // Load configuration from localStorage
        loadConfig() {
            const saved = localStorage.getItem('kjhu_theme_config');
            if (saved) {
                try {
                    Object.assign(this.config, JSON.parse(saved));
                } catch (e) {
                    console.warn('Failed to load theme config');
                }
            }
        },

        // Save configuration
        saveConfig() {
            localStorage.setItem('kjhu_theme_config', JSON.stringify(this.config));
        },

        // Sidebar functionality
        setupSidebar() {
            const toggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            if (toggle && sidebar) {
                toggle.addEventListener('click', () => {
                    this.config.sidebarCollapsed = !this.config.sidebarCollapsed;
                    sidebar.classList.toggle('collapsed', this.config.sidebarCollapsed);
                    mainContent?.classList.toggle('sidebar-collapsed', this.config.sidebarCollapsed);
                    this.saveConfig();
                });

                // Restore state
                if (this.config.sidebarCollapsed) {
                    sidebar.classList.add('collapsed');
                    mainContent?.classList.add('sidebar-collapsed');
                }
            }
        },

        // Tooltip initialization
        setupTooltips() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltipTriggerList.forEach(tooltipTriggerEl => {
                new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover',
                    placement: 'top',
                    boundary: 'viewport'
                });
            });
        },

        // Dropdown enhancements
        setupDropdowns() {
            document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
                dropdown.addEventListener('click', e => {
                    e.stopPropagation();
                });
            });
        },

        // Notifications
        setupNotifications() {
            // Mark notifications as read
            document.querySelectorAll('.mark-all-read').forEach(btn => {
                btn.addEventListener('click', e => {
                    e.preventDefault();
                    this.markAllNotificationsRead();
                });
            });
        },

        async markAllNotificationsRead() {
            try {
                await fetch('/api/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    }
                });

                document.querySelectorAll('.notification-item').forEach(item => {
                    item.classList.add('read');
                });

                const badge = document.querySelector('.notification-badge');
                if (badge) badge.remove();
            } catch (error) {
                console.error('Failed to mark notifications as read');
            }
        },

        // Animations
        setupAnimations() {
            if (!this.config.animations) return;

            // Fade in elements on scroll
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fadeIn');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.card, .resource-card, .file-manager-item').forEach(el => {
                el.style.opacity = '0';
                observer.observe(el);
            });
        },

        // Console auto-scroll
        setupConsoleAutoScroll() {
            const console = document.querySelector('.console');
            if (console) {
                const output = console.querySelector('.console-output');
                if (output) {
                    const scrollButton = console.querySelector('.scroll-to-bottom');
                    if (scrollButton) {
                        scrollButton.addEventListener('click', () => {
                            output.scrollTop = output.scrollHeight;
                        });
                    }

                    // Auto-scroll when new content is added
                    const observer = new MutationObserver(() => {
                        if (output.dataset.autoScroll === 'true') {
                            output.scrollTop = output.scrollHeight;
                        }
                    });

                    observer.observe(output, { childList: true, subtree: true });
                }
            }
        },

        // Theme toggle (for light/dark mode if implemented)
        toggleTheme() {
            this.config.darkMode = !this.config.darkMode;
            document.body.classList.toggle('light-mode', !this.config.darkMode);
            this.saveConfig();
        },

        // Copy to clipboard
        copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                this.showToast('Copied to clipboard!', 'success');
            }).catch(() => {
                this.showToast('Failed to copy', 'error');
            });
        },

        // Show toast notification
        showToast(message, type = 'info') {
            const container = document.getElementById('toast-container') || this.createToastContainer();
            
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <div class="toast-content">
                    <i class="toast-icon ${this.getToastIcon(type)}"></i>
                    <span class="toast-message">${message}</span>
                </div>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => toast.classList.add('show'), 10);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        },

        createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toast-container';
            document.body.appendChild(container);
            return container;
        },

        getToastIcon(type) {
            const icons = {
                success: 'fas fa-check-circle text-success',
                error: 'fas fa-exclamation-circle text-danger',
                warning: 'fas fa-exclamation-triangle text-warning',
                info: 'fas fa-info-circle text-info'
            };
            return icons[type] || icons.info;
        },

        // Server status check
        async checkServerStatus(serverId) {
            try {
                const response = await fetch(`/api/servers/${serverId}/status`);
                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Failed to check server status');
                return null;
            }
        },

        // Resource usage formatter
        formatResource(bytes, type = 'ram') {
            if (type === 'disk') {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
                if (bytes < 1024 * 1024 * 1024) return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
                return (bytes / (1024 * 1024 * 1024)).toFixed(2) + ' GB';
            }
            
            // RAM in MB/GB
            if (bytes < 1024) return bytes + ' MB';
            return (bytes / 1024).toFixed(1) + ' GB';
        },

        // Confirmation dialog
        confirm(message, callback) {
            if (confirm(message)) {
                callback();
            }
        },

        // Loading state
        setLoading(element, loading = true) {
            if (loading) {
                element.disabled = true;
                element.dataset.originalText = element.innerHTML;
                element.innerHTML = '<span class="spinner"></span> Loading...';
            } else {
                element.disabled = false;
                element.innerHTML = element.dataset.originalText;
            }
        }
    };

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', () => {
        KjhuTheme.init();
    });

    // Expose to global
    window.KjhuTheme = KjhuTheme;

})();
