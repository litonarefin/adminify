<?php

namespace WPAdminify\Inc\Classes;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Admin\AdminSettings ;
use  WPAdminify\Inc\Classes\OutputCSS_Body ;
use  WPAdminify\Inc\Admin\AdminSettingsModel ;
// no direct access allowed
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class OutputCSS extends AdminSettingsModel
{
    public  $url ;
    public  $options ;
    public  $admin_bar_options ;
    public  $custom_css_js ;
    public function __construct()
    {
        $this->options = (array) AdminSettings::get_instance()->get( 'menu_layout_settings' );
        $this->admin_bar_options = (array) AdminSettings::get_instance()->get( 'admin_bar_settings' );
        $this->admin_bar_logo_light = (array) AdminSettings::get_instance()->get( 'admin_bar_light_mode' );
        $this->admin_bar_logo_dark = (array) AdminSettings::get_instance()->get( 'admin_bar_dark_mode' );
        $this->custom_css_js = AdminSettings::get_instance()->get();
        add_action( 'admin_enqueue_scripts', array( $this, 'jltwp_adminify_output_styles' ), 100 );
        add_action( 'admin_footer', array( $this, 'jltwp_adminify_output_scripts' ), 100 );
        add_filter( 'admin_body_class', array( $this, 'add_body_classes' ) );
        new OutputCSS_Body();
    }
    
    public function add_body_classes( $classes )
    {
        $options = (array) AdminSettings::get_instance()->get();
        $color_mode = ( !empty($options['admin_bar_mode']) ? $options['admin_bar_mode'] : 'light' );
        $color_preset = ( !empty($options['adminify_theme']) ? $options['adminify_theme'] : 'preset1' );
        $icon_style = ( !empty($this->options['icon_style']) ? $this->options['icon_style'] : 'classic' );
        $menu_hover_submenu = ( !empty($this->options['menu_hover_submenu']) ? $this->options['menu_hover_submenu'] : 'classic' );
        $menu_mode = ( !empty($this->options['menu_mode']) ? $this->options['menu_mode'] : 'classic' );
        $bodyclass = '';
        if ( $color_mode == 'light' ) {
            $bodyclass .= ' adminify-light-mode ';
        }
        if ( $color_mode == 'dark' ) {
            $bodyclass .= ' adminify-dark-mode ';
        }
        if ( $color_preset != 'preset1' ) {
            $bodyclass .= ' color-preset-adminify-icon-white';
        }
        // Submenu Hover Style
        
        if ( $menu_hover_submenu == 'classic' ) {
            $bodyclass .= ' adminify-default-v-menu ';
        } elseif ( $menu_hover_submenu == 'accordion' ) {
            $bodyclass .= ' adminify-accordion-v-menu ';
        } elseif ( $menu_hover_submenu == 'toggle' ) {
            $bodyclass .= ' adminify-toggle-v-menu ';
        }
        
        // Active Menu Style
        
        if ( $menu_mode == 'rounded' || $menu_mode == 'icon_menu' && $icon_style == 'rounded' ) {
            $bodyclass .= ' adminify-rounded-v-menu ';
            $bodyclass .= ' adminify-round-open-menu ';
        }
        
        return $classes . $bodyclass;
    }
    
    public function jltwp_adminify_output_styles()
    {
        $jltwp_adminify_output_css = '';
        // Welcome Panel Styles.
        $latest_wordpress_version = get_bloginfo( 'version' );
        if ( $latest_wordpress_version >= '5.0' && $latest_wordpress_version <= '5.8.4' ) {
            $jltwp_adminify_output_css .= '.wp-adminify #wpbody-content .button { text-shadow: none !important }';
        }
        
        if ( $latest_wordpress_version >= '5.9' && $latest_wordpress_version <= '5.9.3' || $latest_wordpress_version >= '6.0' ) {
            $jltwp_adminify_output_css .= '.wp-adminify #wpbody-content .welcome-panel .welcome-panel-header h2 { font-size: 30px;line-height: 36px; }';
            $jltwp_adminify_output_css .= '.wp-adminify #wpbody-content .welcome-panel .welcome-panel-header p { font-size: 16px; }';
            $jltwp_adminify_output_css .= '.wp-adminify #wpbody-content .welcome-panel-header { padding: 70px 408px 70px 48px; }';
            $jltwp_adminify_output_css .= '.welcome-panel a { text-decoration: underline; }';
        }
        
        
        if ( $latest_wordpress_version >= '6.0' ) {
            $jltwp_adminify_output_css .= '.wp-adminify #wpbody-content .welcome-panel .welcome-panel-header p a{ color:#3c434a !important; }';
            $jltwp_adminify_output_css .= '.wp-adminify #wpbody-content .welcome-panel-header { padding: 80px 408px 80px 48px; }';
        }
        
        // Logo Text Light
        if ( !empty($this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['font-size']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify .navbar .wp-adminify-site-name { font-size: ' . $this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['font-size'] . 'px !important; }';
        }
        if ( !empty($this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['font-family']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify .navbar .wp-adminify-site-name { font-family: ' . $this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['font-family'] . '; }';
        }
        if ( !empty($this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['font-weight']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify .navbar .wp-adminify-site-name { font-weight: ' . $this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['font-weight'] . ' !important; }';
        }
        if ( !empty($this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['text-transform']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify .navbar .wp-adminify-site-name { text-transform: ' . $this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['text-transform'] . '; }';
        }
        if ( !empty($this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['text-decoration']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify .navbar .wp-adminify-site-name { text-decoration: ' . $this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['text-decoration'] . '; }';
        }
        if ( !empty($this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['line-height']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify .navbar .wp-adminify-site-name { line-height: ' . $this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['line-height'] . 'px !important; }';
        }
        if ( !empty($this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['letter-spacing']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify .navbar .wp-adminify-site-name { letter-spacing: ' . $this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['letter-spacing'] . 'px; }';
        }
        if ( !empty($this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['word-spacing']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify .navbar .wp-adminify-site-name { word-spacing: ' . $this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['word-spacing'] . 'px; }';
        }
        if ( !empty($this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['color']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify .navbar .wp-adminify-site-name { color: ' . $this->admin_bar_logo_light['admin_bar_light_logo_text_typo']['color'] . ' !important; }';
        }
        // Logo Text Dark
        if ( !empty($this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['font-size']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-dark-mode .navbar .wp-adminify-site-name { font-size: ' . $this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['font-size'] . 'px !important; }';
        }
        if ( !empty($this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['font-family']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-dark-mode .navbar .wp-adminify-site-name { font-family: ' . $this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['font-family'] . '; }';
        }
        if ( !empty($this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['font-weight']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-dark-mode .navbar .wp-adminify-site-name { font-weight: ' . $this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['font-weight'] . ' !important; }';
        }
        if ( !empty($this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['text-transform']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-dark-mode .navbar .wp-adminify-site-name { text-transform: ' . $this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['text-transform'] . '; }';
        }
        if ( !empty($this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['text-decoration']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-dark-mode .navbar .wp-adminify-site-name { text-decoration: ' . $this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['text-decoration'] . '; }';
        }
        if ( !empty($this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['line-height']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-dark-mode .navbar .wp-adminify-site-name { line-height: ' . $this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['line-height'] . 'px !important; }';
        }
        if ( !empty($this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['letter-spacing']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-dark-mode .navbar .wp-adminify-site-name { letter-spacing: ' . $this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['letter-spacing'] . 'px; }';
        }
        if ( !empty($this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['word-spacing']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-dark-mode .navbar .wp-adminify-site-name { word-spacing: ' . $this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['word-spacing'] . 'px; }';
        }
        if ( !empty($this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['color']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-dark-mode .navbar .wp-adminify-site-name { color: ' . $this->admin_bar_logo_dark['admin_bar_dark_logo_text_typo']['color'] . ' !important; }';
        }
        // Admin Bar Typography Settings
        // font size
        
        if ( !empty($this->admin_bar_options['admin_bar_font_typography']['font-size']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-top_bar #wpadminbar .ab-top-menu > li > a.ab-item, .wp-adminify.adminify-top_bar #wpadminbar .ab-top-menu > li > a.ab-item > .ab-label, .wp-adminify.adminify-top_bar #wpadminbar .ab-top-menu > li > a.ab-item > .ab-icon:before { font-size: ' . ($this->admin_bar_options['admin_bar_font_typography']['font-size'] - 1) . 'px !important; }';
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-top_bar #wpadminbar .ab-submenu > li > a.ab-item, .wp-adminify.adminify-top_bar #wpadminbar .ab-submenu > li > a.ab-item span { font-size: ' . $this->admin_bar_options['admin_bar_font_typography']['font-size'] . 'px !important; }';
        }
        
        // text align
        if ( !empty($this->admin_bar_options['admin_bar_font_typography']['text-align']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-top_bar #wpadminbar .ab-top-menu > li > a.ab-item, .wp-adminify.adminify-top_bar #wpadminbar .ab-top-menu > li > a.ab-item > .ab-label, .wp-adminify.adminify-top_bar #wpadminbar .ab-submenu > li > a.ab-item, .wp-adminify.adminify-top_bar #wpadminbar .ab-submenu > li > a.ab-item span { text-align: ' . $this->admin_bar_options['admin_bar_font_typography']['text-align'] . '; }';
        }
        // text transform
        if ( !empty($this->admin_bar_options['admin_bar_font_typography']['text-transform']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-top_bar #wpadminbar .ab-top-menu > li > a.ab-item, .wp-adminify.adminify-top_bar #wpadminbar .ab-top-menu > li > a.ab-item > .ab-label, .wp-adminify.adminify-top_bar #wpadminbar .ab-submenu > li > a.ab-item, .wp-adminify.adminify-top_bar #wpadminbar .ab-submenu > li > a.ab-item span { text-transform: ' . $this->admin_bar_options['admin_bar_font_typography']['text-transform'] . '; }';
        }
        // text decoration
        if ( !empty($this->admin_bar_options['admin_bar_font_typography']['text-decoration']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-top_bar #wpadminbar .ab-top-menu > li > a.ab-item, .wp-adminify.adminify-top_bar #wpadminbar .ab-top-menu > li > a.ab-item > .ab-label, .wp-adminify.adminify-top_bar #wpadminbar .ab-submenu > li > a.ab-item, .wp-adminify.adminify-top_bar #wpadminbar .ab-submenu > li > a.ab-item span { text-decoration: ' . $this->admin_bar_options['admin_bar_font_typography']['text-decoration'] . '; }';
        }
        // line height
        if ( !empty($this->admin_bar_options['admin_bar_font_typography']['line-height']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-top_bar #wpadminbar .ab-top-menu > li > a.ab-item, .wp-adminify.adminify-top_bar #wpadminbar .ab-top-menu > li > a.ab-item > .ab-label, .wp-adminify.adminify-top_bar #wpadminbar .ab-submenu > li > a.ab-item, .wp-adminify.adminify-top_bar #wpadminbar .ab-submenu > li > a.ab-item span { line-height: ' . $this->admin_bar_options['admin_bar_font_typography']['line-height'] . 'px !important; }';
        }
        // letter spacing
        if ( !empty($this->admin_bar_options['admin_bar_font_typography']['letter-spacing']) ) {
            $jltwp_adminify_output_css .= '.wp-adminify.adminify-top_bar #wpadminbar .ab-top-menu > li > a.ab-item, .wp-adminify.adminify-top_bar #wpadminbar .ab-top-menu > li > a.ab-item > .ab-label, .wp-adminify.adminify-top_bar #wpadminbar .ab-submenu > li > a.ab-item, .wp-adminify.adminify-top_bar #wpadminbar .ab-submenu > li > a.ab-item span { letter-spacing: ' . $this->admin_bar_options['admin_bar_font_typography']['letter-spacing'] . 'px !important; }';
        }
        // Menu Styles
        // Typography Settings
        // if (!empty($this->options['menu_styles']['menu_typography']['font-family'])) {
        // if ($this->options['layout_type'] === 'vertical') {
        // $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.menu-top, .wp-adminify #adminmenu .wp-submenu li a { font-family: ' . $this->options['menu_styles']['menu_typography']['font-family'] . '}';
        // }
        // if (jltwp_adminify()->can_use_premium_code__premium_only()) {
        // if ($this->options['layout_type'] === 'horizontal') {
        // $jltwp_adminify_output_css .= '.wp-adminify.horizontal-menu .wp-adminify-horizontal-menu ul.horizontal-menu li a, .wp-adminify.horizontal-menu .wp-adminify-horizontal-menu ul.horizontal-menu .wp-submenu li a { font-family: ' . $this->options['menu_styles']['menu_typography']['font-family'] . '}';
        // }
        // }
        // }
        if ( !empty($this->options['menu_styles']['menu_typography']['font-weight']) ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.menu-top, .wp-adminify #adminmenu .wp-submenu li a { font-weight: ' . $this->options['menu_styles']['menu_typography']['font-weight'] . '}';
            }
        }
        if ( !empty($this->options['menu_styles']['menu_typography']['text-align']) ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.menu-top, .wp-adminify #adminmenu .wp-submenu li a { text-align: ' . $this->options['menu_styles']['menu_typography']['text-align'] . '}';
            }
        }
        if ( !empty($this->options['menu_styles']['menu_typography']['text-transform']) ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.menu-top, .wp-adminify #adminmenu .wp-submenu li a { text-transform: ' . $this->options['menu_styles']['menu_typography']['text-transform'] . '}';
            }
        }
        if ( !empty($this->options['menu_styles']['menu_typography']['font-size']) ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.menu-top, .wp-adminify #adminmenu .wp-submenu li a { font-size: ' . $this->options['menu_styles']['menu_typography']['font-size'] . 'px;}';
            }
        }
        if ( !empty($this->options['menu_styles']['menu_typography']['line-height']) ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.menu-top, .wp-adminify #adminmenu .wp-submenu li a { line-height: ' . $this->options['menu_styles']['menu_typography']['line-height'] . 'px;}';
            }
        }
        if ( !empty($this->options['menu_styles']['menu_typography']['letter-spacing']) ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.menu-top, .wp-adminify #adminmenu .wp-submenu li a { letter-spacing: ' . $this->options['menu_styles']['menu_typography']['letter-spacing'] . 'px;}';
            }
        }
        if ( !empty($this->options['menu_styles']['menu_typography']['text-decoration']) ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.menu-top, .wp-adminify #adminmenu .wp-submenu li a { text-decoration: ' . $this->options['menu_styles']['menu_typography']['text-decoration'] . ';}';
            }
        }
        // Menu Wrapper Padding
        if ( !empty($this->options['menu_styles']['menu_wrapper_padding']['top']) && $this->options['menu_styles']['menu_wrapper_padding']['top'] !== '' ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp_adminify_sidebar_admin-menu { padding-top: ' . esc_attr( $this->options['menu_styles']['menu_wrapper_padding']['top'] ) . $this->options['menu_styles']['menu_wrapper_padding']['unit'] . ';}';
            }
        }
        if ( !empty($this->options['menu_styles']['menu_wrapper_padding']['right']) && $this->options['menu_styles']['menu_wrapper_padding']['right'] !== '' ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp_adminify_sidebar_admin-menu { padding-right: ' . esc_attr( $this->options['menu_styles']['menu_wrapper_padding']['right'] ) . $this->options['menu_styles']['menu_wrapper_padding']['unit'] . ';}';
            }
        }
        if ( !empty($this->options['menu_styles']['menu_wrapper_padding']['bottom']) && $this->options['menu_styles']['menu_wrapper_padding']['bottom'] !== '' ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp_adminify_sidebar_admin-menu { padding-bottom: ' . esc_attr( $this->options['menu_styles']['menu_wrapper_padding']['bottom'] ) . $this->options['menu_styles']['menu_wrapper_padding']['unit'] . ';}';
            }
        }
        if ( !empty($this->options['menu_styles']['menu_wrapper_padding']['left']) && $this->options['menu_styles']['menu_wrapper_padding']['left'] !== '' ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp_adminify_sidebar_admin-menu { padding-left: ' . esc_attr( $this->options['menu_styles']['menu_wrapper_padding']['left'] ) . $this->options['menu_styles']['menu_wrapper_padding']['unit'] . ';}';
            }
        }
        // Sub Menu Wrapper Padding
        if ( !empty($this->options['menu_styles']['submenu_wrapper_padding']['top']) && $this->options['menu_styles']['submenu_wrapper_padding']['top'] !== '' ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top.wp-menu-open .wp-submenu { padding-top: ' . esc_attr( $this->options['menu_styles']['submenu_wrapper_padding']['top'] ) . $this->options['menu_styles']['submenu_wrapper_padding']['unit'] . ';}';
            }
        }
        if ( !empty($this->options['menu_styles']['submenu_wrapper_padding']['right']) && $this->options['menu_styles']['submenu_wrapper_padding']['right'] !== '' ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top.wp-menu-open .wp-submenu { padding-right: ' . esc_attr( $this->options['menu_styles']['submenu_wrapper_padding']['right'] ) . $this->options['menu_styles']['submenu_wrapper_padding']['unit'] . ';}';
            }
        }
        if ( !empty($this->options['menu_styles']['submenu_wrapper_padding']['bottom']) && $this->options['menu_styles']['submenu_wrapper_padding']['bottom'] !== '' ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top.wp-menu-open .wp-submenu { padding-bottom: ' . esc_attr( $this->options['menu_styles']['submenu_wrapper_padding']['bottom'] ) . $this->options['menu_styles']['submenu_wrapper_padding']['unit'] . ';}';
            }
        }
        if ( !empty($this->options['menu_styles']['submenu_wrapper_padding']['left']) && $this->options['menu_styles']['submenu_wrapper_padding']['left'] !== '' ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top.wp-menu-open .wp-submenu { padding-left: ' . esc_attr( $this->options['menu_styles']['submenu_wrapper_padding']['left'] ) . $this->options['menu_styles']['submenu_wrapper_padding']['unit'] . ';}';
            }
        }
        // Vertical Menu Parent Padding
        if ( !empty($this->options['layout_type']) === 'vertical' ) {
            if ( !empty($this->options['menu_styles']['menu_vertical_padding']) ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp-submenu-wrap, .wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.menu-top { padding:' . esc_attr( $this->options['menu_styles']['menu_vertical_padding'] ) . 'px 0;}';
            }
        }
        // Submenu Item Padding
        if ( !empty($this->options['layout_type']) === 'vertical' ) {
            // Sub Menu Vertical Padding
            if ( !empty($this->options['menu_styles']['submenu_vertical_space']) ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp-submenu li a { padding:' . esc_attr( $this->options['menu_styles']['submenu_vertical_space'] ) . 'px 0px !important;}';
            }
        }
        // Parent Menu Colors
        // Background Color
        if ( !empty($this->options['menu_styles']['parent_menu_colors']['wrap_bg']) ) {
            
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu, .wp-adminify #adminmenuback, .wp-adminify #adminmenuwrap, .wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top.wp-menu-open { background:' . esc_attr( $this->options['menu_styles']['parent_menu_colors']['wrap_bg'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify.adminify-round-open-menu #adminmenu .wp_adminify_admin-menu li.wp-adminify-active > a.menu-top::before, .wp-adminify.adminify-round-open-menu #adminmenu .wp_adminify_admin-menu li.wp-adminify-active > a.menu-top:after{ background-color:' . esc_attr( $this->options['menu_styles']['parent_menu_colors']['wrap_bg'] ) . ' !important;}';
            }
        
        }
        // Menu Item Hover Background
        if ( !empty($this->options['menu_styles']['parent_menu_colors']['hover_bg']) ) {
            
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.menu-top:hover { background:' . esc_attr( $this->options['menu_styles']['parent_menu_colors']['hover_bg'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify.folded #adminmenu .wp_adminify_admin-menu li.menu-top:hover { background: inherit !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify.folded #adminmenu .wp_adminify_admin-menu li.menu-top:hover a.menu-top .wp-adminify-icon-button:not(.svg-image-icon) { background: inherit !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify.folded #adminmenu .wp_adminify_admin-menu li.menu-top:hover a.menu-top .wp-adminify-icon-button.svg-image-icon { background-color: transparent !important;}';
            }
        
        }
        // Text Color
        if ( !empty($this->options['menu_styles']['parent_menu_colors']['text_color']) ) {
            
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a, .wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a .wp-adminify-icon-button:before { color:' . esc_attr( $this->options['menu_styles']['parent_menu_colors']['text_color'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a .wp-adminify-icon-button svg path { fill:' . esc_attr( $this->options['menu_styles']['parent_menu_colors']['text_color'] ) . ' !important;}';
            }
        
        }
        // Text Color
        if ( !empty($this->options['menu_styles']['parent_menu_colors']['text_hover']) ) {
            
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.menu-top:hover, .wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.menu-top:hover .wp-adminify-icon-button:before ,.wp-adminify.folded.adminify-rounded-v-menu #adminmenu .wp_adminify_admin-menu li.menu-top:hover a.menu-top .wp-adminify-icon-button:before{ color:' . esc_attr( $this->options['menu_styles']['parent_menu_colors']['text_hover'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.menu-top:hover .wp-adminify-icon-button svg path { fill:' . esc_attr( $this->options['menu_styles']['parent_menu_colors']['text_hover'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.menu-top.toplevel_page_wp-adminify-settings:hover .wp-adminify-icon-button {  filter: none !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify.folded #adminmenu .wp_adminify_admin-menu li.menu-top:hover a.menu-top:before{ background-color:' . esc_attr( $this->options['menu_styles']['parent_menu_colors']['text_hover'] ) . ' !important;}';
            }
        
        }
        // Active Menu Background Color
        if ( !empty($this->options['menu_styles']['parent_menu_colors']['active_bg']) ) {
            
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify:not(.adminify-round-open-menu) #adminmenu .wp_adminify_admin-menu li.menu-top.wp-adminify-active > a { background:' . esc_attr( $this->options['menu_styles']['parent_menu_colors']['active_bg'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify.adminify-round-open-menu #adminmenu .wp_adminify_admin-menu li.wp-adminify-active > a.menu-top,.wp-adminify.adminify-round-open-menu #adminmenu .wp_adminify_admin-menu li.wp-adminify-active:before, .wp-adminify.adminify-round-open-menu #adminmenu .wp_adminify_admin-menu li.wp-adminify-active:after{ background-color:' . esc_attr( $this->options['menu_styles']['parent_menu_colors']['active_bg'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify.folded #adminmenu .wp_adminify_admin-menu li.wp-adminify-active a.menu-top .wp-adminify-icon-button:not(.svg-image-icon) { background: inherit !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify.folded #adminmenu .wp_adminify_admin-menu li.wp-adminify-active a.menu-top .wp-adminify-icon-button.svg-image-icon { background-color: inherit !important;}';
            }
        
        }
        if ( !empty($this->options['menu_styles']['parent_menu_colors']['active_color']) ) {
            
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.wp-adminify-active, .wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.wp-adminify-active .wp-adminify-icon-button:before, .wp-adminify.folded.adminify-rounded-v-menu #adminmenu .wp_adminify_admin-menu li.menu-top.wp-adminify-active a.menu-top .wp-adminify-icon-button:before{ color:' . esc_attr( $this->options['menu_styles']['parent_menu_colors']['active_color'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.wp-adminify-active .wp-adminify-icon-button svg path { fill:' . esc_attr( $this->options['menu_styles']['parent_menu_colors']['active_color'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top > a.wp-adminify-active.toplevel_page_wp-adminify-settings .wp-adminify-icon-button {  filter: none !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top.wp-adminify-active > a:before {  background-color: ' . esc_attr( $this->options['menu_styles']['parent_menu_colors']['active_color'] ) . ' !important;}';
            }
        
        }
        // Sub Menu Colors
        if ( !empty($this->options['menu_styles']['sub_menu_colors']['wrap_bg']) ) {
            
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top .wp-submenu, .wp-adminify #adminmenu .wp-not-current-submenu .wp-submenu { background:' . esc_attr( $this->options['menu_styles']['sub_menu_colors']['wrap_bg'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top .wp-submenu, .wp-adminify #adminmenu .wp-not-current-submenu .wp-submenu  { border-top-right-radius: 19px !important;}';
            }
        
        }
        if ( !empty($this->options['menu_styles']['sub_menu_colors']['hover_bg']) ) {
            
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top .wp-submenu li a:hover { background:' . esc_attr( $this->options['menu_styles']['sub_menu_colors']['hover_bg'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top.wp-menu-open .wp-submenu li a:hover { background:' . esc_attr( $this->options['menu_styles']['sub_menu_colors']['hover_bg'] ) . ' !important;}';
            }
        
        }
        if ( !empty($this->options['menu_styles']['sub_menu_colors']['text_color']) ) {
            
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top .wp-submenu li a { color:' . esc_attr( $this->options['menu_styles']['sub_menu_colors']['text_color'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top.wp-menu-open .wp-submenu li a { color:' . esc_attr( $this->options['menu_styles']['sub_menu_colors']['text_color'] ) . ' !important;}';
            }
        
        }
        if ( !empty($this->options['menu_styles']['sub_menu_colors']['text_hover']) ) {
            
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top .wp-submenu li a:hover { color:' . esc_attr( $this->options['menu_styles']['sub_menu_colors']['text_hover'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top.wp-menu-open .wp-submenu li a:hover { color:' . esc_attr( $this->options['menu_styles']['sub_menu_colors']['text_hover'] ) . ' !important;}';
            }
        
        }
        if ( !empty($this->options['menu_styles']['sub_menu_colors']['active_bg']) ) {
            
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top .wp-submenu li a.current { background:' . esc_attr( $this->options['menu_styles']['sub_menu_colors']['active_bg'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top.wp-menu-open .wp-submenu li a.current { background:' . esc_attr( $this->options['menu_styles']['sub_menu_colors']['active_bg'] ) . ' !important;}';
            }
        
        }
        if ( !empty($this->options['menu_styles']['sub_menu_colors']['active_color']) ) {
            
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top .wp-submenu li a.current { color:' . esc_attr( $this->options['menu_styles']['sub_menu_colors']['active_color'] ) . ' !important;}';
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li.menu-top.wp-menu-open .wp-submenu li a.current { color:' . esc_attr( $this->options['menu_styles']['sub_menu_colors']['active_color'] ) . ' !important;}';
            }
        
        }
        // Notification Counter
        // Background Color
        if ( !empty($this->options['menu_styles']['notif_colors']['notif_bg']) ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .wp_adminify_admin-menu li .awaiting-mod, .wp-adminify #adminmenu .wp_adminify_admin-menu li .update-plugins, .wp-adminify #adminmenu .wp_adminify_admin-menu #sidemenu li a span.update-plugins, .wp-adminify #adminmenu .wp_adminify_admin-menu li a.wp-has-current-submenu .update-plugins
            { background-color:' . esc_attr( $this->options['menu_styles']['notif_colors']['notif_bg'] ) . ' !important;}';
            }
        }
        if ( !empty($this->options['menu_styles']['notif_colors']['notif_color']) ) {
            if ( $this->options['layout_type'] === 'vertical' ) {
                $jltwp_adminify_output_css .= '.wp-adminify #adminmenu .awaiting-mod, .wp-adminify #adminmenu .update-plugins, .wp-adminify #sidemenu li a span.update-plugins, .wp-adminify #adminmenu li a.wp-has-current-submenu .update-plugins { color:' . esc_attr( $this->options['menu_styles']['notif_colors']['notif_color'] ) . ';}';
            }
        }
        if ( Utils::is_plugin_active( 'brizy/brizy.php' ) ) {
            $jltwp_adminify_output_css .= '.brz-review-notice-container a { padding-left: 14px !important; }';
        }
        // Combine the values from above and minifiy them.
        $jltwp_adminify_output_css = preg_replace( '#/\\*.*?\\*/#s', '', $jltwp_adminify_output_css );
        $jltwp_adminify_output_css = preg_replace( '/\\s*([{}|:;,])\\s+/', '$1', $jltwp_adminify_output_css );
        $jltwp_adminify_output_css = preg_replace( '/\\s\\s+(.*)/', '$1', $jltwp_adminify_output_css );
        $adminify_ui = AdminSettings::get_instance()->get( 'admin_ui' );
        
        if ( !empty($adminify_ui) ) {
            wp_add_inline_style( 'wp-adminify-admin', wp_strip_all_tags( $jltwp_adminify_output_css ) );
        } else {
            wp_add_inline_style( 'wp-adminify-default-ui', wp_strip_all_tags( $jltwp_adminify_output_css ) );
        }
        
        // Custom CSS
        
        if ( !empty($this->custom_css_js['custom_css']) ) {
            $stat_tag = '/<style>/m';
            $end_tag = '#</style>#m';
            $result_start = preg_match( $stat_tag, $this->custom_css_js['custom_css'] );
            $result_end = preg_match( $end_tag, $this->custom_css_js['custom_css'] );
            echo  "\n<!-- Start of WP Adminify - Admin Area Custom CSS -->\n" ;
            echo  ( !$result_start && !$result_end ? '<style>' : '' ) ;
            echo  Utils::wp_kses_custom( "\n{$this->custom_css_js['custom_css']}\n" ) ;
            echo  ( !$result_start && !$result_end ? '</style>' : '' ) ;
            echo  "\n<!-- /End of WP Adminify - Admin Area Custom CSS -->\n" ;
        }
    
    }
    
    public function jltwp_adminify_output_scripts()
    {
        // Custom JS
        
        if ( !empty($this->custom_css_js['custom_js']) ) {
            $stat_tag = '/<script>/m';
            $end_tag = '#</script>#m';
            $result_start = preg_match( $stat_tag, $this->custom_css_js['custom_js'] );
            $result_end = preg_match( $end_tag, $this->custom_css_js['custom_js'] );
            echo  "\n<!-- Start of WP Adminify - Admin Area Custom JS -->\n" ;
            echo  ( !$result_start && !$result_end ? '<script>' : '' ) ;
            echo  Utils::wp_kses_custom( "\n{$this->custom_css_js['custom_js']}\n" ) ;
            echo  ( !$result_start && !$result_end ? '</script>' : '' ) ;
            echo  "\n<!-- /End of WP Adminify - Admin Area Custom JS -->\n" ;
        }
    
    }

}