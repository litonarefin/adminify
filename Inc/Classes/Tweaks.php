<?php

namespace WPAdminify\Inc\Classes;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettings;
use WPAdminify\Inc\Admin\AdminSettingsModel;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package WP Adminify
 * @author: Jewel Theme<support@jeweltheme.com>
 */

class Tweaks extends AdminSettingsModel {

	public $redirect_status = 301;

	public function __construct() {
		$this->options = (array) AdminSettings::get_instance()->get();
		$this->tweaks_init();
		$this->jltwp_adminify_cleanup();
		$this->http_response_cleanup();
		$this->wp_json_api_cleanup();
		$this->comments_cleanup();
		$this->archives_cleanup();
		$this->attachments_cleanup();
		$this->performance_cleanup();
		$this->remove_try_gutenberg_panel();
		$this->jltwp_adminify_customize_admin_bar();

		add_action( 'wp_dashboard_setup', [ $this, 'remove_welcome_panel' ], 999 );
	}

	public function tweaks_init() {
		/* Disable Self Pings */
		if ( ! empty( $this->options['self_ping'] ) ) {
			add_action( 'pre_ping', [ $this, 'jltwp_adminify_no_self_ping' ] );
		}

		/** Remove Dashicons from Admin Bar for non logged in users */
		if ( ! empty( $this->options['remove_dashicons'] ) ) {
			add_action( 'wp_print_styles', [ $this, 'jltwp_adminify_remove_dashicons' ], 100 );
		}

		/** Disable REST API */
		if ( ! empty( $this->options['disable_rest_api'] ) ) {
			// Filters for WP-API version 1.x
			add_filter( 'json_enabled', '__return_false' );
			add_filter( 'json_jsonp_enabled', '__return_false' );

			// Filters for WP-API version 2.x
			// add_filter('rest_enabled', '__return_false');
			add_filter( 'rest_jsonp_enabled', '__return_false' );
		}

		/** Control Interval Heartbeat API */
		if ( ! empty( $this->options['control_heartbeat_api'] ) ) {
			add_filter( 'heartbeat_settings', [ $this, 'jltwp_adminify_control_heartbeat' ] );
		}

		/** Remove Version Query Strings from Scripts/Styles */
		if ( ! empty( $this->options['remove_version_strings'] ) ) {
			add_filter( 'script_loader_src', [ $this, 'jltwp_adminify_remove_script_version' ], 15, 1 );
			add_filter( 'style_loader_src', [ $this, 'jltwp_adminify_remove_script_version' ], 15, 1 );
		}

		/** Remove Version Query Strings from Scripts/Styles */
		if ( ! empty( $this->options['remove_canonical'] ) ) {
			remove_action( 'embed_head', 'rel_canonical' );
			add_filter( 'wpseo_canonical', '__return_false' );
		}

		/** Remove Capital P Dangit */
		if ( ! empty( $this->options['remove_capital_p_dangit'] ) ) {
			remove_filter( 'the_title', 'capital_P_dangit', 11 );
			remove_filter( 'the_content', 'capital_P_dangit', 11 );
			remove_filter( 'comment_text', 'capital_P_dangit', 31 );
		}

		/** Disable PDF Thumbnails Preview */
		if ( ! empty( $this->options['disable_pdf_thumbnail'] ) ) {
			add_filter( 'fallback_intermediate_image_sizes', [ $this, 'jltwp_adminify_disable_pdf_previews' ] );
		}

		/** Secure method for Defer Parsing of JavaScript moving ALL JS from Header to Footer */
		if ( ! empty( $this->options['defer_parsing_js_footer'] ) ) {
			add_filter( 'script_loader_tag', [ $this, 'jltwp_adminify_defer_parsing_of_js' ], 10, 2 );
		}

		/* Remove Gravatar Query Strings */
		if ( ! empty( $this->options['gravatar_query_strings'] ) ) {
			add_filter( 'get_avatar_url', [ $this, 'jltwp_adminify_avatar_remove_querystring' ] );
		}

		// Add Custom Default Gravatar Image
		if ( ! empty( $this->options['enable_custom_gravatar'] ) ) {
			add_filter( 'avatar_defaults', [ $this, 'jltwp_adminify_add_custom_gravatar' ] );
		}

		/* Add Featured Image or Post Thumbnail to RSS Feed */
		if ( ! empty( $this->options['thumbnails_rss_feed'] ) ) {
			add_filter( 'the_excerpt_rss', [ $this, 'jltwp_adminify_rss_post_thumbnail' ] );
			add_filter( 'the_content_feed', [ $this, 'jltwp_adminify_rss_post_thumbnail' ] );
		}

		// tag and category hooks
		if ( ! empty( $this->options['display_last_modified_date'] ) ) {
			add_filter( 'the_content', [ $this, 'jltwp_adminify_last_updated_date' ], 10, 1 );
			add_filter( 'wp_head', [ $this, 'jltwp_adminify_last_updated_date_style' ] );
		}

		if ( ! empty( $this->options['remove_image_link'] ) ) {
			add_action( 'admin_init', [ $this, 'jltwp_adminify_imagelink' ], 10 );
		}

		/** Browser Cache Expires & GZIP Compression */
		if ( ! empty( $this->options['cache_gzip_compression'] ) ) {
			register_activation_hook( __FILE__, [ $this, 'jltwp_adminify_htaccess' ] );
		}
		/**
		 * We run the function that ckecks here
		 * if there are $lineas content between:
		 * # BEGIN WP Adminify by Jewel Theme
		 * and...
		 * # END WP Adminify by Jewel Theme
		 * If exist and it's the same we don't do anything,
		 * if has changed, we update it to the new one
		 * if it doesn't exist we write it.
		 */
		register_deactivation_hook( __FILE__, [ $this, 'jltwp_adminify_delete_tweaks_htaccess' ] );
	}


