<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

use WPAdminify\Inc\Utils;

/**
 *
 * Field: text
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'ADMINIFY_Field_text' ) ) {
	class ADMINIFY_Field_text extends ADMINIFY_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {
			$type = ( ! empty( $this->field['attributes']['type'] ) ) ? $this->field['attributes']['type'] : 'text';

			echo Utils::wp_kses_custom($this->field_before());

			echo '<input type="' . esc_attr( $type ) . '" name="' . esc_attr( $this->field_name() ) . '" value="' . esc_attr( $this->value ) . '"' . $this->field_attributes() . ' />';

			echo Utils::wp_kses_custom($this->field_after());
		}

	}
}
