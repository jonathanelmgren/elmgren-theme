<?php
class Elm_Notice
{
    public const STATUSES = ['success', 'warning', 'error', 'info'];
    public const VARIANTS = ['top-fixed', 'bottom-fixed', 'top-scroll', 'bottom-scroll', 'toast', 'inline'];

    public static function init()
    {
        add_action('wp_footer', [__CLASS__, 'display']);
        add_action('rest_api_init', [__CLASS__, 'ajax_notice']);

        // Remove WC notices
        remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
        remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);
    }

    public static function add($message, $type = 'success', $variant = 'top-fixed', $settings = [])
    {
        if (!in_array($type, self::STATUSES)) {
            throw new Exception('Invalid notice type: ' . $type);
        }
        if (!in_array($variant, self::VARIANTS)) {
            throw new Exception('Invalid notice variant: ' . $variant);
        }

        $default_settings = [
            'visibility' => 'persistent',
            'interaction' => 'static'
        ];
        $settings = array_merge($default_settings, $settings);

        $notice_data = [
            'message' => $message,
            'type' => $type,
            'variant' => $variant,
            'settings' => $settings,
            'target' => $settings['target'] ?? ''
        ];

        $existing_notices = get_transient('elm_notices') ?: [];
        $existing_notices[] = $notice_data;
        set_transient('elm_notices', $existing_notices, 60);
    }

    public static function display()
    {
        $notices = get_transient('elm_notices');
        if (is_array($notices)) {
            foreach ($notices as $notice) {
                self::echo_notice($notice);
            }
            delete_transient('elm_notices');
        }
        self::interrupt_wc_notices();
    }

    private static function echo_notice($notice, $escape = true)
    {
        echo self::generate_html($notice, $escape);
    }

    public static function generate_html($notice, $escape = true)
    {
        $message = $notice['message'];
        $type = isset($notice['type']) ? $notice['type'] : 'success';
        $variant = isset($notice['variant']) ? $notice['variant'] : 'top-fixed';
        $visibility = isset($notice['settings']['visibility']) ? $notice['settings']['visibility'] : 'persistent';
        $interaction = isset($notice['settings']['interaction']) ? $notice['settings']['interaction'] : 'static';
        $target = isset($notice['target']) ? $notice['target'] : null;

        $data_attributes = 'data-variant="' . esc_attr($variant) . '"';
        $data_attributes .= ' data-visibility="' . esc_attr($visibility) . '"';
        $data_attributes .= ' data-interaction="' . esc_attr($interaction) . '"';

        if ($variant === 'inline' && $target !== null) {
            $data_attributes .= ' data-target="' . esc_attr($target) . '"';
        }


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
        $el .= $escape ? esc_html($message) : $message;
        $el .= '</span>';
        $el .= '</div>';
        return $el;
    }

    public static function ajax_notice()
    {
        register_rest_route('elm-notice/v1', '/add', [
            'methods' => 'POST',
            'permission_callback' => '__return_true',
            'callback' => function ($request) {

                $notice = [];
                $notice['message'] = $request->get_param('message');
                $notice['type'] = $request->get_param('type');
                $notice['variant'] = $request->get_param('variant');
                $notice['settings'] = $request->get_param('settings');
                $notice['target'] = $request->get_param('target');
                if ($notice['target']) {
                    $notice['settings']['target'] = $target;
                }

                return new WP_REST_Response(self::generate_html($notice), 200);
            },
        ]);
    }

    public static function interrupt_wc_notices()
    {
        $wc_notices = WC()->session->get('wc_notices', []);
        foreach ($wc_notices as $notice_type => $notices) {
            if (!in_array($notice_type, self::STATUSES)) {
                continue; // Skip unknown notice types
            }
            foreach ($notices as $n) {
                $notice = [
                    'message' => $n['notice'],
                    'type' => $notice_type,
                    'variant' => 'top-fixed',
                    'settings' => []
                ];
                self::echo_notice($notice, false);
            }
        }
        WC()->session->set('wc_notices', []);
    }
}

Elm_Notice::init();
