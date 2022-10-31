<?php

namespace WPAdminify\Inc\Modules\MenuEditor;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Admin\AdminSettings ;
use  WPAdminify\Inc\Modules\MenuEditor\MenuEditorAssets ;
// no direct access allowed
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * WP Adminify
 *
 * @package WP Adminify: Menu Editor
 *
 * @author WP Adminify <support@wpadminify.com>
 */
if ( !class_exists( 'MenuEditor' ) ) {
    class MenuEditor extends MenuEditorModel
    {
        public  $url ;
        public  $menu ;
        public  $submenu ;
        public function __construct()
        {
            $this->url = WP_ADMINIFY_URL . 'Inc/Modules/MenuEditor';
            $this->menu_settings = ( new MenuEditorOptions() )->get();
            $this->options = (array) AdminSettings::get_instance()->get();
            add_filter( 'upload_mimes', [ $this, 'custom_icon_mime_types' ] );
            add_action( 'admin_menu', [ $this, 'jltwp_adminify_menu_editor_submenu' ], 51 );
            add_filter( 'admin_body_class', [ $this, 'jltwp_adminify_menu_editor_body_class' ] );
            add_filter( 'parent_file', [ $this, 'set_menu' ], 800 );
            add_filter( 'parent_file', [ $this, 'apply_menu' ], 900 );
            add_action( 'wp_ajax_adminify_save_menu_settings', [ $this, 'adminify_save_menu_settings' ] );
            add_action( 'wp_ajax_adminify_reset_menu_settings', [ $this, 'adminify_reset_menu_settings' ] );
            add_action( 'wp_ajax_adminify_export_menu_settings', [ $this, 'adminify_export_menu_settings' ] );
            add_action( 'wp_ajax_adminify_import_menu_settings', [ $this, 'adminify_import_menu_settings' ] );
            add_action( 'wp_ajax_adminify_file_upload', [ $this, 'adminify_file_upload_callback' ] );
            add_action( 'wp_ajax_adminify_load_custom_icons', [ $this, 'adminify_load_custom_icons_callback' ] );
            new MenuEditorAssets();
        }
        
        public function custom_icon_mime_types( $mimes )
        {
            $mimes['svg'] = 'image/svg+xml';
            return $mimes;
        }
        
        public function filter_attachment( $value )
        {
            // return $value->post_title == 'adminify-custom-icon';
            return strpos( $value->guid, 'adminify-custom-icon' ) !== false;
        }
        
        public function adminify_load_custom_icons_callback()
        {
            $result['images'] = null;
            $query = get_posts( [
                'post_type'   => 'attachment',
                'numberposts' => -1,
            ] );
            $filtered = array_filter( $query, [ $this, 'filter_attachment' ] );
            foreach ( $filtered as $key => $value ) {
                $result['images'][$value->ID] = $value->guid;
            }
            echo  wp_json_encode( $result ) ;
            die;
        }
        
        public function adminify_file_upload_callback()
        {
            $result['status'] = false;
            check_ajax_referer( 'adminify-menu-editor-security-nonce', 'security' );
            $upload_dir = wp_upload_dir();
            $targeted_dir = $upload_dir['basedir'] . '/adminify-custom-icons';
            if ( !is_dir( $targeted_dir ) ) {
                wp_mkdir_p( $targeted_dir );
            }
            add_filter( 'upload_dir', [ $this, 'adminify_icon_custom_upload_dir' ] );
            $files = $_FILES['my_file_upload'];
            foreach ( $files['name'] as $key => $value ) {
                
                if ( $files['name'][$key] ) {
                    $file = [
                        'name'     => $files['name'][$key],
                        'type'     => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error'    => $files['error'][$key],
                        'size'     => $files['size'][$key],
                    ];
                    $_FILES = [
                        'upload_file' => $file,
                    ];
                    $attachment_id = media_handle_upload( 'upload_file', 0 );
                    
                    if ( is_wp_error( $attachment_id ) ) {
                        // There was an error uploading the image.
                        $result['status'] = false;
                        $result['message'] = 'Error uploading file.';
                    } else {
                        // The image was uploaded successfully!
                        $result['status'] = true;
                        $result['message'] = 'File Uploaded successfully.';
                        $result['images'][$attachment_id] = wp_get_attachment_url( $attachment_id );
                    }
                
                }
            
            }
            remove_filter( 'upload_dir', [ $this, 'adminify_icon_custom_upload_dir' ] );
            echo  wp_json_encode( $result ) ;
            wp_die();
        }
        
        public function adminify_icon_custom_upload_dir( $dir_data )
        {
            // $dir_data already you might want to use
            $custom_dir = 'adminify-custom-icons';
            return [
                'path'    => $dir_data['basedir'] . '/' . $custom_dir,
                'url'     => $dir_data['baseurl'] . '/' . $custom_dir,
                'subdir'  => '/' . $custom_dir,
                'basedir' => $dir_data['basedir'],
                'baseurl' => $dir_data['baseurl'],
                'error'   => $dir_data['error'],
            ];
        }
        
        // Menu Editor Body Class
        public function jltwp_adminify_menu_editor_body_class( $classes )
        {
            $classes .= ' adminify_menu_editor ';
            return $classes;
        }
        
        /**
         * Sanitises and strips tags of input from ajax
         *
         * @since 1.0.0
         * @variables $values = item to clean (array or string)
         */
        public function clean_ajax_input( $values )
        {
            
            if ( is_array( $values ) ) {
                foreach ( $values as $index => $in ) {
                    
                    if ( is_array( $in ) ) {
                        $values[$index] = $this->clean_ajax_input( $in );
                    } else {
                        $values[$index] = strip_tags( $in );
                    }
                
                }
            } else {
                $values = strip_tags( $values );
            }
            
            return $values;
        }
        
        /**
         * Returns ajax error
         *
         * @since 1.4
         * @variables $message = error message to send back to user (string)
         */
        public function ajax_error_message( $message )
        {
            $returndata = [];
            $returndata['error'] = true;
            $returndata['error_message'] = $message;
            return json_encode( $returndata );
        }
        
        public function adminify_save_menu_settings()
        {
            
            if ( defined( 'DOING_AJAX' ) && DOING_AJAX && check_ajax_referer( 'adminify-menu-editor-security-nonce', 'security' ) > 0 ) {
                $options = $_POST['options'];
                $options = $this->clean_ajax_input( $options );
                
                if ( $options == '' || !is_array( $options ) ) {
                    $message = __( 'No options supplied to save', 'adminify' );
                    echo  Utils::wp_kses_custom( $this->ajax_error_message( $message ) ) ;
                    die;
                }
                
                
                if ( is_array( $options ) ) {
                    update_option( $this->prefix, $options );
                    $returndata = [];
                    $returndata['success'] = true;
                    $returndata['message'] = __( 'Settings saved', 'adminify' );
                    echo  json_encode( $returndata ) ;
                    die;
                } else {
                    $message = __( 'Something went wrong', 'adminify' );
                    echo  Utils::wp_kses_custom( $this->ajax_error_message( $message ) ) ;
                    die;
                }
            
            }
            
            die;
        }
        
        /**
         * Menu Editor Settings Reset
         *
         * @return void
         */
        public function adminify_reset_menu_settings()
        {
            
            if ( defined( 'DOING_AJAX' ) && DOING_AJAX && check_ajax_referer( 'adminify-menu-editor-security-nonce', 'security' ) > 0 ) {
                update_option( $this->prefix, [] );
                $menu_editor_options = get_option( $this->prefix );
                
                if ( !$menu_editor_options ) {
                    $returndata = [];
                    $returndata['success'] = true;
                    $returndata['message'] = __( 'Settings reset', 'adminify' );
                    echo  json_encode( $returndata ) ;
                    die;
                } else {
                    $message = __( 'Something went wrong', 'adminify' );
                    echo  Utils::wp_kses_custom( $this->ajax_error_message( $message ) ) ;
                    die;
                }
            
            }
            
            die;
        }
        
        /**
         * Export Menu Editor Settings
         *
         * @return void
         */
        public function adminify_export_menu_settings()
        {
            
            if ( defined( 'DOING_AJAX' ) && DOING_AJAX && check_ajax_referer( 'adminify-menu-editor-security-nonce', 'security' ) > 0 ) {
                $menu_editor_options = get_option( $this->prefix );
                echo  json_encode( $menu_editor_options ) ;
            }
            
            die;
        }
        
        /**
         * Import Menu Editor Settings
         *
         * @since 1.0.0
         */
        public function adminify_import_menu_settings()
        {
            
            if ( defined( 'DOING_AJAX' ) && DOING_AJAX && check_ajax_referer( 'adminify-menu-editor-security-nonce', 'security' ) > 0 ) {
                $new_options = $this->clean_ajax_input( $_POST['settings'] );
                
                if ( $new_options == '' || !is_array( $new_options ) ) {
                    $message = __( 'No options supplied to save', 'adminify' );
                    echo  Utils::wp_kses_custom( $this->ajax_error_message( $message ) ) ;
                    die;
                }
                
                
                if ( is_array( $new_options ) ) {
                    update_option( $this->prefix, $new_options );
                    $returndata = [];
                    $returndata['success'] = true;
                    $returndata['message'] = __( 'Menu Imported', 'adminify' );
                    echo  json_encode( $returndata ) ;
                    die;
                } else {
                    $message = __( 'Something went wrong', 'adminify' );
                    echo  Utils::wp_kses_custom( $this->ajax_error_message( $message ) ) ;
                    die;
                }
            
            }
            
            die;
        }
        
        /**
         * Get menu items
         *
         * @param [type] $parent_file
         *
         * @return void
         */
        public function set_menu( $parent_file )
        {
            global  $menu, $submenu ;
            $this->menu = $this->sort_menu_settings( $menu );
            $this->submenu = $this->sort_sub_menu_settings( $this->menu, $submenu );
            return $parent_file;
        }
        
        /**
         * Sorts Menu's for Option settings
         */
        public function sort_menu_settings( $thismenu )
        {
            $menu_settings = $this->menu_settings;
            $tempmenu = [];
            foreach ( $thismenu as $key => $current_menu_item ) {
                $next_menu_item = next( $thismenu );
                $optiongroup = [];
                $order = $key;
                $separator = 0;
                $icon = null;
                $hidden_for = [];
                if ( !empty($next_menu_item) && strpos( $next_menu_item[2], 'separator' ) !== false ) {
                    $separator = 1;
                }
                if ( is_array( $menu_settings ) ) {
                    
                    if ( isset( $menu_settings[$current_menu_item[2]] ) ) {
                        $optiongroup = $menu_settings[$current_menu_item[2]];
                        if ( isset( $optiongroup['order'] ) ) {
                            $order = $optiongroup['order'];
                        }
                        if ( isset( $optiongroup['separator'] ) ) {
                            $separator = $optiongroup['separator'];
                        }
                        if ( !empty($optiongroup['icon']) ) {
                            $icon = $optiongroup['icon'];
                        }
                        if ( !empty($optiongroup['hidden_for']) ) {
                            $hidden_for = $optiongroup['hidden_for'];
                        }
                    }
                
                }
                $current_menu_item['order'] = $order;
                $current_menu_item['separator'] = $separator;
                
                if ( empty($this->options['admin_ui']) ) {
                    if ( $icon !== null ) {
                        
                        if ( strpos( $icon, 'dashicons ' ) !== false ) {
                            $menu_icon = str_replace( 'dashicons ', '', $icon );
                            $current_menu_item[6] = $menu_icon;
                        } else {
                            
                            if ( strpos( $icon, ',' ) !== false ) {
                                $menu_icon = explode( ',', $icon )[1];
                            } else {
                                $menu_icon = 'dashicons-adminify- ' . $icon;
                            }
                            
                            $current_menu_item[6] = $menu_icon;
                        }
                    
                    }
                    if ( $separator == 1 ) {
                        $current_menu_item[4] = $current_menu_item[4] . ' adminify-menu-separator';
                    }
                }
                
                array_push( $tempmenu, $current_menu_item );
                if ( isset( $menu_settings[$current_menu_item[2]] ) ) {
                    unset( $menu_settings[$current_menu_item[2]] );
                }
            }
            if ( is_array( $menu_settings ) && !array_key_exists( 0, $menu_settings ) ) {
                foreach ( $menu_settings as $key => $menu_s ) {
                    $new_array = [
                        $menu_s['name'],
                        'read',
                        $menu_s['link'] ?? '',
                        '',
                        'menu-top menu-icon-custom',
                        $key,
                        $menu_s['icon'] ?? '',
                        'order' => $menu_s['order'],
                        'separator' => $menu_s['separator'] ?? 0,
                        'hidden_for' => $menu_s['hidden_for'] ?? []
                    ];
                    
                    if ( empty($this->options['admin_ui']) ) {
                        
                        if ( strpos( $menu_s['icon'], 'dashicons ' ) !== false ) {
                            $menu_icon = str_replace( 'dashicons ', '', $menu_s['icon'] );
                        } else {
                            
                            if ( empty($menu_s['icon']) || strpos( $menu_s['icon'], ',' ) !== false ) {
                                
                                if ( empty($menu_s['icon']) ) {
                                    $menu_icon = WP_ADMINIFY_ASSETS_IMAGE . 'logos/menu-icon.svg';
                                } else {
                                    $menu_icon = explode( ',', $menu_s['icon'] )[1];
                                }
                            
                            } else {
                                $menu_icon = 'dashicons-adminify- ' . $menu_s['icon'];
                            }
                        
                        }
                        
                        if ( $menu_s['separator'] == 1 ) {
                            $new_array[4] = $new_array[4] . ' adminify-menu-separator';
                        }
                        $new_array[6] = $menu_icon;
                    }
                    
                    array_push( $tempmenu, $new_array );
                }
            }
            return $this->sort_array( $tempmenu );
        }
        
        /**
         * usort function for menu arrays
         */
        public function sort_array_helper( $a, $b )
        {
            $result = 0;
            if ( !isset( $a['order'] ) ) {
                return $result;
            }
            
            if ( $a['order'] > $b['order'] ) {
                $result = 1;
            } elseif ( $a['order'] < $b['order'] ) {
                $result = -1;
            }
            
            return $result;
        }
        
        /**
         * Sorts arrays by key 'order'
         */
        public function sort_array( $tosort )
        {
            usort( $tosort, [ $this, 'sort_array_helper' ] );
            return $tosort;
        }
        
        /**
         * Sorts Sub Menu for settings
         *
         * @since 1.4
         */
        public function sort_sub_menu_settings( $themenu, $thesubmenu )
        {
            $menu_settings = $this->menu_settings;
            $tempsubmenu = [];
            foreach ( $themenu as $current_menu_item ) {
                $optiongroup = [];
                $submenu_items = [];
                
                if ( isset( $thesubmenu[$current_menu_item[2]] ) ) {
                    $submenuitems = $thesubmenu[$current_menu_item[2]];
                    foreach ( $submenuitems as $key => $subitem ) {
                        $subitem['order'] = $key;
                        
                        if ( is_array( $menu_settings ) && isset( $menu_settings[$current_menu_item[2]] ) && isset( $menu_settings[$current_menu_item[2]]['submenu'] ) ) {
                            $submenugroup = $menu_settings[$current_menu_item[2]]['submenu'];
                            
                            if ( isset( $submenugroup[$subitem[2]] ) ) {
                                $itemoptions = $submenugroup[$subitem[2]];
                                if ( isset( $itemoptions['order'] ) ) {
                                    $subitem['order'] = $itemoptions['order'];
                                }
                            }
                        
                        }
                        
                        array_push( $submenu_items, $subitem );
                    }
                    $submenu_items = $this->sort_array( $submenu_items );
                    $tempsubmenu[$current_menu_item[2]] = $submenu_items;
                }
            
            }
            
            if ( is_array( $menu_settings ) ) {
                $tmp_menu = [];
                foreach ( $menu_settings as $key => $menu_s ) {
                    
                    if ( isset( $menu_s['submenu'] ) && is_array( $menu_s['submenu'] ) ) {
                        $tmp_sub_menu = [];
                        $i = 0;
                        foreach ( $menu_s['submenu'] as $k => $sub_menu ) {
                            if ( strpos( $k, 'adminify-custom-submenu' ) === false ) {
                                continue;
                            }
                            $order = $sub_menu['order'] ?? $i;
                            $new_array = [
                                $sub_menu['name'] ?? '',
                                'read',
                                $sub_menu['link'] ?? '',
                                'order' => $order,
                                'key' => $k,
                                'hidden_for' => $sub_menu['hidden_for'] ?? []
                            ];
                            // processing submenu array
                            $tmp_sub_menu[$order] = $new_array;
                            $i++;
                        }
                        if ( !empty($tmp_sub_menu) ) {
                            // adding submenu into temp variable
                            $tmp_menu[$key] = $tmp_sub_menu;
                        }
                    }
                
                }
                if ( !empty($tmp_menu) ) {
                    $tempsubmenu = array_merge_recursive( $tempsubmenu, $tmp_menu );
                }
                foreach ( $tempsubmenu as $m_k => $m_menu ) {
                    $tempsubmenu[$m_k] = $this->sort_array( $tempsubmenu[$m_k] );
                }
            }
            
            return $tempsubmenu;
        }
        
        /**
         * Applies menu settings
         */
        public function apply_menu( $parent_file )
        {
            global  $menu, $submenu ;
            $tempmenu = [];
            $tempsub = [];
            $submenu = $this->sort_sub_menu_settings( $menu, $submenu );
            if ( $this->menu && is_array( $this->menu ) ) {
                foreach ( $this->menu as $key => $menu_item ) {
                    if ( empty($menu_item[0]) ) {
                        continue;
                    }
                    
                    if ( strpos( $menu_item[2], 'separator' ) !== false && !$menu_item[0] ) {
                        // Build Separator
                        $newitem = $this->apply_separator_settings( $menu_item, $key );
                        if ( $newitem ) {
                            array_push( $tempmenu, $newitem );
                        }
                    } else {
                        // Build Top Level
                        $newitem = $this->apply_top_level_settings( $menu_item, $key );
                        
                        if ( $newitem ) {
                            array_push( $tempmenu, $newitem );
                            $parent_key = $newitem[2];
                            if ( strpos( $newitem[5], 'adminify-custom-menu-' ) !== false ) {
                                $parent_key = $newitem[5];
                            }
                            
                            if ( isset( $this->submenu[$parent_key] ) ) {
                                $subitem = $this->apply_sub_level_settings( $this->submenu[$parent_key], $parent_key );
                                if ( $subitem ) {
                                    $tempsub[$newitem[2]] = $this->apply_sub_level_settings( $this->submenu[$parent_key], $parent_key );
                                }
                            }
                        
                        }
                    
                    }
                
                }
            }
            $submenu = $tempsub;
            $menu = $this->sort_array( $tempmenu );
            return $parent_file;
        }
        
        /**
         * Applies top level menu item settings
         *
         * @since 1.4
         */
        public function apply_sub_level_settings( $subitems, $parentname )
        {
            if ( !is_array( $this->menu_settings ) ) {
                return $subitems;
            }
            if ( !isset( $this->menu_settings[$parentname]['submenu'] ) ) {
                return $subitems;
            }
            $submenu_settings = $this->menu_settings[$parentname]['submenu'];
            $tempsub = [];
            foreach ( $subitems as $current_menu_item ) {
                if ( empty($current_menu_item[0]) || $current_menu_item[2] === 'wp-adminify-settings-pricing' && jltwp_adminify()->can_use_premium_code__premium_only() ) {
                    continue;
                }
                $name = '';
                $link = '';
                $disabled_for = [];
                $optiongroup = [];
                // NO SETTINGS
                
                if ( isset( $submenu_settings[$current_menu_item[2]] ) ) {
                    $optiongroup = $submenu_settings[$current_menu_item[2]];
                    
                    if ( isset( $optiongroup['name'] ) ) {
                        $name = $optiongroup['name'];
                        if ( $name != '' ) {
                            $current_menu_item[0] = $name;
                        }
                    }
                    
                    
                    if ( isset( $optiongroup['link'] ) ) {
                        $link = $optiongroup['link'];
                        
                        if ( $link != '' ) {
                            $current_menu_item[2] = $link;
                            $current_menu_item['link'] = $link;
                        }
                    
                    }
                    
                    
                    if ( isset( $optiongroup['hidden_for'] ) ) {
                        $disabled_for = $optiongroup['hidden_for'];
                        
                        if ( $this->is_hidden( $disabled_for ) ) {
                            $current_menu_item['hidden'] = true;
                            continue;
                        }
                    
                    }
                
                }
                
                $custom_menu = ( isset( $current_menu_item['key'] ) ? $current_menu_item['key'] : '' );
                
                if ( strpos( $custom_menu, 'adminify-custom-submenu-' ) !== false ) {
                    if ( isset( $submenu_settings[$current_menu_item['key']]['hidden_for'] ) ) {
                        $disabled_for = $submenu_settings[$current_menu_item['key']]['hidden_for'];
                    }
                    
                    if ( $this->is_hidden( $disabled_for ) ) {
                        $current_menu_item['hidden'] = true;
                        continue;
                    }
                
                }
                
                array_push( $tempsub, $current_menu_item );
            }
            
            if ( count( $tempsub ) < 1 ) {
                return false;
            } else {
                return $tempsub;
            }
        
        }
        
        /**
         * Applies top level menu item settings
         *
         * @since 1.4
         */
        public function apply_top_level_settings( $current_menu_item, $key )
        {
            $name = '';
            $link = '';
            $icon = '';
            $disabled_for = [];
            $optiongroup = [];
            $order = $key;
            
            if ( is_array( $this->menu_settings ) ) {
                
                if ( isset( $this->menu_settings[$current_menu_item[2]] ) ) {
                    $optiongroup = $this->menu_settings[$current_menu_item[2]];
                    
                    if ( isset( $optiongroup['name'] ) ) {
                        $name = $optiongroup['name'];
                        if ( $name != '' ) {
                            $current_menu_item[0] = $name;
                        }
                    }
                    
                    
                    if ( isset( $optiongroup['link'] ) ) {
                        $link = $optiongroup['link'];
                        
                        if ( $link != '' ) {
                            $current_menu_item[2] = $link;
                            $current_menu_item['link'] = $link;
                        }
                    
                    }
                    
                    
                    if ( isset( $optiongroup['icon'] ) ) {
                        $icon = $optiongroup['icon'];
                        if ( $icon != '' ) {
                            $current_menu_item['icon'] = $icon;
                        }
                    }
                    
                    if ( isset( $optiongroup['order'] ) ) {
                        $order = $optiongroup['order'];
                    }
                    
                    if ( isset( $optiongroup['hidden_for'] ) ) {
                        $disabled_for = $optiongroup['hidden_for'];
                        if ( $this->is_hidden( $disabled_for ) ) {
                            $current_menu_item['hidden'] = true;
                        }
                    }
                
                }
                
                $custom_menu = ( isset( $current_menu_item[5] ) ? $current_menu_item[5] : '' );
                
                if ( strpos( $custom_menu, 'adminify-custom-menu-' ) !== false ) {
                    if ( isset( $this->menu_settings[$current_menu_item[5]]['hidden_for'] ) ) {
                        $disabled_for = $this->menu_settings[$current_menu_item[5]]['hidden_for'];
                    }
                    if ( $this->is_hidden( $disabled_for ) ) {
                        $current_menu_item['hidden'] = true;
                    }
                }
            
            }
            
            $current_menu_item['order'] = $order;
            
            if ( isset( $current_menu_item['hidden'] ) ) {
                
                if ( $current_menu_item['hidden'] == true ) {
                    return false;
                } else {
                    return $current_menu_item;
                }
            
            } else {
                return $current_menu_item;
            }
        
        }
        
        /**
         * Hidden for method
         *
         * @param [type] $disabled_for
         *
         * @return boolean
         */
        public function is_hidden( $disabled_for )
        {
            if ( !is_array( $disabled_for ) ) {
                return false;
            }
            $current_user = wp_get_current_user();
            $current_name = $current_user->display_name;
            $current_roles = $current_user->roles;
            $all_roles = wp_roles()->get_names();
            if ( in_array( $current_name, $disabled_for ) ) {
                return true;
            }
            // MULTISITE SUPER ADMIN
            if ( is_super_admin() && is_multisite() ) {
                
                if ( in_array( 'Super Admin', $disabled_for ) ) {
                    return true;
                } else {
                    return false;
                }
            
            }
            // NORMAL SUPER ADMIN
            if ( $current_user->ID === 1 ) {
                
                if ( in_array( 'Super Admin', $disabled_for ) ) {
                    return true;
                } else {
                    return false;
                }
            
            }
            foreach ( $current_roles as $role ) {
                $role_name = $all_roles[$role];
                if ( in_array( $role_name, $disabled_for ) ) {
                    return true;
                }
            }
        }
        
        /**
         * Applies separator menu item settings
         *
         * @since 1.0.0
         */
        public function apply_separator_settings( $current_menu_item, $key )
        {
            $name = '';
            $disabled_for = [];
            $optiongroup = [];
            $order = $key;
            if ( is_array( $this->menu_settings ) ) {
                
                if ( isset( $this->menu_settings[$current_menu_item[2]] ) ) {
                    $optiongroup = $this->menu_settings[$current_menu_item[2]];
                    
                    if ( isset( $optiongroup['name'] ) ) {
                        $name = $optiongroup['name'];
                        if ( $name != '' ) {
                            $current_menu_item['name'] = $name;
                        }
                    }
                    
                    if ( isset( $optiongroup['order'] ) ) {
                        $order = $optiongroup['order'];
                    }
                    
                    if ( isset( $optiongroup['hidden_for'] ) ) {
                        $disabled_for = $optiongroup['hidden_for'];
                        if ( $this->is_hidden( $disabled_for ) ) {
                            $current_menu_item['hidden'] = true;
                        }
                    }
                
                }
            
            }
            $current_menu_item['order'] = $order;
            
            if ( isset( $current_menu_item['hidden'] ) ) {
                
                if ( $current_menu_item['hidden'] == true ) {
                    return false;
                } else {
                    return $current_menu_item;
                }
            
            } else {
                return $current_menu_item;
            }
        
        }
        
        /**
         * Menu Editor Menu
         */
        public function jltwp_adminify_menu_editor_submenu()
        {
            add_submenu_page(
                'wp-adminify-settings',
                esc_html__( 'Menu Editor by WP Adminify', 'adminify' ),
                esc_html__( 'Menu Editor', 'adminify' ),
                apply_filters( 'jltwp_adminify_capability', 'manage_options' ),
                'adminify-menu-editor',
                // Page slug, will be displayed in URL
                [ $this, 'jltwp_adminify_menu_editor_contents' ]
            );
        }
        
        public function get_saved_sub_menu()
        {
            $menu_settings = $this->menu_settings;
            $menu = $this->menu;
            $submenu = $this->submenu;
            
            if ( is_array( $menu_settings ) && !array_key_exists( 0, $menu_settings ) ) {
                foreach ( $menu as $menu_item ) {
                    if ( isset( $menu_settings[$menu_item[2]] ) ) {
                        unset( $menu_settings[$menu_item[2]] );
                    }
                }
                $tmp_menu = [];
                foreach ( $menu_settings as $key => $menu_s ) {
                    
                    if ( isset( $menu_s['submenu'] ) && is_array( $menu_s['submenu'] ) ) {
                        $tmp_sub_menu = [];
                        $i = 0;
                        foreach ( $menu_s['submenu'] as $k => $sub_menu ) {
                            $new_array = [
                                $sub_menu['name'],
                                'read',
                                $sub_menu['link'],
                                'order' => $i
                            ];
                            $tmp_sub_menu[$i] = $new_array;
                            $i++;
                        }
                        if ( !empty($tmp_sub_menu) ) {
                            $tmp_menu[$key] = $tmp_sub_menu;
                        }
                    }
                
                }
                if ( !empty($tmp_menu) ) {
                    $submenu = $submenu + $tmp_menu;
                }
            }
            
            return $submenu;
        }
        
        /**
         * Render Menu Editor
         */
        public function render_menu_editor()
        {
            global  $wp_roles ;
            $users = get_users();
            $this->users = $users;
            $this->roles = $wp_roles->roles;
            
            if ( $this->menu && is_array( $this->menu ) ) {
                foreach ( $this->menu as $menu_item ) {
                    $next_menu_item = next( $this->menu );
                    
                    if ( strpos( $menu_item[2], 'separator' ) !== false && !$menu_item[0] ) {
                        // Render Separator
                        // $this->render_menu_separator($menu_item);
                    } else {
                        // Render Top Level menu
                        $this->render_top_level_menu_item(
                            $this->menu,
                            $menu_item,
                            $this->submenu,
                            $next_menu_item
                        );
                    }
                
                }
                $this->render_add_new_menu_item();
                ?>
				<script>
					jQuery(function($) {

						$('.adminify-menu-settings').tokenize2({
							placeholder: '<?php 
                _e( 'Select roles or users', 'adminify' );
                ?>'
						});

						$('.adminify-menu-settings').on('tokenize:select', function() {
							$(this).tokenize2().trigger('tokenize:search', [$(this).tokenize2().input.val()]);
						});

					});
				</script>
				<?php 
            }
        
        }
        
        public function get_icon( $value, $default )
        {
            if ( empty($value) ) {
                return $default;
            }
            return $value;
        }
        
        /**
         * Render Top Level menu Item
         *
         * @return void
         */
        public function render_top_level_menu_item(
            $master_menu,
            $current_menu_item,
            $master_sub_menu,
            $next_menu_item
        )
        {
            $disabled_for = '';
            $menu_id = preg_replace( '/[^A-Za-z0-9 ]/', '', $current_menu_item[5] );
            $name = '';
            $link = '';
            $icon = '';
            $separator = '';
            $disabled_for = [];
            $optiongroup = [];
            $menu_options = $this->menu_settings;
            if ( !empty($next_menu_item) && strpos( $next_menu_item[2], 'separator' ) !== false ) {
                $separator = 1;
            }
            if ( is_array( $menu_options ) ) {
                
                if ( isset( $menu_options[$current_menu_item[2]] ) ) {
                    $optiongroup = $menu_options[$current_menu_item[2]];
                    if ( isset( $optiongroup['name'] ) ) {
                        $name = $optiongroup['name'];
                    }
                    if ( isset( $optiongroup['link'] ) ) {
                        $link = $optiongroup['link'];
                    }
                    if ( isset( $optiongroup['icon'] ) ) {
                        $icon = $optiongroup['icon'];
                    }
                    if ( isset( $optiongroup['hidden_for'] ) ) {
                        $disabled_for = $optiongroup['hidden_for'];
                    }
                    if ( isset( $optiongroup['separator'] ) ) {
                        $separator = $optiongroup['separator'];
                    }
                }
            
            }
            $name_attr = $current_menu_item[2];
            
            if ( strpos( $current_menu_item[5], 'adminify-custom-menu-' ) !== false ) {
                $name_attr = $current_menu_item[5];
                $name = $current_menu_item[0];
                $link = $current_menu_item[2];
                if ( isset( $menu_options[$current_menu_item[5]]['hidden_for'] ) ) {
                    $disabled_for = $menu_options[$current_menu_item[5]]['hidden_for'];
                }
                if ( isset( $menu_options[$current_menu_item[5]] ) ) {
                    $optiongroup = $menu_options[$current_menu_item[5]];
                }
                if ( isset( $menu_options[$current_menu_item[5]]['icon'] ) ) {
                    $icon = $menu_options[$current_menu_item[5]]['icon'];
                }
                if ( isset( $current_menu_item['separator'] ) ) {
                    $separator = $current_menu_item['separator'];
                }
            }
            
            if ( !is_array( $disabled_for ) ) {
                $disabled_for = [];
            }
            // LIST OF AVAILABLE MENU ICONS
            $icons = [
                'dashicons-admin-multisite'  => 'dashicons dashicons-admin-multisite',
                'dashicons-dashboard'        => 'dashicons dashicons-dashboard',
                'dashicons-admin-post'       => 'dashicons dashicons-admin-post',
                'dashicons-database'         => 'dashicons dashicons-database',
                'dashicons-admin-media'      => 'dashicons dashicons-admin-media',
                'dashicons-admin-page'       => 'dashicons dashicons-admin-page',
                'dashicons-admin-comments'   => 'dashicons dashicons-admin-comments',
                'dashicons-admin-appearance' => 'dashicons dashicons-admin-appearance',
                'dashicons-admin-plugins'    => 'dashicons dashicons-admin-plugins',
                'dashicons-admin-users'      => 'dashicons dashicons-admin-users',
                'dashicons-admin-tools'      => 'dashicons dashicons-admin-tools',
                'dashicons-chart-bar'        => 'dashicons dashicons-chart-bar',
                'dashicons-admin-settings'   => 'dashicons dashicons-admin-settings',
            ];
            $default_icons = ( isset( $current_menu_item ) ? $current_menu_item[6] : 'dashicons dashicons-external' );
            ?>
			<div class="accordion adminify_menu_item" name="<?php 
            echo  esc_attr( $name_attr ) ;
            ?>" id="wp-adminify-top-menu-<?php 
            echo  esc_attr( $menu_id ) ;
            ?>">
				<input type="number" class="top_level_order" value="" style="display:none;">
				<a class="menu-editor-title accordion-button p-4" href="#">
					<svg class="drag-icon is-pulled-left mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M12 7C13.1046 7 14 6.10457 14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5C10 6.10457 10.8954 7 12 7Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M12 21C13.1046 21 14 20.1046 14 19C14 17.8954 13.1046 17 12 17C10.8954 17 10 17.8954 10 19C10 20.1046 10.8954 21 12 21Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M5 14C6.10457 14 7 13.1046 7 12C7 10.8954 6.10457 10 5 10C3.89543 10 3 10.8954 3 12C3 13.1046 3.89543 14 5 14Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M5 7C6.10457 7 7 6.10457 7 5C7 3.89543 6.10457 3 5 3C3.89543 3 3 3.89543 3 5C3 6.10457 3.89543 7 5 7Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M5 21C6.10457 21 7 20.1046 7 19C7 17.8954 6.10457 17 5 17C3.89543 17 3 17.8954 3 19C3 20.1046 3.89543 21 5 21Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M19 14C20.1046 14 21 13.1046 21 12C21 10.8954 20.1046 10 19 10C17.8954 10 17 10.8954 17 12C17 13.1046 17.8954 14 19 14Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M19 7C20.1046 7 21 6.10457 21 5C21 3.89543 20.1046 3 19 3C17.8954 3 17 3.89543 17 5C17 6.10457 17.8954 7 19 7Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M19 21C20.1046 21 21 20.1046 21 19C21 17.8954 20.1046 17 19 17C17.8954 17 17 17.8954 17 19C17 20.1046 17.8954 21 19 21Z" fill="#4E4B66" fill-opacity="0.72" />
					</svg>
					<?php 
            echo  preg_replace( '/\\<span.*?>.*?\\<\\/span><\\/span>/s', '', $current_menu_item[0] ) ;
            ?>
				</a>

				<div class="accordion-body adminify_top_level_settings">
					<div class="tabs tabbable m-0">
						<ul class="m-0 b-0 nav nav-tabs">
							<li class="nav-item active">
								<a class="nav-link is-clickable active" href="#tab-<?php 
            echo  esc_attr( $menu_id ) ;
            ?>-1">
									<?php 
            _e( 'Settings', 'adminify' );
            ?>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link is-clickable" href="#tab-<?php 
            echo  esc_attr( $menu_id ) ;
            ?>-2">
									<?php 
            _e( 'Submenu', 'adminify' );
            ?>
								</a>
							</li>
						</ul>
					</div>

					<div class="tab-content tab-panel panel p-4">
						<div id="tab-<?php 
            echo  esc_attr( $menu_id ) ;
            ?>-1" class="tab-pane">
							<div class="menu-editor-form">
								<div class="columns">
									<div class="column">
										<label for="<?php 
            echo  esc_attr( $current_menu_item[2] ) ;
            ?>">
											<?php 
            _e( 'Rename as', 'adminify' );
            ?>
										</label>
										<input class="menu_setting" type="text" name="name" data-top-menu-id="<?php 
            echo  esc_attr( $menu_id ) ;
            ?>" placeholder="<?php 
            echo  esc_attr( $current_menu_item[0] ) ;
            ?>" value='<?php 
            echo  esc_attr( $name ) ;
            ?>' />
									</div>
									<div class="column">
										<label for="<?php 
            echo  esc_attr( $current_menu_item[2] ) ;
            ?>">
											<?php 
            _e( 'Hidden For Rules', 'adminify' );
            ?>
										</label>

										<div class="select is-small">
											<select class="adminify-menu-settings menu_setting" name="hidden_for" id="<?php 
            echo  esc_attr( $menu_id ) ;
            ?>-user-role-types" multiple>
												<?php 
            $sel = '';
            if ( in_array( 'Super Admin', $disabled_for ) ) {
                $sel = 'selected';
            }
            ?>
												<option value="Super Admin" <?php 
            echo  esc_attr( $sel ) ;
            ?>><?php 
            _e( 'Super Admin', 'adminify' );
            ?></option>
												<?php 
            foreach ( $this->roles as $role ) {
                $rolename = $role['name'];
                $sel = '';
                if ( in_array( $rolename, $disabled_for ) ) {
                    $sel = 'selected';
                }
                ?>
													<option value="<?php 
                echo  esc_attr( $rolename ) ;
                ?>" <?php 
                echo  esc_attr( $sel ) ;
                ?>><?php 
                echo  esc_html( $rolename ) ;
                ?></option>
													<?php 
            }
            foreach ( $this->users as $user ) {
                $username = $user->display_name;
                $sel = '';
                if ( in_array( $username, $disabled_for ) ) {
                    $sel = 'selected';
                }
                ?>
													<option value="<?php 
                echo  esc_attr( $username ) ;
                ?>" <?php 
                echo  esc_attr( $sel ) ;
                ?>><?php 
                echo  esc_attr( $username ) ;
                ?></option>
													<?php 
            }
            ?>
											</select>

										</div>
									</div>
								</div>
								<div class="columns">
									<div class="column">
										<label for="">
											<?php 
            _e( 'Change Link', 'adminify' );
            ?>
										</label>
										<input class="menu_setting" name="link" type="url" placeholder="<?php 
            _e( 'New link', 'adminify' );
            ?>" value="<?php 
            echo  esc_attr( ( $name_attr != ltrim( $link, '#' ) ? $link : '' ) ) ;
            ?>">
									</div>
									<div class="column">
										<label for="">
											<?php 
            _e( 'Set Custom Icon', 'adminify' );
            ?>
										</label>
										<div class="icon-picker-wrap wp-adminify-menu-icon-picker adminify-icon-picker-input icon-select-button is-clickable is-pulled-left">
											<ul class="icon-picker">
												<li class="icon-none" title="None"><i class="dashicons dashicons-dismiss"></i></li>
												<li class="select-icon <?php 
            echo  ( !empty($icon) && preg_match( '/http(s?)\\:\\/\\//i', $icon ) || empty($icon) && empty($icons[$default_icons]) ? 'custom-icon' : '' ) ;
            ?>" title="Icon Library">
													<?php 
            
            if ( !empty($icon) ) {
                
                if ( preg_match( '/http(s?)\\:\\/\\//i', $icon ) ) {
                    $image = explode( ',', $icon );
                    echo  '<i class=""><img src=' . esc_url( $image[1] ) . ' ></i>' ;
                } else {
                    ?>
															<i class="<?php 
                    echo  Utils::wp_kses_custom( $this->get_icon( esc_attr( $icon ), '' ) ) ;
                    ?>"></i>
															<?php 
                }
            
            } else {
                $adminify_icon = WP_ADMINIFY_ASSETS_IMAGE . 'logos/menu-icon.svg';
                
                if ( empty($icons[$default_icons]) ) {
                    echo  '<i class=""><img src=' . esc_url( $adminify_icon ) . ' ></i>' ;
                } else {
                    ?>
															<i class="<?php 
                    echo  Utils::wp_kses_custom( $this->get_icon( esc_attr( $icon ), $icons[$default_icons] ) ) ;
                    ?>"></i>
															<?php 
                }
            
            }
            
            ?>

												</li>
												<input type="hidden" class="menu_setting" name="icon" value="<?php 
            echo  esc_attr( $icon ) ;
            ?>">
											</ul>
										</div>
									</div>
								</div>
								<div class='columns'>
									<div class='column <?php 
            echo  ( !jltwp_adminify()->can_use_premium_code__premium_only() ? 'upgrade-pro' : '' ) ;
            ?>'>
										<?php 
            ?>
										<?php 
            echo  Utils::adminify_upgrade_pro( 'Add Separator' ) ;
            ?>
									</div>
								</div>
							</div>
							<?php 
            
            if ( strpos( $current_menu_item[5], 'adminify-custom-menu-' ) !== false ) {
                ?>
								<div class="remove-add-new-menu"><span data-id="<?php 
                echo  esc_attr( $current_menu_item[5] ) ;
                ?>"><i class="icon-close"></i> Delete</span></div>
							<?php 
            }
            
            ?>
						</div>
						<div id="tab-<?php 
            echo  esc_attr( $menu_id ) ;
            ?>-2" class="tab-pane tab-pane--submenu">
							<?php 
            // Sub Menu Items Check
            $link = $current_menu_item[2];
            
            if ( isset( $master_sub_menu[$name_attr] ) && is_array( $master_sub_menu[$name_attr] ) ) {
                foreach ( $master_sub_menu[$name_attr] as $sub_menu_item ) {
                    $this->build_sub_menu_item( $sub_menu_item, $optiongroup, $name_attr );
                }
            } else {
                ?>
								<span><?php 
                _e( 'No sub menu items', 'adminify' );
                ?></span>
								<?php 
            }
            
            $this->render_add_new_menu_item( true );
            // true for submenu item
            ?>

						</div>
					</div>

				</div>
			</div>

			<?php 
        }
        
        public function render_menu_separator( $current_menu_item )
        {
            $disabled_for = [];
            $name = '';
            $menu_id = preg_replace( '/[^A-Za-z0-9 ]/', '', $current_menu_item[2] );
            $menu_options = $this->menu_settings;
            if ( is_array( $menu_options ) ) {
                
                if ( isset( $menu_options[$current_menu_item[2]] ) ) {
                    $optiongroup = $menu_options[$current_menu_item[2]];
                    if ( isset( $optiongroup['name'] ) ) {
                        $name = $optiongroup['name'];
                    }
                    if ( isset( $optiongroup['hidden_for'] ) ) {
                        $disabled_for = $optiongroup['hidden_for'];
                    }
                }
            
            }
            if ( !is_array( $disabled_for ) ) {
                $disabled_for = [];
            }
            ?>
			<div class="accordion adminify_menu_item" name="<?php 
            echo  esc_attr( $current_menu_item[2] ) ;
            ?>" id="<?php 
            echo  esc_attr( $menu_id ) ;
            ?>">
				<input type="number" class="top_level_order" value="" style="display:none;">
				<a class="menu-editor-title accordion-button p-4" href="#">
					<svg class="drag-icon is-pulled-left mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M12 7C13.1046 7 14 6.10457 14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5C10 6.10457 10.8954 7 12 7Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M12 21C13.1046 21 14 20.1046 14 19C14 17.8954 13.1046 17 12 17C10.8954 17 10 17.8954 10 19C10 20.1046 10.8954 21 12 21Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M5 14C6.10457 14 7 13.1046 7 12C7 10.8954 6.10457 10 5 10C3.89543 10 3 10.8954 3 12C3 13.1046 3.89543 14 5 14Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M5 7C6.10457 7 7 6.10457 7 5C7 3.89543 6.10457 3 5 3C3.89543 3 3 3.89543 3 5C3 6.10457 3.89543 7 5 7Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M5 21C6.10457 21 7 20.1046 7 19C7 17.8954 6.10457 17 5 17C3.89543 17 3 17.8954 3 19C3 20.1046 3.89543 21 5 21Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M19 14C20.1046 14 21 13.1046 21 12C21 10.8954 20.1046 10 19 10C17.8954 10 17 10.8954 17 12C17 13.1046 17.8954 14 19 14Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M19 7C20.1046 7 21 6.10457 21 5C21 3.89543 20.1046 3 19 3C17.8954 3 17 3.89543 17 5C17 6.10457 17.8954 7 19 7Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M19 21C20.1046 21 21 20.1046 21 19C21 17.8954 20.1046 17 19 17C17.8954 17 17 17.8954 17 19C17 20.1046 17.8954 21 19 21Z" fill="#4E4B66" fill-opacity="0.72" />
					</svg>
					<?php 
            _e( 'Separator', 'adminify' );
            ?>
				</a>

				<div class="accordion-body adminify_top_level_settings">
					<div class="tab-content tab-panel panel p-4">
						<div class="menu-editor-form">
							<div class="columns">
								<div class="column">
									<label for=""><?php 
            _e( 'Rename as', 'adminify' );
            ?></label>
									<input class="menu_setting" type="text" name="name" placeholder="<?php 
            _e( 'New Name', 'adminify' );
            ?>" value="<?php 
            echo  esc_attr( $name ) ;
            ?>">
								</div>
								<div class="column">
									<label for=""><?php 
            _e( 'Hidden For Rules', 'adminify' );
            ?></label>

									<div class="select is-small">
										<select class="adminify-menu-settings menu_setting" name="hidden_for" id="<?php 
            echo  esc_attr( $menu_id ) ;
            ?>-user-role-types" multiple>
											<?php 
            $sel = '';
            if ( in_array( 'Super Admin', $disabled_for ) ) {
                $sel = 'selected';
            }
            ?>
											<option value="Super Admin" <?php 
            echo  esc_attr( $sel ) ;
            ?>><?php 
            _e( 'Super Admin', 'adminify' );
            ?></option>
											<?php 
            foreach ( $this->roles as $role ) {
                $rolename = $role['name'];
                $sel = '';
                if ( in_array( $rolename, $disabled_for ) ) {
                    $sel = 'selected';
                }
                ?>
												<option value="<?php 
                echo  esc_attr( $rolename ) ;
                ?>" <?php 
                echo  esc_attr( $sel ) ;
                ?>><?php 
                echo  esc_html( $rolename ) ;
                ?></option>
												<?php 
            }
            foreach ( $this->users as $user ) {
                $username = $user->display_name;
                $sel = '';
                if ( in_array( $username, $disabled_for ) ) {
                    $sel = 'selected';
                }
                ?>
												<option value="<?php 
                echo  esc_attr( $username ) ;
                ?>" <?php 
                echo  esc_attr( $sel ) ;
                ?>><?php 
                echo  esc_html( $username ) ;
                ?></option>
												<?php 
            }
            ?>
										</select>

										<script>
											jQuery('#<?php 
            echo  esc_attr( $menu_id ) ;
            ?> #<?php 
            echo  esc_attr( $menu_id ) ;
            ?>-user-role-types').tokenize2({
												placeholder: '<?php 
            _e( 'Select roles or users', 'adminify' );
            ?>'
											});
											jQuery(document).ready(function($) {
												$('#<?php 
            echo  esc_attr( $menu_id ) ;
            ?> #<?php 
            echo  esc_attr( $menu_id ) ;
            ?>-user-role-types').on('tokenize:select', function(container) {
													$(this).tokenize2().trigger('tokenize:search', [$(this).tokenize2().input.val()]);
												});
											})
										</script>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<?php 
        }
        
        public function build_sub_menu_item( $current_menu_item, $optiongroup, $name_attr )
        {
            $name = '';
            $link = '';
            $icon = '';
            $disabled_for = [];
            $suboptiongroup = [];
            $menu_options = $this->menu_settings;
            if ( isset( $optiongroup['submenu'] ) ) {
                
                if ( isset( $optiongroup['submenu'][$current_menu_item[2]] ) ) {
                    $suboptiongroup = $optiongroup['submenu'][$current_menu_item[2]];
                    if ( isset( $suboptiongroup['name'] ) ) {
                        $name = $suboptiongroup['name'];
                    }
                    if ( isset( $suboptiongroup['link'] ) ) {
                        $link = $suboptiongroup['link'];
                    }
                    if ( isset( $suboptiongroup['icon'] ) ) {
                        $icon = $suboptiongroup['icon'];
                    }
                    if ( isset( $suboptiongroup['hidden_for'] ) ) {
                        $disabled_for = $suboptiongroup['hidden_for'];
                    }
                }
            
            }
            $sub_menu_name_attr = $current_menu_item[2];
            if ( isset( $current_menu_item['key'] ) ) {
                $sub_menu_name_attr = $current_menu_item['key'];
            }
            
            if ( strpos( $sub_menu_name_attr, 'adminify-custom-submenu-' ) !== false ) {
                $name = $current_menu_item[0];
                $link = $current_menu_item[2];
                if ( isset( $optiongroup['submenu'][$sub_menu_name_attr]['hidden_for'] ) ) {
                    $disabled_for = $optiongroup['submenu'][$sub_menu_name_attr]['hidden_for'];
                }
                if ( isset( $optiongroup['submenu'][$sub_menu_name_attr]['icon'] ) ) {
                    $icon = $optiongroup['submenu'][$sub_menu_name_attr]['icon'];
                }
            }
            
            if ( !is_array( $disabled_for ) ) {
                $disabled_for = [];
            }
            $menu_id = preg_replace( '/[^A-Za-z0-9 ]/', '', $sub_menu_name_attr );
            ?>
			<div class="accordion adminify_sub_menu_item" name="<?php 
            echo  esc_attr( $sub_menu_name_attr ) ;
            ?>" id="wp-adminify-sub-menu-<?php 
            echo  esc_attr( $menu_id ) ;
            ?>">
				<input type="number" class="top_level_order" value="" style="display:none;">
				<a class="menu-editor-title accordion-button p-4" href="#">
					<svg class="drag-icon is-pulled-left mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M12 7C13.1046 7 14 6.10457 14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5C10 6.10457 10.8954 7 12 7Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M12 21C13.1046 21 14 20.1046 14 19C14 17.8954 13.1046 17 12 17C10.8954 17 10 17.8954 10 19C10 20.1046 10.8954 21 12 21Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M5 14C6.10457 14 7 13.1046 7 12C7 10.8954 6.10457 10 5 10C3.89543 10 3 10.8954 3 12C3 13.1046 3.89543 14 5 14Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M5 7C6.10457 7 7 6.10457 7 5C7 3.89543 6.10457 3 5 3C3.89543 3 3 3.89543 3 5C3 6.10457 3.89543 7 5 7Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M5 21C6.10457 21 7 20.1046 7 19C7 17.8954 6.10457 17 5 17C3.89543 17 3 17.8954 3 19C3 20.1046 3.89543 21 5 21Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M19 14C20.1046 14 21 13.1046 21 12C21 10.8954 20.1046 10 19 10C17.8954 10 17 10.8954 17 12C17 13.1046 17.8954 14 19 14Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M19 7C20.1046 7 21 6.10457 21 5C21 3.89543 20.1046 3 19 3C17.8954 3 17 3.89543 17 5C17 6.10457 17.8954 7 19 7Z" fill="#4E4B66" fill-opacity="0.72" />
						<path d="M19 21C20.1046 21 21 20.1046 21 19C21 17.8954 20.1046 17 19 17C17.8954 17 17 17.8954 17 19C17 20.1046 17.8954 21 19 21Z" fill="#4E4B66" fill-opacity="0.72" />
					</svg>
					<?php 
            echo  preg_replace( '/\\<span.*?>.*?\\<\\/span><\\/span>/s', '', $current_menu_item[0] ) ;
            ?>
				</a>

				<div class="accordion-body">
					<div class="tab-content tab-panel panel p-4">
						<div class="tab-pane">
							<div class="menu-editor-form">
								<div class="columns">
									<div class="column">
										<label for=""><?php 
            _e( 'Rename as', 'adminify' );
            ?></label>
										<input class="sub_menu_setting" type="text" data-sub-menu-id="<?php 
            echo  esc_attr( $menu_id ) ;
            ?>" name="name" placeholder="<?php 
            _e( 'New Menu name...', 'adminify' );
            ?>" value="<?php 
            echo  esc_attr( $name ) ;
            ?>">
									</div>
									<div class="column">
										<label for=""><?php 
            _e( 'Hidden For Rules', 'adminify' );
            ?></label>

										<div class="select is-small">
											<select class="adminify-menu-settings sub_menu_setting" name="hidden_for" id="<?php 
            echo  esc_attr( $menu_id ) ;
            ?>-user-role-types" multiple>
												<?php 
            $sel = '';
            if ( in_array( 'Super Admin', $disabled_for ) ) {
                $sel = 'selected';
            }
            ?>
												<option value="Super Admin" <?php 
            echo  esc_attr( $sel ) ;
            ?>><?php 
            _e( 'Super Admin', 'adminify' );
            ?></option>
												<?php 
            foreach ( $this->roles as $role ) {
                $rolename = $role['name'];
                $sel = '';
                if ( in_array( $rolename, $disabled_for ) ) {
                    $sel = 'selected';
                }
                ?>
													<option value="<?php 
                echo  esc_attr( $rolename ) ;
                ?>" <?php 
                echo  esc_attr( $sel ) ;
                ?>><?php 
                echo  esc_html( $rolename ) ;
                ?></option>
													<?php 
            }
            foreach ( $this->users as $user ) {
                $username = $user->display_name;
                $sel = '';
                if ( in_array( $username, $disabled_for ) ) {
                    $sel = 'selected';
                }
                ?>
													<option value="<?php 
                echo  esc_attr( $username ) ;
                ?>" <?php 
                echo  esc_attr( $sel ) ;
                ?>><?php 
                echo  esc_html( $username ) ;
                ?></option>
													<?php 
            }
            ?>
											</select>

											<script>
												jQuery('#wp-adminify-sub-menu-<?php 
            echo  esc_attr( $menu_id ) ;
            ?> #<?php 
            echo  esc_attr( $menu_id ) ;
            ?>-user-role-types').tokenize2({
													placeholder: '<?php 
            _e( 'Select roles or users', 'adminify' );
            ?>'
												});
												jQuery(document).ready(function($) {
													$('#wp-adminify-sub-menu-<?php 
            echo  esc_attr( $menu_id ) ;
            ?> #<?php 
            echo  esc_attr( $menu_id ) ;
            ?>-user-role-types').on('tokenize:select', function(container) {
														$(this).tokenize2().trigger('tokenize:search', [$(this).tokenize2().input.val()]);
													});
												})
											</script>

										</div>
									</div>
								</div>
								<div class="columns">
									<div class="column">
										<label for=""><?php 
            _e( 'Change Link', 'adminify' );
            ?></label>
										<input class="sub_menu_setting" name="link" type="url" placeholder="New link" value="<?php 
            echo  esc_attr( ( $sub_menu_name_attr != ltrim( $link, '#' ) ? $link : '' ) ) ;
            ?>">
									</div>
									<div class="column">
										<label for=""><?php 
            _e( 'Set Custom Icon', 'adminify' );
            ?> <i>(<?php 
            _e( 'Not available for Submenu.', 'adminify' );
            ?>)</i></label>

										<div class="icon-picker-wrap wp-adminify-menu-icon-picker adminify-icon-picker-input icon-select-button is-clickable-no is-pulled-left">
											<ul class="icon-picker">
												<li class="icon-none" title="None"><i class="dashicons dashicons-dismiss"></i></li>
												<?php 
            $custom_class = '';
            $icon = '<i class="' . $this->get_icon( esc_attr( $icon ), 'dashicons dashicons-external' ) . '"></i>';
            
            if ( strpos( $sub_menu_name_attr, 'adminify-custom-submenu-' ) !== false ) {
                $custom_class = 'custom-icon';
                $icon = '<img src="' . WP_ADMINIFY_ASSETS_IMAGE . 'logos/menu-icon.svg" />';
            }
            
            ?>
												<li class="select-icon <?php 
            echo  esc_attr( $custom_class ) ;
            ?>" title="Icon Library">
													<?php 
            echo  esc_attr( $icon ) ;
            ?>
												</li>
												<input type="hidden" class="sub_menu_setting" name="icon" value="<?php 
            echo  esc_attr( $icon ) ;
            ?>">
											</ul>
										</div>

									</div>
								</div>
							</div>
							<?php 
            
            if ( strpos( $sub_menu_name_attr, 'adminify-custom-submenu-' ) !== false ) {
                ?>
								<div class="remove-add-new-menu"><span data-id="<?php 
                echo  esc_attr( $sub_menu_name_attr ) ;
                ?>"><i class="icon-close"></i> Delete</span></div>
							<?php 
            }
            
            ?>
						</div>
					</div>
				</div>
			</div>

			<?php 
        }
        
        /**
         * Add New Menu Item.
         */
        public function render_add_new_menu_item( $submenu = false )
        {
            ?>
			<div class="accordion add-new-menu-editor-item <?php 
            echo  esc_attr( ( $submenu ? 'submenu' : '' ) ) ;
            ?> <?php 
            echo  ( !jltwp_adminify()->can_use_premium_code__premium_only() ? 'upgrade-pro' : '' ) ;
            ?>">
				<div class="inner-text">
					<i class="dashicons dashicons-plus-alt"></i>
					<span class="title">Add Item</span>
				</div>
				<?php 
            echo  Utils::adminify_upgrade_pro( ' ' ) ;
            ?>
			</div>
			<?php 
        }
        
        /**
         * Menu Editor Header
         *
         * @return void
         */
        public function render_menu_editor_header()
        {
            ?>

			<div class="adminify-menu-editor-help-urls wp-heading-inline is-pulled-left is-flex is-align-items-center">
				<?php 
            echo  Utils::adminfiy_help_urls(
                'Menu Editor',
                'https://wpadminify.com/kb/wordpress-dashboard-menu-editor/',
                'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
                'https://www.facebook.com/groups/jeweltheme',
                'https://wpadminify.com/support/'
            ) ;
            ?>
			</div>


			<div class="wp-adminify--page--title--actions mt-1 is-pulled-right">

				<button class="page-title-action mr-3 adminify_menu_save_settings">
					<?php 
            _e( 'Save', 'adminify' );
            ?>
				</button>

				<div class="dropdown is-right is-hoverable is-pulled-right">
					<div class="dropdown-trigger">
						<button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
							<svg class="icon" width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5 12C3.63144 12.0007 2.43589 11.0751 2.09375 9.75H0.5V8.25H2.0945C2.48423 6.74059 3.96509 5.78119 5.50196 6.04243C7.03883 6.30366 8.11953 7.69847 7.98865 9.25188C7.85776 10.8053 6.55892 11.9996 5 12ZM5 7.5C4.18055 7.50083 3.51342 8.15914 3.50167 8.97851C3.48993 9.79788 4.13792 10.475 4.95702 10.4993C5.77611 10.5237 6.46312 9.88613 6.5 9.0675V9.3675V9C6.5 8.17158 5.82843 7.5 5 7.5ZM15.5 9.75H8.75V8.25H15.5V9.75ZM8.75 6C7.38172 6.00035 6.18657 5.07483 5.8445 3.75H0.5V2.25H5.8445C6.23423 0.740588 7.71509 -0.218809 9.25196 0.0424253C10.7888 0.30366 11.8695 1.69847 11.7386 3.25188C11.6078 4.80529 10.3089 5.99961 8.75 6ZM8.75 1.5C7.93055 1.50083 7.26342 2.15914 7.25167 2.97851C7.23993 3.79788 7.88792 4.47503 8.70702 4.49934C9.52611 4.52365 10.2131 3.88613 10.25 3.0675V3.3675V3C10.25 2.17158 9.57843 1.5 8.75 1.5ZM15.5 3.75H12.5V2.25H15.5V3.75Z" fill="#0347FF" />
							</svg>
						</button>
					</div>
					<div class="dropdown-menu" id="dropdown-menu" role="menu">
						<div class="dropdown-content">
							<a href="#" class="dropdown-item adminify_export_menu_settings">
								<?php 
            _e( 'Export menu', 'adminify' );
            ?>
							</a>
							<input accept=".json" type="file" single="" id="adminify_import_menu" class="hidden">
							<a href="#" class="dropdown-item adminify_import_menu_settings">
								<?php 
            _e( 'Import menu', 'adminify' );
            ?>
							</a>
							<a href="#" class="dropdown-item adminify_reset_menu_settings">
								<?php 
            _e( 'Reset menu', 'adminify' );
            ?>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="is-inline-block">
				<p><?php 
            _e( 'Edit each menu item\'s name, link, icon and visibility. Drag and drop to rearange the menu. Changes will take effect after page refresh.', 'adminify' );
            ?></p>
				<p>
					<svg class="is-pulled-left mr-1 mt-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M7.33398 7.32002C7.33398 7.14321 7.40422 6.97364 7.52925 6.84861C7.65427 6.72359 7.82384 6.65335 8.00065 6.65335C8.17746 6.65335 8.34703 6.72359 8.47206 6.84861C8.59708 6.97364 8.66732 7.14321 8.66732 7.32002V11.32C8.66732 11.4968 8.59708 11.6664 8.47206 11.7914C8.34703 11.9164 8.17746 11.9867 8.00065 11.9867C7.82384 11.9867 7.65427 11.9164 7.52925 11.7914C7.40422 11.6664 7.33398 11.4968 7.33398 11.32V7.32002Z" fill="#4E4B66" />
						<path d="M8.00065 4.034C7.82384 4.034 7.65427 4.10423 7.52925 4.22926C7.40422 4.35428 7.33398 4.52385 7.33398 4.70066C7.33398 4.87747 7.40422 5.04704 7.52925 5.17207C7.65427 5.29709 7.82384 5.36733 8.00065 5.36733C8.17746 5.36733 8.34703 5.29709 8.47206 5.17207C8.59708 5.04704 8.66732 4.87747 8.66732 4.70066C8.66732 4.52385 8.59708 4.35428 8.47206 4.22926C8.34703 4.10423 8.17746 4.034 8.00065 4.034Z" fill="#4E4B66" />
						<path fill-rule="evenodd" clip-rule="evenodd" d="M8.00065 1.33334C4.31865 1.33334 1.33398 4.31801 1.33398 8.00001C1.33398 11.682 4.31865 14.6667 8.00065 14.6667C11.6827 14.6667 14.6673 11.682 14.6673 8.00001C14.6673 4.31801 11.6827 1.33334 8.00065 1.33334ZM2.66732 8.00001C2.66732 9.4145 3.22922 10.7711 4.22942 11.7712C5.22961 12.7714 6.58616 13.3333 8.00065 13.3333C9.41514 13.3333 10.7717 12.7714 11.7719 11.7712C12.7721 10.7711 13.334 9.4145 13.334 8.00001C13.334 6.58552 12.7721 5.22897 11.7719 4.22877C10.7717 3.22858 9.41514 2.66668 8.00065 2.66668C6.58616 2.66668 5.22961 3.22858 4.22942 4.22877C3.22922 5.22897 2.66732 6.58552 2.66732 8.00001V8.00001Z" fill="#4E4B66" />
					</svg>

					<?php 
            _e( 'If you have WP Adminify Menu Module disabled, icons and label dividers won\'t change.', 'adminify' );
            ?>

				</p>
			</div>


			<?php 
        }
        
        public function jltwp_adminify_menu_editor_contents()
        {
            ?>

			<div class="wrap">
				<div class="wp-adminify--menu--editor--container mt-4">

					<div id="adminify-data-saved-message"></div>

					<?php 
            $this->render_menu_editor_header();
            ?>


					<div class="wp-adminify--menu--editor--settings mt-5 pt-3">
						<div class="wp-adminify-menu-editor-loader"></div>
						<?php 
            $this->render_menu_editor();
            ?>
					</div>

				</div>
			</div>
			<a href="#" id="adminify_download_settings" style="display: none;" ?></a>
			<?php 
        }
    
    }
}