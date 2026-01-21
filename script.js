// Example: simple alert when "Book Now" button is clicked
// script.js
document.addEventListener('DOMContentLoaded', () => {
  const btns = document.querySelectorAll('.btn, .btn-card');
  btns.forEach(btn => {
    btn.addEventListener('click', () => {
      alert('Feature coming soon! Get ready for your next adventure ✈️');
    });
  });
});
// Hero slider logic
let currentSlide = 0;
const slides = document.querySelectorAll('.slide');

function showSlide(index) {
  slides.forEach((slide, i) => {
    slide.classList.toggle('active', i === index);
  });
}

function nextSlide() {
  currentSlide = (currentSlide + 1) % slides.length;
  showSlide(currentSlide);
}

// Auto slide every 5 seconds
setInterval(nextSlide, 5000);
// Booking form handler
document.querySelector(".booking-form")?.addEventListener("submit", function(e) {
  e.preventDefault();
  alert("Searching for available trips... ✈️");
});

// Testimonial slider
let testimonialIndex = 0;
const testimonials = document.querySelectorAll(".testimonial");
const dots = document.querySelectorAll(".dot");

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

// Newsletter form simple interaction
const newsletterForm = document.querySelector('.newsletter-form');
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


document.getElementById("menu-toggle").addEventListener("click", function () {
  const menu = document.getElementById("nav-menu");
  menu.style.display = menu.style.display === "block" ? "none" : "block";
});
