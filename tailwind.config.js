import daisyui from 'daisyui';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
            },
        },
    },

    plugins: [daisyui],

    daisyui: {
        themes: [
            {
                auto30: {
                    "primary": "#4f46e5",
                    "primary-content": "#ffffff",
                    "secondary": "#f8fafc",
                    "secondary-content": "#1e293b",
                    "accent": "#0ea5e9",
                    "accent-content": "#ffffff",
                    "neutral": "#1e293b",
                    "neutral-content": "#f8fafc",
                    "base-100": "#ffffff",
                    "base-200": "#f1f5f9",
                    "base-300": "#e2e8f0",
                    "info": "#3b82f6",
                    "success": "#22c55e",
                    "warning": "#f59e0b",
                    "error": "#ef4444",
                },
            },
        ],
    },
};
