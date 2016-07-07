var elixir = require('laravel-elixir');
require('laravel-elixir-stylus');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.stylus('custom.styl', 'public/assets/layouts/layout3/css');
    mix.stylus('layout.styl', 'public/assets/layouts/layout3/css');

    mix.scripts(['js-funciones.js'], 'public/js/js-funciones.js');
    mix.scripts(['js-expediente.js'], 'public/js/js-expediente.js');
    mix.scripts(['js-cliente.js'], 'public/js/js-cliente.js');
    mix.scripts(['js-cambiar-estado.js'], 'public/js/js-cambiar-estado.js');
    mix.scripts(['js-tarea.js'], 'public/js/js-tarea.js');
    mix.scripts(['js-create-edit.js'], 'public/js/js-create-edit.js');
});
