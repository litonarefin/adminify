<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Modules\LoginCustomizer\Inc\Customize_Model ;
// Cannot access directly.
if ( !defined( 'ABSPATH' ) ) {
    die;
}
class Logo_Section extends Customize_Model
{
    public function __construct()
    {
        $this->logo_section_customizer();
    }
    
    public function get_defaults()
    {
        return [
            'show_logo'         => true,
            'logo_settings'     => 'image-only',
            'logo_image'        => '',
            'logo_text'         => get_bloginfo( 'name' ),
            'logo_login_url'    => [
            'url'    => site_url( '/' ),
            'text'   => get_bloginfo( 'name' ),
            'target' => '_blank',
        ],
            'login_page_title'  => '',
            'login_title_style' => [
            'logo_heigh_width'       => [
            'width'  => '100',
            'height' => '50',
            'unit'   => '%',
        ],
            'login_title_typography' => [
            'font-family' => 'Lato',
            'font-weight' => '900',
            'subset'      => 'latin',
            'type'        => 'google',
        ],
            'logo_padding'           => [
            'top'    => '',
            'right'  => '',
            'bottom' => '',
            'left'   => '',
        ],
        ],
        ];
    }
    
    public function logo_section_settings( &$logo_settings )
    {
        $login_title_style = [];
        $this->login_title_style_settings( $login_title_style );
        $logo_settings[] = [
            'id'       => 'show_logo',
            'type'     => 'switcher',
            'title'    => __( 'Display Logo?', 'adminify' ),
            'default'  => $this->get_default_field( 'show_logo' ),
            'text_on'  => 'Yes',
            'text_off' => 'No',
            'class'    => 'wp-adminify-cs',
        ];
        $logo_settings[] = [
            'id'         => 'logo_settings',
            'type'       => 'button_set',
            'title'      => __( 'Logo Type', 'adminify' ),
            'help'       => __( 'Select the way you want to display Logo', 'adminify' ),
            'options'    => [
            'text-only'  => __( 'Text', 'adminify' ),
            'image-only' => __( 'Image', 'adminify' ),
            'both'       => __( 'Image & Text', 'adminify' ),
            'none'       => __( 'None', 'adminify' ),
        ],
            'default'    => $this->get_default_field( 'logo_settings' ),
            'dependency' => [ 'show_logo', '==', 'true' ],
        ];
        $logo_settings[] = [
            'id'           => 'logo_image',
            'type'         => 'media',
            'title'        => __( 'Logo Image', 'adminify' ),
            'library'      => 'image',
            'preview'      => true,
            'preview_size' => 'full',
            'dependency'   => [ [ 'show_logo|logo_settings|logo_settings', '==|!=|!=', 'true|text-only|none' ] ],
        ];
        $logo_settings[] = [
            'id'          => 'logo_text',
            'type'        => 'text',
            'title'       => __( 'Text Logo', 'adminify' ),
            'default'     => $this->get_default_field( 'logo_text' ),
            'placeholder' => __( 'Enter Logo Text here', 'adminify' ),
            'dependency'  => [ [
            'show_logo|logo_settings|logo_settings',
            '==|!=|!=',
            'true|image-only|none',
            true
        ] ],
        ];
        $logo_settings[] = [
            'id'         => 'logo_login_url',
            'type'       => 'link',
            'title'      => 'Logo Link',
            'default'    => $this->get_default_field( 'logo_login_url' ),
            'dependency' => [ [ 'show_logo|logo_settings', '==|!=', 'true|none' ] ],
        ];
        $logo_settings[] = [
            'id'          => 'login_page_title',
            'type'        => 'text',
            'title'       => __( 'Login Page Title', 'adminify' ),
            'placeholder' => __( 'Enter Login Page Title here', 'adminify' ),
        ];
        $logo_settings[] = [
            'type'       => 'heading',
            'content'    => __( 'Logo Style', 'adminify' ),
            'dependency' => [ [ 'show_logo', '==', 'true' ] ],
        ];
        $logo_settings[] = [
            'id'         => 'login_title_style',
            'type'       => 'fieldset',
            'dependency' => [ [ 'show_logo', '==', 'true' ] ],
            'fields'     => $login_title_style,
        ];
    }
    
    public function login_title_style_settings( &$login_title_style )
    {
        $login_title_style[] = [
            'id'          => 'logo_heigh_width',
            'type'        => 'dimensions',
            'width_icon'  => 'width',
            'height_icon' => 'height',
            'units'       => [
            'px',
            '%',
            'em',
            'rem',
            'pt'
        ],
            'default'     => $this->get_default_field( 'login_title_style' )['logo_heigh_width'],
        ];
        $login_title_style[] = [
            'type'       => 'notice',
            'title'      => __( 'Title Typography', 'adminify' ),
            'style'      => 'warning',
            'content'    => Utils::adminify_upgrade_pro(),
            'dependency' => [ [
            'show_logo|logo_settings|logo_settings',
            '==|!=|!=',
            'true|image-only|none',
            true
        ] ],
        ];
        $login_title_style[] = [
            'type'    => 'notice',
            'title'   => __( 'Padding', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
    }
    
    public function logo_section_customizer()
    {
        if ( !class_exists( 'ADMINIFY' ) ) {
            return;
        }
        $logo_settings = [];
        $this->logo_section_settings( $logo_settings );
        /**
         * Section: Logo Section
         */
        \ADMINIFY::createSection( $this->prefix, [
            'assign' => 'jltwp_adminify_customizer_logo_section',
            'title'  => __( 'Logo', 'adminify' ),
            'fields' => $logo_settings,
        ] );
    }

}