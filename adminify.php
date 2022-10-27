<?php

/**
 * Plugin Name: WP Adminify
 * Description: Supercharge your WordPress Adminify with <a href="https://wpadminify.com">WP Adminify</a> plugin. It has Completely WordPress White Label, Professional & Clean UI, Analytics, Charts, Menu UI, Light & Dark Mode, Menu Editor, Google Pagespeed Insights, Multisite Support and many more to get amazed.
 * Plugin URI: https://wpadminify.com
 * Author: Jewel Theme
 * Version: 3.0.4
 * Author URI: https://wpadminify.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: adminify
 * Domain Path: /languages
 * @fs_premium_only /Pro/, /Inc/Modules/AdminPages/
 *
 */

// No, Direct access Sir !!!
if (!defined('ABSPATH')) exit;

$jltwp_adminify_plugin_data     = get_file_data(__FILE__,  array(
    'Version'       => 'Version',
    'Plugin Name'   => 'Plugin Name',
    'Author'        => 'Author',
    'Description'   => 'Description',
    'Plugin URI'    => 'Plugin URI',
), false);

// Define Constants
if (!defined('WP_ADMINIFY')) define('WP_ADMINIFY', $jltwp_adminify_plugin_data['Plugin Name']);
if (!defined('WP_ADMINIFY_VER')) define('WP_ADMINIFY_VER', $jltwp_adminify_plugin_data['Version']);
if (!defined('WP_ADMINIFY_FILE')) define('WP_ADMINIFY_FILE', __FILE__);
if (!defined('WP_ADMINIFY_BASE')) define('WP_ADMINIFY_BASE', plugin_basename(__FILE__));
if (!defined('WP_ADMINIFY_PATH')) define('WP_ADMINIFY_PATH', trailingslashit(plugin_dir_path(__FILE__)));
if (!defined('WP_ADMINIFY_URL')) define('WP_ADMINIFY_URL', trailingslashit(plugins_url('/', __FILE__)));
if (!defined('WP_ADMINIFY_ASSETS')) define('WP_ADMINIFY_ASSETS', WP_ADMINIFY_URL . 'assets/');
if (!defined('WP_ADMINIFY_ASSETS_IMAGE')) define('WP_ADMINIFY_ASSETS_IMAGE', WP_ADMINIFY_ASSETS . 'images/');
if (!defined('WP_ADMINIFY_ASSET_PATH')) define('WP_ADMINIFY_ASSET_PATH', wp_upload_dir()['basedir'] . '/wp-adminify');
if (!defined('WP_ADMINIFY_ASSET_URL')) define('WP_ADMINIFY_ASSET_URL', wp_upload_dir()['baseurl'] . '/wp-adminify');
if (!defined('WP_ADMINIFY_DESC')) define('WP_ADMINIFY_DESC', $jltwp_adminify_plugin_data['Description']);
if (!defined('WP_ADMINIFY_AUTHOR')) define('WP_ADMINIFY_AUTHOR', $jltwp_adminify_plugin_data['Author']);
if (!defined('WP_ADMINIFY_URI')) define('WP_ADMINIFY_URI', $jltwp_adminify_plugin_data['Plugin URI']);

if (function_exists('jltwp_adminify')) {
    jltwp_adminify()->set_basename(true, __FILE__);
} else {
    if (!function_exists('jltwp_adminify')) {
        // Create a helper function for easy SDK access.
        function jltwp_adminify()
        {
            global $jltwp_adminify;

            if (!isset($jltwp_adminify)) {
                // Activate multisite network integration.
                if (!defined('WP_FS__PRODUCT_7829_MULTISITE')) {
                    define('WP_FS__PRODUCT_7829_MULTISITE', true);
                }

                // Include Freemius SDK.
                require_once dirname(__FILE__) . '/lib/freemius/start.php';

                $jltwp_adminify = fs_dynamic_init(array(
                    'id'                  => '7829',
                    'slug'                => 'adminify',
                    'premium_slug'        => 'adminify-pro',
                    'type'                => 'plugin',
                    'public_key'          => 'pk_a0ea61beae7126eb845f7e58a03e5',
                    'premium_suffix'      => 'Pro',
                    // 'navigation'          => 'tabs',
                    'has_premium_version' => true,
                    'has_affiliation'     => 'all',
                    'has_addons'          => false,
                    'has_paid_plans'      => true,
                    'menu'                => array(
                        'slug'       => 'wp-adminify-settings',
                        'first-path' => 'admin.php?page=wp-adminify-settings',
                        'account'    => true,
                        'support'    => true,
                        'network'    => true,
                    ),
                    'secret_key' => 'sk_W~>;_f2Lmd+:yR#Ksgtx<t+.OI>^X',
                ));
            }

            return $jltwp_adminify;
        }

        // Init Freemius.
        jltwp_adminify();
        // Signal that SDK was initiated.
        do_action('jltwp_adminify_loaded');
    }
}


if (!class_exists('\\WPAdminify\\WP_Adminify')) {
    // Autoload
    require_once dirname(__FILE__) . '/vendor/autoload.php';
    // Instantiate WP Adminify Class
    require_once dirname(__FILE__) . '/class-wp-adminify.php';
}

// Activation and Deactivation hooks
if (class_exists('\\WPAdminify\\WP_Adminify')) {
    register_activation_hook(WP_ADMINIFY_FILE, array('\\WPAdminify\\WP_Adminify', 'jltwp_adminify_activation_hook'));
    register_deactivation_hook(WP_ADMINIFY_FILE, array('\\WPAdminify\\WP_Adminify', 'jltwp_adminify_deactivation_hook'));
}

if (class_exists('\\WPAdminify\\Inc\\Modules\\ActivityLogs\\Inc\\DB_Table')) {
    register_activation_hook(WP_ADMINIFY_FILE, ['\\WPAdminify\\Inc\\Modules\\ActivityLogs\\Inc\\DB_Table', 'activation_hook']);
    register_uninstall_hook(WP_ADMINIFY_FILE, ['\\WPAdminify\\Inc\\Modules\\ActivityLogs\\Inc\\DB_Table', 'deactivation_hook']);
}
