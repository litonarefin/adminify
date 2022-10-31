<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class Tweaks_Attachments extends AdminSettingsModel {

	public function __construct() {
		$this->tweaks_attachments_settings();
	}


	public function get_defaults() {
		return [
			'thumbnails_rss_feed'   => false,
			'remove_image_link'     => false,
			'remove_attachment'     => false,
			'disable_pdf_thumbnail' => false,
		];
	}


	public function tweaks_attachment_fields( &$attachment_fields ) {
		$attachment_fields[] = [
			'type'    => 'subheading',
			'content' => Utils::adminfiy_help_urls(
				__( 'Redirect attachment single page URLs to parent post URL to avoid indexing these pages.', 'adminify' ),
				'https://wpadminify.com/kb/wp-adminify-tweaks/',
				'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
				'https://www.facebook.com/groups/jeweltheme',
				'https://wpadminify.com/support/'
			),
		];

		$attachment_fields[] = [
			'id'         => 'thumbnails_rss_feed',
			'type'       => 'switcher',
			'title'      => __( 'Show Thumbnails on RSS Feed', 'adminify' ),
			'subtitle'   => __( 'Show Post Thumbnails on RSS excerpt and Content Feed', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'thumbnails_rss_feed' ),
		];

		$attachment_fields[] = [
			'id'         => 'remove_image_link',
			'type'       => 'switcher',
			'title'      => __( 'Remove Image Link', 'adminify' ),
			'subtitle'   => __( 'Remove Default Image Link', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_image_link' ),
		];

		$attachment_fields[] = [
			'id'         => 'remove_attachment',
			'type'       => 'switcher',
			'title'      => __( 'Disable Attachments', 'adminify' ),
			'subtitle'   => __( 'Redirect attachment pages archives to parent post URL', 'adminify' ),
			'label'      => __( 'Every image or other file attached to post has it\'s own URL and sometimes it can hurt your SEO if these URLs will be indexed by search engines.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_attachment' ),
		];

		$attachment_fields[] = [
			'id'         => 'disable_pdf_thumbnail',
			'type'       => 'switcher',
			'title'      => __( 'Disable PDF Thumbnails Preview', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'disable_pdf_thumbnail' ),
		];
	}


	public function tweaks_attachments_settings() {
		if ( ! class_exists( 'ADMINIFY' ) ) {
			return;
		}

		$attachment_fields = [];
		$this->tweaks_attachment_fields( $attachment_fields );

		\ADMINIFY::createSection(
			$this->prefix,
			[
				'title'  => __( 'Attachments', 'adminify' ),
				'parent' => 'tweaks_performance',
				'icon'   => 'far fa-file-alt',
				'fields' => $attachment_fields,
			]
		);
	}
}
