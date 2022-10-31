<?php

namespace WPAdminify\Inc\Modules\NotificationBar;

use WPAdminify\Inc\Modules\NotificationBar\Inc\Notification_Customize;
use WPAdminify\Inc\Modules\NotificationBar\Inc\Notificationbar_Output;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Adminify
 * Module: Notification Bar
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

if ( ! class_exists( 'NotificationBar' ) ) {
	class NotificationBar {

		public $url;
		public $prefix;

		public function __construct() {
			$this->url    = WP_ADMINIFY_URL . 'Inc/Modules/NotificationBar';
			$this->prefix = '_adminify_notification_bar';

			add_action( 'admin_menu', [ $this, 'notification_bar_submenu' ], 45 );
			add_action( 'admin_init', [ $this, 'notification_bar_redirect_customizer' ] );

			// Setup customizer.
			add_action( 'customize_register', [ $this, 'notification_bar_register_panels' ] );
			add_action( 'customize_register', [ $this, 'notification_bar_register_sections' ] );

			// Enqueue Assets
			add_action( 'customize_controls_print_styles', [ $this, 'notification_bar_control_styles' ], 9999 );
			add_action( 'customize_controls_enqueue_scripts', [ $this, 'notification_bar_control_scripts' ], 9999 );
			add_action( 'customize_preview_init', [ $this, 'notification_bar_preview_script' ], 99 );

			new Notification_Customize();
			new Notificationbar_Output();
		}

		/**
		 * Notification Bar: Control Styles
		 */
		public function notification_bar_control_styles() {
			wp_enqueue_style( 'adminify-notification-bar-controls', WP_ADMINIFY_ASSETS . 'css/controls.css', null, WP_ADMINIFY_VER );
		}


		/**
		 * Notification Bar: Control Styles
		 */
		public function notification_bar_control_scripts() {
			wp_enqueue_script( 'adminify-notification-bar-customizer', $this->url . '/assets/js/notification-bar-customizer.js', [ 'jquery', 'customize-controls' ], WP_ADMINIFY_VER, true );
			wp_localize_script( 'adminify-notification-bar-customizer', 'WPAdminifyNotificationBar', $this->jltwp_adminify_create_js_object() );
		}


		/**
		 * Notification Bar: Preview JS
		 */
		public function notification_bar_preview_script() {
			if ( ! is_customize_preview() ) {
				return;
			}
			wp_enqueue_script( 'adminify-notification-bar-preview', $this->url . '/assets/js/notification-bar-preview.js', [ 'jquery', 'customize-preview' ], WP_ADMINIFY_VER, true );
			wp_localize_script( 'adminify-notification-bar-preview', 'WPAdminifyNotificationBar', $this->jltwp_adminify_create_js_object() );
		}

		/**
		 * Create JS Object
		 *
		 * @return void
		 */
		public function jltwp_adminify_create_js_object() {
			return [
				'homeUrl'            => home_url(),
				'notificationBarUrl' => home_url( 'wp-adminify-notification-bar' ),
				'pluginUrl'          => rtrim( WP_ADMINIFY_URL, '/' ),
				'moduleUrl'          => $this->url,
				'assetUrl'           => $this->url . '/assets',
				'isProActive'        => false,
			];
		}

		/**
		 * Customizer Redirect
		 */
		public function notification_bar_redirect_customizer() {
			if ( ! empty( $_GET['page'] ) ) {
				if ( 'wp-adminify-notification-bar' === $_GET['page'] ) {
					// Redirect URL
					$url = add_query_arg(
						[
							'autofocus[panel]' => 'jltwp_notification_bar_panel',
						],
						admin_url( 'customize.php' )
					);

					wp_safe_redirect( $url );
				}
			}
		}



		/**
		 * Notification bar Sub Menu
		 */
		public function notification_bar_submenu() {
			add_submenu_page(
				'wp-adminify-settings',
				esc_html__( 'Notification Bar by WP Adminify', 'adminify' ),
				esc_html__( 'Notification Bar', 'adminify' ),
				apply_filters( 'jltwp_adminify_capability', 'manage_options' ),
				admin_url( 'customize.php?autofocus[panel]=jltwp_notification_bar_panel' )
			);
		}


		/**
		 * Register Panels
		 */
		public function notification_bar_register_panels( $wp_customize ) {
			$wp_customize->add_panel(
				'jltwp_notification_bar_panel',
				[
					'title'       => __( 'Notification Bar - WP Adminify', 'adminify' ),
					'description' => __( 'Customize Notification Bar with WP Adminify :)', 'adminify' ),
					'capability'  => apply_filters( 'jltwp_adminify_capability', 'manage_options' ),
					'priority'    => 11,
				]
			);
		}

		/**
		 * Notification Bar Sections
		 *
		 * @param [type] $wp_customize
		 *
		 * @return void
		 */
		public function notification_bar_register_sections( $wp_customize ) {
			notification_bar_sections( $wp_customize );
		}
	}
}
