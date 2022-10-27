<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer;

// no direct access allowed
if (!defined('ABSPATH'))  exit;


function jltwp_adminify_sections($wp_customize)
{

    $wp_customize->add_section(
        'jltwp_adminify_customizer_template_section',
        array(
            'title' => esc_html__('Templates', 'adminify'),
            'panel' => 'jltwp_adminify_panel',
        )
    );

    $wp_customize->add_section(
        'jltwp_adminify_customizer_logo_section',
        array(
            'title' => esc_html__('Logo', 'adminify'),
            'panel' => 'jltwp_adminify_panel',
        )
    );

    $wp_customize->add_section(
        'jltwp_adminify_customizer_bg_section',
        array(
            'title' => esc_html__('Background', 'adminify'),
            'panel' => 'jltwp_adminify_panel',
        )
    );

    $wp_customize->add_section(
        'jltwp_adminify_customizer_layout_section',
        array(
            'title' => esc_html__('Layout', 'adminify'),
            'panel' => 'jltwp_adminify_panel',
        )
    );


    $wp_customize->add_section(
        'jltwp_adminify_customizer_login_form_section',
        array(
            'title' => esc_html__('Login Form', 'adminify'),
            'panel' => 'jltwp_adminify_panel',
        )
    );

    $wp_customize->add_section(
        'jltwp_adminify_customizer_login_form_fields_section',
        array(
            'title' => esc_html__('Form Fields', 'adminify'),
            'panel' => 'jltwp_adminify_panel',
        )
    );

    $wp_customize->add_section(
        'jltwp_adminify_customizer_login_form_button_section',
        array(
            'title' => esc_html__('Button', 'adminify'),
            'panel' => 'jltwp_adminify_panel',
        )
    );

    $wp_customize->add_section(
        'jltwp_adminify_customizer_login_others_section',
        array(
            'title' => esc_html__('Others', 'adminify'),
            'panel' => 'jltwp_adminify_panel',
        )
    );

    $wp_customize->add_section(
        'jltwp_adminify_customizer_fonts_section',
        array(
            'title' => esc_html__('Google Fonts', 'adminify'),
            'panel' => 'jltwp_adminify_panel',
        )
    );

    $wp_customize->add_section(
        'jltwp_adminify_customizer_error_messages_section',
        array(
            'title' => esc_html__('Error Messages', 'adminify'),
            'panel' => 'jltwp_adminify_panel',
        )
    );

    $wp_customize->add_section(
        'jltwp_adminify_customizer_custom_css_js_section',
        array(
            'title' => esc_html__('Custom CSS & JS', 'adminify'),
            'panel' => 'jltwp_adminify_panel',
        )
    );

    $wp_customize->add_section(
        'jltwp_adminify_customizer_credits_section',
        array(
            'title' => esc_html__('Credits', 'adminify'),
            'panel' => 'jltwp_adminify_panel',
        )
    );
};
