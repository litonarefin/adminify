<?php

namespace WPAdminify\Inc\Modules\ActivityLogs\Hooks;

use  WPAdminify\Inc\Modules\ActivityLogs\Inc\Hooks_Base;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Adminify_Logs_Users extends Hooks_Base {

	public function __construct() {
		parent::__construct();
		add_action( 'wp_login', [ $this, 'hooks_wp_login' ], 10, 2 );
		add_action( 'clear_auth_cookie', [ $this, 'hooks_clear_auth_cookie' ] );
		add_action( 'delete_user', [ $this, 'hooks_delete_user' ] );
		add_action( 'user_register', [ $this, 'hooks_user_register' ] );
		add_action( 'profile_update', [ $this, 'hooks_profile_update' ] );
		add_filter( 'wp_login_failed', [ $this, 'hooks_wrong_password' ] );
	}

	public function hooks_wp_login( $user_login, $user ) {
		adminify_activity_logs(
			[
				'action'      => 'logged_in',
				'object_type' => 'User',
				'user_id'     => $user->ID,
				'object_id'   => $user->ID,
				'object_name' => $user->user_nicename,
			]
		);
	}

	public function hooks_user_register( $user_id ) {
		$user = get_user_by( 'id', $user_id );

		adminify_activity_logs(
			[
				'action'      => 'created',
				'object_type' => 'User',
				'object_id'   => $user->ID,
				'object_name' => $user->user_nicename,
			]
		);
	}
	public function hooks_delete_user( $user_id ) {
		$user = get_user_by( 'id', $user_id );

		adminify_activity_logs(
			[
				'action'      => 'deleted',
				'object_type' => 'User',
				'object_id'   => $user->ID,
				'object_name' => $user->user_nicename,
			]
		);
	}

	public function hooks_clear_auth_cookie() {
		$user = wp_get_current_user();

		if ( empty( $user ) || ! $user->exists() ) {
			return;
		}

		adminify_activity_logs(
			[
				'action'      => 'logged_out',
				'object_type' => 'User',
				'user_id'     => $user->ID,
				'object_id'   => $user->ID,
				'object_name' => $user->user_nicename,
			]
		);
	}

	public function hooks_profile_update( $user_id ) {
		$user = get_user_by( 'id', $user_id );

		adminify_activity_logs(
			[
				'action'      => 'updated',
				'object_type' => 'User',
				'object_id'   => $user->ID,
				'object_name' => $user->user_nicename,
			]
		);
	}

	public function hooks_wrong_password( $username ) {
		adminify_activity_logs(
			[
				'action'      => 'wrong_password',
				'object_type' => 'User',
				'user_id'     => 0,
				'object_id'   => 0,
				'object_name' => $username,
			]
		);
	}
}
