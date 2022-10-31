<?php

namespace WPAdminify\Inc\Admin\Options;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Admin\AdminSettingsModel ;
if ( !defined( 'ABSPATH' ) ) {
    die;
}
// Cannot access directly.
class MenuLayout extends AdminSettingsModel
{
    public function __construct()
    {
        $this->menu_layout_settings();
    }
    
    public function get_defaults()
    {
        return [
            'menu_layout_settings' => [
            'layout_type'           => 'vertical',
            'menu_hover_submenu'    => 'classic',
            'icon_style'            => 'classic',
            'menu_mode'             => 'classic',
            'user_info'             => false,
            'user_info_content'     => 'text',
            'legacy_menu'           => false,
            'user_info_avatar'      => 'rounded',
            'horz_menu_type'        => 'both',
            'show_bloglink'         => true,
            'horz_dropdown_icon'    => true,
            'horz_toplinks'         => false,
            'horz_bubble_icon_hide' => false,
            'horz_long_menu_break'  => true,
            'menu_styles'           => [
            'menu_typography'          => [
            'font-family' => 'Nunito Sans',
            'type'        => 'google',
        ],
            'menu_wrapper_padding'     => '',
            'menu_vertical_padding'    => '',
            'horz_menu_parent_padding' => '',
            'submenu_wrapper_padding'  => '',
            'submenu_vertical_space'   => '',
            'parent_menu_colors'       => [
            'wrap_bg'      => '',
            'hover_bg'     => '',
            'text_color'   => '',
            'text_hover'   => '',
            'active_color' => '',
        ],
            'sub_menu_colors'          => [
            'wrap_bg'      => '',
            'hover_bg'     => '',
            'text_color'   => '',
            'text_hover'   => '',
            'active_bg'    => '',
            'active_color' => '',
        ],
            'notif_colors'             => [
            'notif_bg'    => '',
            'notif_color' => '',
        ],
        ],
            'user_info_style'       => [
            'info_text_color'       => '',
            'info_text_hover_color' => '',
            'info_text_border'      => [
            'top'    => '',
            'right'  => '',
            'bottom' => '',
            'left'   => '',
            'style'  => 'solid',
            'color'  => '',
        ],
            'info_icon_color'       => '',
            'info_icon_hover_color' => '',
        ],
        ],
        ];
    }
    
