<?php

namespace WPAdminify\Inc\Classes;

use WPAdminify\Inc\Admin\AdminSettings;
use WPAdminify\Inc\Admin\AdminSettingsModel;
use WPAdminify\Inc\Admin\Options\Sidebar_Remove;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * WPAdminify
 * Sidebar Widgets
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class Sidebar_Widgets extends AdminSettingsModel {

	public function __construct() {
		$AdminSettings = AdminSettings::get_instance();

		$this->widget_list       = (array) $AdminSettings->get( 'sidebar_widgets_list' );
		$this->restrict_for      = (array) $AdminSettings->get( 'sidebar_widgets_user_roles' );
		$this->disable_gutenberg = wp_validate_boolean( $AdminSettings->get( 'sidebar_widgets_disable_gutenberg_editor' ) );

		$this->disable_gutenberg_editor();

		// Get and disable the sidebar widgets.
		add_action( 'widgets_init', [ $this, 'jltma_remove_default_widgets' ], 99 );
	}

	public function disable_gutenberg_editor() {
		if ( $this->disable_gutenberg ) {
			add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
			add_filter( 'use_widgets_block_editor', '__return_false' );
		}
	}

	/**
	 * Render all registered widgets
	 *
	 * @return void
	 */
	public static function render_sidebar_checkboxes() {
		return get_option( 'sidebar_widgets', [] );
	}

	/**
	 * Remove Sidebar Widgets.
	 *
	 * Gets the list of disabled sidebar widgets and disables
	 * them for you in WordPress.
	 *
	 * @since 1.0.0
	 */
	public function jltma_remove_default_widgets() {
		$user = wp_get_current_user();
		if ( ! empty( array_intersect( $this->restrict_for, $user->roles ) ) ) {
			return;
		}

		$widgets = $this->widget_list;

		$_widgets = Sidebar_Remove::jltma_get_default_widgets();

		update_option( 'sidebar_widgets', $_widgets );

		if ( ! empty( $widgets ) ) {
			foreach ( $widgets as $widget_class ) {
				unregister_widget( $widget_class );
			}
		}
	}
}
