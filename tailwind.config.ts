import type { Config } from "tailwindcss";
import { addIconSelectors } from "@iconify/tailwind";
import daisyui from "daisyui";
import twh from "tailwind-hamburgers";
import typography from "@tailwindcss/typography";

export default {
    darkMode: "selector",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.css",
        "./resources/**/*.html",
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", "ui-sans-serif", "system-ui", "sans-serif"],
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
        },
    },

    daisyui: {
        themes: [
            {
                light: {
                    primary: "#da614c",
                    secondary: "#505678",
                    warning: "#ff9900",
                    success: "#009485",
                    error: "#ff5724",
                    info: "#478ec7",
                },
                dark: {
                    primary: "#da614c",
                    secondary: "#8590c8",
                    warning: "#ff9900",
                    success: "#009485",
                    error: "#ff5724",
                    info: "#478ec7",
                },
            },
        ],
    },
    // safelist icon classes applied dynamically
    safelist: [
        "solar--home-bold-duotone",
        "hugeicons--quill-write-02",
        "solar--eye-scan-bold-duotone",
        "solar--inbox-archive-line-duotone",
        "solar--widget-2-line-duotone",
        "solar--stars-minimalistic-line-duotone",
        "solar--settings-line-duotone",
        "group-focus-visible:text-error",
        "group-focus:text-error",
        "group-hover:text-error",
        "group-focus-visible:text-secondary-focus",
        "group-focus:text-info",
        "group-hover:text-info",
        "group-focus-visible:text-neutral-focus",
        "group-focus:text-surface-strong",
        "group-hover:text-surface-strong",
        "peer-focus:!text-accent-primary-focus",
        "!w-0",
        "!p-0",
    ],
    plugins: [
        addIconSelectors(["solar", "hugeicons", "bxs", "stash"]),
        daisyui,
        twh,
        typography,
    ],
} satisfies Config;
