function onClick() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

document.getElementById("logoutButton").addEventListener("click", function(e) {
    e.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/logout", true);
    xhr.onload = function () {
        window.location.href = "/"
    };
    xhr.send();
});