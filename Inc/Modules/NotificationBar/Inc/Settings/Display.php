<?php

namespace WPAdminify\Inc\Modules\NotificationBar\Inc\Settings;

use WPAdminify\Inc\Modules\NotificationBar\Inc\Notification_Customize;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class Display extends Notification_Customize {

	public function __construct() {
		$this->display_notif_bar_customizer();
	}

	public function get_defaults() {
		return [
			'display_devices' => 'all',
			'display_pages'   => [ 'homepage', 'posts', 'pages' ],
		];
	}


	/**
	 * Notification Bar: Display Settings
	 *
	 * @param [type] $display_settings
	 *
	 * @return void
	 */
	public function get_display_settings( &$display_settings ) {
		$display_settings[] = [
			'id'      => 'display_devices',
			'type'    => 'select',
			'title'   => __( 'Select devices want to display', 'adminify' ),
			'options' => [
				'all'     => __( 'All Devices', 'adminify' ),
				'desktop' => __( 'Desktop', 'adminify' ),
				'mobile'  => __( 'Mobile', 'adminify' ),
			],
			'default' => $this->get_default_field( 'display_devices' ),
		];

		$display_settings[] = [
			'id'      => 'display_pages',
			'type'    => 'checkbox',
			'title'   => __( 'Where to Display', 'adminify' ),
			'options' => [
				'homepage' => __( 'Homepage', 'adminify' ),
				'posts'    => __( 'Posts', 'adminify' ),
				'pages'    => __( 'Pages', 'adminify' ),
			],
			'default' => $this->get_default_field( 'display_pages' ),
		];
	}

	/**
	 * Notification bar: Display
	 *
	 * @return void
	 */
	public function display_notif_bar_customizer() {
		$display_settings = [];
		$this->get_display_settings( $display_settings );

		/**
		 * Section: Display Settings
		 */
		\ADMINIFY::createSection(
			$this->prefix,
			[
				'assign' => 'display_section',
				'title'  => __( 'Display Settings', 'adminify' ),
				'fields' => $display_settings,
			]
		);
	}
}
