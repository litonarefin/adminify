<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class Tweaks_WP_JSON_API extends AdminSettingsModel {

	public function __construct() {
		$this->tweaks_wp_json_api_settings();
	}

	public function get_defaults() {
		return [
			'disable_rest_api'      => false,
			'control_heartbeat_api' => false,
			'remove_api_head'       => false,
			'remove_powered'        => false,
			'remove_api_server'     => false,
			'disable_all_api'       => false,
		];
	}


	public function tweaks_json_api_fields( &$json_api_fields ) {
		$json_api_fields[] = [
			'type'    => 'subheading',
			'content' => Utils::adminfiy_help_urls(
				__( 'Cleanup your site from WP JSON API features.', 'adminify' ),
				'https://wpadminify.com/kb/wp-adminify-tweaks/',
				'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
				'https://www.facebook.com/groups/jeweltheme',
				'https://wpadminify.com/support/'
			),
		];

		$json_api_fields[] = [
			'id'         => 'disable_rest_api',
			'type'       => 'switcher',
			'title'      => __( 'Disable REST API', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'disable_rest_api' ),
		];

		$json_api_fields[] = [
			'id'         => 'control_heartbeat_api',
			'type'       => 'switcher',
			'title'      => __( 'Control Heartbeat API', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'control_heartbeat_api' ),
		];

		$json_api_fields[] = [
			'id'         => 'remove_api_head',
			'type'       => 'switcher',
			'title'      => __( 'Remove WP API Links and Scripts', 'adminify' ),
			'subtitle'   => __( 'Remove all WP JSON API links and scripts from head section', 'adminify' ),
			'label'      => __( 'This option does not disable WP API, just cleans head section from these links.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_api_head' ),
		];

		$json_api_fields[] = [
			'id'         => 'remove_api_server',
			'type'       => 'switcher',
			'title'      => __( 'Remove WP API Link from HTTP Headers', 'adminify' ),
			'subtitle'   => __( 'Remove "Link:<...>; rel=https://api.w.org/" from server response HTTP headers', 'adminify' ),
			'label'      => __( 'This option does not disable WP API, just cleans HTTP headers.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_api_server' ),
		];

		$json_api_fields[] = [
			'id'         => 'disable_all_api',
			'type'       => 'switcher',
			'title'      => __( 'Totally Disable WP API Feature', 'adminify' ),
			'subtitle'   => __( 'Disable WP JSON API functionality on your site', 'adminify' ),
			'label'      => __( 'WordPress API is used by external apps to get data from your site. If you are not using this feature you can disable this.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'disable_all_api' ),
		];
	}


	public function tweaks_wp_json_api_settings() {
		if ( ! class_exists( 'ADMINIFY' ) ) {
			return;
		}

		$json_api_fields = [];
		$this->tweaks_json_api_fields( $json_api_fields );

		\ADMINIFY::createSection(
			$this->prefix,
			[
				'title'  => __( 'WP JSON API', 'adminify' ),
				'parent' => 'tweaks_performance',
				'icon'   => 'fas fa-file-code',
				'fields' => $json_api_fields,
			]
		);
	}
}
