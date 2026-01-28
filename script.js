console.log("Main JS loaded");

/* =========================
   GLOBAL BUTTON ALERT
========================= */
document.addEventListener('DOMContentLoaded', () => {
  const btns = document.querySelectorAll('.btn, .btn-card');
  btns.forEach(btn => {
    btn.addEventListener('click', () => {
      alert('Feature coming soon! Get ready for your next adventure ✈️');
    });
  });
});

/* =========================
   HERO SLIDER (HOME ONLY)
========================= */
(function () {
  const heroSlides = document.querySelectorAll('.slide');
  if (!heroSlides.length) return;

  let currentSlide = 0;

  function showSlide(index) {
    heroSlides.forEach((slide, i) => {
      slide.classList.toggle('active', i === index);
    });
  }

  function nextSlide() {
    currentSlide = (currentSlide + 1) % heroSlides.length;
    showSlide(currentSlide);
  }

  setInterval(nextSlide, 5000);
})();

/* =========================
   BOOKING FORM
========================= */
document.querySelector(".booking-form")?.addEventListener("submit", e => {
  e.preventDefault();
  alert("Searching for available trips... ✈️");
});

/* =========================
   TESTIMONIAL SLIDER
========================= */
(function () {
  const testimonials = document.querySelectorAll(".testimonial");
  const dots = document.querySelectorAll(".dot");

  if (!testimonials.length || !dots.length) return;

  let testimonialIndex = 0;

  function showTestimonial(index) {
    testimonials.forEach(t => t.classList.remove("active"));
    dots.forEach(d => d.classList.remove("active"));
    testimonials[index].classList.add("active");
    dots[index].classList.add("active");
  }

  function nextTestimonial() {
    testimonialIndex = (testimonialIndex + 1) % testimonials.length;
    showTestimonial(testimonialIndex);
  }

  dots.forEach((dot, i) => {
    dot.addEventListener("click", () => {
      testimonialIndex = i;
      showTestimonial(i);
    });
  });

  setInterval(nextTestimonial, 5000);
})();

/* =========================
   NEWSLETTER INTERACTION
========================= */
(function () {
  const newsletterForm = document.querySelector('.newsletter-form');
  if (!newsletterForm) return;

  newsletterForm.addEventListener('submit', e => {
    e.preventDefault();
    const button = newsletterForm.querySelector('button');
    button.innerText = "Subscribed!";
    button.style.background = "#3FBF00";

    setTimeout(() => {
      button.innerText = "Subscribe";
      button.style.background = "#004B2B";
    }, 3000);

    newsletterForm.reset();
  });
})();

/* =========================
   MOBILE NAV (HAMBURGER)
========================= */
(function () {
  const menuToggle = document.getElementById("menu-toggle");
  const navMenu = document.getElementById("nav-menu");

  if (!menuToggle || !navMenu) return;

  menuToggle.addEventListener("click", () => {
    navMenu.classList.toggle("open");
  });
})();
