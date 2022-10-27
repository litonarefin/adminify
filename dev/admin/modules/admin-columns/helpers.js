const config = Object.assign( {}, window.adminify_columns_data );

delete window.adminify_columns_data.ajax_nonce;
delete window.adminify_columns_data.siteurl;
delete window.adminify_columns_data.ajaxurl;
delete window.adminify_columns_data.adminurl;
delete window.adminify_columns_data.ajax_action;
delete window.adminify_columns_data.is_pro;

const helpers = {

	proNotice() {
		return config.pro_notice
	},

	isPro() {
		return !! config.is_pro;
	},

	getSiteURL() {
		return config.siteurl;
	},

	getWPNonce() {
		return config.ajax_nonce;
	},

	getAjaxURL() {
		return config.ajaxurl;
	},

	getAdminURL() {
		return config.adminurl;
	},

	getAjaxAction() {
		return config.ajax_action;
	},

	ajax( route, _data, type = 'POST' ) {

		let data = jQuery.extend( {}, _data, {
			route,
			_ajax_nonce: this.getWPNonce(),
			action: this.getAjaxAction()
		});

		return jQuery.ajax({
			type,
			data,
			url: this.getAjaxURL()
		});

	},

	nonReactive( data ) {
		return JSON.parse( JSON.stringify( data ) );
	},

	triggerLoader( status = true ) {
		if ( status ) {
			jQuery(".wp-adminify--admin-columns--editor--container .wp-adminify-loader").stop(true, true).fadeIn("slow");
		} else {
			jQuery(".wp-adminify--admin-columns--editor--container .wp-adminify-loader").stop(true, true).fadeOut("slow");
		}

	}

}

export default helpers;
