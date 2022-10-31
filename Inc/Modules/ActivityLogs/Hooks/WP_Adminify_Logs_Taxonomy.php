<?php

namespace WPAdminify\Inc\Modules\ActivityLogs\Hooks;

use  WPAdminify\Inc\Modules\ActivityLogs\Inc\Hooks_Base;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Adminify_Logs_Taxonomy extends Hooks_Base {

	public function __construct() {
		parent::__construct();
		add_action( 'created_term', [ $this, 'hooks_created_edited_deleted_term' ], 10, 3 );
		add_action( 'edited_term', [ $this, 'hooks_created_edited_deleted_term' ], 10, 3 );
		add_action( 'delete_term', [ $this, 'hooks_created_edited_deleted_term' ], 10, 4 );
	}


	public function hooks_created_edited_deleted_term( $term_id, $tt_id, $taxonomy, $deleted_term = null ) {
		// Make sure do not action nav menu taxonomy.
		if ( 'nav_menu' === $taxonomy ) {
			return;
		}

		if ( 'delete_term' === current_filter() ) {
			$term = $deleted_term;
		} else {
			$term = get_term( $term_id, $taxonomy );
		}

		if ( $term && ! is_wp_error( $term ) ) {
			if ( 'edited_term' === current_filter() ) {
				$action = 'updated';
			} elseif ( 'delete_term' === current_filter() ) {
				$action  = 'deleted';
				$term_id = '';
			} else {
				$action = 'created';
			}

			adminify_activity_logs(
				[
					'action'         => $action,
					'object_type'    => 'Taxonomy',
					'object_subtype' => $taxonomy,
					'object_id'      => $term_id,
					'object_name'    => $term->name,
				]
			);
		}
	}
}
