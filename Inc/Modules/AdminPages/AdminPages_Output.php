<?php

namespace WPAdminify\Inc\Modules\AdminPages;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Classes\Multisite_Helper;
use WPAdminify\Inc\Modules\AdminPages\AdminPages_Render;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WPAdminify
 * @package Admin Pages
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class AdminPages_Output extends AdminPagesModel
{
    public function __construct()
    {
        $this->adminpages_init();
    }

    public function adminpages_init()
    {
        add_action('admin_menu', [$this, 'render_menu'], PHP_INT_MAX);
        add_action('wp', [$this, 'render_front']);
        add_filter('adminify_admin_page_user_roles', [$this, 'add_super_admin']);
    }

    public function render_menu()
    {
        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $parent_pages  = $this->get_posts('top_level');
            $submenu_pages = $this->get_posts('sub_level');

            if (!empty($parent_pages)) {
                $this->prepare_menu($parent_pages);
            }

            if (!empty($submenu_pages)) {
                $this->prepare_menu($submenu_pages);
            }
        }
    }


    public function get_posts($menu_type)
    {
        $posts = get_posts(
            array(
                'post_type'      => 'adminify_admin_page',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'meta_query'     => array(
                    array(
                        'key'   => $this->prefix . 'menu_type',
                        'compare' => 'IN',
                        'value' => $menu_type,
                    ),
                ),
            )
        );

        $posts = $posts ? $posts : array();

        foreach ($posts as $post) {
            $post_id = $post->ID;

            $post->menu_type     = get_post_meta($post_id, '_wp_adminify_menu_type', true);
            $post->menu_parent   = htmlspecialchars_decode( urldecode( ( get_post_meta($post_id, '_wp_adminify_sub_menu_item', true) ) ) );
            $post->menu_order    = get_post_meta($post_id, '_wp_adminify_menu_order', true);
            $post->menu_order    = $post->menu_order ? absint($post->menu_order) : 10;
            $post->icon_class    = get_post_meta($post_id, $this->prefix . 'menu_icon', true);
            $post->allowed_roles = get_post_meta($post_id, $this->prefix . 'user_roles', true) ?? '';
            $post->custom_css    = get_post_meta($post_id, '_wp_adminify_custom_css', true);
            $post->custom_js     = get_post_meta($post_id, '_wp_adminify_custom_js', true);

            $post->remove_page_title    = (int) get_post_meta($post_id, $this->prefix . 'page_title', true);
            $post->remove_page_margin   = (int) get_post_meta($post_id, $this->prefix . 'remove_margin', true);
            $post->remove_admin_notices = get_post_meta($post_id, $this->prefix . 'remove_notice', true);
        }
        wp_reset_postdata();

        return $posts;
    }

    /**
     * Register Menu and Submenu Admin Pages
     *
     * @param array $posts
     * @param boolean $from_multisite
     *
     * @return void
     */
    public function prepare_menu($posts, $from_multisite = false)
    {

        $user_roles = wp_get_current_user()->roles;
        $user_roles = apply_filters('adminify_admin_page_user_roles', $user_roles);

        foreach ($posts as $post) {
            if (!Utils::restricted_for($post->allowed_roles)) {
                continue;
            }

            $this->add_menu($post, $from_multisite);
        }
    }

    /**
     * Register Admin Menu or Submenu
     */

    public function add_menu($post, $from_multisite = false)
    {
        $menu_title  = $post->post_title;
        $menu_slug   = $post->post_name;
        $menu_type   = $post->menu_type;
        $menu_parent = $post->menu_parent;
        $menu_order  = $post->menu_order;
        $icon_class  = $post->icon_class;

        if (!empty($icon_class)) {
            $menu_icon = str_ireplace('dashicons ', '', $icon_class);
        } else {
            $menu_icon = 'none';
        }

        $screen_id = 'adminify_admin_page_' . $menu_slug;

        if ('top_level' === $menu_type) {
            add_menu_page(
                $menu_title,
                $menu_title,
                'read',
                $screen_id,
                function () use ($post, $from_multisite) {
                    $this->render_admin_page($post, $from_multisite);
                },
                $menu_icon,
                $menu_order
            );
        } else {
            add_submenu_page(
                $menu_parent,
                $menu_title,
                $menu_title,
                'read',
                $screen_id,
                function () use ($post, $from_multisite) {
                    $this->render_admin_page($post, $from_multisite);
                },
                $menu_order
            );
        }
    }

    public function render_admin_page($post, $from_multisite = false)
    {
        new AdminPages_Render($post, $from_multisite = false);
    }

    /**
     * Add Super Admin to existing roles
     *
     * @return void
     */
    public function add_super_admin($roles)
    {
        $ms_helper = new Multisite_Helper();
        if ($ms_helper->is_multisite_supported()) {
            if (is_super_admin()) {
                array_push($roles, 'super_admin');
            }
        }
        return $roles;
    }

    // Accessing from frontend not allowed
    public function render_front()
    {
        if (is_user_logged_in() || !is_singular('adminify_admin_page')) {
            return;
        }

        wp_safe_redirect(home_url());
    }
}
