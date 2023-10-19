<?php

require_once __DIR__ . '/class-elm-base-walker.php';

class Elm_Footer_Walker_Nav_Menu extends Elm_Walker_Nav_Menu
{
    protected function get_combined_attributes($item, $depth, $args): string
    {
        $footer_menu_colors = new TailwindColor([
            'elm_footer_menu_link_color' => ['attr' => 'text', 'fallback' => 'gray-600'],
            'elm_footer_menu_link_color_hover' => ['attr' => 'text', 'prefix' => 'hover', 'fallback' => 'gray-400']
        ]);

        $class = $footer_menu_colors->get_classes('text-sm leading-6');
        $style = $footer_menu_colors->get_styles();

        return "class=\"$class\" style=\"$style\"";
    }
}
