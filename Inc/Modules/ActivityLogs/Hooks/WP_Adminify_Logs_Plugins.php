<?php

namespace WPAdminify\Inc\Modules\ActivityLogs\Hooks;

use  WPAdminify\Inc\Modules\ActivityLogs\Inc\Hooks_Base;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

class WP_Adminify_Logs_Plugins extends Hooks_Base
{
    public function __construct()
    {
        parent::__construct();

        add_action('activated_plugin', [$this, 'hooks_activated_plugin']);
        add_action('deactivated_plugin', [$this, 'hooks_deactivated_plugin']);
        add_filter('wp_redirect', [$this, 'hooks_plugin_modify'], 10, 2);

        add_action('upgrader_process_complete', [$this, 'hooks_plugin_install_or_update'], 10, 2);
    }



    protected function _add_log_plugin($action, $plugin_name)
    {
        // Get plugin name if is a path
        if (false !== strpos($plugin_name, '/')) {
            $plugin_dir  = explode('/', $plugin_name);
            $plugin_data = array_values(get_plugins('/' . $plugin_dir[0]));
            $plugin_data = array_shift($plugin_data);
            $plugin_name = $plugin_data['Name'];
        }

        adminify_activity_logs(
            array(
                'action'      => $action,
                'object_type' => 'Plugin',
                'object_id'   => 0,
                'object_name' => $plugin_name,
            )
        );
    }

    public function hooks_deactivated_plugin($plugin_name)
    {
        $this->_add_log_plugin('deactivated', $plugin_name);
    }

    public function hooks_activated_plugin($plugin_name)
    {
        $this->_add_log_plugin('activated', $plugin_name);
    }

    public function hooks_plugin_modify($location, $status)
    {
        if (false !== strpos($location, 'plugin-editor.php')) {
            if ((!empty($_POST) && 'update' === $_REQUEST['action'])) {
                $aal_args = array(
                    'action'         => 'file_updated',
                    'object_type'    => 'Plugin',
                    'object_subtype' => 'plugin_unknown',
                    'object_id'      => 0,
                    'object_name'    => 'file_unknown',
                );

                if (!empty($_REQUEST['file'])) {
                    $aal_args['object_name'] = $_REQUEST['file'];
                    // Get plugin name
                    $plugin_dir  = explode('/', $_REQUEST['file']);
                    $plugin_data = array_values(get_plugins('/' . $plugin_dir[0]));
                    $plugin_data = array_shift($plugin_data);

                    $aal_args['object_subtype'] = $plugin_data['Name'];
                }
                adminify_activity_logs($aal_args);
            }
        }

        // We are need return the instance, for complete the filter.
        return $location;
    }

    /**
     * @param Plugin_Upgrader $upgrader
     * @param array $extra
     */
    public function hooks_plugin_install_or_update($upgrader, $extra)
    {
        if (!isset($extra['type']) || 'plugin' !== $extra['type'])
            return;

        if ('install' === $extra['action']) {
            $path = $upgrader->plugin_info();
            if (!$path)
                return;

            $data = get_plugin_data($upgrader->skin->result['local_destination'] . '/' . $path, true, false);

            adminify_activity_logs(
                array(
                    'action' => 'installed',
                    'object_type' => 'Plugin',
                    'object_name' => $data['Name'],
                    'object_subtype' => $data['Version'],
                )
            );
        }

        if ('update' === $extra['action']) {
            if (isset($extra['bulk']) && true == $extra['bulk']) {
                $slugs = $extra['plugins'];
            } else {
                if (!isset($upgrader->skin->plugin))
                    return;

                $slugs = array($upgrader->skin->plugin);
            }

            foreach ($slugs as $slug) {
                $data = get_plugin_data(WP_PLUGIN_DIR . '/' . $slug, true, false);

                adminify_activity_logs(
                    array(
                        'action' => 'updated',
                        'object_type' => 'Plugin',
                        'object_name' => $data['Name'],
                        'object_subtype' => $data['Version'],
                    )
                );
            }
        }
    }
}
