<?php

namespace WPAdminify\Inc\Classes\MenuStyles;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettings;
use WPAdminify\Inc\Classes\MenuStyles\MenuStyleBase;
use WPAdminify\Inc\Modules\MenuEditor\MenuEditorOptions;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

class VerticalMainMenu extends MenuStyleBase
{
    protected $options;

    public function __construct()
    {
        parent::__construct();
        $this->menu_settings = (new MenuEditorOptions())->get();
        $this->options = (array) AdminSettings::get_instance()->get();

        add_filter('admin_body_class', [$this, 'admin_menu_body_class']);

        if (empty($this->options['admin_ui'])) {
            return;
        }

        add_filter('parent_file', [$this, 'render_adminify_admin_menu'], 999);
        add_action('adminmenu', [$this, 'render_output_adminify_admin_menu']);
    }

    // Body Class
    public function admin_menu_body_class($classes)
    {


        $this->options = (array) AdminSettings::get_instance()->get('menu_layout_settings');
        $menu_layout = !empty($this->options['layout_type']) ? $this->options['layout_type'] : 'vertical';
        $menu_mode = !empty($this->options['menu_mode']) ? $this->options['menu_mode'] : 'classic';

        $bodyclass = '';
        if ($menu_layout == 'vertical' && $menu_mode === 'icon_menu') {
            $classes .= " folded ";
        }
        $classes .= ' adminify_admin_menu ';
        return $classes . $bodyclass;
    }

