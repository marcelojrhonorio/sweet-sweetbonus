let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.combine([
  './node_modules/bootstrap/dist/css/bootstrap.min.css',
  'resources/assets/css/home.css',
], 'public/css/home.css')
.copyDirectory('resources/assets/images/home/', 'public/images/home/');

mix.combine([
  './node_modules/bootstrap/dist/css/bootstrap.min.css',
  'resources/assets/css/subpage.css',
], 'public/css/sweet.css')
.copyDirectory('resources/assets/images/subpage/', 'public/images/subpage/');

mix.combine([
  './node_modules/jquery/dist/jquery.min.js',
  './node_modules/jquery-mask-plugin/dist/jquery.mask.min.js',
  './node_modules/@fontawesome/fontawesome-free/js/all.min.js',
  './node_modules/bootstrap/dist/js/bootstrap.min.js',
  'resources/assets/js/mask.js',
  'resources/assets/js/laroute.js',
  'resources/assets/js/campaigns.js',
 ], 'public/js/sweet.js');
