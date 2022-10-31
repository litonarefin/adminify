<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Email validate
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'adminify_validate_email' ) ) {
	function adminify_validate_email( $value ) {
		if ( ! filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
			return esc_html__( 'Please enter a valid email address.', 'adminify' );
		}
	}
}

/**
 *
 * Numeric validate
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'adminify_validate_numeric' ) ) {
	function adminify_validate_numeric( $value ) {
		if ( ! is_numeric( $value ) ) {
			return esc_html__( 'Please enter a valid number.', 'adminify' );
		}
	}
}

/**
 *
 * Required validate
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'adminify_validate_required' ) ) {
	function adminify_validate_required( $value ) {
		if ( empty( $value ) ) {
			return esc_html__( 'This field is required.', 'adminify' );
		}
	}
}

/**
 *
 * URL validate
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'adminify_validate_url' ) ) {
	function adminify_validate_url( $value ) {
		if ( ! filter_var( $value, FILTER_VALIDATE_URL ) ) {
			return esc_html__( 'Please enter a valid URL.', 'adminify' );
		}
	}
}

/**
 *
 * Email validate for Customizer
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'adminify_customize_validate_email' ) ) {
	function adminify_customize_validate_email( $validity, $value, $wp_customize ) {
		if ( ! sanitize_email( $value ) ) {
			$validity->add( 'required', esc_html__( 'Please enter a valid email address.', 'adminify' ) );
		}

		return $validity;
	}
}

/**
 *
 * Numeric validate for Customizer
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'adminify_customize_validate_numeric' ) ) {
	function adminify_customize_validate_numeric( $validity, $value, $wp_customize ) {
		if ( ! is_numeric( $value ) ) {
			$validity->add( 'required', esc_html__( 'Please enter a valid number.', 'adminify' ) );
		}

		return $validity;
	}
}

/**
 *
 * Required validate for Customizer
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'adminify_customize_validate_required' ) ) {
	function adminify_customize_validate_required( $validity, $value, $wp_customize ) {
		if ( empty( $value ) ) {
			$validity->add( 'required', esc_html__( 'This field is required.', 'adminify' ) );
		}

		return $validity;
	}
}

/**
 *
 * URL validate for Customizer
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'adminify_customize_validate_url' ) ) {
	function adminify_customize_validate_url( $validity, $value, $wp_customize ) {
		if ( ! filter_var( $value, FILTER_VALIDATE_URL ) ) {
			$validity->add( 'required', esc_html__( 'Please enter a valid URL.', 'adminify' ) );
		}

		return $validity;
	}
}
