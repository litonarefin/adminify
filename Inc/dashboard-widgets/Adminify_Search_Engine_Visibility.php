<?php

namespace WPAdminify\Inc\DashboardWidgets;
// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * Search Engine Visibility Dashboard Widget
 *
 * @return void
 */
/**
 * WPAdminify
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class Adminify_Search_Engine_Visibility
{
    public function __construct()
    {
        add_action('wp_dashboard_setup', [$this, 'jltwp_adminify_search_engine_visibility']);
        add_action('admin_enqueue_scripts', [$this, 'jltwp_adminify_search_engine_visibility_css']);
    }


    /**
     * Label: Search Engine Visibility
     *
     * @return void
     */
    public function jltwp_adminify_search_engine_visibility()
    {
        wp_add_dashboard_widget(
            'jltwp_adminify_dash_search_engine_visibility',
            esc_html__('Search Engine Visibility - Adminify', 'adminify'),
            [$this, 'jltwp_adminify_search_engine_visibility_details']
        );
    }


    public function jltwp_adminify_search_engine_visibility_css()
    {
        $screen = get_current_screen();
        if ($screen->id == 'dashboard') {

            // Dashboard Widget Custom CSS Code Here
            $adminify_dash_css = '';
            $adminify_dash_css .= '.wp-adminify-seo-visibility {margin:-11px -15px -15px -15px;text-align:center;}
            .wp-adminify-seo-visibility-focus {line-height:normal;color:#82878c;font-size:40px;border-bottom:1px solid #eee;padding:23px 20px 28px 20px}
            .wp-adminify-seo-visibility-focus:last-child {border-bottom:0px}
            .wp-adminify-seo-visibility .adminify-warning {display:inline-block;color:#ffb900}
            .wp-adminify-seo-visibility .adminify-success {display:inline-block;color:#00BA88}
            .wp-adminify-seo-visibility-focus .wp-adminify-seo-visibility-num span {width:auto;height:auto;font-size:40px}
            .wp-adminify-seo-visibility-focus .wp-adminify-seo-visibility-num ~ div {font-size:16px;font-weight:400;line-height:1.4em;width:100%}            ';
            echo '<style>' . wp_strip_all_tags($adminify_dash_css) . '</style>';
        }
    }


    /**
     * Dashboard Widgets: Search Engine Visibility Widget Details
     *
     * @return void
     */
    public function jltwp_adminify_search_engine_visibility_details()
    {
        $visibility = get_option('blog_public');
        if (is_multisite()) {
            $visibility = get_blog_option(get_current_blog_id(), 'blog_public', array());
        }
        if (0 == $visibility) {
?>
            <div class="wp-adminify-seo-visibility">
                <div class="wp-adminify-seo-visibility-focus adminify-warning">
                    <div class="wp-adminify-seo-visibility-num">
                        <span class="dashicons dashicons-warning"></span>
                    </div>
                    <div><?php esc_html_e('Your website is currently not visible to search engines!', 'adminify'); ?></div>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="wp-adminify-seo-visibility">
                <div class="wp-adminify-seo-visibility-focus adminify-success">
                    <div class="wp-adminify-seo-visibility-num">
                        <span class="dashicons dashicons-yes-alt"></span>
                    </div>
                    <div><?php esc_html_e('Your website is currently visible to search engines', 'adminify'); ?></div>
                </div>
            </div>
<?php
        }
    }
}
