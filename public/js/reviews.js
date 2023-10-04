function sendRequest(query) {
    const xhr = new XMLHttpRequest();
    const url = `/my-reviews/search?${query}`;
    xhr.open('GET', url);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('rl1').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
function handlePageChange(page) {
    const query = `page=${page}&take=5`;
    sendRequest(query);
}