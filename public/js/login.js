document.addEventListener("DOMContentLoaded", function () {
    handleFormSubmit("#login-form", "/login", function () {
        window.location.href = "/"
    });
});
