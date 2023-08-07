<?php

class Theme_Updater
{
    private $user;
    private $repo;
    private $theme;

    public function __construct()
    {
        $this->user = 'jonathanelmgren';
        $this->repo = 'elmgren-theme';
        $this->theme = wp_get_theme('elmgren-theme');

        // Check for updates
        add_filter('pre_set_site_transient_update_themes', array($this, 'check_update'));
    }

    public function check_update($transient)
    {
        if (empty($transient->checked)) {
            return $transient;
        }

        // Get the appropriate release from GitHub
        $release = $this->get_appropriate_release();

        if (!$release) {
            return $transient;
        }

        // If a new version is available, set the transient
        if (version_compare($this->theme->version, $release->tag_name, '<')) {
            $asset = $this->get_asset_download_url($release->assets_url);
            if ($asset !== false) {
                $transient->response[$this->theme->stylesheet] = array(
                    'theme'       => $this->theme->get('Name'),
                    'new_version' => $release->tag_name,
                    'url'         => $release->html_url,
                    'package'     => $asset,
                );
            }
        }

        return $transient;
    }

    private function get_appropriate_release()
    {
        $url = "https://api.github.com/repos/{$this->user}/{$this->repo}/releases";

        // Get the JSON response from the provided URL
        $response = wp_remote_get($url);
        $response_body = wp_remote_retrieve_body($response);

        // Check for error
        if (is_wp_error($response) || empty($response_body)) {
            return false;
        }

        $releases = json_decode($response_body);

        if ($this->is_beta()) {
            // Return the latest beta release
            foreach ($releases as $release) {
                if (strpos($release->tag_name, 'beta') !== false) {
                    return $release;
                }
            }
        }

        // If not beta or no beta release found, return the latest release
        return $releases[0];
    }

    private function get_asset_download_url($url)
    {
        $response = wp_remote_get($url);
        $response_body = wp_remote_retrieve_body($response);

        if (is_wp_error($response) || empty($response_body)) {
            return false;
        }

        $assets = json_decode($response_body);
        foreach ($assets as $asset) {
            if ($asset->name === 'elmgren-theme.zip') {
                return $asset->browser_download_url;
            }
        }

        return false;
    }

    private function is_beta()
    {
        $options = get_field('beta', 'options');
        if (is_array($options) && array_key_exists('allow_beta_parent', $options)) {
            return $options['allow_beta_parent'];
        }
        return false;
    }
}

new Theme_Updater();
