const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                vazir: ['Vazir', ...defaultTheme.fontFamily.sans],
            },
            spacing: {
                '1/4%': '25%',
                '1/3%': '33.333333%',
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
