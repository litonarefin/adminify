<?php

namespace WPAdminify\Inc\Classes;

use WPAdminify\Inc\Admin\AdminSettings;
use WPAdminify\Inc\Admin\AdminSettingsModel;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * Post Columns: Featured Image and ID
 * @package WP Adminify
 *
 * @author WP Adminify <support@wpadminify.com>
 */

class CustomAdminColumns extends AdminSettingsModel
{
    public function __construct()
    {
        $this->options = (array) AdminSettings::get_instance()->get();
        add_action('admin_init', [$this, 'adminify_taxonomy_id_column']);
        add_action('admin_init', [$this, 'adminify_comments_id_column']);
    }

    /**
     * Taxonomy ID Column
     *
     * @return void
     */
    public function adminify_taxonomy_id_column()
    {
        // If not true then return
        if (empty($this->options['taxonomy_id_column'])) {
            return;
        }
        // Restrict the custom column to specific tax_types
        $tax_types = array(
            'category',
            'post_tag',
            'product_cat',
            'product_tag',
            'page_category',
            'page_tag',
            'recipe_category',
            'recipe_tag',
            'recipe_ingredient',
            'recipe_feature',
            'recipe_cuisine',
            'portfolio_category',
            'portfolio_tag',
            'portfolio_client',
        );

        if (empty($tax_types)) {
            return;
        }

        // Add custom column filter and action
        foreach ($tax_types as $taxonomy) {
            add_action("manage_edit-{$taxonomy}_columns", [$this, 'adminify_taxonomy_id_column_head']);
            add_filter("manage_edit-{$taxonomy}_sortable_columns", [$this, 'adminify_taxonomy_id_column_head']);
            add_filter("manage_{$taxonomy}_custom_column", [$this, 'adminify_taxonomy_id_column_content'], 11, 3);
        }
    }

    /**
     * Taxonomy ID Head
     *
     * @param [type] $column
     *
     * @return void
     */
    public function adminify_taxonomy_id_column_head($column)
    {
        $column['tax_id'] = esc_html__('ID', 'adminify');
        return $column;
    }

    /**
     * Taxonomy Column Content
     *
     * @param [type] $value
     * @param [type] $name
     * @param [type] $id
     *
     * @return void
     */
    function adminify_taxonomy_id_column_content($value, $name, $id)
    {
        return 'tax_id' === $name ? $id : $value;
    }


    /**
     * Comment ID Columns
     *
     * @return void
     */
    public function adminify_comments_id_column()
    {
        // If not true then return
        if (empty($this->options['comment_id_column'])) {
            return;
        }
        add_filter('manage_edit-comments_columns', [$this, 'adminify_add_comments_columns']);
        add_action('manage_comments_custom_column', [$this, 'adminify_add_comment_columns_content'], 10, 2);
    }

    public function adminify_add_comments_columns($columns)
    {
        $comment_columns = array(
            'adminify_comment_id' => __('ID', 'adminify'),
            'adminify_parent_id'  => __('Parent ID', 'adminify')
        );
        $columns = array_slice($columns, 0, 3, true) + $comment_columns + array_slice($columns, 3, NULL, true);
        // return the result
        return $columns;
    }

    public function adminify_add_comment_columns_content($column, $comment_ID)
    {
        global $comment;
        switch ($column):
            case 'adminify_comment_id': {
                    echo $comment_ID; // or echo $comment->comment_ID;
                    break;
                }
            case 'adminify_parent_id': {
                    echo $comment->comment_parent; // this will be printed inside the column
                    break;
                }
        endswitch;
    }
}
