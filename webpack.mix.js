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

// Create public/css/style.css
mix.sass('resources/sass/app.scss', 'public/css');
mix.styles([
    'public/css/app.css',
    'node_modules/perfect-scrollbar/css/perfect-scrollbar.css',
    'resources/themes/purple-admin/css/style.css',
    'node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css',
    'node_modules/datatables.net-responsive-bs4/css/responsive.bootstrap4.css'
], 'public/css/style.css');

// Copy raw CSS to public/css directory.
mix.copyDirectory('resources/css', 'public/css');

// Copy purple-admin fonts to public/fonts directory.
mix.copyDirectory('resources/themes/purple-admin/fonts', 'public/fonts');

// Create public/img directory.
mix.copyDirectory('resources/img', 'public/img');
mix.copyDirectory('resources/themes/purple-admin/images', 'public/img/purple-admin');

// Create public/js/script.js
mix.js('resources/js/app.js', 'public/js');
mix.scripts([
    'public/js/app.js',
    'node_modules/perfect-scrollbar/dist/perfect-scrollbar.js',
    'resources/themes/purple-admin/js/off-canvas.js',
    'resources/themes/purple-admin/js/hoverable-collapse.js',
    'resources/themes/purple-admin/js/misc.js',
    'node_modules/datatables.net/js/jquery.dataTables.js',
    'node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js',
    'node_modules/datatables.net-responsive/js/dataTables.responsive.js',
    'node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.js',
    'resources/js/custom.js'
], 'public/js/script.js');
