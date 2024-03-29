<?php

trait TailwindColorPickerTrait
{
    protected $presets;

    public static function init()
    {
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_assets']);
        add_action('customize_register', [__CLASS__, 'register_customizer_class']);
        add_action('wp_head', [__CLASS__, 'inline_css']);
        add_action('init', [__CLASS__, 'register_acf_class']);
    }

    protected function generate_picker_html($input_name, $value, $setting, $id)
    {
        $this->presets = defined('TAILWIND_COLORS') ? TAILWIND_COLORS : [];

        $tailwind_color = $value['tailwind'] ?? null;
        $current_color = $value['color'] ?? null;
        // Reverse the string, then explode by hyphen
        $reversed_explode = explode('-', strrev($tailwind_color), 2);

        // Reverse the elements and the array itself back to normal
        $preset_shade = array_map('strrev', array_reverse($reversed_explode));

        // Unpack array into variables
        list($preset, $shade) = array_pad($preset_shade, 2, null);

        $html = '<div data-current-color="' . $current_color . '" data-setting="' . $setting . '" data-setting-id="' . $id . '" class="tailwind-color-picker">';
        $html .= '<input type="hidden" id="tailwind-color-picker-value" name="' . $input_name . '" value="' . $current_color . '" />';
        $html .= '<input class="iris-color-picker" value="' . $current_color . '" />';

        // Dropdown for selecting the Tailwind color name.
        $html .= '<select class="tailwind-color-name" >';
        $html .= '<option value="No preset">No preset</option>';
        foreach ($this->presets as $color_name => $shades) {
            $selected = $preset === $color_name ? 'selected' : '';
            $html .= '<option value="' . $color_name . '" ' . $selected . '>' . ucfirst($color_name) . '</option>';
        }
        $html .= '</select>';


        // Dropdown for selecting the Tailwind color shade.
        $html .= '<select class="tailwind-color-shade" >';
        $html .= '</select>';

        $html .= '</div>';

        return $html;
    }
    public static function register_customizer_class()
    {
        require_once(TCP_ABS . '/fields/class-tailwind-color-picker-themecustomizer.php');
    }
    public static function register_acf_class()
    {
        require_once(TCP_ABS . '/fields/class-tailwind-color-picker-acf.php');
        acf_register_field_type('TailwindColorPickerACF');
    }

    public static function enqueue_assets()
    {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_script('jquery');
        wp_enqueue_script('tailwind-color-picker-js', TCP_ASSETS_URI . '/color_picker.js', ['wp-color-picker', 'jquery'], null, true);
        wp_localize_script('tailwind-color-picker-js', 'tailwindColorPicker', array(
            'colors' => defined('TAILWIND_COLORS') ? TAILWIND_COLORS : []
        ));
    }

    public static function inline_css()
    {
        echo '<style>.custom-hover:hover {
            color: var(--hover-color) !important;
        }
        </style>';
    }

    public function sanitize($input)
    {
        return sanitize_tailwind($input);
    }
}
