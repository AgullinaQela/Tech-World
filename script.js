function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('show');
}

// Kontrolloni madhësinë e ekranit kur ndryshon
window.addEventListener('resize', () => {
    const navLinks = document.querySelector('.nav-links');
    if (window.innerWidth >= 768) {
        navLinks.classList.remove('show'); // Hiq "show" për desktop
    }
});