document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar el botón de hamburguesa y el menú
    const navbarToggler = document.getElementById('navbarToggler');
    const miNavbar = document.getElementById('miNavbar');

    // Agregar evento de clic al botón de hamburguesa
    navbarToggler.addEventListener('click', function() {
        miNavbar.classList.toggle('show'); // Alternar la clase 'show' en el menú
    });
});
