<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

class Module_Post_Color extends AdminSettingsModel
{
    public function __construct()
    {
        $this->general_post_settings();
    }

    public function get_defaults()
    {
        return [
            'post_status_bg_colors' => [
                'publish' => '#DBE2F5',
                'pending' => '#FCE4EE',
                'future'  => '#E0F1ED',
                'private' => '#FCF3D2',
                'draft'   => '#EBE0F5',
                'trash'   => '#EFF4E1',
            ],
            'post_thumb_column'   => '',
            'post_page_column_thumb_image'   => '',
            'post_page_id_column' => false,
            'taxonomy_id_column'  => false,
            'comment_id_column'   => false,
        ];
    }

    /**
     * Post Status colors
     */
    public function post_status_bg_colors(&$fields)
    {
        $fields[] = array(
            'type'    => 'subheading',
            'content'   => Utils::adminfiy_help_urls(
                __('Post Status Background Settings', 'adminify'),
                'https://wpadminify.com/kb/post-status-background-color/',
                'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
                'https://www.facebook.com/groups/jeweltheme',
                'https://wpadminify.com/support/'
            )
        );

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {

            $fields[] = array(
                'id'        => 'post_status_bg_colors',
                'type'      => 'color_group',
                'title'     => __('Post Status Background Colors', 'adminify'),
                'subtitle'  => __('Background Color by Post Status type', 'adminify'),
                'options'   => array(
                    'publish' => __('Publish BG Color', 'adminify'),
                    'pending' => __('Pending BG Color', 'adminify'),
                    'future'  => __('Future BG Color', 'adminify'),
                    'private' => __('Private BG Color', 'adminify'),
                    'draft'   => __('Draft BG Color', 'adminify'),
                    'trash'   => __('Trash BG Color', 'adminify'),
                ),
                'default'    => $this->get_default_field('post_status_bg_colors'),
            );
        } else {
            $fields[] = array(
                'type'       => 'notice',
                'title'     => __('Post Status Background', 'adminify'),
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro()
            );
        }
    }

    /**
     * Post Status Columns
     */

    public function post_status_columns(&$fields)
    {
        $fields[] = array(
            'type'    => 'subheading',
            'content' => __('Custom Columns', 'adminify'),
        );

        if (jltwp_adminify()->can_use_premium_code__premium_only() && jltwp_adminify()->is_plan('agency')) {
            $fields[] = array(
                'id'         => 'post_thumb_column',
                'type'       => 'switcher',
                'title'      => __('Show Thumbnail Column', 'adminify'),
                'subtitle'   => __('Display a thumbnail column before the title for post and page table lists.', 'adminify'),
                'text_on'    => 'Show',
                'text_off'   => 'Hide',
                'text_width' => 100,
                'default'    => $this->get_default_field('post_thumb_column'),
            );
            $fields[] = array(
                'id'           => 'post_page_column_thumb_image',
                'type'         => 'media',
                'class'        => 'custom-thumb-image',
                'title'        => __('Column Thumbnail Image', 'adminify'),
                'library'      => 'image',
                'preview_size' => 'thumbnail',
                'button_title' => __('Add Thumbnail Image', 'adminify'),
                'remove_title' => __('Remove Thumbnail Image', 'adminify'),
                'default'      => $this->get_default_field('post_page_column_thumb_image'),
                'dependency'   => array('post_thumb_column', '==', 'true', 'true')
            );
        } else {
            $fields[] = array(
                'type'       => 'notice',
                'title'      => __('Show Thumbnail Column', 'adminify'),
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro()
            );
        }

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $fields[] = array(
                'id'         => 'post_page_id_column',
                'type'       => 'switcher',
                'title'      => __('Show Post/Page ID Column', 'adminify'),
                'subtitle'   => __('Display a IDs column for post and page table lists.', 'adminify'),
                'text_on'    => __('Show', 'adminify'),
                'text_off'   => __('Hide', 'adminify'),
                'text_width' => 100,
                'default'    => $this->get_default_field('post_page_id_column'),
            );
        } else {
            $fields[] = array(
                'type'       => 'notice',
                'title'      => __('Show Post/Page ID Column', 'adminify'),
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro()
            );
        }

        $fields[] = array(
            'id'         => 'taxonomy_id_column',
            'type'       => 'switcher',
            'title'      => __('Show "Taxonomy ID" Column', 'adminify'),
            'subtitle'   => __('Taxonomy ID show on all possible types of taxonomies', 'adminify'),
            'text_on'    => __('Show', 'adminify'),
            'text_off'   => __('Hide', 'adminify'),
            'text_width' => 100,
            'default'    => $this->get_default_field('taxonomy_id_column'),
        );
        $fields[] = array(
            'id'         => 'comment_id_column',
            'type'       => 'switcher',
            'title'      => __('Show "Comment ID" Column', 'adminify'),
            'subtitle'   => __('Show Comment ID and Parent Comment ID Column', 'adminify'),
            'text_on'    => 'Show',
            'text_off'   => 'Hide',
            'text_width' => 100,
            'default'    => $this->get_default_field('comment_id_column'),
        );
    }

    public function general_post_settings()
    {
        if (!class_exists('ADMINIFY')) {
            return;
        }

        $fields = [];
        $this->post_status_bg_colors($fields);
        $this->post_status_columns($fields);

        \ADMINIFY::createSection($this->prefix, array(
            'title'  => __('Post Status/Column', 'adminify'),
            'parent' => 'module_settings',
            'icon'   => 'fas fa-paint-roller',
            'fields' => $fields
        ));
    }
}
