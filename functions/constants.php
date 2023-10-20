<?php

// Define path and URL to the ACF plugin.
define('ELM_ACF_PATH', get_template_directory() . '/plugins/acf/');
define('ELM_ACF_URL', get_template_directory_uri() . '/plugins/acf/');

define('DIST_PATH', get_template_directory_uri() . '/dist/');
define('CSS_PATH', DIST_PATH . 'css/');
define('JS_PATH', DIST_PATH . 'js/');

define('ELM_PAGE_WIDTHS', [
    'Narrow' => 'width-narrow',
    'Normal' => 'width-normal',
    'Wide' => 'width-wide',
    'Ultrawide' => 'width-ultrawide',
    'Fullwidth' => 'width-full',
]);
define('ELM_PAGE_WIDTHS_REVERSE', array_flip(ELM_PAGE_WIDTHS));


// === START: Webpack Generated Block ===
if (!defined('TAILWIND_COLORS')) {
    define('TAILWIND_COLORS', json_decode('{"primary":{"50":"#25066C","100":"#F9F7FF","200":"#DED0FC","300":"#C2A9FA","400":"#A783F8","500":"#8B5CF6","600":"#6527F3","700":"#4A0CD6","800":"#3709A1","900":"#25066C","950":"#1C0451","DEFAULT":"#8B5CF6"},"secondary":{"50":"#FCE4BB","100":"#FBDCA8","200":"#FACD81","300":"#F8BD59","400":"#F7AE32","500":"#F59E0B","600":"#C07C08","700":"#8A5906","800":"#543603","900":"#1E1401","950":"#030200","DEFAULT":"#F59E0B"},"lightgray":{"50":"#FFFFFF","100":"#FFFFFF","200":"#FDFDFD","300":"#FAFAFA","400":"#F8F8F8","500":"#F5F5F5","600":"#E8E8E8","700":"#DCDCDC","800":"#CFCFCF","900":"#C2C2C2","950":"#BCBCBC","DEFAULT":"#F5F5F5"},"gray":{"50":"#8A8A8A","100":"#808080","200":"#6B6B6B","300":"#575757","400":"#424242","500":"#2E2E2E","600":"#121212","700":"#000000","800":"#000000","900":"#000000","950":"#000000","DEFAULT":"#2E2E2E"},"accent-primary":{"50":"#FFF4B8","100":"#FFF1A3","200":"#FFEA7A","300":"#FFE452","400":"#FFDD29","500":"#FFD700","600":"#C7A800","700":"#8F7800","800":"#574900","900":"#1F1A00","950":"#030200","DEFAULT":"#FFD700"},"accent-secondary":{"50":"#FFFFFF","100":"#F7FDFB","200":"#E3F7EF","300":"#D0F1E4","400":"#BCECD9","500":"#A8E6CE","600":"#7CD9B5","700":"#51CD9D","800":"#33B281","900":"#278762","950":"#207152","DEFAULT":"#A8E6CE"}}', true));
}
// === END: Webpack Generated Block ===
