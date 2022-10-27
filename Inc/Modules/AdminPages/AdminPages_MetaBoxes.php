<?php

namespace WPAdminify\Inc\Modules\AdminPages;

use WPAdminify\Inc\Utils;


// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WPAdminify
 * @package Admin Pages
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class AdminPages_MetaBoxes extends AdminPagesModel
{
    public function __construct()
    {
        // this should be first so the default values get stored
        $this->admin_pages_metaboxes();
        parent::__construct((array) get_option($this->prefix));

        add_filter('submenu_file', [$this, 'set_submenu'], 100, 2);

        add_filter('manage_adminify_admin_page_posts_columns', [$this, 'set_columns']);
        add_action('manage_adminify_admin_page_posts_custom_column', [$this, 'adminify_column_content'], 10, 2);
    }


    public function get_defaults()
    {
        return [
            '_wp_adminify_menu_type' => 'top_level',
            '_wp_adminify_sub_menu_item' => '',
            '_wp_adminify_menu_order' => 10,
            '_wp_adminify_menu_icon' => 'dashicons dashicons-admin-site-alt',
            '_wp_adminify_page_title' => '',
            '_wp_adminify_remove_margin' => '',
            '_wp_adminify_remove_notice' => '',
            '_wp_adminify_user_roles' => '',
            '_wp_adminify_script_type' => 'css',
            '_wp_adminify_custom_js' => '',
            '_wp_adminify_custom_css' => ''
        ];
    }



    // Set List Table Admin Pages Columns
    public function set_columns($columns)
    {
        $columns = array(
            'cb'          => '<input type="checkbox" />',
            'title'       => __('Page Name', 'adminify'),
            'icon'        => __('Menu Icon', 'adminify'),
            'parent_menu' => __('Parent Menu', 'adminify'),
            'roles'       => __('User Roles', 'adminify')
        );

        return $columns;
    }

    // User Roles Column Content
    public function user_roles_column_content($allowed_roles, $post_id)
    {
        $user_roles = Utils::post_meta('_wp_adminify_user_roles');
        $roles = is_serialized($user_roles) ? unserialize($user_roles) : $user_roles;
        $roles = empty($roles) ? array('all') : $roles;
        $roles = implode(', ', $roles);

        return $roles;
    }


    // List Table Admin Pages Column Contents
    public function adminify_column_content($column, $post_id)
    {
        $admin_menu_type = Utils::post_meta('_wp_adminify_menu_type');

        switch ($column) {
            case 'parent_menu':
                $parent_menu = __('None', 'adminify');
                if ($admin_menu_type === 'sub_level') {
                    $parent_slug = Utils::post_meta('_wp_adminify_sub_menu_item');

                    foreach ($GLOBALS['menu'] as $menu) {
                        if ($menu[2] === $parent_slug) {
                            $parent_menu = $menu[0];
                            break;
                        }
                    }
                }
                echo esc_html($parent_menu);
                break;

            case 'roles':
                $allowed_roles = __('All', 'adminify');
                $allowed_roles = apply_filters('adminify_admin_page_user_roles', $this->user_roles_column_content($allowed_roles, $post_id));
                echo ucwords($allowed_roles);
                break;


            case 'icon':
                $menu_icon = Utils::post_meta('_wp_adminify_menu_icon');

                $icon_class = $menu_icon ? $menu_icon : 'dashicons dashicons-no is-empty';

                echo ('sub_level' === $admin_menu_type ? __('None', 'adminify') : '<i class="' . esc_attr($icon_class) . '"></i>');
                break;
        }
    }

    public function set_submenu($submenu_file, $parent_file)
    {
        global $current_screen, $parent_file;
        if (in_array($current_screen->base, array('post', 'edit')) && 'adminify_admin_page' === $current_screen->post_type) {
            $submenu_file = 'edit.php?post_type=adminify_admin_page';
        }
        return $submenu_file;
    }


    public static function get_wp_admin_menus()
    {
        global $menu;

        $options = [];

        if (!empty($menu) && is_array($menu)) {
            foreach ($menu as $item) {
                if (!empty($item[0])) {
                    // the preg_replace removes "Comments" & "Plugins" menu spans.
                    $options[$item[2]] = (preg_replace('/\<span.*?>.*?\<\/span><\/span>/s', '', $item[0]));
                }
            }
        }

        return $options;
    }

    public static function get_wp_admin_submenus()
    {

        global $submenu;

        $options = [];

        if (!empty($submenu) && is_array($submenu)) {
            foreach ($submenu as $items) {
                foreach ($items as $item) {
                    if (!empty($item[0])) {
                        $options[$item[1]] = (preg_replace('/\<span.*?>.*?\<\/span><\/span>/s', '', $item[0]));
                    }
                }
            }
        }

        return $options;
    }


    public function get_menu_type_fiels(&$menu_type_fields)
    {
        $menu_type_fields[] = array(
            'id'      => $this->prefix . 'menu_type',
            'type'    => 'select',
            'title'   => __('Menu Type', 'adminify'),
            'options' => array(
                'top_level' => __('Top Level Menu', 'adminify'),
                'sub_level' => __('Sub Menu', 'adminify'),
            ),
            'default' => $this->get_default_field('_wp_adminify_menu_type')
        );

        $menu_type_fields[] = array(
            'id'          => $this->prefix . 'sub_menu_item',
            'type'        => 'select',
            'title'       => __('Select Sub Menu', 'adminify'),
            'placeholder' => __('Select a menu', 'adminify'),
            'options'     => 'WPAdminify\Inc\Modules\AdminPages\AdminPages_MetaBoxes::get_wp_admin_menus',
            'dependency'  => array($this->prefix . 'menu_type', '==', 'sub_level', 'true'),
            'default'     => $this->get_default_field('_wp_adminify_sub_menu_item')
        );

        $menu_type_fields[] = array(
            'id'      => $this->prefix . 'menu_order',
            'type'    => 'text',
            'title'   => __('Menu Order', 'adminify'),
            'default' => $this->get_default_field('_wp_adminify_menu_order')
        );

        $menu_type_fields[] = array(
            'id'      => $this->prefix . 'menu_icon',
            'type'    => 'icon',
            'title'   => __('Icon', 'adminify'),
            'default' => $this->get_default_field('_wp_adminify_menu_icon')
        );
    }


    public function admin_pages_metaboxes()
    {
        if (!class_exists('ADMINIFY')) {
            return;
        }

        // Admin Pages Metabox
        \ADMINIFY::createMetabox($this->prefix, array(
            'title'     => __('Menu Attributes', 'adminify'),
            'post_type' => 'adminify_admin_page',
            'context'   => 'side',
            'priority'  => 'low',
            'data_type' => 'unserialize'
        ));

        $menu_type_fields = [];
        $this->get_menu_type_fiels($menu_type_fields);

        // Activate
        \ADMINIFY::createSection($this->prefix, array(
            'fields' => $menu_type_fields
        ));

        // Display Options
        \ADMINIFY::createMetabox($this->prefix . 'admin_page_display', array(
            'title'     => __('Display Options', 'adminify'),
            'post_type' => 'adminify_admin_page',
            'context'   => 'normal',
            'priority'  => 'high',
            'data_type' => 'unserialize'
        ));

        $remove_notice = [];
        $this->get_remove_notice_fields($remove_notice);
        \ADMINIFY::createSection($this->prefix . 'admin_page_display', array(
            'title'  => __('Enable/Disable', 'adminify'),
            'fields' => $remove_notice
        ));

        // User Roles
        \ADMINIFY::createSection($this->prefix . 'admin_page_display', array(
            'title'  => 'User Roles Access',
            'fields' => array(
                array(
                    'id'          => $this->prefix . 'user_roles',
                    'type'        => 'select',
                    'title'       => __('Allow users to access this page', 'adminify'),
                    'placeholder' => __('Select a role', 'adminify'),
                    'chosen'      => true,
                    'multiple'    => true,
                    'options'     => 'roles',
                    'default'     => $this->get_default_field('_wp_adminify_user_roles')
                ),

            )
        ));

        $custom_css_js = [];
        $this->get_custom_css_js($custom_css_js);

        // Advanced
        \ADMINIFY::createSection($this->prefix . 'admin_page_display', array(
            'title'  => __('Custom CSS/JS', 'adminify'),
            'fields' => $custom_css_js
        ));
    }


    public function get_remove_notice_fields(&$remove_notice)
    {
        $remove_notice[] = array(
            'id'      => $this->prefix . 'page_title',
            'type'    => 'checkbox',
            'title'   => __('Remove Page Title', 'adminify'),
            'label'   => __('Remove Page Title from your created Custom Admin Page.', 'adminify'),
            'default' => $this->get_default_field('_wp_adminify_page_title')
        );
        $remove_notice[] = array(
            'id'      => $this->prefix . 'remove_margin',
            'type'    => 'checkbox',
            'title'   => __('Remove Page Margin', 'adminify'),
            'label'   => __('Remove default Page Margin from Custom Admin Page', 'adminify'),
            'default' => $this->get_default_field('_wp_adminify_remove_margin')
        );
        $remove_notice[] = array(
            'id'      => $this->prefix . 'remove_notice',
            'type'    => 'checkbox',
            'title'   => __('Remove Admin Notices', 'adminify'),
            'label'   => __('Remove Admin Notices from Custom Admin page', 'adminify'),
            'default' => $this->get_default_field('_wp_adminify_remove_notice')
        );
    }

    /**
     * Custom CSS/JS Options
     *
     * @param [type] $custom_css_js
     *
     * @return void
     */
    public function get_custom_css_js(&$custom_css_js)
    {
        $custom_css_js[] = array(
            'id'      => $this->prefix . 'script_type',
            'type'    => 'button_set',
            'title'   => __('Snippet Type', 'adminify'),
            'options' => array(
                'css' => __('CSS', 'adminify'),
                'js'  => __('JS', 'adminify'),
            ),
            'default' => $this->get_default_field('_wp_adminify_script_type')
        );

        $custom_css_js[] = array(
            'id'       => $this->prefix . 'custom_js',
            'type'     => 'code_editor',
            'title'    => __('Custom JS', 'adminify'),
            'subtitle' => __('Add your Custom Script here', 'adminify'),
            'settings' => array(
                'theme' => 'dracula',
                'mode'  => 'javascript',
            ),
            'dependency' => array($this->prefix . 'script_type', '==', 'js'),
            'default'    => $this->get_default_field('_wp_adminify_custom_js')
        );

        $custom_css_js[] = array(
            'id'       => $this->prefix . 'custom_css',
            'type'     => 'code_editor',
            'title'    => __('Custom CSS', 'adminify'),
            'subtitle' => __('Add your Custom CSS here', 'adminify'),
            'settings' => array(
                'theme' => 'mbo',
                'mode'  => 'css',
            ),
            'dependency' => array($this->prefix . 'script_type', '==', 'css'),
            'default'    => $this->get_default_field('_wp_adminify_custom_css')
        );
    }
}
