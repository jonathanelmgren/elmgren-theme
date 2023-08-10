<?php
class Elmgren_Walker_Nav_Menu extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $args = (object) $args;  // Type cast to object

        $attributes = ' href="' . esc_attr($item->url) . '" class="text-sm font-semibold leading-6 text-gray-900"';

        $title = apply_filters('the_title', $item->title, $item->ID);

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
