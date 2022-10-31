<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer;

use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Customize_Settings;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Output_Customization;
use WPAdminify\Inc\Base_Model;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Adminify
 * Module: Login Customizer
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

if ( ! class_exists( 'LoginCustomizer' ) ) {

	class LoginCustomizer {


		public $script_suffix;

		public $options;

		public $url = WP_ADMINIFY_URL . 'Inc/Modules/LoginCustomizer';

		public function __construct() {
			$this->url = WP_ADMINIFY_URL . 'Inc/Modules/LoginCustomizer';

			$this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			$this->_hooks();

			$this->options = ( new \WPAdminify\Inc\Modules\LoginCustomizer\Inc\Customize_Settings() )->get();

			// Customizer Output CSS
			new Output_Customization();
		}

		/**
		 * Hooks
		 */
		public function _hooks() {
			global $wp_version;

			add_action( 'admin_menu', [ $this, 'jltwp_adminify_login_customizer_submenu' ], 50 );
			// add_action('network_admin_menu', [$this, 'jltwp_adminify_login_customizer_submenu'], 50);

			add_action( 'admin_init', [ $this, 'jltwp_adminify_redirect_customizer' ] );

			// Setup customizer.
			add_action( 'customize_register', [ $this, 'jltwp_adminify_register_panels' ] );
			add_action( 'customize_register', [ $this, 'jltwp_adminify_register_sections' ] );

			// Enqueue assets.
			add_action( 'customize_controls_print_styles', [ $this, 'jltwp_adminify_control_styles' ], 9999 );
			add_action( 'customize_controls_enqueue_scripts', [ $this, 'jltwp_adminify_control_scripts' ], 9999 );
			add_action( 'login_enqueue_scripts', [ $this, 'jltwp_adminify_preview_styles' ], 99 );
			add_action( 'customize_preview_init', [ $this, 'jltwp_adminify_preview_scripts' ], 99 );

			// Setup redirect.
			add_filter( 'template_include', [ $this, 'jltwp_adminify_template_include' ], 99 );

			// Templates Ajax
			add_action( 'wp_ajax_jltwp_adminify_adminify_presets', [ $this, 'jltwp_adminify_templates' ] );

			if ( version_compare( $wp_version, '5.9', '>=' ) && function_exists( 'wp_is_block_theme' ) ) {
				if ( wp_is_block_theme() ) {
					add_action( 'customize_register', [ $this, 'remove_customizer_settings_for_block_theme' ], 20 );
				}
			}
		}

		public function remove_customizer_settings_for_block_theme( $WP_Customize_Manager ) {
			// check if WP_Customize_Nav_Menus object exist
			if ( isset( $WP_Customize_Manager->nav_menus ) && is_object( $WP_Customize_Manager->nav_menus ) ) {
				remove_action( 'customize_controls_enqueue_scripts', [ $WP_Customize_Manager->nav_menus, 'enqueue_scripts' ] );
				remove_action( 'customize_controls_print_footer_scripts', [ $WP_Customize_Manager->nav_menus, 'available_items_template' ] );
			}
			// check if WP_Customize_Widgets object exist
			if ( isset( $WP_Customize_Manager->widgets ) && is_object( $WP_Customize_Manager->widgets ) ) {
				remove_action( 'customize_controls_print_footer_scripts', [ $WP_Customize_Manager->widgets, 'output_widget_control_templates' ] );
			}
		}

		// Template Include
		public function jltwp_adminify_template_include( $template ) {
			if ( is_customize_preview() && isset( $_REQUEST['wp-adminify-login-customizer'] ) && is_user_logged_in() ) {
				return plugin_dir_path( __FILE__ ) . 'Inc/wp-adminify-login-template.php';
			}

			return $template;
		}


		/**
		 * Enqueue the login customizer control styles.
		 */
		public function jltwp_adminify_control_styles() {
			wp_enqueue_script( 'wp-adminify-login-customizer', $this->url . '/assets/js/adminify-customizer.js', [ 'jquery', 'customize-controls' ], WP_ADMINIFY_VER, true );
			wp_localize_script( 'wp-adminify-login-customizer', 'WPAdminifyLoginCustomizer', $this->jltwp_adminify_create_js_object() );
		}

		/**
		 * Enqueue styles to login customizer preview styles.
		 */
		public function jltwp_adminify_preview_styles() {
			if ( ! is_customize_preview() ) {
				return;
			}

			wp_enqueue_style( 'wp-adminify-login-customizer-preview', $this->url . '/assets/css/preview.css', [], WP_ADMINIFY_VER, 'all' );
		}

		/**
		 * Enqueue scripts to login customizer preview scripts.
		 */
		public function jltwp_adminify_preview_scripts() {
			if ( ! is_customize_preview() ) {
				return;
			}
			wp_enqueue_script( 'wp-adminify-login-customizer-preview', $this->url . '/assets/js/preview.js', [ 'jquery', 'customize-preview' ], WP_ADMINIFY_VER, true );
			wp_localize_script( 'wp-adminify-login-customizer-preview', 'WPAdminifyLoginCustomizer', $this->jltwp_adminify_create_js_object() );
		}
		/**
		 * Enqueue login customizer control scripts.
		 */
		public function jltwp_adminify_control_scripts() {
			wp_enqueue_style( 'wp-adminify-login-customizer-controls' );
			wp_enqueue_script( 'wp-adminify-login-customizer', $this->url . '/assets/js/adminify-customizer.js', [ 'jquery', 'customize-controls' ], WP_ADMINIFY_VER, true );
			wp_localize_script( 'wp-adminify-login-customizer', 'WPAdminifyLoginCustomizer', $this->jltwp_adminify_create_js_object() );
		}

		/**
		 * Login customizer's localized JS object.
		 *
		 * @return array The login customizer's localized JS object.
		 */
		public function jltwp_adminify_create_js_object() {
			return [
				'homeUrl'             => home_url(),
				'ajaxurl'             => admin_url( 'admin-ajax.php' ),
				'loginPageUrl'        => home_url( 'wp-adminify-login-customizer' ),
				'pluginUrl'           => rtrim( WP_ADMINIFY_URL, '/' ),
				'login_template'      => $this->options['templates'],
				'moduleUrl'           => $this->url,
				'assetUrl'            => $this->url . '/assets/',
				'preset_nonce'        => wp_create_nonce( 'wp-adminify-login-customizer-template-nonce' ),
				'wpLogoUrl'           => admin_url( 'images/wordpress-logo.svg?ver=' . WP_ADMINIFY_VER ),
				'siteurl'             => get_option( 'siteurl' ),
				'register_url'        => wp_registration_url(),
				'anyone_can_register' => get_option( 'users_can_register' ),
				'filter_bg'           => apply_filters( 'adminify_logincustomizer_bg', '' ),
				'preset_loader'       => includes_url( 'js/tinymce/skins/lightgray/img/loader.gif' ),
				'isProActive'         => jltwp_adminify()->can_use_premium_code__premium_only() ? true : false,
			];
		}


		// Template Selection
		public function jltwp_adminify_templates() {
			check_ajax_referer( 'wp-adminify-login-customizer-template-nonce', 'security' );

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( 'No cheating, huh!' );
			}

			$selected_template = $_POST['template_id'];
			if ( $selected_template == 'template-01' ) {
				include_once plugin_dir_path( __FILE__ ) . 'Inc/templates/template-01.php';
			} else {
				do_action( 'wp_adminify_add_templates', $selected_template );
			}
			wp_die();
		}


		/**
		 * Customizer Redirect
		 */
		public function jltwp_adminify_redirect_customizer() {
			if ( ! empty( $_GET['page'] ) ) {
				if ( 'wp-adminify-settings-login-customizer' === $_GET['page'] ) {
					// Redirect URL
					$url = add_query_arg(
						[
							'autofocus[panel]' => 'jltwp_adminify_panel',
						],
						admin_url( 'customize.php' )
					);

					wp_safe_redirect( $url );
				}
			}
		}


		/**
		 * Login Customizer Submenu
		 */
		public function jltwp_adminify_login_customizer_submenu() {
			add_submenu_page(
				'wp-adminify-settings',
				esc_html__( 'Login Customizer', 'adminify' ),
				esc_html__( 'Login Customizer', 'adminify' ),
				apply_filters( 'jltwp_adminify_capability', 'manage_options' ),
				admin_url( 'customize.php?autofocus[panel]=jltwp_adminify_panel' )
			);
		}


		/**
		 * Register Panels
		 */
		public function jltwp_adminify_register_panels( $wp_customize ) {
			$wp_customize->add_panel(
				'jltwp_adminify_panel',
				[
					'title'       => __( 'Login Customizer - WP Adminify', 'adminify' ),
					'description' => __( 'Customize Your WordPress Login Page with WP Adminify :)', 'adminify' ),
					'capability'  => apply_filters( 'jltwp_adminify_capability', 'manage_options' ),
					'priority'    => 10,
				]
			);
		}

		/**
		 * Login Customizer Sections
		 *
		 * @param [type] $wp_customize
		 *
		 * @return void
		 */
		public function jltwp_adminify_register_sections( $wp_customize ) {
			jltwp_adminify_sections( $wp_customize );
		}
	}
}
