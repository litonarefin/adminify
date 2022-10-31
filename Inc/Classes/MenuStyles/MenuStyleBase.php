<?php

namespace WPAdminify\Inc\Classes\MenuStyles;

use WPAdminify\Inc\Admin\AdminSettings;
use WPAdminify\Inc\Admin\AdminSettingsModel;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MenuStyleBase extends AdminSettingsModel {

	protected $url;

	public function __construct() {
		$this->url     = WP_ADMINIFY_URL . 'inc/classes/MenuStyles';
		$this->options = (array) AdminSettings::get_instance()->get();
	}
}
