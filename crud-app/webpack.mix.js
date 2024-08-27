const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .vue() // Incluye esta línea si estás usando Vue.js
   .postCss('resources/css/app.css', 'public/css')
   .version(); // Opcional, para versionar archivos
