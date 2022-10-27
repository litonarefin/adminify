<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings;

use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Customize_Model;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

class Credits_Section extends Customize_Model
{
    public function __construct()
    {
        $this->credits_customizer();
    }

    public function get_defaults()
    {
        return [
            'jltwp_adminify_credits' => true,
            'credits_text_color'     => '',
            'credits_logo_position'  => array(
                'background-position' => 'right bottom'
            )
        ];
    }



    public function credits_settings(&$credit_fields)
    {
        $credit_fields[] = array(
            'type'    => 'heading',
            'content' => __('Show Some Love', 'adminify'),
        );
        $credit_fields[] = array(
            'type'    => 'notice',
            'style'   => 'normal',
            'content' => __('Show some love and help others to learn about this free plugin by adding a Powered by WP Adminify Logo to your login page', 'adminify'),
        );
        $credit_fields[] = array(
            'id'       => 'jltwp_adminify_credits',
            'type'     => 'switcher',
            'title'    => __('Enable Credits?', 'adminify'),
            'text_on'  => 'Yes',
            'text_off' => 'No',
            'default'  => $this->get_default_field('jltwp_adminify_credits'),
            'class'    => 'wp-adminify-cs',
        );
        $credit_fields[] = array(
            'id'         => 'credits_text_color',
            'type'       => 'color',
            'title'      => __('Text Color', 'adminify'),
            'class'      => 'wp-adminify-cs',
            'dependency' => array('jltwp_adminify_credits', '==', 'true'),
        );
        // array(
        //     'id'      => 'jltwp_adminify_customizer_credits_logo_color',
        //     'type'    => 'color',
        //     'title'   => 'Logo Color',
        //     'dependency' => array('jltwp_adminify_credits', '==', 'true'),
        // ),
        $credit_fields[] = array(
            'id'                    => 'credits_logo_position',
            'type'                  => 'background',
            'title'                 => __('Position', 'adminify'),
            'background_color'      => false,
            'background_image'      => false,
            'background_position'   => true,
            'background_repeat'     => false,
            'background_attachment' => false,
            'background_size'       => false,
            'background_origin'     => false,
            'background_clip'       => false,
            'background_blend_mode' => false,
            'background_gradient'   => false,
            'default'               => $this->get_default_field('credits_logo_position'),
            'class'                 => 'wp-adminify-cs',
            'dependency'            => array('jltwp_adminify_credits', '==', 'true'),
        );
    }


    public function credits_customizer()
    {
        if (!class_exists('ADMINIFY')) {
            return;
        }

        $credit_fields = [];
        $this->credits_settings($credit_fields);

        /**
         * Section: Credits Section
         */
        \ADMINIFY::createSection(
            $this->prefix,
            array(
                'assign' => 'jltwp_adminify_customizer_credits_section',
                'title'  => __('Credits', 'adminify'),
                'fields' => $credit_fields
            )
        );
    }
}
