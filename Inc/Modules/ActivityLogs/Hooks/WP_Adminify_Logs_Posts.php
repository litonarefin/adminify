<?php

namespace WPAdminify\Inc\Modules\ActivityLogs\Hooks;

use  WPAdminify\Inc\Modules\ActivityLogs\Inc\Hooks_Base;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Adminify_Logs_Posts extends Hooks_Base {

	public function __construct() {
		parent::__construct();
		add_action( 'transition_post_status', [ $this, 'hooks_transition_post_status' ], 10, 3 );
		add_action( 'delete_post', [ $this, 'hooks_delete_post' ] );
	}


	protected function _draft_or_post_title( $post = 0 ) {
		$title = esc_html( get_the_title( $post ) );

		if ( empty( $title ) ) {
			$title = __( '(no title)', 'adminify' );
		}

		return $title;
	}

	public function hooks_transition_post_status( $new_status, $old_status, $post ) {
		if ( 'auto-draft' === $old_status && ( 'auto-draft' !== $new_status && 'inherit' !== $new_status ) ) {
			// page created
			$action = 'created';
		} elseif ( 'auto-draft' === $new_status || ( 'new' === $old_status && 'inherit' === $new_status ) ) {
			// nvm.. ignore it.
			return;
		} elseif ( 'trash' === $new_status ) {
			// page was deleted.
			$action = 'trashed';
		} elseif ( 'trash' === $old_status ) {
			$action = 'restored';
		} else {
			// page updated. I guess.
			$action = 'updated';
		}

		if ( wp_is_post_revision( $post->ID ) ) {
			return;
		}

		// Skip for menu items.
		if ( 'nav_menu_item' === get_post_type( $post->ID ) ) {
			return;
		}

		adminify_activity_logs(
			[
				'action'         => $action,
				'object_type'    => 'Post',
				'object_subtype' => $post->post_type,
				'object_id'      => $post->ID,
				'object_name'    => $this->_draft_or_post_title( $post->ID ),
			]
		);
	}

	public function hooks_delete_post( $post_id ) {
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		$post = get_post( $post_id );

		if ( ! $post ) {
			return;
		}

		if ( in_array( $post->post_status, [ 'auto-draft', 'inherit' ] ) ) {
			return;
		}

		// Skip for menu items.
		if ( 'nav_menu_item' === get_post_type( $post->ID ) ) {
			return;
		}

		adminify_activity_logs(
			[
				'action'         => 'deleted',
				'object_type'    => 'Post',
				'object_subtype' => $post->post_type,
				'object_id'      => $post->ID,
				'object_name'    => $this->_draft_or_post_title( $post->ID ),
			]
		);
	}
}
