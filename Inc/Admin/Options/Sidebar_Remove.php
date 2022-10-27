<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettings;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

class Sidebar_Remove extends AdminSettingsModel
{

    public function __construct()
    {
        $this->options = []; // (array) AdminSettings::get_instance()->get('sidebar_widgets_list');
        $this->sidebar_widgets_settings();
    }

    public function get_defaults()
    {
        return [
            'widget_settings' => [
                'sidebar_widgets_list' => [],
                'sidebar_widgets_user_roles' => [],
                'sidebar_widgets_disable_gutenberg_editor' => false,
            ]
        ];
    }


    /**
     * Generate Sidebar Widgets on Checkbox format
     *
     * @return void
     */
    public static function jltma_get_default_widgets()
    {
        global $wp_widget_factory;

        $widgets = [];

        // $default_widgets = [
        //     'WP_Widget_Pages',
        //     'WP_Widget_Calendar',
        //     'WP_Widget_Archives',
        //     'WP_Widget_Links',
        //     'WP_Widget_Media_Audio',
        //     'WP_Widget_Media_Image',
        //     'WP_Widget_Media_Video',
        //     'WP_Widget_Media_Gallery',
        //     'WP_Widget_Meta',
        //     'WP_Widget_Search',
        //     'WP_Widget_Text',
        //     'WP_Widget_Categories',
        //     'WP_Widget_Recent_Posts',
        //     'WP_Widget_Recent_Comments',
        //     'WP_Widget_RSS',
        //     'WP_Widget_Tag_Cloud',
        //     'WP_Nav_Menu_Widget',
        //     'WP_Widget_Custom_HTML'
        // ];


        /**
         * Array of known widgets that won't work in the builder.
         * @see jltwp_adminify_get_wp_widgets_exclude
         */
        $exclude = apply_filters('jltwp_adminify_get_wp_widgets_exclude', array(
            'WP_Widget_Media_Audio',
            'WP_Widget_Media_Image',
            'WP_Widget_Media_Video',
            'WP_Widget_Media_Gallery',
            'WP_Widget_Text',
            'WP_Widget_Custom_HTML',
        ));

        foreach ($wp_widget_factory->widgets as $class => $widget) {
            if (in_array($class, $exclude)) {
                continue;
            }
            $widgets[$class]   = $widget->name;
        }

        ksort($widgets);
        return $widgets;
    }


    public function sidebar_widgets_settings()
    {
        if (!class_exists('ADMINIFY')) {
            return;
        }

        // Sidebar Widgets Section
        \ADMINIFY::createSection($this->prefix, array(
            'title'  => __('Sidebar Widgets', 'adminify'),
            'id'     => 'sidebar_widgets',
            'parent' => 'widget_settings',
            'icon'   => 'dashicons dashicons-align-pull-right',
            'fields' => array(
                array(
                    'type'    => 'subheading',
                    'content'   => Utils::adminfiy_help_urls(
                        __('Sidebar Widgets Settings', 'adminify'),
                        'https://wpadminify.com/kb/wp-widget-settings/',
                        'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
                        'https://www.facebook.com/groups/jeweltheme',
                        'https://wpadminify.com/support/'
                    )
                ),
                array(
                    'id'       => 'sidebar_widgets_disable_gutenberg_editor',
                    'type'     => 'switcher',
                    'title'    => __('Disable Gutenberg editor in sidebar widgets', 'adminify'),
                    'text_on'  => 'Yes',
                    'text_off' => 'No',
                    'default'  => $this->get_default_field('widget_settings')['sidebar_widgets_disable_gutenberg_editor'],
                ),
                array(
                    'id'          => 'sidebar_widgets_user_roles',
                    'type'        => 'select',
                    'title'       => 'Visible for',
                    'placeholder' => 'Select User roles you want to show',
                    'options'     => 'roles',
                    'multiple'    => true,
                    'chosen'      => true,
                    'default'     => $this->get_default_field('widget_settings')['sidebar_widgets_user_roles'],
                    'dependency' => array('sidebar_widgets_disable_gutenberg_editor', '==', true),
                ),
                array(
                    'id'      => 'sidebar_widgets_list',
                    'type'    => 'checkbox',
                    'title'   => 'Remove unwanted Widgets',
                    'options' => '\WPAdminify\Inc\Classes\Sidebar_Widgets::render_sidebar_checkboxes',
                    'default' => $this->get_default_field('widget_settings')['sidebar_widgets_list'],
                    'dependency' => array('sidebar_widgets_disable_gutenberg_editor', '==', true),
                )

            )
        ));
    }
}
