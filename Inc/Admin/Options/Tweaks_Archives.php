<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class Tweaks_Archives extends AdminSettingsModel {

	public function __construct() {
		$this->tweaks_archives_settings();
	}

	public function get_defaults() {
		return [
			'display_last_modified_date' => false,
			'remove_capital_p_dangit'    => false,
			'remove_archives_date'       => false,
			'remove_archives_author'     => false,
			'remove_archives_tag'        => false,
			'remove_archives_category'   => false,
			'remove_archives_postformat' => false,
			'remove_archives_search'     => false,
		];
	}


	public function tweaks_archive_fields( &$archive_fields ) {
		$archive_fields[] = [
			'type'    => 'subheading',
			'content' => Utils::adminfiy_help_urls(
				__( 'Redirect unused archives to the homepage to avoid indexing these pages and content duplication.', 'adminify' ),
				'https://wpadminify.com/kb/wp-adminify-tweaks/',
				'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
				'https://www.facebook.com/groups/jeweltheme',
				'https://wpadminify.com/support/'
			),
		];

		$archive_fields[] = [
			'id'         => 'display_last_modified_date',
			'type'       => 'switcher',
			'title'      => __( 'Display Last Modified Date', 'adminify' ),
			'subtitle'   => __( 'Enable/Disable Last Modified date of Posts', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'display_last_modified_date' ),
		];

		$archive_fields[] = [
			'id'         => 'remove_capital_p_dangit',
			'type'       => 'switcher',
			'title'      => __( 'Remove Capital "P" Dangit', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_capital_p_dangit' ),
		];

		$archive_fields[] = [
			'id'         => 'remove_archives_date',
			'type'       => 'switcher',
			'title'      => __( 'Disable Date Archives', 'adminify' ),
			'subtitle'   => __( 'Redirect date archives to the homepage', 'adminify' ),
			'label'      => __( 'If you are not using date archives on your site you can disable them.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_archives_date' ),
		];

		$archive_fields[] = [
			'id'         => 'remove_archives_author',
			'type'       => 'switcher',
			'title'      => __( 'Disable Author Archives', 'adminify' ),
			'subtitle'   => __( 'Redirect author archives to the homepage', 'adminify' ),
			'label'      => __( 'If you have only 1 author on your site or you are not planning to use this archives you can disable them.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_archives_author' ),
		];

		$archive_fields[] = [
			'id'         => 'remove_archives_tag',
			'type'       => 'switcher',
			'title'      => __( 'Disable Tag Archives', 'adminify' ),
			'subtitle'   => __( 'Redirect tag archives to the homepage', 'adminify' ),
			'label'      => __( 'If you are not using tags on your site you can disable these archives.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_archives_tag' ),
		];

		$archive_fields[] = [
			'id'         => 'remove_archives_category',
			'type'       => 'switcher',
			'title'      => __( 'Disable Category Archives', 'adminify' ),
			'subtitle'   => __( 'Redirect category archives to the homepage', 'adminify' ),
			'label'      => __( 'If you are not using categories on your site you can disable these archives.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_archives_category' ),
		];

		$archive_fields[] = [
			'id'         => 'remove_archives_postformat',
			'type'       => 'switcher',
			'title'      => __( 'Disable Post Format Archives', 'adminify' ),
			'subtitle'   => __( 'Redirect post format archives to the homepage', 'adminify' ),
			'label'      => __( 'If you are not using post formats on your site you can disable these archives.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_archives_postformat' ),
		];

		$archive_fields[] = [
			'id'         => 'remove_archives_search',
			'type'       => 'switcher',
			'title'      => __( 'Disable Search', 'adminify' ),
			'subtitle'   => __( 'Redirect search listing to the homepage', 'adminify' ),
			'label'      => __( 'If you do not use search on your site you can disable search results page.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_archives_search' ),
		];
	}

	public function tweaks_archives_settings() {
		if ( ! class_exists( 'ADMINIFY' ) ) {
			return;
		}

		$archive_fields = [];
		$this->tweaks_archive_fields( $archive_fields );

		\ADMINIFY::createSection(
			$this->prefix,
			[
				'title'  => __( 'Post/Archives', 'adminify' ),
				'parent' => 'tweaks_performance',
				'icon'   => 'fas fa-edit',
				'fields' => $archive_fields,
			]
		);
	}
}
