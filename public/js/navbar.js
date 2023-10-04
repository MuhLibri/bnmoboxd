function onClick() {
    const x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const logoutButton = document.getElementById("logoutButton");
    if (logoutButton) {
        logoutButton.addEventListener("click", function (e) {
            e.preventDefault();
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/logout", true);
            xhr.onload = function () {
                window.location.href = "/";
            };
            xhr.send();
        });
    }
});