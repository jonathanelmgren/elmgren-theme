<?php

trait TailwindColorPickerTrait
{
    protected $presets;

    public static function init()
    {
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_assets']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_assets']);
        add_action('customize_register', [__CLASS__, 'register_class']);
    }

    protected function generate_picker_html($input_name, $value = [])
    {
        $this->presets = defined('TAILWIND_COLORS') ? TAILWIND_COLORS : [];

        $tailwind_color = $value['tailwind'] ?? null;
        $current_color = $value['color'] ?? null;
        list($preset, $shade) = array_pad(explode('-', $tailwind_color, 2), 2, null);

        $html = '<div data-setting-id="' . $this->id . '" class="tailwind-color-picker">';
        $html .= '<input class="iris-color-picker" value="' . $current_color . '" />';

        // Dropdown for selecting the Tailwind color name.
        $html .= '<select class="tailwind-color-name" name="' . $input_name . '">';
        $html .= '<option value="No preset">No preset</option>';
        foreach ($this->presets as $color_name => $shades) {
            $selected = $preset === $color_name ? 'selected' : '';
            $html .= '<option value="' . $color_name . '" ' . $selected . '>' . ucfirst($color_name) . '</option>';
        }
        $html .= '</select>';


        // Dropdown for selecting the Tailwind color shade.
        $html .= '<select class="tailwind-color-shade" name="' . $input_name . '-color-shade">';
        $html .= '</select>';

        $html .= '</div>';

        return $html;
    }
    public static function register_class()
    {
        require_once(TCP_ABS . '/fields/class-tailwind-color-picker-themecustomizer.php');
    }

    public static function enqueue_assets()
    {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style('tailwind-color-picker-css', TCP_ASSETS_URI . '/color_picker.css');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_script('jquery');
        wp_enqueue_script('tailwind-color-picker-js', TCP_ASSETS_URI . '/color_picker.js', ['wp-color-picker', 'jquery', 'customize-controls'], null, true);
        wp_localize_script('tailwind-color-picker-js', 'tailwindColorPicker', array(
            'colors' => defined('TAILWIND_COLORS') ? TAILWIND_COLORS : []
        ));
    }
}
