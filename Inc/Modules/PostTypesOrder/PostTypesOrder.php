<?php

namespace WPAdminify\Inc\Modules\PostTypesOrder;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettings;
use WPAdminify\Inc\Admin\AdminSettingsModel;
use WPAdminify\Inc\Modules\PostTypesOrder\PostTypesOrderWalker;

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Adminify
 *
 * @package WP Adminify: Post Types Order
 *
 * @author WP Adminify <support@wpadminify.com>
 */

class PostTypesOrder extends AdminSettingsModel {

	public $url;

	public function __construct() {
		global $pagenow, $typenow;
		$this->url     = WP_ADMINIFY_URL . 'Inc/Modules/PostTypesOrder';
		$this->options = (array) AdminSettings::get_instance()->get();

		// Check Access for User roles
		$restrict_for = ! empty( $this->options['pto_user_roles'] ) ? $this->options['pto_user_roles'] : '';
		if ( $restrict_for ) {
			return;
		}

		// if (empty($this->adminify_pto_get_options()) || $pagenow !== 'upload.php') return;

		// Admin Init
		if ( empty( $_GET ) ) {
			add_action( 'admin_init', [ $this, 'jltwp_adminify_refresh' ] );
		}

		add_action( 'admin_init', [ $this, 'adminify_pto_load_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'adminify_pto_css' ], 99 );

		// sortable ajax action
		add_action( 'wp_ajax_update_post_types_order', [ $this, 'adminify_pto_update_order' ] );
		add_action( 'wp_ajax_update_post_types_taxonomy_order', [ $this, 'adminify_pto_update_taxonomy' ] );

		// reorder post types
		add_action( 'pre_get_posts', [ $this, 'adminify_pto_pre_get_posts' ] );

		add_filter( 'get_previous_post_where', [ $this, 'adminify_pto_previous_post_where' ] );
		add_filter( 'get_previous_post_sort', [ $this, 'adminify_pto_previous_post_sort' ] );
		add_filter( 'get_next_post_where', [ $this, 'adminify_pto_next_post_where' ] );
		add_filter( 'get_next_post_sort', [ $this, 'adminify_pto_next_post_sort' ] );

		// reorder taxonomies
		add_filter( 'get_terms_orderby', [ $this, 'adminify_pto_get_terms_orderby' ], 10, 3 );
		add_filter( 'wp_get_object_terms', [ $this, 'adminify_pto_get_object_terms' ], 10, 3 );
		add_filter( 'get_terms', [ $this, 'adminify_pto_get_object_terms' ], 10, 3 );

		// reorder sites
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			add_action( 'wp_ajax_update_post_types_order_sites', [ $this, 'adminify_pto_update_sites' ] );

			// networkadmin
			if (
				empty( $_SERVER['QUERY_STRING'] ) ||
				( ! empty( $_SERVER['QUERY_STRING'] ) &&
					'action=deleteblog' !== $_SERVER['QUERY_STRING'] && // delete
					'action=allblogs' !== $_SERVER['QUERY_STRING']         // delete all
				)
			) {

				// call from 'get_sites'
				add_filter( 'sites_clauses', [ $this, 'adminify_pto_sites_clauses' ], 10, 1 );

				add_action( 'admin_init', [ $this, 'adminify_pto_refresh_network' ] );

				// adminbar sites reorder
				add_filter( 'get_blogs_of_user', [ $this, 'adminify_pto_get_blogs_of_user' ], 10, 3 );
			}

			// before wp v4.6.0 * wp_get_sites
			add_action( 'init', [ $this, 'adminify_pto_refresh_front_network' ] );
		}
	}




	public function adminiy_pto_media_list( $args = '' ) {
		$defaults = [
			'depth'       => -1,
			'date_format' => get_option( 'date_format' ),
			'child_of'    => 0,
			'sort_column' => 'menu_order',
			'post_status' => 'any',
		];

		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );

		$output = '';

		$r['exclude'] = implode( ',', apply_filters( 'wp_list_pages_excludes', [] ) );

		// Query pages.
		$r['hierarchical'] = 0;
		$args              = [
			'sort_column'    => 'menu_order',
			'post_type'      => $post_type,
			'posts_per_page' => -1,
			'post_status'    => 'any',
			'orderby'        => [
				'menu_order' => 'ASC',
				'post_date'  => 'DESC',
			],
		];

		$the_query = new \WP_Query( $args );
		$pages     = $the_query->posts;

		if ( ! empty( $pages ) ) {
			$output .= $this->walkTree( $pages, $r['depth'], $r );
		}

		echo wp_kses_post( $output );
	}

