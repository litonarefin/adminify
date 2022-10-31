<?php

namespace WPAdminify\Inc\Modules\ActivityLogs\Hooks;

use  WPAdminify\Inc\Modules\ActivityLogs\Inc\Hooks_Base;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Adminify_Logs_Comments extends Hooks_Base {

	public function __construct() {
		parent::__construct();
		add_action( 'wp_insert_comment', [ $this, 'handle_comment_log' ], 10, 2 );
		add_action( 'edit_comment', [ $this, 'handle_comment_log' ] );
		add_action( 'trash_comment', [ $this, 'handle_comment_log' ] );
		add_action( 'untrash_comment', [ $this, 'handle_comment_log' ] );
		add_action( 'spam_comment', [ $this, 'handle_comment_log' ] );
		add_action( 'unspam_comment', [ $this, 'handle_comment_log' ] );
		add_action( 'delete_comment', [ $this, 'handle_comment_log' ] );
		add_action( 'transition_comment_status', [ $this, 'hooks_transition_comment_status' ], 10, 3 );
	}

	protected function _add_comment_log( $id, $action, $comment = null ) {
		if ( is_null( $comment ) ) {
			$comment = get_comment( $id );
		}

		adminify_activity_logs(
			[
				'action'         => $action,
				'object_type'    => 'Comments',
				'object_subtype' => get_post_type( $comment->comment_post_ID ),
				'object_name'    => esc_html( get_the_title( $comment->comment_post_ID ) ),
				'object_id'      => $id,
			]
		);
	}

	public function handle_comment_log( $comment_ID, $comment = null ) {
		if ( is_null( $comment ) ) {
			$comment = get_comment( $comment_ID );
		}

		$action = 'created';
		switch ( current_filter() ) {
			case 'wp_insert_comment':
				$action = 1 === (int) $comment->comment_approved ? 'approved' : 'pending';
				break;

			case 'edit_comment':
				$action = 'updated';
				break;

			case 'delete_comment':
				$action = 'deleted';
				break;

			case 'trash_comment':
				$action = 'trashed';
				break;

			case 'untrash_comment':
				$action = 'untrashed';
				break;

			case 'spam_comment':
				$action = 'spammed';
				break;

			case 'unspam_comment':
				$action = 'unspammed';
				break;
		}

		$this->_add_comment_log( $comment_ID, $action, $comment );
	}

	public function hooks_transition_comment_status( $new_status, $old_status, $comment ) {
		$this->_add_comment_log( $comment->comment_ID, $new_status, $comment );
	}
}
