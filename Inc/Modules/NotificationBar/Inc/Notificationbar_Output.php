<?php

namespace WPAdminify\Inc\Modules\NotificationBar\Inc;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

/**
 * WP Adminify
 * Module: Notification Bar Customization
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class Notificationbar_Output {

	public $url;
	public $prefix = '_adminify_notification_bar';
	public $options;

	public function __construct() {
		$this->url     = WP_ADMINIFY_URL . 'Inc/Modules/NotificationBar';
		$this->options = ( new Notification_Customize() )->get();

		add_filter( 'body_class', [ $this, 'add_body_class' ] );

		// Add notification to the site.
		add_action( 'wp', [ $this, 'adminify_notification_bar' ] );
	}


	/**
	 * Add Body Class for Notification bar
	 *
	 * @return void
	 */
	public function add_body_class( $classes ) {
		if ( ! empty( $this->options['show_notif_bar'] ) ) {
			$classes[] = 'wp-adminify-notification-bar';
		}

		return $classes;
	}


	public function jltwp_adminify_notif_bar_devices_display() {
		$isdevicesDisplay = $this->options['display_devices'];
		if ( $isdevicesDisplay == 'all_devices' ) {
			return true;
		}
		if ( $isdevicesDisplay == 'desktop' && ! wp_is_mobile() ) {
			return true;
		}
		if ( $isdevicesDisplay == 'mobile' && wp_is_mobile() ) {
			return true;
		}
		return false;
	}


	/**
	 * Add Notification Bar to site
	 */
	public function adminify_notification_bar() {
		if ( is_customize_preview() || ! empty( $this->options['show_notif_bar'] ) ) {
			$priority = apply_filters( 'wp_adminify_notification_bar_priority', 10 );
			add_filter( 'wp_adminify_notification_bar_message', 'wp_kses_post' );
			add_filter( 'wp_adminify_notification_bar_message', 'shortcode_unautop' );
			add_filter( 'wp_adminify_notification_bar_message', 'do_shortcode', 11 );

			// Enqueue Notification Bar Script
			add_action( 'wp_enqueue_scripts', [ $this, 'adminify_enqueue_scripts' ] );
		}
	}


	// Enqueue Notification Bar Script
	public function adminify_enqueue_scripts() {
		wp_enqueue_script( 'wp-adminify-notification-bar', $this->url . '/assets/js/wp-adminify-notification-bar.min.js', [ 'jquery' ], WP_ADMINIFY_VER, true );

		$notification_content = ! empty( $this->options['notif_bar_content_section']['notif_bar_content'] ) ? $this->options['notif_bar_content_section']['notif_bar_content'] : '';
		$text_color           = ! empty( $this->options['text_color'] ) ? sanitize_hex_color( $this->options['text_color'] ) : '#fff';

		$notif_bar_typography  = $this->options['typography_sets'];
		$notif_bar_color       = ! empty( $notif_bar_typography['color'] ) ? $notif_bar_typography['color'] : '';
		$notif_bar_unit        = ! empty( $notif_bar_typography['unit'] ) ? $notif_bar_typography['unit'] : '';
		$notif_bar_font_size   = ! empty( $notif_bar_typography['font-size'] ) ? $notif_bar_typography['font-size'] . $notif_bar_unit : '12px';
		$notif_bar_font_family = ! empty( $notif_bar_typography['font-family'] ) ? $notif_bar_typography['font-family'] : '';
		$notif_bar_font_style  = ! empty( $notif_bar_typography['font-style'] ) ? $notif_bar_typography['font-style'] : 'inherit';

		$notice_bg_color = ! empty( $this->options['bg_color'] ) ? sanitize_hex_color( $this->options['bg_color'] ) : '#000';

		$show_notif_bar_btn = ! empty( $this->options['notif_bar_content_section']['show_notif_bar_btn'] ) ? true : false;
		$btn_url            = ! empty( $this->options['notif_bar_content_section']['notif_btn_url']['url'] ) ? $this->options['notif_bar_content_section']['notif_btn_url']['url'] : '';
		$btn_text           = ! empty( $this->options['notif_bar_content_section']['notif_btn'] ) ? $this->options['notif_bar_content_section']['notif_btn'] : '';
		$btn_target         = ! empty( $this->options['notif_bar_content_section']['notif_btn_url']['target'] ) ? $this->options['notif_bar_content_section']['notif_btn_url']['target'] : '';
		$btn_text_color     = ! empty( $this->options['btn_text_color'] ) ? $this->options['btn_text_color'] : '#fff';
		$btn_bg_color       = ! empty( $this->options['btn_color'] ) ? $this->options['btn_color'] : '#d35400';
		$link_color         = ! empty( $this->options['link_color'] ) ? $this->options['link_color'] : '#009fdd';
		$link_bg_color      = ! empty( $this->options['link_bg_color'] ) ? $this->options['link_bg_color'] : '';

		$display_position = ! empty( $this->options['display_position'] ) ? $this->options['display_position'] : 'bottom';
		$expires_in       = ! empty( $this->options['expires_in'] ) ? $this->options['expires_in'] : 30;
		$close_btn_text   = ! empty( $this->options['close_btn_text'] ) ? $this->options['close_btn_text'] : 'bottom';

		wp_add_inline_script(
			'wp-adminify-notification-bar',
			'new cookieNoticeJS(' . json_encode(
				[
					'messageLocales'       => [
						'en' => $notification_content,
					],

					// Localizations of the dismiss button text
					'buttonLocales'        => [
						// 'en' => $close_btn_text
						'en' => $close_btn_text,
					],

					// Position for the cookie-notifier (default=bottom)
					'cookieNoticePosition' => $display_position,
					'closeButtonEnabled'   => true,
					// Shows the "learn more button (default=false)
					'learnMoreLinkEnabled' => $show_notif_bar_btn,

					// The href of the learn more link must be applied if (learnMoreLinkEnabled=true)
					'learnMoreLinkHref'    => $btn_url,

					// Text for optional learn more button
					'learnMoreLinkText'    => [
						'en' => $btn_text,
					],

					// The message will be shown again in X days
					'expiresIn'            => $expires_in,

					// Specify a custom font family and size in pixels
					'fontFamily'           => $notif_bar_font_family,
					'fontSize'             => $notif_bar_font_size,

					// Dismiss button background color
					'buttonBgColor'        => $btn_bg_color,

					// Dismiss button text color
					'buttonTextColor'      => $btn_text_color,

					// Notice background color
					'noticeBgColor'        => $notice_bg_color,

					// Notice text color
					'noticeTextColor'      => $text_color,

					// the learnMoreLink color (default='#009fdd')
					'linkColor'            => $link_color,

					// The target of the learn more link (default='', or '_blank')
					'linkTarget'           => $btn_target,

				]
			) . ');',
			'after'
		);

		if ( $inline_css = $this->inline_css() ) {
			wp_add_inline_style( 'wp-adminify-notification-bar', $inline_css );
		}
	}


	/**
	 * Notification Bar output CSS.
	 *
	 * @access public
	 */
	public function inline_css() {
		$output_css = $main_css = '';

		$background_color = ! empty( $this->options['bg_color'] ) ? $this->options['bg_color'] : '#000';
		if ( $background_color ) {
			$main_css .= 'background:' . sanitize_hex_color( $background_color ) . ';';
		}

		if ( $text_color = $this->options['text_color'] ) {
			$main_css .= 'color:' . sanitize_hex_color( $text_color ) . ';';
		}

		if ( $font_size = isset( $this->options['typography']['font-size'] ) && $this->options['typography']['font-size'] ) {
			$font_size_escaped = is_numeric( $font_size ) ? absint( $font_size ) . 'px' : esc_attr( $font_size );
			$main_css         .= 'font-size:' . $font_size_escaped . ';';
		}

		if ( $main_css ) {
			$output_css .= '#wp-adminify-notification-bar{' . $main_css . '}';
		}

		$output_css .= '.logged-in.admin-bar #cookieNotice{ top:32px;}';

		return $output_css;
	}
}