	public function walkTree( $pages, $depth, $r ) {
		$walker = new PostTypesOrderWalker();

		$args = [ $pages, $depth, $r ];
		return call_user_func_array( [ &$walker, 'walk' ], $args );
	}


	public function jltwp_adminify_refresh() {

		// global $wp_post_types;
		// $pto_obj = $wp_post_types['attachment'];

		global $wpdb;
		$objects = $this->adminify_pto_get_options();
		$tags    = $this->adminify_pto_get_options_taxonomies();

		if ( ! empty( $objects ) ) {
			foreach ( $objects as $object ) {
				$result = $wpdb->get_results(
					"
					SELECT count(*) as cnt, max(menu_order) as max, min(menu_order) as min
					FROM $wpdb->posts
					WHERE post_type = '" . $object . "' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
				"
				);
				if ( $result[0]->cnt == 0 || $result[0]->cnt == $result[0]->max ) {
					continue;
				}

				$results = $wpdb->get_results(
					"
					SELECT ID
					FROM $wpdb->posts
					WHERE post_type = '" . $object . "' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
					ORDER BY menu_order ASC
				"
				);
				foreach ( $results as $key => $result ) {
					$wpdb->update( $wpdb->posts, [ 'menu_order' => $key + 1 ], [ 'ID' => $result->ID ] );
				}
			}
		}

		if ( ! empty( $tags ) ) {
			foreach ( $tags as $taxonomy ) {
				$result = $wpdb->get_results(
					"
					SELECT count(*) as cnt, max(term_order) as max, min(term_order) as min
					FROM $wpdb->terms AS terms
					INNER JOIN $wpdb->term_taxonomy AS term_taxonomy ON ( terms.term_id = term_taxonomy.term_id )
					WHERE term_taxonomy.taxonomy = '" . $taxonomy . "'
				"
				);
				if ( $result[0]->cnt == 0 || $result[0]->cnt == $result[0]->max ) {
					continue;
				}

				$results = $wpdb->get_results(
					"
					SELECT terms.term_id
					FROM $wpdb->terms AS terms
					INNER JOIN $wpdb->term_taxonomy AS term_taxonomy ON ( terms.term_id = term_taxonomy.term_id )
					WHERE term_taxonomy.taxonomy = '" . $taxonomy . "'
					ORDER BY term_order ASC
				"
				);
				foreach ( $results as $key => $result ) {
					$wpdb->update( $wpdb->terms, [ 'term_order' => $key + 1 ], [ 'term_id' => $result->term_id ] );
				}
			}
		}
	}



