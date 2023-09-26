function handleFormSubmit(formId, url, onSuccess) {
    const form = document.querySelector(formId);

    if (!form) {
        return;
    }

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();

        xhr.open("post", url, true);

        // Set up a callback function for when the request is complete
        xhr.onload = function () {
            if (xhr.status === 200) {
                window.location.href = "/";
            } else {
                // Handle errors or failed response here
                const jsonResponse = JSON.parse(xhr.responseText);
                alert(xhr.responseText);
                updateErrorMessages(jsonResponse);
            }
        };

        // Set up the request headers (adjust as needed)
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Send the request with form data
        xhr.send(new URLSearchParams(formData));
    });

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
}