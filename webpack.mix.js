const mix  = require('laravel-mix');

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

mix.scripts('resources/assets/js/jquery.js', 'public/js/jquery.js');
mix.scripts('resources/assets/js/bootstrap.js', 'public/js/bootstrap.js');
mix.scripts('resources/assets/js/app.js', 'public/js/app.js');

mix.sass('resources/assets/scss/app.scss', 'public/css');
