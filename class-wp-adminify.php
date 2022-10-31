<?php

namespace WPAdminify;

use  WPAdminify\Inc\Classes\Assets ;
use  WPAdminify\Inc\Classes\Upgrade ;
use  WPAdminify\Inc\Admin\Admin ;
use  WPAdminify\Inc\Admin\AdminSettings ;
// No, Direct access Sir !!!
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WP_Adminify' ) ) {
    class WP_Adminify
    {
        const  VERSION = WP_ADMINIFY_VER ;
        private static  $instance = null ;
        public function __construct()
        {
            add_action( 'plugins_loaded', [ $this, 'maybe_run_upgrades' ], -100 );
            // This should run earlier
            add_action( 'plugins_loaded', [ $this, 'jltwp_adminify_plugins_loaded' ], 999 );
            add_filter( 'plugin_action_links_' . WP_ADMINIFY_BASE, [ $this, 'plugin_action_links' ] );
            add_filter( 'network_admin_plugin_action_links_' . WP_ADMINIFY_BASE, [ $this, 'plugin_action_links' ] );
            add_filter( 'admin_body_class', [ $this, 'jltwp_adminify_body_class' ] );
            $this->jltwp_is_plugin_row_meta();
            $this->jltwp_adminify_include_files();
            jltwp_adminify()->add_filter( 'freemius_pricing_js_path', [ $this, 'jltwp_new_freemius_pricing_js' ] );
            
            if ( apply_filters( 'jltwp_adminify_show_setup_wizard', true ) ) {
                new \WPAdminify\Inc\Classes\Setup_Wizard();
                set_transient( '_adminify_activation_redirect', 1, 30 );
            }
        
        }
        
        public function jltwp_is_plugin_row_meta()
        {
            add_filter(
                'plugin_row_meta',
                [ $this, 'jltwp_adminify_plugin_row_meta' ],
                10,
                2
            );
            add_filter(
                'network_admin_plugin_row_meta',
                [ $this, 'jltwp_adminify_plugin_row_meta' ],
                10,
                2
            );
        }
        
        /**
         * Add Body Class
         */
        public function jltwp_adminify_body_class( $classes )
        {
            $classes .= ' wp-adminify ';
            $adminify_ui = AdminSettings::get_instance()->get( 'admin_ui' );
            if ( !empty($adminify_ui) ) {
                $classes .= ' adminify-ui';
            }
            if ( is_rtl() ) {
                $classes .= ' adminify-rtl ';
            }
            return $classes;
        }
        
        /**
         * Plugin action links
         *
         * @param   array $links
         *
         * @return array
         */
        public function plugin_action_links( $links )
        {
            $links[] = sprintf( '<a class="adminify-plugin-settings" href="%1$s">%2$s</a>', admin_url( 'admin.php?page=wp-adminify-settings' ), __( 'Settings', 'adminify' ) );
            $links[] = sprintf( '<a href="%1$s" class="adminify-upgrade-pro" target="_blank" style="color: orangered;font-weight: bold;">%2$s</a>', 'https://wpadminify.com/pricing', __( 'Go Pro', 'adminify' ) );
            return $links;
        }
        
        public function jltwp_adminify_plugin_row_meta( $plugin_meta, $plugin_file )
        {
            
            if ( WP_ADMINIFY_BASE === $plugin_file ) {
                $row_meta = [
                    'docs'       => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url_raw( 'https://wpadminify.com/kb' ), __( 'Docs', 'adminify' ) ),
                    'changelogs' => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url_raw( 'https://wpadminify.com/changelogs/' ), __( 'Changelogs', 'adminify' ) ),
                    'tutorials'  => '<a href="https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8" aria-label="' . esc_attr( __( 'View WP Adminify Video Tutorials', 'adminify' ) ) . '" target="_blank">' . __( 'Video Tutorials', 'adminify' ) . '</a>',
                ];
                $plugin_meta = array_merge( $plugin_meta, $row_meta );
            }
            
            return $plugin_meta;
        }
        
        public function jltwp_adminify_plugins_loaded()
        {
            self::jltwp_adminify_activation_hook();
        }
        
        public function maybe_run_upgrades()
        {
            if ( !is_admin() && !current_user_can( 'manage_options' ) ) {
                return;
            }
            $upgrade = new Upgrade();
            if ( $upgrade->if_updates_available() ) {
                $upgrade->run_updates();
            }
        }
        
        public function jltwp_adminify_include_files()
        {
            new Assets();
            new Admin();
        }
        
        public function jltwp_adminify_init()
        {
            $this->jltwp_adminify_load_textdomain();
            // Redirect Hook
            // add_action('admin_init', [$this, 'jltwp_adminify_redirect_hook']);
        }
        
        // Text Domains
        public function jltwp_adminify_load_textdomain()
        {
            $domain = 'adminify';
            $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
            load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
            load_plugin_textdomain( $domain, false, dirname( WP_ADMINIFY_BASE ) . '/languages/' );
        }
        
        /*
         * Activation Plugin redirect hook
         */
        public function jltwp_adminify_redirect_hook()
        {
            wp_redirect( 'admin.php?page=wp-adminify-settings' );
            exit;
        }
        
        // Activation Hook
        public static function jltwp_adminify_activation_hook()
        {
            $current_adminify_version = get_option( 'wp_adminify_version', null );
            if ( get_option( 'jltwp_adminify_activation_time' ) === false ) {
                update_option( 'jltwp_adminify_activation_time', strtotime( 'now' ) );
            }
            if ( is_null( $current_adminify_version ) ) {
                update_option( 'wp_adminify_version', self::VERSION );
            }
        }
        
        // Deactivation Hook
        public static function jltwp_adminify_deactivation_hook()
        {
            delete_option( 'jltwp_adminify_activation_time' );
            delete_option( 'jltwp_adminify_customizer_flush_url' );
        }
        
        public function jltwp_new_freemius_pricing_js( $default_pricing_js_path )
        {
            return WP_ADMINIFY_PATH . '/lib/freemius-pricing/freemius-pricing.js';
        }
        
        /**
         * Returns the singleton instance of the class.
         */
        public static function get_instance()
        {
            
            if ( !isset( self::$instance ) && !self::$instance instanceof WP_Adminify ) {
                self::$instance = new WP_Adminify();
                self::$instance->jltwp_adminify_init();
            }
            
            return self::$instance;
        }
    
    }
    WP_Adminify::get_instance();
}
