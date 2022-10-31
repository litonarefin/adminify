<?php

/**
 * Templates designed by WP Adminify
 *
 * @since  1.0.0
 */
$selected_template = $this->options['templates'];
if ( empty( $selected_template ) ) {
	return include_once plugin_dir_path( __FILE__ ) . 'templates/template-01.php';
} else {
	do_action( 'wp_adminify_add_templates', $selected_template );
}
