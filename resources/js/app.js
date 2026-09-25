/**
 * UI Interaction Controller for District Studio
 * Tailwind CSS + Vite + Laravel 11
 */

document.addEventListener('DOMContentLoaded', () => {
    // Ensure dark theme is active and clean up any old local storage theme keys
    if (localStorage.getItem('theme')) {
        localStorage.removeItem('theme');
    }
    document.documentElement.classList.add('dark');

    initMobileNav();
});


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