	// Remove Items from Admin bar
	public function jltwp_adminify_customize_admin_bar() {
		// add_action('admin_bar_menu', [$this, 'remove_from_admin_bar'], 999);
		// add_action('admin_bar_menu', [$this, 'clear_node_title'], 999);
		add_filter( 'admin_bar_menu', [ $this, 'jltma_adminify_change_howdy_text' ], 25 );
	}

	/*
	* Change Howdy Text
	*/
	public function jltma_adminify_change_howdy_text( $wp_admin_bar ) {
		$admin_bar_howdy_text = ! empty( $this->options['admin_bar_settings']['admin_bar_howdy_text'] ) ? $this->options['admin_bar_settings']['admin_bar_howdy_text'] : '';
		if ( ! empty( $admin_bar_howdy_text ) ) {
			$my_account         = $wp_admin_bar->get_node( 'my-account' );
			$changed_howdy_text = str_replace( 'Howdy,', $admin_bar_howdy_text, $my_account->title );
			$wp_admin_bar->add_node(
				[
					'id'    => 'my-account',
					'title' => $changed_howdy_text,
				]
			);
		}
	}



	// Clear the node titles
	// This will only work if the node is using a :before element for the icon
	public function clear_node_title( $wp_admin_bar ) {
		$all_toolbar_nodes = $wp_admin_bar->get_nodes();
		// Create an array of node ID's we'd like to remove
		$clear_titles = [
			'site-name',
			'customize',
		];

		foreach ( $all_toolbar_nodes as $node ) {

			// Run an if check to see if a node is in the array to clear_titles
			if ( in_array( $node->id, $clear_titles ) ) {
				// use the same node's properties
				$args = $node;

				// make the node title a blank string
				$args->title = '';

				// update the Toolbar node
				$wp_admin_bar->add_node( $args );
			}
		}
	}

