<?php

function elmgren_get_header_setting(string $setting): mixed
{
    $options = get_field('header', 'options');
    if (is_array($options) && array_key_exists($setting, $options)) {
        return $options[$setting];
    }
    return null;
}

function elmgren_get_header_absolute()
{
    if (elmgren_get_header_setting('header_absolute')) {
        echo 'position:absolute';
    }
}
