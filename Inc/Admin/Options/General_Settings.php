<?php

namespace WPAdminify\Inc\Admin\Options;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Admin\AdminSettingsModel ;
if ( !defined( 'ABSPATH' ) ) {
    die;
}
// Cannot access directly.
class General_Settings extends AdminSettingsModel
{
    public function __construct()
    {
        $this->general_settings();
    }
    
    public function get_defaults()
    {
        return [
            'adminify_theme'                     => 'preset1',
            'adminify_theme_custom_colors'       => [
            '--adminify-preset-background'    => '#F9F9F9',
            '--adminify-menu-bg'              => '#4738a6',
            '--adminify-menu-text-color'      => '#ffffff',
            '--adminify-admin-bar-bg'         => '#4738a6',
            '--adminify-admin-bar-icon'       => '#ffffff',
            '--adminify-admin-bar-input-bg'   => '#594caf',
            '--adminify-admin-bar-input-text' => '#ffffff',
            '--adminify-notif-bg-color'       => '#FD49A0',
            '--adminify-btn-bg'               => '#48c7fd',
        ],
            'admin_general_google_font'          => [
            'font-family' => 'Nunito Sans',
            'font-weight' => '400',
            'type'        => 'google',
            'font-size'   => '',
            'line-height' => '',
            'color'       => '',
            'output'      => 'body',
        ],
            'admin_general_bg'                   => 'color',
            'admin_general_bg_color'             => '',
            'admin_general_bg_gradient'          => [
            'background-color'              => '#0347FF',
            'background-gradient-color'     => '#fd1919',
            'background-gradient-direction' => '135deg',
        ],
            'admin_general_bg_image'             => '',
            'admin_general_bg_slideshow'         => '',
            'admin_general_bg_video_type'        => 'youtube',
            'admin_general_bg_video_self_hosted' => '',
            'admin_general_bg_video_youtube'     => '',
            'admin_general_bg_video_loop'        => true,
            'admin_general_bg_video_poster'      => '',
            'admin_glass_effect'                 => true,
            'admin_general_button_color'         => [
            'primary_color'   => '#0347FF',
            'secondary_color' => '#fff',
        ],
            'admin_danger_button_color'          => [
            'primary_color'   => '#c30052',
            'secondary_color' => '#fff',
        ],
        ];
    }
    
    public function general_template_preset_google_fonts( &$fields )
    {
        $fields[] = [
            'type'    => 'subheading',
            'content' => Utils::adminfiy_help_urls(
            __( 'Customize Settings', 'adminify' ),
            'https://wpadminify.com/kb/admin-customization/',
            'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
            'https://www.facebook.com/groups/jeweltheme',
            'https://wpadminify.com/support/'
        ),
        ];
        $fields[] = [
            'id'      => 'adminify_theme',
            'type'    => 'image_select',
            'title'   => __( 'Adminify UI Templates', 'adminify' ),
            'options' => [
            'preset1' => WP_ADMINIFY_ASSETS_IMAGE . 'presets/preset-1.png',
            'preset2' => WP_ADMINIFY_ASSETS_IMAGE . 'presets/preset-2.png',
            'preset3' => WP_ADMINIFY_ASSETS_IMAGE . 'presets/preset-3.png',
            'preset4' => WP_ADMINIFY_ASSETS_IMAGE . 'presets/preset-4.png',
            'preset5' => WP_ADMINIFY_ASSETS_IMAGE . 'presets/preset-5.png',
            'preset6' => WP_ADMINIFY_ASSETS_IMAGE . 'presets/preset-6.png',
            'preset7' => WP_ADMINIFY_ASSETS_IMAGE . 'presets/preset-7.png',
            'preset8' => WP_ADMINIFY_ASSETS_IMAGE . 'presets/preset-8.png',
            'preset9' => WP_ADMINIFY_ASSETS_IMAGE . 'presets/preset-9.png',
            'custom'  => WP_ADMINIFY_ASSETS_IMAGE . 'presets/preset-10.png',
        ],
            'default' => $this->get_default_field( 'adminify_theme' ),
        ];
        $fields[] = [
            'title'      => '',
            'type'       => 'notice',
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'adminify_theme|adminify_theme',
            '!=|!=',
            'preset1|preset2',
            'any'
        ],
        ];
        $fields[] = [
            'title'   => 'Body Font',
            'type'    => 'notice',
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
    }
    
