<?php

namespace WPAdminify\Inc\Modules\SidebarGenerator;

use WPAdminify\Inc\Utils;
// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WPAdminify
 * @package Module: Sidebar Generator
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class Sidebar_Generator_Settings extends Sidebar_Generator_Model
{
    public function __construct()
    {
        // this should be first so the default values get stored
        $this->sidebar_generator_settings();
        parent::__construct((array) get_option($this->prefix));
    }


    protected function get_defaults()
    {
        return [
            'sidebar_title' => '',
            'sidebar_desc'  => '',
        ];
    }


    public function get_sidebar_fields(&$sidebar_fields)
    {
        $sidebar_fields[] = array(
            'id'      => 'sidebar_title',
            'type'    => 'text',
            'title'   => __('Sidebar Name', 'adminify'),
            'default' => $this->get_default_field('sidebar_title'),
        );
        $sidebar_fields[] = array(
            'id'      => 'sidebar_desc',
            'type'    => 'textarea',
            'title'   => __('Sidebar Description', 'adminify'),
            'default' => $this->get_default_field('sidebar_title'),
        );
    }

    /**
     * Sidebar Generator Settings
     *
     * @return void
     */
    public function sidebar_generator_settings()
    {
        if (!class_exists('ADMINIFY')) {
            return;
        }
        // WP Adminify Sidebar Generator Settings
        \ADMINIFY::createOptions($this->prefix, array(

            // Framework Title
            'framework_title' => 'WP Adminify Sidebar Generator <small>by WP Adminify</small>',
            'framework_class' => 'wp-adminify-sidebar-generator',

            // menu settings
            'menu_title'      => 'Sidebar Generator',
            'menu_slug'       => 'wp-adminify-sidebar-generator',
            'menu_type'       => 'submenu',                         // menu, submenu, options, theme, etc.
            'menu_capability' => 'manage_options',
            'menu_icon'       => '',
            'menu_position'   => 59,
            'menu_hidden'     => false,
            'menu_parent'     => 'wp-adminify-settings',

            // footer
            'footer_text'   => ' ',
            'footer_after'  => ' ',
            'footer_credit' => ' ',

            // menu extras
            'show_bar_menu'      => false,
            'show_sub_menu'      => true,
            'show_in_network'    => false,
            'show_in_customizer' => false,

            'show_search'        => false,
            'show_reset_all'     => false,
            'show_reset_section' => false,
            'show_footer'        => true,
            'show_all_options'   => true,
            'show_form_warning'  => true,
            'sticky_header'      => false,
            'save_defaults'      => true,
            'ajax_save'          => true,

            // admin bar menu settings
            'admin_bar_menu_icon'     => '',
            'admin_bar_menu_priority' => 45,


            // database model
            'database'       => 'options',   // options, transient, theme_mod, network(multisite support)
            'transient_time' => 0,


            // typography options
            'enqueue_webfont' => true,
            'async_webfont'   => false,

            // others
            'output_css' => false,

            // theme and wrapper classname
            'nav'   => 'normal',
            'theme' => 'dark',
            'class' => 'wp-adminify-sidebar-generator',
        ));

        $sidebar_fields = [];
        $this->get_sidebar_fields($sidebar_fields);

        \ADMINIFY::createSection(
            $this->prefix,
            array(
                'title'  => __('Sidebar Generator', 'adminify'),
                'icon'   => 'fas fa-bolt',
                'fields' => array(
                    array(
                        'type'    => 'subheading',
                        'content'   => Utils::adminfiy_help_urls(
                            __('Custom Sidebar Generator', 'adminify'),
                            'https://wpadminify.com/kb/wordpress-custom-sidebar',
                            'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
                            'https://www.facebook.com/groups/jeweltheme',
                            'https://wpadminify.com/support/wp-adminify'
                        )
                    ),
                    array(
                        'id'                     => 'sidebars',
                        'type'                   => 'group',
                        'title'                  => '',
                        'accordion_title_prefix' => __('Sidebar Name: ', 'adminify'),
                        'accordion_title_number' => true,
                        'accordion_title_auto'   => true,
                        'button_title'           => __('Add New Sidebar', 'adminify'),
                        'fields'                 => $sidebar_fields
                    ),
                )
            )
        );
    }
}
