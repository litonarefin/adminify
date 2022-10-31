<?php

namespace WPAdminify\Inc\Admin;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Admin\AdminSettings ;
use  WPAdminify\Inc\Admin\AdminSettingsModel ;
use  WPAdminify\Inc\Classes\QuickCircleMenu ;
use  WPAdminify\Inc\Modules\MenuEditor\MenuEditor ;
use  WPAdminify\Inc\Modules\AdminColumns\AdminColumns ;
use  WPAdminify\Inc\Modules\Folders\Folders ;
use  WPAdminify\Inc\Modules\GooglePageSpeed\GooglePageSpeed ;
use  WPAdminify\Inc\Modules\LoginCustomizer\LoginCustomizer ;
use  WPAdminify\Inc\Modules\NotificationBar\NotificationBar ;
use  WPAdminify\Inc\Modules\SidebarGenerator\Sidebar_Generator ;
use  WPAdminify\Inc\Modules\DismissNotices\Dismiss_Admin_Notices ;
use  WPAdminify\Inc\Modules\ActivityLogs\ActivityLogs ;
use  WPAdminify\Inc\Modules\AdminPages\AdminPages ;
use  WPAdminify\Inc\Modules\CustomHeaderFooter\CustomHeaderFooter ;
use  WPAdminify\Inc\Modules\DashboardWidget\DashboardWidget ;
use  WPAdminify\Inc\Modules\PostDuplicator\PostDuplicator ;
use  WPAdminify\Inc\Modules\MenuDuplicator\MenuDuplicator ;
use  WPAdminify\Inc\Modules\PostTypesOrder\PostTypesOrder ;
use  WPAdminify\Inc\Modules\DisableComments\DisableComments ;
use  WPAdminify\Pro\RedirectUrls\RedirectUrls ;
use  WPAdminify\Inc\Modules\ServerInformation\ServerInformation ;
use  WPAdminify\Inc\Admin\Options\RollbackVersion ;
// no direct access allowed
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * WP Adminify
 *
 * @package Modules
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */
class Modules extends AdminSettingsModel
{
    public function __construct()
    {
        $this->modules_init();
        add_action( 'admin_notices', [ $this, 'module_conflict_notice' ], -9999999 );
    }
    
    /**
     * Include Moduels
     *
     * @return void
     */
    public function modules_init()
    {
        $this->options = AdminSettings::get_instance()->get();
        if ( Utils::check_modules( $this->options['folders'] ) ) {
            new Folders();
        }
        if ( Utils::check_modules( $this->options['quick_menu'] ) ) {
            new QuickCircleMenu();
        }
        if ( Utils::check_modules( $this->options['admin_notices'] ) ) {
            new Dismiss_Admin_Notices();
        }
        if ( Utils::check_modules( $this->options['menu_duplicator'] ) ) {
            new MenuDuplicator();
        }
        if ( Utils::check_modules( $this->options['post_duplicator'] ) ) {
            new PostDuplicator();
        }
        if ( Utils::check_modules( $this->options['post_types_order'] ) ) {
            new PostTypesOrder();
        }
        if ( Utils::check_modules( $this->options['disable_comments'] ) ) {
            new DisableComments();
        }
        if ( Utils::check_modules( $this->options['dashboard_widgets'] ) ) {
            new DashboardWidget();
        }
        if ( Utils::check_modules( $this->options['custom_css_js'] ) ) {
            new CustomHeaderFooter();
        }
        if ( Utils::check_modules( $this->options['sidebar_generator'] ) ) {
            new Sidebar_Generator();
        }
        if ( Utils::check_modules( $this->options['server_info'] ) ) {
            new ServerInformation();
        }
        if ( Utils::check_modules( $this->options['notification_bar'] ) ) {
            new NotificationBar();
        }
        if ( Utils::check_modules( $this->options['pagespeed_insights'] ) ) {
            new GooglePageSpeed();
        }
        if ( Utils::check_modules( $this->options['login_customizer'] ) ) {
            new LoginCustomizer();
        }
        if ( Utils::check_modules( $this->options['admin_columns'] ) ) {
            new AdminColumns();
        }
        if ( Utils::check_modules( $this->options['menu_editor'] ) ) {
            new MenuEditor();
        }
        if ( Utils::check_modules( $this->options['activity_logs'] ) ) {
            ActivityLogs::get_instance();
        }
        // TO DO: Turned Off for future release, after making Network Options stable
        // if (Utils::check_modules($this->options['server_info'])) {
        // new RollbackVersion();
        // }
    }
    
    public function maybe_conflicted_plugins_active( $plugins, $module_name )
    {
        $options = (array) AdminSettings::get_instance()->get();
        if ( !Utils::check_modules( $options[$module_name] ) ) {
            return false;
        }
        $active_plugins = get_option( 'active_plugins', [] );
        $is_found = false;
        $_plugin = null;
        foreach ( $active_plugins as $plugin ) {
            
            if ( in_array( $plugin, $plugins ) ) {
                $is_found = true;
                $_plugin = $plugin;
            }
        
        }
        if ( !$is_found ) {
            return false;
        }
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        $all_plugins = get_plugins();
        return $all_plugins[$_plugin];
    }
    
    public function module_conflict_notice()
    {
        $this->maybe_show_folder_module_notice();
    }
    
    public function maybe_show_folder_module_notice()
    {
        $plugins = [
            'folders/folders.php',
            'filebird/filebird.php',
            'real-media-library-lite/index.php',
            'wicked-folders/wicked-folders.php',
            'real-category-library-lite/index.php',
            'wp-media-folders/wp-media-folders.php',
            'media-library-plus/maxgalleria-media-library.php'
        ];
        $result = $this->maybe_conflicted_plugins_active( $plugins, 'folders' );
        if ( !$result ) {
            return;
        }
        ?>

		<div class="notice notice-warning is-dismissible">
			<p class="notice-brand-identifier"><img width="100" src="<?php 
        echo  WP_ADMINIFY_ASSETS_IMAGE . 'logos/logo-text-light.svg' ;
        ?>" alt=""></p>
			<br />
			<p>You are using <strong><?php 
        echo  esc_html( $result['Name'] ) ;
        ?></strong> plugin, which serve the same purpose as our folder module.</p>
			<p>We have Disabled our <strong>Folder</strong> module, to avoid conflicts.</p>
		</div>

		<?php 
        $adminSettings = AdminSettings::get_instance();
        $options = get_option( $adminSettings->prefix );
        $options['folders'] = false;
        // force disable
        update_option( $adminSettings->prefix, $options );
    }

}