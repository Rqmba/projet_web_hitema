document.getElementById('headerSearchForm').addEventListener('keyup', function(e) {
    e.preventDefault();
    const query = document.querySelector('#headerSearchForm input[name="query"]').value;
    const resultsContainer = document.getElementById('search-results');    
    resultsContainer.innerHTML = '';
    
    if (query.trim().length >= 4) {
        fetch('/search?query=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => display(data));
    } else {
        // Masquer le conteneur des résultats si le champ de recherche est vide
        if (query.trim().length === 0) {
            document.querySelector('.search-results-container').style.display = 'none';
        } else {
            resultsContainer.innerHTML = 'Aucun résultat trouvé.';
            document.querySelector('.search-results-container').style.display = 'block';
        }
    }
});

function display(data) {
    const resultsContainer = document.getElementById('search-results');
    if (data.length > 0) {
        resultsContainer.innerHTML = '<h3>Vos résultats</h3>';
        data.forEach(item => {
            const title = item.title;
            const description = item.description;
            const picture = item.picture;
            const price = item.price;
            const slug = item.slug;

            resultsContainer.innerHTML += `
                <li class="search-result-item">
                    <img class="imgproduct" src="/img/${picture}" alt="${description}">
                    <a href="/product/user/${slug}">${title}</a>
                    <p>${price} €</p>
                </li>
            `;
        });
        // Afficher le conteneur des résultats
        document.querySelector('.search-results-container').style.display = 'block';
    } else {
        resultsContainer.innerHTML = 'Aucun résultat trouvé.';
    }
}
