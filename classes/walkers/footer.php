<?php

require_once __DIR__ . '/base.php';

class Elm_Footer_Walker_Nav_Menu extends Elm_Walker_Nav_Menu
{
    protected function get_combined_attributes($item, $depth, $args): string
    {
        $footer_menu_colors = new TailwindColor([
            'footer_menu_link_color' => ['attr' => 'text', 'fallback' => 'text-gray-600'],
            'footer_menu_link_color_hover' => ['attr' => 'text', 'prefix' => 'hover', 'fallback' => 'text-gray-900']
        ]);

        $class = $footer_menu_colors->get_classes('text-sm leading-6');
        $style = $footer_menu_colors->get_styles();

        return "class=\"$class\" style=\"$style\"";
    }
}