	function adminify_pto_pre_get_posts( $wp_query ) {
		$objects = $this->adminify_pto_get_options();
		if ( empty( $objects ) ) {
			return false;
		}

		/**
		 * for Admin
		 *
		 * @default
		 * post pto: [order] => null(desc) [orderby] => null(date)
		 * page: [order] => asc [orderby] => menu_order title
		 */

		if ( is_admin() ) {

			// $wp_query->query['post_type']=post
			if ( isset( $wp_query->query['post_type'] ) && ! isset( $_GET['orderby'] ) ) {
				if ( in_array( $wp_query->query['post_type'], $objects ) ) {
					$wp_query->set( 'orderby', 'menu_order' );
					$wp_query->set( 'order', 'ASC' );
				}
			}
		} else {
			$active = false;

			// page or custom post types
			if ( isset( $wp_query->query['post_type'] ) ) {
				// exclude array()
				if ( ! is_array( $wp_query->query['post_type'] ) ) {
					if ( in_array( $wp_query->query['post_type'], $objects ) ) {
						$active = true;
					}
				}
				// post
			} else {
				if ( in_array( 'post', $objects ) ) {
					$active = true;
				}
			}

			if ( ! $active ) {
				return false;
			}

			// get_posts()
			if ( isset( $wp_query->query['suppress_filters'] ) ) {
				if ( $wp_query->get( 'orderby' ) == 'date' || $wp_query->get( 'orderby' ) == 'menu_order' ) {
					$wp_query->set( 'orderby', 'menu_order' );
					$wp_query->set( 'order', 'ASC' );
				} elseif ( $wp_query->get( 'orderby' ) == 'default_date' ) {
					$wp_query->set( 'orderby', 'date' );
				}
				// WP_Query( contain main_query )
			} else {
				if (
					! $wp_query->get( 'orderby' )
				) {
					$wp_query->set( 'orderby', 'menu_order' );
				}
				if (
					! $wp_query->get( 'order' )
				) {
					$wp_query->set( 'order', 'ASC' );
				}
			}
		}
	}


	public function adminify_pto_update_order() {
		global $wpdb;
		$data = [];
		parse_str( $_POST['order'], $data );

		if ( ! is_array( $data ) ) {
			return false;
		}

		// get objects per now page
		$id_arr = [];
		foreach ( $data as $key => $values ) {
			foreach ( $values as $position => $id ) {
				$id_arr[] = $id;
			}
		}

		// get menu_order of objects per now page
		$menu_order_arr = [];
		foreach ( $id_arr as $key => $id ) {
			$results = $wpdb->get_results( "SELECT menu_order FROM $wpdb->posts WHERE ID = " . intval( $id ) );
			foreach ( $results as $result ) {
				$menu_order_arr[] = $result->menu_order;
			}
		}

		// maintains key association = no
		sort( $menu_order_arr );

		foreach ( $data as $key => $values ) {
			foreach ( $values as $position => $id ) {
				$wpdb->update( $wpdb->posts, [ 'menu_order' => $menu_order_arr[ $position ] ], [ 'ID' => intval( $id ) ] );
			}
		}

		// same number check
		$post_type = get_post_type( $id );
		$sql       = "SELECT COUNT(menu_order) AS mo_count, post_type, menu_order FROM $wpdb->posts
				 WHERE post_type = '{$post_type}' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
				 AND menu_order > 0 GROUP BY post_type, menu_order HAVING (mo_count) > 1";
		$results   = $wpdb->get_results( $sql );
		if ( count( $results ) > 0 ) {

			// menu_order refresh
			$sql     = "SELECT ID, menu_order FROM $wpdb->posts
			 WHERE post_type = '{$post_type}' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
			 AND menu_order > 0 ORDER BY menu_order";
			$results = $wpdb->get_results( $sql );
			foreach ( $results as $key => $result ) {
				$view_posi = array_search( $result->ID, $id_arr, true );
				if ( $view_posi === false ) {
					$view_posi = 999;
				}
				$sort_key              = ( $result->menu_order * 1000 ) + $view_posi;
				$sort_ids[ $sort_key ] = $result->ID;
			}
			ksort( $sort_ids );
			$oreder_no = 0;
			foreach ( $sort_ids as $key => $id ) {
				$oreder_no = $oreder_no + 1;
				$wpdb->update( $wpdb->posts, [ 'menu_order' => $oreder_no ], [ 'ID' => intval( $id ) ] );
			}
		}
	}

