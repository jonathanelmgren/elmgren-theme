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

        $footer_menu_link_color = new TailwindColor('footer_menu_link_color');
        $footer_menu_link_color_hover = new TailwindColor('footer_menu_link_color_hover');

        $class = 'text-sm leading-6 ' . $footer_menu_link_color->get_class('text') . ' ' . $footer_menu_link_color_hover->get_class('text', 'hover');
        $style = $footer_menu_link_color->get_style('color') . ' ' . $footer_menu_link_color_hover->get_style('color', 'hover');

        return "class=\"$class\" style=\"$style\"";
    }
}
