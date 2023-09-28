let slideIndex = 0;
showSlides();

function plusSlides(n) {
    showSlide(slideIndex += n);
}

function showSlides() {
    let slides = document.getElementsByClassName("slide");

    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slideIndex++;

    if (slideIndex > slides.length) {
        slideIndex = 1;
    }

    showSlide(slideIndex);

    setTimeout(showSlides, 2000); // Cambia la imagen cada 2 segundos (2000 milisegundos)
}

function showSlide(n) {
    let slides = document.getElementsByClassName("slide");

    if (n > slides.length) {
        slideIndex = 1;
    }

    if (n < 1) {
        slideIndex = slides.length;
    }

    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slides[slideIndex - 1].style.display = "block";
}
// Función para abrir la barra de navegación
function toggleNav() {
    var sidenav = document.getElementById("mySidenav");
    var mainContent = document.getElementById("main-content");

    if (sidenav.style.width === "250px") {
        sidenav.style.width = "0";
        mainContent.classList.remove("sidenav-open");
    } else {
        sidenav.style.width = "250px"; // Ancho de la barra lateral expandida
        mainContent.classList.add("sidenav-open");
    }
}

// Función para cerrar la barra de navegación
function closeNav() {
    var sidenav = document.getElementById("mySidenav");
    var mainContent = document.getElementById("main-content");

    sidenav.style.width = "0"; // Ancho 0 para ocultar la barra lateral
    mainContent.classList.remove("sidenav-open");
}


