<?php

namespace WPAdminify\Inc\DashboardWidgets;

use WPAdminify\Inc\Classes\ServerInfo;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * System Info Dashboard Widget
 *
 * @return void
 */
/**
 * WPAdminify
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class Adminify_SystemInfo
{
    public function __construct()
    {
        add_action('wp_dashboard_setup', [$this, 'jltwp_adminify_register']);
    }
    public function jltwp_adminify_register()
    {
        wp_add_dashboard_widget(
            'jltwp_adminify_dash_system_info',
            esc_html__('System Info - Adminify', 'adminify'),
            [$this, 'jltwp_adminify_widget_details']
        );
    }

    public function jltwp_adminify_widget_details()
    {
        $server_info = new ServerInfo();
?>


        <div class="wp-adminify-server-info">
            <div class="table listing">
                <table>
                    <tr>
                        <td><?php esc_html_e('WP Version', 'adminify'); ?>:</td>
                        <td><strong><?php bloginfo('version'); ?></strong></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('PHP Version', 'adminify'); ?>:</td>
                        <td><strong><?php echo $server_info->get_php_version(); ?></strong></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('MySQL Version', 'adminify'); ?>:</td>
                        <td><strong><?php echo $server_info->get_mysql_version(); ?></strong></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Database Software', 'adminify'); ?>:</td>
                        <td><strong><?php echo $server_info->get_db_software(); ?></strong></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('PHP Memory Server-Limit', 'adminify'); ?>:</td>
                        <td><?php echo '<strong>' . $server_info->get_server_memory_usage()['MemLimitFormat'] . '</strong>'; ?></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('PHP Memory Server-Usage', 'adminify'); ?>:</td>

                        <td>
                            <?php if ($server_info->get_server_memory_usage()['MemLimitGet'] == '-1') { ?>
                                <strong><?php echo $server_info->get_server_memory_usage()['MemUsageFormat'] . ' ' . esc_html__('of', 'adminify') . ' ' . esc_html__('Unlimited', 'adminify') . ' (-1)'; ?></strong>
                            <?php } else { ?>
                                <strong><?php echo $server_info->get_server_memory_usage()['MemUsageFormat'] . ' ' . esc_html__('of', 'adminify') . ' ' . $server_info->get_server_memory_usage()['MemLimitFormat']; ?></strong>
                                <br>
                                <div class="adminify-system-progress">
                                    <div class="status-progressbar"><span><?php echo $server_info->get_server_memory_usage()['MemUsageCalc'] . '% '; ?></span>
                                        <div style="width: <?php echo $server_info->get_server_memory_usage()['MemUsageCalc']; ?>%"></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('PHP Memory WP-Limit', 'adminify'); ?>:</td>
                        <td><?php echo '<strong>' . $server_info->get_wp_memory_usage()['MemLimitFormat'] . '</strong>'; ?></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('PHP Memory WP-Usage', 'adminify'); ?>:</td>
                        <td>
                            <?php if ($server_info->get_wp_memory_usage()['MemLimitGet'] == '-1') { ?>
                                <strong><?php echo $server_info->get_wp_memory_usage()['MemUsageFormat'] . ' ' . esc_html__('of', 'adminify') . ' ' . esc_html__('Unlimited', 'adminify') . ' (-1)'; ?></strong>
                            <?php } else { ?>
                                <strong><?php echo $server_info->get_wp_memory_usage()['MemUsageFormat'] . ' ' . esc_html__('of', 'adminify') . ' ' . $server_info->get_wp_memory_usage()['MemLimitFormat']; ?></strong>

                                <div class="adminify-system-progress">
                                    <div class="status-progressbar"><span><?php echo $server_info->get_wp_memory_usage()['MemUsageCalc'] . '% '; ?></span>
                                        <div style="width: <?php echo $server_info->get_wp_memory_usage()['MemUsageCalc']; ?>%"></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('PHP Max Upload Size (WP)', 'adminify'); ?>:</td>
                        <td><strong><?php echo (int)ini_get('upload_max_filesize') . ' MB (' . size_format(wp_max_upload_size()) . ')'; ?></strong></td>

                    </tr>
                    <tr>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page=adminify-server-info'); ?>"><span class="dashicons dashicons-dashboard"></span> <?php esc_html_e('Adminify System Info Details', 'adminify'); ?></a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
<?php

    }
}
