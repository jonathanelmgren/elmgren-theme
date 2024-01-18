<?php

define('TCP_ABS', get_template_directory() . '/plugins/tailwind-color-picker');
define('TCP_URI', get_template_directory_uri() . '/plugins/tailwind-color-picker');
define('TCP_ASSETS', TCP_ABS . '/assets');
define('TCP_ASSETS_URI', TCP_URI . '/assets');

include_once TCP_ABS . '/fields/class-tailwind-color-picker-trait.php';
include_once TCP_ABS . '/fields/class-tailwind-color.php';

include_once TCP_ABS . '/functions/sanitize_tailwind.php';
include_once TCP_ABS . '/functions/block-editor-styles.php';

TailwindColorPicker::init();
