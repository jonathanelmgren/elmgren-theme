
<?php

require_once __DIR__ . '/base.php';

class Elm_Footer_Walker_Nav_Menu extends Elm_Walker_Nav_Menu
{
    protected function get_combined_attributes($item, $depth, $args): string
    {
        $settings = [
            'footer_menu_link_color' => ['attr' => 'text', 'fallback' => 'text-gray-600'],
            'footer_menu_link_color_hover' => ['attr' => 'text', 'prefix' => 'hover', 'fallback' => 'text-gray-900']
        ];
        return elm_get_classes_and_styles($settings, 'text', '', false, 'text-sm leading-6');
    }
}
