<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

if (!class_exists('Module_PostTypesOrder')) {
    class Module_PostTypesOrder extends AdminSettingsModel
    {
        public function __construct()
        {
            $this->post_types_order_settings();
        }

        public function get_defaults()
        {
            return [
                'pto_taxonomies' => [],
                'pto_user_roles' => [],
                'pto_posts'      => ['page'],
                'pto_media'      => true
            ];
        }

        public static function get_all_taxonomies()
        {
            $taxonomies = get_taxonomies(array(
                'show_ui' => true,
            ), 'objects');
            $taxonomy_names = [];
            foreach ($taxonomies as $taxonomy) {
                if ($taxonomy->name == 'post_format') continue;
                $taxonomy_names[$taxonomy->name] = $taxonomy->label;
            }
            return $taxonomy_names;
        }


        public function adminify_pto_taxonomy_notice(&$fields)
        {
            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $fields[] =  array(
                    'id'         => 'pto_taxonomies',
                    'type'       => 'checkbox',
                    'title'      => __('Sortable Taxonomies', 'adminify'),
                    'options'    => 'WPAdminify\Inc\Admin\Options\Module_PostTypesOrder::get_all_taxonomies',
                    'query_args' => array(
                        'orderby' => 'post_title',
                        'order'   => 'ASC',
                    ),
                    'default' => $this->get_default_field('pto_taxonomies'),
                );
            } else {
                $fields[] =  array(
                    'type'    => 'notice',
                    'style'   => 'warning',
                    'title'   => __('Sortable Taxonomies', 'adminify'),
                    'content' => Utils::adminify_upgrade_pro(),
                );
            }
        }


        /**
         * User Roles
         */
        public function post_types_order_roles(&$fields)
        {
            $fields[] = array(
                'type'    => 'subheading',
                'content'   => Utils::adminfiy_help_urls(
                    'Post Types Order Settings',
                    'https://wpadminify.com/kb/post-type-order-module',
                    'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
                    'https://www.facebook.com/groups/jeweltheme',
                    'https://wpadminify.com/support/post-types-order'
                )
            );
            $fields[] = array(
                'id'          => 'pto_user_roles',
                'type'        => 'select',
                'title'       => __('Disable for', 'adminify'),
                'placeholder' => __('Select User roles you want to show', 'adminify'),
                'options'     => 'roles',
                'multiple'    => true,
                'chosen'      => true,
                'default'     => $this->get_default_field('pto_user_roles'),
            );
            $fields[] = array(
                'id'         => 'pto_posts',
                'type'       => 'checkbox',
                'title'      => __('Sortable Post Types', 'adminify'),
                'subtitle'   => __('Select Post Types for sorting', 'adminify'),
                'options'    => 'post_types',
                'query_args' => array(
                    'orderby' => 'post_title',
                    'order'   => 'ASC',
                ),
                'default' => $this->get_default_field('pto_posts'),
            );

            if (!jltwp_adminify()->can_use_premium_code__premium_only()) {
                $fields[] = array(
                    'type'       => 'notice',
                    'style'      => 'warning',
                    'content'    => Utils::adminify_upgrade_pro(),
                    'dependency' => array(
                        array('pto_posts', 'not-any', 'post,page', 'true'),
                        array('pto_posts', '!=', '', 'true'),
                    ),
                );
            }
        }


        /**
         * Media Elements Sortable
         *
         * @return void
         */

        public function post_types_order_media(&$fields)
        {
            $fields[] = array(
                'id'         => 'pto_media',
                'type'       => 'switcher',
                'title'      => __('Media Sortable', 'adminify'),
                'text_on'    => 'Enabled',
                'text_off'   => 'Disabled',
                'text_width' => 100,
                'default'    => $this->get_default_field('pto_media'),
            );
        }

        public function post_types_order_settings()
        {

            if (!class_exists('ADMINIFY')) {
                return;
            }

            $fields = [];
            $this->post_types_order_roles($fields);
            $this->adminify_pto_taxonomy_notice($fields);
            $this->post_types_order_media($fields);

            // Post Types Order Section
            \ADMINIFY::createSection($this->prefix, array(
                'title'  => __('Post Types Order', 'adminify'),
                'id'     => 'post_types_order_section',
                'parent' => 'module_settings',
                'icon'   => 'fas fa-sort-amount-up-alt',
                'fields' => $fields
            ));
        }
    }
}
