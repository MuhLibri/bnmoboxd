document.addEventListener("DOMContentLoaded", function () {
    const saveButton = document.querySelector('#save');
    saveButton.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#confirm-edit-modal');
    });

    const deleteButton = document.querySelector('#delete');
    deleteButton.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#confirm-delete-modal');
    });

    const confirmEditButton = document.querySelector('#confirm-edit-btn');
    confirmEditButton.addEventListener('click', function (e) {
        e.preventDefault();
        const form = document.querySelector("#review-form");
        submitForm(form, window.location.href + '/edit', function (responseText) {
            window.location.href = "/my-reviews";
        })
        handleClose('#confirm-edit-modal');
    });

    const confirmDeleteButton = document.querySelector('#confirm-delete-btn');
    confirmDeleteButton.addEventListener('click', function (e) {
        e.preventDefault();
        const xhr = new XMLHttpRequest();
        const url = window.location.href + '/delete';
        xhr.open('DELETE', url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) { // Check if the request is complete
                if (xhr.status === 200) {
                    window.location.href = '/my-reviews';
                } else {
                    alert('Failed to delete review');
                }
            }
        };
        xhr.send();
    });
});