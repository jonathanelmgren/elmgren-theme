<?php

class ELMGREN_Update_Checker
{
    public function __construct()
    {
        if (is_admin()) {
            add_filter('pre_set_site_transient_update_themes', [$this, 'elmgren_check_for_updates']);
        }
    }

    public function elmgren_check_for_updates($transient)
    {
        $basename = basename(get_template_directory());
        $version = (float) wp_get_theme()->parent()->Version;

        $res = wp_remote_get('https://elmgrentheme.elmgren.dev/latest');

        if (is_wp_error($res) || !is_array($res)) {
            return;
        }

        $res = json_decode($res['body'], true);
        $new_version = (float) $res['version'];

        if ($new_version > $version) {
            $transient->response[$basename]['url'] = $res['url'];
            $transient->response[$basename]['slug'] = $basename;
            $transient->response[$basename]['package'] = $res['package'];
            $transient->response[$basename]['new_version'] = $new_version;
        }

        return $transient;
    }
}

new ELMGREN_Update_Checker();
