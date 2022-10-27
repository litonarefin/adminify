<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Customize_Model;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

class Login_Form_Fields extends Customize_Model
{
    public function __construct()
    {
        $this->login_form_fields_customizer();
    }

    public function get_defaults()
    {
        return [
            'login_form_fields' => array(
                'label_username'          => __('Username or Email Address', 'adminify'),
                'fields_user_placeholder' => __('Username/Email', 'adminify'),
                'fields_pass_placeholder' => __('Password', 'adminify'),
                'label_password'          => __('Password', 'adminify'),
                'label_remember_me'       => __('Remember Me', 'adminify'),
                'input_login'             => __('Log In', 'adminify'),
                'label_lost_password'     => __('Lost your password?', 'adminify'),
                'label_back_to_site'      => __('Back to ', 'adminify'),
                'label_register'          => __('Register', 'adminify'),
                'style_label_font_size'   => 16,
                'style_fields_height'     => 50,
                'style_fields_font_size'  => 16,
                'style_fields_bg'         => '',
                'style_label_color'       => '',
                'style_fields_color'      => '',
                'style_border'            => '',
                'style_border_radius'     => '',
                'fields_margin'           => '',
                'fields_padding'          => '',
                'fields_bs_color'         => 'transparent',
                'fields_bs_hz'            => '',
                'fields_bs_ver'           => '',
                'fields_bs_blur'          => '',
                'fields_bs_spread'        => '',
                'fields_bs_spread_pos'    => '',
            ),
        ];
    }


    /**
     * Login Form Fields: Label
     *
     * @param [type] $login_form_fields
     *
     * @return void
     */
    public function login_form_field_label_settings(&$login_form_fields)
    {
        $login_form_fields[] = array(
            'id'      => 'label_username',
            'title'     => __('Username', 'adminify'),
            'type'    => 'text',
            'default'  => $this->get_default_field('login_form_fields')['label_username'],
        );

        $login_form_fields[] = array(
            'id'      => 'label_password',
            'type'    => 'text',
            'title'     => __('Password', 'adminify'),
            'default'  => $this->get_default_field('login_form_fields')['label_password'],
        );

        $login_form_fields[] = array(
            'id'        => 'label_remember_me',
            'type'      => 'text',
            'title'     => __('Remember Me', 'adminify'),
            'default'  => $this->get_default_field('login_form_fields')['label_remember_me'],
        );

        $login_form_fields[] = array(
            'id'      => 'input_login',
            'type'    => 'text',
            'default'  => $this->get_default_field('login_form_fields')['input_login'],
            'title'  => __('Login', 'adminify'),
        );

        $login_form_fields[] = array(
            'title'  => __('Register', 'adminify'),
            'id'      => 'label_register',
            'type'    => 'text',
            'default'  => $this->get_default_field('login_form_fields')['label_register'],

        );

        $login_form_fields[] = array(
            'id'      => 'label_lost_password',
            'type'    => 'text',
            'title'  => __('Lost Password', 'adminify'),
            'default'  => $this->get_default_field('login_form_fields')['label_lost_password'],
        );
        $login_form_fields[] = array(
            'id'      => 'label_back_to_site',
            'type'    => 'text',
            'title'  => __('Back to site', 'adminify'),
            'default'  => $this->get_default_field('login_form_fields')['label_back_to_site'],
        );
    }


    /**
     * Login Form Fields: Placeholder
     *
     * @param [type] $login_form_placeholder
     *
     * @return void
     */
    public function login_form_field_placeholder_settings(&$login_form_placeholder)
    {
        $login_form_placeholder[] = array(
            'id'      => 'fields_user_placeholder',
            'type'    => 'text',
            'default' => $this->get_default_field('login_form_fields')['fields_user_placeholder'],
            'title'  => __('Username', 'adminify'),
        );
        $login_form_placeholder[] = array(
            'id'      => 'fields_pass_placeholder',
            'type'    => 'text',
            'default' => $this->get_default_field('login_form_fields')['fields_pass_placeholder'],
            'title'  => __('Password', 'adminify'),
        );
    }


