function handleFormSubmit(formId, url, onSuccess) {
    const form = document.querySelector(formId);
    if (!form) {
        return;
    }

    form.addEventListener("submit", function (e) {
        submitForm(form, url, onSuccess)
    });

}

function submitForm(form, url, onSuccess) {
    const formData = new FormData(form);
    const xhr = new XMLHttpRequest();

    xhr.open("post", url, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            onSuccess();
        } else {
            const jsonResponse = JSON.parse(xhr.responseText);
            updateErrorMessages(jsonResponse);
        }
    };

    xhr.setRequestHeader("enctype", "multipart/form-data");

    xhr.send(formData);
}
function updateErrorMessages(response) {
    const errorElements = document.querySelectorAll(".form-error");
    errorElements.forEach(function (element) {
        element.style.display = "none";
    });

    for (const key in response.errors) {
        const formattedKey = key.replace(/_/g, '-');
        const errorElement = document.getElementById(formattedKey + "-form-error");
        if (errorElement) {
            errorElement.style.display = "block";
            errorElement.textContent = response.errors[key] || '';
        }
    }
}
