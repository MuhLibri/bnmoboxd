function sendRequest(query) {
    const xhr = new XMLHttpRequest();
    const url = `/films/search?${query}`;
    xhr.open('GET', url);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById("film-poster-list").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

function buildQuery() {
    const searchInput = document.getElementById('searchInput').value;
    const genreFilter = document.getElementById('genreFilter').value;
    const ratingFilter = document.getElementById('ratingFilter').value;
    const sortFilter = (document.getElementById('sortFilter').value).split('_');
    const orderBy = sortFilter[0];
    const sort = sortFilter[1] ?? '';

    // Add any additional parameters as needed
    const query = [
        `search=${searchInput}`,
        `genre=${genreFilter}`,
        `rating=${ratingFilter}`,
        `sort=${sort}`,
        `orderBy=${orderBy}`
    ];

    return query.join('&');
}

function handleFilterChange() {
    const query = buildQuery() + `&page=1&take=10`;
    sendRequest(query);
}

function handlePageChange(page) {
    const query = buildQuery() + `&page=${page}&take=10`;
    sendRequest(query);
}

function debounce(func, delay) {
    let timeout;
    return function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(this, arguments);
        }, delay);
    };
}



const searchInput = document.getElementById('searchInput');
const genreFilter = document.getElementById('genreFilter');
const ratingFilter = document.getElementById('ratingFilter');
const sortFilter = document.getElementById('sortFilter');

const debouncedSearch = debounce(handleFilterChange, 300);

searchInput.addEventListener('input', debouncedSearch);
genreFilter.addEventListener('change', handleFilterChange);
ratingFilter.addEventListener('change', handleFilterChange);
sortFilter.addEventListener('change', handleFilterChange);