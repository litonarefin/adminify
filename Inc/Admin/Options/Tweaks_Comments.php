<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class Tweaks_Comments extends AdminSettingsModel {

	public function __construct() {
		$this->tweaks_comments_settings();
	}

	public function get_defaults() {
		return [
			'remove_comments_url'         => false,
			'remove_comments_notes'       => false,
			'remove_comments_author_link' => false,
			'remove_comments_autolinking' => false,
			'gravatar_query_strings'      => false,
			'enable_custom_gravatar'      => false,
			'custom_gravatar_image'       => [
				[
					'avatar_image' => '',
					'avatar_name'  => 'Avatar Name',
				],
			],
		];
	}


	public function tweaks_comments_fields( &$comments_fields ) {
		$comments_fields[] = [
			'type'    => 'subheading',
			'content' => Utils::adminfiy_help_urls(
				__( 'Cleanup your comment form and comments template.', 'adminify' ),
				'https://wpadminify.com/kb/wp-adminify-tweaks/',
				'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
				'https://www.facebook.com/groups/jeweltheme',
				'https://wpadminify.com/support/'
			),
		];

		$comments_fields[] = [
			'id'         => 'remove_comments_url',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Remove Website Field', 'adminify' ),
			'subtitle'   => esc_html__( 'Remove website (URL) field from comment form template', 'adminify' ),
			'label'      => esc_html__( 'Website field in comments is a popular way to leave spam link. You can avoid such kind of spam.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_comments_url' ),
		];

		$comments_fields[] = [
			'id'         => 'remove_comments_notes',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Remove Notes Before Comment Form', 'adminify' ),
			'subtitle'   => esc_html__( 'Remove "Your email address will not be published..." from comment form template', 'adminify' ),
			'label'      => esc_html__( 'This note is used on many websites. You can remove it as not unique content.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_comments_notes' ),
		];

		$comments_fields[] = [
			'id'         => 'remove_comments_author_link',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Remove Comment Author Link', 'adminify' ),
			'subtitle'   => esc_html__( 'Remove website link from comment author name', 'adminify' ),
			'label'      => esc_html__( 'By default comment author name is linked to its website. You can avoid this.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_comments_author_link' ),
		];

		$comments_fields[] = [
			'id'         => 'remove_comments_autolinking',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Disable Auto Linking', 'adminify' ),
			'subtitle'   => esc_html__( 'Disable auto linking in comment content (URLs will stay as plain text as were posted)', 'adminify' ),
			'label'      => esc_html__( 'When user adds URL as plain text to the comment WordPress automatically converts it to the link tag. You can disable this feature.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_comments_autolinking' ),
		];

		$comments_fields[] = [
			'id'         => 'gravatar_query_strings',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Remove Gravatar Query Strings', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'gravatar_query_strings' ),
		];

		$comments_fields[] = [
			'id'         => 'enable_custom_gravatar',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Custom Gravatar', 'adminify' ),
			'subtitle'   => esc_html__( 'Add Custom Gravatar Images', 'adminify' ),
			'label'      => esc_html__( 'If you want to Add your own Avatar Images for your users', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'enable_custom_gravatar' ),
		];

		$comments_fields[] = [
			'id'         => 'custom_gravatar_image',
			'type'       => 'repeater',
			'title'      => __( 'Custom Avatar', 'adminify' ),
			'fields'     => [
				[
					'id'      => 'avatar_image',
					'type'    => 'media',
					'title'   => __( 'Image', 'adminify' ),
					'library' => 'image',
				],
				[
					'id'    => 'avatar_name',
					'type'  => 'text',
					'title' => __( 'Name', 'adminify' ),
				],
			],
			'default'    => $this->get_default_field( 'custom_gravatar_image' ),
			'dependency' => [ 'enable_custom_gravatar', '==', 'true' ],
		];
	}

	public function tweaks_comments_settings() {
		if ( ! class_exists( 'ADMINIFY' ) ) {
			return;
		}

		$comments_fields = [];
		$this->tweaks_comments_fields( $comments_fields );

		\ADMINIFY::createSection(
			$this->prefix,
			[
				'title'  => __( 'Comments', 'adminify' ),
				'parent' => 'tweaks_performance',
				'icon'   => 'fas fa-comments',
				'fields' => $comments_fields,
			]
		);
	}
}
