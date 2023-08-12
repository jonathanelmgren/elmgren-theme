<?php

if (\file_exists(get_template_directory() . '/vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}

require_once 'functions/constants.php';
require_once 'functions/setup.php';
require_once 'plugins/acf/acf.php';

elm_include_folder('classes');
elm_include_folder('functions');
