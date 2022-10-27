<?php

namespace WPAdminify\Inc;

use WPAdminify\Inc\Classes\Helper;
// no direct access allowed
if (!defined('ABSPATH'))  exit;

class Utils
{
    public $post_types = '';

    /**
     * Check if the Module is Enable/Disable
     *
     * @param [type] $value
     *
     * @return void
     */
    public static function check_modules($value)
    {
        if (empty($value)) {
            return;
        } else {
            return true;
        }
    }

    /**
     * Check given value empty or not
     *
     * @param [type] $value
     *
     * @return void
     */
    public static function check_is_empty($value, $default = '')
    {
        $value = !empty(esc_attr($value)) ? $value : $default;
        return $value;
    }


    /**
     * Check given value empty or not
     *
     * @param [type] $value
     *
     * @return void
     */
    public static function restricted_for($restrict_for)
    {
        if (!is_array($restrict_for)) {
            $restrict_for = ['administrator'];
        }

        if (!function_exists('wp_get_current_user')) {
            include(ABSPATH . "wp-includes/pluggable.php");
        }

        $current_user = wp_get_current_user();
        $current_name = $current_user->display_name;
        $current_roles = $current_user->roles;
        $all_roles = wp_roles()->get_names();


        if (in_array($current_name, $restrict_for)) {
            return true;
        }

        // Super Admin for Multisite
        if (is_super_admin() && is_multisite()) {
            if (in_array('Super Admin', $restrict_for)) {
                return true;
            } else {
                return false;
            }
        }

        // Normal Super Admin
        // if ($current_user->ID === 1) {
        //     if (in_array('Super Admin', $restrict_for)) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // }

        foreach ($current_roles as $role) {
            $role_name = $all_roles[$role];
            if (in_array(strtolower($role_name), $restrict_for)) {
                return true;
            }
        }
    }

    /**
     * Check Site wide plugin settings
     */

    public static function is_site_wide($plugin)
    {

        if (!is_multisite()) {
            return false;
        }

        $plugins = get_site_option('active_sitewide_plugins');
        if (isset($plugins[$plugin])) {
            return true;
        }

        return false;
    }


    /**
     * Restricts for role / user
     */

    public static function restrict_for($disabled_for)
    {
        if (!is_array($disabled_for)) {
            return false;
        }

        require_once(ABSPATH . '/wp-includes/pluggable.php');

        if (!function_exists('wp_get_current_user')) {
            return false;
        }
        $current_user = wp_get_current_user();
        $current_name = $current_user->display_name;
        $current_roles = $current_user->roles;

        $formattedroles = array();


        foreach ($disabled_for as $item) {
            $item = strtolower($item);
            $item = str_replace(' ', '_', $item);
            array_push($formattedroles, $item);
        }

        if (in_array($current_name, $disabled_for)) {
            return true;
        }

        foreach ($current_roles as $role) {
            if (in_array($role, $formattedroles)) {
                return true;
            }
        }
    }


    // Get Taxonomies
    public static function get_taxonomies()
    {
        $args = array('public' => true, 'show_ui' => true);
        $output = 'objects';
        $taxonomies = get_taxonomies($args, $output);
        $taxonomies = $taxonomies;
        return $taxonomies;
    }

    // Get Post Types
    public static function get_post_types()
    {
        $args = array('public' => true, 'show_ui' => true);
        $output = 'objects';
        $post_types = get_post_types($args, $output);
        $post_types = $post_types;
        return $post_types;
    }

    // Get Post Meta
    public static function post_meta($meta_key)
    {
        $meta_key = get_post_meta(get_the_ID(), $meta_key, true);
        return $meta_key;
    }


    //// verfiy current page id
    public static function jltwp_adminify_currentpage_id($id)
    {
        if (!function_exists("get_current_screen")) return true;

        $screen = get_current_screen();
        return is_object($screen) && $screen->id == $id;
    }

    /**
     * Get Current Admin Page Title
     *
     * @param string $title
     *
     * @return void
     */
    public static function admin_page_title($title = '')
    {

        $title = isset($title) && !empty($title) ? $title : WP_ADMINIFY;
        echo $title;

        if (is_multisite()) {
            $text = ' | ' . esc_html__('Current Blog ID', 'adminify') . ': ' . get_current_blog_id(); ?>
            <?php echo self::admin_page_subtitle($text); ?>
        <?php } ?>
    <?php }

    /**
     * Get Current Admin Subtitle
     */

