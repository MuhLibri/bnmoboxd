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

document.addEventListener("DOMContentLoaded", function () {
    const subscribeButton = document.querySelector('#subscribe');
    subscribeButton?.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#confirm-subscribe-modal');
    });

    const confirmEditButton = document.querySelector('#confirm-subscribe-btn');
    confirmEditButton?.addEventListener('click', function (e) {
        console.log("a");
        e.preventDefault();
        // Handle subcribe/unsubscribe
        
        // const form = document.querySelector("#review-form");
        // submitForm(form, window.location.href, function (responseText) {
        //     window.location.href = "/curators/:id";
        // })
        handleClose('#confirm-subscribe-modal');
    });
});

const subscription_status = document.querySelectorAll('.status-text');
subscription_status.forEach(function coloring(ss) {
    if (ss.innerHTML == "Accepted") {
        ss.style.backgroundColor = "green";
    }
    else if (ss.innerHTML == "Pending") {
        ss.style.backgroundColor = "#F29339";
    }
    else if (ss.innerHTML == "Rejected") {
        ss.style.backgroundColor = "red";
    }
    else {
        ss.style.backgroundColor = "grey";
    }
})