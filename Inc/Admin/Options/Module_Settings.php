<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Admin\AdminSettingsModel;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

class Module_Settings extends AdminSettingsModel {

	public $defaults = [];

	public function __construct() {
		$this->module_setting();
	}

	public function module_setting() {
		if ( ! class_exists( 'ADMINIFY' ) ) {
			return;
		}

		\ADMINIFY::createSection(
			$this->prefix,
			[
				'title' => __( 'Module Settings', 'adminify' ),
				'id'    => 'module_settings',
				'icon'  => 'fas fa-toolbox',
			]
		);

		$this->defaults = array_merge( $this->defaults, ( new Module_Folders() )->get_defaults() );
		$this->defaults = array_merge( $this->defaults, ( new Module_PostTypesOrder() )->get_defaults() );
		$this->defaults = array_merge( $this->defaults, ( new Module_Post_Color() )->get_defaults() );
		$this->defaults = array_merge( $this->defaults, ( new Module_QuickCircleMenu() )->get_defaults() );
		$this->defaults = array_merge( $this->defaults, ( new Module_Disable_Comments() )->get_defaults() );
		$this->defaults = array_merge( $this->defaults, ( new Module_Google_PagesSpeed() )->get_defaults() );
		$this->defaults = array_merge( $this->defaults, ( new Module_Duplicate_Post() )->get_defaults() );
		$this->defaults = array_merge( $this->defaults, ( new Module_Activity_Logs() )->get_defaults() );
	}

	protected function get_defaults() {
		return $this->defaults;
	}
}
