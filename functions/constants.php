<?php

// Define path and URL to the ACF plugin.
define('ELM_ACF_PATH', get_template_directory() . '/plugins/acf/');
define('ELM_ACF_URL', get_template_directory_uri() . '/plugins/acf/');

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
    define('TAILWIND_COLORS', json_decode('{"primary":{"50":"#F9F7FF","100":"#DED0FC","DEFAULT":"#8B5CF6"},"secondary":{"50":"#FCE4BB","100":"#FBDCA8","DEFAULT":"#F59E0B"}}', true));
}
// === END: Webpack Generated Block ===
