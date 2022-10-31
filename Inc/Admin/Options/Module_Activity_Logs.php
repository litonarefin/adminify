<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

if ( ! class_exists( 'Module_Activity_Logs' ) ) {
	class Module_Activity_Logs extends AdminSettingsModel {

		public function __construct() {
			$this->jltwp_activity_logs_settings();
		}

		public function get_defaults() {
			return [
				'activity_logs_user_roles'   => [],
				'activity_logs_history_data' => 30,
			];
		}

		/**
		 * User Roles
		 */
		public function activity_logs_fields( &$fields ) {
			$fields[] = [
				'type'    => 'subheading',
				'content' => Utils::adminfiy_help_urls(
					__( 'Activity Logs Settings', 'adminify' ),
					'https://wpadminify.com/kb/organize-media-library-pages-posts-post-type-using-folder/',
					'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
					'https://www.facebook.com/groups/jeweltheme',
					'https://wpadminify.com/support/'
				),
			];
			$fields[] = [
				'id'          => 'activity_logs_user_roles',
				'type'        => 'select',
				'title'       => __( 'Disable for', 'adminify' ),
				'placeholder' => __( 'Select User roles you want to show', 'adminify' ),
				'options'     => 'roles',
				'multiple'    => true,
				'chosen'      => true,
				'default'     => $this->get_default_field( 'activity_logs_user_roles' ),
			];
			$fields[] = [
				'id'       => 'activity_logs_history_data',
				'type'     => 'number',
				'title'    => __( 'Keep Activity Logs Data', 'adminify' ),
				'subtitle' => __( 'How many days Activity Logs data will store', 'adminify' ),
				'after'    => '<span style="padding-left:10px">days</span>',
				'default'  => $this->get_default_field( 'activity_logs_history_data' ),
			];
		}




		/**
		 * Module: Activity Logs
		 *
		 * @return void
		 */
		public function jltwp_activity_logs_settings() {
			if ( ! class_exists( 'ADMINIFY' ) ) {
				return;
			}

			$fields = [];
			$this->activity_logs_fields( $fields );

			// Activity Logs Order Section
			\ADMINIFY::createSection(
				$this->prefix,
				[
					'title'  => __( 'Activity Logs', 'adminify' ),
					'id'     => 'module_activity_logs_section',
					'parent' => 'module_settings',
					'icon'   => 'fas fa-history',
					'fields' => $fields,
				]
			);
		}
	}
}
