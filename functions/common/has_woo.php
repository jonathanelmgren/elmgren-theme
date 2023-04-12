<?php

function elmgren_has_woo(): bool
{
    if (class_exists('woocommerce')) {
        return true;
    } else {
        return false;
    }
}