	public function adminify_pto_update_taxonomy() {
		global $wpdb;

		parse_str( $_POST['order'], $data );

		if ( ! is_array( $data ) ) {
			return false;
		}

		$id_arr = [];
		foreach ( $data as $key => $values ) {
			foreach ( $values as $position => $id ) {
				$id_arr[] = $id;
			}
		}

		$menu_order_arr = [];
		foreach ( $id_arr as $key => $id ) {
			$results = $wpdb->get_results( "SELECT term_order FROM $wpdb->terms WHERE term_id = " . intval( $id ) );
			foreach ( $results as $result ) {
				$menu_order_arr[] = $result->term_order;
			}
		}
		sort( $menu_order_arr );

		foreach ( $data as $key => $values ) {
			foreach ( $values as $position => $id ) {
				$wpdb->update( $wpdb->terms, [ 'term_order' => $menu_order_arr[ $position ] ], [ 'term_id' => intval( $id ) ] );
			}
		}

		// same number check
		$term     = get_term( $id );
		$taxonomy = $term->taxonomy;
		$sql      = "SELECT COUNT(term_order) AS to_count, term_order
			FROM $wpdb->terms AS terms
			INNER JOIN $wpdb->term_taxonomy AS term_taxonomy ON ( terms.term_id = term_taxonomy.term_id )
			WHERE term_taxonomy.taxonomy = '" . $taxonomy . "'GROUP BY taxonomy, term_order HAVING (to_count) > 1";
		$results  = $wpdb->get_results( $sql );
		if ( count( $results ) > 0 ) {
			// term_order refresh
			$sql     = "SELECT terms.term_id, term_order
			FROM $wpdb->terms AS terms
			INNER JOIN $wpdb->term_taxonomy AS term_taxonomy ON ( terms.term_id = term_taxonomy.term_id )
			WHERE term_taxonomy.taxonomy = '" . $taxonomy . "'
			ORDER BY term_order ASC";
			$results = $wpdb->get_results( $sql );
			foreach ( $results as $key => $result ) {
				$view_posi = array_search( $result->term_id, $id_arr, true );
				if ( $view_posi === false ) {
					$view_posi = 999;
				}
				$sort_key              = ( $result->term_order * 1000 ) + $view_posi;
				$sort_ids[ $sort_key ] = $result->term_id;
			}
			ksort( $sort_ids );
			$oreder_no = 0;
			foreach ( $sort_ids as $key => $id ) {
				$oreder_no = $oreder_no + 1;
				$wpdb->update( $wpdb->terms, [ 'term_order' => $oreder_no ], [ 'term_id' => $id ] );
			}
		}

		do_action( 'wpadminify_update_post_types_order_taxonomy' );
	}

	public function jltwp_adminify_taxonomy_compare( $a, $b ) {
		if ( $a->term_order == $b->term_order ) {
			return 0;
		}
		return ( $a->term_order < $b->term_order ) ? -1 : 1;
	}

