<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings;

use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Customize_Model;

// Cannot access directly.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class Templates extends Customize_Model {


	public function __construct() {
		$this->template_customizer();
	}

	public function get_defaults() {
		return [
			'templates' => 'template-01',
		];
	}

	public static function get_default_templates() {
		$url = WP_ADMINIFY_URL . 'Inc/Modules/LoginCustomizer/assets/images/templates/';

		return [
			'template-01' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-01.png', WP_ADMINIFY_BASE ) ),
			'template-02' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-02.png', WP_ADMINIFY_BASE ) ),
			'template-03' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-03.png', WP_ADMINIFY_BASE ) ),
			'template-04' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-04.png', WP_ADMINIFY_BASE ) ),
			'template-05' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-05.png', WP_ADMINIFY_BASE ) ),
			'template-06' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-06.png', WP_ADMINIFY_BASE ) ),
			'template-07' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-07.png', WP_ADMINIFY_BASE ) ),
			'template-08' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-08.png', WP_ADMINIFY_BASE ) ),
			'template-09' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-09.png', WP_ADMINIFY_BASE ) ),
			'template-10' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-10.png', WP_ADMINIFY_BASE ) ),
			'template-11' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-11.png', WP_ADMINIFY_BASE ) ),
			'template-12' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-12.png', WP_ADMINIFY_BASE ) ),
			'template-13' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-13.png', WP_ADMINIFY_BASE ) ),
			'template-14' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-14.png', WP_ADMINIFY_BASE ) ),
			'template-15' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-15.png', WP_ADMINIFY_BASE ) ),
			'template-16' => esc_url( apply_filters( 'adminify_logincustomizer_bg', $url . 'template-16.png', WP_ADMINIFY_BASE ) ),
		];
	}

	public function template_customizer() {
		if ( ! class_exists( 'ADMINIFY' ) ) {
			return;
		}

		/**
		 * Section: Templates
		 */
		\ADMINIFY::createSection(
			$this->prefix,
			[
				'assign' => 'jltwp_adminify_customizer_template_section',
				'title'  => __( 'Templates', 'adminify' ),
				'fields' => [
					[
						'id'      => 'templates',
						'type'    => 'image_select',
						'title'   => __( 'Templates', 'adminify' ),
						'options' => self::get_default_templates(),
						'class'   => jltwp_adminify()->can_use_premium_code__premium_only() ? 'upgrade-to-pro' : '',
						'default' => $this->get_default_field( 'templates' ),
					],
				],
			]
		);
	}
}
