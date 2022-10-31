<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class Tweaks_HTTP_Response extends AdminSettingsModel {

	public function __construct() {
		$this->tweaks_http_response_settings();
	}

	public function get_defaults() {
		return [
			'self_ping'             => false,
			'remove_http_shortlink' => false,
			'remove_pingback'       => false,
			'remove_powered'        => false,
		];
	}


	public function tweaks_http_response_fields( &$http_response_fields ) {
		$http_response_fields[] = [
			'type'    => 'subheading',
			'content' => Utils::adminfiy_help_urls(
				__( 'Cleanup your server response HTTP headers.', 'adminify' ),
				'https://wpadminify.com/kb/wp-adminify-tweaks/',
				'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
				'https://www.facebook.com/groups/jeweltheme',
				'https://wpadminify.com/support/'
			),
		];

		$http_response_fields[] = [
			'id'         => 'self_ping',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Disable Self Ping', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'self_ping' ),
		];

		$http_response_fields[] = [
			'id'         => 'remove_http_shortlink',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Remove Shortlink from HTTP Headers', 'adminify' ),
			'subtitle'   => esc_html__( 'Remove "Link:<...>; rel=shortlink" from server response HTTP headers', 'adminify' ),
			'label'      => esc_html__( 'This response header contains link to posts short URLs. This information is not used anywhere and you can remove this.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_http_shortlink' ),
		];

		$http_response_fields[] = [
			'id'         => 'remove_pingback',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Remove X-Pingback from HTTP Headers', 'adminify' ),
			'subtitle'   => esc_html__( 'Remove "X-Pingback:..." from server response HTTP headers (works only with PHP 5.3 and up)', 'adminify' ),
			'label'      => esc_html__( 'This response header contains link to your pingback file. This information can be used by spammers and you can remove it.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_pingback' ),
		];

		$http_response_fields[] = [
			'id'         => 'remove_powered',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Remove X-Powered-By from HTTP Headers', 'adminify' ),
			'subtitle'   => esc_html__( 'Remove "X-Powered-By:..." from server response HTTP headers (works only with PHP 5.3 and up)', 'adminify' ),
			'label'      => esc_html__( 'This response header contains information about PHP version on your server. This information is not used anywhere and you can remove this.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_powered' ),
		];
	}


	public function tweaks_http_response_settings() {
		if ( ! class_exists( 'ADMINIFY' ) ) {
			return;
		}

		$http_response_fields = [];
		$this->tweaks_http_response_fields( $http_response_fields );

		\ADMINIFY::createSection(
			$this->prefix,
			[
				'title'  => __( 'HTTP Response', 'adminify' ),
				'parent' => 'tweaks_performance',
				'icon'   => 'fas fa-shield-virus',
				'fields' => $http_response_fields,
			]
		);
	}
}
