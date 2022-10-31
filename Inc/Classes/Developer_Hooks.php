<?php

/**
 * WP Adminify has some hooks for developers.
 */
if ( ! class_exists( 'WP_Adminify_Developer_Hooks' ) ) {

	/**
	 * Developer friendly hooks.
	 */
	class WP_Adminify_Developer_Hooks {


		/*
		 * * * * * * * * *
		* Class constructor
		* * * * * * * * * */
		public function __construct() {
			$this->_hooks();
		}

		public function _hooks() {
			add_filter( 'wp_adminify_remember_me', [ $this, 'wp_adminify_remember_me_callback' ], 10, 1 );
		}

		/**
		 * wp_adminify_remember_me_callback [turn off the remember me option from WordPress login form.]
		 *
		 * @param  bolean $activate
		 * @since 1.0.0
		 */
		public function wp_adminify_remember_me_callback( $activate ) {
			if ( ! $activate ) {
				return;
			}

			// Add the hook into the login_form
			add_action( 'login_form', [ $this, 'wp_adminify_login_form' ], 99 );
			// Reset any attempt to set the remember option
			add_action( 'login_head', [ $this, 'unset_remember_me_option' ], 99 );
		}

		function unset_remember_me_option() {

			// Remove the rememberme post value
			if ( isset( $_POST['rememberme'] ) ) {
				unset( $_POST['rememberme'] );
			}
		}

		function wp_adminify_login_form() {
			ob_start( [ $this, 'remove_forgetmenot_class' ] );
		}

		function remove_forgetmenot_class( $content ) {
			$content = preg_replace( '/<p class="forgetmenot">(.*)<\/p>/', '', $content );
			return $content;
		}
	}
}
