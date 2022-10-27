<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Customize_Model;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

class Google_Fonts extends Customize_Model
{
    public function __construct()
    {
        $this->google_fonts_customizer();
    }


    public function get_defaults()
    {
        return [
            'login_google_font' => array(
                'font-family' => 'Lato',
                'type'        => 'google',
            )
        ];
    }


    /**
     * Google Fonts Settings
     *
     * @param [type] $fonts_field
     *
     * @return void
     */
    public function google_fonts_settings(&$fonts_field)
    {
        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $fonts_field[] = array(
                'id'                 => 'login_google_font',
                'type'               => 'typography',
                'title'              => 'Typography',
                'font_family'        => true,
                'font_weight'        => true,
                'font_style'         => false,
                'font_size'          => true,
                'line_height'        => true,
                'letter_spacing'     => true,
                'text_align'         => true,
                'text-transform'     => true,
                'color'              => true,
                'subset'             => true,
                'backup_font_family' => false,
                'font_variant'       => false,
                'word_spacing'       => true,
                'text_decoration'    => true,
                'default'            => $this->get_default_field('login_google_font')
            );
        } else {
            $fonts_field[] = array(
                'type'       => 'notice',
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro()
            );
        }
    }


    public function google_fonts_customizer()
    {
        if (!class_exists('ADMINIFY')) {
            return;
        }

        $fonts_field = [];
        $this->google_fonts_settings($fonts_field);

        /**
         * Section: Google Fonts Section
         */
        \ADMINIFY::createSection(
            $this->prefix,
            array(
                'assign' => 'jltwp_adminify_customizer_fonts_section',
                'title'  => __('Google Fonts', 'adminify'),
                'fields' => $fonts_field
            )
        );
    }
}
