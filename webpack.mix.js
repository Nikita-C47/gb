const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .scripts([
        'public/js/app.js',
        'node_modules/lightbox2/dist/js/lightbox.min.js'
    ], 'public/js/app.js')
   .sass('resources/sass/app.scss', 'public/css')
    .styles([
        'public/css/app.css',
        'node_modules/lightbox2/dist/css/lightbox.min.css'
    ], 'public/css/app.css')
    // Копируем изображения
    .copyDirectory('resources/images', 'public/images')
    .copyDirectory('node_modules/lightbox2/dist/images', 'public/images')
    // Копируем иконки
    .copyDirectory('resources/webicons', 'public');
