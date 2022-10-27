<?php

namespace WPAdminify\Inc\Classes;

use WPAdminify\Inc\Admin\AdminSettings;
use WPAdminify\Inc\Admin\AdminSettingsModel;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * @package WPAdminify
 * Quick Menu
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class QuickCircleMenu extends AdminSettingsModel
{
    public function __construct()
    {
        if (is_admin()) {
            $this->options = (array) AdminSettings::get_instance()->get();
            $restrict_for = !empty($this->options['quick_menus_user_roles']) ? $this->options['quick_menus_user_roles'] : '';
            if ($restrict_for) {
                return;
            }

            add_action('admin_enqueue_scripts', [$this, 'quick_circle_menu_scripts'], 100);
            add_action('admin_footer', [$this, 'adminify_quick_circle_menu']);
        }
    }

    /**
     * Enqueue Quick Circle Script
     *
     * @return void
     */
    public function quick_circle_menu_scripts()
    {
        wp_enqueue_script('wp-adminify-circle-menu');
        wp_localize_script('wp-adminify-admin', 'WPAdminify_QuickMenu', [ 'is_rtl' => is_rtl() ]);
        $this->circle_menu_loader_css();
    }

    public function circle_menu_loader_css()
    {
        $quick_menu_custom_css = '';
        $quick_menu_custom_css .= '.no-js .wp-adminify-loader { display: none; } .js .wp-adminify-loader { display: block; position: fixed; right: 20px; bottom: 105px; } .wp-adminify-loader { width: 30px; height: 30px; border-radius: 50%; background: conic-gradient(#0000 10%, #0347FF); -webkit-mask: radial-gradient(farthest-side, #0000 calc(100% - 8px), #000 0); animation: wp_adminify_loader_keyframe 1s infinite linear; } @keyframes wp_adminify_loader_keyframe { to { transform: rotate(1turn) } }';

        $quick_menu_custom_css = preg_replace('#/\*.*?\*/#s', '', $quick_menu_custom_css);
        $quick_menu_custom_css = preg_replace('/\s*([{}|:;,])\s+/', '$1', $quick_menu_custom_css);
        $quick_menu_custom_css = preg_replace('/\s\s+(.*)/', '$1', $quick_menu_custom_css);

        $adminify_ui = AdminSettings::get_instance()->get('admin_ui');
        if (!empty($adminify_ui)) {
            wp_add_inline_style('wp-adminify-admin', wp_strip_all_tags($quick_menu_custom_css));
        } else {
            wp_add_inline_style('wp-adminify-default-ui', wp_strip_all_tags($quick_menu_custom_css));
        }
    }


    /**
     * Quick Circle Menu
     *
     * @return void
     */
    public function adminify_quick_circle_menu()
    {
        $this->options = (array) AdminSettings::get_instance()->get();
        $quick_menus = !empty($this->options['quick_menus']) ? $this->options['quick_menus'] : '';
        if (empty($quick_menus)) {
            return;
        }
?>
        <div class="wp-adminify-loader"></div>
        <div id="wp-adminify--circle--menu">
            <ul class="circle-menu has-text-centered" id="circle-menu" style="display:none;">
                <li>
                    <a href="#">
                        <svg class="circle-menu-trigger" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 17C21 17.5523 20.5523 18 20 18H4C3.44772 18 3 17.5523 3 17C3 16.4477 3.44772 16 4 16H20C20.5523 16 21 16.4477 21 17ZM21 12C21 12.5523 20.5523 13 20 13H4C3.44772 13 3 12.5523 3 12C3 11.4477 3.44772 11 4 11H20C20.5523 11 21 11.4477 21 12ZM21 7C21 7.55228 20.5523 8 20 8H4C3.44772 8 3 7.55228 3 7C3 6.44772 3.44772 6 4 6H20C20.5523 6 21 6.44772 21 7Z" fill="#4E4B66" />
                        </svg>
                        <svg class="circle-menu-close" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.1547 0.853797C11.079 0.777949 10.9891 0.717774 10.8901 0.676716C10.7911 0.635658 10.685 0.614525 10.5779 0.614525C10.4707 0.614525 10.3646 0.635658 10.2656 0.676716C10.1667 0.717774 10.0768 0.777949 10.0011 0.853797L6.00016 4.84652L1.99925 0.845615C1.9235 0.769866 1.83358 0.709779 1.73461 0.668784C1.63563 0.627789 1.52956 0.606689 1.42243 0.606689C1.31531 0.606689 1.20923 0.627789 1.11026 0.668784C1.01129 0.709779 0.921364 0.769866 0.845615 0.845615C0.769866 0.921364 0.709779 1.01129 0.668784 1.11026C0.627789 1.20923 0.606689 1.31531 0.606689 1.42243C0.606689 1.52956 0.627789 1.63563 0.668784 1.73461C0.709779 1.83358 0.769866 1.9235 0.845615 1.99925L4.84652 6.00016L0.845615 10.0011C0.769866 10.0768 0.709779 10.1667 0.668784 10.2657C0.627789 10.3647 0.606689 10.4708 0.606689 10.5779C0.606689 10.685 0.627789 10.7911 0.668784 10.8901C0.709779 10.989 0.769866 11.079 0.845615 11.1547C0.921364 11.2305 1.01129 11.2905 1.11026 11.3315C1.20923 11.3725 1.31531 11.3936 1.42243 11.3936C1.52956 11.3936 1.63563 11.3725 1.73461 11.3315C1.83358 11.2905 1.9235 11.2305 1.99925 11.1547L6.00016 7.1538L10.0011 11.1547C10.0768 11.2305 10.1667 11.2905 10.2657 11.3315C10.3647 11.3725 10.4708 11.3936 10.5779 11.3936C10.685 11.3936 10.7911 11.3725 10.8901 11.3315C10.989 11.2905 11.079 11.2305 11.1547 11.1547C11.2305 11.079 11.2905 10.989 11.3315 10.8901C11.3725 10.7911 11.3936 10.685 11.3936 10.5779C11.3936 10.4708 11.3725 10.3647 11.3315 10.2657C11.2905 10.1667 11.2305 10.0768 11.1547 10.0011L7.1538 6.00016L11.1547 1.99925C11.4656 1.68834 11.4656 1.16471 11.1547 0.853797Z" fill="white" />
                        </svg>
                    </a>
                </li>

                <?php foreach ($quick_menus as $key => $value) {
                    echo '<li><a href="' . $value['menu_link']['url'] . '" alt="' . $value['menu_title'] . '" target="' . $value['menu_link']['target'] . '" title="' . $value['menu_title'] . '"><i class="' . $value['menu_icon'] . '"></i></a></li>';
                } ?>


            </ul>
        </div>
<?php }
}
