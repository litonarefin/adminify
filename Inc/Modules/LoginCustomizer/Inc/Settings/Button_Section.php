<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Customize_Model;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

class Button_Section extends Customize_Model
{
    public function __construct()
    {
        $this->button_customizer();
    }


    public function get_defaults()
    {
        return [
            'button_size'   => '',
            'button_font_size'   => '',
            'login_form_button_settings' => array(
                'button_bg'         => 'transparent',
                'button_text_color' => '',
                'button_text_shadow' => array(
                    'ts_color'  => 'transparent',
                    'ts_blur'  => '',
                    'ts_hz'  => '',
                    'ts_ver'  => '',
                ),
                'button_bg_hover'   => 'transparent',
                'button_text_hover'   => 'transparent',
                'button_text_shadow_hover' => array(
                    'ts_hover'  => 'transparent',
                    'ts_blur_hover'  => '',
                    'ts_hz_hover'  => '',
                    'ts_ver_hover'  => '',
                ),
                'button_margin' => '',
                'button_padding' => '',
                'button_border' => '',
                'button_border_radius' => '',
                'button_box_shadow' => array(
                    'bs_color'  => 'transparent',
                    'bs_hz'  => '',
                    'bs_ver'  => '',
                    'bs_blur'  => '',
                    'bs_spread'  => '',
                    'bs_spread_pos'  => '',
                ),
            ),
        ];
    }


    /**
     * Button Fields: Normal
     *
     * @param [type] $button_fields_normal
     *
     * @return void
     */
    public function button_fields_normal_settings(&$button_fields_normal)
    {
        $normal_text_shadow = [];
        $this->normal_button_text_shadow($normal_text_shadow);

        $button_fields_normal[] = array(
            'id'      => 'button_bg',
            'type'    => 'color',
            'title'   => __('Background', 'adminify'),
            'default' => $this->get_default_field('login_form_button_settings')['button_bg'],
            'class'   => 'wp-adminify-cs',
        );
        $button_fields_normal[] = array(
            'id'      => 'button_text_color',
            'type'    => 'color',
            'title'   => __('Text Color', 'adminify'),
            'default' => $this->get_default_field('login_form_button_settings')['button_text_color'],
            'class'   => 'wp-adminify-cs',
        );
        // array(
        //     'id'      => 'button_border_color',
        //     'type'    => 'border',
        //     'title'   => 'Border'
        // ),
        // array(
        //     'id'    => 'button_border_radius',
        //     'type'  => 'spacing',
        //     'title' => 'Border Radius',
        // ),

        $button_fields_normal[] = array(
            'type'    => 'subheading',
            'content' => __('Text Shadow', 'adminify'),
        );

        $button_fields_normal[] = array(
            'id'     => 'button_text_shadow',
            'type'   => 'fieldset',
            'fields' => $normal_text_shadow
        );

        // array(
        //     'type'    => 'subheading',
        //     'content' => 'Box Shadow',
        // ),

        // array(
        //     'id'     => 'button_box_shadow',
        //     'type'   => 'fieldset',
        //     'fields' => array(
        //         array(
        //             'id'      => 'bs_color',
        //             'type'    => 'color',
        //             'title'   => 'Color',
        //             'default' => 'transparent',
        //             'class'   => 'wp-adminify-cs',
        //         ),
        //         array(
        //             'id'    => 'bs_hz',
        //             'type'  => 'slider',
        //             'title' => 'Horizontal',
        //         ),
        //         array(
        //             'id'    => 'bs_ver',
        //             'type'  => 'slider',
        //             'title' => 'Vertical',
        //         ),
        //         array(
        //             'id'    => 'bs_blur',
        //             'type'  => 'slider',
        //             'title' => 'Blur',
        //         ),
        //         array(
        //             'id'    => 'bs_spread',
        //             'type'  => 'slider',
        //             'title' => 'Spread',
        //         ),
        //         array(
        //             'id'      => 'bs_spread_pos',
        //             'type'    => 'select',
        //             'title'   => 'Position',
        //             'options' => array(
        //                 ''        => 'Outline',
        //                 'inset'   => 'Inset'
        //             ),
        //             'default' => ''
        //         ),
        //     )
        // )

    }


