<?php

namespace WPAdminify\Inc\Classes;

use WPAdminify\Inc\Classes\Wizard\Adminify_Setup_Wizard;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Setup_Wizard {

	public function __construct() {
		add_action( 'admin_init', [ $this, 'jltwp_adminify_redirects' ] );
		add_action( 'admin_menu', [ $this, 'jltwp_adminify_setup_wizar_menu' ], 59 );
		add_action( 'admin_init', [ $this, 'jltwp_adminify_setup_wizard_run' ] );
	}

	public function jltwp_adminify_setup_wizard_run() {
		new Adminify_Setup_Wizard();
	}


	public function jltwp_adminify_setup_wizar_menu() {
		add_submenu_page(
			'wp-adminify-settings',
			esc_html__( 'Setup Wizard by WP Adminify', 'adminify' ),
			esc_html__( 'Setup Wizard', 'adminify' ),
			apply_filters( 'jltwp_adminify_capability', 'manage_options' ),
			'wp-adminify-setup-wizard'
		);

		add_dashboard_page( '', '', 'manage_options', 'wp-adminify-setup-wizard', '' );
	}


	public function jltwp_adminify_redirects() {
		if ( ! current_user_can( 'administrator' ) || is_network_admin() || isset( $_GET['activate-multi'] ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// jltwp_adminify_setup_wizard_ran = 0 => not started
		// jltwp_adminify_setup_wizard_ran = 1 => finished
		// jltwp_adminify_setup_wizard_ran = 2 => started
		// jltwp_adminify_setup_wizard_ran = 3 => canceled

		$is_ran = get_option( 'jltwp_adminify_setup_wizard_ran', '0' );

		if ( is_admin() ) {
			global $pagenow;
			if ( ( $pagenow == 'index.php' && ! isset( $_GET['page'] ) ) || ( $pagenow == 'admin.php' && ( isset( $_GET['page'] ) && $_GET['page'] == 'wp-adminify-settings' ) ) ) {
				if ( $is_ran == '2' ) {
					update_option( 'jltwp_adminify_setup_wizard_ran', '3' );
				}
			}

			if ( ( ( $pagenow == 'index.php' && ! isset( $_GET['page'] ) ) || ( $pagenow == 'admin.php' && ( isset( $_GET['page'] ) && $_GET['page'] == 'wp-adminify-settings' ) ) ) && isset( $_GET['adminify_setup_done_config'] ) && $_GET['adminify_setup_done_config'] == '1' ) {
				if ( $is_ran == '2' ) {
					update_option( 'jltwp_adminify_setup_wizard_ran', '1' );
				}
			}
		}

		if ( $is_ran != '1' && $is_ran != '2' && $is_ran != '3' ) {
			update_option( 'jltwp_adminify_setup_wizard_ran', '2' );
			wp_safe_redirect( admin_url( 'index.php?page=wp-adminify-setup-wizard' ) );
			exit;
		} elseif ( $is_ran == '2' ) {
			new \WPAdminify\Inc\Classes\Wizard\Adminify_Setup_Wizard();
		}
	}
}
