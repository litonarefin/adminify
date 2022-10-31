<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Modules\LoginCustomizer\Inc\Customize_Model ;
if ( !defined( 'ABSPATH' ) ) {
    die;
}
// Cannot access directly.
class Form_Section extends Customize_Model
{
    public function __construct()
    {
        $this->form_customizer();
    }
    
    public function get_defaults()
    {
        return [
            'login_form_bg_type'       => 'color',
            'login_form_bg_color'      => [
            'background-color'      => '',
            'background-position'   => 'center center',
            'background-repeat'     => 'repeat-x',
            'background-attachment' => 'fixed',
            'background-size'       => 'cover',
        ],
            'login_form_bg_gradient'   => [
            'background-color'              => '#009e44',
            'background-gradient-color'     => '#81d742',
            'background-gradient-direction' => '135deg',
        ],
            'login_form_height_width'  => [
            'width'  => '',
            'height' => '',
            'unit'   => 'px',
        ],
            'login_form_margin'        => '',
            'login_form_padding'       => '',
            'login_form_border'        => '',
            'login_form_border_radius' => '',
            'login_form_box_shadow'    => [
            'bs_color'      => 'transparent',
            'bs_hz'         => '',
            'bs_ver'        => '',
            'bs_blur'       => '',
            'bs_spread'     => '',
            'bs_spread_pos' => '',
        ],
        ];
    }
    
    /**
     * Login Form Box Shadow
     *
     * @param [type] $login_form_box_shadow
     *
     * @return void
     */
    public function login_form_box_shadow_settings( &$login_form_box_shadow )
    {
        $login_form_box_shadow[] = [
            'type'    => 'notice',
            'title'   => __( 'Color', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
        $login_form_box_shadow[] = [
            'type'    => 'notice',
            'title'   => __( 'Horizontal', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
        $login_form_box_shadow[] = [
            'type'    => 'notice',
            'title'   => __( 'Vertical', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
        $login_form_box_shadow[] = [
            'type'    => 'notice',
            'title'   => __( 'Blur', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
        $login_form_box_shadow[] = [
            'type'    => 'notice',
            'title'   => __( 'Spread', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
        $login_form_box_shadow[] = [
            'type'    => 'notice',
            'title'   => __( 'Position', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
    }
    
    /**
     * Login Form Settings
     */
    public function login_form_settings( &$login_form_settings )
    {
        $login_form_box_shadow = [];
        $this->login_form_box_shadow_settings( $login_form_box_shadow );
        $login_form_settings[] = [
            'type'    => 'subheading',
            'content' => __( 'Background', 'adminify' ),
        ];
        $login_form_settings[] = [
            'id'      => 'login_form_bg_type',
            'type'    => 'button_set',
            'options' => [
            'color'    => __( 'Color & Image', 'adminify' ),
            'gradient' => __( 'Gradient', 'adminify' ),
        ],
            'default' => $this->get_default_field( 'login_form_bg_type' ),
        ];
        $login_form_settings[] = [
            'id'         => 'login_form_bg_color',
            'type'       => 'background',
            'title'      => __( 'Background', 'adminify' ),
            'default'    => $this->get_default_field( 'login_form_bg_color' ),
            'dependency' => [
            'login_form_bg_type',
            '==',
            'color',
            'all'
        ],
        ];
        $login_form_settings[] = [
            'type'       => 'notice',
            'title'      => __( 'Background Option with Gradient Color', 'adminify' ),
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'login_form_bg_type',
            '==',
            'gradient',
            'all'
        ],
        ];
        $login_form_settings[] = [
            'type'    => 'subheading',
            'content' => __( 'Form Width & Height', 'adminify' ),
        ];
        $login_form_settings[] = [
            'id'      => 'login_form_height_width',
            'type'    => 'dimensions',
            'title'   => __( 'Width & Height', 'adminify' ),
            'default' => $this->get_default_field( 'login_form_height_width' ),
        ];
        $login_form_settings[] = [
            'type'    => 'notice',
            'title'   => __( 'Margin', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
        $login_form_settings[] = [
            'type'    => 'notice',
            'title'   => __( 'Padding', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
        $login_form_settings[] = [
            'type'  => 'subheading',
            'title' => __( 'Border', 'adminify' ),
        ];
        $login_form_settings[] = [
            'id'      => 'login_form_border',
            'type'    => 'border',
            'default' => $this->get_default_field( 'login_form_border' ),
            'title'   => __( 'Border', 'adminify' ),
        ];
        $login_form_settings[] = [
            'type'    => 'notice',
            'title'   => __( 'Border Radius', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
        $login_form_settings[] = [
            'type'    => 'subheading',
            'content' => __( 'Box Shadow', 'adminify' ),
        ];
        $login_form_settings[] = [
            'id'     => 'login_form_box_shadow',
            'type'   => 'fieldset',
            'fields' => $login_form_box_shadow,
        ];
    }
    
    public function form_customizer()
    {
        if ( !class_exists( 'ADMINIFY' ) ) {
            return;
        }
        $login_form_settings = [];
        $this->login_form_settings( $login_form_settings );
        /**
         * Section: Form Options
         */
        \ADMINIFY::createSection( $this->prefix, [
            'assign' => 'jltwp_adminify_customizer_login_form_section',
            'title'  => __( 'Login Form', 'adminify' ),
            'fields' => $login_form_settings,
        ] );
    }

}