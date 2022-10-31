<?php

namespace WPAdminify\Inc\Classes;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Admin\AdminSettings ;
use  WPAdminify\Inc\Admin\AdminSettingsModel ;
// no direct access allowed
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class AdminBar extends AdminSettingsModel
{
    public  $post_types ;
    public function __construct()
    {
        $this->options = (array) AdminSettings::get_instance()->get( 'admin_bar_settings' );
        $admin_bar_user_roles = ( !empty($this->options['admin_bar_user_roles']) ? $this->options['admin_bar_user_roles'] : '' );
        // if (Utils::restricted_for($admin_bar_user_roles)) {
        // return;
        // }
        // Disable the default admin bar
        // add_filter('show_admin_bar', '__return_false');
        // Add admin-bar support if not already activated
        add_theme_support( 'admin-bar', array(
            'callback' => '__return_false',
        ) );
        // Check Adminify Setup Wizard Page
        if ( !empty($_GET['page']) && 'wp-adminify-setup-wizard' == $_GET['page'] ) {
            return;
        }
        add_action( 'plugins_loaded', array( $this, 'initialize' ) );
        add_action( 'wp_admin_bar_class', array( $this, 'load_wp_admin_bar_class' ) );
        add_action( 'adminify/before/secondary_menu', array( $this, 'before_secondary_menu' ) );
    }
    
    public function initialize()
    {
        $admin_bar_position = ( !empty($this->options['admin_bar_position']) ? $this->options['admin_bar_position'] : 'top' );
        
        if ( is_admin() ) {
            if ( $admin_bar_position == 'top' || $admin_bar_position == 'bottom' ) {
                add_action( 'admin_init', array( $this, 'jltwp_adminify_add_admin_bar' ) );
            }
            // Remove Unnecessary Menus from Admin bar
            // add_action('wp_before_admin_bar_render', [$this, 'jltma_adminify_remove_admin_bar_menus'], 0);
            add_filter( 'admin_body_class', array( $this, 'admin_bar_body_class' ) );
            add_action( 'admin_head', array( $this, 'jltwp_adminify_admin_bar_css' ), 999 );
            add_action( 'wp_ajax_adminify_all_search', array( $this, 'adminify_all_search' ) );
            add_action( 'wp_ajax_wp_adminify_color_mode', array( $this, 'wp_adminify_color_mode' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'jltwp_adminify_admin_scripts' ), 100 );
            // Screen Option and Help Tab
            add_action(
                'admin_head',
                array( $this, 'jltwp_adminify_remove_screen_options' ),
                10,
                3
            );
            add_action( 'admin_head', array( $this, 'jltwp_adminify_remove_help_tab' ) );
        } else {
            // Admin bar Frontend settings
            $frontend_admin = ( !empty($this->options['admin_bar_hide_frontend']) ? $this->options['admin_bar_hide_frontend'] : 'show' );
            $this->jltwp_adminify_front_bar();
            add_action( 'init', array( $this, 'admin_bar_front_style_init' ) );
            if ( $frontend_admin == 'hide' ) {
                add_filter( 'show_admin_bar', '__return_false' );
            }
        }
    
    }
    
    public function before_secondary_menu()
    {
        if ( !empty($this->options['admin_bar_search']) ) {
            ?>
			<div class="wp-adminify-top-header--search--form">
				<form class="top-header--search--form" action="$">
					<span class="adminify-search-expand"><i class="icon-magnifier icons"></i></span>
					<input id="top-header-search-input" class="top-header-search-input" type="search" placeholder="Search here">
				</form>

				<div id="top-header-search-results" class=" top-header-search-results" style="display: none;">
					<div class="top-header-results-wrapper">
					</div>
				</div>
			</div>
			<?php 
        }
    }
    
    public function load_wp_admin_bar_class()
    {
        return 'WPAdminify\\Inc\\Classes\\Adminify_Admin_Bar';
    }
    
    public function jltwp_adminify_front_bar()
    {
        add_action( 'admin_init', array( $this, 'jltwp_adminify_add_admin_bar' ) );
        add_filter( 'body_class', array( $this, 'admin_bar_body_class' ) );
    }
    
    public function admin_bar_front_style_init()
    {
        add_filter( 'wp_enqueue_scripts', array( $this, 'admin_bar_front_style' ) );
    }
    
    // Frontend Admin bar style
    public function admin_bar_front_style()
    {
        $admin_bar_css = '';
        $admin_bar_css .= '.admin-bar-position-bottom #wpadminbar{
            top:auto;
            bottom: 0;
        }
        .admin-bar-position-bottom  #wpadminbar .menupop .ab-sub-wrapper{
            bottom: 32px;
        }

        @media all and (max-width:600px){
            body.logged-in.admin-bar-position-bottom {
                position: relative;
            }
        }';
        wp_add_inline_style( 'admin-bar', $admin_bar_css );
    }
    
    // Remove Screen Options
    public function jltwp_adminify_remove_screen_options()
    {
        $enable_screen_tab = Utils::get_user_preference( 'screen_options_tab' );
        if ( $enable_screen_tab ) {
            add_filter( 'screen_options_show_screen', '__return_false' );
        }
    }
    
    // Contextual Help Tab Remove
    public function jltwp_adminify_remove_help_tab()
    {
        $enable_screen_tab = Utils::get_user_preference( 'adminify_help_tab' );
        
        if ( $enable_screen_tab ) {
            $screen = get_current_screen();
            $screen->remove_help_tabs();
        }
    
    }
    
    // Get All registered WP Admin Menus
    public static function get_wp_admin_menus( $thismenu, $thissubmenu )
    {
        $options = array();
        if ( !empty($thismenu) && is_array( $thismenu ) ) {
            foreach ( $thismenu as $item ) {
                if ( !empty($item[0]) ) {
                    // the preg_replace removes "Comments" & "Plugins" menu spans.
                    $options[$item[2]] = preg_replace( '/\\<span.*?>.*?\\<\\/span><\\/span>/s', '', $item[0] );
                }
            }
        }
        if ( !empty($thissubmenu) && is_array( $thissubmenu ) ) {
            foreach ( $thissubmenu as $items ) {
                foreach ( $items as $item ) {
                    if ( !empty($item[0]) ) {
                        $options[$item[1]] = preg_replace( '/\\<span.*?>.*?\\<\\/span><\\/span>/s', '', $item[0] );
                    }
                }
            }
        }
        return $options;
    }
    
    public function jltwp_adminify_admin_scripts()
    {
        global  $pagenow ;
        if ( !is_user_logged_in() && $pagenow != 'wp-login.php' ) {
            return;
        }
        if ( is_admin_bar_showing() ) {
        }
        wp_enqueue_style( 'wp-adminify-admin-bar' );
        wp_localize_script( 'wp-adminify-admin', 'WPAdminify', $this->adminify_create_admin_bar_js_object() );
        $this->admin_topbar_loader_css();
        // wp_enqueue_style('wp-adminify-admin-bar', WP_ADMINIFY_ASSETS . 'css/admin-bar.css', false, WP_ADMINIFY_VER);
        // wp_enqueue_script('wp-adminify-admin', WP_ADMINIFY_ASSETS . 'js/wp-adminify.js',  ['jquery'], WP_ADMINIFY_VER, true);
        // wp_localize_script('wp-adminify-admin', 'WPAdminify', $this->adminify_create_admin_bar_js_object());
    }
    
    public function adminify_create_admin_bar_js_object()
    {
        return array(
            'ajax_url'       => admin_url( 'admin-ajax.php' ),
            'security_nonce' => wp_create_nonce( 'adminify-admin-bar-security-nonce' ),
            'notice_nonce'   => wp_create_nonce( 'adminify-notice-nonce' ),
        );
    }
    
    /**
     * Preloader
     *
     * @return void
     */
    public function admin_topbar_loader_css()
    {
        $output_css = '';
        $topbar_wireframe_img = WP_ADMINIFY_ASSETS_IMAGE . 'topbar-wireframe.svg';
        $output_css .= '.js .wp-adminify-topbar-loader{background: url(' . $topbar_wireframe_img . '); }';
        echo  '<style>' . $output_css . '</style>' ;
    }
    
    /**
     * Save Color Mode by Ajax
     *
     * @return void
     */
    public function wp_adminify_color_mode()
    {
        
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX && check_ajax_referer( 'adminify-admin-bar-security-nonce', 'security' ) > 0 ) {
            $admin_bar_mode = AdminSettings::get_instance()->get();
            $key = Utils::clean_ajax_input( $_POST['key'] );
            $value = Utils::clean_ajax_input( $_POST['value'] );
            
            if ( $key == '' ) {
                $message = __( 'No Color Mode supplied to save', 'adminify' );
                echo  Utils::ajax_error_message( $message ) ;
                die;
            }
            
            // Light/Dark Mode
            
            if ( $key === 'color_mode' ) {
                $admin_bar_mode['admin_bar_mode'] = $value;
                $admin_bar_mode['enable_schedule_dark_mode'] = false;
                update_option( '_wpadminify', $admin_bar_mode );
                die;
            }
            
            // Screen Options, Help Tabs and WP Hide Links
            
            if ( $key === 'screen_options_tab' || $key === 'hide_wp_links' || $key === 'adminify_help_tab' ) {
                $userid = get_current_user_id();
                $current = get_user_meta( $userid, '_wpadminify_preferences', true );
                
                if ( is_array( $current ) ) {
                    $current[$key] = $value;
                } else {
                    $current = array();
                    $current[$key] = $value;
                }
                
                $state = update_user_meta( $userid, '_wpadminify_preferences', $current );
                
                if ( $state ) {
                    $returndata = array();
                    $returndata['success'] = true;
                    $returndata['message'] = __( 'Preferences saved', 'adminify' );
                    echo  json_encode( $returndata ) ;
                } else {
                    $message = __( 'Unable to save user preferences', 'adminify' );
                    echo  Utils::ajax_error_message( $message ) ;
                    die;
                }
            
            }
        
        }
    
    }
    
    /**
     * Search Everything
     *
     * @return void
     */
    public function adminify_all_search()
    {
        
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX && check_ajax_referer( 'adminify-admin-bar-security-nonce', 'security' ) > 0 ) {
            $term = sanitize_text_field( $_POST['search'] );
            // Search Arguments
            $args = array(
                'numberposts' => -1,
                's'           => $term,
                'post_status' => array(
                'publish',
                'pending',
                'draft',
                'future',
                'private',
                'inherit'
            ),
            );
            // All Post Types
            $post_types = $this->get_post_types();
            foreach ( $post_types as $type ) {
                $args['post_type'][] = $type->name;
            }
            // All Categories/Taxonomies
            $all_taxonomies = get_taxonomies();
            // Get Comments
            $all_comments = get_comments();
            // Get All Users
            $all_users = get_users();
            // All Users
            // $blogusers = get_users();
            // foreach ($blogusers as $type) {
            // $name = $type->user_login;
            // $id = $type->ID;
            // $args['author__in'][] = $type->ID;
            // }
            // // All Menus
            // $all_admin_menus = self::get_wp_admin_menus();
            // All Plugins
            if ( !function_exists( 'get_plugins' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }
            $all_plugins = get_plugins();
            $foundposts = get_posts( $args );
            // $count_items = '';
            // if (count($foundposts) > 0) {
            // $count_items .= count($foundposts);
            // } elseif (count($all_plugins)) {
            // $count_items .= count($all_plugins);
            // }
            ob_start();
            ?>

			<p><span class="count"></span><?php 
            echo  count( $foundposts ) . __( ' item<span>s</span> found', 'adminify' ) ;
            ?></p>

			<table class="top-header-result-table" style="height:500px;">
				<thead>
					<tr class="has-text-left">
						<th><?php 
            _e( 'Title', 'adminify' );
            ?></th>
						<th><?php 
            _e( 'Type', 'adminify' );
            ?></th>
						<th><?php 
            _e( 'User', 'adminify' );
            ?></th>
						<th><?php 
            _e( 'Date', 'adminify' );
            ?></th>
					</tr>
				</thead>
				<tbody>

					<?php 
            foreach ( $foundposts as $item ) {
                $author_id = $item->post_author;
                $editurl = get_edit_post_link( $item );
                $public = get_permalink( $item );
                ?>
						<tr>
							<td><span class="table-title"><a href="<?php 
                echo  esc_url( $editurl ) ;
                ?>"><?php 
                echo  get_the_title( $item ) ;
                ?></a></span></td>
							<td><span class="type"><?php 
                echo  get_post_type( $item ) ;
                ?></span></td>
							<td><span class="user"><?php 
                echo  the_author_meta( 'user_login', $author_id ) ;
                ?></span></td>
							<td><span class="date"><?php 
                echo  get_the_date( get_option( 'date_format' ), $item ) ;
                ?></span></td>
						</tr>
					<?php 
            }
            ?>

					<?php 
            foreach ( $all_taxonomies as $tax_name ) {
                $terms = get_terms( array(
                    'taxonomy'   => $tax_name,
                    'hide_empty' => 1,
                ) );
                foreach ( $terms as $cat ) {
                    if ( strpos( strtolower( $cat->name ), strtolower( $term ) ) === false ) {
                        continue;
                    }
                    // $user = get_userdata($cat->term_id);
                    ?>
							<tr>
								<td>
									<span class="table-title">
										<a href="<?php 
                    echo  get_term_link( $cat->slug, $cat->taxonomy ) ;
                    ?>">
											<?php 
                    echo  esc_html( $cat->name ) ;
                    ?>
										</a>
									</span>
								</td>
								<td>
									<span class="type"><?php 
                    echo  esc_html( $cat->taxonomy ) ;
                    ?></span>
								</td>
								<td>
									<span class="user">
										N/A
									</span>
								</td>
								<td>
									<span class="date">
										N/A
									</span>
								</td>
								<td>
								</td>
							</tr>
							<?php 
                }
            }
            ?>


					<!-- Get Comments  -->
					<?php 
            foreach ( $all_comments as $comment ) {
                if ( strpos( strtolower( $comment->comment_content ), strtolower( $term ) ) === false ) {
                    continue;
                }
                ?>
						<tr>
							<td>
								<span class="table-title">
									<a href="<?php 
                echo  admin_url( 'comment.php?action=editcomment&c=' . $comment->comment_ID ) ;
                ?>">
										<?php 
                echo  wp_kses_post( $comment->comment_content ) ;
                ?>
									</a>
								</span>
							</td>
							<td>
								<span class="type">
									<?php 
                echo  ucwords( $comment->comment_type ) ;
                ?>
								</span>
							</td>
							<td>
								<span class="user">
									<?php 
                echo  the_author_meta( 'display_name', $comment->user_id ) ;
                ?>
								</span>
							</td>
							<td>
								<span class="date">
									<?php 
                echo  get_the_date( get_option( 'date_format' ), $comment->comment_date ) ;
                ?>
								</span>
							</td>
						</tr>
					<?php 
            }
            ?>



					<!-- Get Users  -->
					<?php 
            foreach ( $all_users as $user ) {
                if ( strpos( strtolower( $user->user_login ), strtolower( $term ) ) === false ) {
                    continue;
                }
                ?>
						<tr>
							<td>
								<span class="table-title">
									<a href="<?php 
                echo  admin_url( 'user-edit.php?user_id=' . $user->ID ) ;
                ?>">
										<?php 
                echo  esc_html( $user->display_name ) ;
                ?>
									</a>
								</span>
							</td>
							<td>
								<span class="type">
									<?php 
                esc_html_e( 'User', 'adminify' );
                ?>
								</span>
							</td>
							<td>
								<span class="user">
									<?php 
                echo  the_author_meta( 'display_name', $user->ID ) ;
                ?>
								</span>
							</td>
							<td>
								<span class="date">
									<?php 
                echo  get_the_date( get_option( 'date_format' ), $user->user_registered ) ;
                ?>
								</span>
							</td>
						</tr>
					<?php 
            }
            ?>



					<!-- Get Plugins  -->
					<?php 
            foreach ( $all_plugins as $plugin ) {
                if ( strpos( strtolower( $plugin['Name'] ), strtolower( $term ) ) === false ) {
                    continue;
                }
                ?>
						<tr>
							<td>
								<span class="table-title">
									<a href="<?php 
                echo  admin_url( 'plugins.php' ) ;
                ?>">
										<?php 
                echo  esc_html( $plugin['Name'] ) ;
                ?>
									</a>
								</span>
							</td>
							<td>
								<span class="type">
									<?php 
                esc_html_e( 'Plugin', 'adminify' );
                ?>
								</span>
							</td>
							<td>
								<span class="user">
									<?php 
                echo  esc_html( $plugin['AuthorName'] ) ;
                ?>
								</span>
							</td>
							<td>
								<span class="date">
									<?php 
                esc_html_e( 'N/A', 'adminify' );
                ?>
								</span>
							</td>
						</tr>
					<?php 
            }
            ?>


				</tbody>
			</table>


			<?php 
            $output_data = ob_get_clean();
            echo  json_encode( $output_data ) ;
        }
        
        die;
    }
    
    public function jltwp_adminify_admin_bar_css()
    {
        $admin_bar_mode = AdminSettings::get_instance()->get();
        $admin_bar_mode = ( !empty($admin_bar_mode['admin_bar_mode']) ? $admin_bar_mode['admin_bar_mode'] : '' );
        $output_css = '';
        $output_css .= '<style type="text/css">';
        $admin_bar_container = ( !empty($this->options['admin_bar_container']) ? $this->options['admin_bar_container'] : 'full_container' );
        
        if ( $admin_bar_mode === 'light' ) {
            $light_bg_type = ( !empty($this->options['admin_bar_light_bg']) ? $this->options['admin_bar_light_bg'] : 'color' );
            $light_bg_color = ( !empty($this->options['admin_bar_light_bg_color']) ? $this->options['admin_bar_light_bg_color'] : '' );
            // Full Container Colors
            
            if ( $admin_bar_container == 'full_container' ) {
                if ( $light_bg_type === 'color' ) {
                    $output_css .= '.wp-adminify.adminify-light-mode .adminify-top_bar nav.navbar, .wp-adminify .wp-adminify-horizontal-menu { background-color:' . $light_bg_color . ' ; }';
                }
            } elseif ( $admin_bar_container == 'admin_bar_only' ) {
                // Admin Bar Colors
                if ( $light_bg_type === 'color' ) {
                    if ( !empty($this->options['admin_bar_light_bg_color']) ) {
                        $output_css .= '.wp-adminify.adminify-light-mode .adminify-top_bar nav.navbar { background-color:' . $light_bg_color . ' }';
                    }
                }
            }
            
            if ( !empty($admin_bar_colors['icon_color']) ) {
                $output_css .= '.adminify-top_bar nav.navbar .navbar-menu .topbar-icon { fill: ' . $admin_bar_colors['icon_color'] . ' }';
            }
        } elseif ( $admin_bar_mode === 'dark' ) {
            $dark_bg_type = ( isset( $this->options['admin_bar_dark_bg'] ) ? $this->options['admin_bar_dark_bg'] : 'color' );
            
            if ( $admin_bar_container == 'full_container' ) {
                
                if ( $dark_bg_type === 'color' ) {
                    $dark_bg_color = $this->options['admin_bar_dark_bg_color'];
                    $output_css .= '.wp-adminify.adminify-dark-mode .adminify-top_bar nav.navbar, .wp-adminify .wp-adminify-horizontal-menu{ background-color:' . $dark_bg_color . ' }';
                } elseif ( $dark_bg_type === 'gradient' ) {
                    $dark_gradient_bg_color = $this->options['admin_bar_dark_bg_gradient']['background-color'];
                    $dark_gradient_color = $this->options['admin_bar_dark_bg_gradient']['background-gradient-color'];
                    $dark_gradient_color_dir = $this->options['admin_bar_dark_bg_gradient']['background-gradient-direction'];
                    $output_css .= '.wp-adminify.adminify-dark-mode .adminify-top_bar nav.navbar, .wp-adminify .wp-adminify-horizontal-menu{ background-image : linear-gradient(' . esc_attr( $dark_gradient_color_dir ) . ', ' . esc_attr( $dark_gradient_bg_color ) . ' , ' . esc_attr( $dark_gradient_color ) . '); }';
                }
            
            } elseif ( $admin_bar_container == 'admin_bar_only' ) {
                
                if ( $dark_bg_type === 'color' ) {
                    $dark_bg_color = $this->options['admin_bar_dark_bg_color'];
                    $output_css .= '.wp-adminify.adminify-dark-mode .adminify-top_bar nav.navbar{ background-color:' . $dark_bg_color . ' }';
                }
            
            }
        
        }
        
        // "New" Button Colors
        $new_btn_colors = ( !empty($this->options['admin_bar_link_color']) ? $this->options['admin_bar_link_color'] : '' );
        if ( !empty($new_btn_colors['link_color']) ) {
            $output_css .= '.wp-adminify #wpadminbar #wp-admin-bar-root-default #wp-admin-bar-new-content > .ab-item .ab-label, .wp-adminify #wpadminbar #wp-admin-bar-root-default #wp-admin-bar-new-content .ab-item .ab-icon:before { color:' . $new_btn_colors['link_color'] . ' }';
        }
        if ( !empty($new_btn_colors['hover_color']) ) {
            $output_css .= '.wp-adminify #wpadminbar #wp-admin-bar-root-default #wp-admin-bar-new-content > .ab-item:hover .ab-label, .wp-adminify #wpadminbar #wp-admin-bar-root-default #wp-admin-bar-new-content .ab-item:hover .ab-icon:before{ color:' . $new_btn_colors['hover_color'] . ' }';
        }
        if ( !empty($new_btn_colors['bg_color']) ) {
            $output_css .= '.wp-adminify #wpadminbar #wp-admin-bar-root-default #wp-admin-bar-new-content > .ab-item, .wp-adminify #wpadminbar #wp-admin-bar-root-default #wp-admin-bar-new-content:hover > .ab-item { background:' . $new_btn_colors['bg_color'] . ';}';
        }
        // "New" Button Hover Colors
        $new_btn_dropwon = ( !empty($this->options['admin_bar_link_dropdown_color']) ? $this->options['admin_bar_link_dropdown_color'] : '' );
        if ( !empty($new_btn_dropwon['wrapper_bg']) ) {
            $output_css .= '.wp-adminify #wpadminbar .ab-top-menu .ab-sub-wrapper, .wp-adminify #wpadminbar .ab-top-menu .ab-sub-wrapper .ab-submenu, .wp-adminify #wpadminbar .ab-top-menu .ab-sub-wrapper .ab-submenu .ab-item { background-color:' . $new_btn_dropwon['wrapper_bg'] . ' !important;}';
        }
        if ( !empty($new_btn_dropwon['bg_color']) ) {
            $output_css .= '.wp-adminify #wpadminbar .ab-top-menu .ab-sub-wrapper .ab-submenu .ab-item:hover { background-color:' . $new_btn_dropwon['bg_color'] . ' !important;}';
        }
        if ( !empty($new_btn_dropwon['link_color']) ) {
            $output_css .= '.wp-adminify #wpadminbar .ab-top-menu .ab-sub-wrapper .ab-submenu .ab-item { color:' . $new_btn_dropwon['link_color'] . ' !important }';
        }
        if ( !empty($new_btn_dropwon['hover_color']) ) {
            $output_css .= '.wp-adminify #wpadminbar .ab-top-menu .ab-sub-wrapper .ab-submenu .ab-item:hover { color:' . $new_btn_dropwon['hover_color'] . ' !important }';
        }
        // Text Color
        
        if ( !empty($this->options['admin_bar_text_color']) ) {
            $output_css .= '.adminify-top_bar nav.navbar .navbar-brand .navbar-item .wp-adminify-site-name, .adminify-top_bar nav.navbar .navbar-menu .wp-adminify-user-site-list button { color:' . $this->options['admin_bar_text_color'] . ' }';
            $output_css .= '.wp-adminify #wpadminbar #wp-admin-bar-root-default #wp-admin-bar-new-post > .ab-item { color:' . $this->options['admin_bar_text_color'] . ' ; }';
            $output_css .= '.wp-adminify #wpadminbar #wp-admin-bar-root-default #wp-admin-bar-new-post > .ab-item .ab-icon:before { color:' . $this->options['admin_bar_text_color'] . ' ; }';
            $output_css .= '.wp-adminify #wpadminbar #wp-admin-bar-root-default #wp-admin-bar-new-post > .ab-item .ab-label { color:' . $this->options['admin_bar_text_color'] . ' ; }';
        }
        
        // Icon Color
        
        if ( !empty($this->options['admin_bar_icon_color']) ) {
            $output_css .= '.adminify-top_bar nav.navbar .navbar-menu .topbar-icon svg path { fill:' . $this->options['admin_bar_icon_color'] . ' }';
            $output_css .= '.adminify-top_bar nav.navbar .navbar-end i, .adminify-top_bar nav.navbar .navbar-burger i { color:' . $this->options['admin_bar_icon_color'] . ' }';
        }
        
        $output_css .= ' </style>';
        echo  Utils::wp_kses_custom( $output_css ) ;
    }
    
    // Admin Bar Body Class
    public function admin_bar_body_class( $classes )
    {
        
        if ( is_admin() ) {
            $classes .= ' wp-adminify-admin-bar';
            $admin_bar_position = ( !empty($this->options['admin_bar_position']) ? $this->options['admin_bar_position'] : 'top' );
            
            if ( $admin_bar_position === 'top' ) {
                $classes .= ' position-top';
            } elseif ( $admin_bar_position === 'bottom' ) {
                $classes .= ' position-bottom';
            }
            
            if ( !empty($this->options['enable_admin_bar']) ) {
                $classes .= ' topbar-disabled';
            }
        } else {
            global  $pagenow ;
            if ( !is_user_logged_in() && $pagenow != 'wp-login.php' ) {
                return $classes;
            }
            $classes[] = 'wp-adminify-admin-bar';
            $admin_bar_position = ( !empty($this->options['admin_bar_position']) ? $this->options['admin_bar_position'] : 'top' );
            
            if ( $admin_bar_position === 'top' ) {
                $classes[] = 'admin-bar-position-top';
            } elseif ( $admin_bar_position === 'bottom' ) {
                $classes[] = 'admin-bar-position-bottom';
            }
            
            if ( !empty($this->options['enable_admin_bar']) ) {
                $classes[] = 'topbar-disabled';
            }
        }
        
        return $classes;
    }
    
    public function get_post_types()
    {
        
        if ( is_array( $this->post_types ) ) {
            return $this->post_types;
        } else {
            $args = array(
                'public' => true,
            );
            $output = 'objects';
            $post_types = get_post_types( $args, $output );
            $this->post_types = $post_types;
            return $post_types;
        }
    
    }
    
    public function jltwp_adminify_add_admin_bar()
    {
        // For Testing Admin Bar on Setup Wizard
        // add_action('admin_head', [$this, 'jltwp_adminify_render_admin_bar']);
        add_action( 'in_admin_header', array( $this, 'jltwp_adminify_render_admin_bar' ), -999999999 );
        // on frontend area
        add_action( 'wp_head', array( $this, 'jltwp_adminify_render_admin_bar' ) );
    }
    
    public function jltwp_adminify_render_admin_bar()
    {
        global  $pagenow ;
        if ( !is_user_logged_in() && $pagenow != 'wp-login.php' ) {
            return;
        }
        if ( !is_admin_bar_showing() ) {
            return false;
        }
        global  $wp_admin_bar ;
        if ( empty($wp_admin_bar) ) {
            return false;
        }
        $admin_bar_mode = AdminSettings::get_instance()->get();
        $admin_bar_mode = ( empty($admin_bar_mode['admin_bar_mode']) ? 'light' : $admin_bar_mode['admin_bar_mode'] );
        // Light/Dark Mode
        $enable_dark_mode = $admin_bar_mode != 'light';
        // Screen Option && Hide WP Links
        $enable_screen_tab = Utils::get_user_preference( 'screen_options_tab' );
        $enable_help_tab = Utils::get_user_preference( 'adminify_help_tab' );
        $enable_hide_wp_links = Utils::get_user_preference( 'hide_wp_links' );
        // Admin Bar Position
        
        if ( !empty($this->options['admin_bar_position']) === 'top' ) {
            $admin_bar_position = 'top_bar';
        } elseif ( !empty($this->options['admin_bar_position']) === 'bottom' ) {
            $admin_bar_position = 'bottom_bar is-fixed-bottom';
        } else {
            $admin_bar_position = 'top_bar';
        }
        
        $current_user = wp_get_current_user();
        ob_start();
        ?>

		<div class="wp-adminify-topbar-loader"></div>
		<div class="wp-adminify adminify-top_bar" style="opacity: 0;">
			<nav class="navbar adminify-top-navbar <?php 
        echo  esc_attr( $admin_bar_position ) ;
        ?>">

				<?php 
        $this->jltwp_adminify_logo();
        ?>
				<div class="adminify-admin-wrapper">
					<div class="adminify-legacy-admin">
						<?php 
        if ( !$enable_hide_wp_links ) {
            echo  wp_admin_bar_render() ;
        }
        ?>
					</div>

					<div id="wp-adminify-top-adminbar" class="navbar-menu">

						<div class="navbar-end">
							<div class="field is-grouped">

								<?php 
        
        if ( !empty($this->options['admin_bar_dark_light_btn']) ) {
            ?>
									<div class="wp-admnify--mode--switcher pr-4">
										<label class="admnify-switcher is-pulled-right">
											<input type="checkbox" id="light-dark-switcher-btn" <?php 
            checked( $enable_dark_mode, 1 );
            ?>>
											<span class="slider round"></span>
										</label>
									</div>
								<?php 
        }
        
        ?>

								<?php 
        
        if ( !empty($this->options['admin_bar_comments']) ) {
            ?>
									<div class="wp-adminify--top--comment ml-4 mr-4">
										<button class="comment-trigger is-clickable">
											<div class="topbar-icon">
												<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M0.25 13.75V1.75C0.25 0.921573 0.921572 0.25 1.75 0.25H12.25C13.0784 0.25 13.75 0.921573 13.75 1.75V9.25C13.75 10.0784 13.0784 10.75 12.25 10.75H4.75C4.42535 10.7494 4.10936 10.8547 3.85 11.05L0.25 13.75ZM1.75 1.75V10.75L3.3505 9.55C3.60973 9.35448 3.9258 9.24913 4.2505 9.25H12.25V1.75H1.75Z" fill="#4E4B66" />
												</svg>
											</div>
											<span class="comment-counter p-0 tag is-rounded">
												<?php 
            $comments_count = wp_count_comments();
            echo  esc_html( $comments_count->moderated ) ;
            ?>
											</span>
										</button>
									</div>

									<?php 
        }
        
        
        if ( !empty($this->options['admin_bar_view_website']) ) {
            ?>
									<div class="wp-adminify--preview mr-4">
										<a class="preview-trigger is-clickable" href="<?php 
            echo  get_home_url() ;
            ?>"
										<?php 
            if ( !empty($this->options['admin_bar_view_website_window_type']) && $this->options['admin_bar_view_website_window_type'] == 'new_tab' ) {
                ?>
											target="_blank"
										<?php 
            }
            ?>
										>
											<i class="dashicons dashicons-visibility"></i>
										</a>
									</div>
								<?php 
        }
        
        ?>

								<div class="wp-adminify--user--account">
									<button class="user-avatar is-clickable">
										<div class="image is-45x45">
											<?php 
        echo  get_avatar(
            $current_user->user_email,
            45,
            '',
            '',
            array(
            'class' => 'is-rounded',
        )
        ) ;
        ?>
										</div>
										<span class="user-status tag p-0 is-rounded"></span>
									</button>
								</div>

							</div>
						</div>
					</div>
				</div>
			</nav>

			<?php 
        
        if ( !empty($this->options['admin_bar_user_offcanvas_menu']) ) {
            ?>
				<div class="wp-adminify--user--wrapper">
					<div class="user-wqrapper-inner">
						<button class="user-wrapper-close is-clickable">
							<img src="<?php 
            echo  WP_ADMINIFY_ASSETS ;
            ?>images/header/close.svg" alt="Close Icon">
						</button>

						<div class="user-wrapper-top media">
							<figure class="media-left">
								<p class="image is-85x85">
									<?php 
            echo  get_avatar(
                $current_user->user_email,
                85,
                '',
                '',
                array(
                'class' => 'is-rounded',
            )
            ) ;
            ?>
								</p>
							</figure>
							<div class="media-content">
								<div class="content">
									<h3 class="name">
										<?php 
            echo  esc_html( $current_user->display_name ) ;
            ?>
									</h3>
									<a href="<?php 
            echo  admin_url( 'profile.php' ) ;
            ?>" class="email">
										<?php 
            echo  is_email( $current_user->user_email ) ;
            ?>
									</a>
									<br>
									<a href="<?php 
            echo  wp_logout_url() ;
            ?>" class="logout button">
										<?php 
            echo  esc_html__( 'Log Out', 'adminify' ) ;
            ?>
									</a>
								</div>
							</div>
						</div>


						<div class="user-wrapper-content">
							<div class="panel-insider">
								<h4 class="title"><?php 
            esc_html__( 'Overview', 'adminify' );
            ?></h4>
								<ul>
									<li>
										<a href="<?php 
            echo  get_home_url() ;
            ?>" target="_blank">
											<img class="user-panel-icon" src="<?php 
            echo  WP_ADMINIFY_ASSETS ;
            ?>images/header/panel/building.svg" alt="<?php 
            echo  esc_html__( 'View Website Icon', 'adminify' ) ;
            ?>">
											<?php 
            echo  _e( 'View Website', 'adminify' ) ;
            ?>
										</a>
									</li>
									<li>
										<a href="<?php 
            echo  admin_url( 'profile.php' ) ;
            ?>">
											<img class="user-panel-icon" src="<?php 
            echo  WP_ADMINIFY_ASSETS ;
            ?>images/header/panel/users.svg" alt="<?php 
            echo  esc_html__( 'Profile Icon', 'adminify' ) ;
            ?>">
											<?php 
            _e( 'View Profile', 'adminify' );
            ?>
										</a>
									</li>
								</ul>
							</div>

							<?php 
            $all_updates = Utils::get_all_updates();
            $total_updates = $all_updates['total'];
            $plugin_updates = $all_updates['plugin'];
            $theme_updates = $all_updates['theme'];
            $wp_updates = $all_updates['wordpress'];
            ?>


							<div class="panel-insider">
								<h4 class="title"><?php 
            _e( 'Updates', 'adminify' );
            ?></h4>
								<?php 
            
            if ( $total_updates < 1 ) {
                ?>
									<p class="adminify-meta">
										<?php 
                _e( 'Everything is up to date', 'adminify' );
                ?>
									</p>
								<?php 
            } else {
                ?>
									<ul>

										<li>
											<a href="<?php 
                echo  esc_url( admin_url( 'update-core.php' ) ) ;
                ?>">
												<span class="icon-reload"></span>
												<?php 
                _e( 'All Updates', 'adminify' );
                ?>
												<span class="count tag is-rounded">
													<?php 
                echo  esc_html( $total_updates ) ;
                ?>
												</span>
											</a>
										</li>
										<li>
											<a href="<?php 
                echo  esc_url( admin_url( 'update-core.php' ) ) ;
                ?>">
												<span class="dashicons dashicons-wordpress"></span>
												<?php 
                _e( ' WordPress Core', 'adminify' );
                ?>
												<span class="count tag is-rounded">
													<?php 
                echo  esc_html( $wp_updates ) ;
                ?>
												</span>
											</a>
										</li>
										<li>
											<a href="<?php 
                echo  esc_url( admin_url( 'plugins.php' ) ) ;
                ?>">
												<span class="icon-energy"></span>
												<?php 
                _e( ' Plugins', 'adminify' );
                ?>
												<span class="count tag is-rounded"><?php 
                echo  esc_html( count( $plugin_updates ) ) ;
                ?></span>
											</a>
										</li>
										<li>
											<a href="<?php 
                echo  esc_url( admin_url( 'themes.php' ) ) ;
                ?>">
												<img class="user-panel-icon" src="<?php 
                echo  WP_ADMINIFY_ASSETS ;
                ?>images/header/panel/plugins.svg" />
												<?php 
                _e( ' Themes', 'adminify' );
                ?>
												<span class="count tag is-rounded"><?php 
                echo  esc_html( count( $theme_updates ) ) ;
                ?></span>
											</a>
										</li>
									</ul>
								<?php 
            }
            
            ?>
							</div>

							<div class="panel-insider">
								<h4 class="title"><?php 
            _e( 'Preferences', 'adminify' );
            ?></h4>
								<ul>
									<li>
										<?php 
            _e( 'Screen Tab Hide', 'adminify' );
            ?>
										<label class="admnify-switcher is-pulled-right">
											<input type="checkbox" id="screen-option-switcher-btn" <?php 
            checked( $enable_screen_tab, 1 );
            ?>>
											<span class="slider round"></span>
										</label>
									</li>
									<li>
										<?php 
            _e( 'Help Tab Hide ', 'adminify' );
            ?>
										<label class="admnify-switcher is-pulled-right">
											<input type="checkbox" id="help-option-switcher-btn" <?php 
            checked( $enable_help_tab, 1 );
            ?>>
											<span class="slider round"></span>
										</label>
									</li>
									<li>
										<?php 
            _e( 'Hide WP Links', 'adminify' );
            ?>
										<label class="admnify-switcher is-pulled-right">
											<input type="checkbox" id="hide-wp-links-switcher-btn" <?php 
            checked( $enable_hide_wp_links, 1 );
            ?>>
											<span class="slider round"></span>
										</label>
									</li>
								</ul>
							</div>
						</div>

						<!-- <div class="user-notification-area pb-5">
							<h4>
							<?php 
            // _e('All Notifications', 'adminify');
            ?>
								</h4>
							<ul class="m-0 p-0">
								<li>
									<a href="#">Dashboard: <span class="count has-text-centered is-pulled-right">2</span></a>
								</li>
								<li>
									<a href="#">Themes: <span class="count has-text-centered is-pulled-right">2</span></a>
								</li>
								<li>
									<a href="#">Plugins: <span class="count has-text-centered is-pulled-right">2</span></a>
								</li>
								<li>
									<a href="#">Settings: <span class="count has-text-centered is-pulled-right">2</span></a>
								</li>
							</ul>
						</div> -->

					</div>
				</div>
			<?php 
        }
        
        ?>
		</div>

		<?php 
        $output_wp_admin_bar = ob_get_clean();
        echo  Utils::wp_kses_custom( $output_wp_admin_bar ) ;
    }
    
    public function jltwp_adminify_logo()
    {
        global  $wp_admin_bar ;
        $adminurl = get_admin_url();
        $homeurl = $adminurl;
        // Light Logo
        $admin_bar_mode = AdminSettings::get_instance()->get();
        $menu_layout = (array) $admin_bar_mode['menu_layout_settings'];
        // Menu Layouts
        $menu_layout = ( !empty($admin_bar_mode['menu_layout_settings']) ? $admin_bar_mode['menu_layout_settings'] : '' );
        $menu_mode = ( !empty($menu_layout['menu_mode']) ? $menu_layout['menu_mode'] : 'classic' );
        $menu_layout = ( !empty($menu_layout['layout_type']) ? $menu_layout['layout_type'] : 'vertical' );
        $admin_bar_logo_type = ( !empty($admin_bar_mode['admin_bar_logo_type']) ? $admin_bar_mode['admin_bar_logo_type'] : 'image_logo' );
        $light_mode = ( !empty($admin_bar_mode['admin_bar_light_mode']) ? $admin_bar_mode['admin_bar_light_mode'] : '' );
        
        if ( $admin_bar_logo_type == 'image_logo' ) {
            // Logo Image
            
            if ( !empty($light_mode['admin_bar_light_logo']['url']) ) {
                $light_logo = $light_mode['admin_bar_light_logo']['url'];
            } else {
                
                if ( $menu_layout == 'vertical' && $menu_mode == 'icon_menu' ) {
                    $light_logo = WP_ADMINIFY_ASSETS_IMAGE . 'logos/logo-text-light.svg';
                } else {
                    $light_logo = WP_ADMINIFY_ASSETS_IMAGE . 'logos/logo-text-light.svg';
                }
            
            }
        
        } elseif ( $admin_bar_logo_type == 'text_logo' ) {
            // Text Logo
            $light_logo = $light_mode['admin_bar_light_logo_text'];
        }
        
        // Logo Size
        $light_width = ( isset( $light_mode['light_logo_size']['width'] ) ? $light_mode['light_logo_size']['width'] : '150' );
        $light_height = ( isset( $light_mode['light_logo_size']['height'] ) ? $light_mode['light_logo_size']['height'] : '45' );
        // Dark Logo
        $dark_mode = ( !empty($admin_bar_mode['admin_bar_dark_mode']) ? $admin_bar_mode['admin_bar_dark_mode'] : '' );
        
        if ( $admin_bar_logo_type == 'image_logo' ) {
            // Dark Logo Image
            
            if ( isset( $dark_mode['admin_bar_dark_logo']['url'] ) && $dark_mode['admin_bar_dark_logo']['url'] ) {
                $dark_logo = $dark_mode['admin_bar_dark_logo']['url'];
            } else {
                
                if ( $menu_layout == 'vertical' && $menu_mode === 'icon_menu' ) {
                    $dark_logo = WP_ADMINIFY_ASSETS_IMAGE . 'logos/logo-text-dark.svg';
                } else {
                    $dark_logo = WP_ADMINIFY_ASSETS_IMAGE . 'logos/logo-text-dark.svg';
                }
            
            }
        
        } elseif ( $admin_bar_logo_type == 'text_logo' ) {
            // Text Logo
            $dark_logo = $dark_mode['admin_bar_dark_logo_text'];
        }
        
        // Dark Logo Size
        $dark_width = ( isset( $dark_mode['dark_logo_size']['width'] ) ? $dark_mode['dark_logo_size']['width'] : '150' );
        $dark_height = ( isset( $dark_mode['dark_logo_size']['height'] ) ? $dark_mode['dark_logo_size']['height'] : '45' );
        ?>

		<div class="navbar-brand">
			<a class="navbar-item p-0" href="<?php 
        echo  esc_url( $homeurl ) ;
        ?>">
				<?php 
        
        if ( $admin_bar_logo_type == 'image_logo' ) {
            ?>
					<img alt="<?php 
            echo  get_bloginfo( 'name' ) ;
            ?>" class="logo-light" src="<?php 
            echo  esc_url( $light_logo ) ;
            ?>" width="<?php 
            echo  esc_attr( $light_width ) ;
            ?>" height="<?php 
            echo  esc_attr( $light_height ) ;
            ?>">
					<img alt="<?php 
            echo  get_bloginfo( 'name' ) ;
            ?>" class="logo-dark" src="<?php 
            echo  esc_url( $dark_logo ) ;
            ?>" width="<?php 
            echo  esc_attr( $dark_width ) ;
            ?>" height="<?php 
            echo  esc_attr( $dark_height ) ;
            ?>">
				<?php 
        } elseif ( $admin_bar_logo_type == 'text_logo' ) {
            ?>
					<span class="wp-adminify-site-name">
						<?php 
            echo  esc_html( $light_logo ) ;
            ?>
					</span>
				<?php 
        }
        
        ?>
			</a>


			<div class="navbar-burger" data-target="wp-adminify-top-adminbar">
				<i class="dashicons dashicons-menu-alt"></i>
			</div>

		</div>

		<?php 
    }
    
    /* Remove from the administration bar */
    public function jltma_adminify_remove_admin_bar_menus()
    {
        global  $wp_admin_bar ;
        $restricted_user = ( !empty($this->options['admin_bar_new_button_user_roles']) ? $this->options['admin_bar_new_button_user_roles'] : '' );
        if ( $restricted_user ) {
            
            if ( Utils::restrict_for( $this->options['admin_bar_new_button_user_roles'] ) ) {
                $wp_admin_bar->remove_menu( 'new-content' );
                return;
            }
        
        }
        $wp_admin_bar->remove_menu( 'wp-logo' );
        $wp_admin_bar->remove_menu( 'site-name' );
        $wp_admin_bar->remove_menu( 'updates' );
        $wp_admin_bar->remove_menu( 'menu-toggle' );
    }

}