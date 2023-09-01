<?php

class Elm_Notice
{
    public const STATUSES = ['success', 'warning', 'error', 'info'];
    public const VARIANTS = ['top-fixed', 'bottom-fixed', 'top-scroll', 'bottom-scroll', 'toast', 'inline'];

    public static function init()
    {
        add_action('init', [__CLASS__, 'start_session']);
        add_action('wp_head', [__CLASS__, 'display']);
    }

    public static function start_session()
    {
        if (!session_id()) {
            session_start();
        }
    }

    public static function add($message, $type = 'success', $variant = 'top-fixed', $settings = [])
    {
        if (!in_array($type, self::STATUSES)) {
            throw new Exception('Invalid notice type: ' . $type);
        }
        if (!in_array($variant, self::VARIANTS)) {
            throw new Exception('Invalid notice variant: ' . $variant);
        }

        // Define default settings and merge with provided settings
        $default_settings = [
            'visibility' => 'persistent',  // Options: 'auto-dismiss', 'persistent'
            'interaction' => 'static'        // Options: 'static', 'clickable'
        ];

        $settings = array_merge($default_settings, $settings);
        $target = isset($settings['target']) ? $settings['target'] : '';

        $_SESSION['elm_notices'][] = [
            'message' => $message,
            'type' => $type,
            'variant' => $variant,
            'settings' => $settings,
            'target' => $target
        ];
    }

    public static function display()
    {
        if (!empty($_SESSION['elm_notices'])) {
            foreach ($_SESSION['elm_notices'] as $notice) {
                $data_attributes = 'data-variant="' . esc_attr($notice['variant']) . '"';
                $data_attributes .= ' data-visibility="' . esc_attr($notice['settings']['visibility']) . '"';
                $data_attributes .= ' data-interaction="' . esc_attr($notice['settings']['interaction']) . '"';

                if ($notice['variant'] === 'inline' && !empty($notice['target'])) {
                    $data_attributes .= ' data-target="' . esc_attr($notice['target']) . '"';
                }

                $type = $notice['type'];
                $variant = $notice['variant'];
                $attrs = ['bg', 'border', 'text'];
                $tw_color_settings = [];
                foreach ($attrs as $attr) {
                    $color = 'green-500';
                    switch ($type) {
                        case 'success':
                            $color = 'green-500';
                            break;
                        case 'warning':
                            $color = 'yellow-500';
                            break;
                        case 'error':
                            $color = 'red-500';
                            break;
                        case 'info':
                            $color = 'blue-500';
                            break;
                    }
                    $tw_color_settings["notice_{$type}_{$attr}"] = [
                        'attr' => $attr,
                        'fallback' => $color,
                    ];
                }

                $position_classes = '';
                switch ($variant) {
                    case 'top-scroll':
                        $position_classes = 'fixed top-0 right-0 left-0';
                        break;
                    case 'bottom-scroll':
                        $position_classes = 'fixed bottom-0 right-0 left-0';
                        break;
                    case 'toast':
                        $position_classes = 'fixed top-4 right-4 min-w-[10rem]';
                        break;
                    default:
                        break;
                }

                $container_width = get_theme_mod('notice_bg_width', 'width-full');
                $content_width = get_theme_mod('notice_content_width', 'width-normal');
                $text_align = get_theme_mod('notice_text_align', 'text-center');
                $notice_colors = new TailwindColor($tw_color_settings);

                // Position is defined with jQuery
                $el = '<div style="' . $notice_colors->get_styles('border-width:1px;') . '" class="' . $notice_colors->get_classes($container_width . ' ' . $text_align . ' elm-notice hidden p-3 text-md z-50 ' . $position_classes) . '" ' . $data_attributes . '>';
                $el .= '<span class="block ' . $content_width . '">';
                $el .= esc_html($notice['message']);
                $el .= '</span>';
                $el .= '</div>';
                echo $el;
            }
            unset($_SESSION['elm_notices']);  // Clear notices after displaying
        }
    }

    public static function mock($message = 'This is a mock notice', $type = 'success', $variant = 'top-fixed', $settings = [])
    {
        self::add($message, $type, $variant, $settings);
    }
}

Elm_Notice::init();
