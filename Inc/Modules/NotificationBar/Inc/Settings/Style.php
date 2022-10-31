<?php

namespace WPAdminify\Inc\Modules\NotificationBar\Inc\Settings;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Modules\NotificationBar\Inc\Notification_Customize;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class Style extends Notification_Customize {

	public function __construct() {
		$this->style_notif_bar_customizer();
	}


	public function get_defaults() {
		return [
			'presets'        => 'set-1',
			'bg_color'       => '#000',
			'text_color'     => '#fff',
			'btn_color'      => '#d35400',
			'btn_text_color' => '#fff',
			'link_color'     => '#009fdd',
		];
	}

	/**
	 * Get Style Fields
	 */
	public function get_style_fields( &$style_fields ) {
		// $style_fields[] = array(
		// 'id'      => 'presets',
		// 'type'    => 'palette',
		// 'title'   => __('Presets', 'adminify'),
		// 'options' => array(
		// 'set-1' => array('#f36e27', '#f3d430'),
		// 'set-2' => array('#4153ab', '#6e86c7'),
		// 'set-3' => array('#162526', '#508486'),
		// 'set-4' => array('#ccab5e', '#fff55f'),
		// 'set-5' => array('#B45F1A', '#fff55f'),
		// 'set-6' => array('#d69762', '#fff55f'),
		// 'set-7' => array('#212b2f', '#fff55f'),
		// 'set-8' => array('#ed1683', '#fff55f'),
		// ),
		// 'default' => $this->get_default_field('presets'),
		// );

		$style_fields[] = [
			'id'      => 'bg_color',
			'type'    => 'color',
			'title'   => __( 'Background Color', 'adminify' ),
			'class'   => 'wp-adminify-cs',
			'default' => $this->get_default_field( 'bg_color' ),
		];

		$style_fields[] = [
			'id'      => 'text_color',
			'type'    => 'color',
			'title'   => __( 'Text Color', 'adminify' ),
			'class'   => 'wp-adminify-cs',
			'default' => $this->get_default_field( 'text_color' ),
		];

		$style_fields[] = [
			'id'      => 'btn_color',
			'type'    => 'color',
			'title'   => __( 'Close Button Background', 'adminify' ),
			'class'   => 'wp-adminify-cs',
			'default' => $this->get_default_field( 'btn_color' ),
		];

		$style_fields[] = [
			'id'      => 'btn_text_color',
			'type'    => 'color',
			'title'   => __( 'Close Btn Text Color', 'adminify' ),
			'class'   => 'wp-adminify-cs',
			'default' => $this->get_default_field( 'btn_text_color' ),
		];

		$style_fields[] = [
			'id'      => 'link_bg_color',
			'type'    => 'color',
			'title'   => __( 'Learn More BG Color', 'adminify' ),
			'class'   => 'wp-adminify-cs',
			'default' => $this->get_default_field( 'link_color' ),
		];

		$style_fields[] = [
			'id'      => 'link_color',
			'type'    => 'color',
			'title'   => __( 'Learn More Color', 'adminify' ),
			'class'   => 'wp-adminify-cs',
			'default' => $this->get_default_field( 'link_color' ),
		];
	}

	/**
	 * Notification bar: Style
	 *
	 * @return void
	 */
	public function style_notif_bar_customizer() {
		$style_fields = [];
		$this->get_style_fields( $style_fields );
		/**
		 * Section: Style Settings
		 */
		\ADMINIFY::createSection(
			$this->prefix,
			[
				'assign' => 'style_section',
				'title'  => __( 'Style Settings', 'adminify' ),
				'fields' => $style_fields,
			]
		);
	}
}
