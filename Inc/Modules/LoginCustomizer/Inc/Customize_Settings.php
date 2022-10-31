<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer\Inc;

use WPAdminify\Inc\Modules\LoginCustomizer\LoginCustomizer;

use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings\Templates;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings\Logo_Section;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings\Layout_Section;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings\Form_Section;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings\Background_Section;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings\Login_Form_Fields;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings\Button_Section;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings\Others_Section;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings\Google_Fonts;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings\Error_Messages;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings\Custom_CSS_JS;
use WPAdminify\Inc\Modules\LoginCustomizer\Inc\Settings\Credits_Section;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

if ( ! class_exists( 'Customize_Settings' ) ) {

	class Customize_Settings extends Customize_Model {


		public $defaults = [];

		public function __construct() {

			// this should be first so the default values get stored
			$this->login_customizer_options();

			parent::__construct( (array) get_option( $this->prefix ) );
		}

		protected function get_defaults() {
			return $this->defaults;
		}

		public function login_customizer_options() {
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

			$this->defaults = array_merge( $this->defaults, ( new Templates() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Logo_Section() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Background_Section() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Layout_Section() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Form_Section() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Login_Form_Fields() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Button_Section() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Others_Section() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Google_Fonts() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Error_Messages() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Credits_Section() )->get_defaults() );
			$this->defaults = array_merge( $this->defaults, ( new Custom_CSS_JS() )->get_defaults() );
		}
	}
}
