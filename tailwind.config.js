import defaultTheme from "tailwindcss/defaultTheme";
const { addIconSelectors } = require("@iconify/tailwind");

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "selector",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.css",
        "./resources/**/*.html",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "accent-primary": "var(--accent-primary)",
                "accent-primary-subtle": "var(--accent-primary-subtle)",
                "accent-primary-focus": "var(--accent-primary-focus)",
                "accent-primary-content": "var(--accent-primary-content)",

                "accent-secondary": "var(--accent-secondary)",
                "accent-secondary-subtle": "var(--accent-secondary-subtle)",
                "accent-secondary-focus": "var(--accent-secondary-focus)",
                "accent-secondary-content": "var(--accent-secondary-content)",

                neutral: "var(--neutral)",
                "neutral-subtle": "var(--neutral-subtle)",
                "neutral-focus": "var(--neutral-focus)",
                "neutral-content": "var(--neutral-content)",

                "text-primary": "var(--text-primary)",
                "text-subtle": "var(--text-subtle)",

                surface: "var(--surface)",
                "surface-strong": "var(--surface-strong)",

                "base-100": "var(--base-100)",
                "base-200": "var(--base-200)",
                "base-300": "var(--base-300)",

                info: "var(--info)",
                success: "var(--success)",
                warning: "var(--warning)",
                error: "var(--error)",
            },
            backgroundImage: {
                splash01: "url(/public/splash_01.svg)",
            },
        },
    },
    // safelist icon classes applied dynamically
    safelist: [
        "solar--home-bold-duotone",
        "hugeicons--quill-write-02",
        "solar--eye-scan-bold-duotone",
        "solar--inbox-archive-line-duotone",
        "solar--widget-2-line-duotone",
        "solar--notebook-bookmark-bold-duotone",
        "solar--settings-line-duotone",
    ],
    plugins: [
        addIconSelectors(["solar", "hugeicons", "bxs"]),
        require("tailwind-hamburgers"),
        "prettier-plugin-tailwindcss",
    ],
};
