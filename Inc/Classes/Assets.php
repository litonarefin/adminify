<?php

namespace WPAdminify\Inc\Classes;

use  WPAdminify\Inc\Admin\AdminSettings ;
use  WPAdminify\Inc\Admin\AdminSettingsModel ;
use  WPAdminify\Inc\Utils ;
// no direct access allowed
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class Assets extends AdminSettingsModel
{
    public function __construct()
    {
        $this->options = (array) AdminSettings::get_instance()->get();
        add_action( 'admin_enqueue_scripts', [ $this, 'jltwp_adminify_admin_scripts' ], 100 );
        add_action( 'wp_enqueue_scripts', [ $this, 'jltwp_adminify_enqueue_scripts' ], 100 );
    }
    
    // Google Fonts
    function jltwp_adminify_google_fonts_url()
    {
        $font_url = '';
        $font_family = ( !empty($this->options['admin_general_google_font']['font-family']) ? $this->options['admin_general_google_font']['font-family'] : 'Nunito Sans:300,400,600,700,800' );
        if ( 'off' !== _x( 'on', 'Google font: on or off', 'adminify' ) ) {
            $font_url = add_query_arg( 'family', urlencode( $font_family ), '//fonts.googleapis.com/css' );
        }
        return $font_url;
    }
    
    public function jltwp_adminify_admin_scripts()
    {
        $screen = get_current_screen();
        // Register Styles
        wp_register_style(
            'wp-adminify-admin',
            WP_ADMINIFY_ASSETS . 'css/wp-adminify' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        wp_register_style(
            'wp-adminify-default-ui',
            WP_ADMINIFY_ASSETS . 'css/wp-adminify-default-ui' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        wp_register_style(
            'wp-adminify-admin-bar',
            WP_ADMINIFY_ASSETS . 'css/admin-bar' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        wp_register_style(
            'wp-adminify-menu-editor',
            WP_ADMINIFY_ASSETS . 'css/adminify-menu-editor' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        wp_register_style(
            'wp-adminify-dark-mode',
            WP_ADMINIFY_ASSETS . 'css/dark-mode' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        wp_register_style(
            'wp-adminify-rtl',
            WP_ADMINIFY_ASSETS . 'css/adminify-rtl' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        wp_register_style(
            'wp-adminify-responsive',
            WP_ADMINIFY_ASSETS . 'css/adminify-responsive' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        wp_register_style(
            'wp-adminify-tokenize2',
            WP_ADMINIFY_ASSETS . 'vendors/tokenize/tokenize2.min' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        wp_register_style(
            'wp-adminify-animate',
            WP_ADMINIFY_ASSETS . 'vendors/animatecss/animate' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        // Register Fonts Styles
        wp_register_style(
            'wp-adminify-simple-line-icons',
            WP_ADMINIFY_ASSETS . 'fonts/simple-line-icons/css/simple-line-icons' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        wp_register_style(
            'wp-adminify-icomoon',
            WP_ADMINIFY_ASSETS . 'fonts/icomoon/style' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        wp_register_style(
            'wp-adminify-themify-icons',
            WP_ADMINIFY_ASSETS . 'fonts/themify-icons/themify-icons' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        // Register Scripts
        wp_register_script(
            'wp-adminify-circle-menu',
            WP_ADMINIFY_ASSETS . 'vendors/circle-menu/jQuery.circleMenu.js',
            [ 'jquery' ],
            WP_ADMINIFY_VER,
            false
        );
        wp_register_script(
            'wp-adminify-tokenize2',
            WP_ADMINIFY_ASSETS . 'vendors/tokenize/tokenize2.min.js',
            [ 'jquery' ],
            WP_ADMINIFY_VER,
            false
        );
        wp_register_script(
            'wp-adminify-admin',
            WP_ADMINIFY_ASSETS . 'js/wp-adminify.js',
            [ 'jquery' ],
            WP_ADMINIFY_VER,
            true
        );
        wp_register_script(
            'wp-adminify-menu-editor',
            WP_ADMINIFY_ASSETS . 'js/wp-adminify-menu-editor.js',
            [ 'jquery', 'jquery-ui-sortable', 'wp-adminify-icon-picker' ],
            WP_ADMINIFY_VER,
            true
        );
        wp_register_script(
            'wp-adminify-realtime-server',
            WP_ADMINIFY_ASSETS . 'js/adminify-realtime-server.js',
            [ 'jquery' ],
            WP_ADMINIFY_VER,
            true
        );
        // Login Customizer Control
        wp_register_script(
            'wp-adminify-login-customizer-controls',
            WP_ADMINIFY_ASSETS . 'css/controls' . Utils::assets_ext( '.css' ),
            null,
            WP_ADMINIFY_VER
        );
        // Adminify Icon Picker
        wp_register_style(
            'wp-adminify-icon-picker',
            WP_ADMINIFY_ASSETS . 'vendors/adminify-icon-picker/css/style' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        wp_register_script(
            'wp-adminify-icon-picker',
            WP_ADMINIFY_ASSETS . 'vendors/adminify-icon-picker/js/adminify-icon-picker.js',
            [ 'jquery' ],
            WP_ADMINIFY_VER,
            true
        );
        // Vendor
        wp_register_script(
            'wp-adminify-vue-manifest',
            WP_ADMINIFY_ASSETS . 'admin/js/manifest.js',
            [],
            WP_ADMINIFY_VER,
            true
        );
        wp_register_script(
            'wp-adminify-vue-vendors',
            WP_ADMINIFY_ASSETS . 'admin/js/vendor' . Utils::assets_ext( '.js' ),
            [ 'wp-adminify-vue-manifest' ],
            WP_ADMINIFY_VER,
            true
        );
        // Adminify Admin Columns
        wp_enqueue_style(
            'wp-adminify-admin-columns',
            WP_ADMINIFY_ASSETS . 'admin/css/wp-adminify--admin-columns' . Utils::assets_ext( '.css' ),
            [ 'wp-adminify-themify-icons' ],
            WP_ADMINIFY_VER
        );
        wp_register_script(
            'wp-adminify-admin-columns',
            WP_ADMINIFY_ASSETS . 'admin/js/wp-adminify--admin-columns' . Utils::assets_ext( '.js' ),
            [ 'jquery', 'wp-adminify-vue-vendors' ],
            WP_ADMINIFY_VER,
            true
        );
        // Adminify Page Speed
        wp_register_script(
            'wp-adminify--page-speed',
            WP_ADMINIFY_ASSETS . 'admin/js/wp-adminify--page-speed' . Utils::assets_ext( '.js' ),
            [ 'jquery', 'wp-adminify-vue-vendors' ],
            WP_ADMINIFY_VER,
            true
        );
        // Adminify Folder
        wp_register_script(
            'wp-adminify--folder',
            WP_ADMINIFY_ASSETS . 'admin/js/wp-adminify--folder' . Utils::assets_ext( '.js' ),
            [
            'jquery',
            'jquery-ui-droppable',
            'jquery-ui-draggable',
            'wp-adminify-vue-vendors'
        ],
            WP_ADMINIFY_VER,
            true
        );
        // Styles Enqueue
        wp_enqueue_style( 'wp-adminify-google-fonts', $this->jltwp_adminify_google_fonts_url() );
        
        if ( !empty($this->options['admin_ui']) ) {
            wp_enqueue_style( 'wp-adminify-animate' );
            wp_enqueue_style( 'wp-adminify-admin' );
            wp_enqueue_style( 'wp-adminify-admin-bar' );
            wp_enqueue_style( 'wp-adminify-responsive' );
        } else {
            wp_enqueue_style( 'wp-adminify-default-ui' );
        }
        
        // Dark Mode Style
        wp_enqueue_style( 'wp-adminify-dark-mode' );
        if ( is_rtl() ) {
            wp_enqueue_style( 'wp-adminify-rtl' );
        }
        // Scripts Enqueue
        wp_enqueue_script( 'wp-adminify-admin' );
        if ( !wp_script_is( 'adminify-fa', 'enqueued' ) || !wp_script_is( 'adminify-fa5', 'enqueued' ) ) {
            
            if ( apply_filters( 'adminify_fa4', false ) ) {
                wp_enqueue_style(
                    'adminify-fa',
                    'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome' . Utils::assets_ext( '.css' ),
                    [],
                    '4.7.0',
                    'all'
                );
            } else {
                wp_enqueue_style(
                    'adminify-fa5',
                    'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all' . Utils::assets_ext( '.css' ),
                    [],
                    '5.15.5',
                    'all'
                );
                wp_enqueue_style(
                    'adminify-fa5-v4-shims',
                    'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/v4-shims' . Utils::assets_ext( '.css' ),
                    [],
                    '5.15.5',
                    'all'
                );
            }
        
        }
        // Load Scripts/Styles only WP Adminify Admin Page
        if ( $screen->id == 'toplevel_page_wp-adminify-settings' ) {
            // Admin Notice Dismiss
            $this->jltwp_adminify_admin_script();
        }
    }
    
    // WP Adminify Options Page Style
    public function jltwp_adminify_admin_script()
    {
        echo  '<style>.wp-adminify-two-columns{ display: flex; flex-wrap: wrap; padding: 15px; } .wp-adminify .adminify-hightlight-field{ border: 2px solid #0347FF !important; font-weight: 600 !important;} .wp-adminify-two-columns .adminify-full-width-field{ width: 100% !important; flex-basis: 100% !important; } .wp-adminify-two-columns > .adminify-field{ width: 49%; flex-basis: 49%; margin-right: 1%; margin-top: -1px; border: 1px solid #eee; box-sizing: border-box; } .wp-adminify-two-columns.aminify-title-width-40 .adminify-title, .aminify-title-width-40 .adminify-title{ width: 40% !important;} .wp-adminify-two-columns.aminify-title-width-40 .adminify-fieldset, .aminify-title-width-40 .adminify-fieldset{ width: calc(60% - 20px) !important;} .wp-adminify-two-columns.aminify-title-width-65 .adminify-title{ width: 65%;} .wp-adminify-two-columns.aminify-title-width-65 .adminify-fieldset{ width: calc(35% - 20px);} .wp-adminify-two-columns .adminify-field-subheading{height:25px;box-sizing: content-box; width: 100%; flex-basis: 100%;} .wp-adminify-white-label-notice-content { background-color: #fff; box-shadow: 0px 0px 50px rgb(0 0 0 / 13%); position: absolute; top: 150px; left: 400px; width: 530px; padding: 32px; padding-bottom: 50px; -webkit-border-radius: 20px; border-radius: 20px; text-align: center; z-index: 2; } .wp-adminify-white-label-notice-logo img { height: 100px; width: 250px; padding: 10px; padding-top: 10px; } .wp-adminify-white-label-notice-content h2 span{ color: #6814cd; text-transform: uppercase; } .wp-adminify-white-label-notice-content em{ font-size: 13px; color: red; } .wp-adminify-white-label-notice .wp-adminify-get-pro{ background-image: -moz-linear-gradient( 0deg, rgb(223,29,198) 0%, rgb(106,20,209) 100%); background-image: -webkit-linear-gradient( 0deg , rgb(223,29,198) 0%, rgb(106,20,209) 100%); background-image: -ms-linear-gradient( 0deg, rgb(223,29,198) 0%, rgb(106,20,209) 100%); border: none; box-shadow: none; color: #fff; cursor: pointer; font-weight: 700; line-height: 35px; padding: 0 15px; text-transform: uppercase; text-decoration: none; display: inline-block; width: 180px; padding: 5px 15px !important; border-radius: 10px; font-size: 15px; font-weight: 800; -webkit-transition: all 0.2s ease-in-out; transition: all 0.2s ease-in-out; } .wp-adminify-white-label-notice{ position: absolute !important; top: 0; left: 0; width: 100% !important; height: 100%; background: rgba(200, 200, 200, 0.5); -js-display: flex; display: -webkit-box; display: -webkit-flex; display: -moz-box; display: -ms-flexbox; display: flex; -webkit-box-pack: center; -webkit-justify-content: center; -moz-box-pack: center; -ms-flex-pack: center; justify-content: center;z-index: 1; } .wp-adminify-white-label-notice .wp-adminify-get-pro:hover { color:#fff; background-image: -moz-linear-gradient(0deg, rgb(106, 20, 209) 0%, rgb(223, 29, 198) 100%); background-image: -webkit-linear-gradient( 0deg, rgb(106, 20, 209) 0%, rgb(223, 29, 198) 100%); background-image: -ms-linear-gradient(0deg, rgb(106, 20, 209) 0%, rgb(223, 29, 198) 100%);} .adminify-field-callback a.wp-adminify-rollback-button{font-family:inherit !important;} .wp-adminify-rollback-button.dashicons, .wp-adminify-rollback-button.dashicons-before:before{ width: inherit !important;}</style>' ;
    }
    
    // Styles & Scripts
    public static function jltwp_adminify_enqueue_scripts()
    {
        // Styles
        wp_register_style( 'wp-adminify-vegas', WP_ADMINIFY_ASSETS . 'vendors/vegas/vegas' . Utils::assets_ext( '.css' ) );
        // Icons
        wp_register_style(
            'wp-adminify-simple-line-icons',
            WP_ADMINIFY_ASSETS . 'fonts/simple-line-icons/css/simple-line-icons' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        wp_register_style(
            'wp-adminify-icomoon',
            WP_ADMINIFY_ASSETS . 'fonts/icomoon/style' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        wp_register_style(
            'wp-adminify-themify-icons',
            WP_ADMINIFY_ASSETS . 'fonts/themify-icons/themify-icons' . Utils::assets_ext( '.css' ),
            false,
            WP_ADMINIFY_VER
        );
        // Scripts
        wp_register_script(
            'wp-adminify-vegas',
            WP_ADMINIFY_ASSETS . 'vendors/vegas/vegas' . Utils::assets_ext( '.js' ),
            [ 'jquery' ],
            WP_ADMINIFY_VER,
            true
        );
        wp_register_script(
            'wp-adminify-vidim',
            WP_ADMINIFY_ASSETS . 'vendors/vidim/vidim' . Utils::assets_ext( '.js' ),
            [ 'jquery' ],
            WP_ADMINIFY_VER,
            true
        );
    }

}