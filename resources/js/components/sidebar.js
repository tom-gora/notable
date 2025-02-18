const sidebar = document.querySelector("#drawer-navigation");
const sidebarLinks = sidebar.querySelectorAll("a");
const sidebarToggle = document.querySelector(
    "button[aria-controls='drawer-navigation']",
);
const tham = document.querySelector(".tham");
const thamInner = tham.querySelector(".tham-inner");
const slot = document.querySelector("#slot-content");
const themeBtn = document.querySelector('button[aria-label="Toggle theme"]');
const topbar = document.querySelector("#secondary-nav");

// vary cookies string based on env b/c Secure and SameSite props are not allowed over http
let sidebar0StateCookie = "sidebar=; SameSite=None; Secure";
let sidebar1StateCookie = "sidebar=expanded; SameSite=None; Secure";

// sidebar helpers
const hideSidebar = (
    themeBtn,
    slot,
    sidebar,
    sidebarLinks,
    tham,
    thamInner,
    topbar,
    sidebar0StateCookie,
) => {
    themeBtn.classList.remove("md:translate-x-44");
    themeBtn.classList.remove("translate-x-[calc(100vw-160%)]");
    slot.classList.remove("pl-64");
    slot.classList.add("pl-16");
    sidebar.setAttribute("aria-expanded", "false");
    sidebarLinks.forEach((link) => {
        link.classList.add("w-12");
    });
    sidebar.classList.add("-translate-x-[calc(100%-4.8rem)]");
    tham.classList.remove("tham-active");
    thamInner.classList.add("bg-accent-primary");
    thamInner.classList.remove("bg-text-primary");
    topbar.classList.add("pl-32");
    topbar.classList.remove("pl-80");
    document.cookie = `${sidebar0StateCookie}`;
};

const showSidebar = (
    themeBtn,
    slot,
    sidebar,
    sidebarLinks,
    tham,
    thamInner,
    topbar,
    sidebar1StateCookie,
) => {
    themeBtn.classList.add("md:translate-x-44");
    themeBtn.classList.add("translate-x-[calc(100vw-160%)]");
    slot.classList.add("pl-64");
    slot.classList.remove("pl-16");
    sidebar.setAttribute("aria-expanded", "true");
    sidebarLinks.forEach((link) => {
        link.classList.remove("w-12");
    });
    sidebar.classList.remove("-translate-x-[calc(100%-4.8rem)]");
    tham.classList.add("tham-active");
    thamInner.classList.add("bg-text-primary");
    thamInner.classList.remove("bg-accent-primary");
    topbar.classList.remove("pl-32");
    topbar.classList.add("pl-80");
    document.cookie = `${sidebar1StateCookie}`;
};

export default function () {
    sidebarToggle.addEventListener("click", () => {
        sidebar.getAttribute("aria-expanded") == "true"
            ? hideSidebar(
                  themeBtn,
                  slot,
                  sidebar,
                  sidebarLinks,
                  tham,
                  thamInner,
                  topbar,
                  sidebar0StateCookie,
              )
            : showSidebar(
                  themeBtn,
                  slot,
                  sidebar,
                  sidebarLinks,
                  tham,
                  thamInner,
                  topbar,
                  sidebar1StateCookie,
              );
    });
}
