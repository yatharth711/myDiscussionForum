
function searchFunction() {
    var input = document.getElementById('searchQuery');
    var query = input.value;
    var searchResultsContainer = document.getElementById('searchResults');

    // Only perform the search if there is input
    if (query.length > 0) {
        fetch('search.php?searchQuery=' + encodeURIComponent(query))
        .then(response => response.text())
        .then(html => {
            searchResultsContainer.innerHTML = html;
            searchResultsContainer.style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
        });
    } else {
        searchResultsContainer.style.display = 'none';
    }
}

