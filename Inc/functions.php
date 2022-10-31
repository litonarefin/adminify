<?php

use WPAdminify\Inc\Modules\ActivityLogs\ActivityLogs;

/**
 * Check given value empty or not
 *
 * @param [type] $value
 *
 * @return void
 */
function check_is_empty( $value, $default = '' ) {
	$value = ! empty( esc_attr( $value ) ) ? $value : $default;
	return $value;
}


// WP Adminify function for get an option
if ( ! function_exists( 'jltwp_adminify_get_option' ) ) {
	function jltwp_adminify_get_option( $option = '', $default = null ) {
		$options = [];
		// if (is_multisite() && is_site_wide('wp-adminify/wp-adminify.php')) {
		$options = (array) \WPAdminify\Inc\Admin\AdminSettings::get_instance()->get();
		// }
		return ( isset( $options[ $option ] ) ) ? $options[ $option ] : $default;
	}
}

function is_site_wide( $plugin ) {
	if ( ! is_multisite() ) {
		return false;
	}

	$plugins = get_site_option( 'active_sitewide_plugins' );
	if ( isset( $plugins[ $plugin ] ) ) {
		return true;
	}

	return false;
}


function adminify_activity_logs( $args = [] ) {
	$adminify_activity_logs = ActivityLogs::get_instance();
	$adminify_activity_logs->api->insert( $args );
}
