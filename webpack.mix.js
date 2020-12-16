const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix

    .styles([
        'resources/views/series/assets/css/createSeries.css',
        'resources/views/series/assets/css/indexTemp.css'
    ], 'public/seriespub/assets/css/style.css')

    .scripts([
        'resources/views/series/assets/js/createSeries.js'
    ], 'public/seriespub/assets/js/createSeries.js')

    .scripts([
        'resources/views/series/assets/js/indexSeries.js'
    ], 'public/seriespub/assets/js/indexSeries.js')

    .scripts([
        'resources/views/series/assets/js/indexTemp.js'
    ], 'public/seriespub/assets/js/indexTemp.js')
;
