import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                afacad: ['Afacad Flux', ...defaultTheme.fontFamily.sans],
            },
            minHeight: {
                '600px': '600px',
            },
            fontSize: {
                '12px': '12px',
            },
            borderRadius: {
                '40px': '40px',
                '45px': '45px',
            },
            colors: {
                'maindark': '#141511',
                'mainldark': '#6061624D',
                'mainone': '#FF9D00',
                'maintwo': '#FF00D8',
                'mainthree': '#03041e',
                'mainhomeone': '#242424',
                'mainhometwo': '#D03630',
                'ade-orange': '#ff4533',
            },
            backgroundColor: {
                'mainone': '#FF9D00',
                'maintwo': '#FF00D8',
                'mainthree': '#03041e',
                'mainhomeone': '#242424',
                'mainhometwo': '#D03630',
                'ade': '#070A46',
                'ade-orange': '#ff4533',
            },
        },
    },

    plugins: [forms, typography],
};
