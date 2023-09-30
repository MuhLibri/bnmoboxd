function sendRequest() {
    const searchInput = document.getElementById('searchInput').value;
    const genreFilter = document.getElementById('genreFilter').value;
    const ratingFilter = document.getElementById('ratingFilter').value;
    const sortFilter = (document.getElementById('sortFilter').value).split('_');
    const orderBy = sortFilter[0];
    const sort = sortFilter[1] ?? '';
    const xhr = new XMLHttpRequest();
    const url = `/films/search?search=${searchInput}&genre=${genreFilter}&rating=${ratingFilter}&sort=${sort}&orderBy${orderBy}`;
    xhr.open('GET', url);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById("film-poster-list").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
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

const debouncedSearch = debounce(sendRequest, 300);

searchInput.addEventListener('input', debouncedSearch);
genreFilter.addEventListener('change', sendRequest);
ratingFilter.addEventListener('change', sendRequest);
sortFilter.addEventListener('change', sendRequest);