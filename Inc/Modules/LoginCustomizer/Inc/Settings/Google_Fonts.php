<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Modules\LoginCustomizer\Inc\Customize_Model ;
if ( !defined( 'ABSPATH' ) ) {
    die;
}
// Cannot access directly.
class Google_Fonts extends Customize_Model
{
    public function __construct()
    {
        $this->google_fonts_customizer();
    }
    
    public function get_defaults()
    {
        return [
            'login_google_font' => [
            'font-family' => 'Lato',
            'type'        => 'google',
        ],
        ];
    }
    
    /**
     * Google Fonts Settings
     *
     * @param [type] $fonts_field
     *
     * @return void
     */
    public function google_fonts_settings( &$fonts_field )
    {
        $fonts_field[] = [
            'type'    => 'notice',
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
    }
    
    public function google_fonts_customizer()
    {
        if ( !class_exists( 'ADMINIFY' ) ) {
            return;
        }
        $fonts_field = [];
        $this->google_fonts_settings( $fonts_field );
        /**
         * Section: Google Fonts Section
         */
        \ADMINIFY::createSection( $this->prefix, [
            'assign' => 'jltwp_adminify_customizer_fonts_section',
            'title'  => __( 'Google Fonts', 'adminify' ),
            'fields' => $fonts_field,
        ] );
    }

}