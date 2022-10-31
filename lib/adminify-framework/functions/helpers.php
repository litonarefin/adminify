<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Array search key & value
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'adminify_array_search' ) ) {
	function adminify_array_search( $array, $key, $value ) {
		$results = [];

		if ( is_array( $array ) ) {
			if ( isset( $array[ $key ] ) && $array[ $key ] == $value ) {
				$results[] = $array;
			}

			foreach ( $array as $sub_array ) {
				$results = array_merge( $results, adminify_array_search( $sub_array, $key, $value ) );
			}
		}

		return $results;
	}
}

/**
 *
 * Between Microtime
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'adminify_timeout' ) ) {
	function adminify_timeout( $timenow, $starttime, $timeout = 30 ) {
		return ( ( $timenow - $starttime ) < $timeout ) ? true : false;
	}
}

/**
 *
 * Check for wp editor api
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'adminify_wp_editor_api' ) ) {
	function adminify_wp_editor_api() {
		global $wp_version;
		return version_compare( $wp_version, '4.8', '>=' );
	}
}
