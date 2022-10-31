<?php

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function notification_bar_sections( $wp_customize ) {
	$wp_customize->add_section(
		'general_section',
		[
			'title' => esc_html__( 'General Settings', 'adminify' ),
			'panel' => 'jltwp_notification_bar_panel',
		]
	);

	$wp_customize->add_setting( 'twitter', [ 'sanitize_callback' => 'sanitize_text_field' ] );

	$wp_customize->add_section(
		'content_section',
		[
			'title' => esc_html__( 'Content Section', 'adminify' ),
			'panel' => 'jltwp_notification_bar_panel',
		]
	);

	$wp_customize->add_section(
		'layout_section',
		[
			'title' => esc_html__( 'Layout Section', 'adminify' ),
			'panel' => 'jltwp_notification_bar_panel',
		]
	);

	$wp_customize->add_section(
		'display_section',
		[
			'title' => esc_html__( 'Display Section', 'adminify' ),
			'panel' => 'jltwp_notification_bar_panel',
		]
	);

	$wp_customize->add_section(
		'style_section',
		[
			'title' => esc_html__( 'Style Options', 'adminify' ),
			'panel' => 'jltwp_notification_bar_panel',
		]
	);
};
