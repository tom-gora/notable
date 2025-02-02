import "./bootstrap";
import * as c from "./components";

//document.addEventListener("livewire:init", () => {
//});

document.addEventListener(
    "livewire:navigated",
    () => {
        console.log("Navigated");
        // this is run with every navigation because
        // it reads the stored state of the sidebar
        // and keeps it persistent when navigating between routes
        c.initSidebar();

        document.documentElement.classList.remove("no-transition");
        c.initThemeToggle();
        c.initTopbar();
        c.initAccordion();
    },
    { once: true },
);

if (Livewire) {
    Livewire.hook("component.init", ({ component }) => {
        if (component.name === "core.editor") {
            console.log("editor init triggered");
            c.initEditorAlerts(component.$wire);
        }
    });
}