    /**
     * Button Text Shadow
     */
    public function normal_button_text_shadow(&$normal_text_shadow)
    {

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $normal_text_shadow[] = array(
                'id'      => 'ts_color',
                'type'    => 'color',
                'title'   => __('Color', 'adminify'),
                'default' => $this->get_default_field('login_form_button_settings')['button_text_shadow']['ts_color'],
                'class'   => 'wp-adminify-cs',
            );
        } else {
            $normal_text_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Color', 'adminify'),
                'style'   => 'warning',
                'class'   => 'wp-adminify-cs',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $normal_text_shadow[] = array(
                'id'    => 'ts_blur',
                'type'  => 'slider',
                'title' => __('Blur', 'adminify'),
                'default' => $this->get_default_field('login_form_button_settings')['button_text_shadow']['ts_blur'],
            );
        } else {
            $normal_text_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Blur', 'adminify'),
                'style'   => 'warning',
                'class'   => 'wp-adminify-cs',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $normal_text_shadow[] = array(
                'id'    => 'ts_hz',
                'type'  => 'slider',
                'title' => __('Horizontal', 'adminify'),
                'default' => $this->get_default_field('login_form_button_settings')['button_text_shadow']['ts_hz'],
            );
        } else {
            $normal_text_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Horizontal', 'adminify'),
                'style'   => 'warning',
                'class'   => 'wp-adminify-cs',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }



        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $normal_text_shadow[] = array(
                'id'    => 'ts_ver',
                'type'  => 'slider',
                'title' => __('Vertical', 'adminify'),
                'default' => $this->get_default_field('login_form_button_settings')['button_text_shadow']['ts_ver'],
            );
        } else {
            $normal_text_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Vertical', 'adminify'),
                'style'   => 'warning',
                'class'   => 'wp-adminify-cs',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }
    }

    /**
     * * Button Fields: Hover
     *
     * @param [type] $button_fields_hover
     *
     * @return void
     */
    public function button_fields_hover_settings(&$button_fields_hover)
    {
        $hover_text_shadow = [];
        $this->hover_text_shadow($hover_text_shadow);

        $button_fields_hover[] = array(
            'id'      => 'button_bg_hover',
            'type'    => 'color',
            'title'   => __('Background', 'adminify'),
            'default' => $this->get_default_field('login_form_button_settings')['button_bg_hover'],
            'class'   => 'wp-adminify-cs',
        );
        $button_fields_hover[] = array(
            'id'      => 'button_text_hover',
            'type'    => 'color',
            'title'   => __('Text Color', 'adminify'),
            'default' => $this->get_default_field('login_form_button_settings')['button_text_hover'],
            'class'   => 'wp-adminify-cs',
        );
        // array(
        //     'id'      => 'button_border_color_hover',
        //     'type'    => 'border',
        //     'title'   => 'Border'
        // ),
        // array(
        //     'id'    => 'button_border_radius_hover',
        //     'type'  => 'spacing',
        //     'title' => 'Border Radius',
        // ),
        $button_fields_hover[] = array(
            'type'    => 'subheading',
            'content' => __('Text Shadow', 'adminify'),
        );

        $button_fields_hover[] = array(
            'id'     => 'button_text_shadow_hover',
            'type'   => 'fieldset',
            'fields' => $hover_text_shadow
        );

        // Turned off for future use
        // array(
        //     'type'    => 'subheading',
        //     'content' => 'Box Shadow',
        // ),

        // array(
        //     'id'     => 'button_box_shadow_hover',
        //     'type'   => 'fieldset',
        //     'fields' => array(
        //         array(
        //             'id'      => 'bs_color',
        //             'type'    => 'color',
        //             'title'   => 'Color',
        //             'default' => 'transparent',
        //             'class'   => 'wp-adminify-cs',
        //         ),
        //         array(
        //             'id'    => 'bs_hz',
        //             'type'  => 'slider',
        //             'title' => 'Horizontal',
        //         ),
        //         array(
        //             'id'    => 'bs_ver',
        //             'type'  => 'slider',
        //             'title' => 'Vertical',
        //         ),
        //         array(
        //             'id'    => 'bs_blur',
        //             'type'  => 'slider',
        //             'title' => 'Blur',
        //         ),
        //         array(
        //             'id'    => 'bs_spread',
        //             'type'  => 'slider',
        //             'title' => 'Spread',
        //         ),
        //         array(
        //             'id'      => 'bs_spread_pos',
        //             'type'    => 'select',
        //             'title'   => 'Position',
        //             'options' => array(
        //                 ''        => 'Outline',
        //                 'inset'   => 'Inset'
        //             ),
        //             'default' => ''
        //         ),
        //     )
        // )
    }


    /**
     * Hover Text Shadow
     */
    public function hover_text_shadow(&$hover_text_shadow)
    {

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $hover_text_shadow[] = array(
                'id'      => 'ts_hover',
                'type'    => 'color',
                'title'   => __('Color', 'adminify'),
                'default' => $this->get_default_field('login_form_button_settings')['button_text_shadow_hover']['ts_hover'],
                'class'   => 'wp-adminify-cs',
            );
        } else {
            $hover_text_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Color', 'adminify'),
                'style'   => 'warning',
                'class'   => 'wp-adminify-cs',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $hover_text_shadow[] = array(
                'id'    => 'ts_blur_hover',
                'type'  => 'slider',
                'title' => __('Blur', 'adminify'),
                'default' => $this->get_default_field('login_form_button_settings')['button_text_shadow_hover']['ts_blur_hover'],
            );
        } else {
            $hover_text_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Blur', 'adminify'),
                'style'   => 'warning',
                'class'   => 'wp-adminify-cs',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $hover_text_shadow[] = array(
                'id'    => 'ts_hz_hover',
                'type'  => 'slider',
                'title' => __('Horizontal', 'adminify'),
                'default' => $this->get_default_field('login_form_button_settings')['button_text_shadow_hover']['ts_hz_hover'],
            );
        } else {
            $hover_text_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Horizontal', 'adminify'),
                'style'   => 'warning',
                'class'   => 'wp-adminify-cs',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }



        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $hover_text_shadow[] = array(
                'id'    => 'ts_ver_hover',
                'type'  => 'slider',
                'title' => __('Vertical', 'adminify'),
                'default' => $this->get_default_field('login_form_button_settings')['button_text_shadow_hover']['ts_ver_hover'],
            );
        } else {
            $hover_text_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Vertical', 'adminify'),
                'style'   => 'warning',
                'class'   => 'wp-adminify-cs',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }
    }

    /**
     * Button Fields: Advance
     *
     * @param [type] $button_fields_advance
     *
     * @return void
     */
    public function button_fields_advance_settings(&$button_fields_advance)
    {
        $advance_box_shadow = [];
        $this->advance_box_shadow($advance_box_shadow);

        $button_fields_advance[] = array(
            'id'    => 'button_margin',
            'type'  => 'spacing',
            'title' => __('Margin', 'adminify'),
            'default' => $this->get_default_field('login_form_button_settings')['button_margin'],
        );
        $button_fields_advance[] = array(
            'id'    => 'button_padding',
            'type'  => 'spacing',
            'title' => __('Padding', 'adminify'),
            'default' => $this->get_default_field('login_form_button_settings')['button_padding'],
        );
        $button_fields_advance[] = array(
            'type'    => 'subheading',
            'content' => __('Border', 'adminify'),
        );

        $button_fields_advance[] = array(
            'id'    => 'button_border',
            'type'  => 'border',
            'title' => __('Border', 'adminify'),
            'default' => $this->get_default_field('login_form_button_settings')['button_border'],
        );

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $button_fields_advance[] = array(
                'id'    => 'button_border_radius',
                'type'  => 'spacing',
                'title' => __('Border Radius', 'adminify'),
                'default' => $this->get_default_field('login_form_button_settings')['button_border_radius'],
            );
        } else {
            $button_fields_advance[] = array(
                'type'    => 'notice',
                'title'   => __('Border Radius', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }



        $button_fields_advance[] = array(
            'type'    => 'subheading',
            'content' => __('Box Shadow', 'adminify'),
        );

        $button_fields_advance[] = array(
            'id'     => 'button_box_shadow',
            'type'   => 'fieldset',
            'fields' => $advance_box_shadow
        );
    }

    /**
     * Advance Box Shadow
     */
    public function advance_box_shadow(&$advance_box_shadow)
    {

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $advance_box_shadow[] = array(
                'id'      => 'bs_color',
                'type'    => 'color',
                'title'   => __('Color', 'adminify'),
                'default' => $this->get_default_field('login_form_button_settings')['button_box_shadow']['bs_color'],
                'class'   => 'wp-adminify-cs',
            );
        } else {
            $advance_box_shadow[] = array(
                'type'       => 'notice',
                'title'   => __('Color', 'adminify'),
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro(' ')
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $advance_box_shadow[] = array(
                'id'    => 'bs_hz',
                'type'  => 'slider',
                'title' => __('Horizontal', 'adminify'),
                'default' => $this->get_default_field('login_form_button_settings')['button_box_shadow']['bs_hz'],
            );
        } else {
            $advance_box_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Horizontal', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $advance_box_shadow[] = array(
                'id'    => 'bs_ver',
                'type'  => 'slider',
                'title' => __('Vertical', 'adminify'),
                'default' => $this->get_default_field('login_form_button_settings')['button_box_shadow']['bs_ver'],
            );
        } else {
            $advance_box_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Vertical', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $advance_box_shadow[] = array(
                'id'    => 'bs_blur',
                'type'  => 'slider',
                'title' => __('Blur', 'adminify'),
                'default' => $this->get_default_field('login_form_button_settings')['button_box_shadow']['bs_blur'],
            );
        } else {
            $advance_box_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Vertical', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $advance_box_shadow[] = array(
                'id'    => 'bs_spread',
                'type'  => 'slider',
                'title' => __('Spread', 'adminify'),
                'default' => $this->get_default_field('login_form_button_settings')['button_box_shadow']['bs_spread'],
            );
        } else {
            $advance_box_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Spread', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }



        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $advance_box_shadow[] = array(
                'id'      => 'bs_spread_pos',
                'type'    => 'select',
                'title'   => __('Position', 'adminify'),
                'options' => array(
                    ''        => __('Outline', 'adminify'),
                    'inset'   => __('Inset', 'adminify'),
                ),
                'default' => $this->get_default_field('login_form_button_settings')['button_box_shadow']['bs_spread_pos'],
            );
        } else {
            $advance_box_shadow[] = array(
                'type'    => 'notice',
                'title'   => __('Position', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }
    }


    public function button_customizer_settings(&$button_customizer_settings)
    {

        $button_fields_normal = [];
        $this->button_fields_normal_settings($button_fields_normal);
        $button_fields_hover = [];
        $this->button_fields_hover_settings($button_fields_hover);
        $button_fields_advance = [];
        $this->button_fields_advance_settings($button_fields_advance);

        $button_customizer_settings[] = array(
            'type'    => 'subheading',
            'content' => __('General Settings', 'adminify'),
        );

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $button_customizer_settings[] = array(
                'id'      => 'button_size',
                'type'    => 'dimensions',
                'title'   => __('Button Width & Height', 'adminify'),
                'default' => $this->get_default_field('button_size'),
            );
        } else {
            $button_customizer_settings[] = array(
                'type'    => 'notice',
                'title'   => __('Button Width & Height', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro(' ')
            );
        }


        $button_customizer_settings[] = array(
            'id'    => 'button_font_size',
            'type'  => 'slider',
            'unit'  => 'px',
            'title' => __('Font Size', 'adminify'),
            'default' => $this->get_default_field('button_font_size'),
        );

        $button_customizer_settings[] = array(
            'id'    => 'login_form_button_settings',
            'type'  => 'tabbed',
            'title' => __('Button', 'adminify'),
            'tabs'  => array(

                array(
                    'title'  => __('Normal', 'adminify'),
                    'fields' => $button_fields_normal
                ),

                array(
                    'title'  => __('Hover', 'adminify'),
                    'fields' => $button_fields_hover
                ),

                array(
                    'title'  => __('Advanced', 'adminify'),
                    'fields' => $button_fields_advance
                )
            ),
        );
    }

    public function button_customizer()
    {
        if (!class_exists('ADMINIFY')) {
            return;
        }

        $button_customizer_settings = [];
        $this->button_customizer_settings($button_customizer_settings);

        /**
         * Section: Button Section
         */
        \ADMINIFY::createSection(
            $this->prefix,
            array(
                'assign' => 'jltwp_adminify_customizer_login_form_button_section',
                'title'  => __('Button', 'adminify'),
                'fields' => $button_customizer_settings
            )
        );
    }
}
