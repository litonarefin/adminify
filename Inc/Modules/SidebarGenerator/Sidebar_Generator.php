<?php

namespace WPAdminify\Inc\Modules\SidebarGenerator;

use WPAdminify\Inc\Utils;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * WPAdminify
 *
 * @package Sidebar Generator
 *
 * @author WP Adminify <support@wpadminify.com>
 */

class Sidebar_Generator extends Sidebar_Generator_Model {

	private $url;
	private $options;
	public function __construct() {
		$this->url     = WP_ADMINIFY_URL . 'Inc/Modules/SidebarGenerator';
		$this->options = ( new Sidebar_Generator_Settings() )->get();

		add_action( 'admin_enqueue_scripts', [ $this, 'sidebar_generator_scripts' ], 99 );
		add_action( 'admin_init', [ $this, 'get_all_sidebars' ] );
		add_action( 'widgets_init', [ $this, 'render_generate_sidebars' ] );
	}


	/**
	 * Render Sidebars
	 *
	 * @return void
	 */
	public function render_generate_sidebars() {
		// Make sure if we have valid sidebars data
		if ( ! empty( $this->options['sidebars'] ) && is_array( $this->options['sidebars'] ) ) {
			foreach ( $this->options['sidebars'] as $sidebar ) {
				$sidebar_id  = str_replace( ' ', '_', strtolower( $sidebar['sidebar_title'] ) );
				$id          = 'adminify-' . $sidebar_id;
				$name        = $sidebar['sidebar_title'];
				$description = $sidebar['sidebar_desc'];
				$alias       = $sidebar_id;

				$sidebar_class = Utils::convert_name_to_class( $alias );

				register_sidebar(
					[
						'name'          => $name,
						'id'            => "generated_sidebar-$id",
						'description'   => $description,
						'before_widget' => '<div id="%1$s" class="widget scg_widget ' . $sidebar_class . ' %2$s">',
						'after_widget'  => '</div>',
						'before_title'  => '<h4 class="widgetTitle">',
						'after_title'   => '</h4>',
					]
				);
			}
		}
	}

	/**
	 * Sidebar Generator Script
	 *
	 * @return void
	 */
	public function sidebar_generator_scripts() {
		global $pagenow;

		if ( ( 'admin.php' === $pagenow ) && ( 'wp-adminify-sidebar-generator' === $_GET['page'] ) ) {
			$this->sidebar_generator_option_style();
		}
	}

	public function sidebar_generator_option_style() {
		echo '<style>.wp-adminify-sidebar-generator .adminify-container{ max-width:80%; margin:0 auto;} .wp-adminify-sidebar-generator .adminify-header-inner{padding:0;}.wp-adminify-sidebar-generator .adminify-field-subheading{font-size:20px; padding-left:0;}.wp-adminify-sidebar-generator .adminify-nav,.wp-adminify-sidebar-generator .adminify-search,.wp-adminify-sidebar-generator .adminify-footer,.wp-adminify-sidebar-generator .adminify-reset-all,.wp-adminify-sidebar-generator .adminify-expand-all,.wp-adminify-sidebar-generator .adminify-header-left,.wp-adminify-sidebar-generator .adminify-reset-section,.wp-adminify-sidebar-generator .adminify-nav-background{display: none !important;}.wp-adminify-sidebar-generator .adminify-nav-normal + .adminify-content{margin-left: 0;}

            /* If needed for white top-bar */
            .wp-adminify-sidebar-generator .adminify-header-inner {
                background-color: #fafafa !important;
                border-bottom: 1px solid #f5f5f5;
            }
        </style>';
	}

	/**
	 * Get All Sidebars
	 *
	 * @return void
	 */
	public function get_all_sidebars() {
		global $wp_registered_sidebars;

		$sidebar_list = [];
		foreach ( $wp_registered_sidebars as $key => $values ) {
			$sidebar_list[ $key ] = [
				'sidebar_name' => $values['name'],
				'sidebar_id'   => $values['id'],
				'sidebar_desc' => $values['description'],
			];
		}
	}
}
