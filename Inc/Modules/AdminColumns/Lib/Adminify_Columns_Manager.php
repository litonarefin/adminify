<?php

namespace WPAdminify\Inc\Modules\AdminColumns\Lib;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Adminify_Columns_Manager' ) ) {
	return;
}


class Adminify_Columns_Manager {

	public function __construct() {
		require_once 'Inc/Carbon_Admin_Columns_Manager.php';

		require_once 'Inc/Carbon_Admin_Columns_Manager_Post.php';

		require_once 'Inc/Carbon_Admin_Columns_Manager_Taxonomy.php';

		require_once 'Inc/Carbon_Admin_Columns_Manager_User.php';

		require_once 'Inc/Carbon_Admin_Column.php';
	}
}
