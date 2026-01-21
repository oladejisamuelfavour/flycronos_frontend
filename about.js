const reveals = document.querySelectorAll('.reveal');

function revealOnScroll() {
    reveals.forEach(section => {
        const top = section.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;

        if (top < windowHeight - 100) {
            section.classList.add('active');
        }
    });
}

window.addEventListener('scroll', revealOnScroll);
revealOnScroll();
