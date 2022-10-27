<?php

namespace WPAdminify\Inc\Modules\ActivityLogs\Inc;

use WPAdminify\Inc\Admin\AdminSettings;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WPAdminify
 * @package Activity Logs
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class Api
{
    protected function old_data_remove()
    {
        global $wpdb;

        // Remove data after 30 days
        $logs_lifespan = AdminSettings::get_instance()->get('activity_logs_history_data');

        if (empty($logs_lifespan))
            return;

        $wpdb->query(
            $wpdb->prepare(
                'DELETE FROM `' . $wpdb->adminify_activity_logs . '`
					WHERE `log_time` < %d',
                strtotime('-' . $logs_lifespan . ' days', current_time('timestamp'))
            )
        );
    }

    public function erase_all_items()
    {
        global $wpdb;

        $wpdb->query('TRUNCATE `' . $wpdb->adminify_activity_logs . '`');
    }

    protected function get_ip_address()
    {
        $server_ip_keys = array(
            'HTTP_CF_CONNECTING_IP', // CloudFlare
            'HTTP_TRUE_CLIENT_IP', // CloudFlare Enterprise header
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        );

        foreach ($server_ip_keys as $key) {
            if (isset($_SERVER[$key]) && filter_var($_SERVER[$key], FILTER_VALIDATE_IP)) {
                return $_SERVER[$key];
            }
        }

        // Fallback local ip.
        return '127.0.0.1';
    }

    public function insert($args)
    {
        global $wpdb;

        $args = wp_parse_args(
            $args,
            array(
                'action'         => '',
                'object_type'    => '',
                'object_subtype' => '',
                'object_name'    => '',
                'object_id'      => '',
                'log_ip'        => $this->get_ip_address(),
                'log_time'      => current_time('timestamp'),
            )
        );

        $user = get_user_by('id', get_current_user_id());
        if ($user) {
            $args['user_caps'] = strtolower(key($user->caps));
            if (empty($args['user_id']))
                $args['user_id'] = $user->ID;
        } else {
            $args['user_caps'] = 'guest';
            if (empty($args['user_id']))
                $args['user_id'] = 0;
        }

        // TODO: Find better way to Multisite compatibility.
        // Fallback for multisite with bbPress
        if (empty($args['user_caps']) || 'bbp_participant' === $args['user_caps'])
            $args['user_caps'] = 'administrator';

        // Make sure for non duplicate.
        $check_duplicate = $wpdb->get_row(
            $wpdb->prepare(
                'SELECT `log_id` FROM `' . $wpdb->adminify_activity_logs . '`
					WHERE `user_caps` = %s
						AND `action` = %s
						AND `object_type` = %s
						AND `object_subtype` = %s
						AND `object_name` = %s
						AND `user_id` = %s
						AND `log_ip` = %s
						AND `log_time` = %s
				;',
                $args['user_caps'],
                $args['action'],
                $args['object_type'],
                $args['object_subtype'],
                $args['object_name'],
                $args['user_id'],
                $args['log_ip'],
                $args['log_time']
            )
        );

        if ($check_duplicate)
            return;

        $wpdb->insert(
            $wpdb->adminify_activity_logs,
            array(
                'action'         => $args['action'],
                'object_type'    => $args['object_type'],
                'object_subtype' => $args['object_subtype'],
                'object_name'    => $args['object_name'],
                'object_id'      => $args['object_id'],
                'user_id'        => $args['user_id'],
                'user_caps'      => $args['user_caps'],
                'log_ip'        => $args['log_ip'],
                'log_time'      => $args['log_time'],
            ),
            array('%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%d')
        );

        // Remove old items.
        $this->old_data_remove();
        do_action('adminify_activity_logs', $args);
    }

    public function delete($id)
    {
        global $wpdb;
        return $wpdb->delete($wpdb->adminify_activity_logs, ['log_id' => $id], ['%d']);
    }
}
