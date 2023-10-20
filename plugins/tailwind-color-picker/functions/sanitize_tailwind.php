<?php

function sanitize_tailwind($input)
{
    $color = sanitize_hex_color($input);
    $res = ['tailwind' => null, 'color' => $color];
    foreach (TAILWIND_COLORS as $tailwindKey => $colors) {
        if (is_string($colors)) {
            continue;
        }
        foreach ($colors as $shade => $colorValue) {
            if (is_string($shade)) {
                continue;
            }
            if (strtolower($colorValue) == strtolower($color)) {
                // If the shade is 'DEFAULT', return just the primary class, otherwise return both the class and shade
                $res['tailwind'] = $shade == 'DEFAULT' ? $tailwindKey : $tailwindKey . '-' . $shade;
            }
        }
    }
    return $res; // return null if not found
}
