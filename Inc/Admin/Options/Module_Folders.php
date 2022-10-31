<?php

namespace WPAdminify\Inc\Admin\Options;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Admin\AdminSettingsModel ;
if ( !defined( 'ABSPATH' ) ) {
    die;
}
// Cannot access directly.
if ( !class_exists( 'Module_Folders' ) ) {
    class Module_Folders extends AdminSettingsModel
    {
        public function __construct()
        {
            $this->folders_settings();
        }
        
        public function get_defaults()
        {
            return [
                'folders_user_roles' => [],
                'folders_enable_for' => [ 'post', 'page' ],
                'folders_media'      => true,
            ];
        }
        
        /**
         * User Roles
         */
        public function folders_user_roles( &$fields )
        {
            $fields[] = [
                'type'    => 'subheading',
                'content' => Utils::adminfiy_help_urls(
                __( 'Folders Settings', 'adminify' ),
                'https://wpadminify.com/kb/organize-media-library-pages-posts-post-type-using-folder/',
                'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
                'https://www.facebook.com/groups/jeweltheme',
                'https://wpadminify.com/support/folders/'
            ),
            ];
            $fields[] = [
                'id'          => 'folders_user_roles',
                'type'        => 'select',
                'title'       => __( 'Disable for', 'adminify' ),
                'placeholder' => __( 'Select User roles you want to show', 'adminify' ),
                'options'     => 'roles',
                'multiple'    => true,
                'chosen'      => true,
                'default'     => $this->get_default_field( 'folders_user_roles' ),
            ];
            $fields[] = [
                'id'         => 'folders_enable_for',
                'type'       => 'checkbox',
                'title'      => __( 'Enable Folders for', 'adminify' ),
                'subtitle'   => __( 'Select Post Types for enabling Folders Module', 'adminify' ),
                'options'    => 'post_types',
                'query_args' => [
                'orderby' => 'post_title',
                'order'   => 'ASC',
            ],
                'default'    => $this->get_default_field( 'folders_enable_for' ),
            ];
            $fields[] = [
                'type'       => 'notice',
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro(),
                'dependency' => [ [
                'folders_enable_for',
                'not-any',
                'post,page',
                'true'
            ], [
                'folders_enable_for',
                '!=',
                '',
                'true'
            ] ],
            ];
        }
        
        /**
         * Media Elements Sortable
         *
         * @return void
         */
        public function folders_for_media( &$fields )
        {
            $fields[] = [
                'id'         => 'folders_media',
                'type'       => 'switcher',
                'title'      => __( 'Enable for Media', 'adminify' ),
                'text_on'    => __( 'Enabled', 'adminify' ),
                'text_off'   => __( 'Disabled', 'adminify' ),
                'text_width' => 100,
                'default'    => $this->get_default_field( 'folders_media' ),
            ];
        }
        
        /**
         * Module: Folders
         *
         * @return void
         */
        public function folders_settings()
        {
            if ( !class_exists( 'ADMINIFY' ) ) {
                return;
            }
            $fields = [];
            $this->folders_user_roles( $fields );
            $this->folders_for_media( $fields );
            // Folders Order Section
            \ADMINIFY::createSection( $this->prefix, [
                'title'  => __( 'Folders', 'adminify' ),
                'id'     => 'module_folders_section',
                'parent' => 'module_settings',
                'icon'   => 'far fa-folder-open',
                'fields' => $fields,
            ] );
        }
    
    }
}