<?php

namespace WPAdminify\Inc\Modules\ActivityLogs;

use WPAdminify\Inc\Modules\ActivityLogs\Inc\DB_Table;
use WPAdminify\Inc\Modules\ActivityLogs\Inc\Api;
use WPAdminify\Inc\Modules\ActivityLogs\Inc\Hooks;
use WPAdminify\Inc\Modules\ActivityLogs\Inc\Adminify_Activity_Log_List_Table;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WPAdminify
 *
 * @package Activity Logs
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class ActivityLogs {

	public $url;

	// Adminify List Table
	protected $_list_table = null;
	protected $_screens    = [];

	public static $instance;

	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public static function get_log_table() {
		global $wpdb;
		return $wpdb->prefix . 'adminify_activity_logs';
	}

	public function __construct() {
		global $wpdb;
		$this->url = WP_ADMINIFY_URL . 'Inc/Modules/ActivityLogs';
		if ( is_admin() ) {
			add_action( 'admin_menu', [ $this, 'jltwp_adminify_activity_logs_submenu' ], 52 );
			add_action( 'admin_enqueue_scripts', [ $this, 'jltwp_adminify_enqueue_scripts' ] );
			$wpdb->adminify_activity_logs = self::get_log_table();

			new DB_Table();

			$this->api   = new Api();
			$this->hooks = Hooks::get_instance();
		}

		add_action( 'admin_init', [ $this, 'init_actions' ] );
	}

	public function jltwp_adminify_activity_logs_submenu() {
		$this->_screens['adminify_log'] = add_submenu_page(
			'wp-adminify-settings',
			esc_html__( 'Activity Logs by WP Adminify', 'adminify' ),
			esc_html__( 'Activity Logs', 'adminify' ),
			apply_filters( 'jltwp_adminify_capability', 'manage_options' ),
			'adminify-activity-logs', // Page slug, will be displayed in URL
			[ $this, 'jltwp_adminify_activity_logs_contents' ]
		);

		// Making sure that we've created Instance
		add_action( 'load-' . $this->_screens['adminify_log'], [ $this, 'jltwp_adminify_get_list_table' ] );
	}

	public function init_actions() {
		if ( empty( $_GET['page'] ) || $_GET['page'] !== 'adminify-activity-logs' ) {
			return;
		}
		if ( empty( $_GET['action'] ) || $_GET['action'] == -1 ) {
			return;
		}
		if ( empty( $_GET['log_id'] ) ) {
			return;
		}

		$action = $_GET['action'];
		$log_id = (int) $_GET['log_id'];

		$sendback = admin_url( 'admin.php?page=adminify-activity-logs' );

		if ( $action == 'delete' ) {
			check_admin_referer( 'delete-log_' . $log_id );
			$adminify_activity_logs = self::get_instance();
			$adminify_activity_logs->api->delete( $log_id );
		}

		wp_redirect( $sendback );
		exit;
	}

	/**
	 * Scripst / Styles
	 */
	public function jltwp_adminify_enqueue_scripts() {
		$screen = get_current_screen();

		// Load Scripts/Styles only Activity Logs Page
		if ( 'wp-adminify_page_adminify-activity-logs' != $screen->id ) {
			return;
		}

		if ( $screen->id == 'wp-adminify_page_adminify-activity-logs' ) {
			$this->admin_head_css();
		}
	}

	/**
	 * Admin head CSS
	 *
	 * @return void
	 */
	public function admin_head_css() {
		$activity_custom_css  = '';
		$activity_custom_css .= '.wp-adminify_page_adminify-activity-logs .label {
                font-size: inherit !important;
            }

            #record-actions-submit {
                margin-top: 10px;
            }

            .wp-adminify-pt {
                color: #ffffff;
                padding: 1px 4px;
                margin: 0 5px;
                font-size: 1em;
                border-radius: 3px;
                background: #808080;
                font-family: inherit;
            }

            .wp-adminify_page_adminify-activity-logs .manage-column {
                width: auto;
            }

            .wp-adminify_page_adminify-activity-logs .column-description {
                width: 20%;
            }

            #adminmenu #wp-adminify_page_adminify-activity-logs div.wp-menu-image:before {
                content: "\f321";
            }

            @media (max-width: 767px) {
                .wp-adminify_page_adminify-activity-logs .manage-column {
                    width: auto;
                }

                .wp-adminify_page_adminify-activity-logs .column-date,
                .wp-adminify_page_adminify-activity-logs .column-author {
                    display: table-cell;
                    width: auto;
                }

                .wp-adminify_page_adminify-activity-logs .column-ip,
                .wp-adminify_page_adminify-activity-logs .column-description,
                .wp-adminify_page_adminify-activity-logs .column-label {
                    display: none;
                }

                .wp-adminify_page_adminify-activity-logs .column-author .avatar {
                    display: none;
                }
            }';

		$activity_custom_css = preg_replace( '#/\*.*?\*/#s', '', $activity_custom_css );
		$activity_custom_css = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $activity_custom_css );
		$activity_custom_css = preg_replace( '/\s\s+(.*)/', '$1', $activity_custom_css );

		if ( ! empty( $this->options['admin_ui'] ) ) {
			wp_add_inline_style( 'wp-adminify-admin', wp_strip_all_tags( $activity_custom_css ) );
		} else {
			wp_add_inline_style( 'wp-adminify-default-ui', wp_strip_all_tags( $activity_custom_css ) );
		}
	}

	/**
	 * Get List Table
	 */
	public function jltwp_adminify_get_list_table() {
		if ( is_null( $this->_list_table ) ) {
			$this->_list_table = new Adminify_Activity_Log_List_Table( [ 'screen' => $this->_screens['adminify_log'] ] );
			do_action( 'wp_adminify_activity_page', $this->_list_table );
		}

		return $this->_list_table;
	}

	public function jltwp_adminify_activity_logs_contents() {
		$this->jltwp_adminify_get_list_table()->prepare_items();
		?>
		<div class="wrap">
			<h1 class="wp-adminify-page-title"><?php _ex( 'Activity Log', 'Page and Menu Title', 'adminify' ); ?></h1>

			<form id="activity-filter" method="get">
				<input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ); ?>" />
				<?php $this->jltwp_adminify_get_list_table()->display(); ?>
			</form>
		</div>

		<?php
	}
}
