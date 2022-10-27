<?php

namespace WPAdminify\Inc\Classes;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Classes\ServerInfo;
use WPAdminify\Inc\Admin\AdminSettings;
use WPAdminify\Inc\Admin\AdminSettingsModel;


// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * @package WP Adminify
 * @author: Jewel Theme<support@jeweltheme.com>
 */

class AdminFooterText extends AdminSettingsModel
{
    public $server_info;

    public function __construct()
    {
        $this->options = (array) AdminSettings::get_instance()->get();

        $restrict_for = !empty($this->options['admin_footer_user_roles']) ? $this->options['admin_footer_user_roles'] : '';
        if ($restrict_for) {
            add_filter('admin_footer_text', [$this, 'jltwp_adminify_change_admin_footer_text']);
            return;
        }


        add_action('admin_menu', [$this, 'jltwp_adminify_footer_version_remove']);
        add_action('network_admin_menu', [$this, 'jltwp_adminify_footer_version_remove']);

        $this->adminify_footer_text_init();

        $this->server_info = new ServerInfo();
    }

    public function jltwp_adminify_footer_version_remove()
    {
        remove_filter('update_footer', 'core_update_footer');
    }

    public function adminify_footer_text_init()
    {
        /** Admin Footer Credits Text **/
        add_filter('update_footer', [$this, 'jltwp_adminify_change_admin_footer'], 10, 3);

        // Footer Right Info
        add_filter('admin_footer_text', [$this, 'jltwp_adminify_change_admin_footer_text']);
    }

