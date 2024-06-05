// Js search Bar
const query = document.querySelector('#headerSearchForm input[name="query"]').value;

const resultsContainer = document.getElementById('search-results');

document.getElementById('headerSearchForm').addEventListener('keyup', function(e) {
    e.preventDefault();
    resultsContainer.innerHTML= '';

    fetch('/search?query=' + encodeURIComponent(query))
    .then (response => response.json())
    .then (data => display(data))

    let display = data => {
        if (data.Search) {
            target.innerHTML= '';

            resultsContainer.innerHTML = '<h3>Vos résultats</h3>';

            data.Search.forEach(item => {
                const title = item.title;
                const description = item.description;
                const picture = item.picture;
                const category = item.categoryName;
                const price = item.price;
                const slug = item.slug;

                resultsContainer.innerHTML += `
                <li class="search-result-item">
                <img class="img_product_one" src="/img/${category}/${picture}" alt="${description}">
                <a href="/product/${slug}">${title}</a>
                <p>${price} €</p>
            </li>
                `;
            });
        } else {
            resultsContainer.innerHTML = 'Aucun résultat trouvé.';
        }
    }
});