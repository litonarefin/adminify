<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class Admin_Footer extends AdminSettingsModel {

	public function __construct() {
		$this->admin_footer_settings();
	}


	public function get_defaults() {
		return [
			'admin_footer_user_roles'         => '',
			'admin_footer_default_wp_version' => true,
			'admin_footer_ip_address'         => true,
			'admin_footer_php_version'        => true,
			'admin_footer_wp_version'         => true,
			'admin_footer_memory_usage'       => true,
			'admin_footer_memory_limit'       => true,
			'admin_footer_memory_available'   => true,
			'footer_text'                     => '',
		];
	}
	public function admin_footer_settings() {
		if ( ! class_exists( 'ADMINIFY' ) ) {
			return;
		}

		\ADMINIFY::createSection(
			$this->prefix,
			[
				'title'  => __( 'Admin Footer', 'adminify' ),
				'icon'   => 'fas fa-grip-horizontal',
				'fields' => [

					[
						'type'    => 'subheading',
						'content' => Utils::adminfiy_help_urls(
							__( 'Admin Footer Settings', 'adminify' ),
							'https://wpadminify.com/kb/admin-footer/',
							'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
							'https://www.facebook.com/groups/jeweltheme',
							'https://wpadminify.com/support/'
						),
					],
					[
						'id'          => 'admin_footer_user_roles',
						'type'        => 'select',
						'title'       => __( 'Disable for', 'adminify' ),
						'placeholder' => __( 'Select User roles you don\'t want to show', 'adminify' ),
						'options'     => 'roles',
						'multiple'    => true,
						'chosen'      => true,
						'default'     => $this->get_default_field( 'admin_footer_user_roles' ),
					],

					[
						'id'         => 'admin_footer_default_wp_version',
						'type'       => 'switcher',
						'title'      => __( 'Default WP Version', 'adminify' ),
						'text_on'    => 'Show',
						'text_off'   => 'Hide',
						'text_width' => 90,
						'default'    => $this->get_default_field( 'admin_footer_default_wp_version' ),
					],

					// Adminify Footer Text
					[
						'type'    => 'subheading',
						'content' => __( 'Adminify Footer', 'adminify' ),
					],

					[
						'id'         => 'admin_footer_ip_address',
						'type'       => 'switcher',
						'title'      => __( 'IP Address', 'adminify' ),
						'text_on'    => 'Show',
						'text_off'   => 'Hide',
						'text_width' => 90,
						'default'    => $this->get_default_field( 'admin_footer_ip_address' ),
					],

					[
						'id'         => 'admin_footer_php_version',
						'type'       => 'switcher',
						'title'      => __( 'PHP Version', 'adminify' ),
						'text_on'    => 'Show',
						'text_off'   => 'Hide',
						'text_width' => 90,
						'default'    => $this->get_default_field( 'admin_footer_php_version' ),
					],
					[
						'id'         => 'admin_footer_wp_version',
						'type'       => 'switcher',
						'title'      => __( 'WordPress Version', 'adminify' ),
						'text_on'    => 'Show',
						'text_off'   => 'Hide',
						'text_width' => 90,
						'default'    => $this->get_default_field( 'admin_footer_wp_version' ),
					],
					[
						'id'         => 'admin_footer_memory_usage',
						'type'       => 'switcher',
						'title'      => __( 'Memory Usage', 'adminify' ),
						'text_on'    => 'Show',
						'text_off'   => 'Hide',
						'text_width' => 90,
						'default'    => $this->get_default_field( 'admin_footer_memory_usage' ),
					],
					[
						'id'         => 'admin_footer_memory_limit',
						'type'       => 'switcher',
						'title'      => __( 'Memory Limit', 'adminify' ),
						'text_on'    => 'Show',
						'text_off'   => 'Hide',
						'text_width' => 90,
						'default'    => $this->get_default_field( 'admin_footer_memory_limit' ),
					],

					[
						'id'         => 'admin_footer_memory_available',
						'type'       => 'switcher',
						'title'      => __( 'Memory Available', 'adminify' ),
						'text_on'    => 'Show',
						'text_off'   => 'Hide',
						'text_width' => 90,
						'default'    => $this->get_default_field( 'admin_footer_memory_available' ),
					],

					[
						'id'            => 'footer_text',
						'type'          => 'wp_editor',
						'title'         => __( 'Admin Footer Text', 'adminify' ),
						'height'        => '100px',
						'media_buttons' => false,
						'default'       => $this->get_default_field( 'footer_text' ),
					],

				],
			]
		);
	}
}
