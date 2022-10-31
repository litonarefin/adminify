<?php
/**
 * Update: Admin general button colors settings key. reduced it from six to two.
 */
function update_admin_general_button_color_keys() {
	 $adminify_options_settings = get_option( '_wpadminify', '' );

	if ( ! empty( $adminify_options_settings ) ) {
		if ( ! empty( $adminify_options_settings['admin_general_button_color'] ) ) {
			$button_colors = $adminify_options_settings['admin_general_button_color'];

			$new_button_colors = [
				'primary_color'   => '#0347FF',
				'secondary_color' => '#fff',
			];

			if ( is_array( $button_colors ) && array_key_exists( 'bg_color', $button_colors ) ) {
				$new_button_colors['primary_color'] = $button_colors['bg_color'];
			}
			if ( is_array( $button_colors ) && array_key_exists( 'text_color', $button_colors ) ) {
				$new_button_colors['secondary_color'] = $button_colors['text_color'];
			}

			$adminify_options_settings['admin_general_button_color'] = $new_button_colors;

			update_option( '_wpadminify', $adminify_options_settings );
		}
	}
}
update_admin_general_button_color_keys();

/**
 * Update: Admin Column Data
 */
function update_admin_columns_data() {
	global $wpdb;

	$column_options = $wpdb->get_results( "SELECT option_name FROM {$wpdb->prefix}options WHERE option_name LIKE ('_adminify_admin_columns_%')", ARRAY_A );

	if ( is_wp_error( $column_options ) || empty( $column_options ) ) {
		return;
	}

	$column_options = wp_list_pluck( $column_options, 'option_name' );

	foreach ( $column_options as $column_option ) {
		if ( strpos( $column_option, '_columns_meta_' ) ) {
			continue;
		}

		$data = get_option( $column_option );

		$data_keys = array_keys( $data );

		$first = array_shift( $data_keys );

		if ( gettype( $first ) === 'string' ) {
			$_data = [
				[
					'group'   => 'Default',
					'options' => $data,
				],
			];

			update_option( $column_option, $_data );
		}
	}
}
update_admin_columns_data();

// update version once migration is completed.
update_option( $this->option_name, $version );
