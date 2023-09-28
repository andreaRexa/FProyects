// script.js

const toggleSidebar = document.getElementById('toggleSidebar');
const sidebar = document.querySelector('.sidebar');
const prevSlide = document.getElementById('prevSlide');
const nextSlide = document.getElementById('nextSlide');
const slider = document.querySelector('.slider');
const slides = document.querySelectorAll('.slide');

let currentSlide = 0;

// Función para mostrar el siguiente slide
function showSlide(index) {
    slides.forEach((slide, i) => {
        if (i === index) {
            slide.style.display = 'block';
        } else {
            slide.style.display = 'none';
        }
    });
}

showSlide(currentSlide);

// Evento para mostrar el siguiente slide
nextSlide.addEventListener('click', () => {
    currentSlide++;
    if (currentSlide >= slides.length) {
        currentSlide = 0;
    }
    showSlide(currentSlide);
});

// Evento para mostrar el slide anterior
prevSlide.addEventListener('click', () => {
    currentSlide--;
    if (currentSlide < 0) {
        currentSlide = slides.length - 1;
    }
    showSlide(currentSlide);
});

// Evento para abrir/cerrar la barra de navegación lateral
toggleSidebar.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});
