export default function () {
    const topbar = document.querySelector("#secondary-nav");
    window.onscroll = function () {
        if (window.scrollY > 50) {
            topbar.classList.add("shadow-md");
        } else {
            topbar.classList.remove("shadow-md");
        }
    };
}
