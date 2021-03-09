const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    purge: ['./storage/framework/views/*.php', './resources/views/**/*.blade.php'],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            ...colors,
            transparent: 'transparent',
        }
    },

    variants: {
        extend: {
            opacity: ['disabled'],
            fill: ['dark'],
            borderWidth: ['dark', 'hover', 'focus'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
