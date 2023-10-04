document.addEventListener("DOMContentLoaded", function () {
    const saveButton = document.querySelector('#save-btn');
    saveButton.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#confirm-save-modal');
    });

    const cancelButton = document.querySelector('#cancel-btn');
    cancelButton.addEventListener('click', function (e) {
        e.preventDefault();
        window.location.href = window.location.href.replace('/edit', '');
    });

    const deleteButton = document.querySelector('#delete-btn');
    deleteButton.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#confirm-delete-modal');
    });

    const confirmEditButton = document.querySelector('#confirm-save-btn');
    confirmEditButton.addEventListener('click', function (e) {
        e.preventDefault();
        const form = document.querySelector("#film-form");
        submitForm(form, window.location.href, function (responseText) {
            window.location.href = "/films"
        })
        handleClose('#confirm-save-modal');
    });

    const confirmDeleteButton = document.querySelector('#confirm-delete-btn');
    confirmDeleteButton.addEventListener('click', function (e) {
        e.preventDefault();
        const xhr = new XMLHttpRequest();
        const url = window.location.href.replace('edit', 'delete');
        xhr.open('DELETE', url, true);
        xhr.onreadystatechange = function () {
            // alert(xhr.responseText);
            if (xhr.readyState === 4) { // Check if the request is complete
                if (xhr.status === 200) {
                    window.location.href = '/films';
                } else {
                    alert('Failed to delete film');
                }
            }
        };
        xhr.send();
    });
});