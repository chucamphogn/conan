const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    mode: 'jit',

    purge: [
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php'
    ],

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

    /**
     * Không cần setup variants nữa vì đang bật chế độ JIT, nó sẽ tự động tạo ra các variant tương ứng
     * Có thể setup ở đây để PhpStorm gợi ý class
     */
    // variants: {
    //     extend: {
    //         opacity: ['disabled'],
    //         fill: ['dark'],
    //         borderWidth: ['dark', 'hover', 'focus'],
    //     },
    // },

    plugins: [require('@tailwindcss/forms')],
};
