<?php

namespace WPAdminify\Inc\Modules\DashboardWidget;

use WPAdminify\Inc\Utils;
// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WPAdminify
 * @package Module: Dashboard Widget
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

if (!class_exists('DashboardWidget_Setttings')) {

    class DashboardWidget_Setttings extends DashboardWidgetModel
    {
        public function __construct()
        {
            // this should be first so the default values get stored
            $this->dashboard_widget_settings();
            parent::__construct((array) get_option($this->prefix));
        }

        public function get_defaults()
        {
            return [
                'dashboard_widget_types' => array(
                    'dashboard_widgets' => array(
                        'title'       => '',
                        'widget_pos'  => 'normal',
                        'widget_type' => 'editor',
                        'dashw_video' => array(
                            'dashw_type_video_type'             => 'self_hosted',
                            'dashw_type_video_title'            => '',
                            'dashw_type_video_type_self_hosted' => array(
                                'url'         => '',
                                'id'          => '',
                                'width'       => '',
                                'height'      => '',
                                'thumbnail'   => '',
                                'alt'         => '',
                                'title'       => '',
                                'description' => '',
                            ),
                            'dashw_type_video_type_youtube' => '',
                            'dashw_type_video_type_vimeo'   => '',
                        ),
                        'dashw_type_editor'       => '',
                        'dashw_type_icon'         => '',
                        'dashw_type_icon_tooltip' => '',
                        'dashw_type_icon_link'    => array(
                            'url'    => 'https://wpadminify.com/',
                            'text'   => 'WP Adminify',
                            'target' => '_blank',
                        ),
                        'dashw_type_shortcode'   => '',
                        'dashw_type_script'      => '<script>
    ;(function($) {
        "use strict";
        $(document).ready( function() {
            // Write your JS code here
        });
    })( jQuery );
</script>',
                        'dashw_type_rss_feed'    => '',
                        'dashw_type_rss_count'   => 5,
                        'dashw_type_rss_excerpt' => true,
                        'dashw_type_rss_date'    => true,
                        'dashw_type_rss_author'  => true,
                        'user_roles'             => '',

                    ),
                    'welcome_dash_widget' => array(
                        'enable_custom_welcome_dash_widget' => false,
                        'widget_template_type'              => 'specific_page',
                        'custom_page'                       => '',
                        'elementor_section_id'              => '',
                        'elementor_widget_id'               => '',
                        'elementor_template_id'             => '',
                        'oxygen_template_id'                => '',
                        'dismissible'                       => true,
                        'user_roles'                        => '',
                    )
                )
            ];
        }


        /**
         * Welcome Widget Settings
         *
         * @param [type] $welcome_widgets
         *
         * @return void
         */
        public function welcome_widgets_settings(&$welcome_widgets)
        {
            $welcome_widget_fields = [];
            $this->welcome_widget_fields($welcome_widget_fields);
            $welcome_widgets[] = array(
                'id'     => 'welcome_dash_widget',
                'type'   => 'fieldset',
                'title'  => '',
                'fields' => $welcome_widget_fields
            );
        }

        public function welcome_widget_fields(&$welcome_widget_fields)
        {
            $welcome_widget_fields[] = array(
                'id'         => 'enable_custom_welcome_dash_widget',
                'type'       => 'switcher',
                'title'      => __('Enable Custom Welcome Panel?', 'adminify'),
                'subtitle'   => __('Enable if you want to show any Elementor Template/Page on Welcome Panel', 'adminify'),
                'text_on'    => __('Enable', 'adminify'),
                'text_off'   => __('Disable', 'adminify'),
                'default'    => $this->get_default_field('dashboard_widget_types')['welcome_dash_widget']['enable_custom_welcome_dash_widget'],
                'text_width' => 100
            );

            // Default Page
            $page_type_options = [
                'specific_page' => __('Page', 'adminify')
            ];

            // Oxygen Builder Support
            if (Utils::is_plugin_active('oxygen/functions.php')) {
                $page_oxygen_options = [];
                $page_oxygen_options = [
                    'oxygen_template' => __('Oxygen Template', 'adminify'),
                ];
                $page_type_options = array_merge($page_type_options, $page_oxygen_options);
            }

            // Elementor Builder
            if (Utils::is_plugin_active('elementor/elementor.php')) {
                $page_elementory_options = [];
                $page_elementory_options = [
                    'elementor_template' => __('Elementor Page Template', 'adminify'),
                    'elementor_section'  => __('Elementor Saved Section', 'adminify'),
                    'elementor_widget'   => __('Elementor Saved Widget', 'adminify'),
                ];
                $page_type_options = array_merge($page_type_options, $page_elementory_options);
            }

            $welcome_widget_fields[] = array(
                'id'          => 'widget_template_type',
                'type'        => 'select',
                'title'       => __('Select Page/Template', 'adminify'),
                'placeholder' => __('Select an option', 'adminify'),
                'options'     => $page_type_options,
                'default'    => $this->get_default_field('dashboard_widget_types')['welcome_dash_widget']['widget_template_type'],
                'dependency' => array('enable_custom_welcome_dash_widget', '==', 'true', true),
            );

            // Default Page
            $welcome_widget_fields[] = array(
                'id'          => 'custom_page',
                'type'        => 'select',
                'title'       => __('Select Page', 'adminify'),
                'placeholder' => __('Select a Page', 'adminify'),
                'options'     => 'pages',
                'default'     => $this->get_default_field('dashboard_widget_types')['welcome_dash_widget']['custom_page'],
                'dependency'  => array('widget_template_type|enable_custom_welcome_dash_widget', '==|==', 'specific_page|true', true),
            );

            // Oxygen Builder
            if (Utils::is_plugin_active('oxygen/functions.php')) {
                $welcome_widget_fields[] = array(
                    'id'          => 'oxygen_template_id',
                    'type'        => 'select',
                    'title'       => __('Select Template', 'adminify'),
                    'placeholder' => __('Select a Template', 'adminify'),
                    'options'     => 'posts',
                    'query_args'  => array(
                        'post_type' => 'ct_template',
                    ),
                    'default'    => $this->get_default_field('dashboard_widget_types')['welcome_dash_widget']['oxygen_template_id'],
                    'dependency' => array('widget_template_type|enable_custom_welcome_dash_widget', '==|==', 'oxygen_template|true', true),
                );
            }

            // Elementor Builder
            if (Utils::is_plugin_active('elementor/elementor.php')) {


                $welcome_widget_fields[] = array(
                    'id'          => 'elementor_section_id',
                    'type'        => 'select',
                    'title'       => __('Saved Section', 'adminify'),
                    'options'     => 'WPAdminify\Inc\Utils::get_section_template_options',
                    'default'    => $this->get_default_field('dashboard_widget_types')['welcome_dash_widget']['elementor_section_id'],
                    'dependency' => array('widget_template_type|enable_custom_welcome_dash_widget', '==|==', 'elementor_section|true', true),
                );

                $welcome_widget_fields[] = array(
                    'id'          => 'elementor_widget_id',
                    'type'        => 'select',
                    'title'       => __('Saved Widget', 'adminify'),
                    'options'     => 'WPAdminify\Inc\Utils::get_widget_template_options',
                    'default'    => $this->get_default_field('dashboard_widget_types')['welcome_dash_widget']['elementor_widget_id'],
                    'dependency' => array('widget_template_type|enable_custom_welcome_dash_widget', '==|==', 'elementor_widget|true', true),
                );

                $welcome_widget_fields[] = array(
                    'id'          => 'elementor_template_id',
                    'type'        => 'select',
                    'title'       => __('Saved Template', 'adminify'),
                    'options'     => 'WPAdminify\Inc\Utils::get_page_template_options',
                    'default'    => $this->get_default_field('dashboard_widget_types')['welcome_dash_widget']['elementor_template_id'],
                    'dependency' => array('widget_template_type|enable_custom_welcome_dash_widget', '==|==', 'elementor_template|true', true),
                );


            }


            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $welcome_widget_fields[] = array(
                    'id'         => 'dismissible',
                    'type'       => 'switcher',
                    'title'      => __('Dismissible', 'adminify'),
                    'default'    => $this->get_default_field('dashboard_widget_types')['welcome_dash_widget']['dismissible'],
                    'dependency' => array('enable_custom_welcome_dash_widget', '==', 'true', true),
                );
            } else {
                $welcome_widget_fields[] = array(
                    'type'       => 'notice',
                    'title'      => __('Dismissible', 'adminify'),
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array('enable_custom_welcome_dash_widget', '==', 'true', true),
                );
            }

            $welcome_widget_fields[] = array(
                'id'          => 'user_roles',
                'type'        => 'select',
                'title'       => __('Allowed User Roles', 'adminify'),
                'subtitle'    => __('Allow users to access this section', 'adminify'),
                'placeholder' => __('Select a role', 'adminify'),
                'chosen'      => true,
                'multiple'    => true,
                'options'     => 'roles',
                'default'     => $this->get_default_field('dashboard_widget_types')['welcome_dash_widget']['user_roles'],
                'dependency'  => array('enable_custom_welcome_dash_widget', '==', 'true', true),
            );
        }

        /**
         * Dashboard Widgets Setting
         *
         * @param [type] $dash_widgets_setting
         *
         * @return void
         */
        public function dash_widget_setting_setup(&$dash_widgets_setting)
        {
            $dash_widgets = [];
            $this->dashboard_widgets($dash_widgets);

            $welcome_widgets = [];
            $this->welcome_widgets_settings($welcome_widgets);

            $dash_widgets_setting[] = array(
                'type'    => 'subheading',
                'content'   => Utils::adminfiy_help_urls(
                    __('Custom Dashboard & Welcome Widgets', 'adminify'),
                    'https://wpadminify.com/kb/wordpress-custom-dashboard-widget',
                    'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
                    'https://www.facebook.com/groups/jeweltheme',
                    'https://wpadminify.com/support/dashboard-welcome-widgets'
                )
            );

            $dash_widgets_setting[] =  array(
                'id'    => 'dashboard_widget_types',
                'type'  => 'tabbed',
                'title' => '',
                'tabs'  => array(
                    array(
                        'title'  => __('Dashboard Widgets', 'adminify'),
                        'fields' => $dash_widgets
                    ),

                    array(
                        'title'  => __('Welcome Widget', 'adminify'),
                        'fields' => $welcome_widgets
                    ),


                )
            );
        }

        /**
         * Dashboard Widgets Section
         *
         * @param [type] $dash_widgets
         *
         * @return void
         */
        public function dashboard_widgets(&$dash_widgets)
        {
            $dashboard_group_fields = [];
            $this->dashboard_widget_group_fields($dashboard_group_fields);

            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dash_widgets[] =  array(
                    'id'                    => 'dashboard_widgets',
                    'type'                  => 'group',
                    'title'                 => '',
                    'accordion_title_title' => __('Dashboard Widget Name:', 'adminify'),
                    'accordion_title_prefix' => __('Dashboard Widget Name: ', 'adminify'),
                    'accordion_title_number' => true,
                    'accordion_title_auto'   => true,
                    'button_title'          => __('Add New Widget', 'adminify'),
                    'fields'                => $dashboard_group_fields
                );
            } else {
                $dash_widgets[] =  array(
                    'id'                    => 'dashboard_widgets',
                    'type'                  => 'group',
                    'title'                 => '',
                    'max'                   => 2,
                    'max_text'              => __('Get <strong>Pro Version</strong> to Unlock this feature. <a href="https://wpadminify.com/pricing" target="_blank">Upgrade to Pro Now!</a>', 'adminify'),
                    'accordion_title_title' => __('Dashboard Widget Name:', 'adminify'),
                    'accordion_title_prefix' => __('Dashboard Widget Name: ', 'adminify'),
                    'accordion_title_number' => true,
                    'accordion_title_auto'   => true,
                    'button_title'          => __('Add New Widget', 'adminify'),
                    'fields'                => $dashboard_group_fields
                );
            }
        }


        public function dashboard_widget_group_fields(&$dashboard_group_fields)
        {
            $dashboard_widget_video = [];
            $this->dashboard_widget_video($dashboard_widget_video);

            $dashboard_group_fields[] = array(
                'id'      => 'title',
                'type'    => 'text',
                'title'   => __('Widget Title', 'adminify'),
                'default' => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['title'],
            );

            $dashboard_group_fields[] = array(
                'id'      => 'widget_pos',
                'type'    => 'button_set',
                'title'   => __('Widget Position', 'adminify'),
                'options' => array(
                    'side'   => __('Side', 'adminify'),
                    'normal' => __('Normal', 'adminify'),
                ),
                'default' => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['widget_pos'],
            );

            $dashboard_group_fields[] = array(
                'id'      => 'widget_type',
                'type'    => 'button_set',
                'title'   => __('Content Type', 'adminify'),
                'options' => array(
                    'editor'    => __('Editor', 'adminify'),
                    'icon'      => __('Icon', 'adminify'),
                    'video'     => __('Video', 'adminify'),
                    'shortcode' => __('Shortcode', 'adminify'),
                    'rss_feed'  => __('RSS Feed', 'adminify'),
                    'script'    => __('Script', 'adminify'),
                ),
                'default' => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['widget_type'],
            );

            $dashboard_group_fields[] = array(
                'id'         => 'dashw_video',
                'type'       => 'fieldset',
                'title'      => __('Video', 'adminify'),
                'fields'     => $dashboard_widget_video,
                'dependency' => array('widget_type', '==', 'video'),
            );

            $dashboard_group_fields[] = array(
                'id'         => 'dashw_type_editor',
                'type'       => 'wp_editor',
                'title'      => __('Content', 'adminify'),
                'subtitle'   => 'Contents with Editor and HTML mode',
                'height'     => '100px',
                'dependency' => array('widget_type', '==', 'editor'),
                'default'    => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_type_editor'],
            );


            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dashboard_group_fields[] = array(
                    'id'         => 'dashw_type_icon',
                    'type'       => 'icon',
                    'title'      => __('Icon', 'adminify'),
                    'dependency' => array('widget_type', '==', 'icon'),
                    'default'    => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_type_icon'],
                );
            } else {
                $dashboard_group_fields[] = array(
                    'type'       => 'notice',
                    'title'      => __('Icon', 'adminify'),
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array('widget_type', '==', 'icon'),
                );
            }


            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dashboard_group_fields[] = array(
                    'id'         => 'dashw_type_icon_tooltip',
                    'type'       => 'text',
                    'title'      => __('Tooltip Text', 'adminify'),
                    'dependency' => array('widget_type', '==', 'icon'),
                    'default'    => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_type_icon_tooltip'],
                );
            } else {
                $dashboard_group_fields[] = array(
                    'type'       => 'notice',
                    'title'      => __('Tooltip Text', 'adminify'),
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array('widget_type', '==', 'icon'),
                );
            }


            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dashboard_group_fields[] = array(
                    'id'         => 'dashw_type_icon_link',
                    'type'       => 'link',
                    'title'      => __('Link', 'adminify'),
                    'default'    => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_type_icon_link'],
                    'dependency' => array('widget_type', '==', 'icon')
                );
            } else {
                $dashboard_group_fields[] = array(
                    'type'       => 'notice',
                    'title'      => __('Link', 'adminify'),
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array('widget_type', '==', 'icon')
                );
            }


            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dashboard_group_fields[] = array(
                    'id'         => 'dashw_type_shortcode',
                    'type'       => 'textarea',
                    'title'      => __('Shortcode', 'adminify'),
                    'dependency' => array('widget_type', '==', 'shortcode'),
                    'default'    => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_type_shortcode'],
                );
            } else {
                $dashboard_group_fields[] = array(
                    'type'       => 'notice',
                    'title'      => __('Shortcode', 'adminify'),
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array('widget_type', '==', 'shortcode'),
                );
            }


            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dashboard_group_fields[] = array(
                    'id'         => 'dashw_type_script',
                    'type'       => 'code_editor',
                    'title'      => __('Script', 'adminify'),
                    'subtitle'    => __('Write Custom Script code inside <strong>&lt;script&gt;&lt;/script&gt;</strong> tag.', 'adminify'),
                    'settings' => array(
                        'theme'  => 'dracula',
                        'mode'   => 'htmlmixed',
                    ),
                    'sanitize' => false,
                    'dependency' => array('widget_type', '==', 'script'),
                    'default'    => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_type_script'],
                );
            } else {
                $dashboard_group_fields[] = array(
                    'type'       => 'notice',
                    'title'      => __('Script', 'adminify'),
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array('widget_type', '==', 'script'),
                );
            }



            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dashboard_group_fields[] = array(
                    'id'         => 'dashw_type_rss_feed',
                    'type'       => 'text',
                    'title'      => __('RSS Feed URL', 'adminify'),
                    'dependency' => array('widget_type', '==', 'rss_feed'),
                    'default'    => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_type_rss_feed'],
                );
            } else {
                $dashboard_group_fields[] = array(
                    'type'       => 'notice',
                    'title'      => __('RSS Feed URL', 'adminify'),
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array('widget_type', '==', 'rss_feed'),
                );
            }


            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dashboard_group_fields[] = array(
                    'id'         => 'dashw_type_rss_count',
                    'type'       => 'number',
                    'title'      => __('No. of Feed Posts', 'adminify'),
                    'default'    => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_type_rss_count'],
                    'dependency' => array('widget_type', '==', 'rss_feed'),
                );
            } else {
                $dashboard_group_fields[] = array(
                    'type'       => 'notice',
                    'title'      => __('No. of Feed Posts', 'adminify'),
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array('widget_type', '==', 'rss_feed'),
                );
            }


            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dashboard_group_fields[] = array(
                    'id'         => 'dashw_type_rss_excerpt',
                    'type'       => 'switcher',
                    'title'      => __('Show Excerpt?', 'adminify'),
                    'text_on'    => 'Yes',
                    'text_off'   => 'No',
                    'default'    => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_type_rss_excerpt'],
                    'dependency' => array('widget_type', '==', 'rss_feed')
                );
            } else {
                $dashboard_group_fields[] = array(
                    'type'       => 'notice',
                    'title'      => __('Show Excerpt?', 'adminify'),
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array('widget_type', '==', 'rss_feed')
                );
            }


            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dashboard_group_fields[] = array(
                    'id'         => 'dashw_type_rss_date',
                    'type'       => 'switcher',
                    'title'      => __('Show Date?', 'adminify'),
                    'text_on'    => 'Yes',
                    'text_off'   => 'No',
                    'default'    => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_type_rss_date'],
                    'dependency' => array('widget_type', '==', 'rss_feed')
                );
            } else {
                $dashboard_group_fields[] = array(
                    'type'       => 'notice',
                    'title'      => __('Show Date?', 'adminify'),
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array('widget_type', '==', 'rss_feed')
                );
            }


            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dashboard_group_fields[] = array(
                    'id'         => 'dashw_type_rss_author',
                    'type'       => 'switcher',
                    'title'      => __('Show Author?', 'adminify'),
                    'text_on'    => 'Yes',
                    'text_off'   => 'No',
                    'default'    => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_type_rss_author'],
                    'dependency' => array('widget_type', '==', 'rss_feed')
                );
            } else {
                $dashboard_group_fields[] = array(
                    'type'       => 'notice',
                    'title'      => __('Show Author?', 'adminify'),
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array('widget_type', '==', 'rss_feed')
                );
            }


            $dashboard_group_fields[] = array(
                'id'          => 'user_roles',
                'type'        => 'select',
                'title'       => __('Allowed User Roles', 'adminify'),
                'subtitle'    => __('Allow users to access this section', 'adminify'),
                'placeholder' => __('Select a role', 'adminify'),
                'chosen'      => true,
                'multiple'    => true,
                'options'     => 'roles',
                'default'     => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['user_roles'],
            );
        }

        public function dashboard_widget_video(&$dashboard_widget_video)
        {
            $dashboard_widget_video[] = array(
                'id'      => 'dashw_type_video_type',
                'type'    => 'button_set',
                'title'   => __('Video Type', 'adminify'),
                'options' => array(
                    'self_hosted' => __('Self Hosted ', 'adminify'),
                    'youtube'     => __('Youtube', 'adminify'),
                    'vimeo'       => __('Vimeo', 'adminify'),
                ),
                'default' => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_video']['dashw_type_video_type'],
            );

            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dashboard_widget_video[] = array(
                    'id'      => 'dashw_type_video_title',
                    'type'    => 'text',
                    'title'   => __('Text', 'adminify'),
                    'default' => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_video']['dashw_type_video_title'],
                );
            } else {
                $dashboard_widget_video[] = array(
                    'type'    => 'notice',
                    'title'   => __('Text', 'adminify'),
                    'style'   => 'warning',
                    'content' => Utils::adminify_upgrade_pro()
                );
            }

            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dashboard_widget_video[] = array(
                    'id'         => 'dashw_type_video_type_self_hosted',
                    'type'       => 'media',
                    'title'      => __('Upload Video', 'adminify'),
                    'library'    => 'video',
                    'preview'    => true,
                    'dependency' => array('dashw_type_video_type', '==', 'self_hosted'),
                    'default'    => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_video']['dashw_type_video_type_self_hosted'],
                );
            } else {
                $dashboard_widget_video[] = array(
                    'type'       => 'notice',
                    'title'      => __('Upload Video', 'adminify'),
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array('dashw_type_video_type', '==', 'self_hosted'),
                );
            }

            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dashboard_widget_video[] = array(
                    'id'         => 'dashw_type_video_type_youtube',
                    'type'       => 'text',
                    'title'      => __('Youtube URL', 'adminify'),
                    'validate'   => 'adminify_validate_url',
                    'dependency' => array('dashw_type_video_type', '==', 'youtube'),
                    'default'    => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_video']['dashw_type_video_type_youtube'],
                );
            } else {
                $dashboard_widget_video[] = array(
                    'type'       => 'notice',
                    'title'      => __('Youtube URL', 'adminify'),
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array('dashw_type_video_type', '==', 'youtube'),
                );
            }

            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dashboard_widget_video[] = array(
                    'id'         => 'dashw_type_video_type_vimeo',
                    'type'       => 'text',
                    'title'      => __('Vimeo URL', 'adminify'),
                    'validate'   => 'adminify_validate_url',
                    'dependency' => array('dashw_type_video_type', '==', 'vimeo'),
                    'default'    => $this->get_default_field('dashboard_widget_types')['dashboard_widgets']['dashw_video']['dashw_type_video_type_vimeo'],
                );
            } else {
                $dashboard_widget_video[] = array(
                    'type'       => 'notice',
                    'title'      => __('Vimeo URL', 'adminify'),
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array('dashw_type_video_type', '==', 'vimeo'),
                );
            }
        }

        public function dashboard_widget_settings()
        {
            if (!class_exists('ADMINIFY')) {
                return;
            }

            // WP Adminify Dashboard Widgets Settings
            \ADMINIFY::createOptions($this->prefix, array(

                // Framework Title
                'framework_title' => 'WP Adminify Dashboard Widget <small>by Jewel Theme</small>',
                'framework_class' => 'adminify-dashboard-widgets',

                // menu settings
                'menu_title'      => 'Dashboard Widget',
                'menu_slug'       => 'adminify-dashboard-widgets',
                'menu_type'       => 'submenu',                      // menu, submenu, options, theme, etc.
                'menu_capability' => 'manage_options',
                'menu_icon'       => '',
                'menu_position'   => 56,
                'menu_hidden'     => false,
                'menu_parent'     => 'wp-adminify-settings',

                // footer
                'footer_text'   => ' ',
                'footer_after'  => ' ',
                'footer_credit' => ' ',

                // menu extras
                'show_bar_menu'      => false,
                'show_sub_menu'      => false,
                'show_in_network'    => false,
                'show_in_customizer' => false,

                'show_search'        => false,
                'show_reset_all'     => false,
                'show_reset_section' => false,
                'show_footer'        => true,
                'show_all_options'   => true,
                'show_form_warning'  => true,
                'sticky_header'      => false,
                'save_defaults'      => false,
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
                'class' => 'wp-adminify-dashboard-widgets',
            ));

            $dash_widgets_setting = [];
            $this->dash_widget_setting_setup($dash_widgets_setting);

            \ADMINIFY::createSection(
                $this->prefix,
                array(
                    'title'  => __('Dashboard Widget', 'adminify'),
                    'icon'   => 'fas fa-bolt',
                    'fields' => $dash_widgets_setting
                )
            );
        }
    }
}
