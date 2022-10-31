/**
 * Scripts within customizer preview window.
 *
 * Used global objects:
 * - jQuery
 * - wp
 * - WPAdminifyNotificationBar
 */
(function ($, api) {
	var events = {};
	var state  = {};

	wp.customize.bind(
		'preview-ready',
		function () {
			notif_bar_setup();
		}
	);

	function notif_bar_setup(){
		events.generalFieldChange();
		events.contentFieldChange();
		events.displayFieldChange();
		events.styleFieldChange();
		events.focusSection();
	}

	events.focusSection = function(){
		$( '.wp-adminify-preview-event' ).click(
			function() {
				wp.customize.preview.send( 'wp-adminify-focus-section', $( this ).data( 'section' ) );
			}
		);
	}

	events.generalFieldChange = function (){

		// Enable/Disable Notification bar
		wp.customize(
			'_adminify_notification_bar[show_notif_bar]',
			function( value ) {
				value.bind(
					function( to ) {
						if (to == true) {
							  $( 'div#cookieNotice' ).css( { display: 'block' } );
						} else {
							$( 'div#cookieNotice' ).css( { display: 'none' } );
						}
					}
				);
			}
		);

		// Content Alignment
		wp.customize(
			'_adminify_notification_bar[content_align]',
			function( value ) {
				value.bind(
					function( to ) {
						$( 'div#cookieNotice' ).css( {'text-align':to} );
					}
				);
			}
		);

		// Padding
		wp.customize(
			'_adminify_notification_bar[padding]',
			function( value ) {
				value.bind(
					function( to ) {
						$( 'div#cookieNotice' ).css( { 'padding':to['height'] + 'px ' + to['width'] + 'px'} );
					}
				);
			}
		);

		// Bar Position
		wp.customize(
			'_adminify_notification_bar[display_position]',
			function( value ) {
				value.bind(
					function( to ) {
						if ( to == 'top') {
							  $( 'div#cookieNotice' ).css( { top: '0px', bottom: 'unset'} );
						} else if ( to == 'bottom') {
							$( 'div#cookieNotice' ).css( { top: 'unset', bottom: '0px'} );
						}
					}
				);
			}
		);

		// Notification Bar Position type
		wp.customize(
			'_adminify_notification_bar[display_type]',
			function( value ) {
				value.bind(
					function( to ) {

						switch (to) {
							case 'fixed':
								$( '#wp-adminify-notification-bar' ).css( { position: 'fixed'} );
								  break;
							case 'on_scroll':
								$( '#wp-adminify-notification-bar' ).css( {position: 'scroll'} );
							 break;
						}
					}
				);
			}
		);

		// Notification Bar: Show/Hide Close Button
		wp.customize(
			'_adminify_notification_bar[show_btn_close]',
			function( value ) {
				value.bind(
					function( to ) {
						if (to == true) {
							  $( 'div#cookieNotice .confirm' ).show();
						} else {
							$( 'div#cookieNotice .confirm' ).hide();
						}
					}
				);
			}
		);

		// Notification Bar: Close Button Text
		wp.customize(
			'_adminify_notification_bar[close_btn_text]',
			function( value ) {
				value.bind(
					function( to ) {
						$( 'div#cookieNotice .confirm' ).text( to );
					}
				);
			}
		);

	};

	// Notification Bar Content Change Section
	events.contentFieldChange = function (){

		wp.customize(
			'_adminify_notification_bar[notif_bar_content_section]',
			function( value ) {
				value.bind(
					function( to ) {
						for (const label of Object.keys( to )) {
							switch (label) {
								case 'notif_bar_content':
									  $( 'div#cookieNotice' ).not( '.confirm' ).text( to['notif_bar_content'] );
							   break;
								case 'show_notif_bar_btn':
									if (to['show_notif_bar_btn']) {
										$( 'div#cookieNotice .learn-more' ).css( {'display': 'block'} );
									} else {
										$( 'div#cookieNotice .learn-more' ).css( {'display': 'none'} );
									}
							 break;
								case 'notif_btn':
									$( 'div#cookieNotice .learn-more' ).text( to['notif_btn'] );
							   break;
							}
						}
					}
				);
			}
		);

	};

	// Display Settings
	events.displayFieldChange = function (){};

	// Style Settings
	events.styleFieldChange = function (){

		// Background Color
		wp.customize(
			'_adminify_notification_bar[bg_color]',
			function (value) {
				value.bind(
					function( to ) {
						$( 'div#cookieNotice ' ).css( {'background':to} );
					}
				);
			}
		);

		// Text Color
		wp.customize(
			'_adminify_notification_bar[text_color]',
			function (value) {
				value.bind(
					function( to ) {
						$( 'div#cookieNotice ' ).css( {'color':to} );
					}
				);
			}
		);

		// Close Button Color
		wp.customize(
			'_adminify_notification_bar[btn_color]',
			function (value) {
				value.bind(
					function( to ) {
						$( 'div#cookieNotice  .confirm' ).css( {'background-color':to} );
					}
				);
			}
		);

		// Close Button Color
		wp.customize(
			'_adminify_notification_bar[btn_text_color]',
			function (value) {
				value.bind(
					function( to ) {
						$( 'div#cookieNotice  .confirm' ).css( {'color':to} );
					}
				);
			}
		);

		// Learn More BG Color
		wp.customize(
			'_adminify_notification_bar[link_bg_color]',
			function (value) {
				value.bind(
					function( to ) {
						$( 'div#cookieNotice  .learn-more' ).css( {'background-color':to} );
					}
				);
			}
		);

		// Learn More Color
		wp.customize(
			'_adminify_notification_bar[link_color]',
			function (value) {
				value.bind(
					function( to ) {
						$( 'div#cookieNotice  .learn-more' ).css( {'color':to} );
					}
				);
			}
		);

		// Typography
		wp.customize(
			'_adminify_notification_bar[typography]',
			function (value) {
				value.bind(
					function( to ) {
						const notif_bar_font_size = to['font-size'] + 'px',
						 notif_bar_font_family    = to['font-family'],
						 notif_bar_font_style     = to['font-style'],
						 notif_bar_font_ln_height = to['line-height'] + 'px',
						 notif_bar_font_txt_trans = to['text-transform'];

						$( '#wp-adminify-notification-bar' ).css(
							{
								fontSize: notif_bar_font_size,
								fontFamily: notif_bar_font_family,
								fontStyle: notif_bar_font_style,
								lineHeight: notif_bar_font_ln_height,
								textTransform: notif_bar_font_txt_trans
							}
						);
					}
				);
			}
		);

	};

})( jQuery, wp.customize );
