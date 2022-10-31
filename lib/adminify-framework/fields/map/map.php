<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

use WPAdminify\Inc\Utils;

/**
 *
 * Field: map
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'ADMINIFY_Field_map' ) ) {
	class ADMINIFY_Field_map extends ADMINIFY_Fields {

		public $version = '1.7.1';
		public $cdn_url = 'https://cdn.jsdelivr.net/npm/leaflet@';

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {
			$args = wp_parse_args(
				$this->field,
				[
					'placeholder'    => esc_html__( 'Search...', 'adminify' ),
					'latitude_text'  => esc_html__( 'Latitude', 'adminify' ),
					'longitude_text' => esc_html__( 'Longitude', 'adminify' ),
					'address_field'  => '',
					'height'         => '',
				]
			);

			$value = wp_parse_args(
				$this->value,
				[
					'address'   => '',
					'latitude'  => '20',
					'longitude' => '0',
					'zoom'      => '2',
				]
			);

			$default_settings = [
				'center'          => [ $value['latitude'], $value['longitude'] ],
				'zoom'            => $value['zoom'],
				'scrollWheelZoom' => false,
			];

			$settings = ( ! empty( $this->field['settings'] ) ) ? $this->field['settings'] : [];
			$settings = wp_parse_args( $settings, $default_settings );

			$style_attr  = ( ! empty( $args['height'] ) ) ? ' style="min-height:' . esc_attr( $args['height'] ) . ';"' : '';
			$placeholder = ( ! empty( $args['placeholder'] ) ) ? [ 'placeholder' => $args['placeholder'] ] : '';

			echo Utils::wp_kses_custom($this->field_before());

			if ( empty( $args['address_field'] ) ) {
				echo '<div class="adminify--map-search">';
				echo '<input type="text" name="' . esc_attr( $this->field_name( '[address]' ) ) . '" value="' . esc_attr( $value['address'] ) . '"' . $this->field_attributes( $placeholder ) . ' />';
				echo '</div>';
			} else {
				echo '<div class="adminify--address-field" data-address-field="' . esc_attr( $args['address_field'] ) . '"></div>';
			}

			echo '<div class="adminify--map-osm-wrap"><div class="adminify--map-osm" data-map="' . esc_attr( json_encode( $settings ) ) . '"' . $style_attr . '></div></div>';

			echo '<div class="adminify--map-inputs">';

			echo '<div class="adminify--map-input">';
			echo '<label>' . esc_attr( $args['latitude_text'] ) . '</label>';
			echo '<input type="text" name="' . esc_attr( $this->field_name( '[latitude]' ) ) . '" value="' . esc_attr( $value['latitude'] ) . '" class="adminify--latitude" />';
			echo '</div>';

			echo '<div class="adminify--map-input">';
			echo '<label>' . esc_attr( $args['longitude_text'] ) . '</label>';
			echo '<input type="text" name="' . esc_attr( $this->field_name( '[longitude]' ) ) . '" value="' . esc_attr( $value['longitude'] ) . '" class="adminify--longitude" />';
			echo '</div>';

			echo '</div>';

			echo '<input type="hidden" name="' . esc_attr( $this->field_name( '[zoom]' ) ) . '" value="' . esc_attr( $value['zoom'] ) . '" class="adminify--zoom" />';

			echo Utils::wp_kses_custom($this->field_after());
		}

		public function enqueue() {
			if ( ! wp_script_is( 'adminify-leaflet' ) ) {
				wp_enqueue_script( 'adminify-leaflet', esc_url( $this->cdn_url . $this->version . '/dist/leaflet.js' ), [ 'adminify' ], $this->version, true );
			}

			if ( ! wp_style_is( 'adminify-leaflet' ) ) {
				wp_enqueue_style( 'adminify-leaflet', esc_url( $this->cdn_url . $this->version . '/dist/leaflet.css' ), [], $this->version );
			}

			if ( ! wp_script_is( 'jquery-ui-autocomplete' ) ) {
				wp_enqueue_script( 'jquery-ui-autocomplete' );
			}
		}

	}
}
