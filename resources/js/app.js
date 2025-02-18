import "./bootstrap";
import * as c from "./components";

//document.addEventListener("livewire:init", () => {
//});

document.addEventListener(
    "livewire:navigated",
    () => {
        // this is run with every navigation because
        // it reads the stored state of the sidebar
        // and keeps it persistent when navigating between routes
        c.initSidebar();

        document.documentElement.classList.remove("no-transition");
        c.initThemeToggle();
        c.initTopbar();
        c.initAccordion();
        c.initEditorAlerts();
    },
    { once: true },
);
