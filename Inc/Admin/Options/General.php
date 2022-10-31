<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Admin\AdminSettingsModel;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class General extends AdminSettingsModel {

	public $defaults = [];
	public function __construct() {
		$this->defaults = array_merge( $this->defaults, ( new General_Settings() )->get_defaults() );
		$this->defaults = array_merge( $this->defaults, ( new General_Layout_Mode() )->get_defaults() );
	}

	protected function get_defaults() {
		return $this->defaults;
	}
}
