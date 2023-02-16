<?php

if (\file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}

require_once 'functions/_consts.php';

require_once 'functions/setup.php';

elmgren_include_folder('functions/hooks');

elmgren_include_folder('functions/settings');

elmgren_include_folder('functions/common');

