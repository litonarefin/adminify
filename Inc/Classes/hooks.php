<?php

namespace WPAdminify\Inc\Classes;

// no direct access allowed
if (!defined('ABSPATH'))  exit;
/**
 * WPAdminify
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */
class Hooks
{
    public function __construct()
    {
        // https://wordpress.stackexchange.com/questions/25034/how-to-remove-screen-options-and-help-links-in-the-admin-area
        // https://wordpress.stackexchange.com/questions/73561/how-to-remove-all-widgets-from-dashboard
        // Hide Screen Options and Contextual Help

        // Add Featured Image or Post Thumbnail to RSS Feed
        add_filter('the_excerpt_rss', [$this, 'jltwp_adminify_rss_post_thumbnail']);
        add_filter('the_content_feed', [$this, 'jltwp_adminify_rss_post_thumbnail']);

        //Add Categories to WordPress Pages, add tag and category support to pages
        add_action('init', [$this, 'jltwp_adminify_tags_categories_support_all']);
        add_action('pre_get_posts', [$this, 'jltwp_adminify_tags_categories_support_query']);

        // Remove WordPress Version Number
        add_filter('the_generator', [$this, 'jltwp_adminify_remove_version']);

        //Remove Default Image Links in WordPress
        add_action('admin_init', [$this, 'jltwp_adminify_imagelink_setup'], 10);



        // WP Adminify Custom Tweaks
        add_filter('manage_posts_columns', [$this, 'jltwp_adminify_columns_attachments'], 1);
        add_action('manage_posts_custom_column', [$this, 'jltwp_adminify_custom_columns_attachments'], 1, 2);
    }


    function jltwp_adminify_columns_attachments($attachmentCount)
    {
        $attachmentCount['wp_adminify_post_attachments'] = esc_html__('Attachment(s)', 'adminify');
        return $attachmentCount;
    }

    function jltwp_adminify_custom_columns_attachments($adminify_col_name, $id)
    {
        if ($adminify_col_name === 'wp_adminify_post_attachments') {
            $attachments = get_children(array('post_parent' => $id));
            $adminifyAttachments = count($attachments);
            if ($adminifyAttachments != 0) {
                echo $adminifyAttachments;
            }
        }
    }


    function jltwp_adminify_rss_post_thumbnail($content)
    {
        global $post;
        if (has_post_thumbnail($post->ID)) {
            $content = '<p>' . get_the_post_thumbnail($post->ID) .
                '</p>' . get_the_content();
        }
        return $content;
    }


    function jltwp_adminify_tags_categories_support_all()
    {
        register_taxonomy_for_object_type('post_tag', 'page');
        register_taxonomy_for_object_type('category', 'page');
    }

    // ensure all tags and categories are included in queries
    function jltwp_adminify_tags_categories_support_query($wp_query)
    {
        if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
        if ($wp_query->get('category_name')) $wp_query->set('post_type', 'any');
    }


    function jltwp_adminify_remove_version()
    {
        return '';
    }


    function jltwp_adminify_imagelink_setup()
    {
        $image_set = get_option('image_default_link_type');

        if ($image_set !== 'none') {
            update_option('image_default_link_type', 'none');
        }
    }
}