    public function general_gradient_bg( &$fields )
    {
        $fields[] = [
            'title'      => '',
            'type'       => 'notice',
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'admin_general_bg',
            '==',
            'gradient',
            true
        ],
        ];
    }
    
    public function general_image_bg( &$fields )
    {
        $fields[] = [
            'title'      => '',
            'type'       => 'notice',
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'admin_general_bg',
            '==',
            'image',
            true
        ],
        ];
    }
    
    public function general_slideshow_bg( &$fields )
    {
        $fields[] = [
            'title'      => '',
            'type'       => 'notice',
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'admin_general_bg',
            '==',
            'slideshow',
            true
        ],
        ];
    }
    
    public function general_glass_effect_bg( &$fields )
    {
        $fields[] = [
            'title'   => __( 'Glass Effect', 'adminify' ),
            'type'    => 'notice',
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
    }
    
    public function general_video_bg( &$fields )
    {
        $fields[] = [
            'title'      => '',
            'type'       => 'notice',
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'admin_general_bg',
            '==',
            'video',
            true
        ],
        ];
    }
    
    public function general_fields( &$fields )
    {
        $fields[] = [
            'type'    => 'subheading',
            'content' => __( 'Body Background', 'adminify' ),
        ];
        $fields[] = [
            'id'      => 'admin_general_bg',
            'type'    => 'button_set',
            'title'   => 'Background Type',
            'options' => [
            'color'     => 'Color',
            'gradient'  => 'Gradient',
            'image'     => 'Image',
            'slideshow' => 'Slideshow',
            'video'     => 'Video',
        ],
            'default' => 'color',
        ];
        $fields[] = [
            'id'         => 'admin_general_bg_color',
            'type'       => 'color',
            'title'      => 'Background Color',
            'default'    => '',
            'dependency' => [
            'admin_general_bg',
            '==',
            'color',
            true
        ],
        ];
    }
    
    public function general_customization( &$fields )
    {
        $fields[] = [
            'type'    => 'subheading',
            'content' => __( 'General Customization', 'adminify' ),
        ];
        $fields[] = [
            'id'       => 'admin_general_button_color',
            'type'     => 'color_group',
            'title'    => __( 'Button', 'adminify' ),
            'subtitle' => __( 'Change Admin Button Colors', 'adminify' ),
            'options'  => [
            'primary_color'   => __( 'Primary Color', 'adminify' ),
            'secondary_color' => __( 'Secondary Color', 'adminify' ),
        ],
            'default'  => $this->get_default_field( 'admin_general_button_color' ),
        ];
        $fields[] = [
            'id'       => 'admin_danger_button_color',
            'type'     => 'color_group',
            'title'    => __( 'Danger Button', 'adminify' ),
            'subtitle' => __( 'Change Admin Delete Button Colors', 'adminify' ),
            'options'  => [
            'primary_color'   => __( 'Primary Color', 'adminify' ),
            'secondary_color' => __( 'Secondary Color', 'adminify' ),
        ],
            'default'  => $this->get_default_field( 'admin_danger_button_color' ),
        ];
    }
    
    public function general_settings()
    {
        if ( !class_exists( 'ADMINIFY' ) ) {
            return;
        }
        $fields = [];
        $this->general_template_preset_google_fonts( $fields );
        $this->general_fields( $fields );
        $this->general_gradient_bg( $fields );
        $this->general_image_bg( $fields );
        $this->general_slideshow_bg( $fields );
        $this->general_video_bg( $fields );
        // self::general_glass_effect_bg($fields);
        $this->general_customization( $fields );
        \ADMINIFY::createSection( $this->prefix, [
            'title'  => __( 'Customize', 'adminify' ),
            'icon'   => 'fas fa-fill-drip',
            'fields' => $fields,
        ] );
    }

}