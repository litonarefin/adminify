<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

/**
 * WP Adminify
 * @package WP Admin Bar
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class AdminBar extends AdminSettingsModel
{
    public function __construct()
    {
        $this->admin_bar_settings();
    }

    public function get_defaults()
    {
        return [
            'admin_bar_settings'    => [
                'admin_bar_user_roles'               => [],
                'enable_admin_bar'                   => true,
                'admin_bar_hide_frontend'            => 'show',
                'admin_bar_position'                 => 'top',
                'admin_bar_hide_frontend_user_roles' => [],
                'admin_bar_search'                   => true,
                'admin_bar_comments'                 => true,
                'admin_bar_howdy_text'               => __('Howdy', 'adminify'),
                'admin_bar_view_website'             => true,
                'admin_bar_view_website_window_type' => 'new_tab',
                'admin_bar_user_offcanvas_menu'      => true,
                'admin_bar_dark_light_btn'           => true,
                'admin_bar_container'                => 'admin_bar_only',
                'admin_bar_light_bg'                 => 'color',
                'admin_bar_light_bg_color'           => '',
                'admin_bar_font_typography'          => '',
                'admin_bar_light_bg_gradient' => [
                    'background-color'              => '',
                    'background-gradient-color'     => '',
                    'background-gradient-direction' => '135deg'
                ],
                'admin_bar_dark_bg'          => 'color',
                'admin_bar_dark_bg_color'    => '',
                'admin_bar_dark_bg_gradient' => [
                    'background-color'              => '',
                    'background-gradient-color'     => '',
                    'background-gradient-direction' => '135deg'
                ],
                'admin_bar_text_color' => '',
                'admin_bar_link_color' => [
                    'bg_color'    => '',
                    'link_color'  => '',
                    'hover_color' => ''
                ],
                'admin_bar_link_dropdown_color' => [
                    'wrapper_bg'  => '',
                    'bg_color'    => '',
                    'link_color'  => '',
                    'hover_color' => ''
                ],
                'admin_bar_icon_color' => ''
            ]
        ];
    }

    public function admin_bar_settings_user_roles(&$fields)
    {
        // $fields[] = array(
        //     'id'          => 'admin_bar_user_roles',
        //     'type'        => 'select',
        //     'title'       => __('Disable for', 'adminify'),
        //     'placeholder' => __('Select User roles you don\'t want to show', 'adminify'),
        //     'options'     => 'roles',
        //     'multiple'    => true,
        //     'chosen'      => true,
        //     'default'     => $this->get_default_field('admin_bar_settings')['admin_bar_user_roles'],
        // );

        $fields[] = array(
            'id'         => 'enable_admin_bar',
            'type'       => 'switcher',
            'title'      => __('Admin Bar Settings', 'adminify'),
            'label'      => __('Enable/Disable Admin Bar includes Logo, Search, Dark/Light Mode, User Info etc.', 'adminify'),
            'text_on'    => __('Enabled', 'adminify'),
            'text_off'   => __('Disabled', 'adminify'),
            'text_width' => 100,
            'default'    => $this->get_default_field('admin_bar_settings')['enable_admin_bar'],
        );

        $fields[] = array(
            'id'      => 'admin_bar_hide_frontend',
            'type'    => 'button_set',
            'title'   => __('Frontend Admin Bar', 'adminify'),
            'options' => array(
                'show' => __('Show', 'adminify'),
                'hide' => __('Hide', 'adminify'),
            ),
            'default'    => $this->get_default_field('admin_bar_settings')['admin_bar_hide_frontend'],
            'dependency' => array('enable_admin_bar', '==', 'true', 'true'),
        );

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $fields[] = array(
                'id'          => 'admin_bar_hide_frontend_user_roles',
                'type'        => 'select',
                'title'       => __('"Frontend Admin Bar" Disable for', 'adminify'),
                'placeholder' => __('Select User roles you don\'t want to show', 'adminify'),
                'options'     => 'roles',
                'multiple'    => true,
                'chosen'      => true,
                'default'     => $this->get_default_field('admin_bar_settings')['admin_bar_hide_frontend_user_roles'],
                'dependency' => array('enable_admin_bar|admin_bar_hide_frontend', '==|==', 'true|show', 'true'),
            );
        } else {
            $fields[] = array(
                'type'       => 'notice',
                'title'   => __('"Frontend Admin Bar" Disable for', 'adminify'),
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro(),
                'dependency' => array('enable_admin_bar|admin_bar_hide_frontend', '==|==', 'true|show', 'true'),
            );
        }

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $fields[] = array(
                'id'      => 'admin_bar_position',
                'type'    => 'button_set',
                'title'   => __('Admin Bar Position', 'adminify'),
                'options' => array(
                    'top'    => __('Top', 'adminify'),
                    'bottom' => __('Bottom', 'adminify'),
                ),
                'default'    => $this->get_default_field('admin_bar_settings')['admin_bar_position'],
                'dependency' => array('enable_admin_bar', '==', 'true', 'true'),
            );
        } else {
            $fields[] = array(
                'type'       => 'notice',
                'title'   => __('Admin Bar Position', 'adminify'),
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro(),
                'dependency' => array('enable_admin_bar|admin_bar_position', '==|==', 'true|pro_feature', 'true'),
            );
        }

        $fields[] = array(
            'id'         => 'admin_bar_search',
            'type'       => 'switcher',
            'title'      => __('Search Form', 'adminify'),
            'default'    => $this->get_default_field('admin_bar_settings')['admin_bar_search'],
            'text_on'    => __('Show', 'adminify'),
            'text_off'   => __('Hide', 'adminify'),
            'text_width' => '100',
            'dependency' => array('admin_ui|enable_admin_bar', '==|==', 'true|true', 'true'),
        );
        $fields[] = array(
            'id'         => 'admin_bar_dark_light_btn',
            'type'       => 'switcher',
            'title'      => __('Light/Dark Switcher', 'adminify'),
            'text_on'    => __('Show', 'adminify'),
            'text_off'   => __('Hide', 'adminify'),
            'text_width' => '100',
            'default'    => $this->get_default_field('admin_bar_settings')['admin_bar_dark_light_btn'],
            'dependency' => array('admin_ui|enable_admin_bar', '==|==', 'true|true', 'true'),
        );
        $fields[] = array(
            'id'         => 'admin_bar_comments',
            'type'       => 'switcher',
            'title'      => __('Comments Icon', 'adminify'),
            'text_on'    => __('Show', 'adminify'),
            'text_off'   => __('Hide', 'adminify'),
            'text_width' => '100',
            'default'    => $this->get_default_field('admin_bar_settings')['admin_bar_comments'],
            'dependency' => array('enable_admin_bar', '==', 'true', 'true'),
        );

        $fields[] = array(
            'id'         => 'admin_bar_howdy_text',
            'type'       => 'text',
            'title'      => __('"Howdy" Text', 'adminify'),
            'default'    => $this->get_default_field('admin_bar_settings')['admin_bar_howdy_text'],
            'dependency' => array('admin_ui|enable_admin_bar', '!=|==', 'true|true', 'true'),
        );

        $fields[] = array(
            'id'         => 'admin_bar_view_website',
            'type'       => 'switcher',
            'title'      => 'View Website Icon',
            'text_on'    => __('Show', 'adminify'),
            'text_off'   => __('Hide', 'adminify'),
            'text_width' => '100',
            'default'    => $this->get_default_field('admin_bar_settings')['admin_bar_view_website'],
            'dependency' => array('admin_ui|enable_admin_bar', '==|==', 'true|true', 'true'),
        );
        $fields[] = array(
            'id'         => 'admin_bar_view_website_window_type',
            'type'       => 'button_set',
            'title'      => __('Website Open In', 'adminify'),
            'options'    => array(
                'same_tab'    => __('Same Window', 'adminify'),
                'new_tab'     => __('New Window', 'adminify'),
            ),
            'default'    => $this->get_default_field('admin_bar_settings')['admin_bar_view_website_window_type'],
            'dependency' => array('admin_ui|enable_admin_bar|admin_bar_view_website', '==|==|==', 'true|true|true', 'true'),
        );
        $fields[] = array(
            'id'         => 'admin_bar_user_offcanvas_menu',
            'type'       => 'switcher',
            'title'      => __('User Offcanvas Menu', 'adminify'),
            'text_on'    => __('Enabled', 'adminify'),
            'text_off'   => __('Disabled', 'adminify'),
            'text_width' => '100',
            'default'    => $this->get_default_field('admin_bar_settings')['admin_bar_user_offcanvas_menu'],
            'dependency' => array('admin_ui|enable_admin_bar', '==|==', 'true|true', 'true'),
        );
    }



    /**
     * Style Tab Settings
     *
     * @return void
     */
    public function admin_bar_style_tab_settings(&$fields)
    {
        $fields[] = array(
            'id'          => 'admin_bar_container',
            'type'        => 'button_set',
            'title'       => __('Admin Bar Select', 'adminify'),
            'description' => __('Select to change Colors of Full Container(with Admin bar and Navigation) or Admin Bar only', 'adminify'),
            'options'     => array(
                'full_container' => __('Full Container', 'adminify'),
                'admin_bar_only' => __('Admin Bar', 'adminify'),
            ),
            'default'    => $this->get_default_field('admin_bar_settings')['admin_bar_container'],
            'dependency' => array('layout_type', '==', 'horizontal', 'true'),
        );

        if (!jltwp_adminify()->can_use_premium_code__premium_only()) {
            $fields[] = array(
                'type'       => 'notice',
                'title'      => __('', 'adminify'),
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro(),
                'dependency' => array('admin_bar_container', '==', 'full_container', 'true'),
            );
        }
        $fields[] = array(
            'id'                 => 'admin_bar_font_typography',
            'type'               => 'typography',
            'title'              => __('Font Settings', 'adminify'),
            'font_family'        => false,
            'font_weight'        => true,
            'font_style'         => true,
            'font_size'          => true,
            'line_height'        => true,
            'letter_spacing'     => true,
            'text_align'         => true,
            'text-transform'     => true,
            'color'              => false,
            'subset'             => false,
            'backup_font_family' => false,
            'font_variant'       => false,
            'word_spacing'       => false,
            'text_decoration'    => true,
            'default'            => $this->get_default_field('admin_bar_settings')['admin_bar_font_typography'],
        );

        $fields[] = array(
            'id'      => 'admin_bar_light_bg',
            'type'    => 'button_set',
            'title'   => __('Background', 'adminify'),
            'options' => array(
                'color'    => __('Color', 'adminify'),
                'gradient' => __('Gradient', 'adminify'),
            ),
            'default'    => $this->get_default_field('admin_bar_settings')['admin_bar_light_bg'],
            'dependency' => array('admin_bar_mode', '==', 'light', 'true'),
        );

        $fields[] = array(
            'id'         => 'admin_bar_light_bg_color',
            'type'       => 'color',
            'title'      => __('Background Color', 'adminify'),
            'default'    => $this->get_default_field('admin_bar_settings')['admin_bar_light_bg_color'],
            'dependency' => array('admin_bar_light_bg|admin_bar_mode', '==|==', 'color|light', 'true'),
        );


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $fields[] = array(
                'id'                    => 'admin_bar_light_bg_gradient',
                'type'                  => 'background',
                'title'                 => __('Gradient Background', 'adminify'),
                'background_color'      => true,
                'background_image'      => false,
                'background_position'   => false,
                'background_repeat'     => false,
                'background_attachment' => false,
                'background_size'       => false,
                'background_origin'     => false,
                'background_clip'       => false,
                'background_blend_mode' => false,
                'background_gradient'   => true,
                'default'               => $this->get_default_field('admin_bar_settings')['admin_bar_light_bg_gradient'],
                'dependency'            => array('admin_bar_light_bg|admin_bar_mode', '==|==', 'gradient|light', 'true')
            );
        } else {
            $fields[] = array(
                'type'       => 'notice',
                'title'      => __('', 'adminify'),
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro(),
                'dependency' => array('admin_bar_light_bg|admin_bar_mode', '==|==', 'gradient|light', 'true')
            );
        }


        // Dark Background
        $fields[] = array(
            'id'      => 'admin_bar_dark_bg',
            'type'    => 'button_set',
            'title'   => __('Background Type', 'adminify'),
            'options' => array(
                'color'    => __('Color', 'adminify'),
                'gradient' => __('Gradient', 'adminify'),
            ),
            'default'    => $this->get_default_field('admin_bar_settings')['admin_bar_dark_bg'],
            'dependency' => array('admin_bar_mode', '==', 'dark', 'true'),
        );

        $fields[] = array(
            'id'         => 'admin_bar_dark_bg_color',
            'type'       => 'color',
            'title'      => __('Background Color', 'adminify'),
            'default'    => $this->get_default_field('admin_bar_settings')['admin_bar_dark_bg_color'],
            'dependency' => array('admin_bar_dark_bg|admin_bar_mode', '==|==', 'color|dark', 'true'),
        );



        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $fields[] = array(
                'id'                    => 'admin_bar_dark_bg_gradient',
                'type'                  => 'background',
                'title'                 => __('Gradient Background', 'adminify'),
                'background_color'      => true,
                'background_image'      => false,
                'background_position'   => false,
                'background_repeat'     => false,
                'background_attachment' => false,
                'background_size'       => false,
                'background_origin'     => false,
                'background_clip'       => false,
                'background_blend_mode' => false,
                'background_gradient'   => true,
                'default'               => $this->get_default_field('admin_bar_settings')['admin_bar_dark_bg_gradient'],
                'dependency'            => array('admin_bar_dark_bg|admin_bar_mode', '==|==', 'gradient|dark', 'true')
            );
        } else {
            $fields[] = array(
                'type'       => 'notice',
                'title'      => __('', 'adminify'),
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro(),
                'dependency' => array('admin_bar_dark_bg|admin_bar_mode', '==|==', 'gradient|dark', 'true')
            );
        }



        $fields[] = array(
            'id'      => 'admin_bar_text_color',
            'type'    => 'color',
            'title'   => __('Text Color', 'adminify'),
            'default' => $this->get_default_field('admin_bar_settings')['admin_bar_text_color'],
        );

        $fields[] = array(
            'type'    => 'subheading',
            'content' => __('"New" Button Style', 'adminify')
        );
        $fields[] = array(
            'id'       => 'admin_bar_link_color',
            'type'     => 'color_group',
            'title'    => __('"New" Button color', 'adminify'),
            'subtitle' => __('"New" Button Link colors active, hover, background etc ', 'adminify'),
            'options'  => array(
                'bg_color'    => __('Background Color', 'adminify'),
                'link_color'  => __('Text Color', 'adminify'),
                'hover_color' => __('Hover Color', 'adminify'),
            ),
            'default' => $this->get_default_field('admin_bar_settings')['admin_bar_link_color'],
        );
        $fields[] = array(
            'id'       => 'admin_bar_link_dropdown_color',
            'type'     => 'color_group',
            'title'    => __('"New" Dropdown', 'adminify'),
            'subtitle' => __('"New" Dropdown Link colors active, hover, background etc ', 'adminify'),
            'options'  => array(
                'wrapper_bg'  => __('Wrapper BG', 'adminify'),
                'bg_color'    => __('Item Hover BG', 'adminify'),
                'link_color'  => __('Link Color', 'adminify'),
                'hover_color' => __('Hover Color', 'adminify'),
            ),
            'default' => $this->get_default_field('admin_bar_settings')['admin_bar_link_dropdown_color'],
        );



        $fields[] = array(
            'type'    => 'subheading',
            'content' => __('Icon Color', 'adminify'),
        );
        $fields[] = array(
            'id'      => 'admin_bar_icon_color',
            'type'    => 'color',
            'title'   => __('Color', 'adminify'),
            'default' => $this->get_default_field('admin_bar_settings')['admin_bar_icon_color'],
        );
    }



    public function admin_bar_settings()
    {

        if (!class_exists('ADMINIFY')) {
            return;
        }

        $settings_tab_fields = [];
        $style_tab_fields    = [];
        $this->admin_bar_settings_user_roles($settings_tab_fields);
        $this->admin_bar_style_tab_settings($style_tab_fields);

        // Admin Bar Section
        \ADMINIFY::createSection($this->prefix, array(
            'title'  => __('Admin Bar', 'adminify'),
            'icon'   => 'fas fa-user-shield',
            'fields' => array(
                array(
                    'type'    => 'subheading',
                    'content'   => Utils::adminfiy_help_urls(
                        __('Admin Bar Settings', 'adminify'),
                        'https://wpadminify.com/kb/wp-admin-bar/',
                        'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
                        'https://www.facebook.com/groups/jeweltheme',
                        'https://wpadminify.com/support/'
                    )
                ),
                array(
                    'id'    => 'admin_bar_settings',
                    'type'  => 'tabbed',
                    'title' => '',
                    'tabs'  => array(
                        array(
                            'title'  => __('Settings', 'adminify'),
                            'fields' => $settings_tab_fields
                        ),
                        array(
                            'title'  => 'Styles',
                            'fields' => $style_tab_fields
                        ),
                    ),
                ),
            )
        ));
    }
}
