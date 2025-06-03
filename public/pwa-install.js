let deferredPrompt;

// Check if app is already installed
window.addEventListener('load', () => {
    if (window.matchMedia('(display-mode: standalone)').matches) {
        hideInstallPrompt();
    }
});

// Show/Hide install prompt functions
function showInstallPrompt() {
    const installPrompt = document.getElementById('install-prompt');
    if (installPrompt) {
        installPrompt.style.display = 'block';
    }
}

function hideInstallPrompt() {
    const installPrompt = document.getElementById('install-prompt');
    if (installPrompt) {
        installPrompt.style.display = 'none';
    }
}

// Handle install prompt
window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    showInstallPrompt();
});

// Handle install button click
document.addEventListener('DOMContentLoaded', () => {
    const installButton = document.getElementById('install-button');
    if (installButton) {
        installButton.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    console.log('PWA installed successfully');
                }
                deferredPrompt = null;
                hideInstallPrompt();
            }
        });
    }
});

// Handle successful installation
window.addEventListener('appinstalled', () => {
    hideInstallPrompt();
    console.log('PWA was installed');
});