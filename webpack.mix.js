let mix = require('laravel-mix')

mix.combine(['public/assets/js/'], 'public/assets/js/merged.js')

mix.combine(['public/assets/css/'], 'public/assets/css/merged.css')