<?php

if (\file_exists(get_template_directory() . '/vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}

require_once 'functions/constants.php';

require_once 'functions/setup.php';

elmgren_include_folder('classes');

elmgren_include_folder('functions/includes');

elmgren_include_folder('functions/hooks');

elmgren_include_folder('functions/settings');
elmgren_include_folder('functions/settings/theme');

elmgren_include_folder('functions/common');
elmgren_include_folder('functions');
