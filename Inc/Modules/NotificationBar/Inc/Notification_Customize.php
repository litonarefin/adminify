<?php

namespace WPAdminify\Inc\Modules\NotificationBar\Inc;

use WPAdminify\Inc\Modules\NotificationBar\Inc\Settings\General;
use WPAdminify\Inc\Modules\NotificationBar\Inc\Settings\Content;
use WPAdminify\Inc\Modules\NotificationBar\Inc\Settings\Style;
use WPAdminify\Inc\Modules\NotificationBar\Inc\Settings\Display;

/**
 * WP Adminify
 * Module: Notification Bar Customization
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

if ( ! class_exists( 'Notification_Customize' ) ) {
	class Notification_Customize extends NotificationBarModel {

		public $defaults = [];

		public function __construct() {
			// this should be first so the default values get stored
			$this->notification_bar_options();
			parent::__construct( (array) get_option( $this->prefix ) );
		}


		protected function get_defaults() {
			return $this->defaults;
		}

		public function notification_bar_options() {
			if ( ! class_exists( 'ADMINIFY' ) ) {
				return;
			}
			// Create customize options
			\ADMINIFY::createCustomizeOptions(
				$this->prefix,
				[
					'database'        => 'option',
					'transport'       => 'postMessage',
					'capability'      => 'manage_options',
					'save_defaults'   => true,
					'enqueue_webfont' => true,
					'async_webfont'   => false,
					'output_css'      => true,
				]
			);

			$this->defaults = array_merge( $this->defaults, ( new General() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Content() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Style() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Display() )->get_defaults() );
		}
	}
}
