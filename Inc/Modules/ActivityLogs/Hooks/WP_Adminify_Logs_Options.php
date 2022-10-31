<?php

namespace WPAdminify\Inc\Modules\ActivityLogs\Hooks;

use  WPAdminify\Inc\Modules\ActivityLogs\Inc\Hooks_Base;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Adminify_Logs_Options extends Hooks_Base {

	public function __construct() {
		parent::__construct();
		add_action( 'updated_option', [ $this, 'hooks_updated_option' ], 10, 3 );
	}

	public function hooks_updated_option( $option, $oldvalue, $_newvalue ) {
		$whitelist_options = apply_filters(
			'wp_adminify_whitelist_options',
			[
				// General
				'blogname',
				'blogdescription',
				'siteurl',
				'home',
				'admin_email',
				'users_can_register',
				'default_role',
				'timezone_string',
				'date_format',
				'time_format',
				'start_of_week',

				// Writing
				'use_smilies',
				'use_balanceTags',
				'default_category',
				'default_post_format',
				'mailserver_url',
				'mailserver_login',
				'mailserver_pass',
				'default_email_category',
				'ping_sites',

				// Reading
				'show_on_front',
				'page_on_front',
				'page_for_posts',
				'posts_per_page',
				'posts_per_rss',
				'rss_use_excerpt',
				'blog_public',

				// Discussion
				'default_pingback_flag',
				'default_ping_status',
				'default_comment_status',
				'require_name_email',
				'comment_registration',
				'close_comments_for_old_posts',
				'close_comments_days_old',
				'thread_comments',
				'thread_comments_depth',
				'page_comments',
				'comments_per_page',
				'default_comments_page',
				'comment_order',
				'comments_notify',
				'moderation_notify',
				'comment_moderation',
				'comment_whitelist',
				'comment_max_links',
				'moderation_keys',
				'blacklist_keys',
				'show_avatars',
				'avatar_rating',
				'avatar_default',

				// Media
				'thumbnail_size_w',
				'thumbnail_size_h',
				'thumbnail_crop',
				'medium_size_w',
				'medium_size_h',
				'large_size_w',
				'large_size_h',
				'uploads_use_yearmonth_folders',

				// Permalinks
				'permalink_structure',
				'category_base',
				'tag_base',

				// Widgets
				'sidebars_widgets',
			]
		);

		if ( ! in_array( $option, $whitelist_options ) ) {
			return;
		}

		// TODO: need to think about save old & new values.
		adminify_activity_logs(
			[
				'action'      => 'updated',
				'object_type' => 'Options',
				'object_name' => $option,
			]
		);
	}
}
