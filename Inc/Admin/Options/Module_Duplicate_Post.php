<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

if (!class_exists('Module_Duplicate_Post')) {
    class Module_Duplicate_Post extends AdminSettingsModel
    {
        public function __construct()
        {
            $this->adminify_duplicate_post_settings();
        }


        public function get_defaults()
        {
            return [
                'adminify_clone_post_user_roles' => [],
                'adminify_clone_post_posts'      => ['page'],
                'adminify_clone_post_taxonomies' => [],
            ];
        }

        public function adminify_duplicate_post_user_roles(&$fields)
        {

            $fields[] = array(
                'type'    => 'subheading',
                'content'   => Utils::adminfiy_help_urls(
                    __('Duplicate Post/Page/Custom Post Types Settings', 'adminify'),
                    'https://wpadminify.com/kb/duplicate-post-using-wp-adminify/',
                    'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
                    'https://www.facebook.com/groups/jeweltheme',
                    'https://wpadminify.com/support/post-page-custom-post-type-duplicator/'
                )
            );

            $fields[] = array(
                'id'          => 'adminify_clone_post_user_roles',
                'type'        => 'select',
                'title'       => __('Disable for', 'adminify'),
                'placeholder' => __('Select User roles you want to show', 'adminify'),
                'options'     => 'roles',
                'multiple'    => true,
                'chosen'      => true,
                'default'     => $this->get_default_field('adminify_clone_post_user_roles'),
            );

            $fields[] = array(
                'id'         => 'adminify_clone_post_posts',
                'type'       => 'checkbox',
                'title'      => __('Enable for Post Types', 'adminify'),
                'subtitle'   => __('Select Post Types for Enabling Duplicate feature', 'adminify'),
                'options'    => 'post_types',
                'query_args' => array(
                    'orderby' => 'post_title',
                    'order'   => 'ASC',
                ),
                'default' => $this->get_default_field('adminify_clone_post_posts'),
            );

            if (!jltwp_adminify()->can_use_premium_code__premium_only()) {
                $fields[] = array(
                    'type'       => 'notice',
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array(
                        array('adminify_clone_post_posts', 'not-any', 'post,page', 'true'),
                        array('adminify_clone_post_posts', '!=', '', 'true'),
                    ),
                );
            }
        }


        public function adminify_duplicate_post_taxonomy(&$fields)
        {
            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $fields[] =  array(
                    'id'         => 'adminify_clone_post_taxonomies',
                    'type'       => 'checkbox',
                    'title'      => __('Enable for Taxonomies', 'adminify'),
                    'options'    => 'WPAdminify\Inc\Admin\Options\Module_PostTypesOrder::get_all_taxonomies',
                    'query_args' => array(
                        'orderby' => 'post_title',
                        'order'   => 'ASC',
                    ),
                    'default' => $this->get_default_field('adminify_clone_post_taxonomies'),
                );
            } else {
                $fields[] =  array(
                    'type'    => 'notice',
                    'style'   => 'warning',
                    'title'   => __('Enable for Taxonomies', 'adminify'),
                    'content' => Utils::adminify_upgrade_pro(),
                );
            }
        }


        /**
         * Adminify Duplicate Post Settings
         */
        public function adminify_duplicate_post_settings()
        {

            if (!class_exists('ADMINIFY')) {
                return;
            }

            $fields = [];
            $this->adminify_duplicate_post_user_roles($fields);
            // $this->adminify_duplicate_post_taxonomy($fields);

            // Duplicate Post Setttings
            \ADMINIFY::createSection($this->prefix, array(
                'title'  => __('Duplicate Post', 'adminify'),
                'id'     => 'duplicate_post_section',
                'parent' => 'module_settings',
                'icon'   => 'far fa-copy',
                'fields' => $fields
            ));
        }
    }
}