    /**
     * Render Admin Menu
     * @package WP Adminify
     * @return void
     */
    public function render_adminify_admin_menu($parent_file)
    {
        global $menu, $pagenow, $wp_adminify_menu;
        $current_user = wp_get_current_user();
        $this->original_menu = $menu;
        $this->options = (array) AdminSettings::get_instance()->get();

        // Disable Default Menu
        $menu = array();
        ob_start();
?>

        <div class="wp_adminify_sidebar_admin-menu menu-default-light">

            <ul class="wp_adminify_admin-menu">

                <?php
                // User Info Section
                if (!empty($this->options['menu_layout_settings']['user_info'])) { ?>
                    <li class="wp_adminify_admin-menu-top">
                        <div class="wp_adminify_user has-text-centered p-2 pt-4 pb-5 mb-2">
                            <div class="wp_adminify_user-avatar image is-80x80">
                                <?php if (isset($this->options['menu_layout_settings']['user_info_avatar']) && $this->options['menu_layout_settings']['user_info_avatar'] === 'rounded') { ?>
                                    <?php echo get_avatar($current_user->user_email, 80, '', '', array('class' => 'is-rounded')); ?>
                                <?php } else {
                                    echo get_avatar($current_user->user_email, 80, '', '', array('class' => 'is-square'));
                                }
                                ?>
                            </div>

                            <?php if (isset($this->options['menu_layout_settings']['user_info_content']) && $this->options['menu_layout_settings']['user_info_content'] === 'text') { ?>

                                <div class="wp_adminify_user-details">
                                    <h4 class="wp_adminify_user-name is-capitalized">
                                        <a class="has-text-weight-bold" href="<?php echo admin_url('profile.php'); ?>">
                                            <?php echo esc_html($current_user->display_name); ?>
                                        </a>
                                    </h4>
                                    <span class="wp_adminify_user-url">
                                        <a href="<?php echo admin_url('profile.php'); ?>">
                                            <?php echo is_email($current_user->user_email); ?>
                                        </a>
                                    </span>

                                    <a class="logout mt-2" href="<?php echo wp_logout_url(); ?>">
                                        <?php echo esc_html__('Log Out', 'adminify'); ?>
                                    </a>
                                </div>

                            <?php } elseif (isset($this->options['menu_layout_settings']['user_info_content']) && $this->options['menu_layout_settings']['user_info_content'] === 'icon') { ?>
                                <div class="wp_adminify_user-actions">
                                    <a href="<?php echo admin_url('profile.php'); ?>">
                                        <i class="icon-user icons"></i>
                                    </a>
                                    <a href="<?php echo wp_logout_url(); ?>">
                                        <i class="icon-logout icons"></i>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </li>
                <?php } ?>

                <?php $this->render_top_level_menu_items($this->original_menu); ?>


            </ul>

        </div>


        <?php
        $wp_adminify_menu = ob_get_clean();

        return $parent_file;
    }


    /**
     * Render Top Level Menu Items
     */

    public function render_top_level_menu_items($the_menu)
    {
        global $submenu;
        $this->original_submenu = $submenu;
        $menu_options = $this->menu_settings;

        foreach ($the_menu as $menu_item) {
            $menu_name = $menu_item[0];
            $menu_link = $menu_item[2];
            $divider = false;

            $disabled_for = [];
            if (is_array($menu_options)) {
                if (isset($menu_options[$menu_item[2]])) {
                    $optiongroup = $menu_options[$menu_item[2]];
                    if (isset($optiongroup['hidden_for'])) {
                        $disabled_for = $optiongroup['hidden_for'];
                    }
                }
            }
            $custom_menu = isset($menu_item[5]) ? $menu_item[5] : '';
            if (strpos($custom_menu, 'adminify-custom-menu-') !== false) {
                if (isset($menu_options[$menu_item[5]]['hidden_for'])) {
                    $disabled_for = $menu_options[$menu_item[5]]['hidden_for'];
                }
                $disabled_for = array_flip($disabled_for);
                $disabled_for = array_change_key_case($disabled_for, CASE_LOWER);
                $disabled_for = array_flip($disabled_for);
                if (Utils::restricted_for($disabled_for)) {
                    continue;
                }
            }

            if (strpos($menu_link, "separator") !== false) {
                $divider = true;
                // $this->render_divider($menu_item);
                continue;
            }

            if (!$menu_name) {
                continue;
            }

            if (isset($submenu[$menu_link])) {
                $sub_menu_items = $submenu[$menu_link];
            } else {
                $sub_menu_items = false;
            }

            $link = $this->get_menu_link($menu_item);

            if( 'edit.php?post_type=elementor_library' === $link ){
                $link .= '&tabs_group=library';
            }
            $classes = $this->get_menu_clases($menu_item, $submenu);

        ?>

            <li class="<?php echo $classes ?>" id="<?php echo $menu_item[5] ?>">
                <a class="menu-icon-generic <?php echo $classes; ?>" href="<?php echo $link; ?>">

                    <?php $this->get_icon($menu_item); ?>

                    <span class="wp-menu-name" id="adminify-main-topmenu-<?php echo preg_replace("/[^A-Za-z0-9 ]/", '', $menu_item[5]); ?>"><?php echo $menu_name; ?></span>

                </a>

                <?php
                if (is_array($sub_menu_items)) {
                    $this->render_sub_level_menu_items($sub_menu_items,$menu_item,$menu_options);
                }
                ?>

            </li>

        <?php

        if( isset($menu_item['separator']) && $menu_item['separator'] == 1 ){
            $this->render_divider($menu_item);
        }

        }
    }


    /**
     * Gets correct classes for top level menu item
     * @since 1.4
     */

    public function get_menu_clases($menu_item, $sub_menu)
    {

        $menu_link = $menu_item[2];
        $classes = $menu_item[4];

        if (isset($sub_menu[$menu_link])) {
            $classes = $classes . ' wp-has-submenu wp-adminify-parent ';
            $classes = $classes . ' ' . $this->check_if_active($menu_item, $sub_menu[$menu_link]);
        } else {
            $classes = $classes . ' ' . $this->check_if_single_active($menu_item);
        }

        return $classes;
    }


    /**
     * Checks if we are on an active link or sub link
     * @since 1.4
     */

    public function check_if_active($menu_item, $sub_menu)
    {

        if (!is_array($sub_menu)) {
            return "";
        }

        global $pagenow;

        $currentquery = $_SERVER['QUERY_STRING'];
        if ($currentquery) {
            $currentquery = '?' . $currentquery;
        }
        $wholestring = $pagenow . $currentquery;
        $visibility = 'hidden';
        $open = 'wp-not-current-submenu';
        $files = $this->files;

        foreach ($sub_menu as $sub) {
            if ($sub[2] === 'edit-tags.php?taxonomy=elementor_library_category&amp;post_type=elementor_library') {
                $link = 'edit-tags.php?taxonomy=elementor_library_category&post_type=elementor_library';
            } else if ($sub[2] === 'edit.php?post_type=elementor_library') {
                $link = 'edit.php?post_type=elementor_library';
            } else if (($sub[2] === 'e-landing-page') || ($sub[2] === 'popup_templates')) {
                $link = 'edit.php?post_type=elementor_library&page=' . $sub[2];
            } else if ($sub[2] === 'updraftplus') {
                $link = 'options-general.php?page=' . $sub[2];
            } else if (strpos($sub[2], '.php') !== false) {
                $link = $sub[2];

                $querypieces = explode("?", $link);
                $temp = $querypieces[0];

                if (!in_array($temp, $files)) {
                    $link = 'admin.php?page=' . $sub[2];
                }
            } else {
                $link = 'admin.php?page=' . $sub[2];
            }
            $linkclass = '';
            if (($wholestring == $link) || ( (strpos($wholestring, 'edit.php?post_type=elementor_library') !== false) && (strpos($link, 'edit.php?post_type=elementor_library') !== false) ) ) {
                $linkclass = "wp-has-current-submenu wp-menu-open";
                $open = 'wp-adminify-active wp-adminify-open wp-menu-open wp-has-current-submenu';
                $visibility = '';
                break;
            }
        }

        return $open;
    }



    /**
     * Render Divider
     * @package WP Adminify
     * @return void
     */
    public function render_divider($divider)
    {
        if (isset($divider['name'])) {
        ?>

            <li class="wp-adminify-nav-header"><?php echo $divider['name'] ?></li>
            <li class="wp-adminify-nav-divider divider-placeholder"></li>

        <?php

        } else {
        ?>

            <li class="wp-adminify-nav-divider"></li>

        <?php
        }
    }


    /**
     * Render Sub Menu Items
     *
     * @return void
     */
    public function render_sub_level_menu_items($sub_menu,$parent_menu,$menu_options)
    {
        ?>
        <ul class="wp-adminify-nav-sub wp-submenu wp-submenu-wrap">

            <?php
            foreach ($sub_menu as $sub_item) {
                $sub_menu_name = $sub_item[0];
                $sub_menu_link = $sub_item[2];
                $link = $this->get_menu_link($sub_item);
                $class = $this->check_if_single_active($sub_item);

                $parent_menu_id = preg_replace("/[^A-Za-z0-9 ]/", '', $sub_menu_link);

                $disabled_for = [];
                $custom_submenu = isset($sub_item['key']) ? $sub_item['key'] : '';
                if (strpos($parent_menu[5], 'adminify-custom-menu-') !== false) {
                    if (strpos($custom_submenu, 'adminify-custom-submenu-') !== false) {
                        $submenu_options = $menu_options[$parent_menu[5]]['submenu'][$custom_submenu];
                        if( !empty($submenu_options['hidden_for']) ){
                            $disabled_for = $submenu_options['hidden_for'];
                        }
                        $disabled_for = array_flip($disabled_for);
                        $disabled_for = array_change_key_case($disabled_for, CASE_LOWER);
                        $disabled_for = array_flip($disabled_for);
                        if (Utils::restricted_for($disabled_for)) {
                            continue;
                        }
                    }
                }

                // hide pricing menu when user is using pro version
                if ( ($sub_menu_link === 'wp-adminify-settings-pricing') && jltwp_adminify()->can_use_premium_code__premium_only() ) {
                    // Do not display the menu item
                }else{
            ?>
                <li class="<?php echo $class; ?>">
                    <a class="<?php echo $class; ?>" href="<?php echo $link; ?>" id="adminify-main-submenu-<?php echo esc_attr($parent_menu_id); ?>">
                        <?php echo $sub_menu_name ?>
                    </a>
                </li>
            <?php }

            }
            ?>

        </ul>
        <?php
    }


    /**
     * Checks if we are on an active link or sub link
     * @since 1.4
     */

    public function check_if_single_active($sub_menu_item)
    {

        global $pagenow;

        $currentquery = $_SERVER['QUERY_STRING'];
        if ($currentquery) {
            $currentquery = '?' . $currentquery;
        }
        $wholestring = $pagenow . $currentquery;
        $visibility = 'hidden';
        $open = 'wp-not-current-submenu';
        $files = $this->files;

        if ($sub_menu_item[2] === 'edit-tags.php?taxonomy=elementor_library_category&amp;post_type=elementor_library') {
            $link = 'edit-tags.php?taxonomy=elementor_library_category&post_type=elementor_library';
        } else if ($sub_menu_item[2] === 'popup_templates') {
            $link = 'edit.php?post_type=elementor_library&page=' . $sub_menu_item[2];
        } else if ($sub_menu_item[2] === 'updraftplus') {
            $link = 'options-general.php?page=' . $sub_menu_item[2];
        } else if (strpos($sub_menu_item[2], '.php') !== false) {
            $link = $sub_menu_item[2];

            $querypieces = explode("?", $link);
            $temp = $querypieces[0];

            if (!in_array($temp, $files)) {
                $link = 'admin.php?page=' . $sub_menu_item[2];
            }
        } else {
            $link = 'admin.php?page=' . $sub_menu_item[2];
        }

        $linkclass = '';
        if ($wholestring == $link) {
            $linkclass = "wp-adminify-active current";
        }


        return $linkclass;
    }



    /**
     * Scans admin directory for menu links
     * @since 1.4
     */
    public function get_admin_files()
    {

        $absolutepath = ABSPATH . '/wp-admin' . "/";
        $files = array_diff(scandir($absolutepath), array('.', '..'));

        if (is_multisite()) {
            $pathtonetwork = ABSPATH . '/wp-admin' . "/network/";
            $networkfiles = array_diff(scandir($pathtonetwork), array('.', '..'));
            $files = array_merge($files, $networkfiles);
        }

        return $files;
    }

    /**
     * Gets correct link for menu item
     * @since 1.4
     */

    public function get_menu_link($menu_item)
    {

        $menu_link = $menu_item[2];
        $files = $this->get_admin_files();
        $this->files = $files;

        if ($menu_link == 'woocommerce') {
            $menu_link = 'wc-admin';
        }

        if (($menu_link === 'e-landing-page') || ($menu_link === 'popup_templates')) {
            $link = 'edit.php?post_type=elementor_library&page=' . $menu_link;
        } else if ($menu_link === 'updraftplus') {
            $link = 'options-general.php?page=' . $menu_link;
        } else if (strpos($menu_link, 'admin.php') !== false) {
            $link = $menu_link;
        } else if (strpos($menu_link, '.php') !== false) {

            $link = $menu_link;
            if (strpos($menu_link, '/') !== false) {
                $pieces = explode("/", $menu_link);
                if (strpos($pieces[0], '.php') !== true || !file_exists(get_admin_url() . $menu_link)) {
                    $link = 'admin.php?page=' . $menu_link;
                }
            }

            $querypieces = explode("?", $link);
            $temp = $querypieces[0];

            if (!in_array($temp, $files)) {
                $link = 'admin.php?page=' . $menu_link;
            }
        } else {

            $link = 'admin.php?page=' . $menu_link;
        }

        if (strpos($menu_link, "/wp-content/") !== false) {

            $link = 'admin.php?page=' . $menu_link;
        }

        //CHECK IF INTERNAL URL
        if (strpos($menu_link, get_site_url()) !== false) {

            $link = $menu_link;
        }

        ///CHECK IF EXTERNAL LINK
        if (strpos($menu_link, 'https://') !== false || strpos($menu_link, 'http://') !== false) {

            $link = $menu_link;
        }

        return $link;
    }



    /**
     * Gets top level menu item icon
     * @since 1.4
     */

    public function get_icon($menu_item)
    {

        /// LIST OF AVAILABLE MENU ICONS
        $icons = array(
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
            'dashicons-admin-settings'   => 'dashicons dashicons-admin-settings'
        );

        // SET MENU ICON
        $theicon = '';
        // $wpicon = $menu_item;
        $wpicon = (isset($menu_item)) ? $menu_item[6] : '';

        if (isset($menu_item['icon']) && !empty($menu_item['icon'])) {

            if( preg_match('/http(s?)\:\/\//i', $menu_item['icon']) ) {
                $icon = explode(',', $menu_item['icon']);

                ?>
                    <span class="wp-adminify-icon-button" style="background-image: url(<?php echo $icon[1] ?>);"></span>
                <?php
                return;
            }else{
                ?>
                    <span class="wp-adminify-icon-button <?php echo $menu_item['icon'] ?>"></span>
                <?php
                return;
            }
        }

        if (isset($icons[$wpicon])) {

            //ICON IS SET BY WP ADMINIFY
            ?>
            <span class="wp-adminify-icon-button <?php echo $icons[$wpicon] ?>"></span>
            <?php
            return;
        }

        if (!$theicon) {
            if (strpos($wpicon, 'http') !== false || strpos($wpicon, 'data:') !== false) {
                //ICON IS IMAGE && BASE64
                $class = '';
                // ICON IS BASE64
                if(strpos($wpicon, 'data:') !== false){
                    $deocded_bas64 = base64_decode(explode(',',$wpicon)[1]);
                }
                // ICON IS IMAGE
                if(strpos($wpicon, 'http') !== false){
                    $class = 'svg-image-icon';
                    $wpicon = (strpos($wpicon,',') !== false) ? explode(',',$wpicon)[1] : $wpicon;
                }
            ?>
                <span class="wp-adminify-icon wp-adminify-icon-image wp-adminify-icon-button <?php echo $class; ?>" <?php if(strpos($wpicon, 'data:') === false) { ?> style="background-image: url(<?php echo $wpicon ?>);" <?php } ?>><?php if(strpos($wpicon, 'data:') !== false) echo $deocded_bas64; ?></span>
            <?php

            } else {

                ///ICON IS ::BEFORE ELEMENT
                if( empty($wpicon) ){
                    $wpicon =  empty($wpicon) ? WP_ADMINIFY_ASSETS_IMAGE . 'logos/menu-icon.svg' : '';
                    ?>
                        <span class="wp-adminify-icon wp-adminify-icon-image wp-adminify-icon-button svg-image-icon" style="background-image: url(<?php echo $wpicon ?>);"></span>
                    <?php
                }else{
                    $wpicon =  (strpos($wpicon,'dashicons-') !== false) ? 'dashicons-before '. $wpicon : $wpicon;
                    ?>
                        <div class="wp-menu-image <?php echo $wpicon ?> wp-adminify-icon wp-adminify-icon-image wp-adminify-icon-button"></div>
                    <?php
                }

            }
        }
    }


    /**
     * Render Output Admin Menu
     *
     * @return void
     */
    public function render_output_adminify_admin_menu()
    {
        global $menu, $submenu, $wp_adminify_menu;
        echo $wp_adminify_menu;
        $menu    = $this->original_menu;
        $submenu = $this->original_submenu;
    }
}
