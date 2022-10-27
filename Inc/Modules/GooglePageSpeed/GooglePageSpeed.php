<?php

namespace WPAdminify\Inc\Modules\GooglePageSpeed;

use WPAdminify\Inc\Modules\PageSpeed_Insight\PageSpeed_Insight;
use WPAdminify\Inc\Admin\AdminSettings;
use WPAdminify\Inc\Utils;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WP Adminify
 * Module: Google Pagespeed
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

if (!class_exists('GooglePageSpeed')) {

    class GooglePageSpeed
    {

        public $url;

        public $insight;

        public $options;

        public function __construct()
        {

            $needed_keys = ['google_pagepseed_user_roles', 'google_pagepseed_api_key'];

            $this->options = (array) array_intersect_key(AdminSettings::get_instance()->get(), array_flip($needed_keys));

            // $this->url = WP_ADMINIFY_URL . 'Inc/Modules/GooglePageSpeed';

            add_action('admin_menu', [$this, 'GooglePageSpeed'], 47);

            add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts'], 100);

            add_action('wp_ajax_adminify_page_speed', [$this, 'handle_adminify_page_speed']);

            add_action('init', [$this, 'maybe_create_tables'], 0);
        }

        public function is_module_active()
        {

            $mopdule_roles = array_filter((array) $this->options['google_pagepseed_user_roles']);

            if (empty($mopdule_roles)) return true;

            $user = wp_get_current_user();

            return !empty(array_intersect($mopdule_roles, $user->roles));
        }

        /**
         * Google Pagespeed Menu
         */
        public function GooglePageSpeed()
        {

            if (!$this->is_module_active()) return;

            add_submenu_page(
                'wp-adminify-settings',
                esc_html__('Google Pagespeed Insights by WP Adminify', 'adminify'),
                esc_html__('Pagespeed Insights', 'adminify'),
                apply_filters('jltwp_adminify_capability', 'manage_options'),
                'adminify-pagespeed-insights', // Page slug, will be displayed in URL
                [$this, 'jltwp_adminify_menu_editor_contents']
            );
        }

        public function jltwp_adminify_menu_editor_contents()
        {
            echo '<div class="wrap"><div id="wp-adminify--page-speed-app"></div></div>';
        }

        public function load_insight_class()
        {

            require_once 'class-pagespeed-insights.php';

            if (!($this->insight instanceof PageSpeed_Insight)) {
                $this->insight = new PageSpeed_Insight($this->options['google_pagepseed_api_key']);
            }

            return $this->insight;
        }

        public function handle_adminify_page_speed()
        {

            check_ajax_referer('__adminify-page_speed-secirity__');

            if (!empty($_POST['route'])) {
                $route_handler = 'handle_' . $_POST['route'];
                if (is_callable(get_class($this), $route_handler)) $this->$route_handler($_POST);
            }

            wp_send_json_error(['message' => __('Something is wrong, no route found')], 400);
        }

        private function _get_analyze_data($url)
        {

            $data = [
                'desktop' => null,
                'mobile' => null
            ];

            $result = $this->insight->run_insight($url, ['strategy' => 'desktop']);
            if (!empty($result) && $result['responseCode'] == 200 && !empty($result['data'])) {
                $data['desktop'] = $result['data'];

                $result_mobile = $this->insight->run_insight($url, ['strategy' => 'mobile']);
                if (!empty($result_mobile) && $result_mobile['responseCode'] == 200 && !empty($result_mobile['data'])) {
                    $data['mobile'] = $result_mobile['data'];
                    return $data;
                }
            }

            return false;
        }

        public function handle_new_analyze($data)
        {

            check_ajax_referer('__adminify-page_speed-secirity__');

            if (empty($data['url']) || !wp_http_validate_url($data['url'])) wp_send_json_error(['message' => __('Something is wrong, URL is missing or wrong formatted')], 400);

            set_time_limit(300);

            $this->load_insight_class();

            $analyze_data = $this->_get_analyze_data($data['url']);

            if ($analyze_data === false) wp_send_json_error(['message' => __('Couldn\'t fetch the result, Please try again later')], 503);

            $saved = $this->save_analyze($analyze_data);

            if (empty($saved)) wp_send_json_error(['message' => __('Couldn\'t save the result, Please try again later')], 500);

            wp_send_json_success($saved);
        }

        public function save_analyze($analyze_data)
        {

            $data_desktop = $analyze_data['desktop'];
            $data_mobile = $analyze_data['mobile'];
            $url = $data_desktop->id;
            $score_desktop = $data_desktop->lighthouseResult->categories->performance->score * 100;
            $score_mobile = $data_mobile->lighthouseResult->categories->performance->score * 100;
            $screenshot = $data_desktop->lighthouseResult->audits->{'final-screenshot'}->details->data;

            // unset( $data_desktop->lighthouseResult->audits->{'final-screenshot'} );
            // unset( $data_mobile->lighthouseResult->audits->{'final-screenshot'} );

            $data = array(
                "url"               => $url,
                "score_desktop"     => (int) $score_desktop,
                "score_mobile"      => (int) $score_mobile,
                "data_desktop"      => json_encode($data_desktop),
                "data_mobile"       => json_encode($data_mobile),
                "screenshot"        => $screenshot,
                "time"              => current_time('mysql'),
            );

            global $wpdb;

            $result = $wpdb->insert("{$wpdb->prefix}adminify_page_speed", $data, array(
                'url' => '%s',
                'score_desktop' => '%d',
                'score_mobile' => '%d',
                'data_desktop' => '%s',
                'data_mobile' => '%s',
                'screenshot' => '%s',
                'time' => '%s',
            ));

            if (empty($result)) return false;

            return $wpdb->insert_id;
        }

        public function handle_count_total($data)
        {
            check_ajax_referer('__adminify-page_speed-secirity__');

            global $wpdb;

            $table_name = $wpdb->prefix . 'adminify_page_speed';

            $total_query = "SELECT COUNT(*) FROM $table_name";
            $total = $wpdb->get_var($total_query);

            wp_send_json_success($total);
        }

        public function handle_fetch_histories($data)
        {

            check_ajax_referer('__adminify-page_speed-secirity__');

            global $wpdb;

            $table_name = $wpdb->prefix . 'adminify_page_speed';
            $fields = 'id, url, score_desktop, score_mobile, time, screenshot';
            $items_per_page = empty($data['items_per_page']) ? 1 : abs((int) $data['items_per_page']);
            $page = empty($data['page']) ? 1 : abs((int) $data['page']);
            $offset = ($page * $items_per_page) - $items_per_page;

            $query = "SELECT {$fields} FROM $table_name";

            $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
            $total = $wpdb->get_var($total_query);

            $histories = $wpdb->get_results($query . ' ORDER BY time DESC LIMIT ' . $offset . ', ' . $items_per_page, ARRAY_A);

            foreach ($histories as &$history) {
                $history['formated_date'] = date("Y-m-d", strtotime($history['time']));
                $history['formated_time'] = date("H:i:s", strtotime($history['time']));
            }

            wp_send_json_success([
                'total' => (int) $total,
                'histories' => (array) $histories
            ]);
        }

        public function handle_fetch_history($data)
        {

            check_ajax_referer('__adminify-page_speed-secirity__');

            if (empty($data['id'])) wp_send_json_error('Something is wrong, Try again later', 400);

            global $wpdb;

            $table_name = $wpdb->prefix . 'adminify_page_speed';
            $history_id = $data['id'];
            $fields = 'id, url, score_desktop, score_mobile, data_desktop, data_mobile, time';

            $history = $wpdb->get_row($wpdb->prepare("SELECT {$fields} FROM $table_name WHERE id = %d", $history_id), ARRAY_A);

            if (empty($history) || $wpdb->last_error !== '') wp_send_json_error($wpdb->last_error, 400);

            $history["data_desktop"] = json_decode($history["data_desktop"], true);
            $history["data_mobile"] = json_decode($history["data_mobile"], true);

            wp_send_json_success([
                'history' => $history
            ]);
        }

        public function handle_delete_history()
        {

            check_ajax_referer('__adminify-page_speed-secirity__');

            if (empty($_POST['ids'])) wp_send_json_error('Something is wrong, Try again later', 400);

            global $wpdb;

            $ids = implode(',', array_map('absint', $_POST['ids']));
            $wpdb->query("DELETE FROM {$wpdb->prefix}adminify_page_speed WHERE ID IN($ids)");

            if ($wpdb->last_error !== '') wp_send_json_error($wpdb->last_error, 400);

            wp_send_json_success([
                'message' => 'History has been deleted'
            ]);
        }

        public function enqueue_scripts()
        {

            wp_enqueue_style('wp-adminify--page-speed', WP_ADMINIFY_URL . 'assets/admin/css/wp-adminify--page-speed.css', [], WP_ADMINIFY_VER);

            $data = [
                'adminurl' => admin_url(),
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('__adminify-page_speed-secirity__'),
                'is_pro' => wp_validate_boolean(jltwp_adminify()->can_use_premium_code__premium_only()),
                'pro_notice' => Utils::adminify_upgrade_pro()
            ];

            wp_localize_script('wp-adminify--page-speed', 'wp_adminify__pagespeed_data', $data);

            wp_enqueue_script('wp-adminify--page-speed');
        }

        public function maybe_create_tables()
        {

            global $wpdb;

            // delete_option( "{$wpdb->prefix}adminify_page_speed_db_version" );

            $db_version = '1.0';

            if (get_option("{$wpdb->prefix}adminify_page_speed_db_version") == $db_version) return; // vail early

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}adminify_page_speed (
            	id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
            	url VARCHAR(255) NOT NULL,
            	score_desktop VARCHAR(3) NOT NULL,
            	score_mobile VARCHAR(3) NOT NULL,
            	data_desktop MEDIUMTEXT NOT NULL,
            	data_mobile MEDIUMTEXT NOT NULL,
            	screenshot MEDIUMTEXT NOT NULL,
            	time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            	PRIMARY KEY (id)
            )" . $wpdb->get_charset_collate() . ";";

            if (get_option("{$wpdb->prefix}adminify_page_speed_db_version") < $db_version) {
                dbDelta($sql);
            }

            update_option("{$wpdb->prefix}adminify_page_speed_db_version", $db_version);
        }
    }
}
