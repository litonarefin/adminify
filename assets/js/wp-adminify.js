// JS codes by WP Adminify

(function ($)
{
	'use strict';

	// wp adminify adminbar menu displaying issue fixed START
	if ( ! $( "#wp-admin-bar-top-secondary" ).length) {
		$( "#wp-toolbar.quicklinks" ).append( ` < ul id = "wp-adminify-default-top-secondary" > < / ul > ` )
	}
	// wp adminify adminbar menu displaying issue fixed END

	// Icon Class replaced when adminify_ui is disabled
	$( "body:not(.adminify-ui) div[class*=' dashicons-adminify']" ).each(
		function(){
			var el_class = $( this ).attr( 'class' ).replace( "dashicons-before dashicons-adminify-", "adminify-menu-icon " );
			$( this ).attr( 'class',el_class );
		}
	);

	// scroll to top class added to body / its currently working for gravity form header
	window.addEventListener(
		'scroll',
		function(e){
			var distanceY = window.pageYOffset || document.documentElement.scrollTop,
			scrollTo      = 40,
			header        = document.querySelector( "body" );
			if (distanceY > scrollTo) {
				header.classList.add( "adminify-scrollto-sticky" );
			} else {
				if (header.classList.contains( "adminify-scrollto-sticky" )) {
					header.classList.remove( "adminify-scrollto-sticky" );
				}
			}
		}
	);

	// Folder div made full width and content placed to bottom
	if (window.matchMedia( '(max-width: 500px)' ).matches) {
		setTimeout(
			() => {
				var folder_height = $( ".wp-adminify--folder-app" ).height();
				$( '#wpbody-content' ).css( 'margin-top',(folder_height + 180) );
			},
			1500
		);
	}

	var adminHeight = $( '.wp-adminify.adminify-top_bar' ).height();
	$( '.wp-adminify-admin-bar.position-bottom' ).css( 'padding-bottom', adminHeight * 1.25 );

	// User Wrapper On / Off

	var openBtn  = $( ".wp-adminify--user--account" ),
		colseBtn = $( ".user-wrapper-close" ),
		menu     = $( ".wp-adminify--user--wrapper" );

	// Open menu when click on menu button
	openBtn.on(
		"click",
		function (e)
		{
				menu.addClass( "active" );
		}
	);

	// Close menu when click on Close button
	colseBtn.on(
		"click",
		function ()
		{
				menu.removeClass( "active" );
		}
	);

	// Close menu when click on anywhere on the document
	$( document ).on(
		"click",
		function (e)
		{
				var target = $( e.target );
			if (target.is( ".wp-adminify--user--wrapper *, .wp-adminify--user--wrapper, img.avatar.avatar-45.photo.is-rounded" ) === false) {
				menu.removeClass( "active" );
				e.stopPropagation();
			}
		}
	);

	// Widget #dashboard_right_now count style

	jQuery( "#dashboard_right_now li a" ).html(
		function ()
		{
				var text  = jQuery( this ).text().trim().split( " " );
				var first = text.shift();
				return (text.length > 0 ? "<span class='counter'>" + first + "</span> " : first) + text.join( " " );
		}
	);

	// Accordion

	jQuery( ".accordion .accordion-body" ).css( "display", "none" );

	jQuery( 'body' ).on(
		'click',
		'.accordion-button, .accordion-opener',
		function(e)
		// jQuery(".accordion-button, .accordion-opener").on('click', function (e)
		{
				e.preventDefault();
				jQuery( this ).toggleClass( 'show' );

				var jQuerythis = jQuery( this );

			if (jQuerythis.next().hasClass( 'show' )) {
				jQuerythis.next().removeClass( 'show' );
				jQuerythis.next().slideUp( 100 );
			} else {
				jQuerythis.parent().parent().find( '.accordion-body' ).removeClass( 'show' );
				jQuerythis.parent().parent().find( '.accordion-body' ).slideUp( 100 );
				jQuerythis.prev( '.accordion-title' ).toggleClass( 'show' );
				jQuerythis.next().toggleClass( 'show' );
				jQuerythis.next().slideToggle( 100 );
			}
		}
	);

	// Admin Columns Accordions

	$( '.accordion-opener' ).on(
		'click',
		function (e)
		{
				e.preventDefault();

				let $this = $( this );

			if ($this.next().hasClass( 'show' )) {
				$this.next().removeClass( 'show' );
				$this.next().slideUp( 100 );
			} else {
				$this.parent().parent().find( '.accordion-body' ).removeClass( 'show' );
				$this.parent().parent().find( '.accordion-body' ).slideUp( 100 );
				$this.prev( '.accordion-title' ).toggleClass( 'show' );
				$this.next().toggleClass( 'show' );
				$this.next().slideToggle( 100 );
			}
		}
	);

	$( window ).on(
		'load',
		function () {

			// WP_Adminify.animateCSS('body.wp-adminify', 'fadeIn');
			// WP_Adminify.animateCSS('.my-element', 'fadeIn').then((message) => {
			// // Do something after the animation
			// });

			// Circle Menu Functions
			var $circle_menu = $( '#circle-menu' );
			var direction    = 'left-half';
			if ( "undefined" != typeof WPAdminify_QuickMenu && WPAdminify_QuickMenu.is_rtl ) {
				direction = 'right-half';
			}
			$( ".wp-adminify-loader" ).delay( 300 ).fadeOut( "slow" );
			if ( $circle_menu.length ) {
				$circle_menu.circleMenu(
					{
						direction: direction,
						trigger: 'hover',
						delay: 200
					}
				).fadeIn( "slow" ).show();
			}

			// Adminbar Loader
			$( ".wp-adminify-topbar-loader" ).delay( 100 ).fadeOut( "fast" );
			setTimeout( function () { $( '.wp-adminify.adminify-top_bar' ).fadeIn( 'fast' ); }, 100 );

			// Menu Editor Preloader
			setTimeout( function () { $( '.wp-adminify-menu-editor-loader' ).css( { 'display': 'none' } ); }, 700 )
			setTimeout( function () { $( '.wp-adminify--menu--editor--settings' ).addClass( 'loaded' ); }, 700 );

		}
	);

	// Google page speed origin on / off

	jQuery( '.origin-summery-trigger button' ).on(
		'click',
		function () {
			alert( 'clicked!' );
			jQuery( '.result-body' ).toggleClass( 'show-origin' );
		}
	);

	// Wrap content get extra margin if folder options exist
	jQuery( 'body' ).has( '#wp-adminify--folder-app' ).addClass( 'has-folder-options' );

	// tippy('[data-tippy-content]');

	// Admin Topbar Search
	function admin_top_search_hide_result()
	{
		$( "#top-header-search-results" ).hide();
	}
	function admin_top_search_show_result()
	{
		$( "#top-header-search-results" ).show();
	}

	$( "#top-header-search-input" ).on(
		"input",
		function ()
		{
				var search_val = $( "#top-header-search-input" ).val();
				admin_top_bar_search( search_val );
			if ( ! search_val.length) {
				admin_top_search_hide_result();
			}
		}
	);

	var cansearch;
	function admin_top_bar_search(searchTerm)
	{

		// Admin Bar Search
		if (cansearch == false) {
			return;
		}

		if (searchTerm == "") {
			return;
		}

		// var count_rows = $('#top-header-search-results .top-header-result-table > tbody > tr').length;
		// console.log(count_rows);
		// $("#top-header-search-results").css('display','block');

		$.ajax(
			{
				url: WPAdminify.ajax_url,
				type: "post",
				data: {
					action: "adminify_all_search",
					security: WPAdminify.security_nonce,
					search: searchTerm
				},
				beforeSend: function (xhr)
			{
					cansearch = false;
				},
				success: function (response)
			{

					if (response) {
						var data = JSON.parse( response );

						// if (data.error) {
						// Toastr Code here
						// } else {
						admin_top_search_show_result();

						$( "#top-header-search-results .top-header-results-wrapper" ).html( data );

						// $("#top-header-search-results").show();
						cansearch = true;
						// }
					}
				},
			}
		);
	}

	var WP_Adminify = {

		ToggleSwitcher: function (key, value)
		{
			if (key == "") {
				return; }
			jQuery.ajax(
				{
					url: WPAdminify.ajax_url,
					type: "post",
					data: {
						action: "wp_adminify_color_mode",
						security: WPAdminify.security_nonce,
						key: key,
						value: value,
					}
				}
			);
		},

		// Light/Dark Mode
		Color_Mode_Switcher: function ()
		{
			$( '#light-dark-switcher-btn' ).on(
				'click',
				function ()
				{
						var color_mode = $( "#light-dark-switcher-btn" ).is( ":checked" ) ? 'dark' : 'light';
						WP_Adminify.ToggleSwitcher( "color_mode", color_mode );
					if (color_mode === 'dark') {
						$( "body" ).removeClass( "adminify-light-mode" );
						$( "body" ).addClass( "adminify-dark-mode" );
					} else if (color_mode === 'light') {
						$( "body" ).removeClass( "adminify-dark-mode" );
						$( "body" ).addClass( "adminify-light-mode" );
					}
				}
			);
		},

		// Screens Tab
		Screen_Option_Switcher: function ()
		{
			$( '#screen-option-switcher-btn' ).on(
				'click',
				function ()
				{
						var screen_options_tab = $( "#screen-option-switcher-btn" ).is( ":checked" ) ? 1 : 0;
						WP_Adminify.ToggleSwitcher( "screen_options_tab", screen_options_tab );
					if (screen_options_tab) {
						$( '#screen-options-link-wrap' ).css( 'display', 'none' );
					}
				}
			);
		},

		// Help Tab
		Help_Tab: function ()
		{
			$( '#help-option-switcher-btn' ).on(
				'click',
				function ()
				{
						var adminify_help_tab = $( "#help-option-switcher-btn" ).is( ":checked" ) ? 1 : 0;
						WP_Adminify.ToggleSwitcher( "adminify_help_tab", adminify_help_tab );
					if (adminify_help_tab) {
						$( '#contextual-help-link-wrap' ).css( 'display', 'none' );
					}
				}
			);
		},

		// Hide WP Links
		Hide_WP_Links: function ()
		{
			$( '#hide-wp-links-switcher-btn' ).on(
				'click',
				function ()
				{
						var hide_wp_links = $( "#hide-wp-links-switcher-btn" ).is( ":checked" ) ? 1 : 0;
						WP_Adminify.ToggleSwitcher( "hide_wp_links", hide_wp_links );
				}
			);
		},

		// Copy Active Plugins
		Copy_Active_Plugins: function (e)
		{
			e.preventDefault();
			$( '.adminify-copy-btn' ).copyToClipboard(
				{
					parent: '.adminify-server-info',
					content: '.adminify-active-plugins-data',
					onSuccess: function ($element, source, selection)
				{
						$( 'span', $element ).text( $element.attr( "data-text-copied" ) );
						setTimeout(
							function ()
							{
									$( 'span', $element ).text( $element.attr( "data-text" ) );
							},
							200000
						);
					}
				}
			);
		},

		Dismiss_Notice: function(){
			$( 'div[data-dismissible] .notice-dismiss,div[data-dismissible] .adminify-notice-dismiss, div[data-dismissible] .dismiss-this' ).on(
				'click',
				function (event) {
					event.preventDefault();
					var $this = $( this );
					var attr_value, option_name, dismissible_length, data;

					attr_value = $this.closest( "div[data-dismissible]" ).attr( 'data-dismissible' ).split( '-' );

					// remove the dismissible length from the attribute value and rejoin the array.
					dismissible_length = attr_value.pop();
					option_name        = attr_value.join( '-' );
					data               = {
						'action'            : 'adminify_dismiss_admin_notice',
						'option_name'       : option_name,
						'dismissible_length': dismissible_length,
						'notice_nonce'      : WPAdminify.notice_nonce
					};

					// We can also pass the url value separately from ajaxurl for front end AJAX implementations
					$.post( WPAdminify.ajax_url, data );
					$this.closest( "div[data-dismissible]" ).hide( 'slow' );
				}
			);
		},

		animateCSS: function (element, animation, prefix = 'animate__')
		{
			// We create a Promise and return it
			new Promise(
				(resolve, reject) =>
				{
					var animationName = `${prefix}${animation}`;
					var node          = document.querySelector( element );

					node.classList.add( `${prefix}animated`, animationName );

					// When the animation ends, we clean the classes and resolve the Promise
					function handleAnimationEnd(event)
					{
						event.stopPropagation();
						node.classList.remove( `${prefix}animated`, animationName );
						resolve( 'Animation ended' );
					}

					node.addEventListener( 'animationend', handleAnimationEnd, { once: true } );
				}
			);
		},

		VersionRollback:function(){
			$( 'select.wp-adminify-rollback-select' ).on(
				'change',
				function () {
					var $this       = $( this ),
					$rollbackButton = $this.next( '.wp-adminify-rollback-button' ),
					placeholderText = $rollbackButton.data( 'placeholder-text' ),
					placeholderUrl  = $rollbackButton.data( 'placeholder-url' );
					$rollbackButton.html( placeholderText.replace( '{VERSION}', $this.val() ) );
					$rollbackButton.attr( 'href', placeholderUrl.replace( 'VERSION', $this.val() ) );
				}
			).trigger( 'change' );

			$( 'body' ).removeClass( 'wp-adminify--popup-show' );

			$( '.wp-adminify-rollback-button' ).on(
				'click',
				function (event) {
					event.preventDefault();
					var $this = $( this );
					$( 'body' ).addClass( 'wp-adminify--popup-show' );
					$( '.wp-adminify-dialog-ok' ).on(
						'click',
						function(event){
							event.preventDefault();
							location.href = $this.attr( 'href' );
						}
					);
				}
			);
		},

	};

	// Documents Loaded
	$(
		function () {

			// Adminify vertical menu

			$( '.adminify-accordion-v-menu #adminmenu .wp-submenu, .adminify-toggle-v-menu #adminmenu .wp-submenu' ).hide();
			$( '.adminify-accordion-v-menu .wp-adminify-active .wp-submenu' ).show();
			$( '.adminify-accordion-v-menu #adminmenu .wp-adminify-parent > a.menu-top, .adminify-toggle-v-menu #adminmenu .wp-adminify-parent > a.menu-top' ).data( 'href', $( this ).attr( 'href' ) ).removeAttr( 'href' );

			// Adminify Accordion type vertical menu

			$( ".adminify-accordion-v-menu #adminmenu .wp-adminify-parent > a.menu-top" ).on(
				'click',
				function (e) {
					$( this ).each(
						function ()
						{
								$( ".wp_adminify_admin-menu ul" ).slideUp().parent( 'li.menu-top' ).removeClass( 'wp-adminify-active' );
								$( this ).next().is( ":visible" ) || $( this ).next().slideDown().parent( 'li.menu-top' ).toggleClass( 'wp-adminify-active' );
						}
					)
					e.stopPropagation()
				}
			);

			// Adminify Toggle type vertical menu

			$( ".adminify-toggle-v-menu #adminmenu .wp-adminify-parent > a.menu-top" ).on(
				'click',
				function () {
					$( this ).parent( ".adminify-toggle-v-menu #adminmenu li.wp-adminify-parent" ).toggleClass( 'wp-adminify-active' );
				}
			);

			// Extra space appears on Folder Widget in Horizontal Menu mode
			var hmenuHeight = $( '.wp-adminify-horizontal-menu' ).height();
			$( '.wp-adminify.horizontal-menu.has-folder-options .wp-adminify--folder-widget' ).css( 'top', hmenuHeight * 1.05 );

			function fixClasses() {
				var width = $( window ).innerWidth();
				if ( width <= 767 ) {
					$( 'body' ).removeClass( 'folded auto-fold' );
				}
				if ( width <= 1023 && width > 767 ) {
					$( 'body' ).addClass( 'folded' );
				}
			}

			fixClasses();

			$( window ).on(
				'resize',
				function() {
					fixClasses();
				}
			);

			$( '.navbar-brand .navbar-burger' ).on(
				'click',
				function () {
					if ( $( window ).innerWidth() <= 767 ) {
						$( 'body' ).toggleClass( 'adminify-collapse-menu' );
						$( '#adminmenumain' ).toggleClass( 'adminify-menu-expanded' );
						window.scrollTo( 0, 0 );
					} else {
						jQuery( '#collapse-button' ).trigger( 'click' );
					}
				}
			);

			// Range Slider

			// var textinput = $( ".range-value" ).val();
			// var myslider =  $( ".range-slider" ).slider({
			// min: 0,
			// max: 900,
			// range: "min",
			// value: $(".range-value").val(),
			// slide: function( event, ui ) {
			// $(".range-value").val(ui.value);
			// }
			// });

			// $( ".range-value" ).on( "keyup", function() {
			// myslider.slider( "value", this.value );
			// });

			// WP_Adminify.ToggleSwitcher();
			WP_Adminify.Color_Mode_Switcher();
			WP_Adminify.Screen_Option_Switcher();
			WP_Adminify.Help_Tab();
			WP_Adminify.Hide_WP_Links();
			WP_Adminify.Dismiss_Notice();
			WP_Adminify.VersionRollback();
			// WP_Adminify.Copy_Active_Plugins();

			// Copy to Clipboard Section
			(function (n) {
				n.fn.copyToClipboard = function (e)
			{
					var t = n.extend(
						{
							parent: "body",
							content: "",
							onSuccess: function () { },
							onError: function () { }
						},
						e
					);
					return this.each(
						function ()
						{
								var e = n( this );
								e.on(
									"click",
									function ()
									{
											var n = e.parents( t.parent ).find( t.content );
											var o = document.createRange();
											var c = window.getSelection();
											o.selectNodeContents( n[0] );
											c.removeAllRanges();
											c.addRange( o );
										try {
											var r = document.execCommand( "copy" );
											var a = r ? "onSuccess" : "onError";
											t[a]( e, n, c.toString() )
										} catch (i) {
										}
											c.removeAllRanges()
									}
								);
						}
					)
				}
			})( jQuery );

			$( '.adminify-copy-btn' ).on(
				'click',
				function (e)
				{
						e.preventDefault();
						$( '.adminify-copy-btn' ).copyToClipboard(
							{
								parent: '.adminify-server-info',
								content: '.adminify-active-plugins-data',
								onSuccess: function ($element, source, selection)
							{
									$( 'span', $element ).text( $element.attr( "data-text-copied" ) );
									setTimeout(
										function ()
										{
												$( 'span', $element ).text( $element.attr( "data-text" ) );
										},
										2000
									);
								}
							}
						);
				}
			);

			if ($( window ).innerWidth() <= 1200) {
				$( '.adminify-search-expand' ).on(
					'click',
					function ()
					{
							$( '.top-header--search--form' ).toggleClass( 'adminify-form-expand' );
					}
				);
			}

			// betterlinks menu settings
			if ( WPAdminify_ThirdParty.better_links.active === true ) {
				var { menu_name, submenu_manage, submenu_name, submenu_settings } = WPAdminify_ThirdParty.better_links;

				if ( $( "body" ).hasClass( "toplevel_page_betterlinks" ) ) {
					if (menu_name) {
						$( '.toplevel_page_betterlinks #toplevel_page_betterlinks .wp-menu-name' ).text( menu_name );
					}
					setTimeout(
						() => {
							if (menu_name) {
								$( '.toplevel_page_betterlinks #toplevel_page_betterlinks .wp-submenu .wp-submenu-head' ).text( menu_name );
							}
							if (submenu_manage) {
								$( '.toplevel_page_betterlinks #toplevel_page_betterlinks .wp-submenu li:nth-child(2) a' ).text( submenu_manage );
							}
							if (submenu_name) {
								$( '.toplevel_page_betterlinks #toplevel_page_betterlinks .wp-submenu li:nth-child(3) a' ).text( submenu_name );
							}
							if (submenu_settings) {
								$( '.toplevel_page_betterlinks #toplevel_page_betterlinks .wp-submenu li:nth-child(4) a' ).text( submenu_settings );
							}
						},
						500
					);
				}
			}

		}
	);

})( jQuery );
