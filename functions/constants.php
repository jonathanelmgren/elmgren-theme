<?php

// Define path and URL to the ACF plugin.
define('ELMGREN_ACF_PATH', get_template_directory() . '/plugins/acf/');
define('ELMGREN_ACF_URL', get_template_directory_uri() . '/plugins/acf/');

define('ELMGREN_PAGE_WIDTHS', [
    'Narrow' => 'width-narrow',
    'Normal' => 'width-normal',
    'Wide' => 'width-wide',
    'Ultrawide' => 'width-ultrawide',
    'Fullwidth' => 'width-full',
]);


// === START: Webpack Generated Block ===
if (!defined('TAILWIND_COLORS')) {
    define('TAILWIND_COLORS', json_decode('{"primary":{"50":"#FFFFFF","100":"#F9F7FF","200":"#DED0FC","300":"#C2A9FA","400":"#A783F8","500":"#8B5CF6","600":"#6527F3","700":"#4A0CD6","800":"#3709A1","900":"#25066C","950":"#1C0451","DEFAULT":"#8B5CF6"},"secondary":{"50":"#FCE4BB","100":"#FBDCA8","200":"#FACD81","300":"#F8BD59","400":"#F7AE32","500":"#F59E0B","600":"#C07C08","700":"#8A5906","800":"#543603","900":"#1E1401","950":"#030200","DEFAULT":"#F59E0B"}}', true));
}
// === END: Webpack Generated Block ===

