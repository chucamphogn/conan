const mix = require('laravel-mix');

mix.ts('resources/js/app.ts', 'public/js');

mix.postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        // require('tailwindcss'),
        require('@tailwindcss/jit'),
        require('autoprefixer'),
    ]);

mix.copyDirectory('resources/images', 'public/images');
