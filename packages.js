document.addEventListener("DOMContentLoaded", () => {

  const buttons = document.querySelectorAll('.p-filter-btn');
  const cards = document.querySelectorAll('.package-card');

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {

      buttons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filter = btn.dataset.filter;

      cards.forEach(card => {
        const category = card.dataset.category;

        if (filter === "all" || filter === category) {
          card.style.display = "block";
          setTimeout(() => card.style.opacity = 1, 10);
        } else {
          card.style.opacity = 0;
          setTimeout(() => card.style.display = "none", 300);
        }
      });
    });
  });

});
