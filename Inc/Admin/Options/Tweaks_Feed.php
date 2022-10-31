<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class Tweaks_Feed extends AdminSettingsModel {

	public function __construct() {
		$this->tweaks_feed_settings();
	}

	public function get_defaults() {
		return [
			'remove_feed'   => false,
			'redirect_feed' => false,
		];
	}


	/**
	 * Tweaks: Feed Fields
	 *
	 * @param [type] $feed_fields
	 *
	 * @return void
	 */
	public function tweaks_feed_fields( &$feed_fields ) {
		$feed_fields[] = [
			'type'    => 'subheading',
			'content' => Utils::adminfiy_help_urls(
				__( 'Cleanup your head section from feed links and redirect them to the homepage if needed.', 'adminify' ),
				'https://wpadminify.com/kb/wp-adminify-tweaks/',
				'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
				'https://www.facebook.com/groups/jeweltheme',
				'https://wpadminify.com/support/'
			),
		];

		$feed_fields[] = [
			'id'         => 'remove_feed',
			'type'       => 'switcher',
			'title'      => __( 'Remove Feed Links', 'adminify' ),
			'subtitle'   => __( 'Remove all feed links from head section', 'adminify' ),
			'label'      => __( 'This option does not disable feed functionality, just cleans head section.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'remove_feed' ),
		];

		$feed_fields[] = [
			'id'         => 'redirect_feed',
			'type'       => 'switcher',
			'title'      => __( 'Redirect ALL Feeds', 'adminify' ),
			'subtitle'   => __( 'Disable feeds feature by redirection to the homepage (also removes feed links from head section)', 'adminify' ),
			'label'      => __( 'This option totally disables feed functionality. If you are using feeds on your site (e.g. FeedBurner) do not disable feeds.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'redirect_feed' ),
		];
	}

	public function tweaks_feed_settings() {
		if ( ! class_exists( 'ADMINIFY' ) ) {
			return;
		}

		$feed_fields = [];
		$this->tweaks_feed_fields( $feed_fields );

		\ADMINIFY::createSection(
			$this->prefix,
			[
				'title'  => __( 'Feed', 'adminify' ),
				'parent' => 'tweaks_performance',
				'icon'   => 'fas fa-rss-square',
				'fields' => $feed_fields,
			]
		);
	}
}
