<?php

namespace WPAdminify\Inc\Admin\Options;

use  WPAdminify\Inc\Admin\AdminSettingsModel ;
if ( !defined( 'ABSPATH' ) ) {
    die;
}
// Cannot access directly.
if ( !class_exists( 'Modules' ) ) {
    class Modules extends AdminSettingsModel
    {
        public function __construct()
        {
            $this->jltwp_adminify_general_options();
        }
        
        public function get_defaults()
        {
            return [
                'admin_ui'           => true,
                'folders'            => true,
                'admin_notices'      => true,
                'login_customizer'   => true,
                'redirect_urls'      => true,
                'admin_columns'      => true,
                'menu_editor'        => true,
                'dashboard_widgets'  => true,
                'pagespeed_insights' => true,
                'custom_css_js'      => true,
                'quick_menu'         => true,
                'menu_duplicator'    => true,
                'activity_logs'      => true,
                'admin_pages'        => true,
                'notification_bar'   => true,
                'post_duplicator'    => true,
                'post_types_order'   => true,
                'server_info'        => true,
                'sidebar_generator'  => true,
                'disable_comments'   => true,
            ];
        }
        
        /**
         * Module Fields
         *
         * @param [type] $modules_fields
         *
         * @return void
         */
        public function module_fields( &$modules_fields )
        {
            $modules_fields[] = [
                'id'         => 'admin_ui',
                'type'       => 'switcher',
                'title'      => __( 'Adminify UI', 'adminify' ),
                'subtitle'   => __( 'Choose WordPress Default or Adminify UI for your Dashboard. Default: Adminify UI', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'admin_ui' ),
            ];
            $modules_fields[] = [
                'id'         => 'folders',
                'type'       => 'switcher',
                'title'      => __( 'Folders', 'adminify' ),
                'subtitle'   => __( 'Categorize Post/Page/Media & Custom Post Types', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'folders' ),
            ];
            $modules_fields[] = [
                'id'         => 'login_customizer',
                'type'       => 'switcher',
                'title'      => __( 'Login Customizer', 'adminify' ),
                'subtitle'   => __( '16 pre-built Templates, with Video,Slideshow,Gradient and many more', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'login_customizer' ),
            ];
            $modules_fields[] = [
                'id'         => 'admin_notices',
                'type'       => 'switcher',
                'title'      => __( 'Admin Notices', 'adminify' ),
                'subtitle'   => __( 'Enable/Disable Hide All admin Notices Module', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'admin_notices' ),
            ];
            $modules_fields[] = [
                'id'         => 'admin_columns',
                'type'       => 'switcher',
                'title'      => __( 'Admin Columns', 'adminify' ),
                'subtitle'   => __( 'Customize Column names post,page,products,media,taxonomoy etc', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'admin_columns' ),
            ];
            $modules_fields[] = [
                'id'         => 'menu_editor',
                'type'       => 'switcher',
                'title'      => __( 'Menu Editor', 'adminify' ),
                'subtitle'   => __( 'Advanced Menu Editor with restrict users, Custom Icons etc', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'menu_editor' ),
            ];
            $modules_fields[] = [
                'id'         => 'dashboard_widgets',
                'type'       => 'switcher',
                'title'      => __( 'Dashboard & Welcome Widget', 'adminify' ),
                'subtitle'   => __( 'Create Custom Dashboard & Sidebar Widgets', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'dashboard_widgets' ),
            ];
            $modules_fields[] = [
                'id'         => 'pagespeed_insights',
                'type'       => 'switcher',
                'title'      => __( 'Pagespeed Insights', 'adminify' ),
                'subtitle'   => __( 'Analyze Google Pagespeed from Dashboard', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'pagespeed_insights' ),
            ];
            $modules_fields[] = [
                'id'         => 'custom_css_js',
                'type'       => 'switcher',
                'title'      => __( 'Header/Footer Scripts', 'adminify' ),
                'subtitle'   => __( 'Inject Custom CSS/JS on Header or Footer', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'custom_css_js' ),
            ];
            $modules_fields[] = [
                'id'         => 'quick_menu',
                'type'       => 'switcher',
                'title'      => __( 'Quick Menu', 'adminify' ),
                'subtitle'   => __( 'Quick Menu for navigating quickly', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'quick_menu' ),
            ];
            $modules_fields[] = [
                'id'         => 'menu_duplicator',
                'type'       => 'switcher',
                'title'      => __( 'Menu Duplicator', 'adminify' ),
                'subtitle'   => __( 'Duplicate menu and Nav menu items also', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'menu_duplicator' ),
            ];
            $modules_fields[] = [
                'id'         => 'notification_bar',
                'type'       => 'switcher',
                'title'      => __( 'Notification Bar', 'adminify' ),
                'subtitle'   => __( 'Cookie Notice, Promotional Bar on frontend', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'notification_bar' ),
            ];
            $modules_fields[] = [
                'id'         => 'activity_logs',
                'type'       => 'switcher',
                'title'      => __( 'Activity Logs', 'adminify' ),
                'subtitle'   => __( 'Security check for all users Activity', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'activity_logs' ),
            ];
            $modules_fields[] = [
                'id'         => 'post_duplicator',
                'type'       => 'switcher',
                'title'      => __( 'Post Duplicator', 'adminify' ),
                'subtitle'   => __( 'Duplicate Post/Page and any Custom Post Type', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'post_duplicator' ),
            ];
            $modules_fields[] = [
                'id'         => 'admin_pages',
                'type'       => 'switcher',
                'title'      => __( 'Admin Pages', 'adminify' ),
                'subtitle'   => __( 'Custom Admin Pages hooks on Top/Sub Menu', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'admin_pages' ),
            ];
            $modules_fields[] = [
                'id'         => 'sidebar_generator',
                'type'       => 'switcher',
                'title'      => __( 'Sidebar Generator', 'adminify' ),
                'subtitle'   => __( 'Create Custom Sidebar Widgets', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'sidebar_generator' ),
            ];
            $modules_fields[] = [
                'id'         => 'post_types_order',
                'type'       => 'switcher',
                'title'      => __( 'Post Types Order', 'adminify' ),
                'subtitle'   => __( 'Post Types and Taxonomy Order', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'post_types_order' ),
            ];
            $modules_fields[] = [
                'id'         => 'server_info',
                'type'       => 'switcher',
                'title'      => __( 'Server Info', 'adminify' ),
                'subtitle'   => __( 'Server Info menu Module', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'server_info' ),
            ];
            $modules_fields[] = [
                'id'         => 'disable_comments',
                'type'       => 'switcher',
                'title'      => __( 'Disable Comments', 'adminify' ),
                'subtitle'   => __( 'Disable Comments for Post/Pages/Post Types etc', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'disable_comments' ),
            ];
        }
        
        public function jltwp_adminify_general_options()
        {
            if ( !class_exists( 'ADMINIFY' ) ) {
                return;
            }
            $modules_fields = [];
            $this->module_fields( $modules_fields );
            // Modules Section
            \ADMINIFY::createSection( $this->prefix, [
                'title'  => __( 'Modules', 'adminify' ),
                'icon'   => 'fas fa-layer-group',
                'class'  => 'wp-adminify-two-columns aminify-title-width-65',
                'fields' => $modules_fields,
            ] );
        }
    
    }
}