	// Remove items from the admin bar
	public function remove_from_admin_bar( $wp_admin_bar ) {
		/*
		* Placing items in here will only remove them from admin bar
		* when viewing the fronte end of the site
		*/
		if ( ! is_admin() ) {
			// Example of removing item generated by plugin. Full ID is #wp-admin-bar-si_menu
			$wp_admin_bar->remove_node( 'si_menu' );

			// WordPress Core Items (uncomment to remove)
			$wp_admin_bar->remove_node( 'updates' );
			$wp_admin_bar->remove_node( 'comments' );
			$wp_admin_bar->remove_node( 'new-content' );
			// $wp_admin_bar->remove_node('wp-logo');
			// $wp_admin_bar->remove_node('site-name');
			// $wp_admin_bar->remove_node('my-account');
			// $wp_admin_bar->remove_node('search');
			// $wp_admin_bar->remove_node('customize');
		}

		/*
		* Items placed outside the if statement will remove it from both the frontend
		* and backend of the site
		*/
		$wp_admin_bar->remove_node( 'wp-logo' );
	}


	/**
	 * Remove Welcome Panel
	 */
	public function remove_welcome_panel() {
		if ( ! empty( $this->options['remove_welcome_panel'] ) ) {
			remove_action( 'welcome_panel', 'wp_welcome_panel' );
		}
	}


