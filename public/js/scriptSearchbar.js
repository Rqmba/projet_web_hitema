document.getElementById('headerSearchForm').addEventListener('keyup', function(e) {
    e.preventDefault();
    const query = document.querySelector('#headerSearchForm input[name="query"]').value;
    const resultsContainer = document.getElementById('search-results');    
    resultsContainer.innerHTML= '';
    
    if (query.trim() !== '') {
         fetch('/search?query=' + encodeURIComponent(query))
        // fetch(`/search?query=${query}`)
            .then(response => response.json())
            .then(data => display(data));
    } else {
        resultsContainer.innerHTML = 'Aucun résultat trouvé.';
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
            // const category = item.categoryName;
            const price = item.price;
            const slug = item.slug;

            resultsContainer.innerHTML += `
                <li class="search-result-item">
                    <img class="img_product_one" src="/img/${picture}" alt="${description}">
                    <a href="/product/user/${slug}">${title}</a>
                    <p>${price} €</p>
                </li>
            `;
        });
    } else {
        resultsContainer.innerHTML = 'Aucun résultat trouvé.';
    }
}