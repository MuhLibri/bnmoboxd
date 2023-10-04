const
    CTX_CREATE = 1,
    CTX_UPDATE = 2,
    CTX_INVALID = -1;

function formContext(){
    if(window.location.href.endsWith('new')){
        return CTX_CREATE;
    }else if(window.location.href.endsWith('edit')){
        return CTX_UPDATE;
    }else{
        return CTX_INVALID;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const saveButton = document.querySelector('#save-btn');
    saveButton.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#confirm-save-modal');
    });

    const cancelButton = document.querySelector('#cancel-btn');
    cancelButton.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#confirm-cancel-modal');
    });

    const deleteButton = document.querySelector('#delete-btn');
    deleteButton?.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#confirm-delete-modal');
    });

    const confirmSaveButton = document.querySelector('#confirm-save-btn');
    confirmSaveButton.addEventListener('click', function (e) {
        e.preventDefault();
        const form = document.querySelector("#film-form");
        submitForm(form, window.location.href, function (responseText) {
            switch(formContext()){
                case CTX_CREATE:
                    const jsonResponse = JSON.parse(responseText);
                    window.location.href = '/film/' + jsonResponse['id'];
                    break;
                case CTX_UPDATE:
                    window.location.href = window.location.href.replace('/edit', '');
                    break;
                default:
                    window.location.href = '/'
            }
        })
        handleClose('#confirm-save-modal');
    });

    const confirmCancelButton = document.querySelector('#confirm-cancel-btn');
    confirmCancelButton.addEventListener('click', function (e) {
        e.preventDefault();
        window.location.href = window.location.href.replace(/\/\w+$/, '');
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