import "./bootstrap";
import { initSidebar, initThemeToggle } from "./interactions";

window.onload = () => {
    initSidebar();
    initThemeToggle();
    document.documentElement.classList.remove("no-transition");
};
