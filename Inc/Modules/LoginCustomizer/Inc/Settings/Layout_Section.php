<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Modules\LoginCustomizer\Inc\Customize_Model ;
if ( !defined( 'ABSPATH' ) ) {
    die;
}
// Cannot access directly.
class Layout_Section extends Customize_Model
{
    public function __construct()
    {
        $this->layout_customizer();
    }
    
    public function get_defaults()
    {
        return [
            'alignment_login_width'             => '',
            'alignment_login_column'            => '',
            'alignment_login_horizontal'        => '',
            'alignment_login_vertical'          => '',
            'alignment_login_bg_type'           => 'color',
            'alignment_login_bg_color'          => [
            'background-color'      => '',
            'background-position'   => 'center center',
            'background-repeat'     => 'repeat-x',
            'background-attachment' => 'fixed',
            'background-size'       => 'cover',
        ],
            'alignment_login_bg_gradient_color' => [
            'background-color'              => '',
            'background-gradient-color'     => '',
            'background-gradient-direction' => '',
        ],
            'alignment_login_bg_skew'           => 0,
        ];
    }
    
    public function layout_fields_settings( &$layout_fields )
    {
        $url = WP_ADMINIFY_URL . 'Inc/Modules/LoginCustomizer/assets/images/layouts/';
        $layout_fields[] = [
            'id'      => 'alignment_login_width',
            'type'    => 'image_select',
            'title'   => __( 'Layout', 'adminify' ),
            'options' => [
            'fullwidth'        => $url . 'width-full.png',
            'width_two_column' => $url . 'width-2column.png',
        ],
            'default' => $this->get_default_field( 'alignment_login_width' ),
        ];
        $layout_fields[] = [
            'id'         => 'alignment_login_column',
            'type'       => 'image_select',
            'title'      => __( 'Column Alignment', 'adminify' ),
            'options'    => [
            'top'    => $url . 'column-top.png',
            'right'  => $url . 'column-right.png',
            'bottom' => $url . 'column-bottom.png',
            'left'   => $url . 'column-left.png',
        ],
            'default'    => $this->get_default_field( 'alignment_login_column' ),
            'dependency' => [ 'alignment_login_width', '==', 'width_two_column' ],
        ];
        $layout_fields[] = [
            'id'      => 'alignment_login_horizontal',
            'type'    => 'image_select',
            'title'   => __( 'Horizontal Alignment', 'adminify' ),
            'options' => [
            'left_center'   => $url . 'form-left-center.png',
            'center_center' => $url . 'form-center.png',
            'right_center'  => $url . 'form-right-center.png',
        ],
            'default' => $this->get_default_field( 'alignment_login_horizontal' ),
        ];
        $layout_fields[] = [
            'id'      => 'alignment_login_vertical',
            'type'    => 'image_select',
            'title'   => __( 'Vertical Alignment', 'adminify' ),
            'options' => [
            'center_top'    => $url . 'form-center-top.png',
            'center_center' => $url . 'form-center-center.png',
            'center_bottom' => $url . 'form-center-bottom.png',
        ],
            'default' => $this->get_default_field( 'alignment_login_vertical' ),
        ];
        $layout_fields[] = [
            'id'      => 'alignment_login_bg_type',
            'type'    => 'button_set',
            'title'   => __( 'Side Background', 'adminify' ),
            'options' => [
            'color'    => __( 'Color ', 'adminify' ),
            'gradient' => __( 'Gradient', 'adminify' ),
        ],
            'default' => $this->get_default_field( 'alignment_login_bg_type' ),
            'class'   => 'wp-adminify-cs',
        ];
        $layout_fields[] = [
            'id'         => 'alignment_login_bg_color',
            'type'       => 'background',
            'default'    => $this->get_default_field( 'alignment_login_bg_color' ),
            'dependency' => [
            'alignment_login_bg_type',
            '==',
            'color',
            true
        ],
        ];
        $layout_fields[] = [
            'type'       => 'notice',
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'alignment_login_bg_type',
            '==',
            'gradient',
            true
        ],
        ];
        $layout_fields[] = [
            'type'       => 'notice',
            'title'      => __( 'Skew', 'adminify' ),
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [
            'alignment_login_width',
            '==',
            'fullwidth',
            true
        ],
        ];
    }
    
    public function layout_customizer()
    {
        if ( !class_exists( 'ADMINIFY' ) ) {
            return;
        }
        $layout_fields = [];
        $this->layout_fields_settings( $layout_fields );
        /**
         * Section: Layout Section
         */
        \ADMINIFY::createSection( $this->prefix, [
            'assign' => 'jltwp_adminify_customizer_layout_section',
            'title'  => __( 'Layout', 'adminify' ),
            'fields' => $layout_fields,
        ] );
    }

}