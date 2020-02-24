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

// Create public/app.css
mix.sass('resources/sass/app.scss', 'public/css');
mix.styles([
    'public/css/app.css',
    'node_modules/perfect-scrollbar/css/perfect-scrollbar.css',
    'resources/themes/purple-admin/css/style.css'
], 'public/css/style.css');

// Copy purple-admin fonts to public/fonts directory.
mix.copyDirectory('resources/themes/purple-admin/fonts', 'public/fonts');

// Copy purple-admin logos to  public/img directory.
mix.copy('resources/themes/purple-admin/images/logo.svg', 'public/img/purple-admin/logo.svg');
mix.copy('resources/themes/purple-admin/images/logo-mini.svg', 'public/img/purple-admin/logo-mini.svg');

// Create public/js/app.js
mix.js('resources/js/app.js', 'public/js');
mix.scripts([
    'public/js/app.js',
    'node_modules/perfect-scrollbar/dist/perfect-scrollbar.js',
    'resources/themes/purple-admin/js/off-canvas.js',
    'resources/themes/purple-admin/js/hoverable-collapse.js',
    'resources/themes/purple-admin/js/misc.js'
], 'public/js/script.js');
