<?php

namespace WPAdminify\Inc\Modules\ActivityLogs\Hooks;

use  WPAdminify\Inc\Modules\ActivityLogs\Inc\Hooks_Base;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

class WP_Adminify_Logs_Widgets extends Hooks_Base
{
    public function __construct()
    {
        parent::__construct();
        add_filter('widget_update_callback', [$this, 'hooks_widget_update_callback'], 9999, 4);
        add_filter('sidebar_admin_setup', [$this, 'hooks_widget_delete']); // Widget delete.
    }

    public function hooks_widget_update_callback($instance, $new_instance, $old_instance, \WP_Widget $widget)
    {
        $adminify_widget_args = array(
            'action'         => 'updated',
            'object_type'    => 'Widget',
            'object_subtype' => 'sidebar_unknown',
            'object_id'      => 0,
            'object_name'    => $widget->id_base,
        );

        if (empty($_REQUEST['sidebar'])) {
            return $instance;
        }

        adminify_activity_logs($adminify_widget_args);

        // We are need return the instance, for complete the filter.
        return $instance;
    }

    public function hooks_widget_delete()
    {
        // A reference: http://grinninggecko.com/hooking-into-widget-delete-action-in-wordpress/
        if ('post' == strtolower($_SERVER['REQUEST_METHOD']) && !empty($_REQUEST['widget-id'])) {
            if (isset($_REQUEST['delete_widget']) && 1 === (int) $_REQUEST['delete_widget']) {
                adminify_activity_logs(array(
                    'action'         => 'deleted',
                    'object_type'    => 'Widget',
                    'object_subtype' => strtolower($_REQUEST['sidebar']),
                    'object_id'      => 0,
                    'object_name'    => $_REQUEST['id_base'],
                ));
            }
        }
    }
}
