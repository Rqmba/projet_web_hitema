
console.log("Le fichier JavaScript fonctionne !");



// Js des blocs produits
let productItems = document.querySelectorAll('.product-item');

// Boucle sur chaque élément .product-item
productItems.forEach(productItem => {
    productItem.addEventListener("mouseover", () => {
        let displayPrice = productItem.querySelector('.priceJs');
        displayPrice.style.display = 'flex';
    });

  
    productItem.addEventListener("mouseout", () => {

        let displayPrice = productItem.querySelector('.priceJs');
        // Masque la div .priceJs
        displayPrice.style.display = 'none';
    });
});

// Sélectionnez tous les éléments .priceJs
let priceJsElements = document.querySelectorAll('.priceJs');

// Bouclez sur chaque élément .priceJs
priceJsElements.forEach(priceJsElement => {
    // Ajoutez un gestionnaire d'événements pour le clic sur l'élément .priceJs
    priceJsElement.addEventListener("click", () => {
        // Récupérez l'URL de redirection à partir de l'attribut data-redirect-url
        let redirectURL = priceJsElement.dataset.redirectUrl;
        // Redirigez vers l'URL récupérée
        window.location.href = redirectURL;
    });
});

// Js du FAQ



