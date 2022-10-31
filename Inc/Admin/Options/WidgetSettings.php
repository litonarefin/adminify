<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Admin\AdminSettingsModel;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class WidgetSettings extends AdminSettingsModel {

	public $defaults = [];

	public function __construct() {
		$this->widget_settings();
	}

	protected function get_defaults() {
		return $this->defaults;
	}

	public function widget_settings() {
		if ( ! class_exists( 'ADMINIFY' ) ) {
			return;
		}

		\ADMINIFY::createSection(
			$this->prefix,
			[
				'title' => __( 'Widget Settings', 'adminify' ),
				'id'    => 'widget_settings',
				'icon'  => 'dashicons dashicons-admin-appearance',
			]
		);

		$this->defaults = array_merge( $this->defaults, ( new DashboardWidgets() )->get_defaults() );
		$this->defaults = array_merge( $this->defaults, ( new Sidebar_Remove() )->get_defaults() );
	}
}
