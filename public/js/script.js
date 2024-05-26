
console.log("Le fichier JavaScript fonctionne !");



// Js des blocs produits
let productItems = document.querySelectorAll('.product-item');

// Boucle sur chaque élément .product-item
productItems.forEach(productItem => {
    productItem.addEventListener("mouseover", () => {
        let displayPrice = productItem.querySelector('.prixJs');
        displayPrice.style.display = 'flex';
    });

  
    productItem.addEventListener("mouseout", () => {

        let displayPrice = productItem.querySelector('.prixJs');
        // Masque la div .prixJs
        displayPrice.style.display = 'none';
    });
});

// Sélectionnez tous les éléments .prixJs
let prixJsElements = document.querySelectorAll('.prixJs');

// Bouclez sur chaque élément .prixJs
prixJsElements.forEach(prixJsElement => {
    // Ajoutez un gestionnaire d'événements pour le clic sur l'élément .prixJs
    prixJsElement.addEventListener("click", () => {
        // Récupérez l'URL de redirection à partir de l'attribut data-redirect-url
        let redirectURL = prixJsElement.dataset.redirectUrl;
        // Redirigez vers l'URL récupérée
        window.location.href = redirectURL;
    });
});

// Js du FAQ



