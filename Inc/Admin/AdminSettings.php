<?php

namespace WPAdminify\Inc\Admin;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Admin\AdminSettingsModel ;
use  WPAdminify\Inc\Admin\Options\General ;
use  WPAdminify\Inc\Admin\Options\Modules ;
use  WPAdminify\Inc\Admin\Options\DismissNotices ;
use  WPAdminify\Inc\Admin\Options\MenuLayout ;
use  WPAdminify\Inc\Admin\Options\Tweaks ;
use  WPAdminify\Inc\Admin\Options\AdminBar ;
use  WPAdminify\Inc\Admin\Options\Admin_Footer ;
use  WPAdminify\Inc\Admin\Options\WidgetSettings ;
use  WPAdminify\Inc\Admin\Options\Module_Settings ;
use  WPAdminify\Inc\Admin\Options\Assets_Manager ;
use  WPAdminify\Inc\Admin\Options\White_Label ;
use  WPAdminify\Inc\Admin\Options\Custom_CSS_JS_Admin_Area ;
if ( !defined( 'ABSPATH' ) ) {
    die;
}
// Cannot access directly.
if ( !class_exists( 'AdminSettings' ) ) {
    class AdminSettings extends AdminSettingsModel
    {
        // AdminSettings cannot be extended by creating instances
        public static  $instance = null ;
        public  $defaults = array() ;
        private  $message = array() ;
        public function __construct()
        {
            // this should be first so the default values get stored
            $this->jltwp_adminify_options();
            parent::__construct( (array) get_option( $this->prefix ) );
            add_action( 'network_admin_menu', array( $this, 'network_panel' ) );
        }
        
        public function network_panel()
        {
            add_menu_page(
                $this->get_plugin_menu_label(),
                $this->get_plugin_menu_label(),
                'manage_options',
                'wp-adminify-settings',
                array( $this, 'network_panel_display' ),
                WP_ADMINIFY_ASSETS_IMAGE . 'logos/menu-icon.svg',
                30
            );
        }
        
        public function get_bloginfo( $blog_id, $fields = array() )
        {
            switch_to_blog( $blog_id );
            $_fields = array();
            foreach ( $fields as $field ) {
                $_fields[$field] = get_bloginfo( $field );
            }
            restore_current_blog();
            return $_fields;
        }
        
        public function get_sites()
        {
            $sites = get_sites();
            foreach ( $sites as $site ) {
                $info = $this->get_bloginfo( $site->blog_id, array( 'name' ) );
                $site->name = $info['name'];
            }
            return $sites;
        }
        
        public function get_sites_option_empty()
        {
            return sprintf( '<option value="%s">%s</option>', 0, __( 'Select', 'adminify' ) );
        }
        
        public function get_sites_option( $sites = array(), $add_empty_slot = false )
        {
            if ( empty($sites) ) {
                $sites = $this->get_sites();
            }
            $_sites = array();
            if ( $add_empty_slot ) {
                $_sites[] = $this->get_sites_option_empty();
            }
            foreach ( $sites as $site ) {
                $_sites[] = sprintf( '<option value="%s">%s</option>', $site->blog_id, $site->name );
            }
            return implode( '', $_sites );
        }
        
        public function maybe_display_message()
        {
            if ( empty($this->message) ) {
                return;
            }
            $classes = 'adminify-status adminify-status--' . $this->message['type'];
            printf( '<div class="%s"><p>%s</p></div>', $classes, $this->message['message'] );
        }
        
        public function network_panel_display()
        {
            echo  '<h2>Network Settings</h2>' ;
            echo  '<div>' ;
            echo  Utils::adminify_upgrade_pro( 'Upgrade to Pro' ) ;
            echo  '</div>' ;
        }
        
        public function option_modules()
        {
            return (array) apply_filters( 'adminify_clone_blog_option_modules', array(
                '_wpadminify'                                 => __( 'Adminify Core' ),
                '_wp_adminify_sidebar_settings'               => __( 'Sidebar Settings' ),
                '_wpadminify_custom_js_css'                   => __( 'Custom JS CSS' ),
                '_adminify_admin_columns_adminify_admin_page' => __( 'Admin Page Columns Data' ),
                '_adminify_admin_columns_page'                => __( 'Page Columns Data' ),
                '_adminify_admin_columns_post'                => __( 'Post Columns Data' ),
                '_wpadminify_admin_saved_notices'             => __( 'Saved Notices' ),
                '_adminify_notification_bar'                  => __( 'Notification Bar' ),
                'jltwp_adminify_login'                        => __( 'Login Customizer' ),
            ) );
        }
        
        public function maybe_clone_blog_options()
        {
        }
        
        public function get_pagespeed_data( $copy_from )
        {
            switch_to_blog( $copy_from );
            global  $wpdb ;
            $table_name = $wpdb->prefix . 'adminify_page_speed';
            $histories = $wpdb->get_results( "SELECT * FROM {$table_name}", ARRAY_A );
            restore_current_blog();
            return $histories;
        }
        
        public function clone_pagespeed_data( $histories, $copy_to )
        {
            switch_to_blog( $copy_to );
            global  $wpdb ;
            $table_name = $wpdb->prefix . 'adminify_page_speed';
            foreach ( $histories as $history ) {
                unset( $history['id'] );
                $wpdb->insert( "{$table_name}", $history, array(
                    'url'           => '%s',
                    'score_desktop' => '%d',
                    'score_mobile'  => '%d',
                    'data_desktop'  => '%s',
                    'data_mobile'   => '%s',
                    'screenshot'    => '%s',
                    'time'          => '%s',
                ) );
            }
            restore_current_blog();
        }
        
        public function get_admin_columns_options( $copy_from )
        {
            $options = array();
            switch_to_blog( $copy_from );
            $args = array(
                'public' => true,
            );
            $types = get_post_types( $args );
            unset( $types['attachment'] );
            restore_current_blog();
            foreach ( $types as $type ) {
                $options[] = '_adminify_admin_columns_meta_' . $type;
            }
            return $options;
        }
        
        public static function get_instance()
        {
            if ( !is_null( self::$instance ) ) {
                return self::$instance;
            }
            self::$instance = new self();
            return self::$instance;
        }
        
        protected function get_defaults()
        {
            return $this->defaults;
        }
        
        /**
         * Admin Settings CSS
         *
         * @return void
         */
        public function jltwp_adminify_admin_scripts()
        {
        }
        
        public function get_plugin_menu_label()
        {
            $plugin_menu_label = WP_ADMINIFY;
            $saved_data = get_option( $this->prefix );
            return $plugin_menu_label;
        }
        
        public function jltwp_adminify_options()
        {
            if ( !class_exists( 'ADMINIFY' ) ) {
                return;
            }
            $saved_data = get_option( $this->prefix );
            $admin_bar_mode = ( empty($saved_data['admin_bar_mode']) ? 'light' : $saved_data['admin_bar_mode'] );
            
            if ( $admin_bar_mode == 'light' ) {
                $logo_image_url = WP_ADMINIFY_ASSETS_IMAGE . 'logos/logo-text-light.svg';
            } else {
                $logo_image_url = WP_ADMINIFY_ASSETS_IMAGE . 'logos/logo-text-dark.svg';
            }
            
            $plugin_author_name = WP_ADMINIFY_AUTHOR;
            // WP Adminify Options
            \ADMINIFY::createOptions( $this->prefix, array(
                'framework_title'         => '<img class="wp-adminify-settings-logo" src=' . $logo_image_url . '>' . ' <small>by ' . $plugin_author_name . '</small>',
                'framework_class'         => '',
                'menu_title'              => $this->get_plugin_menu_label(),
                'menu_slug'               => 'wp-adminify-settings',
                'menu_capability'         => 'manage_options',
                'menu_icon'               => WP_ADMINIFY_ASSETS_IMAGE . 'logos/menu-icon.svg',
                'menu_position'           => 30,
                'menu_hidden'             => false,
                'menu_parent'             => 'admin.php?page=wp-adminify-settings',
                'show_bar_menu'           => true,
                'show_sub_menu'           => false,
                'show_in_network'         => false,
                'show_in_customizer'      => false,
                'show_search'             => false,
                'show_reset_all'          => true,
                'show_reset_section'      => true,
                'show_footer'             => true,
                'show_all_options'        => false,
                'show_form_warning'       => true,
                'sticky_header'           => false,
                'save_defaults'           => false,
                'ajax_save'               => true,
                'admin_bar_menu_icon'     => '',
                'admin_bar_menu_priority' => 80,
                'footer_text'             => ' ',
                'footer_after'            => ' ',
                'footer_credit'           => ' ',
                'database'                => 'options',
                'transient_time'          => 0,
                'contextual_help'         => array(),
                'contextual_help_sidebar' => '',
                'enqueue_webfont'         => true,
                'async_webfont'           => false,
                'output_css'              => true,
                'nav'                     => 'normal',
                'theme'                   => 'dark',
                'class'                   => 'wp-adminify-settings',
                'defaults'                => array(),
            ) );
            $this->defaults = array_merge( $this->defaults, ( new Modules() )->get_defaults() );
            $this->defaults = array_merge( $this->defaults, ( new General() )->get_defaults() );
            $this->defaults = array_merge( $this->defaults, ( new Admin_Footer() )->get_defaults() );
            $this->defaults = array_merge( $this->defaults, ( new MenuLayout() )->get_defaults() );
            $this->defaults = array_merge( $this->defaults, ( new AdminBar() )->get_defaults() );
            $this->defaults = array_merge( $this->defaults, ( new Tweaks() )->get_defaults() );
            $this->defaults = array_merge( $this->defaults, ( new WidgetSettings() )->get_defaults() );
            $this->defaults = array_merge( $this->defaults, ( new DismissNotices() )->get_defaults() );
            $this->defaults = array_merge( $this->defaults, ( new Module_Settings() )->get_defaults() );
            $this->defaults = array_merge( $this->defaults, ( new Assets_Manager() )->get_defaults() );
            $this->defaults = array_merge( $this->defaults, ( new Custom_CSS_JS_Admin_Area() )->get_defaults() );
            $this->defaults = array_merge( $this->defaults, ( new White_Label() )->get_defaults() );
            // Backup Settings
            \ADMINIFY::createSection( $this->prefix, array(
                'title'  => 'Backup',
                'icon'   => 'fas fa-shield-alt',
                'fields' => array( array(
                'type'    => 'subheading',
                'content' => Utils::adminfiy_help_urls(
                __( 'Backup Config Settings', 'adminify' ),
                'https://wpadminify.com/kb/wp-adminify-options-panel/#adminify-backup',
                'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
                'https://www.facebook.com/groups/jeweltheme',
                'https://wpadminify.com/support/'
            ),
            ), array(
                'type' => 'backup',
            ) ),
            ) );
        }
    
    }
}