    public static function admin_page_subtitle($text)
    { ?>

        <span style="color:#8b959e;" <?php if (is_rtl()) {
                                            echo ' dir="rtl"';
                                        } ?>>
            <?php echo esc_html($text); ?>
        </span>

    <?php }

    public static function convert_name_to_class($name)
    {
        $class = str_replace(array(' ', ',', '.', '"', "'", '/', "\\", '+', '=', ')', '(', '*', '&', '^', '%', '$', '#', '@', '!', '~', '`', '<', '>', '?', '[', ']', '{', '}', '|', ':',), '', $name);
        return $class;
    }

    public static function jltwp_adminify_class_cleanup($string)
    {
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }

    public static function sanitize_id($url)
    {
        $url = preg_replace('/^customize.php\?return=.*$/', 'customize', $url);
        $url = preg_replace('/(&|&amp;|&#038;)?_wpnonce=([^&]+)/', '', $url);
        return str_replace(array('.php', '.', '/', '?', '='), array('', '_', '_', '_', '_'), $url);
    }

    /**
     * Strip tags and it's content from the given string.
     *
     * @link https://stackoverflow.com/questions/14684077/remove-all-html-tags-from-php-string/#answer-39320168
     *
     * @param string $text The string being stripped.
     * @return string The stripped string.
     */
    public static function strip_tags_content($text)
    {

        $cleanup = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
        $cleanup = wp_strip_all_tags($cleanup);
        $cleanup = trim($cleanup);

        return $cleanup;
    }

    /**
     * String to ID
     * Remove Space replace with underscore and lowercase
     *
     * @param void
     *
     * @return string
     */
    public static function string_to_id($string)
    {
        $string_replace = str_replace(" ", "_", $string);
        $formatted_string = strtolower($string_replace);
        return $formatted_string;
    }

    /**
     * ID to String
     * Remove Space replace with underscore and lowercase
     *
     * @param void
     *
     * @return string
     */
    public static function id_to_string($string)
    {
        $string_replace = str_replace("_", " ", $string);
        $formatted_string = ucwords($string_replace);
        return $formatted_string;
    }

    /**
     * Check is Plugin Active
     *
     * @param [type] $plugin_basename
     *
     * @return boolean
     */
    public static function is_plugin_active($plugin_basename)
    {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        return is_plugin_active($plugin_basename);
    }

    /**
     * User Defined Settings
     */

    public static function get_user_preference($key)
    {

        $userid = get_current_user_id();
        $current = get_user_meta($userid, '_wpadminify_preferences', true);
        $value = false;

        if (is_array($current)) {
            if (isset($current[$key])) {
                $value = $current[$key];
            }
        }

        return $value;
    }


    /**
     * Sanitises and strips tags of input from ajax
     * @since 1.0.0
     * @variables $values = item to clean (array or string)
     */
    public static function clean_ajax_input($values)
    {

        if (is_array($values)) {
            foreach ($values as $index => $in) {
                if (is_array($in)) {
                    $values[$index] = self::clean_ajax_input($in);
                } else {
                    $values[$index] = strip_tags($in);
                }
            }
        } else {
            $values = strip_tags($values);
        }

        return $values;
    }

    /**
     * Check Ajax Error Messages
     *
     * @param [type] $message
     *
     * @return void
     */
    public static function ajax_error_message($message)
    {
        $returndata = array();
        $returndata['error'] = true;
        $returndata['error_message'] = $message;
        return json_encode($returndata);
    }

    /**
     * Get All Updates
     * Themes, Plugins, Core etc
     *
     * @return void
     */
    public static function get_all_updates()
    {
        $allupdates = [];
        $allupdates['total'] = 0;
        $allupdates['wordpress'] = 0;
        $allupdates['theme'] = 0;
        $allupdates['plugin'] = 0;

        if (!is_admin()) {
            return $allupdates;
        }

        if (!current_user_can('install_plugins')) {
            return $allupdates;
        }
        $updatesTotal = 0;
        if (is_super_admin() && is_admin()) {
            $pluginUpdates = get_plugin_updates();
            $themeUpdates  = get_theme_updates();
            $wpUpdates     = get_core_updates();

            if (isset($wpUpdates[0])) {
                $wpversion =  $wpUpdates[0]->version;
                global $wp_version;

                if ($wpversion > $wp_version) {
                    $wpUpdates = 1;
                } else {
                    $wpUpdates = 0;
                }
            } else {
                $wpUpdates = 0;
            }

            $updatesTotal = count($pluginUpdates) + count($themeUpdates) + $wpUpdates;

            $allupdates['total']     = $updatesTotal;
            $allupdates['wordpress'] = $wpUpdates;
            $allupdates['theme']     = $themeUpdates;
            $allupdates['plugin']    = $pluginUpdates;
        }
        return $allupdates;
    }

