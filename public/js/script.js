// Js du carousel

let slideIndex = 1;

function showSlide(n) {
  const slides = document.getElementsByClassName("slide");
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

function nextSlide() {
  showSlide(slideIndex += 1);
}

function prevSlide() {
  showSlide(slideIndex -= 1);
}

showSlide(slideIndex);

// Page FAQ

document.addEventListener('DOMContentLoaded', function() {
  // Gérer les clics sur les éléments de menu
  document.querySelectorAll('.menu-item').forEach(function(link) {
      link.addEventListener('click', function(event) {
          event.preventDefault();
          let targetId = this.getAttribute('data-target');
          document.querySelectorAll('article').forEach(function(article) {
              article.classList.add('hidden');
          });
          document.getElementById(targetId).classList.remove('hidden');
      });
  });

  // Gérer les clics sur les titres <h4>
  document.querySelectorAll('.collapsible').forEach(function(header) {
      header.addEventListener('click', function() {
          this.classList.toggle('active');
      });
  });
});


// Affichage prix

document.addEventListener('DOMContentLoaded', (event) => {
  const productItems = document.querySelectorAll('.product-item');

  productItems.forEach(item => {
      const imgContainer = item.querySelector('.img-container');
      const priceOverlay = item.querySelector('.price-overlay');

      imgContainer.addEventListener('mouseover', () => {
          priceOverlay.style.display = 'block';
      });

      imgContainer.addEventListener('mouseout', () => {
          priceOverlay.style.display = 'none';
      });
  });
});

