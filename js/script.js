// Contoh JavaScript sederhana untuk parallax, bisa diperluas
document.addEventListener('DOMContentLoaded', function() {
    const hero = document.querySelector('.futuristic-hero');
    if (hero) {
        window.addEventListener('scroll', function() {
            let scrollPosition = window.pageYOffset;
            hero.style.backgroundPositionY = -scrollPosition * 0.5 + 'px';
        });
    }
});