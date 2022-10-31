<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Modules\LoginCustomizer\Inc\Customize_Model ;
if ( !defined( 'ABSPATH' ) ) {
    die;
}
// Cannot access directly.
class Background_Section extends Customize_Model
{
    public function __construct()
    {
        $this->adminify_background_customizer();
    }
    
    public function get_defaults()
    {
        return [
            'jltwp_adminify_login_bg_video_type'             => '',
            'jltwp_adminify_login_bg_video_self_hosted'      => '',
            'jltwp_adminify_login_bg_video_youtube'          => '',
            'jltwp_adminify_login_bg_video_loop'             => true,
            'jltwp_adminify_login_bg_video_poster'           => '',
            'jltwp_adminify_login_bg_slideshow'              => '',
            'jltwp_adminify_login_bg_type'                   => 'color_image',
            'jltwp_adminify_login_bg_color_opt'              => 'color',
            'jltwp_adminify_login_bg_color'                  => [
            'background-color'      => '',
            'background-position'   => 'center center',
            'background-repeat'     => 'repeat-x',
            'background-attachment' => 'fixed',
            'background-size'       => 'cover',
        ],
            'jltwp_adminify_login_gradient_bg'               => [
            'background-color'              => '',
            'background-gradient-color'     => '',
            'background-gradient-direction' => '',
            'background-position'           => 'center center',
            'background-repeat'             => 'repeat-x',
            'background-attachment'         => 'fixed',
            'background-size'               => 'cover',
            'background-origin'             => 'border-box',
            'background-clip'               => 'padding-box',
            'background-blend-mode'         => 'normal',
        ],
            'jltwp_adminify_login_bg_overlay_type'           => '',
            'jltwp_adminify_login_bg_overlay_color'          => '',
            'jltwp_adminify_login_bg_overlay_gradient_color' => '',
            'jltwp_adminify_login_overlay_opacity'           => '',
        ];
    }
    
    /**
     * Background Settings
     */
    public function login_customizer_bg_settings( &$bg_fields )
    {
        $bg_fields[] = [
            'id'      => 'jltwp_adminify_login_bg_type',
            'type'    => 'button_set',
            'options' => [
            'color_image' => __( 'Color/Image', 'adminify' ),
            'video'       => __( 'Video', 'adminify' ),
            'slideshow'   => __( 'Slideshow', 'adminify' ),
        ],
            'default' => $this->get_default_field( 'jltwp_adminify_login_bg_type' ),
        ];
        $bg_fields[] = [
            'id'         => 'jltwp_adminify_login_bg_color_opt',
            'type'       => 'button_set',
            'options'    => [
            'color'    => __( 'Color ', 'adminify' ),
            'gradient' => __( 'Gradient', 'adminify' ),
        ],
            'default'    => $this->get_default_field( 'jltwp_adminify_login_bg_color_opt' ),
            'dependency' => [
            'jltwp_adminify_login_bg_type',
            '==',
            'color_image',
            true
        ],
        ];
        $bg_fields[] = [
            'id'         => 'jltwp_adminify_login_bg_color',
            'type'       => 'background',
            'title'      => 'Background',
            'default'    => $this->get_default_field( 'jltwp_adminify_login_bg_color' ),
            'dependency' => [
            'jltwp_adminify_login_bg_type|jltwp_adminify_login_bg_color_opt',
            '==|==',
            'color_image|color',
            true
        ],
        ];
        $bg_fields[] = [
            'type'       => 'notice',
            'title'      => __( 'Background', 'adminify' ),
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'jltwp_adminify_login_bg_type|jltwp_adminify_login_bg_color_opt',
            '==|==',
            'color_image|gradient',
            true
        ],
        ];
        $bg_fields[] = [
            'type'       => 'notice',
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [ 'jltwp_adminify_login_bg_type', 'any', 'video,slideshow' ],
        ];
        $bg_fields[] = [
            'id'      => 'jltwp_adminify_login_bg_overlay_type',
            'type'    => 'button_set',
            'title'   => __( 'Overlay', 'adminify' ),
            'options' => [
            'color'    => __( 'Color ', 'adminify' ),
            'gradient' => __( 'Gradient', 'adminify' ),
        ],
            'default' => $this->get_default_field( 'jltwp_adminify_login_bg_overlay_type' ),
        ];
        $bg_fields[] = [
            'id'                    => 'jltwp_adminify_login_bg_overlay_color',
            'type'                  => 'background',
            'background_image'      => false,
            'background_position'   => false,
            'background_repeat'     => false,
            'background_attachment' => false,
            'background_size'       => false,
            'default'               => $this->get_default_field( 'jltwp_adminify_login_bg_overlay_color' ),
            'dependency'            => [
            'jltwp_adminify_login_bg_overlay_type',
            '==',
            'color',
            true
        ],
        ];
        $bg_fields[] = [
            'type'       => 'notice',
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [ 'jltwp_adminify_login_bg_overlay_type', '==', 'gradient' ],
        ];
        $bg_fields[] = [
            'id'         => 'jltwp_adminify_login_overlay_opacity',
            'type'       => 'slider',
            'title'      => __( 'Overlay Opacity', 'adminify' ),
            'dependency' => [
            'jltwp_adminify_login_bg_overlay_type',
            '!=',
            '',
            true
        ],
            'default'    => $this->get_default_field( 'jltwp_adminify_login_overlay_opacity' ),
        ];
    }
    
    public function adminify_background_customizer()
    {
        if ( !class_exists( 'ADMINIFY' ) ) {
            return;
        }
        $bg_fields = [];
        $this->login_customizer_bg_settings( $bg_fields );
        /**
         * Section: Background Section
         */
        \ADMINIFY::createSection( $this->prefix, [
            'assign' => 'jltwp_adminify_customizer_bg_section',
            'title'  => __( 'Background', 'adminify' ),
            'fields' => $bg_fields,
        ] );
    }

}