<?php

function elmgren_get_footer_setting(string $setting): mixed
{
    $options = get_field('footer', 'options');
    if (is_array($options) && array_key_exists($setting, $options)) {
        return $options[$setting];
    }
    return null;
}
function elmgren_the_footer_setting(string $setting): void
{
    echo elmgren_get_footer_setting($setting);
}

function elmgren_has_socials(?string $social = null): bool
{
    if ($social && elmgren_get_footer_setting($social)) {
        return true;
    } elseif ($social && !elmgren_get_footer_setting($social)) {
        return false;
    }

    if (elmgren_get_footer_setting('youtube') || elmgren_get_footer_setting('instagram') || elmgren_get_footer_setting('facebook')) {
        return true;
    }
    return false;
}
