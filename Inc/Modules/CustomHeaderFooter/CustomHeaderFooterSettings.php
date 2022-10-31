<?php

namespace WPAdminify\Inc\Modules\CustomHeaderFooter;

use  WPAdminify\Inc\Utils ;
// no direct access allowed
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * WPAdminify
 *
 * @package Module: Dashboard Widget
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */
class CustomHeaderFooterSettings extends CustomHeaderFooterModel
{
    public function __construct()
    {
        // this should be first so the default values get stored
        $this->custom_header_footer_settings();
        parent::__construct( (array) get_option( $this->prefix ) );
    }
    
    public function get_defaults()
    {
        return [
            'custom_scripts' => [
            'title'             => '',
            'display_on'        => 'full_site',
            'custom_posts'      => '',
            'custom_category'   => '',
            'custom_post_types' => '',
            'custom_pages'      => '',
            'custom_tags'       => '',
            'location'          => 'header',
            'device_type'       => 'all_devices',
            'script_type'       => 'css',
            'custom_js'         => '<script>
    ;(function($) {
        "use strict";
        $(document).ready( function() {
            // Write your Dashboard Widget JS code here
        });
    })( jQuery );
</script>',
            'custom_css'        => '<style>
    /* Write your Dashboard Widget CSS code here */
</style>',
        ],
        ];
    }
    
    /**
     * Settings Fields
     *
     * @return void
     */
    public function custom_header_footer_setting_fields( &$fields )
    {
        $fields[] = [
            'id'      => 'title',
            'type'    => 'text',
            'title'   => __( 'Snippet Title', 'adminify' ),
            'default' => $this->get_default_field( 'custom_scripts' )['title'],
        ];
        $fields[] = [
            'id'          => 'display_on',
            'type'        => 'select',
            'title'       => __( 'Display on', 'adminify' ),
            'placeholder' => __( 'Select an option', 'adminify' ),
            'options'     => [
            'full_site'        => __( 'Full Site', 'adminify' ),
            'posts_pro'        => __( 'Specific Posts (Pro)', 'adminify' ),
            'pages_pro'        => __( 'Specific Page (Pro)', 'adminify' ),
            'categories_pro'   => __( 'Specific Categories (Pro)', 'adminify' ),
            'custom_posts_pro' => __( 'Specific Post Types (Pro)', 'adminify' ),
            'tags_pro'         => __( 'Specific Tags (Pro)', 'adminify' ),
        ],
            'default'     => $this->get_default_field( 'custom_scripts' )['display_on'],
        ];
        $fields[] = [
            'id'      => 'location',
            'type'    => 'button_set',
            'title'   => __( 'Location', 'adminify' ),
            'options' => [
            'header'             => __( 'Header', 'adminify' ),
            'footer'             => __( 'Footer', 'adminify' ),
            'content_before_pro' => __( 'Before Content (Pro)', 'adminify' ),
            'content_after_pro'  => __( 'After Content (Pro)', 'adminify' ),
        ],
            'default' => $this->get_default_field( 'custom_scripts' )['location'],
        ];
        $fields[] = [
            'id'      => 'device_type_notice',
            'type'    => 'notice',
            'title'   => __( 'Display Device', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
        $fields[] = [
            'id'      => 'script_type',
            'type'    => 'button_set',
            'title'   => __( 'Snippet Type', 'adminify' ),
            'options' => [
            'css' => 'CSS',
            'js'  => 'JS',
        ],
            'default' => $this->get_default_field( 'custom_scripts' )['script_type'],
        ];
        $fields[] = [
            'id'         => 'custom_js',
            'type'       => 'code_editor',
            'title'      => __( 'Custom JavaScript', 'adminify' ),
            'subtitle'   => __( 'Add Custom script inside <strong>&lt;script&gt;&lt;/script&gt;</strong> tag.', 'adminify' ),
            'settings'   => [
            'theme' => 'dracula',
            'mode'  => 'htmlmixed',
        ],
            'sanitize'   => false,
            'dependency' => [ 'script_type', '==', 'js' ],
            'default'    => $this->get_default_field( 'custom_scripts' )['custom_js'],
        ];
        $fields[] = [
            'id'         => 'custom_css',
            'type'       => 'code_editor',
            'title'      => __( 'Custom CSS', 'adminify' ),
            'subtitle'   => __( 'Write CSS code inside <strong>&lt;style&gt;&lt;/style&gt;</strong> tag.', 'adminify' ),
            'settings'   => [
            'theme' => 'monokai',
            'mode'  => 'htmlmixed',
        ],
            'sanitize'   => false,
            'dependency' => [ 'script_type', '==', 'css' ],
            'default'    => $this->get_default_field( 'custom_scripts' )['custom_css'],
        ];
    }
    
    public function custom_header_footer_settings()
    {
        if ( !class_exists( 'ADMINIFY' ) ) {
            return;
        }
        // WP Adminify Custom Header & Footer Options
        \ADMINIFY::createOptions( $this->prefix, [
            'framework_title'         => 'WP Adminify Custom CSS/JS <small>by WP Adminify</small>',
            'framework_class'         => 'adminify-custom-css-js',
            'menu_title'              => 'Custom CSS / JS',
            'menu_slug'               => 'adminify-custom-css-js',
            'menu_type'               => 'submenu',
            'menu_capability'         => 'manage_options',
            'menu_icon'               => '',
            'menu_position'           => 54,
            'menu_hidden'             => false,
            'menu_parent'             => 'wp-adminify-settings',
            'footer_text'             => ' ',
            'footer_after'            => ' ',
            'footer_credit'           => ' ',
            'show_bar_menu'           => false,
            'show_sub_menu'           => false,
            'show_in_network'         => false,
            'show_in_customizer'      => false,
            'show_search'             => false,
            'show_reset_all'          => false,
            'show_reset_section'      => false,
            'show_footer'             => true,
            'show_all_options'        => true,
            'show_form_warning'       => true,
            'sticky_header'           => false,
            'save_defaults'           => true,
            'ajax_save'               => true,
            'admin_bar_menu_icon'     => '',
            'admin_bar_menu_priority' => 45,
            'database'                => 'options',
            'transient_time'          => 0,
            'enqueue_webfont'         => true,
            'async_webfont'           => false,
            'output_css'              => false,
            'nav'                     => 'normal',
            'theme'                   => 'dark',
            'class'                   => 'wp-adminify-custom-css-js',
        ] );
        $fields = [];
        $this->custom_header_footer_setting_fields( $fields );
        // Custom CSS/JS Settings
        \ADMINIFY::createSection( $this->prefix, [
            'title'  => __( 'Others', 'adminify' ),
            'icon'   => 'fas fa-bolt',
            'fields' => [ [
            'type'    => 'subheading',
            'content' => Utils::adminfiy_help_urls(
            __( 'Header/Footer Snippets', 'adminify' ),
            'https://wpadminify.com/kb/how-to-add-custom-css-or-js-in-full-site-or-specific-page/',
            'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
            'https://www.facebook.com/groups/jeweltheme',
            'https://wpadminify.com/support/header-footer-scripts/'
        ),
        ], [
            'id'                     => 'custom_scripts',
            'type'                   => 'group',
            'title'                  => '',
            'accordion_title_prefix' => __( 'Snippet Name: ', 'adminify' ),
            'accordion_title_number' => true,
            'accordion_title_auto'   => true,
            'button_title'           => __( 'Add New Snippet', 'adminify' ),
            'fields'                 => $fields,
        ] ],
        ] );
    }

}