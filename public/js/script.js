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


function showPrice(product) {
  // Trouver l'élément de prix dans le produit actuel
  var priceElement = product.querySelector('.product-price');
  if (priceElement) {
      // Afficher le prix en faisant apparaître l'élément
      priceElement.style.display = 'block';
  }
}

function hidePrice(product) {
  // Trouver l'élément de prix dans le produit actuel
  var priceElement = product.querySelector('.product-price');
  if (priceElement) {
      // Masquer le prix en faisant disparaître l'élément
      priceElement.style.display = 'none';
  }
}