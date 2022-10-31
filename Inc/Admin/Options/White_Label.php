<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class White_Label extends AdminSettingsModel {

	public function __construct() {
		$this->white_label_settings();
	}

	public function get_defaults() {
		return [
			'jltwp_adminify_wl_plugin_logo'            => '',
			'jltwp_adminify_wl_plugin_name'            => 'WP Adminify',
			'jltwp_adminify_wl_plugin_desc'            => 'Supercharge your WordPress Adminify with <a href="https://wpadminify.com">WP Adminify</a> plugin. It has Professional & Clean UI, White Label, Analytics, Charts, Menu UI, WP Dark Theme, User Roles management, Multisite Support and many more to get amazed.',
			'jltwp_adminify_wl_plugin_author_name'     => 'Jewel Theme',
			'jltwp_adminify_wl_plugin_menu_label'      => WP_ADMINIFY,
			'jltwp_adminify_wl_plugin_url'             => 'https://wpadminify.com',
			'jltwp_adminify_wl_plugin_row_links'       => false,
			'jltwp_adminify_wl_plugin_tab_system_info' => false,
			'jltwp_adminify_wl_plugin_option'          => false,
			'jltwp_adminify_remove_action_links'       => [],
		];
	}


	/**
	 * Tweaks: Performance Fields
	 *
	 * @param [type] $white_label
	 *
	 * @return void
	 */
	public function white_label_fields( &$white_label ) {
		$white_label_class = '';
		if ( ! jltwp_adminify()->is_plan( 'agency' ) ) {
			$white_label_class = 'adminify-depend-visible adminify-depend-on';
		}

		$white_label[] = [
			'type'    => 'subheading',
			'content' => Utils::adminfiy_help_urls(
				__( 'White Label Settings', 'adminify' ),
				'https://wpadminify.com/kb/adminify-white-label/',
				'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
				'https://www.facebook.com/groups/jeweltheme',
				'https://wpadminify.com/support/'
			),
		];

		$white_label[] = [
			'id'           => 'jltwp_adminify_wl_plugin_logo',
			'type'         => 'media',
			'class'        => $white_label_class,
			'title'        => __( 'Logo Image', 'adminify' ),
			'library'      => 'image',
			'preview_size' => 'thumbnail',
			'button_title' => __( 'Add Logo Image', 'adminify' ),
			'remove_title' => __( 'Remove Logo Image', 'adminify' ),
			'default'      => $this->get_default_field( 'jltwp_adminify_wl_plugin_logo' ),
		];

		$white_label[] = [
			'id'      => 'jltwp_adminify_wl_plugin_name',
			'type'    => 'text',
			'class'   => $white_label_class,
			'title'   => __( 'Plugin Name', 'adminify' ),
			'default' => $this->get_default_field( 'jltwp_adminify_wl_plugin_name' ),
		];

		$white_label[] = [
			'id'      => 'jltwp_adminify_wl_plugin_desc',
			'type'    => 'textarea',
			'class'   => $white_label_class,
			'title'   => __( 'Plugin Description', 'adminify' ),
			'default' => $this->get_default_field( 'jltwp_adminify_wl_plugin_desc' ),
		];

		$white_label[] = [
			'id'      => 'jltwp_adminify_wl_plugin_author_name',
			'type'    => 'text',
			'class'   => $white_label_class,
			'title'   => __( 'Developer/Agency Name', 'adminify' ),
			'default' => $this->get_default_field( 'jltwp_adminify_wl_plugin_author_name' ),
		];

		$white_label[] = [
			'id'      => 'jltwp_adminify_wl_plugin_menu_label',
			'type'    => 'text',
			'class'   => $white_label_class,
			'title'   => __( 'Menu Label', 'adminify' ),
			'default' => $this->get_default_field( 'jltwp_adminify_wl_plugin_menu_label' ),
		];

		$white_label[] = [
			'id'      => 'jltwp_adminify_wl_plugin_url',
			'type'    => 'text',
			'class'   => $white_label_class,
			'title'   => __( 'Plugin URL', 'adminify' ),
			'default' => $this->get_default_field( 'jltwp_adminify_wl_plugin_url' ),
		];

		$white_label[] = [
			'type'    => 'subheading',
			'class'   => $white_label_class,
			'content' => __( 'White Label WP Adminify', 'adminify' ),
		];

		// $white_label[] = array(
		// 'id'            => 'jltwp_adminify_wl_plugin_tab_system_info',
		// 'type'          => 'checkbox',
		// 'label'         => __('Hide System Info Menu', 'adminify'),
		// 'default'       => $this->get_default_field('jltwp_adminify_wl_plugin_tab_system_info')
		// );

		$white_label[] = [
			'id'      => 'jltwp_adminify_wl_plugin_row_links',
			'type'    => 'checkbox',
			'class'   => $white_label_class,
			'label'   => __( 'Hide Plugin Row Meta Links', 'adminify' ),
			'default' => $this->get_default_field( 'jltwp_adminify_wl_plugin_row_links' ),
		];
		if ( ! jltwp_adminify()->is_plan( 'agency' ) ) {
			$white_label[] = [
				'type'     => 'callback',
				'class'    => 'wp-adminify-white-label-notice',
				'function' => 'WPAdminify\Inc\Utils::jltwp_adminify_white_label_upgrade',
			];
		}

		$white_label[] = [
			'id'      => 'jltwp_adminify_remove_action_links',
			'type'    => 'checkbox',
			'class'   => 'aminify-title-width-40',
			'title'   => __( 'Remove Action Links', 'adminify' ),
			'options' => [
				'upgrade'                  => __( 'Upgrade', 'adminify' ),
				'activate-license'         => __( 'Activate/Change License', 'adminify' ),
				'opt-in-or-opt-out'        => __( 'Opt In/Out', 'adminify' ),
				'adminify-plugin-settings' => __( 'Settings', 'adminify' ),
			],
		];

		$white_label[] = [
			'id'      => 'jltwp_adminify_wl_plugin_option',
			'type'    => 'checkbox',
			'class'   => $white_label_class,
			'class'   => 'adminify-full-width-field adminify-hightlight-field',
			'label'   => __( 'Enable Force Disable "White Label" Options: If you enable this option, White Label option will be completely hidden. If you want it back, You have to deactivate and activate plugin to make it work again.', 'adminify' ),
			'default' => $this->get_default_field( 'jltwp_adminify_wl_plugin_option' ),
		];
	}


	/*
	White Label Settings
	*/
	public function white_label_settings() {
		if ( ! class_exists( 'ADMINIFY' ) ) {
			return;
		}

		$white_label = [];
		$this->white_label_fields( $white_label );

		\ADMINIFY::createSection(
			$this->prefix,
			[
				'title'  => __( 'White Label', 'adminify' ),
				'icon'   => 'far fa-copyright',
				'class'  => 'wp-adminify-two-columns ',
				'fields' => $white_label,
			]
		);
	}
}
