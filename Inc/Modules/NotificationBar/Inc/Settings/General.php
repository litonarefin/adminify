<?php

namespace WPAdminify\Inc\Modules\NotificationBar\Inc\Settings;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Modules\NotificationBar\Inc\Notification_Customize;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class General extends Notification_Customize {

	public function __construct() {
		$this->general_notif_bar_customizer();
	}


	public function get_defaults() {
		return [
			'show_notif_bar'   => false,
			'content_align'    => 'center',
			'padding'          => [
				'width'  => '',
				'height' => '',
				'unit'   => 'px',
			],
			'display_position' => 'top',
			'display_type'     => 'fixed',
			'show_btn_close'   => true,
			'expires_in'       => 30,
			'close_btn_text'   => 'x',
		];
	}


	/**
	 * Notification bar: General Feilds
	 *
	 * @param [type] $general_fields
	 *
	 * @return void
	 */
	public function general_fields( &$general_fields ) {
		$general_fields[] = [
			'id'       => 'show_notif_bar',
			'type'     => 'switcher',
			'title'    => __( 'Enable Notification Bar?', 'adminify' ),
			'text_on'  => 'Yes',
			'text_off' => 'No',
			'class'    => 'wp-adminify-cs',
			'default'  => $this->get_default_field( 'show_notif_bar' ),
		];

		$general_fields[] = [
			'id'         => 'content_align',
			'type'       => 'button_set',
			'title'      => __( 'Content Alignment', 'adminify' ),
			'options'    => [
				'left'   => __( 'Left', 'adminify' ),
				'center' => __( 'Center', 'adminify' ),
				'right'  => __( 'Right', 'adminify' ),
			],
			'class'      => 'wp-adminify-cs',
			'default'    => $this->get_default_field( 'content_align' ),
			'dependency' => [ 'show_notif_bar', '==', 'true', true ],
		];

		$general_fields[] = [
			'id'         => 'display_position',
			'type'       => 'button_set',
			'title'      => __( 'Display Position', 'adminify' ),
			'class'      => 'wp-adminify-cs',
			'options'    => [
				'top'    => __( 'Top', 'adminify' ),
				'bottom' => __( 'Bottom', 'adminify' ),
			],
			'default'    => $this->get_default_field( 'display_position' ),
			'dependency' => [ 'show_notif_bar', '==', 'true', true ],
		];

		// $general_fields[] = array(
		// 'id'      => 'display_type',
		// 'type'    => 'button_set',
		// 'title'   => __('Position Type', 'adminify'),
		// 'class'   => 'wp-adminify-cs',
		// 'options' => array(
		// 'fixed'     => __('Fixed', 'adminify'),
		// 'on_scroll' => __('On Scroll', 'adminify'),
		// ),
		// 'default'    => $this->get_default_field('display_type'),
		// 'dependency' => array('show_notif_bar', '==', 'true', true),
		// );

		$general_fields[] = [
			'id'         => 'show_btn_close',
			'type'       => 'switcher',
			'title'      => __( 'Show Close Button?', 'adminify' ),
			'text_on'    => 'Yes',
			'text_off'   => 'No',
			'class'      => 'wp-adminify-cs',
			'default'    => $this->get_default_field( 'show_btn_close' ),
			'dependency' => [ 'show_notif_bar', '==', 'true', true ],
		];

		$general_fields[] = [
			'id'         => 'close_btn_text',
			'type'       => 'text',
			'class'      => 'wp-adminify-cs',
			'title'      => __( 'Close Button Text', 'adminify' ),
			'default'    => $this->get_default_field( 'close_btn_text' ),
			'dependency' => [ 'show_notif_bar|show_btn_close', '==|==', 'true|true', true ],
		];

		$general_fields[] = [
			'id'         => 'expires_in',
			'type'       => 'number',
			'class'      => 'wp-adminify-cs',
			'title'      => __( 'Expires In', 'adminify' ),
			'default'    => $this->get_default_field( 'expires_in' ),
			'dependency' => [ 'show_notif_bar', '==', 'true', true ],
		];

		$general_fields[] = [
			'id'         => 'padding',
			'type'       => 'dimensions',
			'class'      => 'wp-adminify-cs',
			'title'      => __( 'Padding', 'adminify' ),
			'units'      => [ 'px' ],
			'default'    => $this->get_default_field( 'padding' ),
			'dependency' => [ 'show_notif_bar', '==', 'true', true ],
		];
	}

	/**
	 * Notification bar: General
	 *
	 * @return void
	 */
	public function general_notif_bar_customizer() {
		$general_fields = [];
		$this->general_fields( $general_fields );

		// General Settings
		\ADMINIFY::createSection(
			$this->prefix,
			[
				'assign' => 'general_section',
				'title'  => __( 'General Settings', 'adminify' ),
				'fields' => $general_fields,
			]
		);
	}
}
