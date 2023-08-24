<?php

class TailwindColor
{
    private $setting;

    public function __construct(string $setting, string | bool $fallback = false)
    {
        $this->setting = get_theme_mod($setting, $fallback);

        $this->tailwind = $this->setting['tailwind'] ?? null;
        $this->color = $this->setting['color'] ?? null;
        if ($setting === 'header_bg_color') {
            //dd($this->setting);
        }
    }

    public function get_style(string $attr, string | null $prefix = null): string
    {
        if ($prefix === 'hover') {
            $attr = '--hover-color';
        }
        if (!$this->isTailwind()) {
            return $attr . ': ' . $this->color . ';';
        }
        return '';
    }

    public function get_class(string $attr, string | null $prefix = null): string
    {
        if ($this->isTailwind()) {
            $class = $attr . '-' . $this->tailwind;
            $class = $prefix ? $prefix . ':' . $class : $class;
            return $class;
        } elseif ($prefix === 'hover') {
            return 'custom-hover';
        }
        return '';
    }

    public function isTailwind(): bool
    {
        return isset($this->tailwind) && is_string($this->tailwind);
    }
}
