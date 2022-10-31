/**
 * Scripts within customizer control panel.
 *
 * Used global objects:
 * - jQuery
 * - wp
 * - WP Adminify Notification Bar
 */
(function ($) {
	'use strict';

	var events = {};

	wp.customize.bind(
		'ready',
		function () {
			notification_bar_setup();
		}
	);

	function notification_bar_setup() {
		events.switchNotificationBarPreview();
		events.focusSection();
	}

	/**
	 * Change the page when the "WP Adminify Login Customizer" panel is expanded (or collapsed).
	 */
	events.switchNotificationBarPreview = function () {
		wp.customize.panel(
			'jltwp_notification_bar_panel',
			function ( section ) {
				section.expanded.bind(
					function ( isExpanding ) {
						var loginURL = WPAdminifyNotificationBar.siteurl + '?wp-adminify-notification-bar=true';
						// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
						if ( isExpanding ) {
							  wp.customize.previewer.previewUrl.set( loginURL );
						} else {
							wp.customize.previewer.previewUrl.set( WPAdminifyNotificationBar.siteurl );
						}
					}
				);
			}
		);
	}
	events.focusSection                 = function(){
		wp.customize.previewer.bind(
			'wp-adminify-focus-section',
			function ( sectionName ) {
				var section = wp.customize.section( sectionName );

				if ( undefined !== section ) {
					section.focus();
				}
			}
		);
	}

})( jQuery, wp.customize );
