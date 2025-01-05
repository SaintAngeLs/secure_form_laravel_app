document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");
    const menuIconOpen = document.getElementById("menu-icon-open");
    const menuIconClose = document.getElementById("menu-icon-close");

    menuToggle.addEventListener("click", function () {
        const isHidden = mobileMenu.classList.contains("hidden");

        if (isHidden) {
            mobileMenu.classList.remove("hidden");
            menuIconOpen.classList.add("hidden");
            menuIconClose.classList.remove("hidden");
        } else {
            mobileMenu.classList.add("hidden");
            menuIconOpen.classList.remove("hidden");
            menuIconClose.classList.add("hidden");
        }
    });
});
