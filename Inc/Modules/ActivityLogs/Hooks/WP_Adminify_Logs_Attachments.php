<?php

namespace WPAdminify\Inc\Modules\ActivityLogs\Hooks;

use  WPAdminify\Inc\Modules\ActivityLogs\Inc\Hooks_Base;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Adminify_Logs_Attachments extends Hooks_Base {

	public function __construct() {
		add_action( 'add_attachment', [ $this, 'hooks_add_attachment' ] );
		add_action( 'edit_attachment', [ $this, 'hooks_edit_attachment' ] );
		add_action( 'delete_attachment', [ $this, 'hooks_delete_attachment' ] );

		parent::__construct();
	}

	protected function _add_log_attachment( $action, $attachment_id ) {
		$post = get_post( $attachment_id );

		adminify_activity_logs(
			[
				'action'         => $action,
				'object_type'    => 'Attachment',
				'object_subtype' => $post->post_type,
				'object_id'      => $attachment_id,
				'object_name'    => esc_html( get_the_title( $post->ID ) ),
			]
		);
	}

	public function hooks_delete_attachment( $attachment_id ) {
		$this->_add_log_attachment( 'deleted', $attachment_id );
	}

	public function hooks_edit_attachment( $attachment_id ) {
		$this->_add_log_attachment( 'updated', $attachment_id );
	}

	public function hooks_add_attachment( $attachment_id ) {
		$this->_add_log_attachment( 'added', $attachment_id );
	}
}
