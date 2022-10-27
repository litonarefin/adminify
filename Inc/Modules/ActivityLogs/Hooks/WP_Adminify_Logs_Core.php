<?php

namespace WPAdminify\Inc\Modules\ActivityLogs\Hooks;

use  WPAdminify\Inc\Modules\ActivityLogs\Inc\Hooks_Base;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

class WP_Adminify_Logs_Core extends Hooks_Base
{
    public function __construct()
    {
        parent::__construct();
        add_action('_core_updated_successfully', [$this, 'core_updated_successfully']);
    }

    public function core_updated_successfully($wp_version)
    {
        global $pagenow;

        // Auto updated
        if ('update-core.php' !== $pagenow)
            $object_name = 'WordPress Auto Updated';
        else
            $object_name = 'WordPress Updated';

        adminify_activity_logs(
            array(
                'action'      => 'updated',
                'object_type' => 'Core',
                'object_id'   => 0,
                'object_name' => $object_name,
            )
        );
    }
}
