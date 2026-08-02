import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    dark: '#0f172a',    // Slate 900
                    primary: '#1e3a8a', // Blue 900
                    accent: '#3b82f6',  // Blue 500
                    light: '#f8fafc',   // Slate 50
                }
            }
        },
    },
    plugins: [forms],
};
