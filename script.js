function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('show');
}

window.addEventListener('resize', () => {
    const navLinks = document.querySelector('.nav-links');
    if (window.innerWidth >= 768) {
        navLinks.classList.remove('show'); 
    }
});
const heroSection = document.querySelector('.hero');


const backgrounds = [
  'Images/pic1.jpg',
  'Images/pic27.jpg',
  'Images/pic25.jpg'
];

let currentIndex = 0;

function changeBackground() {
  heroSection.style.backgroundImage = `url('${backgrounds[currentIndex]}')`;
}

function nextBackground() {
  currentIndex = (currentIndex + 1) % backgrounds.length;
  changeBackground();
}

function prevBackground() {
  currentIndex = (currentIndex - 1 + backgrounds.length) % backgrounds.length;
  changeBackground();
}

document.querySelector('.next-btn').addEventListener('click', nextBackground);
document.querySelector('.prev-btn').addEventListener('click', prevBackground);

changeBackground();