    /**
     * Login Form Fields: Style
     *
     * @param [type] $login_form_style
     *
     * @return void
     */
    public function login_form_field_style_settings(&$login_form_style)
    {
        $login_form_style[] = array(
            'id'      => 'style_label_font_size',
            'type'    => 'slider',
            'title'  => __('Label Font Size', 'adminify'),
            'unit'    => 'px',
            'min'     => 8,
            'max'     => 100,
            'step'    => 1,
            'default' => $this->get_default_field('login_form_fields')['style_label_font_size'],
        );

        $login_form_style[] = array(
            'id'      => 'style_fields_height',
            'type'    => 'slider',
            'title'  => __('Field Height', 'adminify'),
            'unit'    => 'px',
            'min'     => 8,
            'max'     => 100,
            'step'    => 1,
            'default' => $this->get_default_field('login_form_fields')['style_fields_height'],
        );

        $login_form_style[] = array(
            'id'      => 'style_fields_font_size',
            'type'    => 'slider',
            'title'  => __('Field Font Size', 'adminify'),
            'unit'    => 'px',
            'min'     => 8,
            'max'     => 100,
            'step'    => 1,
            'default' => $this->get_default_field('login_form_fields')['style_fields_font_size'],
        );


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_style[] = array(
                'id'      => 'style_fields_bg',
                'type'    => 'link_color',
                'title'  => __('Field Background', 'adminify'),
                'color'   => true,
                'hover'   => false,
                'visited' => false,
                'active'  => false,
                'focus'   => true,
                'default' => $this->get_default_field('login_form_fields')['style_fields_bg'],
            );
        } else {
            $login_form_style[] = array(
                'type'    => 'notice',
                'title'   => __('Field Background', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }



        $login_form_style[] = array(
            'id'    => 'style_label_color',
            'type'  => 'color',
            'title'  => __('Label Color', 'adminify'),
            'default' => $this->get_default_field('login_form_fields')['style_label_color'],
        );

        $login_form_style[] = array(
            'id'      => 'style_fields_color',
            'type'    => 'link_color',
            'title'  => __('Input Color', 'adminify'),
            'color'   => true,
            'hover'   => false,
            'visited' => false,
            'active'  => false,
            'focus'   => true,
            'default' => $this->get_default_field('login_form_fields')['style_fields_color'],
        );


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_style[] = array(
                'id'      => 'style_border',
                'type'    => 'border',
                'title'   => __('Border', 'adminify'),
                'default' => $this->get_default_field('login_form_fields')['style_border'],
            );
        } else {
            $login_form_style[] = array(
                'type'    => 'notice',
                'title'   => __('Border', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_style[] = array(
                'id'      => 'style_border_radius',
                'type'    => 'spacing',
                'title'   => __('Border Radius', 'adminify'),
                'default' => $this->get_default_field('login_form_fields')['style_border_radius'],
            );
        } else {
            $login_form_style[] = array(
                'type'    => 'notice',
                'title'   => __('Border Radius', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }
    }


    /**
     * Login Form Fields: Advanced
     *
     * @param [type] $login_form_advanced
     *
     * @return void
     */
    public function login_form_field_advanced_settings(&$login_form_advanced)
    {

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_advanced[] = array(
                'id'      => 'fields_margin',
                'type'    => 'spacing',
                'title'   => __('Margin', 'adminify'),
                'default' => $this->get_default_field('login_form_fields')['fields_margin'],
            );
        } else {
            $login_form_advanced[] = array(
                'type'    => 'notice',
                'title'   => __('Margin', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_advanced[] = array(
                'id'      => 'fields_padding',
                'type'    => 'spacing',
                'title'   => __('Field Padding', 'adminify'),
                'default' => $this->get_default_field('login_form_fields')['fields_padding'],
            );
        } else {
            $login_form_advanced[] = array(
                'type'    => 'notice',
                'title'   => __('Field Padding', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }



        $login_form_advanced[] = array(
            'type'    => 'subheading',
            'title'  => __('Box Shadow', 'adminify'),
        );


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_advanced[] = array(
                'id'      => 'fields_bs_color',
                'type'    => 'color',
                'title'   => __('Color', 'adminify'),
                'default' => $this->get_default_field('login_form_fields')['fields_bs_color'],
                'class'   => 'wp-adminify-cs',
            );
        } else {
            $login_form_advanced[] = array(
                'type'    => 'notice',
                'title'   => __('Color', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_advanced[] = array(
                'id'      => 'fields_bs_hz',
                'type'    => 'slider',
                'title'   => __('Horizontal', 'adminify'),
                'default' => $this->get_default_field('login_form_fields')['fields_bs_hz'],
            );
        } else {
            $login_form_advanced[] = array(
                'type'    => 'notice',
                'title'   => __('Horizontal', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_advanced[] = array(
                'id'      => 'fields_bs_ver',
                'type'    => 'slider',
                'title'   => __('Vertical', 'adminify'),
                'default' => $this->get_default_field('login_form_fields')['fields_bs_ver'],
            );
        } else {
            $login_form_advanced[] = array(
                'type'    => 'notice',
                'title'   => __('Vertical', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_advanced[] = array(
                'id'      => 'fields_bs_blur',
                'type'    => 'slider',
                'title'   => __('Blur', 'adminify'),
                'default' => $this->get_default_field('login_form_fields')['fields_bs_blur'],
            );
        } else {
            $login_form_advanced[] = array(
                'type'    => 'notice',
                'title'   => __('Blur', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_advanced[] = array(
                'id'      => 'fields_bs_spread',
                'type'    => 'slider',
                'title'   => __('Spread', 'adminify'),
                'default' => $this->get_default_field('login_form_fields')['fields_bs_spread'],
            );
        } else {
            $login_form_advanced[] = array(
                'type'    => 'notice',
                'title'   => __('Spread', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $login_form_advanced[] = array(
                'id'      => 'fields_bs_spread_pos',
                'type'    => 'select',
                'title'  => __('Position', 'adminify'),
                'options' => array(
                    ''      => 'Outside',
                    'inset' => 'Inset'
                ),
                'default' => $this->get_default_field('login_form_fields')['fields_bs_spread_pos'],
            );
        } else {
            $login_form_advanced[] = array(
                'type'    => 'notice',
                'title'  => __('Position', 'adminify'),
                'style'   => 'warning',
                'content' => Utils::adminify_upgrade_pro()
            );
        }
    }

    public function login_form_fields_customizer()
    {
        if (!class_exists('ADMINIFY')) {
            return;
        }

        $login_form_fields      = [];
        $login_form_placeholder = [];
        $login_form_style       = [];
        $login_form_advanced    = [];
        $this->login_form_field_label_settings($login_form_fields);
        $this->login_form_field_placeholder_settings($login_form_placeholder);
        $this->login_form_field_style_settings($login_form_style);
        $this->login_form_field_advanced_settings($login_form_advanced);

        /**
         * Section: Login Form Fields
         */
        \ADMINIFY::createSection(
            $this->prefix,
            array(
                'assign' => 'jltwp_adminify_customizer_login_form_fields_section',
                // 'title'  => __('Login Form Fields', 'adminify'),
                'fields' => array(

                    array(
                        'id'    => 'login_form_fields',
                        'type'  => 'tabbed',
                        'tabs'  => array(
                            array(
                                'title'  => __('Label', 'adminify'),
                                'fields' => $login_form_fields
                            ),

                            array(
                                'title'  => __('Placeholder', 'adminify'),
                                'fields' => $login_form_placeholder
                            ),

                            array(
                                'title'  => __('Style', 'adminify'),
                                'fields' => $login_form_style
                            ),

                            array(
                                'title'  => __('Advance', 'adminify'),
                                'fields' => $login_form_advanced
                            )
                        ),
                    ),

                )
            )
        );
    }
}
