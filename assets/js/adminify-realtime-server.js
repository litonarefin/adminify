// WP Adminify Realtime Server Details widget
(function ($)
{
	'use strict';

	var set_default = false;
	var uptime_interval;
	var interval_count = 0;

	var Adminify_Realtime_Server = {

		UpdateServerUptime: function( $days, $hours, $minutes, $seconds, upsec ) {

			$days.innerText    = Math.floor( upsec / 86400 );
			$hours.innerText   = String( Math.floor( (upsec % 86400) / 3600 ) ).padStart( 2, '0' );
			$minutes.innerText = String( Math.floor( ((upsec % 86400) % 3600) / 60 ) ).padStart( 2, '0' );
			$seconds.innerText = String( Math.floor( ((upsec % 86400) % 3600) % 60 ) ).padStart( 2, '0' );

		},

		// Server Uptime Counter
		ServerUptime: function(upsec) {

			upsec = Number( upsec );

			var $days    = document.getElementById( "adminify-days" ),
				$hours   = document.getElementById( "adminify-hours" ),
				$minutes = document.getElementById( "adminify-minutes" ),
				$seconds = document.getElementById( "adminify-seconds" );

			// Init
			Adminify_Realtime_Server.UpdateServerUptime( $days, $hours, $minutes, $seconds, Number( upsec ) );

			// 1 Sec Interval
			uptime_interval = setInterval(
				function() {
					Adminify_Realtime_Server.UpdateServerUptime( $days, $hours, $minutes, $seconds, ++upsec );
				},
				1000
			);

		},

		ProgressBar: function(){
			var totalProgress, progress;
			const circles = document.querySelectorAll( '.adminify-progress-bar' );
			for (var i = 0; i < circles.length; i++) {
				totalProgress = circles[i].querySelector( 'circle' ).getAttribute( 'stroke-dasharray' );
				progress      = circles[i].parentElement.getAttribute( 'data-percent' );

				circles[i].querySelector( '.adminify-bar' ).style['stroke-dashoffset'] = totalProgress * progress / 100;

			}
		},

		Ajax_Server_Data: function(){
			$.ajax(
				{
					type: 'POST',
					dataType: 'json',
					async: false,
					url: WPAdminify_Server.ajax_url,
					data: {
						action: 'adminify_live_server_stats',
						security: WPAdminify_Server.security_nonce
					},
					cache: false,
					success: function (response) {

						if ( ! response.success ) {
							return;
						}

						// CPU Loads
						var $cpu_load = response.data.cpu_load;
						$( '#adminify-cpu-load' ).attr( 'data-percent', $cpu_load );

						if ($cpu_load <= 10) {
							$( '#adminify-cpu-load .adminify-progress-bar circle:not(.adminify-bar)' ).css( { 'stroke': '#00BA88' } );
						} else if ($cpu_load > 65 && $cpu_load < 90) {
							$( '#adminify-cpu-load .adminify-progress-bar circle:not(.adminify-bar)' ).css( { 'stroke': '#ffe08a' } );
						} else if ($cpu_load > 90) {
							$( '#adminify-cpu-load .adminify-progress-bar circle:not(.adminify-bar)' ).css( { 'stroke': '#f14668' } );
						}

						// PHP Memory Usage
						var $memory_load_mb = response.data.memory_usage_MB;
						$( '#adminify-php-memory-usage' ).attr( 'data-percent', $memory_load_mb );

						if ($memory_load_mb <= 10) {
							$( '#adminify-php-memory-usage .adminify-progress-bar circle:not(.adminify-bar)' ).css( { 'stroke': '#00BA88' } );
						} else if ($memory_load_mb > 65 && $memory_load_mb < 90) {
							$( '#adminify-php-memory-usage .adminify-progress-bar circle:not(.adminify-bar)' ).css( { 'stroke': '#ffe08a' } );
						} else if ($memory_load_mb > 90) {
							$( '#adminify-php-memory-usage .adminify-progress-bar circle:not(.adminify-bar)' ).css( { 'stroke': '#f14668' } );
						}

						// RAM Usage
						var $ram_used = response.data.used_ram;
						$( '#adminify-ram-usage' ).attr( 'data-percent', $ram_used );

						if ($ram_used <= 10) {
							$( '#adminify-ram-usage .adminify-progress-bar circle:not(.adminify-bar)' ).css( { 'stroke': '#00BA88' } );
						} else if ($ram_used > 65 && $ram_used < 90) {
							$( '#adminify-ram-usage .adminify-progress-bar circle:not(.adminify-bar)' ).css( { 'stroke': '#ffe08a' } );
						} else if ($ram_used > 90) {
							$( '#adminify-ram-usage .adminify-progress-bar circle:not(.adminify-bar)' ).css( { 'stroke': '#f14668' } );
						}

						// WP Memory Usage
						var $wp_memory_usage = response.data.wp_memory_usage;
						$( '#adminify-wp-memory-usage' ).attr( 'data-percent', $wp_memory_usage );

						if ($wp_memory_usage <= 10) {
							$( '#adminify-wp-memory-usage .adminify-progress-bar circle:not(.adminify-bar)' ).css( { 'stroke': '#00BA88' } );
						} else if ($wp_memory_usage > 65 && $wp_memory_usage < 90) {
							$( '#adminify-wp-memory-usage .adminify-progress-bar circle:not(.adminify-bar)' ).css( { 'stroke': '#ffe08a' } );
						} else if ($wp_memory_usage > 90) {
							$( '#adminify-wp-memory-usage .adminify-progress-bar circle:not(.adminify-bar)' ).css( { 'stroke': '#f14668' } );
						}

						Adminify_Realtime_Server.ProgressBar();

						if (set_default == false) {
							Adminify_Realtime_Server.ServerUptime( response.data.uptime );
							set_default = true;
						}

					},
				}
			);
		}
	}

	// Documents Loaded
	Adminify_Realtime_Server.Ajax_Server_Data();
	setInterval(
		function() {

			interval_count++;

			if ( interval_count > 10 ) {
				  interval_count = 0;
				  set_default    = false;
				if ( uptime_interval ) {
					clearInterval( uptime_interval );
				}
			}

			Adminify_Realtime_Server.Ajax_Server_Data();

		},
		5000
	);

})( jQuery );
