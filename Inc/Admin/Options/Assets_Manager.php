<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

/**
 * WP Adminify
 *
 * @package WP Admin Bar
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */


class Assets_Manager extends AdminSettingsModel {

	public function __construct() {
		$this->assets_manager_settings();
	}


	public function get_defaults() {
		return [
			'adminify_assets' => [],
		];
	}

	/**
	 * Assets Manager Fields
	 *
	 * @param [type] $fields
	 *
	 * @return void
	 */
	public static function assets_manager_fields( &$fields ) {
		$fields[] = [
			'type'    => 'subheading',
			'content' => Utils::adminfiy_help_urls(
				__( 'Assets Manager Settings', 'adminify' ),
				'https://wpadminify.com/kb/wp-adminify-options-panel/#assets-manager',
				'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
				'https://www.facebook.com/groups/jeweltheme',
				'https://wpadminify.com/support/'
			),
		];

		$icon_style1 = [];
		if ( Utils::is_plugin_active( 'elementor/elementor.php' ) ) {
			$icon_style1 = [
				'elementor-icons' => __( 'Elementor Icons', 'adminify' ),
			];
		}
		$icon_style2         = [
			'wp-adminify-simple-line-icons' => __( 'Simple Line Icons', 'adminify' ),
			'wp-adminify-icomoon'           => __( 'Icomoon', 'adminify' ),
			'wp-adminify-themify-icons'     => __( 'Themify Icons', 'adminify' ),
		];
		$icon_library_styles = $icon_style1 + $icon_style2;

		$script_options = [
			'Styles'  => $icon_library_styles,
			'Scripts' => [
				'wp-adminify-circle-menu'     => __( 'Quick Circle Menu', 'adminify' ),
				'wp-adminify-realtime-server' => __( 'Realtime Server', 'adminify' ),
			],
		];

		$fields[] = [
			'id'      => 'adminify_assets',
			'type'    => 'checkbox',
			'title'   => __( 'Remove Scripts/Styles', 'adminify' ),
			'options' => $script_options,
		];
	}



	/**
	 * Assets Manager Settings
	 */
	public function assets_manager_settings() {
		if ( ! class_exists( 'ADMINIFY' ) ) {
			return;
		}

		$fields = [];
		self::assets_manager_fields( $fields );

		// Folders Order Section
		\ADMINIFY::createSection(
			$this->prefix,
			[
				'title'  => __( 'Assets Manager', 'adminify' ),
				'id'     => 'assets_manager_section',
				'icon'   => 'far fa-folder-open',
				'fields' => $fields,
			]
		);
	}
}
