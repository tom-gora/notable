const themeBtn = document.querySelector('button[aria-label="Toggle theme"]');
const themeToggle = document.querySelector("#theme-toggle");

const darkSvgString = `<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" class="fill-none stroke-current">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
</svg>`;

const lightSvgString = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-none stroke-current">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
</svg>`;

// vary cookies string based on env b/c Secure and SameSite props are not allowed over http
let themeLStateCookie = "theme=; SameSite=None; Secure";
let themeDStateCookie = "theme=dark; SameSite=None; Secure";

// helpers
const setLightMode = () => {
    themeToggle.classList.add("bg-warning", "translate-x-1");
    themeToggle.classList.remove("bg-info", "translate-x-6");
    themeToggle.innerHTML = lightSvgString;
    document.documentElement.classList.remove("dark");
    // explicitly for component library to work
    document.documentElement.setAttribute("data-theme", "light");
    document.cookie = `${themeLStateCookie}`;
};

const setDarkMode = () => {
    themeToggle.classList.remove("bg-warning", "translate-x-1");
    themeToggle.classList.add("bg-info", "translate-x-6");
    themeToggle.innerHTML = darkSvgString;
    document.documentElement.classList.add("dark");
    // explicitly for component library to work
    document.documentElement.setAttribute("data-theme", "dark");
    document.cookie = `${themeDStateCookie}`;
};

const setTheme = (isDark) => {
    isDark ? setDarkMode() : setLightMode();
    localStorage.setItem("isDark", isDark);
};

export default function () {
    // defautl to light mode if not set else set current
    let isDark = localStorage.getItem("isDark");
    isDark === null ? setTheme(false) : setTheme(isDark === "true");

    themeBtn.addEventListener("click", () => {
        const isDark = localStorage.getItem("isDark") === "true" ? false : true;
        setTheme(isDark);
    });
}
