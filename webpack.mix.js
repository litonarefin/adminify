const mix = require("laravel-mix");
const fs = require('fs');
const wpPot = require("wp-pot");

mix.options({
	autoprefixer: {
		remove: false,
	},
	processCssUrls: false,
	terser: {
		terserOptions: {
		   keep_fnames: true
		}
	}
});

mix.webpackConfig({
	target: "web",
	externals: {
		jquery: "window.jQuery",
		$: "window.jQuery",
		wp: "window.wp",
		_wp_adminify: "window._wp_adminify",
	},
});
mix.sourceMaps(true, 'source-map');

if ( process.env.NODE_ENV.trim() === 'production' ) {

	// SCSS to CSS
	mix.sass( "dev/admin/modules/folder/folder.scss", "assets/admin/css/wp-adminify--folder.min.css" );
	mix.sass( "dev/admin/modules/page-speed/page-speed.scss", "assets/admin/css/wp-adminify--page-speed.min.css" );
	mix.sass( "dev/admin/modules/admin-columns/app.scss", "assets/admin/css/wp-adminify--admin-columns.min.css" );

	// Scripts to js - regular
	// mix.scripts( 'dev/admin/scripts/wp-adminify.js', 'assets/admin/js/wp-adminify.js' );

	// Scripts to js - vue

	mix.js("dev/nothing.js", "assets/nothing.js").vue();

	mix.js( "dev/admin/modules/admin-columns/app.js", "assets/admin/js/wp-adminify--admin-columns.min.js" )
		.js( "dev/admin/modules/page-speed/page-speed.js", "assets/admin/js/wp-adminify--page-speed.min.js" )
		.js( "dev/admin/modules/folder/folder.js", "assets/admin/js/wp-adminify--folder.min.js" )
		.js( "dev/admin/modules/setup-wizard/setup-wizard.js", "assets/admin/js/wp-adminify--setup-wizard.min.js" )
		.vue()
		.extract("assets/admin/js/vendor.min.js");

	mix.sass("assets/scss/style.scss", "assets/css/wp-adminify.min.css");
	mix.sass( "assets/scss/premium/adminify-pro-styles.scss", "Pro/assets/css/wp-adminify-pro.min.css" );
	mix.sass("assets/scss/_admin-bar.scss", "assets/css/admin-bar.min.css");
	mix.sass( "assets/scss/_menu-editor.scss", "assets/css/adminify-menu-editor.min.css" );
	mix.sass("assets/scss/_dark-mode.scss", "assets/css/dark-mode.min.css");
	mix.sass("assets/scss/_adminify-rtl.scss", "assets/css/adminify-rtl.min.css");
	mix.sass( "assets/scss/_adminify-responsive.scss", "assets/css/adminify-responsive.min.css" );
	mix.sass( "assets/scss/style-wp-default-ui.scss", "assets/css/wp-adminify-default-ui.min.css" );


	fs.readdirSync('assets/scss/plugins').forEach( file => {
		mix.sass( 'assets/scss/plugins/' + file, 'assets/css/plugins/' + file.substring(1).replace('.scss', '.min.css') );
	});

	fs.readdirSync('assets/scss/premium/plugins/').forEach( file => {
		mix.sass( 'assets/scss/premium/plugins//' + file, 'Pro/assets/css/plugins/' + file.substring(1).replace('.scss', '.min.css') );
	});

	// Themes
	mix.sass("assets/scss/themes/_neve.scss", "assets/css/themes/neve.min.css");

	// Language pot file generator
	wpPot({
		destFile: "languages/wp-adminify.pot",
		domain: "wp-adminify",
		package: "WP_Adminify",
		src: "**/*.php",
	});
	
} else {

	// SCSS to CSS
	mix.sass( "dev/admin/modules/folder/folder.scss", "assets/admin/css/wp-adminify--folder.css" );
	mix.sass( "dev/admin/modules/page-speed/page-speed.scss", "assets/admin/css/wp-adminify--page-speed.css" );
	mix.sass( "dev/admin/modules/admin-columns/app.scss", "assets/admin/css/wp-adminify--admin-columns.css" );

	// Scripts to js - regular
	// mix.scripts( 'dev/admin/scripts/wp-adminify.js', 'assets/admin/js/wp-adminify.js' );

	// Scripts to js - vue

	mix.js("dev/nothing.js", "assets/nothing.js").vue();

	mix.js( "dev/admin/modules/admin-columns/app.js", "assets/admin/js/wp-adminify--admin-columns.js" )
		.js( "dev/admin/modules/page-speed/page-speed.js", "assets/admin/js/wp-adminify--page-speed.js" )
		.js( "dev/admin/modules/folder/folder.js", "assets/admin/js/wp-adminify--folder.js" )
		.js( "dev/admin/modules/setup-wizard/setup-wizard.js", "assets/admin/js/wp-adminify--setup-wizard.js" )
		.vue()
		.extract();

	// Disable notification on dev mode
	mix.disableNotifications();

	mix.sass("assets/scss/style.scss", "assets/css/wp-adminify.css");
	mix.sass( "assets/scss/premium/adminify-pro-styles.scss", "Pro/assets/css/wp-adminify-pro.css" );
	mix.sass("assets/scss/_admin-bar.scss", "assets/css/admin-bar.css");
	mix.sass( "assets/scss/_menu-editor.scss", "assets/css/adminify-menu-editor.css" );
	mix.sass("assets/scss/_dark-mode.scss", "assets/css/dark-mode.css");
	mix.sass("assets/scss/_adminify-rtl.scss", "assets/css/adminify-rtl.css");
	mix.sass( "assets/scss/_adminify-responsive.scss", "assets/css/adminify-responsive.css" );
	mix.sass( "assets/scss/style-wp-default-ui.scss", "assets/css/wp-adminify-default-ui.css" );


	fs.readdirSync('assets/scss/plugins').forEach( file => {
		mix.sass( 'assets/scss/plugins/' + file, 'assets/css/plugins/' + file.substring(1).replace('.scss', '.css') );
	});

	fs.readdirSync('assets/scss/premium/plugins/').forEach( file => {
		mix.sass( 'assets/scss/premium/plugins//' + file, 'Pro/assets/css/plugins/' + file.substring(1).replace('.scss', '.css') );
	});

	// Themes
	mix.sass("assets/scss/themes/_neve.scss", "assets/css/themes/neve.css");

}