	public function adminify_pto_load_scripts() {
		global $pagenow, $typenow;
		if ( $this->conditional_script_load() || ( $pagenow === 'upload.php' && ( isset( $this->options['pto_media'] ) && $this->options['pto_media'] ) ) ) {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'wp-adminify-post-type-order', $this->url . '/js/post-type-order.js', [ 'jquery' ], WP_ADMINIFY_VER, true );
		}
	}

	public function adminify_pto_css() {
		global $pagenow, $typenow;
		if ( $this->conditional_script_load() || ( $pagenow === 'upload.php' && ( ! empty( $this->options['pto_media'] ) ) ) ) {
			echo '<!-- Start of Post Type and Taxonomy Order --->';
			echo '<style type="text/css">';
			echo '.ui-sortable tr:hover { cursor: move; } .ui-sortable tr.alternate { background-color: #F9F9F9; } .ui-sortable tr.ui-sortable-helper { background-color: #F9F9F9; border-top: 1px solid #DFDFDF; } .ui-sortable-placeholder { display: none; } .wp-list-table { table-layout: auto; width: 100%;}';
			echo '</style>';
			echo '<!-- End of Post Type and Taxonomy Order --->';
		}
	}

	public function conditional_script_load() {
		global $pagenow, $typenow;

		$active = false;

		// Multisite > Sites
		if (
			function_exists( 'is_multisite' )
			&& is_multisite()
			&& $pagenow == 'sites.php'
			// && get_option('adminify_pto_network_sites')
		) {
			return true;
		}

		$objects = $this->adminify_pto_get_options();
		$tags    = $this->adminify_pto_get_options_taxonomies();

		if ( empty( $objects ) && empty( $tags ) ) {
			return false;
		}

		// exclude (sorting, addnew page, edit page)
		if ( isset( $_GET['orderby'] ) || strstr( $_SERVER['REQUEST_URI'], 'action=edit' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) ) {
			return false;
		}

		if ( ! empty( $objects ) ) {
			if ( isset( $_GET['post_type'] ) && ! isset( $_GET['taxonomy'] ) && in_array( $_GET['post_type'], $objects ) ) { // if page or custom post types
				$active = true;
			}
			if ( ! isset( $_GET['post_type'] ) && strstr( $_SERVER['REQUEST_URI'], 'wp-admin/edit.php' ) && in_array( 'post', $objects ) ) { // if post
				$active = true;
			}
		}

		if ( ! empty( $tags ) ) {
			if ( isset( $_GET['taxonomy'] ) && in_array( $_GET['taxonomy'], $tags ) ) {
				$active = true;
			}
		}

		return $active;
	}

	function adminify_pto_get_options() {
		$objects = isset( $this->options['pto_posts'] ) && is_array( $this->options['pto_posts'] ) ? $this->options['pto_posts'] : [];
		return $objects;
	}

	function adminify_pto_get_options_taxonomies() {
		$tags = isset( $this->options['pto_taxonomies'] ) && is_array( $this->options['pto_taxonomies'] ) ? $this->options['pto_taxonomies'] : [];
		return $tags;
	}

	function adminify_pto_previous_post_where( $where ) {
		global $post;

		$objects = $this->adminify_pto_get_options();
		if ( empty( $objects ) ) {
			return $where;
		}

		if ( isset( $post->post_type ) && in_array( $post->post_type, $objects ) ) {
			$current_menu_order = $post->menu_order;
			$where              = str_replace( "p.post_date < '" . $post->post_date . "'", "p.menu_order > '" . $current_menu_order . "'", $where );
		}
		return $where;
	}


	function adminify_pto_previous_post_sort( $orderby ) {
		global $post;

		$objects = $this->adminify_pto_get_options();
		if ( empty( $objects ) ) {
			return $orderby;
		}

		if ( isset( $post->post_type ) && in_array( $post->post_type, $objects ) ) {
			$orderby = 'ORDER BY p.menu_order ASC LIMIT 1';
		}
		return $orderby;
	}


	function adminify_pto_next_post_where( $where ) {
		global $post;

		$objects = $this->adminify_pto_get_options();
		if ( empty( $objects ) ) {
			return $where;
		}

		if ( isset( $post->post_type ) && in_array( $post->post_type, $objects ) ) {
			$current_menu_order = $post->menu_order;
			$where              = str_replace( "p.post_date > '" . $post->post_date . "'", "p.menu_order < '" . $current_menu_order . "'", $where );
		}
		return $where;
	}

	function adminify_pto_next_post_sort( $orderby ) {
		global $post;

		$objects = $this->adminify_pto_get_options();
		if ( empty( $objects ) ) {
			return $orderby;
		}

		if ( isset( $post->post_type ) && in_array( $post->post_type, $objects ) ) {
			$orderby = 'ORDER BY p.menu_order DESC LIMIT 1';
		}
		return $orderby;
	}


	function adminify_pto_get_terms_orderby( $orderby, $args ) {
		if ( is_admin() ) {
			return $orderby;
		}

		$tags = $this->adminify_pto_get_options_taxonomies();

		if (
			! isset( $args['taxonomy'] )
		) {
			return $orderby;
		}

		$taxonomy = $args['taxonomy'];
		if ( ! in_array( $taxonomy, $tags ) ) {
			return $orderby;
		}

		$orderby = 't.term_order';
		return $orderby;
	}

	function adminify_pto_get_object_terms( $terms ) {
		$tags = $this->adminify_pto_get_options_taxonomies();

		if ( is_admin() && isset( $_GET['orderby'] ) ) {
			return $terms;
		}

		foreach ( $terms as $key => $term ) {
			if ( is_object( $term ) && isset( $term->taxonomy ) ) {
				$taxonomy = $term->taxonomy;
				if (
					! in_array( $taxonomy, $tags )
				) {
					return $terms;
				}
			} else {
				return $terms;
			}
		}

		usort(
			$terms,
			[ $this, 'jltwp_adminify_taxonomy_compare' ]
		);
		return $terms;
	}



	public function adminify_pto_sites_clauses( $pieces = [] ) {
		global $blog_id;

		if ( is_admin() ) {
			return $pieces;
		}
		// if (1 != $blog_id) {
		// $current = $blog_id;
		// switch_to_blog(1);
		// $adminify_pto_sites = get_option('adminify_pto_sites');
		// switch_to_blog($current);
		// if (!$adminify_pto_sites) return $pieces;
		// } else {
		// if (!get_option('adminify_pto_sites')) return $pieces;
		// }

		global $wp_version;
		if ( version_compare( $wp_version, '4.6.0' ) >= 0 ) {
			if ( 'blog_id ASC' === $pieces['orderby'] ) {
				$pieces['orderby'] = 'menu_order ASC';
			}
		}
		return $pieces;
	}

	public function adminify_pto_update_sites() {
		global $wpdb;

		parse_str( $_POST['order'], $data );

		if ( ! is_array( $data ) ) {
			return false;
		}

		$id_arr = [];
		foreach ( $data as $key => $values ) {
			foreach ( $values as $position => $id ) {
				$id_arr[] = $id;
			}
		}

		foreach ( $data as $key => $values ) {
			foreach ( $values as $position => $id ) {
				$wpdb->update( $wpdb->prefix . 'blogs', [ 'menu_order' => $position + 1 ], [ 'blog_id' => intval( $id ) ] );
			}
		}

		die();
	}

	/* before wp v4.6.0 */
	public function adminify_pto_refresh_front_network() {
		global $wp_version;
		if ( version_compare( $wp_version, '4.6.0' ) < 0 ) {
			// global $blog_id;
			// if (1 != $blog_id) {
			// $current = $blog_id;
			// switch_to_blog(1);
			// $adminify_pto_sites = get_option('adminify_pto_sites');
			// switch_to_blog($current);
			// if (!$adminify_pto_sites) return;
			// }
			// else {
			// if (!get_option('adminify_pto_sites')) return;
			// }
			add_filter( 'query', [ $this, 'adminify_pto_refresh_front_network_second' ] );
		}
	}

	public function adminify_pto_refresh_network() {
		global $pagenow;
		if ( 'sites.php' === $pagenow && ! isset( $_GET['orderby'] ) ) {
			add_filter( 'query', [ $this, 'adminify_pto_refresh_network_second' ] );
		}
	}


	public function adminify_pto_refresh_network_second( $query ) {
		global $wpdb, $wp_version, $blog_id;

		/**
		 * after wp4.7.0
		 * eq.) SELECT option_name, option_value FROM wp_11_options WHERE autoload = 'yes'
		 */

		// $wpdb->get_varやswitch_to_blog(1)
		if ( version_compare( $wp_version, '4.7.0' ) >= 0 ) {
			if ( 1 !== $blog_id ) {
				return $query;
			}
		}

		// $adminify_pto_sites = get_option('adminify_pto_sites');
		// if (!$adminify_pto_sites) return $query;

		if (
			false !== strpos( $query, "SELECT * FROM $wpdb->blogs WHERE site_id = '1'" ) ||
			false !== strpos( $query, "SQL_CALC_FOUND_ROWS blog_id FROM $wpdb->blogs  WHERE site_id = 1" )
		) {
			if ( false !== strpos( $query, ' LIMIT ' ) ) {
				$query = preg_replace( '/^(.*) LIMIT(.*)$/', '$1 ORDER BY menu_order ASC LIMIT $2', $query );
			} else {
				$query .= ' ORDER BY menu_order ASC';
			}
		}
		return $query;
	}


	public function adminify_pto_get_blogs_of_user( $blogs ) {
		// global $blog_id;
		// if (1 != $blog_id) {
		// $current = $blog_id;
		// switch_to_blog(1);
		// $adminify_pto_sites = get_option('adminify_pto_sites');
		// switch_to_blog($current);
		// if (!$adminify_pto_sites) return $blogs;
		// } else {
		// if (!get_option('adminify_pto_sites')) return $blogs;
		// }
		global $wpdb, $wp_version;

		if ( version_compare( $wp_version, '4.6.0' ) >= 0 ) {
			$sites     = get_sites( [] );
			$sort_keys = [];
			foreach ( $sites as $k => $v ) {
				$sort_keys[] = $v->menu_order;
			}
			array_multisort( $sort_keys, SORT_ASC, $sites );

			$blog_list = [];
			foreach ( $blogs as $k => $v ) {
				$blog_list[ $v->userblog_id ] = $v;
			}

			$new = [];
			foreach ( $sites as $k => $v ) {
				if (
					isset( $v->blog_id ) &&
					isset( $blog_list[ $v->blog_id ] ) &&
					is_object( $blog_list[ $v->blog_id ] )
				) {
					$new[] = $blog_list[ $v->blog_id ];
				}
			}
		} else {
			$sites     = wp_get_sites( [ 'limit' => 9999 ] );
			$sort_keys = [];
			foreach ( $sites as $k => $v ) {
				$sort_keys[] = $v['menu_order'];
			}
			array_multisort( $sort_keys, SORT_ASC, $sites );

			$blog_list = [];
			foreach ( $blogs as $k => $v ) {
				$blog_list[ $v->userblog_id ] = $v;
			}

			$new = [];
			foreach ( $sites as $k => $v ) {
				if (
					isset( $v['blog_id'] ) &&
					isset( $blog_list[ $v['blog_id'] ] ) &&
					is_object( $blog_list[ $v['blog_id'] ] )
				) {
					$new[] = $blog_list[ $v['blog_id'] ];
				}
			}
		}
		return $new;
	}


	public function adminify_pto_refresh_front_network_second( $query ) {
		global $wpdb;
		if ( false !== strpos( $query, "SELECT  blog_id FROM $wpdb->blogs    ORDER BY blog_id ASC" ) ) {
			$query = str_replace( 'ORDER BY blog_id ASC', '', $query );
			if ( false !== strpos( $query, ' LIMIT ' ) ) {
				$query = preg_replace( '/^(.*) LIMIT(.*)$/', '$1 ORDER BY menu_order ASC LIMIT $2', $query );
			} else {
				$query .= ' ORDER BY menu_order ASC';
			}
		} elseif ( false !== strpos( $query, "SELECT * FROM $wpdb->blogs WHERE 1=1 AND site_id IN (1)" ) ) {
			if ( false !== strpos( $query, ' LIMIT ' ) ) {
				$query = preg_replace( '/^(.*) LIMIT(.*)$/', '$1 ORDER BY menu_order ASC LIMIT $2', $query );
			} else {
				$query .= ' ORDER BY menu_order ASC';
			}
		}
		return $query;
	}
}