    /** Footer Credits */
    public function jltwp_adminify_footer_credits()
    { ?>
        <div class="wp-adminify adminify-first-child">
            <div class="wp-adminify--copyright">
                <?php
                echo sprintf(
                    __('Developed by <a href="%s" target="_blank" title="WP Adminify by Jewel Theme" target="_blank">WP Adminify</a> <br>
                        Powered by <a target="_blank" href="%s">WordPress</a>', 'adminify'),
                    esc_url('https://wpadminify.com/'),
                    esc_url('https://wordpress.org/')
                );
                ?>
            </div>
        </div>
        <?php
    }


    public function jltwp_adminify_change_admin_footer_text()
    {
        $this->options = (array) AdminSettings::get_instance()->get();
        if (!empty($this->options['footer_text'])) {
            echo $this->options['footer_text'];
            return;
        }
        // Change the content of the left admin footer text.
        apply_filters('jltwp_adminify_footer_credits', $this->jltwp_adminify_footer_credits());
    }


    /**
     * IP Address
     */
    public function adminify_ip_address()
    {
        if (!empty($this->options['admin_footer_ip_address'])) {
        ?>
            <div class="column has-text-right">
                <?php if (is_rtl()) {
                    echo sprintf(
                        '<span class="info-details">%2$s</span><span class="info-id is-uppercase">%1$s</span>',
                        esc_html__('IP: ', 'adminify'),
                        $this->server_info->get_ip_address()
                    );
                } else {
                    echo sprintf(
                        '<span class="info-id is-uppercase">%1$s</span><span class="info-details">%2$s</span>',
                        esc_html__('IP: ', 'adminify'),
                        $this->server_info->get_ip_address()
                    );
                } ?>
            </div>
        <?php
        }
    }


    /**
     * PHP Version
     */
    public function adminify_php_version()
    {
        if (!empty($this->options['admin_footer_php_version'])) {
        ?>
            <div class="column has-text-right">
                <?php if (is_rtl()) {
                    echo sprintf(
                        '<span class="info-details">%2$s</span><span class="info-id">%1$s</span>',
                        esc_html__('PHP: ', 'adminify'),
                        $this->server_info->get_php_version_lite()
                    );
                } else {
                    echo sprintf(
                        '<span class="info-id">%1$s</span><span class="info-details">%2$s</span>',
                        esc_html__('PHP: ', 'adminify'),
                        $this->server_info->get_php_version_lite()
                    );
                } ?>
            </div>
        <?php
        }
    }

    /**
     * WordPress Version
     */
    public function adminify_wp_version()
    {
        if (!empty($this->options['admin_footer_wp_version'])) {
        ?>
            <div class="column has-text-right">
                <?php if (is_rtl()) {
                    echo sprintf(
                        '<span class="info-details">%2$s</span><span class="info-id">%1$s</span>',
                        esc_html__('WordPress: v', 'adminify'),
                        $this->server_info->get_wp_version()
                    );
                } else {
                    echo sprintf(
                        '<span class="info-id">%1$s</span><span class="info-details">%2$s</span>',
                        esc_html__('WordPress: v', 'adminify'),
                        $this->server_info->get_wp_version()
                    );
                } ?>
            </div>
        <?php
        }
    }

    /**
     * Memory Usage
     */
    public function adminify_memory_usage()
    {
        if (!empty($this->options['admin_footer_memory_usage'])) {
            $memory_usage            = $this->server_info->get_wp_memory_usage();
            $memory_limit            = $memory_usage['MemLimitFormat'];
            $memory_usage_format     = $memory_usage['MemUsageFormat'];
            // $memory_usage_percentage = $memory_usage['MemUsageCalc'];
            $memory_usage_percentage = ServerInfo::wp_memory_usage_percentage();

            if ($memory_usage_percentage <= 65) {
                $memory_status = '#00BA88';
            } elseif ($memory_usage_percentage > 65 && $memory_usage_percentage < 85) {
                $memory_status = '#ffe08a';
            } elseif ($memory_usage_percentage > 85) {
                $memory_status = '#f14668';
            }
        ?>
            <div class="column has-text-right">

                <?php if (is_rtl()) {
                    echo sprintf(
                        __('<span class="info-details">%2$s of %3$s <span class="percentage tag has-text-white is-rounded" style="background:%4$s">%5$s</span></span><span class="info-id">%1$s</span>', 'adminify'),

                        esc_html__('WP Memory Usage: ', 'adminify'),
                        $memory_usage_format,
                        $memory_limit,
                        esc_html($memory_status),
                        $memory_usage_percentage . '%'
                    );
                } else {
                    echo sprintf(
                        __('<span class="info-id">%1$s</span><span class="info-details">%2$s of %3$s <span class="percentage tag has-text-white is-rounded" style="background:%4$s">%5$s</span></span>', 'adminify'),
                        esc_html__('WP Memory Usage: ', 'adminify'),
                        $memory_usage_format,
                        $memory_limit,
                        esc_html($memory_status),
                        $memory_usage_percentage . '%'
                    );
                } ?>
                </span>
            </div>
        <?php
        }
    }

    /**
     * Memory Limit
     */
    public function adminify_memory_limit()
    {
        if (!empty($this->options['admin_footer_memory_limit'])) {
            $memory_limit = $this->server_info->get_wp_memory_usage();
            $memory_limit = $memory_limit['MemLimitFormat'];
        ?>
            <div class="column has-text-right">
                <?php if (is_rtl()) {
                    echo sprintf(
                        '<span class="info-details">%2$s</span><span class="info-id">%1$s</span>',
                        esc_html__('WP Memory Limit: ', 'adminify'),
                        $memory_limit
                    );
                } else {
                    echo sprintf(
                        '<span class="info-id">%1$s</span><span class="info-details">%2$s</span>',
                        esc_html__('WP Memory Limit: ', 'adminify'),
                        $memory_limit
                    );
                } ?>
            </div>
        <?php
        }
    }


    /**
     * Memory Limit
     */
    public function adminify_memory_available()
    {
        if (!empty($this->options['admin_footer_memory_available'])) {
            $memory_available = $this->server_info->get_wp_memory_usage();
            $memory_available = $memory_available['MemLimitGet'];
        ?>
            <div class="column has-text-right">
                <?php if (is_rtl()) {
                    echo sprintf(
                        '<span class="info-details is-uppercase">%2$s</span><span class="info-id">%1$s</span>',
                        esc_html__('WP Memory Available: ', 'adminify'),
                        $memory_available
                    );
                } else {
                    echo sprintf(
                        '<span class="info-id">%1$s</span><span class="info-details is-uppercase">%2$s</span>',
                        esc_html__('WP Memory Available: ', 'adminify'),
                        $memory_available
                    );
                } ?>
            </div>
        <?php
        }
    }

    /** Admin Footer Text **/
    public function jltwp_adminify_change_admin_footer($footer_text)
    {
        if (
            !empty($this->options['admin_footer_memory_usage']) ||
            !empty($this->options['admin_footer_memory_limit']) ||
            !empty($this->options['admin_footer_memory_available']) ||
            !empty($this->options['admin_footer_ip_address']) ||
            !empty($this->options['admin_footer_php_version']) ||
            !empty($this->options['admin_footer_wp_version'])
        ) {
        ?>
            <div class="wp-adminify adminify-last-child">

                <div class="system-info has-text-right">
                    <div class="info-line-1">

                        <?php
                        $this->adminify_ip_address();
                        $this->adminify_php_version();
                        $this->adminify_wp_version();
                        ?>
                    </div>

                    <div class="info-line-2">
                        <?php
                        $this->adminify_memory_usage();
                        $this->adminify_memory_limit();
                        $this->adminify_memory_available();
                        ?>

                    </div>
                </div>

            </div>
<?php
            return $footer_text;
        }

        // Nothing, return blank
        return '';
    }
}
