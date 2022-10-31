<?php

namespace WPAdminify\Inc\Classes;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Admin\AdminSettings ;
use  WPAdminify\Inc\Modules\MenuEditor\MenuEditorOptions ;
// no direct access allowed
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * WPAdminify
 * Third Party Plugins Compatibility
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */
class ThirdPartyCompatibility
{
    public function __construct()
    {
        $this->menu_settings = ( new MenuEditorOptions() )->get();
        add_action( 'init', array( $this, 'register_actions_on_init' ), 0 );
        add_action( 'admin_init', array( $this, 'register_actions_on_admin_init' ), 0 );
        $this->enqueue_scripts();
        add_action( 'admin_enqueue_scripts', array( $this, 'jltwp_adminify_reset_theme_conflicts' ), 100 );
    }
    
    public function jltwp_adminify_reset_theme_conflicts()
    {
        $theme = wp_get_theme();
        // Neve WordPress Theme
        if ( 'Neve' == $theme->name || 'Neve' == $theme->parent_theme ) {
            wp_enqueue_style(
                'wp-adminify_neve-theme',
                WP_ADMINIFY_ASSETS . 'css/themes/neve.min.css',
                false,
                WP_ADMINIFY_VER
            );
        }
        // Third Party Plugin CSS Conflict
        // $jltwp_adminify_plugin_conflict_css = '';
        // if (Utils::is_plugin_active('quillforms/quillforms.php')) {
        // $jltwp_adminify_plugin_conflict_css = '//css code here';
        // $jltwp_adminify_plugin_conflict_css = preg_replace('#/\*.*?\*/#s', '', $jltwp_adminify_plugin_conflict_css);
        // $jltwp_adminify_plugin_conflict_css = preg_replace('/\s*([{}|:;,])\s+/', '$1', $jltwp_adminify_plugin_conflict_css);
        // $jltwp_adminify_plugin_conflict_css = preg_replace('/\s\s+(.*)/', '$1', $jltwp_adminify_plugin_conflict_css);
        // }
        // $adminify_ui = AdminSettings::get_instance()->get('admin_ui');
        // if (!empty($adminify_ui)) {
        // wp_add_inline_style('wp-adminify-admin', wp_strip_all_tags($jltwp_adminify_plugin_conflict_css));
        // } else {
        // wp_add_inline_style('wp-adminify-default-ui', wp_strip_all_tags($jltwp_adminify_plugin_conflict_css));
        // }
        if ( Utils::is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            echo  '<style>
            body.woocommerce-page #wpwrap #wpcontent,
            body.woocommerce-page.woocommerce_page_wc-admin #wpwrap #wpbody-content {
                overflow-x: unset !important;
                position: unset !important;
            }
            </style>' ;
        }
        if ( Utils::is_plugin_active( 'tinymce-templates/tinymce-templates.php' ) ) {
            echo  '<style>#tinymce-templates-wrap #tinymce-templates-preview { height: 500px !important; }</style>' ;
        }
        if ( Utils::is_plugin_active( 'elementor/elementor.php' ) ) {
            echo  '<style>
                body.wp-adminify-admin-bar.admin-bar .dialog-lightbox-widget {
                    height: calc(100vh - 0px) !important;
                }
                body.wp-adminify-admin-bar.admin-bar #e-admin-top-bar-root{
                    padding-top: 70px !important;
                    width: calc(100% + 20px) !important;
                    margin-left: -20px;
                }
                body.wp-adminify-admin-bar.admin-bar #e-admin-top-bar-root .e-admin-top-bar{
                    padding-left: 20px;
                }
            </style>' ;
        }
        if ( Utils::is_plugin_active( 'one-click-demo-import/one-click-demo-import.php' ) ) {
            echo  '<style>
                .wp-adminify.appearance_page_one-click-demo-import .button-hero {
                    min-height: auto !important;
                }
            </style>' ;
        }
        if ( Utils::is_plugin_active( 'classic-editor/classic-editor.php' ) ) {
            echo  '<style>
                #ed_toolbar{
                    width: 100% !important;
                }
                #ed_toolbar #qt_content_dfw{
                    line-height: inherit;
                    padding: 0;
                }
            </style>' ;
        }
        if ( Utils::is_plugin_active( 'updraftplus/updraftplus.php' ) ) {
            echo  '<style>
                .wp-adminify.adminify-dark-mode .updraft_feat_table,
                .wp-adminify.adminify-dark-mode .updraft_feat_table td,
                .wp-adminify.adminify-dark-mode .updraft_next_scheduled_backups_wrapper > div,
                .wp-adminify.adminify-dark-mode .updraft_migrate_widget_module_content{
                    background: inherit;
                }
                .wp-adminify.adminify-dark-mode .updraft_premium_cta,
                .wp-adminify.adminify-dark-mode .updraft_premium_cta__bottom,
                .wp-adminify.adminify-dark-mode .udp-box,
                .wp-adminify.adminify-dark-mode .updraftcentral_cloud_connect,
                .wp-adminify.adminify-dark-mode .updraft_advert_bottom,
                .wp-adminify.adminify-dark-mode #remote-storage-container label{
                    background: #020407;
                }
                .wp-adminify.adminify-dark-mode .expertmode .advanced_settings_container .advanced_settings_menu .advanced_tools_button{
                    color: inherit;
                }
            </style>' ;
        }
        if ( Utils::is_plugin_active( 'tinymce-advanced/tinymce-advanced.php' ) ) {
            echo  '<style>
                .wp-editor-container .mce-container-body .mce-menubar.mce-toolbar{
                    position: initial !important;
                }
                .wp-editor-container .mce-container-body .mce-toolbar-grp .mce-container-body{
                    position: relative !important;
                }
                .wp-editor-container .mce-container-body .mce-toolbar-grp .mce-toolbar.mce-first {
                    padding-right: 0 !important;
                }
                #ed_toolbar{
                    width: 100% !important;
                }
                #ed_toolbar #qt_content_dfw{
                    line-height: inherit;
                    padding: 0;
                }
            </style>' ;
        }
        // Third Party localize script
        wp_localize_script( 'wp-adminify-admin', 'WPAdminify_ThirdParty', $this->thirdparty_create_js_object() );
    }
    
    public function thirdparty_create_js_object()
    {
        // betterlinks menu settings
        $betterlinks = array(
            'active' => false,
        );
        if ( Utils::is_plugin_active( 'betterlinks/betterlinks.php' ) ) {
            
            if ( is_array( $this->menu_settings ) && array_key_exists( 'betterlinks', $this->menu_settings ) ) {
                $menu_name = ( !empty($this->menu_settings['betterlinks']['name']) ? $this->menu_settings['betterlinks']['name'] : '' );
                $submenu_manage = ( !empty($this->menu_settings['betterlinks']['submenu']['betterlinks']['name']) ? $this->menu_settings['betterlinks']['submenu']['betterlinks']['name'] : '' );
                $submenu_name = ( !empty($this->menu_settings['betterlinks']['submenu']['betterlinks-analytics']['name']) ? $this->menu_settings['betterlinks']['submenu']['betterlinks-analytics']['name'] : '' );
                $submenu_settings = ( !empty($this->menu_settings['betterlinks']['submenu']['betterlinks-settings']['name']) ? $this->menu_settings['betterlinks']['submenu']['betterlinks-settings']['name'] : '' );
                $betterlinks = array(
                    'active'           => true,
                    'menu_name'        => $menu_name,
                    'submenu_manage'   => $submenu_manage,
                    'submenu_name'     => $submenu_name,
                    'submenu_settings' => $submenu_settings,
                );
            }
        
        }
        return array(
            'ajax_url'     => admin_url( 'admin-ajax.php' ),
            'better_links' => $betterlinks,
        );
    }
    
    public function register_actions_on_init()
    {
        // Brizy Builder
        
        if ( isset( $_REQUEST['brizy-edit-iframe'] ) ) {
            add_filter( 'wp_adminify_defer_skip', '__return_true' );
            add_filter( 'wp_adminify_skip_removing_dashicons', '__return_true' );
        }
    
    }
    
    public function register_actions_on_admin_init()
    {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 999 );
        add_filter( 'adminify_third_party_styles', array( $this, 'register_compatability_styles' ) );
        // Fluent CRM
        add_action( 'fluentcrm_skip_no_conflict', '__return_true' );
        // Fluent FORM
        add_action( 'fluentform_skip_no_conflict', '__return_true' );
    }
    
    /**
     * Register Third Party Styles
     *
     * @since 1.0.0
     */
    public function register_compatability_styles( $plugin_supports )
    {
        if ( !is_array( $plugin_supports ) ) {
            $plugin_supports = array();
        }
        $plugin_dir = WP_ADMINIFY_ASSETS . 'css/plugins/';
        $plugin_files = list_files( WP_ADMINIFY_PATH . 'assets/css/plugins/', 1 );
        if ( !empty($plugin_files) ) {
            foreach ( $plugin_files as $file ) {
                $plugin_supports[wp_basename( $file, '.min.css' )] = $plugin_dir . wp_basename( $file );
            }
        }
        return $plugin_supports;
    }
    
    /**
     * Admin Enqueue Third Party Scripts/Styles
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        $plugin_supports = array();
        $plugin_supports = apply_filters( 'adminify_third_party_styles', $plugin_supports );
        // Check Plugin Activated for Site Wide
        
        if ( is_multisite() ) {
            $active_plugins = get_site_option( 'active_sitewide_plugins' );
            foreach ( $active_plugins as $active_path => $active_plugin ) {
                
                if ( is_plugin_active_for_network( $active_path ) ) {
                    $string = explode( '/', $active_path );
                    $pluginname = $string[0];
                    if ( isset( $plugin_supports[$pluginname] ) ) {
                        
                        if ( $plugin_supports[$pluginname] != '' ) {
                            wp_register_style(
                                'wp-adminify_site-wide_' . $pluginname . '_css',
                                $plugin_supports[$pluginname],
                                array(),
                                WP_ADMINIFY_VER
                            );
                            wp_enqueue_style( 'wp-adminify_site-wide_' . $pluginname . '_css' );
                        }
                    
                    }
                }
            
            }
        }
        
        // Check Plugin Activated for Individual Sites
        $activeplugins = get_option( 'active_plugins' );
        foreach ( $activeplugins as $plugin ) {
            
            if ( Utils::is_plugin_active( $plugin ) ) {
                $string = explode( '/', $plugin );
                $pluginname = $string[0];
                if ( isset( $plugin_supports[$pluginname] ) ) {
                    
                    if ( $plugin_supports[$pluginname] != '' ) {
                        wp_register_style(
                            'wp-adminify_' . $pluginname . '_css',
                            $plugin_supports[$pluginname],
                            array(),
                            WP_ADMINIFY_VER
                        );
                        wp_enqueue_style( 'wp-adminify_' . $pluginname . '_css' );
                    }
                
                }
            }
        
        }
    }

}