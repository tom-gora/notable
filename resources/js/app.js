import "./bootstrap";
import { initSidebar, initThemeToggle } from "./interactions";

//window.onload = () => {

document.addEventListener("livewire:navigated", () => {
    initSidebar();
});

document.addEventListener("DOMContentLoaded", () => {
    initThemeToggle();
    document.documentElement.classList.remove("no-transition");
});
