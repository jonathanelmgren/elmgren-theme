
<?php

require_once __DIR__ . '/base.php';

class Elm_Mobile_Walker_Nav_Menu extends Elm_Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0): void
    {
        $args = $this->initialize_args($args);
        $indent = str_repeat("	", $depth);
        $attributes = 'class="flex justify-between py-2 items-center" data-menu-item data-is-mobile';
        $arrow_down = $this->has_children($item) ? elm_get_inline_svg('arrow_down') : '';
        $attributes .= $this->has_children($item) ? ' data-has-children' : '';
        $item_output = $this->generate_item_output($item, $attributes, $args, $arrow_down);
        $output .= $indent . apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat($t, $depth);

        // Default class.
        $classes = array('sub-menu w-full px-2');

        $class_names = implode(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));

        $atts          = array();
        $atts['class'] = !empty($class_names) ? $class_names : '';
        $atts['style'] = 'display: none;';

        /**
         * Filters the HTML attributes applied to a menu list element.
         *
         * @since 6.3.0
         *
         * @param array $atts {
         *     The HTML attributes applied to the `<ul>` element, empty strings are ignored.
         *
         *     @type string $class    HTML CSS class attribute.
         * }
         * @param stdClass $args      An object of `wp_nav_menu()` arguments.
         * @param int      $depth     Depth of menu item. Used for padding.
         */
        $atts       = apply_filters('nav_menu_submenu_attributes', $atts, $args, $depth);
        $attributes = $this->build_atts($atts);

        $output .= "{$n}{$indent}<ul{$attributes}>{$n}";
    }
}
