// Bandeau displayed on scroll down
let bandeau = document.getElementById('bandeau');

window.addEventListener('scroll', function () {
    if (window.scrollY > 50) {
        bandeau.classList.add('visible');
    } else {
        bandeau.classList.remove('visible');
    }
});