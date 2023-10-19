<?php

class Elm_Walker_Nav_Menu extends Walker_Nav_Menu
{
    // Helper function to initialize args
    protected function initialize_args($args)
    {
        if (!is_object($args)) {
            return (object) [
                'before' => '',
                'link_before' => '',
                'link_after' => '',
                'after' => ''
            ];
        }
        return $args;
    }

    // Helper function to check if a menu item has children
    protected function has_children($item)
    {
        return is_array($item->classes) && in_array('menu-item-has-children', $item->classes);
    }

    // Helper function to generate item output
    protected function generate_item_output($item, $attributes, $args, $additional_content = '')
    {
        $settings = [
            'header_link_color' => ['attr' => 'text', 'fallback' => 'gray-600'],
            'header_link_color_hover' => ['attr' => 'text', 'prefix' => 'hover', 'fallback' => 'gray-900']
        ];
        $colors = new TailwindColor($settings);
        $classes = $colors->get_classes();
        $styles = $colors->get_styles();
        return $args->before . '<a href="' . esc_attr($item->url) . '" ' . $attributes . '>' . $args->link_before . '<span class="menu-item-text ' . $classes . '" style="' . $styles . '">' . $item->title . '</span>' . $args->link_after . $additional_content . '</a>' . $args->after;
    }

    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0): void
    {
        $args = $this->initialize_args($args);
        $indent = str_repeat("	", $depth);
        $attributes = $this->get_combined_attributes($item, $depth, $args);
        $item_output = $this->generate_item_output($item, $attributes, $args);
        $output .= $indent . apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    protected function get_combined_attributes($item, $depth, $args): string
    {
        return "";  // Placeholder. To be overridden in child classes.
    }
}