    public static function adminfiy_help_urls($module_name = '', $docs = '', $youtube = '', $facebook_grp = '', $support = '')
    {
        $help_content = '';

        // Modules
        if (empty($module_name)) {
            $module_name = 'Module';
        } else {
            $module_name = $module_name;
        }

        // Docs
        if (empty($docs)) {
            $docs = 'https://wpadminify.com/kb';
        } else {
            $docs = $docs;
        }

        // youtube
        if (empty($youtube)) {
            $youtube = 'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8';
        } else {
            $youtube = $youtube;
        }

        // facebook_grp
        if (empty($facebook_grp)) {
            $facebook_grp = 'https://www.facebook.com/groups/jeweltheme';
        } else {
            $facebook_grp = $facebook_grp;
        }

        // Support
        if (empty($support)) {
            $support = 'https://wpadminify.com/support/wp-adminify';
        } else {
            $support = $support;
        }


        $help_content = sprintf(
            __('%1$s <a class="adminify-docs-url" href="%2$s" target="_blank"> ' . Utils::docs_icon() . ' Docs</a>
                <a  class="adminify-video-url" href="%3$s" target="_blank">' . Utils::video_tutorials_icon() . ' Video Tutorial</a> <a  class="adminify-fbgroup-url" href="%4$s" target="_blank">' . Utils::fbgroup_icon() . ' Facebook Group</a> <a  class="adminify-support-url" href="%5$s" target="_blank">' . Utils::support_icon() . ' Support</a>', 'adminify'),
            $module_name,
            $docs,
            $youtube,
            $facebook_grp,
            $support
        );
        return $help_content;
    }


    // Upgrade to Pro Notice
    public static function adminify_upgrade_pro($custom_message = '')
    {
        $pro_content = '';
        $pro_message = '';

        if (empty($custom_message)) {
            $pro_message = 'Get <strong>Pro Version</strong> to Unlock this feature.';
        } else {
            $pro_content = $custom_message;
        }

        if (!jltwp_adminify()->can_use_premium_code__premium_only()) {
            if(!empty($custom_message)){
                $pro_message = $custom_message;
            }
            $jltwp_pro_notice = sprintf(__('%s <a href="https://wpadminify.com/pricing" target="_blank">Upgrade to Pro Now!</a>', 'adminify'), $pro_message);
            $pro_content = '<div class="adminify-pro-notice">
            <svg class="adminify-pro-notice-icon is-pulled-left mr-2" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.8233 0.18318C21.8541 0.215042 21.8753 0.255055 21.8843 0.298527C22.5767 3.32046 20.085 9.8239 16.4731 13.4209C15.8343 14.064 15.1407 14.6502 14.4002 15.1727C14.4955 16.2787 14.411 17.3846 13.9985 18.3318C12.8302 21.0043 9.75855 21.7824 8.44197 21.9937C8.36979 22.0059 8.29577 22.0012 8.22571 21.9799C8.15566 21.9587 8.09147 21.9215 8.03819 21.8713C7.9849 21.821 7.94397 21.7591 7.9186 21.6904C7.89323 21.6217 7.88411 21.548 7.89196 21.4751L8.36241 17.189C8.04096 17.1858 7.71987 17.1663 7.40039 17.1305C7.17735 17.1087 6.96893 17.0096 6.81109 16.8503L5.15076 15.1924C4.99146 15.0346 4.89242 14.8259 4.87084 14.6026C4.83497 14.281 4.81547 13.9578 4.8124 13.6343L0.524795 14.1076C0.451994 14.1156 0.378341 14.1065 0.309629 14.0811C0.240917 14.0558 0.17902 14.0148 0.128806 13.9615C0.0785915 13.9081 0.0414297 13.8438 0.0202432 13.7736C-0.000943262 13.7035 -0.0055768 13.6293 0.00670721 13.5571C0.223273 12.2368 1.00065 9.16771 3.67065 7.99148C4.61695 7.57859 5.72728 7.4965 6.83761 7.59481C7.35968 6.85546 7.94513 6.16306 8.58733 5.52547C12.1879 1.92304 18.8337 -0.585245 21.7099 0.118627C21.7531 0.128924 21.7924 0.151317 21.8233 0.18318ZM12.224 7.92186C12.3151 8.37957 12.5397 8.79996 12.8695 9.12986C13.0882 9.34908 13.348 9.52298 13.6339 9.64164C13.9198 9.7603 14.2263 9.82137 14.5358 9.82137C14.8453 9.82137 15.1517 9.7603 15.4377 9.64164C15.7236 9.52298 15.9833 9.34908 16.202 9.12986C16.5318 8.79996 16.7565 8.37957 16.8475 7.92186C16.9386 7.46415 16.892 6.98968 16.7137 6.55848C16.5353 6.12727 16.2332 5.7587 15.8455 5.49939C15.4578 5.24007 15.002 5.10166 14.5358 5.10166C14.0695 5.10166 13.6137 5.24007 13.226 5.49939C12.8384 5.7587 12.5362 6.12727 12.3579 6.55848C12.1795 6.98968 12.1329 7.46415 12.224 7.92186ZM5.47798 18.5161C5.99754 18.4262 6.4292 18.321 6.69831 18.0511C6.83974 17.9032 7.0897 18.0256 7.07153 18.2311C6.99299 18.8853 6.69667 19.4941 6.23032 19.9593C5.07579 21.1158 0.785726 21.225 0.785726 21.225C0.785726 21.225 0.894746 16.9334 2.04927 15.7768C2.51439 15.3115 3.12167 15.0153 3.77443 14.9353C3.81912 14.9292 3.86459 14.9374 3.90439 14.9586C3.94419 14.9799 3.97629 15.0131 3.99613 15.0537C4.01597 15.0942 4.02255 15.14 4.01493 15.1845C4.00731 15.229 3.98588 15.2699 3.95368 15.3015C3.80635 15.449 3.56965 16.0767 3.48961 16.5245C3.27991 17.7056 4.31069 18.7152 5.47798 18.5161Z" fill="#00BA88"/>
            </svg>
            <p> ' . $jltwp_pro_notice . '</p>
        </div>';
            return $pro_content;
        } else {
            return '<div class="adminify-pro-notice">            <svg class="adminify-pro-notice-icon is-pulled-left mr-2" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.8233 0.18318C21.8541 0.215042 21.8753 0.255055 21.8843 0.298527C22.5767 3.32046 20.085 9.8239 16.4731 13.4209C15.8343 14.064 15.1407 14.6502 14.4002 15.1727C14.4955 16.2787 14.411 17.3846 13.9985 18.3318C12.8302 21.0043 9.75855 21.7824 8.44197 21.9937C8.36979 22.0059 8.29577 22.0012 8.22571 21.9799C8.15566 21.9587 8.09147 21.9215 8.03819 21.8713C7.9849 21.821 7.94397 21.7591 7.9186 21.6904C7.89323 21.6217 7.88411 21.548 7.89196 21.4751L8.36241 17.189C8.04096 17.1858 7.71987 17.1663 7.40039 17.1305C7.17735 17.1087 6.96893 17.0096 6.81109 16.8503L5.15076 15.1924C4.99146 15.0346 4.89242 14.8259 4.87084 14.6026C4.83497 14.281 4.81547 13.9578 4.8124 13.6343L0.524795 14.1076C0.451994 14.1156 0.378341 14.1065 0.309629 14.0811C0.240917 14.0558 0.17902 14.0148 0.128806 13.9615C0.0785915 13.9081 0.0414297 13.8438 0.0202432 13.7736C-0.000943262 13.7035 -0.0055768 13.6293 0.00670721 13.5571C0.223273 12.2368 1.00065 9.16771 3.67065 7.99148C4.61695 7.57859 5.72728 7.4965 6.83761 7.59481C7.35968 6.85546 7.94513 6.16306 8.58733 5.52547C12.1879 1.92304 18.8337 -0.585245 21.7099 0.118627C21.7531 0.128924 21.7924 0.151317 21.8233 0.18318ZM12.224 7.92186C12.3151 8.37957 12.5397 8.79996 12.8695 9.12986C13.0882 9.34908 13.348 9.52298 13.6339 9.64164C13.9198 9.7603 14.2263 9.82137 14.5358 9.82137C14.8453 9.82137 15.1517 9.7603 15.4377 9.64164C15.7236 9.52298 15.9833 9.34908 16.202 9.12986C16.5318 8.79996 16.7565 8.37957 16.8475 7.92186C16.9386 7.46415 16.892 6.98968 16.7137 6.55848C16.5353 6.12727 16.2332 5.7587 15.8455 5.49939C15.4578 5.24007 15.002 5.10166 14.5358 5.10166C14.0695 5.10166 13.6137 5.24007 13.226 5.49939C12.8384 5.7587 12.5362 6.12727 12.3579 6.55848C12.1795 6.98968 12.1329 7.46415 12.224 7.92186ZM5.47798 18.5161C5.99754 18.4262 6.4292 18.321 6.69831 18.0511C6.83974 17.9032 7.0897 18.0256 7.07153 18.2311C6.99299 18.8853 6.69667 19.4941 6.23032 19.9593C5.07579 21.1158 0.785726 21.225 0.785726 21.225C0.785726 21.225 0.894746 16.9334 2.04927 15.7768C2.51439 15.3115 3.12167 15.0153 3.77443 14.9353C3.81912 14.9292 3.86459 14.9374 3.90439 14.9586C3.94419 14.9799 3.97629 15.0131 3.99613 15.0537C4.01597 15.0942 4.02255 15.14 4.01493 15.1845C4.00731 15.229 3.98588 15.2699 3.95368 15.3015C3.80635 15.449 3.56965 16.0767 3.48961 16.5245C3.27991 17.7056 4.31069 18.7152 5.47798 18.5161Z" fill="#00BA88"/>
            </svg>' . $pro_content . '</div>';
        }
    }



    /**
     * Documentation SVG Icon
     */
    public static function docs_icon()
    {
        return '<svg class="is-pulled-left mr-1 width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5.25 3.1875V0H0.5625C0.250781 0 0 0.250781 0 0.5625V11.4375C0 11.7492 0.250781 12 0.5625 12H8.4375C8.74922 12 9 11.7492 9 11.4375V3.75H5.8125C5.50313 3.75 5.25 3.49687 5.25 3.1875ZM6.75 8.71875C6.75 8.87344 6.62344 9 6.46875 9H2.53125C2.37656 9 2.25 8.87344 2.25 8.71875V8.53125C2.25 8.37656 2.37656 8.25 2.53125 8.25H6.46875C6.62344 8.25 6.75 8.37656 6.75 8.53125V8.71875ZM6.75 7.21875C6.75 7.37344 6.62344 7.5 6.46875 7.5H2.53125C2.37656 7.5 2.25 7.37344 2.25 7.21875V7.03125C2.25 6.87656 2.37656 6.75 2.53125 6.75H6.46875C6.62344 6.75 6.75 6.87656 6.75 7.03125V7.21875ZM6.75 5.53125V5.71875C6.75 5.87344 6.62344 6 6.46875 6H2.53125C2.37656 6 2.25 5.87344 2.25 5.71875V5.53125C2.25 5.37656 2.37656 5.25 2.53125 5.25H6.46875C6.62344 5.25 6.75 5.37656 6.75 5.53125ZM9 2.85703V3H6V0H6.14297C6.29297 0 6.43594 0.0585938 6.54141 0.164062L8.83594 2.46094C8.94141 2.56641 9 2.70938 9 2.85703Z" fill="#0347FF"/>
        </svg>';
    }
    /**
     * Video Tutorials SVG Icon
     */
    public static function video_tutorials_icon()
    {
        return '<svg class="is-pulled-left mr-1 width="8" height="10" viewBox="0 0 8 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.5 4.13399C8.16667 4.51889 8.16667 5.48114 7.5 5.86604L1.5 9.33014C0.833334 9.71504 0 9.23392 0 8.46412V1.53592C0 0.766115 0.833333 0.28499 1.5 0.66989L7.5 4.13399Z" fill="#C30052"/>
            </svg>';
    }

    /**
     * Facebook Group SVG Icon
     */
    public static function fbgroup_icon()
    {
        return '<svg class="is-pulled-left mr-1 width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.82594 0C0.814448 0 0 0.814448 0 1.82594V8.17405C0 9.18554 0.814448 9.99999 1.82594 9.99999H5.26656V6.09062H4.23281V4.68312H5.26656V3.48062C5.26656 2.53587 5.87735 1.66844 7.28437 1.66844C7.85404 1.66844 8.2753 1.72313 8.2753 1.72313L8.24217 3.0375C8.24217 3.0375 7.81254 3.03344 7.34374 3.03344C6.83635 3.03344 6.75499 3.26722 6.75499 3.65532V4.68313H8.28248L8.21592 6.09063H6.75499V10H8.17404C9.18553 10 9.99998 9.18555 9.99998 8.17406V1.82595C9.99998 0.814458 9.18553 9.99998e-06 8.17404 9.99998e-06H1.82593L1.82594 0Z" fill="#3B5998"/>
        </svg>';
    }

    /**
     * Support SVG Icon
     */
    public static function support_icon()
    {
        return '<svg class="is-pulled-left mr-1 width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M10 5C10 6.32608 9.47322 7.59785 8.53553 8.53553C7.59785 9.47322 6.32608 10 5 10C3.67392 10 2.40215 9.47322 1.46447 8.53553C0.526784 7.59785 0 6.32608 0 5C0 3.67392 0.526784 2.40215 1.46447 1.46447C2.40215 0.526784 3.67392 0 5 0C6.32608 0 7.59785 0.526784 8.53553 1.46447C9.47322 2.40215 10 3.67392 10 5ZM8.75 5C8.75 5.62063 8.59937 6.20563 8.3325 6.72125L7.38 5.76813C7.52262 5.32668 7.5395 4.85425 7.42875 4.40375L8.405 3.4275C8.62625 3.90563 8.75 4.4375 8.75 5ZM5.52187 7.44563L6.50938 8.43312C6.03375 8.64254 5.51968 8.75046 5 8.75C4.45699 8.75068 3.92036 8.63294 3.4275 8.405L4.40375 7.42875C4.77042 7.5186 5.15266 7.52437 5.52187 7.44563ZM2.59875 5.69812C2.47576 5.27463 2.46692 4.82614 2.57313 4.39812L2.52313 4.44812L1.56687 3.49C1.35738 3.96582 1.24945 4.48011 1.25 5C1.25 5.59625 1.38937 6.16 1.63687 6.66062L2.59938 5.69812H2.59875ZM3.27875 1.66687C3.81076 1.39189 4.40112 1.24891 5 1.25C5.59625 1.25 6.16 1.38937 6.66062 1.63687L5.69812 2.59938C5.21829 2.45961 4.70759 2.46679 4.23187 2.62L3.27875 1.6675V1.66687ZM6.25 5C6.25 5.33152 6.1183 5.64946 5.88388 5.88388C5.64946 6.1183 5.33152 6.25 5 6.25C4.66848 6.25 4.35054 6.1183 4.11612 5.88388C3.8817 5.64946 3.75 5.33152 3.75 5C3.75 4.66848 3.8817 4.35054 4.11612 4.11612C4.35054 3.8817 4.66848 3.75 5 3.75C5.33152 3.75 5.64946 3.8817 5.88388 4.11612C6.1183 4.35054 6.25 4.66848 6.25 5Z" fill="#4E4B66"/>
            </svg>';
    }

    /* White Label Upgrade Pro */
    public static function jltwp_adminify_white_label_upgrade()
    {

        ?>
        <div class="wp-adminify-white-label-notice-content">
            <div class="wp-adminify-white-label-notice-logo">
                <img src="<?php echo WP_ADMINIFY_ASSETS_IMAGE . 'logos/logo-text-light.svg'; ?>" alt="<?php echo WP_ADMINIFY; ?>">
            </div>
            <h2>
                <?php _e('Upgrade <span>Pro</span> for White Labeling', 'adminify'); ?>
            </h2>
            <p>
                <?php echo sprintf(__('<strong>%1$s</strong> can be completely re-branded with your own brand Logo, Name and Author Details. Your clients will never know what tools you are using to build their website and will think that this is your own tool set. White-labeling works as long as your license is active. ', 'adminify'), WP_ADMINIFY);

                _e('', 'adminify'); ?><br>
                <em><?php _e('Note: Agency or Higher Plans Only', 'adminify'); ?></em>
            </p>
            <a class="wp-adminify-btn wp-adminify-get-pro" href="<?php echo esc_url('https://wpadminify.com/pricing/'); ?>" target="_blank"><?php _e('Upgrade Now', 'adminify'); ?></a>
        </div>
        <?php 
    }


    public static function get_widget_template_options()
    {
        $type = 'widget';
        $page_templates = self::jltwp_adminify_get_page_templates($type);

        $options[-1]   = __('Select', 'adminify');

        if (count($page_templates)) {
            foreach ($page_templates as $id => $name) {
                $options[$id] = $name;
            }
        } else {
            $options['no_template'] = __('No saved templates found!', 'adminify');
        }

        return $options;
    }

    public static function get_section_template_options()
    {
        $type = 'section';
        $page_templates = self::jltwp_adminify_get_page_templates($type);

        $options[-1]   = __('Select', 'adminify');

        if (count($page_templates)) {
            foreach ($page_templates as $id => $name) {
                $options[$id] = $name;
            }
        } else {
            $options['no_template'] = __('No saved templates found!', 'adminify');
        }

        return $options;
    }

    public static function get_page_template_options()
    {
        $type = 'page';
        $page_templates = self::jltwp_adminify_get_page_templates($type);

        $options[-1]   = __('Select', 'adminify');

        if (count($page_templates)) {
            foreach ($page_templates as $id => $name) {
                $options[$id] = $name;
            }
        } else {
            $options['no_template'] = __('No saved templates found!', 'adminify');
        }

        return $options;
    }

    public static function get_theme_presets($theme = null)
    {

        $presets = [

            // Base/ Default Preset
            'preset1' => [
                '--adminify-preset-background'         => '#F9F9F9',
                '--adminify-menu-bg'                   => '#ffffff',
                '--adminify-menu-text-color'           => 'rgba(78, 75, 102, 0.72)',
                '--adminify-admin-bar-bg'              => 'var(--adminify-menu-bg)',
                '--adminify-admin-bar-icon'            => '#14142B',
                '--adminify-admin-bar-input-bg'        => '#F1F1F3',
                '--adminify-admin-bar-input-text'      => '#14142B',
                '--adminify-admin-bar-icon-brightness' => '1',
                '--adminify-notif-bg-color'            => '#FF1C69',
                '--adminify-text-color'                => '#ffffff',
                '--adminify-btn-bg'                    => '#0347FF',
                '--adminify-admin-bar-icon-filter'     => '0.5',
            ],

            'preset2' => [
                '--adminify-preset-background'         => '#F9F9F9',
                '--adminify-menu-bg'                   => '#14142B',
                '--adminify-menu-text-color'           => '#ffffff',
                '--adminify-admin-bar-bg'              => 'var(--adminify-menu-bg)',
                '--adminify-admin-bar-icon'            => '#ffffff',
                '--adminify-admin-bar-input-bg'        => '#2b2a3f',
                '--adminify-admin-bar-input-text'      => '#9391A0',
                '--adminify-admin-bar-icon-brightness' => '11',
                '--adminify-notif-bg-color'            => '#FF1C69',
                '--adminify-text-color'                => '#ffffff',
                '--adminify-btn-bg'                    => '#0347FF',
                '--adminify-admin-bar-icon-filter'     => '1',
            ],
        ];


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $pro_presets = [

                'preset3' => [
                    '--adminify-preset-background'         => '#F9F9F9',
                    '--adminify-menu-bg'                   => '#3F3535',
                    '--adminify-menu-text-color'           => '#ffffff',
                    '--adminify-admin-bar-bg'              => 'var(--adminify-menu-bg)',
                    '--adminify-admin-bar-icon'            => '#ffffff',
                    '--adminify-admin-bar-input-bg'        => '#514a4a',
                    '--adminify-admin-bar-input-text'      => '#9391A0',
                    '--adminify-admin-bar-icon-brightness' => '11',
                    '--adminify-notif-bg-color'            => '#3397C1',
                    '--adminify-text-color'                => '#ffffff',
                    '--adminify-btn-bg'                    => '#FF8811',
                    '--adminify-admin-bar-icon-filter'     => '1',
                ],

                'preset4' => [
                    '--adminify-preset-background'         => '#F9F9F9',
                    '--adminify-menu-bg'                   => '#0e6980',
                    '--adminify-menu-text-color'           => '#ffffff',
                    '--adminify-admin-bar-bg'              => 'var(--adminify-menu-bg)',
                    '--adminify-admin-bar-icon'            => '#ffffff',
                    '--adminify-admin-bar-input-bg'        => '#25788d',
                    '--adminify-admin-bar-input-text'      => '#ffffff',
                    '--adminify-admin-bar-icon-brightness' => '11',
                    '--adminify-notif-bg-color'            => '#FF8811',
                    '--adminify-text-color'                => '#ffffff',
                    '--adminify-btn-bg'                    => '#2EB5E0',
                    '--adminify-admin-bar-icon-filter'     => '1',
                ],

                'preset5' => [
                    '--adminify-preset-background'         => '#F9F9F9',
                    '--adminify-menu-bg'                   => '#603f8b',
                    '--adminify-menu-text-color'           => '#ffffff',
                    '--adminify-admin-bar-bg'              => 'var(--adminify-menu-bg)',
                    '--adminify-admin-bar-icon'            => '#ffffff',
                    '--adminify-admin-bar-input-bg'        => '#705197',
                    '--adminify-admin-bar-input-text'      => '#ffffff',
                    '--adminify-admin-bar-icon-brightness' => '11',
                    '--adminify-notif-bg-color'            => '#FD49A0',
                    '--adminify-text-color'                => '#ffffff',
                    '--adminify-btn-bg'                    => '#fd49a0',
                    '--adminify-admin-bar-icon-filter'     => '1',
                ],

                'preset6' => [
                    '--adminify-preset-background'         => '#F9F9F9',
                    '--adminify-menu-bg'                   => '#eb3135',
                    '--adminify-menu-text-color'           => '#ffffff',
                    '--adminify-admin-bar-bg'              => 'var(--adminify-menu-bg)',
                    '--adminify-admin-bar-icon'            => '#ffffff',
                    '--adminify-admin-bar-input-bg'        => '#d42c31',
                    '--adminify-admin-bar-input-text'      => '#ffffff',
                    '--adminify-admin-bar-icon-brightness' => '11',
                    '--adminify-notif-bg-color'            => '#90BE6D',
                    '--adminify-text-color'                => '#ffffff',
                    '--adminify-btn-bg'                    => '#ffb705',
                    '--adminify-admin-bar-icon-filter'     => '1',
                ],

                'preset7' => [
                    '--adminify-preset-background'         => '#F9F9F9',
                    '--adminify-menu-bg'                   => '#344e41',
                    '--adminify-menu-text-color'           => '#ffffff',
                    '--adminify-admin-bar-bg'              => 'var(--adminify-menu-bg)',
                    '--adminify-admin-bar-icon'            => '#ffffff',
                    '--adminify-admin-bar-input-bg'        => '#496054',
                    '--adminify-admin-bar-input-text'      => '#9391A0',
                    '--adminify-admin-bar-icon-brightness' => '11',
                    '--adminify-notif-bg-color'            => '#A3B18A',
                    '--adminify-text-color'                => '#ffffff',
                    '--adminify-btn-bg'                    => '#588157',
                    '--adminify-admin-bar-icon-filter'     => '1',
                ],

                'preset8' => [
                    '--adminify-preset-background'         => '#F9F9F9',
                    '--adminify-menu-bg'                   => '#2a4494',
                    '--adminify-menu-text-color'           => '#ffffff',
                    '--adminify-admin-bar-bg'              => 'var(--adminify-menu-bg)',
                    '--adminify-admin-bar-icon'            => '#ffffff',
                    '--adminify-admin-bar-input-bg'        => '#263d85',
                    '--adminify-admin-bar-input-text'      => '#ffffff',
                    '--adminify-admin-bar-icon-brightness' => '11',
                    '--adminify-notif-bg-color'            => '#FF961F',
                    '--adminify-text-color'                => '#ffffff',
                    '--adminify-btn-bg'                    => '#3c95ff',
                    '--adminify-admin-bar-icon-filter'     => '1',
                ],

                'preset9' => [
                    '--adminify-preset-background'         => '#F9F9F9',
                    '--adminify-menu-bg'                   => '#4738a6',
                    '--adminify-menu-text-color'           => '#ffffff',
                    '--adminify-admin-bar-bg'              => 'var(--adminify-menu-bg)',
                    '--adminify-admin-bar-icon'            => '#ffffff',
                    '--adminify-admin-bar-input-bg'        => '#594caf',
                    '--adminify-admin-bar-input-text'      => '#ffffff',
                    '--adminify-admin-bar-icon-brightness' => '11',
                    '--adminify-notif-bg-color'            => '#FD49A0',
                    '--adminify-text-color'                => '#ffffff',
                    '--adminify-btn-bg'                    => '#48c7fd',
                    '--adminify-admin-bar-icon-filter'     => '1',
                ],
            ];
            $presets = array_merge($presets, $pro_presets);
        }
        // return all presets
        if (is_null($theme)) return $presets;

        // return specific preset
        if (array_key_exists($theme, $presets)) return $presets[$theme];

        // specific preset not found
        return [];
    }

    public static function jltwp_adminify_get_page_templates($type = '')
    {
        $args = [
            'post_type'         => 'elementor_library',
            'posts_per_page'    => -1,
        ];

        if ($type) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'elementor_library_type',
                    'field'    => 'slug',
                    'terms' => $type,
                ]
            ];
        }

        $page_templates = get_posts($args);

        $options = array();

        if (!empty($page_templates) && !is_wp_error($page_templates)) {
            foreach ($page_templates as $post) {
                $options[$post->ID] = $post->post_title;
            }
        }
        return $options;
    }

    public static function assets_ext( $ext ) {
        if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) return $ext;
        return '.min' . $ext;
    }
}
