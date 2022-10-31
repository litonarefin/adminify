<?php

namespace WPAdminify\Inc\Modules\ActivityLogs\Hooks;

use  WPAdminify\Inc\Modules\ActivityLogs\Inc\Hooks_Base;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Adminify_Logs_Menu extends Hooks_Base {

	public function __construct() {
		parent::__construct();
		add_action( 'wp_update_nav_menu', [ $this, 'hooks_menu_created_or_updated' ] );
		add_action( 'wp_create_nav_menu', [ $this, 'hooks_menu_created_or_updated' ] );
		add_action( 'delete_nav_menu', [ $this, 'hooks_menu_deleted' ], 10, 3 );
	}


	public function hooks_menu_created_or_updated( $nav_menu_selected_id ) {
		if ( $menu_object = wp_get_nav_menu_object( $nav_menu_selected_id ) ) {
			if ( 'wp_create_nav_menu' === current_filter() ) {
				$action = 'created';
			} else {
				$action = 'updated';
			}

			adminify_activity_logs(
				[
					'action'      => $action,
					'object_type' => 'Menu',
					'object_name' => $menu_object->name,
				]
			);
		}
	}

	public function hooks_menu_deleted( $term, $tt_id, $deleted_term ) {
		adminify_activity_logs(
			[
				'action'      => 'deleted',
				'object_type' => 'Menu',
				'object_name' => $deleted_term->name,
			]
		);
	}
}
