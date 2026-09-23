/**
 * Theme & UI Interaction Controller for District Studio
 * Tailwind CSS + Vite + Laravel 11
 */

document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initMobileNav();
});

/**
 * Initialize Light / Dark Mode preference
 */
export function initTheme() {
    const themeColorMeta = document.getElementById('theme-color-meta');
    
    // Determine target theme
    const userPref = localStorage.getItem('theme');
    const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDark = userPref === 'dark' || (!userPref && systemDark);

    applyTheme(isDark);

    // Listen for OS theme changes if user has no explicit localStorage setting
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (!localStorage.getItem('theme')) {
            applyTheme(e.matches);
        }
    });

    // Attach click listeners to all theme toggle buttons (desktop & mobile)
    const toggleBtns = document.querySelectorAll('[data-theme-toggle]');
    toggleBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            const currentIsDark = document.documentElement.classList.contains('dark');
            const newIsDark = !currentIsDark;
            
            localStorage.setItem('theme', newIsDark ? 'dark' : 'light');
            applyTheme(newIsDark);
        });
    });
}

/**
 * Apply dark / light class to root HTML and update theme-color meta tag
 */
function applyTheme(isDark) {
    const root = document.documentElement;
    const themeColorMeta = document.getElementById('theme-color-meta');

    if (isDark) {
        root.classList.add('dark');
        if (themeColorMeta) themeColorMeta.setAttribute('content', '#0f172a');
    } else {
        root.classList.remove('dark');
        if (themeColorMeta) themeColorMeta.setAttribute('content', '#ffffff');
    }

    // Update toggle button icons if available
    document.querySelectorAll('[data-theme-icon-sun]').forEach((icon) => {
        icon.classList.toggle('hidden', !isDark);
    });
    document.querySelectorAll('[data-theme-icon-moon]').forEach((icon) => {
        icon.classList.toggle('hidden', isDark);
    });
}

/**
 * Initialize Mobile Navigation Drawer & Hamburger Menu
 */
export function initMobileNav() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
    const mobileMenuCloseBtn = document.getElementById('mobile-menu-close-btn');

    if (!mobileMenuBtn || !mobileMenuDrawer) return;

    function openMobileNav() {
        mobileMenuDrawer.classList.remove('-translate-x-full');
        if (mobileMenuBackdrop) {
            mobileMenuBackdrop.classList.remove('opacity-0', 'pointer-events-none');
            mobileMenuBackdrop.classList.add('opacity-100');
        }
        document.body.classList.add('overflow-hidden');
    }

    function closeMobileNav() {
        mobileMenuDrawer.classList.add('-translate-x-full');
        if (mobileMenuBackdrop) {
            mobileMenuBackdrop.classList.remove('opacity-100');
            mobileMenuBackdrop.classList.add('opacity-0', 'pointer-events-none');
        }
        document.body.classList.remove('overflow-hidden');
    }

    mobileMenuBtn.addEventListener('click', openMobileNav);
    if (mobileMenuCloseBtn) mobileMenuCloseBtn.addEventListener('click', closeMobileNav);
    if (mobileMenuBackdrop) mobileMenuBackdrop.addEventListener('click', closeMobileNav);

    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !mobileMenuDrawer.classList.contains('-translate-x-full')) {
            closeMobileNav();
        }
    });

    // Close when clicking nav links inside drawer
    mobileMenuDrawer.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', closeMobileNav);
    });
}
