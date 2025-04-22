<?php

function minify_css($css) {
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    $css = preg_replace('/\s*([{}|:;,])\s+/', '$1', $css);
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
   
   return $css;
}

function format_price(float $amount) {
    return number_format($amount, 2, thousands_separator: '');
}

function get_random_photo() {
    $blur = scandir(public_path('assets/img/blur'));
    $blur = array_filter($blur, fn ($file) => ! in_array($file, ['.', '..',]));
    $blur = array_values($blur);

    return '/assets/img/blur/' . $blur[rand(0, count($blur)-1)];
}