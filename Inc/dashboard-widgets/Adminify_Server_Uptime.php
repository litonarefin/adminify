<?php

namespace WPAdminify\Inc\DashboardWidgets;

use \WPAdminify\Inc\Classes\ServerInfo;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * Dashboard Widget
 *
 * @return void
 */
/**
 * WPAdminify
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class Adminify_Server_Uptime
{
    public $url;
    public $server_info;

    public function __construct()
    {
        $this->url     = WP_ADMINIFY_URL . 'inc/classes/dashboard-widgets/';
        $this->server_info = new ServerInfo();

        if (!$this->server_info->is_shell_enable()) {
            return;
        }

        add_action('wp_dashboard_setup', [$this, 'jltwp_adminify_server_uptime']);
        add_action('admin_enqueue_scripts', [$this, 'jltwp_adminify_server_uptime_scripts']);
        add_action('wp_ajax_adminify_live_server_stats', [$this, 'adminify_live_server_stats']);
    }


    /**
     * Label: Server Uptime
     *
     * @return void
     */
    public function jltwp_adminify_server_uptime()
    {
        wp_add_dashboard_widget(
            'jltwp_adminify_dash_server_uptime',
            esc_html__('Real-time Server Details - Adminify', 'adminify'),
            [$this, 'jltwp_adminify_server_uptime_details']
        );
    }


    public function jltwp_adminify_server_uptime_scripts()
    {
        $screen = get_current_screen();
        if ($screen->id == 'dashboard') {

            // Server Uptime Widget Details Custom CSS
            $adminify_dash_css = '';
            $adminify_dash_css .= '.adminify-server-status-good circle{ stroke: #00BA88 !important;}';
            $adminify_dash_css .= '.adminify-server-status-average circle{ stroke: #ffe08a !important;}';
            $adminify_dash_css .= '.adminify-server-status-bad circle{ stroke: #f14668 !important;}';
            // echo '<style>' . wp_strip_all_tags($adminify_dash_css) . '</style>';

            wp_register_script('wp-adminify-realtime-server', WP_ADMINIFY_ASSETS . 'js/adminify-realtime-server.js',  ['jquery'], WP_ADMINIFY_VER, true);
            wp_enqueue_script('wp-adminify-realtime-server');

            wp_localize_script('wp-adminify-realtime-server', 'WPAdminify_Server', $this->adminify_server_uptime_object());
        }
    }


    public function adminify_server_uptime_object()
    {
        return array(
            'ajax_url'       => admin_url('admin-ajax.php'),
            'security_nonce' => wp_create_nonce('adminify-server-uptime-nonce')
        );
    }


    public function adminify_live_server_stats()
    {
        if (defined('DOING_AJAX') && DOING_AJAX && check_ajax_referer('adminify-server-uptime-nonce', 'security') > 0) {

            $get_server_memory_usage = $this->server_info->get_server_memory_usage();
            $server_ram_details      = $this->server_info->get_server_ram_details();

            // WP Memory Usage
            $wp_memory_usage            = $this->server_info->get_server_memory_usage();
            $wp_memory_usage_percentage = ServerInfo::wp_memory_usage_percentage();

            $server_uptime = $this->server_info->get_server_uptime();

            if ($this->server_info->is_shell_enable()) {

                // CPU Details
                $cpu_load                  = $this->server_info->get_server_cpu_load_percentage();
                $memory_usage_MB           = function_exists('memory_get_usage') ? round(memory_get_usage() / 1024 / 1024, 2) : 0;
                $memory_usage_pos          = $get_server_memory_usage['MemLimit'];

                // RAM Details
                $total_ram_server          = $server_ram_details['MemTotal'];
                $free_ram_server           = $server_ram_details['MemFree'];
                $used_ram_server           = ($total_ram_server - $free_ram_server);

                $output_json = array(
                    'cpu_load'           => round($cpu_load, 0, PHP_ROUND_HALF_UP),
                    'memory_usage_MB'    => round($memory_usage_MB, 0, PHP_ROUND_HALF_UP),
                    'memory_usage_pos'   => $memory_usage_pos,
                    'total_ram'          => $total_ram_server,
                    'free_ram'           => $free_ram_server,
                    'used_ram'           => round($used_ram_server, 0, PHP_ROUND_HALF_UP),
                    'ram_usage_pos'      => $server_ram_details['MemUsagePercentage'],
                    'uptime'             => $server_uptime,
                    'wp_memory_usage'    => round($wp_memory_usage_percentage, 0, PHP_ROUND_HALF_UP),
                    'refresh_interval'   => 200
                );

                wp_send_json_success($output_json);
            } else {

                $memory_usage_MB = function_exists('memory_get_usage') ? round(memory_get_usage() / 1024 / 1024, 2) : 0;

                $output_json = array(
                    'cpu_load'         => null,
                    'memory_usage_MB'    => $memory_usage_MB,
                    'memory_usage_pos'   => $wp_memory_usage['MemUsageFormat'],
                    'uptime'             => $server_uptime,
                    'wp_memory_usage'    => $wp_memory_usage_percentage,
                    'refresh_interval'   => 200
                );

                wp_send_json_success($output_json);
            }
        }
    }

    /**
     * Dashboard Widgets: Server Uptime Widget Details
     *
     * @return void
     */
    public function jltwp_adminify_server_uptime_details()
    {
?>
        <div class="adminify-server-right-now">

            <div class="columns mb-5">

                <div class="column">
                    <div class="adminify-server-right-now has-text-centered mb-2">
                        <h4 class="adminify-title">
                            <?php echo esc_html__('RAM Uses: ', 'adminify'); ?>
                        </h4>
                        <div class="adminify-realtime-chart is-relative is-flex is-align-items-center is-justify-content-center" data-percent="86" id="adminify-ram-usage">
                            <svg class="adminify-progress-bar" width="120" height="120" viewport="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <circle r="50" cx="59" cy="59" fill="transparent" stroke-dasharray="314" stroke-dashoffset="0"></circle>
                                <circle class="adminify-bar" r="50" cx="59" cy="59" fill="transparent" stroke-dasharray="314" stroke-dashoffset="0"></circle>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="column">
                    <div class="adminify-server-right-now has-text-centered mb-2">
                        <h4 class="adminify-title">
                            <?php echo esc_html__('CPU Load: ', 'adminify'); ?>
                        </h4>
                        <div class="adminify-realtime-chart is-relative is-flex is-align-items-center is-justify-content-center" data-percent="24" id="adminify-cpu-load">
                            <svg class="adminify-progress-bar" width="120" height="120" viewport="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <circle r="50" cx="59" cy="59" fill="transparent" stroke-dasharray="314" stroke-dashoffset="0"></circle>
                                <circle class="adminify-bar" r="50" cx="59" cy="59" fill="transparent" stroke-dasharray="314" stroke-dashoffset="0"></circle>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            <div class="columns">

                <div class="column">
                    <div class="adminify-server-right-now has-text-centered mb-2">
                        <h4 class="adminify-title">
                            <?php echo esc_html__('PHP Memory Uses: ', 'adminify'); ?>
                        </h4>
                        <div class="adminify-realtime-chart is-relative is-flex is-align-items-center is-justify-content-center" data-percent="50" id="adminify-php-memory-usage">
                            <svg class="adminify-progress-bar" width="120" height="120" viewport="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <circle r="50" cx="59" cy="59" fill="transparent" stroke-dasharray="314" stroke-dashoffset="0"></circle>
                                <circle class="adminify-bar" r="50" cx="59" cy="59" fill="transparent" stroke-dasharray="314" stroke-dashoffset="0"></circle>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="column">
                    <div class="adminify-server-right-now has-text-centered mb-2">
                        <h4 class="adminify-title"><?php echo esc_html__('WP Memory Uses: ', 'adminify'); ?></h4>
                        <div class="adminify-realtime-chart is-relative is-flex is-align-items-center is-justify-content-center" data-percent="36" id="adminify-wp-memory-usage">
                            <svg class="adminify-progress-bar" width="120" height="120" viewport="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <circle r="50" cx="59" cy="59" fill="transparent" stroke-dasharray="314" stroke-dashoffset="0"></circle>
                                <circle class="adminify-bar" r="50" cx="59" cy="59" fill="transparent" stroke-dasharray="314" stroke-dashoffset="0"></circle>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            <div class="adminify-server-uptime has-text-centered" id="adminify-server-uptime">

                <h4 class="adminify-title">
                    <?php echo esc_html__('Server Uptime: ', 'adminify'); ?>
                </h4>

                <div class="adminify-uptime-counter">
                    <div id="time-elapsed">
                        <ul class="mb-0 is-flex is-align-items-center is-justify-content-center is-uppercase">
                            <li class="is-pulled-left">
                                <span id="adminify-days"></span>
                                <span class="adminify-countdown-title is-block"> days</span>
                            </li>
                            <li class="is-pulled-left">
                                <span id="adminify-hours"></span>
                                <span class="adminify-countdown-title is-block"> Hours</span>
                            </li>
                            <li class="is-pulled-left">
                                <span id="adminify-minutes"></span>
                                <span class="adminify-countdown-title is-block"> Minutes</span>
                            </li>
                            <li class="is-pulled-left">
                                <span id="adminify-seconds"></span>
                                <span class="adminify-countdown-title is-block"> Seconds</span>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>

        </div>
<?php
    }
}
