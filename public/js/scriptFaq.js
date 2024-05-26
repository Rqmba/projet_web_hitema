let menuItems = document.querySelectorAll('.menu-item');

    // Bouclez sur chaque élément du menu
    menuItems.forEach(item => {
        // Ajoutez un gestionnaire d'événements de clic à chaque élément du menu
        item.addEventListener('click', function(event) {
            // Empêchez le comportement par défaut du lien (par exemple, empêchez la page de défiler vers le haut)
            event.preventDefault();

            // Récupérez l'identifiant de l'élément cible à afficher à partir de l'attribut data-target du lien
            let targetId = item.dataset.target;

            // Sélectionnez tous les éléments .hidden qui contiennent le contenu et cachez-les
            let hiddenContents = document.querySelectorAll('.hidden');
            hiddenContents.forEach(content => {
                content.style.display = 'none';
            });

            // Affichez uniquement l'élément correspondant à l'identifiant récupéré
            let targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.style.display = 'block';
            } else {
                console.error("Contenue Introuvable");
            }
        });
    });