    public function menu_layout_settings_tab( &$settings_tab )
    {
        $settings_tab[] = [
            'id'      => 'layout_type',
            'type'    => 'button_set',
            'title'   => __( 'Menu Type', 'adminify' ),
            'options' => [
            'vertical'   => __( 'Vertical Menu', 'adminify' ),
            'horizontal' => __( 'Horizontal Menu', 'adminify' ),
        ],
            'default' => $this->get_default_field( 'menu_layout_settings' )['layout_type'],
        ];
        $settings_tab[] = [
            'type'       => 'notice',
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro( 'Horizontal Menu Requires "Adminify UI" Module Enabled from "WP Adminify>Modules" list ' ),
            'dependency' => [
            'admin_ui|layout_type',
            '!=|==',
            'true|horizontal',
            'true'
        ],
        ];
        $settings_tab[] = [
            'id'         => 'menu_mode',
            'type'       => 'button_set',
            'title'      => __( 'Menu Mode', 'adminify' ),
            'options'    => [
            'classic'   => __( 'Classic', 'adminify' ),
            'icon_menu' => __( 'Mini Icon', 'adminify' ),
            'rounded'   => __( 'Rounded', 'adminify' ),
        ],
            'default'    => $this->get_default_field( 'menu_layout_settings' )['menu_mode'],
            'dependency' => [
            'layout_type',
            '==',
            'vertical',
            'true'
        ],
        ];
        $settings_tab[] = [
            'type'       => 'notice',
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro( 'Rounded Menu Mode Requires "Adminify UI" Module Enabled from "WP Adminify>Modules" list ' ),
            'dependency' => [
            'admin_ui|layout_type|menu_mode',
            '!=|==|==',
            'true|vertical|rounded',
            'true'
        ],
        ];
        $settings_tab[] = [
            'id'         => 'icon_style',
            'type'       => 'button_set',
            'title'      => __( 'Icon Style', 'adminify' ),
            'options'    => [
            'classic' => __( 'Classic', 'adminify' ),
            'rounded' => __( 'Rounded', 'adminify' ),
        ],
            'dependency' => [
            'admin_ui|layout_type|menu_mode',
            '==|==|==',
            'true|vertical|icon_menu',
            'true'
        ],
            'default'    => $this->get_default_field( 'menu_layout_settings' )['icon_style'],
        ];
        $settings_tab[] = [
            'id'         => 'menu_hover_submenu',
            'type'       => 'button_set',
            'title'      => __( 'Sub Menu Style', 'adminify' ),
            'options'    => [
            'classic'   => __( 'Classic', 'adminify' ),
            'accordion' => __( 'Accordion', 'adminify' ),
            'toggle'    => __( 'Toggle', 'adminify' ),
        ],
            'dependency' => [
            'layout_type',
            '==',
            'vertical',
            'true'
        ],
            'default'    => $this->get_default_field( 'menu_layout_settings' )['menu_hover_submenu'],
        ];
        $settings_tab[] = [
            'type'       => 'notice',
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro( 'Accordion Menu Requires "Adminify UI" Module Enabled from "WP Adminify>Modules" list ' ),
            'dependency' => [
            'admin_ui|layout_type|menu_hover_submenu',
            '!=|==|!=',
            'true|vertical|classic',
            'true'
        ],
        ];
        $settings_tab[] = [
            'type'       => 'notice',
            'title'      => __( 'Horizontal Menu', 'adminify' ),
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'admin_ui|layout_type',
            '==|==',
            'true|horizontal',
            'true'
        ],
        ];
        $settings_tab[] = [
            'type'       => 'notice',
            'title'      => __( 'User Info', 'adminify' ),
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'layout_type',
            '==',
            'vertical',
            'true'
        ],
        ];
        $settings_tab[] = [
            'id'         => 'user_info_content',
            'type'       => 'button_set',
            'title'      => __( 'Content Type', 'adminify' ),
            'options'    => [
            'text' => __( 'Text', 'adminify' ),
            'icon' => __( 'Icon', 'adminify' ),
        ],
            'default'    => $this->get_default_field( 'menu_layout_settings' )['user_info_content'],
            'dependency' => [
            'user_info|layout_type',
            '==|==',
            'true|vertical',
            'true'
        ],
        ];
        $settings_tab[] = [
            'id'         => 'user_info_avatar',
            'type'       => 'button_set',
            'title'      => __( 'Avatar Type', 'adminify' ),
            'options'    => [
            'rounded' => __( 'Rounded', 'adminify' ),
            'square'  => __( 'Square', 'adminify' ),
        ],
            'default'    => $this->get_default_field( 'menu_layout_settings' )['user_info_avatar'],
            'dependency' => [
            'user_info|layout_type',
            '==|==',
            'true|vertical',
            'true'
        ],
        ];
        $settings_tab[] = [
            'type'       => 'notice',
            'title'      => __( 'Menu Item Style', 'adminify' ),
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'layout_type',
            '==',
            'horizontal',
            'true'
        ],
        ];
        $settings_tab[] = [
            'type'       => 'notice',
            'title'      => __( 'Show Blog Link', 'adminify' ),
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'layout_type',
            '==',
            'horizontal',
            'true'
        ],
        ];
        $settings_tab[] = [
            'type'       => 'notice',
            'title'      => __( 'Dropdown Toggle Icon', 'adminify' ),
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'layout_type',
            '==',
            'horizontal',
            'true'
        ],
        ];
        $settings_tab[] = [
            'type'       => 'notice',
            'title'      => __( 'Top Menu Links', 'adminify' ),
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'layout_type',
            '==',
            'horizontal',
            'true'
        ],
        ];
        $settings_tab[] = [
            'type'       => 'notice',
            'title'      => __( 'Bubble Icon', 'adminify' ),
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'layout_type',
            '==',
            'horizontal',
            'true'
        ],
        ];
        $settings_tab[] = [
            'type'       => 'notice',
            'title'      => __( 'Break Long Lists', 'adminify' ),
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'layout_type',
            '==',
            'horizontal',
            'true'
        ],
        ];
    }
    
    public function menu_layout_style_tab( &$menu_styles_tab )
    {
        $menu_styles_tab[] = [
            'type'    => 'subheading',
            'content' => __( 'Menu Styles', 'adminify' ),
        ];
        $menu_styles_tab[] = [
            'id'                 => 'menu_typography',
            'type'               => 'typography',
            'title'              => __( 'Font Settings', 'adminify' ),
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
            'default'            => $this->get_default_field( 'menu_layout_settings' )['menu_styles']['menu_typography'],
        ];
        $menu_styles_tab[] = [
            'id'      => 'menu_wrapper_padding',
            'type'    => 'spacing',
            'title'   => __( 'Menu Wrapper Padding', 'adminify' ),
            'default' => $this->get_default_field( 'menu_layout_settings' )['menu_styles']['menu_wrapper_padding'],
        ];
        $menu_styles_tab[] = [
            'id'         => 'menu_vertical_padding',
            'type'       => 'slider',
            'title'      => __( 'Parent Menu Vertical Padding', 'adminify' ),
            'unit'       => 'px',
            'min'        => 1,
            'max'        => 100,
            'step'       => 1,
            'default'    => $this->get_default_field( 'menu_layout_settings' )['menu_styles']['menu_vertical_padding'],
            'dependency' => [
            'layout_type',
            '==',
            'vertical',
            'true'
        ],
        ];
        $menu_styles_tab[] = [
            'type'       => 'notice',
            'title'      => __( 'Parent Menu Horizontal Padding', 'adminify' ),
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'layout_type',
            '==',
            'horizontal',
            'true'
        ],
        ];
        $menu_styles_tab[] = [
            'id'      => 'submenu_wrapper_padding',
            'type'    => 'spacing',
            'title'   => __( 'Sub Menu Wrapper Padding', 'adminify' ),
            'default' => $this->get_default_field( 'menu_layout_settings' )['menu_styles']['submenu_wrapper_padding'],
        ];
        $menu_styles_tab[] = [
            'id'      => 'submenu_vertical_space',
            'type'    => 'slider',
            'title'   => __( 'Sub Menu Vertical Padding', 'adminify' ),
            'unit'    => 'px',
            'min'     => 1,
            'max'     => 100,
            'step'    => 1,
            'default' => $this->get_default_field( 'menu_layout_settings' )['menu_styles']['submenu_vertical_space'],
        ];
        $menu_styles_tab[] = [
            'type'    => 'subheading',
            'content' => __( 'Color Settings', 'adminify' ),
        ];
        $menu_styles_tab[] = [
            'id'      => 'parent_menu_colors',
            'type'    => 'color_group',
            'title'   => __( 'Parent Menu Colors', 'adminify' ),
            'options' => [
            'wrap_bg'      => __( 'Wrap BG', 'adminify' ),
            'hover_bg'     => __( 'Menu Hover BG', 'adminify' ),
            'text_color'   => __( 'Text Color', 'adminify' ),
            'text_hover'   => __( 'Text Hover', 'adminify' ),
            'active_bg'    => __( 'Active Menu BG', 'adminify' ),
            'active_color' => __( 'Active Menu Color', 'adminify' ),
        ],
            'default' => $this->get_default_field( 'menu_layout_settings' )['menu_styles']['parent_menu_colors'],
        ];
        $menu_styles_tab[] = [
            'id'      => 'sub_menu_colors',
            'type'    => 'color_group',
            'title'   => __( 'Sub Menu Colors', 'adminify' ),
            'options' => [
            'wrap_bg'      => __( 'Wrap BG', 'adminify' ),
            'hover_bg'     => __( 'Submenu Hover BG', 'adminify' ),
            'text_color'   => __( 'Text Color', 'adminify' ),
            'text_hover'   => __( 'Text Hover', 'adminify' ),
            'active_bg'    => __( 'Active Submenu BG', 'adminify' ),
            'active_color' => __( 'Active Submenu Color', 'adminify' ),
        ],
            'default' => $this->get_default_field( 'menu_layout_settings' )['menu_styles']['sub_menu_colors'],
        ];
        $menu_styles_tab[] = [
            'id'      => 'notif_colors',
            'type'    => 'color_group',
            'title'   => __( 'Notification Colors', 'adminify' ),
            'options' => [
            'notif_bg'    => __( 'Background', 'adminify' ),
            'notif_color' => __( 'Text Color', 'adminify' ),
        ],
            'default' => $this->get_default_field( 'menu_layout_settings' )['menu_styles']['notif_colors'],
        ];
    }
    
    public function user_info_style_tab( &$user_info_styles_tab )
    {
        $user_info_styles_tab[] = [
            'type'    => 'subheading',
            'content' => __( 'User Info Style', 'adminify' ),
        ];
        $user_info_styles_tab[] = [
            'type'    => 'notice',
            'title'   => __( 'Link Color', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
        $user_info_styles_tab[] = [
            'type'    => 'notice',
            'title'   => __( 'Hover Color', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
        $user_info_styles_tab[] = [
            'type'    => 'notice',
            'title'   => __( 'Border', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
        $user_info_styles_tab[] = [
            'type'    => 'notice',
            'title'   => __( 'Icon Color', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
        $user_info_styles_tab[] = [
            'type'    => 'notice',
            'title'   => __( 'Hover Icon Color', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
    }
    
    public function menu_styles_tab( &$styles_tab )
    {
        $menu_styles_tab = [];
        $user_info_styles_tab = [];
        $this->menu_layout_style_tab( $menu_styles_tab );
        $this->user_info_style_tab( $user_info_styles_tab );
        $styles_tab[] = [
            'id'     => 'menu_styles',
            'type'   => 'fieldset',
            'title'  => '',
            'fields' => $menu_styles_tab,
        ];
        $styles_tab[] = [
            'id'         => 'user_info_style',
            'type'       => 'fieldset',
            'title'      => '',
            'fields'     => $user_info_styles_tab,
            'dependency' => [
            'layout_type',
            '==',
            'vertical',
            'true'
        ],
        ];
    }
    
    public function menu_layout_settings()
    {
        if ( !class_exists( 'ADMINIFY' ) ) {
            return;
        }
        $settings_tab = [];
        $styles_tab = [];
        $this->menu_layout_settings_tab( $settings_tab );
        $this->menu_styles_tab( $styles_tab );
        // Menu Layout Section
        \ADMINIFY::createSection( $this->prefix, [
            'title'  => __( 'Menu Settings', 'adminify' ),
            'icon'   => 'fas fa-bars',
            'fields' => [ [
            'type'    => 'subheading',
            'content' => Utils::adminfiy_help_urls(
            __( 'Menu Settings', 'adminify' ),
            'https://wpadminify.com/kb/dashboard-menu-settings/',
            'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
            'https://www.facebook.com/groups/jeweltheme',
            'https://wpadminify.com/support/'
        ),
        ], [
            'id'    => 'menu_layout_settings',
            'type'  => 'tabbed',
            'title' => '',
            'tabs'  => [ [
            'title'  => 'Settings',
            'fields' => $settings_tab,
        ], [
            'title'  => 'Styles',
            'fields' => $styles_tab,
        ] ],
        ] ],
        ] );
    }

}