<?php

namespace WPAdminify\Inc\Modules\MenuEditor;

use WPAdminify\Inc\Base_Model;

class MenuEditorOptions extends MenuEditorModel {

	public function __construct() {
		// this should be first so the default values get stored
		parent::__construct( (array) get_option( $this->prefix ) );
	}
}
