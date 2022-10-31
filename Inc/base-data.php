<?php

namespace WPAdminify\Inc;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Base_Data {

	private $data;

	final public function get( $data = null ) {
		$this->ensure_data();

		return self::get_items( $this->data, $data );
	}

	final public function set( $key, $value = null ) {
		if ( is_array( $key ) ) {
			$this->data = array_merge( $this->get_defaults(), $key );
		} else {
			$this->ensure_data();
			$this->data[ $key ] = $value;
		}
	}

	public function delete( $key = null ) {
		if ( $key ) {
			unset( $this->data[ $key ] );
		} else {
			$this->data = [];
		}
	}

	final public function set_recursive( $key, array $value ) {
		$this->ensure_data();

		$data = &$this->data[ $key ];

		$data = $this->merge_properties( $data, $value );
	}

	final public function merge_properties( array $default_props, array $custom_props, array $allowed_props_keys = [] ) {
		$props = array_replace_recursive( $default_props, $custom_props );

		if ( $allowed_props_keys ) {
			$props = array_intersect_key( $props, array_flip( $allowed_props_keys ) );
		}

		return $props;
	}

	final protected static function get_items( array $haystack, $needle = null ) {
		if ( $needle ) {
			return isset( $haystack[ $needle ] ) ? $haystack[ $needle ] : null;
		}

		return $haystack;
	}

	protected function get_defaults() {
		return [];
	}

	private function ensure_data() {
		if ( null === $this->data ) {
			$this->data = $this->get_defaults();
		}
	}

	public function has_own_method( $method_name, $base_class_name = null ) {
		try {
			$reflection_method = new \ReflectionMethod( $this, $method_name );
			$declaring_class   = $reflection_method->getDeclaringClass();
		} catch ( \Exception $e ) {
			return false;
		}

		if ( $base_class_name ) {
			return $base_class_name !== $declaring_class->name;
		}

		return get_called_class() === $declaring_class->name;
	}

}
