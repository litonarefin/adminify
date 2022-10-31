<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class DashboardWidgets extends AdminSettingsModel {

	public function __construct() {
		$this->dasboard_widgets_settings();
	}

	public function get_defaults() {
		return [
			'dashboard_widgets' => [
				'dashboard_widgets_user_roles' => [],
				'dashboard_widgets_list'       => [],
			],
		];
	}

	public function dasboard_widgets_settings() {
		if ( ! class_exists( 'ADMINIFY' ) ) {
			return;
		}

		// Dashboard Widgets Section
		\ADMINIFY::createSection(
			$this->prefix,
			[
				'title'  => __( 'Dashboard Widgets', 'adminify' ),
				'icon'   => 'dashicons dashicons-dashboard',
				'parent' => 'widget_settings',
				'id'     => 'dashboard_widgets',
				'fields' => [
					[
						'type'    => 'subheading',
						'content' => Utils::adminfiy_help_urls(
							__( 'Dashboard Widgets Settings', 'adminify' ),
							'https://wpadminify.com/kb/wp-widget-settings/',
							'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
							'https://www.facebook.com/groups/jeweltheme',
							'https://wpadminify.com/support/'
						),
					],
					[
						'id'          => 'dashboard_widgets_user_roles',
						'type'        => 'select',
						'title'       => __( 'Visible for', 'adminify' ),
						'placeholder' => __( 'Select User roles you want to show', 'adminify' ),
						'options'     => 'roles',
						'multiple'    => true,
						'chosen'      => true,
						'default'     => $this->get_default_field( 'dashboard_widgets' )['dashboard_widgets_user_roles'],
					],
					[
						'id'      => 'dashboard_widgets_list',
						'type'    => 'checkbox',
						'title'   => __( 'Remove unwanted Widgets', 'adminify' ),
						'options' => '\WPAdminify\Inc\Classes\DashboardWidgets::render_dashboard_checkboxes',
						'default' => $this->get_default_field( 'dashboard_widgets' )['dashboard_widgets_list'],
					],

				],
			]
		);
	}
}
