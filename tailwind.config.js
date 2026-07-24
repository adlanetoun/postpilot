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
                sans: ['Plus Jakarta Sans', 'Inter', 'system-ui', 'sans-serif'],
                headline: ['Plus Jakarta Sans', 'sans-serif'],
            },
            keyframes: {
                shimmer: {
                    '100%': { transform: 'translateX(100%)' },
                }
            },
            animation: {
                shimmer: 'shimmer 2s infinite',
            }
        },
    },

    plugins: [daisyui],

    daisyui: {
        themes: [
            {
                auto30: {
                    "primary": "#0040e0",
                    "primary-content": "#ffffff",
                    "secondary": "#f8f9fc",
                    "secondary-content": "#191c1e",
                    "accent": "#dde1ff",
                    "accent-content": "#001356",
                    "neutral": "#191c1e",
                    "neutral-content": "#ffffff",
                    "base-100": "#ffffff",
                    "base-200": "#f8f9fc",
                    "base-300": "#edeef1",
                    "info": "#3b82f6",
                    "success": "#22c55e",
                    "warning": "#f59e0b",
                    "error": "#ef4444",
                },
            },
        ],
    },
};
