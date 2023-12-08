<?php

class Theme_Updater
{
    private $username;
    private $repository;
    private $theme;

    public function __construct()
    {
        $this->username = 'jonathanelmgren';
        $this->repository = 'elmgren-theme';
        $this->theme = wp_get_theme('elmgren-theme');

        // Check for updates
        add_filter('pre_set_site_transient_update_themes', array($this, 'check_update'));
    }

    public function check_update($transient)
    {
        if (empty($transient->checked)) {
            return $transient;
        }

        // Get the latest release from GitHub
        $release = $this->fetchLatestRelease();

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

    private function fetchLatestRelease()
    {
        $apiUrl = "https://api.github.com/repos/{$this->username}/{$this->repository}/releases";
        $response = wp_remote_get($apiUrl);
        $responseBody = wp_remote_retrieve_body($response);

        if (is_wp_error($response) || empty($responseBody)) {
            return false;
        }

        $releases = json_decode($responseBody);
        $latestRelease = null;

        for ($i = 0; $i < min(10, count($releases)); $i++) {
            $release = $releases[$i];

            // Check if it's a beta release
            $isBeta = strpos($release->tag_name, 'beta') !== false;

            // If it's not beta or if beta is allowed
            if (!$isBeta || ($isBeta && $this->is_beta())) {
                // Compare version and update the latest release if the new one is greater
                if ($latestRelease === null || version_compare($release->tag_name, $latestRelease->tag_name, '>')) {
                    $latestRelease = $release;
                }
            }
        }

        return $latestRelease;
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
