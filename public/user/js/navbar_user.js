const menu = document.getElementById("subMenu");

if (localStorage.getItem("menuOpen") === "true") {
    menu.style.display = "block";
}

function toggleMenu() {
    if (menu.style.display === "none" || menu.style.display === "") {
        menu.style.display = "block";
        localStorage.setItem("menuOpen", "true");
    } else {
        menu.style.display = "none";
        localStorage.setItem("menuOpen", "false");
    }
}