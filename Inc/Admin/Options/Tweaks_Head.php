<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class Tweaks_Head extends AdminSettingsModel {

	public function __construct() {
		$this->tweaks_head_settings();
	}

	public function get_defaults() {
		return [
			'generator_wp_version'             => false,
			'remove_wc_generator'              => false,
			'remove_revslider_generator'       => false,
			'remove_visual_composer_generator' => false,
			'remove_wpml_generator'            => false,
			'remove_yoast_generator'           => false,
			'remove_version_strings'           => false,
			'remove_dashicons'                 => false,
			'remove_link_url'                  => false,
			'remove_wlwmanifest'               => false,
			'remove_dns_prefetch'              => false,
			'remove_rsd'                       => false,
			'remove_shortlink'                 => false,
			'remove_canonical'                 => false,
			'remove_emoji'                     => false,
			'remove_prev_next'                 => false,
			'remove_recentcomments'            => false,
			'disable_xmlrpc'                   => false,
		];
	}


	/**
	 * Tweaks: Head Fields
	 *
	 * @return void
	 */
	public function tweaks_head_fields( &$head_fields ) {
		$head_fields[] = [
			'type'    => 'subheading',
			'content' => Utils::adminfiy_help_urls(
				__( 'Remove unncessary links, scripts and styles from head section.', 'adminify' ),
				'https://wpadminify.com/kb/wp-adminify-tweaks/',
				'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
				'https://www.facebook.com/groups/jeweltheme',
				'https://wpadminify.com/support/'
			),
		];

		$head_fields[] = [
			'id'         => 'generator_wp_version',
			'type'       => 'switcher',
			'title'      => __( 'Remove Generator Version', 'adminify' ),
			'subtitle'   => __( 'Remove WordPress Generator WordPress Version from Frontend and RSS Feed', 'adminify' ),
			'label'      => __( 'This meta tag just shows your WordPress version. You can remove it for security reasons and keep your head section clean.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
			'default'    => $this->get_default_field( 'generator_wp_version' ),
		];

		if ( Utils::is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			$head_fields[] = [
				'id'         => 'remove_wc_generator',
				'type'       => 'switcher',
				'title'      => __( 'Remove WooCommerce Generator Meta', 'adminify' ),
				'subtitle'   => __( 'Remove &lt;meta name=&quot;generator&quot; content=&quot;WooCommerce x.x.x&quot; /&gt; from head section', 'adminify' ),
				'text_on'    => __( 'Yes', 'adminify' ),
				'text_off'   => __( 'No', 'adminify' ),
				'text_width' => 80,
			];
		}

		if ( Utils::is_plugin_active( 'revslider/revslider.php' ) ) {
			$head_fields[] = [
				'id'         => 'remove_revslider_generator',
				'type'       => 'switcher',
				'title'      => __( 'Remove Revolution Slider Generator Meta', 'adminify' ),
				'subtitle'   => __( 'Remove &lt;meta name=&quot;generator&quot; content=&quot;Revolution Slider x.x.x&quot; /&gt; from head section', 'adminify' ),
				'text_on'    => __( 'Yes', 'adminify' ),
				'text_off'   => __( 'No', 'adminify' ),
				'text_width' => 80,
			];
		}

		if ( Utils::is_plugin_active( 'js_composer/js_composer.php' ) ) {
			$head_fields[] = [
				'id'         => 'remove_visual_composer_generator',
				'type'       => 'switcher',
				'title'      => __( 'Remove Visual Composer Generator Meta', 'adminify' ),
				'subtitle'   => __( 'Remove &lt;meta name=&quot;generator&quot; content=&quot;Visual Composer x.x.x&quot; /&gt; from head section', 'adminify' ),
				'text_on'    => __( 'Yes', 'adminify' ),
				'text_off'   => __( 'No', 'adminify' ),
				'text_width' => 80,
			];
		}

		if ( Utils::is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
			$head_fields[] = [
				'id'         => 'remove_wpml_generator',
				'type'       => 'switcher',
				'title'      => __( 'Remove WPML Generator Meta', 'adminify' ),
				'subtitle'   => __( 'Remove &lt;meta name=&quot;generator&quot; content=&quot;Visual Composer x.x.x&quot; /&gt; from head section', 'adminify' ),
				'text_on'    => __( 'Yes', 'adminify' ),
				'text_off'   => __( 'No', 'adminify' ),
				'text_width' => 80,
			];
		}

		if ( Utils::is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
			$head_fields[] = [
				'id'         => 'remove_yoast_generator',
				'type'       => 'switcher',
				'title'      => __( 'Remove All Yoast HTML Comments', 'adminify' ),
				'subtitle'   => __( 'Remove Yoast HTML Comments', 'adminify' ),
				'label'      => __( 'Remove message - "This site is optimized with the Yoast WordPress SEO plugin" generated by Yoast', 'adminify' ),
				'text_on'    => __( 'Yes', 'adminify' ),
				'text_off'   => __( 'No', 'adminify' ),
				'text_width' => 80,
			];
		}

		$head_fields[] = [
			'id'         => 'remove_version_strings',
			'type'       => 'switcher',
			'title'      => __( 'Remove Version from Style and Script', 'adminify' ),
			'subtitle'   => __( 'Remove Version Number from Styles/Scripts', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
		];

		$head_fields[] = [
			'id'         => 'remove_dashicons',
			'type'       => 'switcher',
			'title'      => __( 'Remove Dashicons', 'adminify' ),
			'subtitle'   => __( 'Remove Dashicons from Admin Bar for non logged in users', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
		];

		$head_fields[] = [
			'id'         => 'remove_link_url',
			'type'       => 'switcher',
			'title'      => __( 'Remove Index Link', 'adminify' ),
			'subtitle'   => esc_html__( 'Remove "<link rel=\'index\'..." from head section', 'adminify' ),
			'label'      => 'Remove Homepage Index Link',
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
		];

		$head_fields[] = [
			'id'         => 'remove_wlwmanifest',
			'type'       => 'switcher',
			'title'      => __( 'Remove WLW Manifest Link', 'adminify' ),
			'subtitle'   => esc_html__( 'Remove "<link rel=\'wlwmanifest\'..." from head section', 'adminify' ),
			'label'      => 'WLW Manifest Link adds support for Windows Live Writer app. If you are not using this app you can remove this link.',
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
		];

		$head_fields[] = [
			'id'         => 'remove_dns_prefetch',
			'type'       => 'switcher',
			'title'      => __( 'Remove WP.org DNS Prefetch', 'adminify' ),
			'subtitle'   => esc_html__( 'Remove &lt;link rel=&quot;dns-prefetch&quot; href=&quot;http://www.yourdomain.com/&quot;&gt; from head section', 'adminify' ),
			'label'      => __( 'If all of your resources has the same domain yo can disable forcing DNS lookup of specific hostnames', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
		];

		$head_fields[] = [
			'id'         => 'remove_rsd',
			'type'       => 'switcher',
			'title'      => __( 'Remove RSD Link (EditURI Link)', 'adminify' ),
			'subtitle'   => esc_html__( 'Remove "<link rel=\'EditURI\'..." from head section', 'adminify' ),
			'label'      => __( 'RSD (Real Simple Discovery) is the mechanism used by XML-RPC clients. Also this mechanism can be used by spammers. If do not use this clients with your site, you can remove it.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
		];

		$head_fields[] = [
			'id'         => 'remove_shortlink',
			'type'       => 'switcher',
			'title'      => __( 'Remove Shortlink', 'adminify' ),
			'subtitle'   => esc_html__( 'Remove "<link rel=\'shortlink\'..." from head section', 'adminify' ),
			'label'      => __( 'This meta tag just shows short link (not canonical link) to your posts. You can remove it.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
		];

		$head_fields[] = [
			'id'         => 'remove_canonical',
			'type'       => 'switcher',
			'title'      => __( 'Remove Canonical URL', 'adminify' ),
			'subtitle'   => esc_html__( 'Remove &lt;link rel="canonical" href="http://www.site.com/some-url" /&gt; from head section', 'adminify' ),
			'label'      => 'Remove Canonical URL. Details: https://support.google.com/webmasters/answer/139066?hl=en',
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
		];

		$head_fields[] = [
			'id'         => 'remove_emoji',
			'type'       => 'switcher',
			'title'      => __( 'Remove Emoji Styles and Scripts', 'adminify' ),
			'subtitle'   => __( 'Remove Emoji styles and scripts from head section', 'adminify' ),
			'label'      => __( 'If you are not using emoji smiles on your site you can disable this feature and keep your head section clean.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
		];

		$head_fields[] = [
			'id'         => 'remove_prev_next',
			'type'       => 'switcher',
			'title'      => __( 'Remove Prev/Next Links', 'adminify' ),
			'subtitle'   => esc_html__( 'Remove "<link rel=\'prev\'..." and "<link rel=\'next\'..." from head section', 'adminify' ),
			'label'      => 'This is links to the next and previous post that actually not used. You can remove it and keep your head section clean.',
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
		];

		$head_fields[] = [
			'id'         => 'remove_recentcomments',
			'type'       => 'switcher',
			'title'      => __( 'Remove Hardcoded Styles for Recent Comments', 'adminify' ),
			'subtitle'   => __( 'Remove styles for ".recentcomments a" from head section', 'adminify' ),
			'label'      => __( 'This is hard coded CSS for recent comments widget. You can remove it and keep your head section clean.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
		];

		$head_fields[] = [
			'id'         => 'disable_xmlrpc',
			'type'       => 'switcher',
			'title'      => __( 'Disable XML-RPC', 'adminify' ),
			'label'      => __( 'Use for WordPress APP, Trackbacks and pingbacks and JetPack Plugin.', 'adminify' ),
			'text_on'    => __( 'Yes', 'adminify' ),
			'text_off'   => __( 'No', 'adminify' ),
			'text_width' => 80,
		];
	}

	public function tweaks_head_settings() {
		if ( ! class_exists( 'ADMINIFY' ) ) {
			return;
		}

		$head_fields = [];
		$this->tweaks_head_fields( $head_fields );

		\ADMINIFY::createSection(
			$this->prefix,
			[
				'title'  => __( 'Head', 'adminify' ),
				'parent' => 'tweaks_performance',
				'icon'   => 'fas fa-newspaper',
				'class'  => 'wp-adminify-two-columns aminify-title-width-40',
				'fields' => $head_fields,
			]
		);
	}
}
