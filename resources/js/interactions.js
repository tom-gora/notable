export function initSidebar() {
    const sidebar = document.querySelector("#drawer-navigation");
    const sidebarLinks = sidebar.querySelectorAll("a");
    const sidebarToggle = document.querySelector(
        "button[aria-controls='drawer-navigation']",
    );
    const tham = document.querySelector(".tham");
    const thamInner = tham.querySelector(".tham-inner");

    // helpers
    const hideSidebar = () => {
        sidebar.setAttribute("aria-expanded", "false");
        sidebarLinks.forEach((link) => {
            link.classList.add("w-12");
        });
        sidebar.classList.add("-translate-x-[calc(100%-4.8rem)]");
        tham.classList.remove("tham-active");
        thamInner.classList.add("bg-accent-primary");
        thamInner.classList.remove("bg-text-primary");
        document.cookie = "sidebar=;SameSite=None;Secure";
    };

    const showSidebar = () => {
        sidebar.setAttribute("aria-expanded", "true");
        sidebarLinks.forEach((link) => {
            link.classList.remove("w-12");
        });
        sidebar.classList.remove("-translate-x-[calc(100%-4.8rem)]");
        tham.classList.add("tham-active");
        thamInner.classList.add("bg-text-primary");
        thamInner.classList.remove("bg-accent-primary");
        document.cookie = "sidebar=expanded;SameSite=None;Secure";
    };

    sidebarToggle.addEventListener("click", () => {
        sidebar.getAttribute("aria-expanded") == "true"
            ? hideSidebar()
            : showSidebar();
    });
}

export function initThemeToggle() {
    const themeBtn = document.querySelector(
        'button[aria-label="Toggle theme"]',
    );
    const themeToggle = document.querySelector("#theme-toggle");

    const darkSvgString = `<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" class="fill-none stroke-current">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
</svg>`;

    const lightSvgString = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-none stroke-current">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
</svg>`;

    // helpers
    const setLightMode = () => {
        themeToggle.classList.add("bg-warning", "translate-x-1");
        themeToggle.classList.remove("bg-info", "translate-x-6");
        themeToggle.innerHTML = lightSvgString;
        document.documentElement.classList.remove("dark");
        document.cookie = "theme=;SameSite=None;Secure";
    };

    const setDarkMode = () => {
        themeToggle.classList.remove("bg-warning", "translate-x-1");
        themeToggle.classList.add("bg-info", "translate-x-6");
        themeToggle.innerHTML = darkSvgString;
        document.documentElement.classList.add("dark");
        document.cookie = "theme=dark;SameSite=None;Secure";
    };

    const setTheme = (isDark) => {
        isDark ? setDarkMode() : setLightMode();
        localStorage.setItem("isDark", isDark);
    };

    // defautl to light mode if not set else set current
    let isDark = localStorage.getItem("isDark");
    isDark === null ? setTheme(false) : setTheme(isDark === "true");

    themeBtn.addEventListener("click", () => {
        const isDark = localStorage.getItem("isDark") === "true" ? false : true;
        setTheme(isDark);
    });
}
