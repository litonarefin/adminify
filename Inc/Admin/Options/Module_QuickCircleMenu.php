<?php

namespace WPAdminify\Inc\Admin\Options;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Admin\AdminSettingsModel ;
// no direct access allowed
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * @package WPAdminify
 * Quick Menu
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */
class Module_QuickCircleMenu extends AdminSettingsModel
{
    public function __construct()
    {
        $this->quick_menu_settings();
    }
    
    public function get_defaults()
    {
        return [
            'quick_menus_user_roles' => [],
            'quick_menus'            => [ [
            'menu_title' => __( 'New Post', 'adminify' ),
            'menu_link'  => [
            'url'    => esc_url( admin_url( 'post-new.php' ) ),
            'target' => '_self',
        ],
            'menu_icon'  => 'dashicons dashicons-edit-page',
        ], [
            'menu_title' => __( 'New Page', 'adminify' ),
            'menu_link'  => [
            'url'    => esc_url( admin_url( 'post-new.php?post_type=page' ) ),
            'target' => '_self',
        ],
            'menu_icon'  => 'dashicons dashicons-welcome-add-page',
        ], [
            'menu_title' => __( 'New Media', 'adminify' ),
            'menu_link'  => [
            'url'    => esc_url( admin_url( 'media-new.php' ) ),
            'target' => '_self',
        ],
            'menu_icon'  => 'dashicons dashicons-admin-media',
        ] ],
        ];
    }
    
    /**
     * User Roles
     *
     * @return void
     */
    public function quick_menu_user_roles( &$fields )
    {
        $fields[] = [
            'type'    => 'subheading',
            'content' => Utils::adminfiy_help_urls(
            __( 'Quick Menu Settings', 'adminify' ),
            'https://wpadminify.com/kb/floating-dashboard-quick-menu',
            'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
            'https://www.facebook.com/groups/jeweltheme',
            'https://wpadminify.com/support/quick-circle-menu/'
        ),
        ];
        $fields[] = [
            'id'          => 'quick_menus_user_roles',
            'type'        => 'select',
            'title'       => __( 'Disable for', 'adminify' ),
            'placeholder' => __( 'Select User roles you want to show', 'adminify' ),
            'options'     => 'roles',
            'multiple'    => true,
            'chosen'      => true,
            'default'     => $this->get_default_field( 'quick_menus_user_roles' ),
        ];
    }
    
    /**
     * Default Data Settings
     */
    public function quick_menu_default_settings( &$fields )
    {
        $fields[] = [
            'type'    => 'subheading',
            'content' => __( 'Add/Remove Quick Menu', 'adminify' ),
        ];
        $fields[] = [
            'id'                     => 'quick_menus',
            'type'                   => 'group',
            'title'                  => '',
            'accordion_title_prefix' => __( 'Quick Menu: ', 'adminify' ),
            'accordion_title_number' => true,
            'accordion_title_auto'   => true,
            'max'                    => 3,
            'max_text'               => __( 'Get <strong>Pro Version</strong> to Unlock this feature. <a href="https://wpadminify.com/pricing" target="_blank">Upgrade to Pro Now!</a>', 'adminify' ),
            'button_title'           => __( 'Add New Quick Menu', 'adminify' ),
            'fields'                 => [ [
            'id'    => 'menu_title',
            'type'  => 'text',
            'title' => __( 'Menu Title', 'adminify' ),
        ], [
            'id'           => 'menu_link',
            'type'         => 'link',
            'title'        => __( 'Link', 'adminify' ),
            'add_title'    => __( 'Add Menu Link', 'adminify' ),
            'edit_title'   => __( 'Edit Menu Link', 'adminify' ),
            'remove_title' => __( 'Remove Menu Link', 'adminify' ),
        ], [
            'id'           => 'menu_icon',
            'type'         => 'icon',
            'title'        => __( 'Icon', 'adminify' ),
            'button_title' => __( 'Add Menu Icon', 'adminify' ),
            'remove_title' => __( 'Remove Menu Icon', 'adminify' ),
        ] ],
            'default'                => $this->get_default_field( 'quick_menus' ),
        ];
    }
    
    public function quick_menu_settings()
    {
        if ( !class_exists( 'ADMINIFY' ) ) {
            return;
        }
        $fields = [];
        $this->quick_menu_user_roles( $fields );
        $this->quick_menu_default_settings( $fields );
        // Quick Menu Section
        \ADMINIFY::createSection( $this->prefix, [
            'title'  => __( 'Quick Menu', 'adminify' ),
            'icon'   => 'fas fa-plane-departure',
            'parent' => 'module_settings',
            'fields' => $fields,
        ] );
    }

}