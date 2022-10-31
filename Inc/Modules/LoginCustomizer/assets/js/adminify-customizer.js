/**
 * String.prototype.includes polyfill.
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/includes
 */
if ( ! String.prototype.includes) {
	String.prototype.includes = function (search, start) {
		'use strict';

		if (search instanceof RegExp) {
			throw TypeError( 'first argument must not be a RegExp' );
		}
		if (start === undefined) {
			start = 0; }
		return this.indexOf( search, start ) !== -1;
	};
}

/**
 * Scripts within customizer control panel.
 *
 * Used global objects:
 * - jQuery
 * - wp
 * - WPAdminifyLoginCustomizer
 */
(function ($) {
	'use strict';

	var events = {};

	wp.customize.bind(
		'ready',
		function () {
			wpAdminifyListen();
			$( 'body' ).addClass( 'wp-adminify' );
			if ( ! WPAdminifyLoginCustomizer.isProActive) {
				adminifyUpgradeProLink();
			}
		}
	);

	function wpAdminifyListen() {
		events.switchLoginPreview();
		events.switchFormPreview();
		events.focusSection();
		events.focusSection();
		if ( ! WPAdminifyLoginCustomizer.isProActive) {
			events.templateFieldsChange();
		}
	}

	events.focusSection = function(){
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

	events.switchFormPreview = function(){

		wp.customize.section(
			'wp_adminify_register-form',
			function ( section ) {
				section.expanded.bind(
					function ( isExpanding ) {
						// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
						if ( isExpanding ) {
							  wp.customize.previewer.send( 'change-form', 'register' );
						} else {
							wp.customize.previewer.send( 'change-form', 'login' );
						}
					}
				);
			}
		);

		wp.customize.section(
			'wp_adminify_lostpassword-form',
			function ( section ) {
				section.expanded.bind(
					function ( isExpanding ) {
						// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
						if ( isExpanding ) {
							  wp.customize.previewer.send( 'change-form', 'lostpassword' );
						} else {
							wp.customize.previewer.send( 'change-form', 'login' );
						}
					}
				);
			}
		);

	}
	/**
	 * Change the page when the "WP Adminify Login Customizer" panel is expanded (or collapsed).
	 */
	events.switchLoginPreview = function () {
		wp.customize.panel(
			'jltwp_adminify_panel',
			function ( section ) {
				section.expanded.bind(
					function ( isExpanding ) {
						var loginURL = WPAdminifyLoginCustomizer.siteurl + '?wp-adminify-login-customizer=true';
						// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
						if ( isExpanding ) {
							  wp.customize.previewer.previewUrl.set( loginURL );
						} else {
							wp.customize.previewer.previewUrl.set( WPAdminifyLoginCustomizer.siteurl );
						}
					}
				);
			}
		);
	}

	events.templateFieldsChange = function () {
		wp.customize.section(
			'jltwp_adminify_customizer_template_section',
			function (section) {
				section.expanded.bind(
					function (isExpanded) {
						if (isExpanded) {
							var figur_input = $( '#customize-control-jltwp_adminify_login-templates .adminify--image-group .adminify--image figure input' );

							for (let index = 0; index < figur_input.length; index++) {
								var element = figur_input[index];
								var val     = element.value;
								// console.log('element', element.value);
								var hasDivAlready = element.parentNode.querySelector( '.wp-adminify-templates-pro' );

								if (val === 'template-01' || val === 'template-02' || val === 'template-03' || val === 'template-04') {
									continue;
								}

								if (hasDivAlready !== null) {
									continue;
								}

								var _div       = document.createElement( 'div' );
								var _a         = document.createElement( 'a' );
								_div.classList = 'wp-adminify-templates-pro';
								_a.setAttribute( 'href', 'https://wpadminify.com/login-customizer/?utm_source=plugin&utm_medium=login_customizer_link&utm_campaign=wp_adminify' )
								_a.setAttribute( 'target', '_blank' );
								_a.innerHTML = 'Upgrade to Pro';

								_div.appendChild( _a );
								element.parentNode.appendChild( _div );

							}
							// figur_input.forEach(element => {
							// console.log('figur_input_val', element.val());
							// });

							// var value = wp.customize('jltwp_adminify_login[templates]').get();
							// console.log('value', value);
							// if (value !== 'template-01' ) {
							// $('<div class="wp-adminify-templates-pro"><a href="https://wpadminify.com/login-customizer/?utm_source=plugin&utm_medium=login_customizer_link&utm_campaign=wp_adminify" target="_blank">Upgrade to Pro</a></div>').appendTo('#customize-control-jltwp_adminify_login-templates .adminify--image-group .adminify--image figure');
							// }
							// $("#customize-control-jltwp_adminify_login-templates .adminify--image-group .adminify--image").insertAt(0, "<li>as fasd fads fsd</li>");
							// $('<li>fgdf</li>').appendToWithIndex($("#customize-control-jltwp_adminify_login-templates .adminify--image-group .adminify--image > figure"),0)
						}
					}
				)
			}
		);
	}

	$.fn.appendToWithIndex = function(to,index){
		// console.log('firesd');
		// var lastIndex = this.children().size();
		// if (index < 0) {
		// index = Math.max(0, lastIndex + 1 + index);
		// }
		// this.append(element);
		// if (index < lastIndex) {
		// this.children().eq(index).before(this.children().last());
		// }
		// return this;
		if ( ! to instanceof jQuery) {
			to = $( to );
		};
		if (index === 0) {
			$( this ).prependTo( to )
		} else {
			$( this ).insertAfter( to.children().eq( index - 1 ) );
		}
	}

	function adminifyUpgradeProLink() {

		var proLink = '\
		<li class="accordion-section control-section wp-adminify-pro-control-section">\
			<a \
			href="https://wpadminify.com/login-customizer/?utm_source=plugin&utm_medium=login_customizer_link&utm_campaign=wp_adminify" \
			style="display: block; font-weight: 600; color: #fff !important; font-size: 16px; text-decoration: none; border-left-color: #0347FF; background: #0347FF;"\
				class="accordion-section-title" target="_blank" tabindex="0">\
				Upgrade to Pro ›\
			</a>\
		</li>\
		';

		$( proLink ).insertBefore( '#accordion-section-jltwp_adminify_customizer_template_section' );
	}

})( jQuery, wp.customize );
