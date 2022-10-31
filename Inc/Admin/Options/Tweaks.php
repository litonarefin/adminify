<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;


if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

if ( ! class_exists( 'Tweaks' ) ) {
	class Tweaks extends AdminSettingsModel {

		public $defaults = [];

		public function __construct() {
			$this->tweak_settings();
			parent::__construct( (array) get_option( $this->prefix ) );
		}

		protected function get_defaults() {
			return $this->defaults;
		}

		public function tweak_settings() {
			if ( ! class_exists( 'ADMINIFY' ) ) {
				return;
			}

			// Tweaks Section
			\ADMINIFY::createSection(
				$this->prefix,
				[
					'title' => __( 'Tweaks', 'adminify' ),
					'id'    => 'tweaks_performance',
					'icon'  => 'fas fa-tools',
				]
			);

			$this->defaults = array_merge( $this->defaults, ( new Tweaks_Head() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Tweaks_Feed() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Tweaks_HTTP_Response() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Tweaks_WP_JSON_API() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Tweaks_Comments() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Tweaks_Archives() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Tweaks_Attachments() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Tweaks_Performance() )->get_defaults() );
		}
	}
}
