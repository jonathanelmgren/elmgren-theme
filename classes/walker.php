<?php

class Elm_Walker_Nav_Menu extends Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0): void
    {
        $indent = str_repeat("\t", $depth);
        $attributes = $this->get_combined_attributes($item, $depth, $args);
        $title = apply_filters('the_title', $item->title, $item->ID);

        $item_output = "{$args->before}<a href=\"" . esc_attr($item->url) . "\" $attributes>{$args->link_before}$title{$args->link_after}</a>{$args->after}";

        $output .= $indent . apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    protected function get_combined_attributes($item, $depth, $args): string
    {
        return "";  // Placeholder. To be overridden in child classes.
    }
}

class Elm_Header_Walker_Nav_Menu extends Elm_Walker_Nav_Menu
{
    protected function get_combined_attributes($item, $depth, $args): string
    {
        $settings = [
            'header_link_color' => ['attr' => 'text'],
            'header_link_color_hover' => ['attr' => 'text', 'prefix' => 'hover']
        ];
        return elm_get_classes_and_styles($settings);
    }
}

class Elm_Footer_Walker_Nav_Menu extends Elm_Walker_Nav_Menu
{
    protected function get_combined_attributes($item, $depth, $args): string
    {
        $settings = [
            'footer_menu_link_color' => ['attr' => 'text'],
            'footer_menu_link_color_hover' => ['attr' => 'text', 'prefix' => 'hover']
        ];
        return elm_get_classes_and_styles($settings, 'text', '', false, 'text-sm font-semibold leading-6');
    }
}