	/**
	 * Remove "Try Gutenberg Panel"
	 */
	public function remove_try_gutenberg_panel() {
		if ( ! empty( $this->options['remove_try_gutenberg_panel'] ) ) {
			remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );
		}
	}


	// Custom Avatars
	public function jltwp_adminify_add_custom_gravatar( $avatar_defaults ) {
		if ( ! empty( $this->options['custom_gravatar_image'] ) ) {
			foreach ( $this->options['custom_gravatar_image'] as $key => $value ) {
				$avatar_url                     = esc_url_raw( $value['avatar_image']['url'] );
				$avatar_defaults[ $avatar_url ] = $value['avatar_name'];
			}
		}
		return $avatar_defaults;
	}


	// Cleanup Hooks
	public function jltwp_adminify_cleanup() {

		// Hide Admin bar
		if ( ! empty( $this->options['show_admin_bar'] ) ) {
			add_filter( 'show_admin_bar', '__return_false' );
		}

		// Remove Admin Footer Version Number
		if ( ! empty( $this->options['admin_footer_default_wp_version'] ) ) {
			add_action( 'admin_menu', [ $this, 'remove_admin_footer_version' ] );
		}

		// Remove WordPress Version Number
		if ( ! empty( $this->options['generator_wp_version'] ) ) {
			remove_action( 'wp_head', 'wp_generator' ); // Remove WordPress Generator Version
			add_filter( 'the_generator', '__return_false' ); // Remove Generator Name From Rss Feeds.
		}

		// Remove Revolution Slider generator version
		if ( ! empty( $this->options['remove_revslider_generator'] ) ) {
			add_filter( 'revslider_meta_generator', '__return_empty_string' );
		}

		// Remove woocommerce generator version
		if ( ! empty( $this->options['remove_wc_generator'] ) ) {
			remove_action( 'wp_head', 'wc_generator_tag' );
		}

		// Remove wpml meta generator tag
		if ( ! empty( $this->options['remove_wpml_generator'] ) ) {
			add_action( 'wp_head', [ $this, '_remove_wpml_generator' ], 0 );
		}

		// Remove wpbakery visual_composer meta generator tag
		if ( ! empty( $this->options['remove_visual_composer_generator'] ) ) {
			add_action( 'wp_head', [ $this, 'jltwp_adminify_remove_visual_composer_generator' ], 1 );
		}

		// Remove Yoast SEO meta generator tag
		if ( ! empty( $this->options['remove_yoast_generator'] ) ) {
			add_filter( 'wpseo_debug_markers', '__return_false' );
		}

		// Remove WordPress.org Dns-prefetch.
		if ( ! empty( $this->options['remove_dns_prefetch'] ) ) {
			remove_action( 'wp_head', 'wp_resource_hints', 2 );
		}

		// REMOVE wlwmanifest.xml.
		if ( ! empty( $this->options['remove_wlwmanifest'] ) ) {
			remove_action( 'wp_head', 'wlwmanifest_link' );
		}

		// Remove Really Simple Discovery Link.
		if ( ! empty( $this->options['remove_rsd'] ) ) {
			remove_action( 'wp_head', 'rsd_link' );
		}

		// Remove Shortlink Url
		if ( ! empty( $this->options['remove_shortlink'] ) ) {
			remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
			remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
		}

		// Remove Emoji Styles and Scripts
		if ( ! empty( $this->options['remove_emoji'] ) ) {
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); // Remove Emoji's Styles and Scripts.
			remove_action( 'embeded_head', 'print_emoji_detection_script' );
			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' ); // Remove Emoji's Styles and Scripts.
			remove_action( 'wp_print_styles', 'print_emoji_styles' ); // Remove Emoji's Styles and Scripts.
			remove_action( 'admin_print_styles', 'print_emoji_styles' ); // Remove Emoji's Styles and Scripts.
			remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
			remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
			remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
			add_filter( 'tiny_mce_plugins', [ $this, 'disable_emojicons_tinymce' ] );
			add_filter( 'emoji_svg_url', '__return_false' );
		}

		$this->remove_feed();
		$this->redirect_feed();

		// Remove Link to Home Page.
		if ( ! empty( $this->options['remove_link_url'] ) ) {
			remove_action( 'wp_head', 'index_rel_link' );
		}

		// Remove Prev/Next Link from Head
		if ( ! empty( $this->options['remove_prev_next'] ) ) {
			remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 ); // Remove Prev-next Links From Header -not From Post-.
			remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Remove Prev-next Links.
			remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // Remove Random Link Post.
			remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // Remove Parent Post Link.
		}

		// Remove styles for .recentcomments
		if ( ! empty( $this->options['remove_recentcomments'] ) ) {
			add_action( 'widgets_init', [ $this, 'jltwp_adminify_remove_recent_comments_style' ] );
		}

		// Remove styles for .recentcomments
		if ( ! empty( $this->options['disable_xmlrpc'] ) ) {
			add_action( 'wp_default_scripts', [ $this, 'jltwp_adminify_disable_xmlrpc' ], 9999 );
		}
	}

	// Remove styles for .recentcomments
	public function jltwp_adminify_remove_recent_comments_style() {
		global $wp_widget_factory;
		remove_action( 'wp_head', [ $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ] );
	}

	// Remove Visual Composer Generator
	public function jltwp_adminify_remove_visual_composer_generator() {
		if ( class_exists( 'Vc_Manager' ) ) {
			remove_action( 'wp_head', [ visual_composer(), 'addMetaData' ] );
		}
	}

	// Remove WPML Generator
	public function _remove_wpml_generator() {
		if ( ! empty( $GLOBALS['sitepress'] ) ) {
			remove_action( current_filter(), [ $GLOBALS['sitepress'], 'meta_generator_tag' ] );
		}
	}

	/**
	 * Disable XML-RPC
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function jltwp_adminify_disable_xmlrpc() {
		add_filter( 'xmlrpc_enabled', '__return_false' );
	}

	/**
	 * Disable WP emojicons from TinyMCE
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function disable_emojicons_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, [ 'wpemoji' ] );
		} else {
			return [];
		}
	}


	// HTTP Response Cleanup
	public function http_response_cleanup() {
		// Remove Link rel=shortlink from http
		if ( ! empty( $this->options['remove_http_shortlink'] ) ) {
			remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
		}

		// Remove X-Pingback
		if ( ! empty( $this->options['remove_pingback'] ) ) {
			add_filter( 'wp_headers', [ $this, 'jltwp_adminify_remove_pingback_head' ] );
			add_action( 'wp', [ $this, 'jltwp_adminify_remove_pingback' ] );
		}

		// Remove X-Powered-By
		if ( ! empty( $this->options['remove_powered'] ) ) {
			add_action( 'wp', [ $this, 'jltwp_adminify_remove_powered' ] );
		}
	}

	public function jltwp_adminify_remove_powered() {
		if ( function_exists( 'header_remove' ) ) {
			header_remove( 'x-powered-by' );
		}
	}

	public function jltwp_adminify_remove_pingback_head( $headers ) {
		if ( isset( $headers['X-Pingback'] ) ) {
			unset( $headers['X-Pingback'] );
		}

		return $headers;
	}

	public function jltwp_adminify_remove_pingback() {
		if ( function_exists( 'header_remove' ) ) {
			header_remove( 'X-Pingback' );
		}
	}

	// WP JSON API Cleanup
	public function wp_json_api_cleanup() {
		if ( ! empty( $this->options['remove_api_head'] ) ) {
			$this->remove_api_head();
		}
		$this->disable_all_api();

		if ( ! empty( $this->options['remove_api_server'] ) ) {
			$this->remove_api_server();
		}
	}
	public function remove_api_server() {
		remove_action( 'template_redirect', 'rest_output_link_header', 11 );
	}

	public function disable_json_api() {
		// Filters for WP-API version 1.x
		add_filter( 'json_enabled', '__return_false' );
		add_filter( 'json_jsonp_enabled', '__return_false' );

		// Filters for WP-API version 2.x
		// add_filter('rest_enabled', '__return_false');
		add_filter( 'rest_jsonp_enabled', '__return_false' );
	}

	public function disable_all_api() {
		$this->remove_api_head();
		$this->remove_api_server();
		$this->disable_json_api();

		// More REST API Hooks
		remove_action( 'rest_api_init', 'wp_oembed_register_route' ); // Remove the REST API endpoint.
		remove_action( 'wp_head', 'wp_oembed_add_host_js' ); // Remove oEmbed-specific JavaScript from the front-end and back-end.
		add_filter( 'embed_oembed_discover', '__return_false' ); // Turn off oEmbed auto discovery.
		remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 ); // Remove filter oEmbed results.
		add_filter( 'rewrite_rules_array', [ $this, 'adminify_disable_embeds_rewrites' ] ); // Remove all embeds rewrite rules.
	}


	/**
	 * Remove all rewrite rules related to embeds.
	 *
	 * @param array $rules WordPress rewrite rules.
	 * @return array Rewrite rules without embeds rules.
	 */
	public function adminify_disable_embeds_rewrites( $rules ) {
		foreach ( $rules as $rule => $rewrite ) {
			if ( false !== strpos( $rewrite, 'embed=true' ) ) {
				unset( $rules[ $rule ] );
			}
		}

		return $rules;
	}

	public function remove_api_head() {
		remove_action( 'wp_head', 'rest_output_link_wp_head' );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	}


	// Comments Cleanup
	public function comments_cleanup() {
		// Remove Comments Website/URL field
		if ( ! empty( $this->options['remove_comments_url'] ) ) {
			add_filter( 'comment_form_default_fields', [ $this, 'jltwp_adminify_remove_comments_url' ] );
		}

		// Remove comment notes
		if ( ! empty( $this->options['remove_comments_notes'] ) ) {
			add_filter( 'comment_form_defaults', [ $this, 'jltwp_adminify_remove_comments_notes' ] );
		}

		// Remove comment author link
		if ( ! empty( $this->options['remove_comments_author_link'] ) ) {
			add_filter( 'get_comment_author_link', [ $this, 'jltwp_adminify_remove_comments_author_link' ] );
		}

		// Remove comments autolinking
		if ( ! empty( $this->options['remove_comments_autolinking'] ) ) {
			remove_filter( 'comment_text', 'make_clickable', 9 );
		}
	}

	public function jltwp_adminify_remove_comments_author_link( $author_link ) {
		return strip_tags( $author_link );
	}

	public function jltwp_adminify_remove_comments_notes( $defaults ) {
		$defaults['comment_notes_before'] = '';

		return $defaults;
	}

	public function jltwp_adminify_remove_comments_url( $fields ) {
		if ( isset( $fields['url'] ) ) {
			unset( $fields['url'] );
		}

		return $fields;
	}


	// Archives Cleanup
	public function archives_cleanup() {
		// Remove date archives
		if ( ! empty( $this->options['remove_archives_date'] ) ) {
			add_action( 'template_redirect', [ $this, 'jltwp_adminify_remove_archives_date' ] );
		}

		// Remove Author archives
		if ( ! empty( $this->options['remove_archives_author'] ) ) {
			add_action( 'template_redirect', [ $this, 'jltwp_adminify_remove_archives_author' ] );
		}

		// Remove tag archives
		if ( ! empty( $this->options['remove_archives_tag'] ) ) {
			add_action( 'template_redirect', [ $this, 'jltwp_adminify_remove_archives_tag' ] );
		}

		// Remove category archives
		if ( ! empty( $this->options['remove_archives_category'] ) ) {
			add_action( 'template_redirect', [ $this, 'jltwp_adminify_remove_archives_category' ] );
		}

		// Remove archives post formats
		if ( ! empty( $this->options['remove_archives_postformat'] ) ) {
			add_action( 'template_redirect', [ $this, 'jltwp_adminify_remove_archives_postformat' ] );
		}

		// Remove search page
		if ( ! empty( $this->options['remove_archives_search'] ) ) {
			add_action( 'template_redirect', [ $this, 'jltwp_adminify_remove_archives_search' ] );
		}
	}

	public function jltwp_adminify_remove_archives_date() {
		if ( is_date() ) {
			$this->redirect();
		}
	}

	public function jltwp_adminify_remove_archives_author() {
		if ( is_author() ) {
			$this->redirect();
		}
	}

	public function jltwp_adminify_remove_archives_tag() {
		if ( is_tag() ) {
			$this->redirect();
		}
	}

	public function jltwp_adminify_remove_archives_category() {
		if ( is_category() ) {
			$this->redirect();
		}
	}

	public function jltwp_adminify_remove_archives_postformat() {
		if ( is_tax( 'post_format' ) ) {
			$this->redirect();
		}
	}

	public function jltwp_adminify_remove_archives_search() {
		if ( is_search() ) {
			$this->redirect();
		}
	}

	public function attachments_cleanup() {
		// Remove attachments
		if ( ! empty( $this->options['remove_attachment'] ) ) {
			add_action( 'template_redirect', [ $this, 'jltwp_adminify_remove_attachment' ] );
		}
	}

	public function jltwp_adminify_remove_attachment() {
		if ( is_attachment() ) {
			global $post;

			$url = get_the_permalink( $post->post_parent );

			$this->redirect( $url );
		}
	}

	// Redirect function
	public function redirect( $url = false ) {
		if ( $url ) {
			$target = $url;
		} else {
			$target = get_option( 'siteurl' );
		}

		$target = apply_filters( 'wp_adminify_redirect_target', $target );
		$status = apply_filters( 'wp_adminify_redirect_status', $this->redirect_status );

		wp_redirect( $target, $status );
		die();
	}

	// Disable Feeds
	public function redirect_feed() {
		$this->remove_feed();

		add_action( 'do_feed', [ $this, '_redirect_feed' ], 1 );
		add_action( 'do_feed_rdf', [ $this, '_redirect_feed' ], 1 );
		add_action( 'do_feed_rss', [ $this, '_redirect_feed' ], 1 );
		add_action( 'do_feed_rss2', [ $this, '_redirect_feed' ], 1 );
		add_action( 'do_feed_atom', [ $this, '_redirect_feed' ], 1 );
	}

	public function _redirect_feed() {
		$this->redirect();
	}

	// Remove Feed Links
	public function remove_feed() {
		if ( ! empty( $this->options['remove_feed'] ) ) {
			remove_action( 'wp_head', 'feed_links_extra', 3 ); // Remove Every Extra Links to Rss Feeds.
			remove_action( 'wp_head', 'feed_links', 2 );
			remove_action( 'wp_head', 'wc_products_rss_feed' );
		}
	}

	public function remove_admin_footer_version() {
		// Remove WordPress Version except Admin
		if ( ! current_user_can( 'manage_options' ) ) {
			remove_filter( 'update_footer', 'core_update_footer' );
		}
	}


	/* Add Featured Image or Post Thumbnail to RSS Feed */
	public function jltwp_adminify_rss_post_thumbnail( $content ) {
		global $post;
		if ( has_post_thumbnail( $post->ID ) ) {
			$content = '<p>' . get_the_post_thumbnail( $post->ID ) .
				'</p>' . get_the_content();
		}
		return $content;
	}

	// Display Last Updated Date of Your Posts
	public function jltwp_adminify_last_updated_date( $content ) {
		if ( ! is_single() ) {
			return $content;
		}

		$u_time          = get_the_time( 'U' );
		$u_modified_time = get_the_modified_time( 'U' );

		if ( $u_modified_time >= $u_time + 86400 ) {
			$custom_content = sprintf(
				'<div class="wp-adminify-last-updated"><p>%s</p><p>%s %s</p></div>',
				esc_html__( 'Last Updated on', 'adminify' ),
				get_the_modified_time( 'F jS, Y' ),
				get_the_modified_time( 'h:i a' )
			);
			return $custom_content . $content;
		}

		return $content;
	}

	public function jltwp_adminify_last_updated_date_style() {
		echo '<style>.last-updated{ border: 1px dashed red; padding: 5px 10px;}</style>';
	}


	// Remove Default Image Links typeremove_image_link
	public function jltwp_adminify_imagelink() {
		$image_set = get_option( 'image_default_link_type' );

		if ( $image_set !== 'none' ) {
			update_option( 'image_default_link_type', 'none' );
		}
	}


	/* Disable Self Pings */
	public function jltwp_adminify_no_self_ping( &$links ) {
		$home = get_option( 'home' );

		foreach ( $links as $l => $link ) {
			if ( 0 === strpos( $link, $home ) ) {
				unset( $links[ $l ] );
			}
		}
	}


	/** Remove Dashicons from Admin Bar for non logged in users **/
	public function jltwp_adminify_remove_dashicons() {
		$dequeue = ! (bool) apply_filters( 'wp_adminify_skip_removing_dashicons', false );

		if ( is_admin_bar_showing() || is_customize_preview() ) {
			$dequeue = false;
		}

		if ( $dequeue ) {
			wp_dequeue_style( 'dashicons' );
			wp_deregister_style( 'dashicons' );
		}
	}


	/** Control Interval Heartbeat API **/
	public function jltwp_adminify_control_heartbeat( $settings ) {
		$settings['interval'] = 60;
		return $settings;
	}

	/** Remove Query Strings from Scripts/Styles **/
	public function jltwp_adminify_remove_script_version( $src ) {
		$parts = explode( '?ver', $src );

		return $parts[0];
	}

	/* Remove Gravatar Query Strings */
	public function jltwp_adminify_avatar_remove_querystring( $url ) {
		$url_parts = explode( '?', $url );
		return $url_parts[0];
	}

	/** Disable PDF Thumbnails Preview **/
	public function jltwp_adminify_disable_pdf_previews() {
		$fallbacksizes = [];
		return $fallbacksizes;
	}

	/** Secure method for Defer Parsing of JavaScript moving ALL JS from Header to Footer **/
	public function jltwp_adminify_defer_parsing_of_js( $tag, $handle ) {
		$skip = apply_filters( 'wp_adminify_defer_skip', false, $tag, $handle );

		if ( $skip ) {
			return $tag;
		}

		if ( is_admin() ) {
			return $tag;
		}
		if ( strpos( $tag, '/wp-includes/js/jquery/jquery' ) ) {
			return $tag;
		}
		if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE 9.' ) !== false ) {
			return $tag;
		} else {
			return str_replace( ' src', ' defer src', $tag );
		}
	}

	/** Browser Cache Expires & GZIP Compression **/
	public function jltwp_adminify_htaccess() {
		// We get the main WordPress .htaccess filepath.
		$ruta_htaccess = get_home_path() . '.htaccess'; // https://codex.wordpress.org/Function_Reference/get_home_path !

		$lineas   = [];
		$lineas[] = '<IfModule mod_expires.c>';
		$lineas[] = '# Activar caducidad de contenido';
		$lineas[] = 'ExpiresActive On';
		$lineas[] = '# Directiva de caducidad por defecto';
		$lineas[] = 'ExpiresDefault "access plus 1 month"';
		$lineas[] = '# Para el favicon';
		$lineas[] = 'ExpiresByType image/x-icon "access plus 1 year"';
		$lineas[] = '# Imagenes';
		$lineas[] = 'ExpiresByType image/gif "access plus 1 month"';
		$lineas[] = 'ExpiresByType image/png "access plus 1 month"';
		$lineas[] = 'ExpiresByType image/jpg "access plus 1 month"';
		$lineas[] = 'ExpiresByType image/jpeg "access plus 1 month"';
		$lineas[] = '# CSS';
		$lineas[] = 'ExpiresByType text/css "access 1 month"';
		$lineas[] = '# Javascript';
		$lineas[] = 'ExpiresByType application/javascript "access plus 1 year"';
		$lineas[] = '</IfModule>';
		$lineas[] = '<IfModule mod_deflate.c>';
		$lineas[] = '# Activar compresión de contenidos estáticos';
		$lineas[] = 'AddOutputFilterByType DEFLATE text/plain text/html';
		$lineas[] = 'AddOutputFilterByType DEFLATE text/xml application/xml application/xhtml+xml application/xml-dtd';
		$lineas[] = 'AddOutputFilterByType DEFLATE application/rdf+xml application/rss+xml application/atom+xml image/svg+xml';
		$lineas[] = 'AddOutputFilterByType DEFLATE text/css text/javascript application/javascript application/x-javascript';
		$lineas[] = 'AddOutputFilterByType DEFLATE font/otf font/opentype application/font-otf application/x-font-otf';
		$lineas[] = 'AddOutputFilterByType DEFLATE font/ttf font/truetype application/font-ttf application/x-font-ttf';
		$lineas[] = '</IfModule>';

		insert_with_markers( $ruta_htaccess, 'WP Adminify by Jewel Theme', $lineas ); // https://developer.wordpress.org/reference/functions/insert_with_markers/ !
	}

	public function jltwp_adminify_delete_tweaks_htaccess() {
		// We get the mail WordPress .htaccess filepath.
		$ruta_htaccess = get_home_path() . '.htaccess'; // https://codex.wordpress.org/Function_Reference/get_home_path !

		$lineas = [];

		$lineas[] = '# Optimizaciones eliminadas al desactivar el plugin';

		insert_with_markers( $ruta_htaccess, 'WP Adminify by Jewel Theme', $lineas ); // https://developer.wordpress.org/reference/functions/insert_with_markers/ !
	}

	/**
	 * Performance Cleanup
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function performance_cleanup() {
		// Remove jQuery Migrate
		if ( ! empty( $this->options['remove_jquery_migrate'] ) ) {
			add_action( 'wp_default_scripts', [ $this, 'jltwp_adminify_remove_jquery_migrate' ], 9999 );
		}

		// Remove Gutenberg scrips
		if ( ! empty( $this->options['remove_gutenberg_scripts'] ) ) {
			add_action( 'wp_default_scripts', [ $this, 'jltwp_adminify_remove_gutenberg_scripts' ], 9999 );
		}
	}

	public function jltwp_adminify_remove_jquery_migrate( $scripts ) {
		if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
			$script = $scripts->registered['jquery'];
			if ( $script->deps ) { // Check whether the script has any dependencies
				$script->deps = array_diff(
					$script->deps,
					[
						'jquery-migrate',
					]
				);
			}
		}
	}

	// Remove all scripts and styles added by Gutenberg
	public function jltwp_adminify_remove_gutenberg_scripts( $scripts ) {
		add_action( 'wp_enqueue_scripts', [ $this, 'jltwp_adminify_remove_block_scripts_action' ] );
		remove_action( 'enqueue_block_assets', 'wp_enqueue_registered_block_scripts_and_styles' );
	}

	// Dequeue all scripts and styles added by Gutenberg
	public function jltwp_adminify_remove_block_scripts_action() {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wc-block-style' );
	}
}
