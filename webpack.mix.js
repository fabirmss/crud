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

mix
  .js('resources/js/app.js', 'public/assets/js/gebic.min.js')
  .sass('resources/sass/app.scss', 'public/assets/css/gebic.min.css')

  .copy('resources/vendors', 'public/assets/vendors')
  .copy('resources/images', 'public/assets/images')

  .copy('node_modules/@mdi/font/css/materialdesignicons.min.css', 'public/assets/vendors/mdi/css/materialdesignicons.min.css')
  .copy('node_modules/@mdi/font/fonts', 'public/assets/vendors/mdi/fonts')

  .styles([
    './node_modules/sweetalert2/dist/sweetalert2.min.css',
    './node_modules/fullcalendar/main.min.css',
    './node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
  ], 'public/assets/css/plugins.min.css')

  .scripts([
    './node_modules/sweetalert2/dist/sweetalert2.min.js',
    './node_modules/jquery-validation/dist/jquery.validate.min.js',
    './node_modules/jquery-validation/dist/localization/messages_pt_BR.js',
    './node_modules/fullcalendar/main.min.js',
    './node_modules/fullcalendar/locales/pt-br.js',
    './node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
    './node_modules/bootstrap-datepicker/js/locales/bootstrap-datepicker.pt-BR.js',
    './node_modules/jquery-mask-plugin/dist/jquery.mask.min.js',
  ], 'public/assets/js/plugins.min.js')

  .browserSync({
    proxy: 'gebic.com.br',
    files: [
      '!node_modules',
      '!vendor',
      'public/assets/js/**/gebic.min.js',
      'public/assets/css/**/gebic.min.css',
      '{*,**/*}.php',
    ],
    notify: false,
    ghostMode: false,
    port: 3002,
    ui: {
      port: 3007,
    },
  })
  .options({
    processCssUrls: false,
  })
  .setPublicPath('public/assets');
