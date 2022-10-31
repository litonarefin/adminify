<?php

namespace WPAdminify\Inc\Modules\ActivityLogs\Inc;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DB_Table {

	public function __construct() {
		// add_action('plugins_loaded', [$this, 'init']);
		$this->init();
	}

	// Activation/Deactivation Hook
	public function init() {
		add_action( 'wp_initialize_site', [ 'WPAdminify\Inc\Modules\ActivityLogs\Inc\DB_Table', 'adminify_new_mu_site_installer' ], 30 );
		add_filter( 'wpmu_drop_tables', [ 'WPAdminify\Inc\Modules\ActivityLogs\Inc\DB_Table', 'adminify_mu_drop_tables' ], 30 );
	}

	public static function adminify_mu_drop_tables( $tables ) {
		global $wpdb;

		$tables['adminify_activity_logs'] = $wpdb->prefix . 'adminify_activity_logs';
		$tables['adminify_page_speed']    = $wpdb->prefix . 'adminify_page_speed';

		return $tables;
	}

	public static function adminify_new_mu_site_installer( $site ) {
		global $wpdb;

		if ( is_plugin_active_for_network( WP_ADMINIFY_BASE ) ) {
			$old_blog_id = $wpdb->blogid;
			switch_to_blog( $site->blog_id );
			self::adminify_logs_create_table();
			switch_to_blog( $old_blog_id );
		}
	}

	public static function activation_hook( $network_wide ) {
		global $wpdb;

		if ( function_exists( 'is_multisite' ) && is_multisite() && $network_wide ) {
			$old_blog_id = $wpdb->blogid;

			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM {$wpdb->blogs}" );
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				self::adminify_logs_create_table();
			}

			switch_to_blog( $old_blog_id );
		} else {
			self::adminify_logs_create_table();
		}
	}

	public static function deactivation_hook( $network_deactivating ) {
		global $wpdb;

		if ( function_exists( 'is_multisite' ) && is_multisite() && $network_deactivating ) {
			$old_blog_id = $wpdb->blogid;

			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM {$wpdb->blogs};" );
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				self::delete_table();
			}

			switch_to_blog( $old_blog_id );
		} else {
			self::delete_table();
		}
	}

	protected static function delete_table() {
		global $wpdb;

		$wpdb->query( "DROP TABLE IF EXISTS `{$wpdb->prefix}adminify_activity_logs`;" );

		$admin_role = get_role( 'administrator' );
		if ( $admin_role && $admin_role->has_cap( 'view_all_adminify_activity_logs' ) ) {
			$admin_role->remove_cap( 'view_all_adminify_activity_logs' );
		}

		delete_option( 'adminify_activity_logs_version' );
	}


	protected static function adminify_logs_create_table() {
		global $wpdb;

		$sql_query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}adminify_activity_logs` (
            `log_id` int(11) NOT NULL AUTO_INCREMENT,
            `user_caps` varchar(70) NOT NULL DEFAULT 'guest',
            `action` varchar(255) NOT NULL,
            `object_type` varchar(255) NOT NULL,
            `object_subtype` varchar(255) NOT NULL DEFAULT '',
            `object_name` varchar(255) NOT NULL,
            `object_id` int(11) NOT NULL DEFAULT '0',
            `user_id` int(11) NOT NULL DEFAULT '0',
            `log_ip` varchar(55) NOT NULL DEFAULT '127.0.0.1',
            `log_time` int(11) NOT NULL DEFAULT '0',
            PRIMARY KEY (`log_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql_query );

		$admin_role = get_role( 'administrator' );
		if ( $admin_role instanceof \WP_Role && ! $admin_role->has_cap( 'view_all_adminify_activity_logs' ) ) {
			$admin_role->add_cap( 'view_all_adminify_activity_logs' );
		}

		update_option( 'adminify_activity_logs_version', WP_ADMINIFY_VER );
	}
}
