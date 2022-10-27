<?php

namespace WPAdminify\Inc\Classes;

if (!defined('ABSPATH')) exit;

class Adminify_Rollback
{

    protected $package_url;

    protected $version;

    protected $plugin_name = WP_ADMINIFY;

    protected $plugin_slug;

    private static $instance = null;

    public function __construct($args = [])
    {
        add_action('admin_post_wp_adminify_rollback_version', [$this, 'jltwp_adminify_post_addons_rollback']);

        foreach ($args as $key => $value) {
            $this->{$key} = $value;
        }
    }


    /**
     *  Rollback function
     */
    public function jltwp_adminify_post_addons_rollback()
    {

        check_admin_referer('wp_adminify_rollback_version');

        $rollback_versions = $this->get_rollback_versions();

        if (empty($_GET['version']) || !in_array($_GET['version'], $rollback_versions)) {
            wp_die(esc_html__('Error occurred, The version selected is invalid. Try selecting different version.', 'adminify'));
        }

        $plugin_slug = basename(WP_ADMINIFY_BASE, '.php');
        $plugin_version = sanitize_text_field($_GET['version']);

        $jltwp_adminify_rollback = new self(
            [
                'version'     => $plugin_version,
                'plugin_name' => $this->plugin_name,
                'plugin_slug' => $plugin_slug,
                'package_url' => sprintf('https://downloads.wordpress.org/plugin/%s.%s.zip', $plugin_slug, $_GET['version']),
            ]
        );

        $jltwp_adminify_rollback->run();

        wp_die('', __('Rollback to Previous Version', MELA_TD), ['response' => 200,]);
    }




    public function get_rollback_versions()
    {
        $rollback_versions = get_transient('wp_adminify_rollback_versions_' . WP_ADMINIFY_VER);
        if (false === $rollback_versions) {
            $max_versions = 30;

            require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

            $plugin_information = plugins_api(
                'plugin_information',
                [
                    'slug' => 'adminify',
                ]
            );

            if (empty($plugin_information->versions) || !is_array($plugin_information->versions)) {
                return [];
            }

            krsort($plugin_information->versions);

            $rollback_versions = [];

            $current_index = 0;
            foreach ($plugin_information->versions as $version => $download_link) {
                if ($max_versions <= $current_index) {
                    break;
                }

                $lowercase_version = strtolower($version);
                $is_valid_rollback_version = !preg_match('/(trunk|beta|rc|dev)/i', $lowercase_version);

                $is_valid_rollback_version = apply_filters(
                    'adminify/options/rollback/is_valid_rollback_version',
                    $is_valid_rollback_version,
                    $lowercase_version
                );

                if (!$is_valid_rollback_version) {
                    continue;
                }

                if (version_compare($version, WP_ADMINIFY_VER, '>=')) {
                    continue;
                }

                $current_index++;
                $rollback_versions[] = $version;
            }

            set_transient('wp_adminify_rollback_versions_' . WP_ADMINIFY_VER, $rollback_versions, WEEK_IN_SECONDS);
        }

        return $rollback_versions;
    }



    private function print_inline_style()
    {
?>
        <style>
            .wrap {
                overflow: hidden;
            }

            h1 {
                background: #0347FF;
                text-align: center;
                color: #fff !important;
                padding: 70px !important;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            h1 img {
                max-width: 300px;
                display: block;
                margin: auto auto 50px;
            }
        </style>

<?php
    }

    protected function apply_package()
    {

        $update_plugins = get_site_transient('update_plugins');

        if (!is_object($update_plugins)) {

            $update_plugins = new \stdClass();
        }

        $plugin_info = new \stdClass();

        $plugin_info->new_version = $this->version;

        $plugin_info->slug = $this->plugin_slug;

        $plugin_info->package = $this->package_url;

        $plugin_info->url = 'https://wpadminify.com/';

        $update_plugins->response[$this->plugin_name] = $plugin_info;

        set_site_transient('update_plugins', $update_plugins);
    }

    protected function upgrade()
    {

        require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

        $logo_url = WP_ADMINIFY_ASSETS_IMAGE . 'logos/logo-text-dark.svg';

        $upgrader_args = [
            'url' => 'update.php?action=upgrade-plugin&plugin=' . rawurlencode($this->plugin_name),
            'plugin' => $this->plugin_name,
            'nonce' => 'upgrade-plugin_' . $this->plugin_name,
            'title' => '<img src="' . $logo_url . '" alt="WP Adminify Version Rollback">' . __('Rollback to Previous Version ', 'adminify'),
        ];

        $this->print_inline_style();

        $upgrader = new \Plugin_Upgrader(new \Plugin_Upgrader_Skin($upgrader_args));

        $upgrader->upgrade($this->plugin_name);
    }

    public function run()
    {

        $this->apply_package();

        $this->upgrade();
    }

    public static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}
