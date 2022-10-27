<?php

namespace WPAdminify\Inc\Modules\AdminColumns;

use WP_List_Table;
use WP_Posts_List_Table;
use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\Options\PostTypesOrder;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WP Adminify
 * Module: Admin Columns
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class AdminColumnsRaw
{
    public $url;

    // Key: Unique Screen ID
    private $key;

    private $post_type;

    public $prefix;

    public function __construct()
    {
        $this->url = WP_ADMINIFY_URL . 'Inc/Modules/AdminColumns';
        $this->prefix = '_wpadminify_admin_columns_settings';

        if (is_admin()) {
            add_action('admin_menu', [$this, 'jltwp_adminify_admin_columns_menu'], 51);
            add_action('admin_enqueue_scripts', [$this, 'jltwp_adminify_admin_columns_enqueue_scripts']);
        }
        // $this->jltwp_adminify_admin_columns_settings();
        // echo gettype(self::adminify_post_types());
        // print_r(Utils::get_post_types());
    }


    public function jltwp_adminify_admin_columns_menu()
    {
        add_submenu_page(
            'wp-adminify-settings',
            esc_html__('Admin Columns by WP Adminify', 'adminify'),
            esc_html__('Admin Columns', 'adminify'),
            apply_filters('jltwp_adminify_capability', 'manage_options'),
            'adminify-admin-columns', // Page slug, will be displayed in URL
            [$this, 'jltwp_adminify_admin_columns_contents']
        );
    }


    public function jltwp_adminify_admin_columns_enqueue_scripts()
    {
        $screen = get_current_screen();
        if ($screen->id === 'wp-adminify_page_adminify-admin-columns') {
            wp_enqueue_style('wp-adminify-admin-columns', $this->url . '/assets/css/wp-adminify-admin-columns.css', [], WP_ADMINIFY_VER);
            wp_register_script('wp-adminify-admin-columns', $this->url . '/assets/js/wp-adminify-admin-columns.js', ['jquery', 'jquery-ui-droppable', 'jquery-ui-draggable'], WP_ADMINIFY_VER, true);
        }

        // $admin_columns_data = [
        //     'adminurl' => admin_url(),
        //     'ajaxurl' => admin_url('admin-ajax.php'),
        //     'nonce' => wp_create_nonce('adminify-admin-columns-secirity')
        // ];
        // wp_localize_script('wp-adminify-admin-columns', 'wp_adminify__admin-columns_data', $admin_columns_data);
        wp_enqueue_script('wp-adminify-admin-columns');
    }


    public function jltwp_adminify_admin_columns_contents()
    { ?>
        <div class="wrap">
            <div class="wp-adminify--admin-columns--editor--container">
                <h1 class="wp-heading-inline">
                    <?php _e('Admin Columns Editor', 'adminify'); ?>
                </h1>
                <div class="wp-adminify--page--title--actions mt-4 is-pulled-right">
                    <button class="page-title-action mr-3">
                        <?php _e('Save Settings', 'adminify'); ?>
                    </button>
                </div>

                <div class="wp-adminify--admin-columns--editor--settings mt-6">
                    <div id="wpadminify-admin-columns">


                        <div class="tabs is-boxed is-centered">
                            <ul>
                                <li>
                                    <a href="#post-types">
                                        <span class="icon is-small">
                                            <i class="dashicons dashicons-edit-page"></i>
                                        </span>
                                        <span> <?php _e('Post Types', 'adminify'); ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#taxonomies">
                                        <span class="icon is-small">
                                            <i class="dashicons dashicons-category"></i>
                                        </span>
                                        <span> <?php _e('Taxonomies', 'adminify'); ?> </span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane" id="post-types">


                                <div class="tabs is-boxed is-centered">
                                    <ul>
                                        <?php
                                        // print_r($this->get_post_types());
                                        ?>
                                        <li>
                                            <a href="#posts"> <span> Posts </span> </a>
                                        </li>
                                        <li>
                                            <a href="#pages"> <span> Pages </span> </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content">
                                    <div class="tab-pane" id="posts">
                                        Posts Content

                                    </div>
                                    <div class="tab-pane" id="pages">
                                        Pages content
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane" id="taxonomies">


                                <div class="tabs is-boxed is-centered">
                                    <ul>
                                        <li>
                                            <a href="#post-category">
                                                <span> Post Category </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#team-category">
                                                <span> Team Category </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content">
                                    <div class="tab-pane" id="post-category">
                                        Post Category Content

                                    </div>
                                    <div class="tab-pane" id="team-category">
                                        Team Category content
                                    </div>
                                </div>



                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>


<?php
    }
}
