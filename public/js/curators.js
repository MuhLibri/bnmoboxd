function sendRequest(query) {
    const xhr = new XMLHttpRequest();
    const url = `/curators/search?${query}`;
    xhr.open('GET', url);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('cl').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

function handlePageChange(page) {
    const query = `page=${page}&take=5`;
    sendRequest(query);
}

function subscribe() {
    const xhr = new XMLHttpRequest();
    const curatorUsername = document.getElementById('curator_username').value;
    xhr.open("post", `/curators/${curatorUsername}/subscribe`, true);
    xhr.onload = function () {
        console.log(xhr.responseText);
        if (xhr.status === 200) {
            window.location.href = `/curators/${curatorUsername}`;
        }
    };
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send();
}

document.addEventListener("DOMContentLoaded", function () {
    const subscribeButton = document.querySelector('#subscribe');
    subscribeButton?.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#confirm-subscribe-modal');
    });

    const confirmEditButton = document.querySelector('#confirm-subscribe-btn');
    confirmEditButton?.addEventListener('click', function (e) {
        e.preventDefault();
        subscribe();
        handleClose('#confirm-subscribe-modal');
    });
});