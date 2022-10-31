<?php

namespace WPAdminify\Inc\Classes;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Helper {


	// Admin Path
	public static function jltwp_adminify_admin_path( $path ) {
		// Get custom filter path
		if ( has_filter( 'jltwp_adminify_admin_path' ) ) {
			return apply_filters( 'jltwp_adminify_admin_path', $path );
		}

		// Get plugin path
		return plugins_url( $path, __DIR__ );
	}

	/**
	 * Get the editor/ builder of the given post.
	 *
	 * @param int $post_id ID of the post being checked.
	 * @return string The content editor name.
	 */
	public static function get_content_editor( $post_id ) {
		$content_editor = 'default';
		$content_editor = apply_filters( 'udb_content_editor', $content_editor, $post_id );

		return $content_editor;
	}

	/**
	 * Sanitize Checkbox.
	 *
	 * @param string|bool $checked Customizer option.
	 */
	public function sanitize_checkbox( $checked ) {
		return ( ( isset( $checked ) && true === $checked ) ? true : false );
	}


	/**
	 * Image sanitization callback.
	 *
	 * Checks the image's file extension and mime type against a whitelist. If they're allowed,
	 * send back the filename, otherwise, return the setting default.
	 *
	 * - Sanitization: image file extension
	 * - Control: text, WP_Customize_Image_Control
	 *
	 * @see wp_check_filetype() https://developer.wordpress.org/reference/functions/wp_check_filetype/
	 *
	 * @version 1.2.2
	 *
	 * @param string               $image   Image filename.
	 * @param WP_Customize_Setting $setting Setting instance.
	 *
	 * @return string The image filename if the extension is allowed; otherwise, the setting default.
	 */
	public static function sanitize_image( $image, $setting ) {

		/**
		 * Array of valid image file types.
		 *
		 * The array includes image mime types that are included in wp_get_mime_types()
		 */
		$mimes = [
			'jpg|jpeg|jpe' => 'image/jpeg',
			'gif'          => 'image/gif',
			'png'          => 'image/png',
			'bmp'          => 'image/bmp',
			'tif|tiff'     => 'image/tiff',
			'ico'          => 'image/x-icon',
		];

		// Allowed svg mime type in version 1.2.2.
		$allowed_mime   = get_allowed_mime_types();
		$svg_mime_check = isset( $allowed_mime['svg'] ) ? true : false;

		if ( $svg_mime_check ) {
			$allow_mime = [ 'svg' => 'image/svg+xml' ];
			$mimes      = array_merge( $mimes, $allow_mime );
		}

		// Return an array with file extension and mime_type.
		$file = wp_check_filetype( $image, $mimes );

		// If $image has a valid mime_type, return it; otherwise, return the default.
		return esc_url_raw( ( $file['ext'] ? $image : $setting->default ) );
	}
}
