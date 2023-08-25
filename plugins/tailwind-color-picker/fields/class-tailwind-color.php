<?php

class TailwindColor
{
    private $settings;
    private $attr_converter = [
        'bg' => 'background-color',
        'text' => 'color',
        'border' => 'border-color',
    ];

    public function __construct(array $settings, string | bool $fallback = false)
    {
        foreach ($settings as $setting => $option) {
            $attr = $option['attr'];
            $prefix = $option['prefix'] ?? null;
            $fallback = $option['fallback'] ?? false;
            $active = $option['active'] ?? true;
            $extra_attrs = $option['extra_attrs'] ?? ''; // setting specific extra styles
            $value = get_theme_mod($setting);
            $value = $value ? $value : get_field($setting);
            $value = $value ? $value : $fallback;

            $this->settings[$setting] = ['attr' => $attr, 'prefix' => $prefix, 'color' => $value['color'] ?? null, 'tailwind' => $value['tailwind'] ?? null, 'active' => $active, 'extra_attrs' => $extra_attrs];
        }
    }

    public function get_style(string $setting): string
    {
        $setting = $this->settings[$setting];

        if (!isset($this->attr_converter[$setting['attr']])) {
            wp_die('Invalid attribute: ' . $setting['attr'] . ' for setting: ' . $setting);
        }

        $active = $setting['active'];
        $attr = $this->attr_converter[$setting['attr']];
        $prefix = $setting['prefix'];
        $color = $setting['color'];
        $tailwind = $setting['tailwind'];
        $extra_attrs = $setting['extra_attrs'];

        if (!$active) {
            return '';
        }

        if ($prefix === 'hover') {
            $attr = '--hover-color';
        }
        if (!$this->isTailwind($setting)) {
            $style = $attr . ': ' . $color . ';';
            if (!empty($extra_attrs)) {
                $style .= ' ' . $extra_attrs;
            }
            return $style;
        }
        return '';
    }

    public function get_class(string $setting): string
    {
        $setting = $this->settings[$setting];

        $active = $setting['active'];
        $attr = $setting['attr'];
        $prefix = $setting['prefix'];
        $color = $setting['color'];
        $tailwind = $setting['tailwind'];
        $extra_attrs = $setting['extra_attrs'];

        if (!$active) {
            return '';
        }

        if ($this->isTailwind($setting)) {
            $class = $attr . '-' . $tailwind;
            $class = $prefix ? $prefix . ':' . $class : $class;
            if (!empty($extra_attrs)) {
                $class .= ' ' . $extra_attrs;
            }
            return $class;
        } elseif ($prefix === 'hover') {
            return 'custom-hover';
        }
        return '';
    }

    public function get_classes(string $additional_classes = ''): string
    {
        $classes = '';
        foreach ($this->settings as $setting => $option) {
            $classes .= $this->get_class($setting) . ' ';
        }
        return $this->sanitize_attr_string($classes . ' ' . $additional_classes);
    }

    public function get_styles(string $additional_styles = ''): string
    {
        $styles = '';
        foreach ($this->settings as $setting => $option) {
            $styles .= $this->get_style($setting) . ' ';
        }
        return $this->sanitize_attr_string($styles . ' ' . $additional_styles);
    }

    public function isTailwind(array $setting): bool
    {
        return isset($setting['tailwind']) && is_string($setting['tailwind']);
    }

    private function sanitize_attr_string(string $string)
    {
        return trim(preg_replace('/\s+/', ' ', $string));
    }

    public function the_class(string $setting): void
    {
        echo $this->get_class($setting);
    }

    public function the_classes(string $additional_classes = ''): void
    {
        echo $this->get_classes($additional_classes);
    }

    public function the_styles(string $additional_styles = ''): void
    {
        echo $this->get_styles($additional_styles);
    }

    public function the_style(string $setting): void
    {
        echo $this->get_style($setting);
    }
}
