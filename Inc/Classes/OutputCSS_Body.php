<?php

namespace WPAdminify\Inc\Classes;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettings;
use WPAdminify\Inc\Admin\AdminSettingsModel;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class OutputCSS_Body extends AdminSettingsModel {

	public $url;
	public function __construct() {
		$this->options = (array) AdminSettings::get_instance()->get();
		add_action( 'admin_enqueue_scripts', [ $this, 'jltwp_adminify_output_body_styles' ], 9999 );

		// Customize Colors Preset
		// add_action('wp_head', [$this, 'jltwp_adminify_output_body_preset_vars']);
		add_action( 'admin_enqueue_scripts', [ $this, 'jltwp_adminify_output_body_preset_vars' ] );
	}


	public function jltwp_adminify_output_body_preset_vars() {
		if ( array_key_exists( 'adminify_theme', $this->options ) && ! empty( $this->options['adminify_theme'] ) ) {
			$theme = $this->options['adminify_theme'];
		} else {
			$theme = 'preset1'; // get the default value dynamically
		}

		$preset = (array) Utils::get_theme_presets( $theme );

		if ( empty( $preset ) ) {
			$preset = $this->options['adminify_theme_custom_colors'];
		}
		$preset_style = '';

		foreach ( $preset as $prop => $val ) {
			$preset_style .= sprintf( '%s:%s;', $prop, $val );
		}

		if ( empty( $preset_style ) ) {
			return;
		}

		printf( '<style>body.wp-adminify{%s}</style>', $preset_style );

		wp_enqueue_script( 'adminify-theme-presetter', WP_ADMINIFY_ASSETS . 'admin/js/wp-adminify-theme-presetter.js', [ 'jquery' ], null, true );

		wp_localize_script( 'adminify-theme-presetter', 'adminify_preset_themes', Utils::get_theme_presets() );
	}


	public function jltwp_adminify_output_body_styles() {
		$jltwp_adminify_output_body_css = '';
		$admin_bg_type                  = ! empty( $this->options['admin_general_bg'] ) ? $this->options['admin_general_bg'] : 'color';

		// Background Types
		$admin_bg_color = ! empty( $this->options['admin_general_bg_color'] ) ? $this->options['admin_general_bg_color'] : '';

		// Background Types
		if ( $admin_bg_type ) {
			$jltwp_adminify_output_body_css .= 'html, body.wp-adminify{';

			// Background Type: Color
			if ( $admin_bg_type == 'color' ) {
				if ( ! empty( $admin_bg_color ) ) {
					$jltwp_adminify_output_body_css .= 'background-color: ' . esc_attr( $admin_bg_color ) . ';';
				}
			}

			$jltwp_adminify_output_body_css .= '}';
		}

		// Primary Button Settings
		$button_primary_color   = ! empty( $this->options['admin_general_button_color']['primary_color'] ) ? $this->options['admin_general_button_color']['primary_color'] : '#0347FF';
		$button_secondary_color = ! empty( $this->options['admin_general_button_color']['secondary_color'] ) ? $this->options['admin_general_button_color']['secondary_color'] : '#fff';

		// Primary Button Fill Coloe
		if ( $button_primary_color || $button_secondary_color ) {
			$jltwp_adminify_output_body_css .= '.wp-adminify #wpbody-content .actions input[type=submit]:hover, .wp-adminify #wpbody-content .interface-interface-skeleton__header .edit-post-header .edit-post-header__settings button.block-editor-post-preview__button-toggle:hover, .wp-adminify.block-editor-page .editor-post-publish-panel .components-button.is-secondary:hover, .wp-adminify .media-modal .media-frame-content button:not(.delete-attachment):hover, .wp-adminify .media-upload-form .drag-drop-inside #plupload-browse-button:hover, .wp-adminify #wp-media-grid .media-frame .uploader-inline-content button.browser:hover, .wp-adminify .is-secondary:not(.wp-editor-wrap button):hover, .wp-adminify #wpbody-content #createuser .wp-generate-pw:hover, .wp-adminify #wpbody-content #createuser .wp-hide-pw:hover, .wp-adminify #wpbody-content #your-profile .wp-generate-pw:hover, .wp-adminify .button-secondary:not(.wp-editor-wrap button):hover, .wp-adminify #wpbody-content input[type=submit]#create-page:hover, .wp-adminify.themes-php #wpbody-content .theme-browser .theme:not(.add-new-theme) .theme-actions .button.activate:hover, .wp-adminify .media-frame-content .wp-filter button.select-mode-toggle-button:hover, .wp-adminify #wpbody-content #your-profile #destroy-sessions:hover,
            .wp-adminify .is-primary:not(.wp-editor-wrap button, #adminify-data-saved-message), .wp-adminify--folder-widget .folder--header a, .wp-adminify.themes-php #wpbody-content .theme-browser .theme .theme-actions .button:not(.activate), .wp-adminify.plugin-install-php #wpbody-content .plugin-card .plugin-card-top .action-links .plugin-action-buttons .button.activate-now, .wp-adminify.plugin-install-php #wpbody-content .plugin-card .plugin-card-top .action-links .plugin-action-buttons .button.install-now, .wp-adminify #file-editor-warning .file-editor-warning-content p .button.file-editor-warning-dismiss, .wp-adminify .privacy-settings-accordion-actions button, .wp-adminify #wpbody-content .metabox-holder .postbox-container .postbox-header + .inside .button:not(.rwmb-meta-box .rwmb-field .rwmb-input .wp-picker-container .button.wp-color-result), .wp-adminify #wpbody-content .metabox-holder .postbox-container .postbox-header + .inside input[type=submit], .wp-adminify #wpbody-content .page-title-action, .wp-adminify #wpbody-content .interface-interface-skeleton__header .edit-post-header .edit-post-header__settings button.editor-post-publish-button__button, .wp-adminify #wpbody-content .metabox-holder .postbox-header + .inside input[type=submit], .wp-adminify #wpbody-content input[type=submit]:not(.actions .button, #create-page), .wp-adminify #wpbody-content .metabox-holder .postbox-header + .inside .button:not(.wp-editor-wrap button, .rwmb-meta-box .rwmb-field .rwmb-input .wp-picker-container .button.wp-color-result, .rwmb-field .rwmb-input .wp-picker-container .wp-picker-input-wrap .wp-picker-clear), .wp-adminify .button-primary:not(.wp-editor-wrap button), .wp-customizer .wp-full-overlay-sidebar .control-panel-themes .button, .wp-adminify.themes-php #wpbody-content .theme-browser .theme:not(.add-new-theme) .more-details, .wp-adminify #wpbody-content .subsubsub li a .count, .wp-adminify #e-admin-top-bar-root .page-title-action, .wp-adminify #wpbody-content .elementor-button.elementor-button-success, .wp-adminify .elementor-button-go-pro, .wp-adminify .health-check-body .site-health-view-passed, .wp-adminify .health-check-body .site-health-copy-buttons button, .wp-adminify #wpbody-content #documentation #docs-lookup:not([disabled]), .wp-adminify #wpbody-content .form-table.permalink-structure .available-structure-tags button.active, .wp-adminify #wpadminify-admin-columns .columns.is-desktop button{';

			if ( isset( $button_primary_color ) ) {
				$jltwp_adminify_output_body_css .= 'background-color: ' . esc_attr( $button_primary_color ) . ' !important;';
				$jltwp_adminify_output_body_css .= 'border: 1px solid ' . esc_attr( $button_primary_color ) . ' !important;';
			}
			if ( isset( $button_secondary_color ) ) {
				$jltwp_adminify_output_body_css .= 'color: ' . esc_attr( $button_secondary_color ) . ' !important;';
			}

			$jltwp_adminify_output_body_css .= '}';

			// for link
			if ( $button_primary_color ) {
				$jltwp_adminify_output_body_css .= '.wp-adminify .components-button.is-tertiary:not(.edit-site-navigation-panel__back-to-dashboard), .wp-adminify #e-dashboard-overview .e-overview__header .button:hover .dashicons, .wp-adminify.plugin-install-php #wpbody-content .plugin-card .plugin-card-top .action-links .plugin-action-buttons .open-plugin-details-modal, .wp-adminify #wpbody-content .widefat.importers .importer-item .importer-action a{
                    color: ' . esc_attr( $button_primary_color ) . ' !important;
                }';
				$jltwp_adminify_output_body_css .= '.wp-adminify #wpbody-content .health-check-body .site-health-view-passed:hover .icon{
                    border-color: ' . esc_attr( $button_primary_color ) . ' !important;
                }';
			}

			// Primary Button Fill Hover Color
			$jltwp_adminify_output_body_css .= '.wp-adminify #wpbody-content .actions input[type=submit], .wp-adminify #wpbody-content .interface-interface-skeleton__header .edit-post-header .edit-post-header__settings button.block-editor-post-preview__button-toggle, .wp-adminify.block-editor-page .editor-post-publish-panel .components-button.is-secondary, .wp-adminify .media-modal .media-frame-content button:not(.delete-attachment), .wp-adminify .media-upload-form .drag-drop-inside #plupload-browse-button, .wp-adminify #wp-media-grid .media-frame .uploader-inline-content button.browser, .wp-adminify .is-secondary:not(.wp-editor-wrap button), .wp-adminify #wpbody-content #createuser .wp-generate-pw, .wp-adminify #wpbody-content #createuser .wp-hide-pw, .wp-adminify #wpbody-content #your-profile .wp-generate-pw, .wp-adminify .button-secondary:not(.wp-editor-wrap button), .wp-adminify #wpbody-content input[type=submit]#create-page, .wp-adminify.themes-php #wpbody-content .theme-browser .theme:not(.add-new-theme) .theme-actions .button.activate, .wp-adminify .media-modal .media-frame-content .actions a, .wp-adminify .media-frame-content .wp-filter button.select-mode-toggle-button, .wp-adminify #wpbody-content #your-profile #destroy-sessions, .wp-adminify #wpbody-content #documentation #docs-lookup[disabled],
            .wp-adminify .is-primary:not(.wp-editor-wrap button, #adminify-data-saved-message):hover, .wp-adminify--folder-widget .folder--header a:hover, .wp-adminify.themes-php #wpbody-content .theme-browser .theme .theme-actions .button:not(.activate):hover, .wp-adminify.plugin-install-php #wpbody-content .plugin-card .plugin-card-top .action-links .plugin-action-buttons .button.activate-now:hover, .wp-adminify.plugin-install-php #wpbody-content .plugin-card .plugin-card-top .action-links .plugin-action-buttons .button.install-now:hover, .wp-adminify #file-editor-warning .file-editor-warning-content p .button.file-editor-warning-dismiss:hover, .wp-adminify .privacy-settings-accordion-actions button:hover, .wp-adminify #wpbody-content .metabox-holder .postbox-container .postbox-header + .inside .button:not(.rwmb-meta-box .rwmb-field .rwmb-input .wp-picker-container .button.wp-color-result):hover, .wp-adminify #wpbody-content .metabox-holder .postbox-container .postbox-header + .inside input[type=submit]:hover, .wp-adminify #wpbody-content .page-title-action:hover, .wp-adminify #wpbody-content .interface-interface-skeleton__header .edit-post-header .edit-post-header__settings button.editor-post-publish-button__button:hover, .wp-adminify #wpbody-content .metabox-holder .postbox-header + .inside input[type=submit]:hover, .wp-adminify #wpbody-content input[type=submit]:not(.actions .button, #create-page):hover, .wp-adminify #wpbody-content .metabox-holder .postbox-header + .inside .button:not(.wp-editor-wrap button, .rwmb-meta-box .rwmb-field .rwmb-input .wp-picker-container .button.wp-color-result, .rwmb-field .rwmb-input .wp-picker-container .wp-picker-input-wrap .wp-picker-clear):hover, .wp-adminify .button-primary:not(.wp-editor-wrap button):hover, .wp-customizer .wp-full-overlay-sidebar .control-panel-themes .button:hover, .wp-adminify #wpbody-content .subsubsub li a, .wp-adminify #e-admin-top-bar-root .page-title-action:hover, .wp-adminify #wpbody-content .elementor-button.elementor-button-success:hover, .wp-adminify .elementor-button-go-pro:hover, .wp-adminify .health-check-body .site-health-view-passed:hover, .wp-adminify .health-check-body .site-health-copy-buttons button:hover, .wp-adminify #wpbody-content #documentation #docs-lookup:not([disabled]):hover, .wp-adminify #wpadminify-admin-columns .columns.is-desktop button:hover{';

			if ( isset( $button_primary_color ) ) {
				$jltwp_adminify_output_body_css .= 'color: ' . esc_attr( $button_primary_color ) . ' !important;';
				$jltwp_adminify_output_body_css .= 'border: 1px solid ' . esc_attr( $button_primary_color ) . ' !important;';
			}
			if ( isset( $button_secondary_color ) ) {
				$jltwp_adminify_output_body_css .= 'background-color: ' . esc_attr( $button_secondary_color ) . ' !important;';
			}
			$jltwp_adminify_output_body_css .= '}';
		}

		// Danger Button Settings
		$danger_button_primary_color   = ! empty( $this->options['admin_danger_button_color']['primary_color'] ) ? $this->options['admin_danger_button_color']['primary_color'] : '#c30052';
		$danger_button_secondary_color = ! empty( $this->options['admin_danger_button_color']['secondary_color'] ) ? $this->options['admin_danger_button_color']['secondary_color'] : '#fff';

		// Danger Button Fill Color
		if ( $danger_button_primary_color || $danger_button_secondary_color ) {
			$jltwp_adminify_output_body_css .= '.wp-adminify.adminify-ui .media-modal .media-frame-content .actions .delete-attachment:hover, .wp-adminify.adminify-ui .media-frame-content .media-toolbar .media-toolbar-secondary .delete-selected-button:hover,
            .wp-adminify.adminify-ui .clear-button .components-panel .components-panel__body button.is-destructive, .wp-adminify.adminify-ui #wpbody-content .interface-interface-skeleton__body .components-panel .components-panel__body button.is-destructive{';

			if ( isset( $danger_button_primary_color ) ) {
				$jltwp_adminify_output_body_css .= 'background-color: ' . esc_attr( $danger_button_primary_color ) . ' !important;';
				$jltwp_adminify_output_body_css .= 'border: 1px solid ' . esc_attr( $danger_button_primary_color ) . ' !important;';
			}
			if ( isset( $danger_button_secondary_color ) ) {
				$jltwp_adminify_output_body_css .= 'color: ' . esc_attr( $danger_button_secondary_color ) . ' !important;';
			}

			$jltwp_adminify_output_body_css .= '}';

			// Danger Button Fill Hover Color
			$jltwp_adminify_output_body_css .= '.wp-adminify.adminify-ui .media-modal .media-frame-content .actions .delete-attachment, .wp-adminify.adminify-ui .media-frame-content .media-toolbar .media-toolbar-secondary .delete-selected-button,
            .wp-adminify.adminify-ui .clear-button .components-panel .components-panel__body button.is-destructive:hover, .wp-adminify.adminify-ui #wpbody-content .interface-interface-skeleton__body .components-panel .components-panel__body button.is-destructive:hover{';

			if ( isset( $danger_button_secondary_color ) ) {
				$jltwp_adminify_output_body_css .= 'background-color: ' . esc_attr( $danger_button_secondary_color ) . ' !important;';
			}
			if ( isset( $danger_button_primary_color ) ) {
				$jltwp_adminify_output_body_css .= 'color: ' . esc_attr( $danger_button_primary_color ) . ' !important;';
				$jltwp_adminify_output_body_css .= 'border: 1px solid ' . esc_attr( $danger_button_primary_color ) . ' !important;';
			}

			$jltwp_adminify_output_body_css .= '}';

			$jltwp_adminify_output_body_css .= '.wp-adminify #wpbody-content .components-button.is-primary.is-busy{
                background-image: linear-gradient(-45deg, ' . $button_secondary_color . ' 33%, ' . $button_primary_color . ' 33%, ' . $button_primary_color . ' 70%, ' . $button_secondary_color . ' 70%);
            }';
		}

		$jltwp_adminify_output_body_css .= '.wp-adminify #wpbody-content .subsubsub li a .count{
            border: 0 !important;
        }';
		$jltwp_adminify_output_body_css .= '.wp-adminify #wpbody-content .subsubsub li a:not(.current){
            border-color: #E5E5E5 !important;
        }';

		// Combine the values from above and minifiy them.
		$jltwp_adminify_output_body_css = preg_replace( '#/\*.*?\*/#s', '', $jltwp_adminify_output_body_css );
		$jltwp_adminify_output_body_css = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $jltwp_adminify_output_body_css );
		$jltwp_adminify_output_body_css = preg_replace( '/\s\s+(.*)/', '$1', $jltwp_adminify_output_body_css );

		if ( ! empty( $this->options['admin_ui'] ) ) {
			wp_add_inline_style( 'wp-adminify-admin', wp_strip_all_tags( $jltwp_adminify_output_body_css ) );
		} else {
			wp_add_inline_style( 'wp-adminify-default-ui', wp_strip_all_tags( $jltwp_adminify_output_body_css ) );
		}
	}
}
