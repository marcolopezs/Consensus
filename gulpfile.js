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

    mix.scripts(['js-delete.js'], 'public/js/js-delete.js');
    mix.scripts(['js-funciones.js'], 'public/js/js-funciones.js');
});
