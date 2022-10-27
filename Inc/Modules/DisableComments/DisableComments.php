<?php

namespace WPAdminify\Inc\Modules\DisableComments;

use \Elementor;
use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Classes\Multisite_Helper;
use WPAdminify\Inc\Admin\AdminSettings;
use WPAdminify\Inc\Admin\AdminSettingsModel;


// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WPAdminify
 * @package Module: Disable Comments
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class DisableComments extends AdminSettingsModel
{

    public $url;
    public function __construct()
    {
        $this->url     = WP_ADMINIFY_URL . 'Inc/Modules/DisableComments';

        $this->options = (array) AdminSettings::get_instance()->get();

        // Disable Comments
        add_action('admin_init', [$this, 'jltma_adminify_disable_comments_post_type_support']);

        add_action('admin_init', array($this, 'jltma_adminify_disable_comments_dashboard_widget'));
        add_action('admin_init', array($this, 'jltma_adminify_disable_comments_admin_menu_redirect'));
        add_action('admin_menu', [$this, 'jltma_adminify_disable_comments_menu']);
        add_action('admin_menu', [$this, 'jltma_adminify_disable_discussion_menu']);

        // Close comments on the front-end
        if (!empty($this->options['disable_comments_close_front'])) {
            add_filter('comments_open', '__return_false', 20, 2);
            add_filter('pings_open', '__return_false', 20, 2);
        }


        // Remove comments links from admin bar
        // add_action('init', [$this, 'jltma_adminify_disable_comments_admin_bar_menu']);
        add_action('wp_before_admin_bar_render', [$this, 'jltma_adminify_remove_admin_bar_menus'], 0);
        add_filter('comment_form_default_fields', [$this, 'remove_url_field_comment_form']);
    }



    /** Redirect any user trying to access comments page. */
    public function jltma_adminify_disable_comments_admin_menu_redirect()
    {
        if (!empty($this->options['disable_comments_menu_redirect'])) {
            // Redirect any user trying to access comments page
            global $pagenow;
            if ($pagenow === 'edit-comments.php' || $pagenow === 'options-discussion.php') {
                wp_safe_redirect(admin_url());
                exit;
            }
        }
    }

    /* Remove from the administration bar */
    public function jltma_adminify_remove_admin_bar_menus()
    {
        if (!empty($this->options['disable_comments_admin_bar'])) {
            global $wp_admin_bar;
            $wp_admin_bar->remove_menu('comments');
        }
    }

    // Remove comments page in menu
    public function jltma_adminify_disable_comments_menu()
    {
        if (!empty($this->options['disable_comments_admin_menu'])) {
            remove_menu_page('edit-comments.php');
        }
    }

    // Remove "Discussion" submenu from Settings  menu
    public function jltma_adminify_disable_discussion_menu()
    {
        if (!empty($this->options['disable_comments_discussion_menu'])) {
            remove_submenu_page('options-general.php', 'options-discussion.php');
        }
    }


    // Remove Comments Menu
    public function jltma_adminify_disable_comments_admin_bar_menu()
    {
        if (is_admin_bar_showing()) {
            remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
        }
    }


    public function jltma_adminify_disable_comments_post_type_support()
    {
        if (!empty($this->options['disable_comments_post_types'])) {
            $post_types = $this->options['disable_comments_post_types'];
        } else {
            $post_types = get_post_types();
        }

        // Disable support for comments and trackbacks in post types
        foreach ($post_types as $post_type) {
            if (post_type_supports($post_type, 'comments')) {
                remove_post_type_support($post_type, 'comments');
                remove_post_type_support($post_type, 'trackbacks');
            }
        }
    }

    // Remove comments metabox from dashboard
    public function jltma_adminify_disable_comments_dashboard_widget()
    {
        if (!empty($this->options['disable_comments_dashboard_widget'])) {
            remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
        }
    }


    /**
     * Remove url field from comment form
     *
     * @param $fields
     *
     * @return mixed
     */

    public function remove_url_field_comment_form($fields)
    {
        if (!empty($this->options['disable_comments_url_field'])) {
            if (isset($fields['url'])) {
                unset($fields['url']);
            }
        }
        return $fields;
    }



    /**
     * Convert links into span pseudo links
     *
     * @param $text
     *
     * @return mixed
     */

    public function convert_to_pheudo($text)
    {
        return preg_replace_callback('/<a[^>]+href=[\'"](https?:\/\/[^"\']+)[\'"][^>]+>(.*?)<\/a>/i', [$this, 'jltwp_adminify_links_replace'], $text);
    }

    public function jltwp_adminify_links_replace($matches)
    {
        if ($matches[1] == get_home_url()) {
            return $matches[0];
        }

        return '<span class="wp-adminify-author-link-to-data-uri" data-adminify-comment-uri="' . $matches[1] . '" > ' . $matches[2] . '</span>';
    }
}
