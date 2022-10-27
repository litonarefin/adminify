<?php

namespace WPAdminify\Inc\DashboardWidgets;
// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * Dashboard Widget: News Feed
 *
 * @return void
 */
/**
 * WPAdminify
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class Adminify_News_Feed
{
    public function __construct()
    {
        // add_action('wp_dashboard_setup', [$this, 'jltwp_adminify_news_feed']);
        add_action('admin_enqueue_scripts', [$this, 'jltwp_adminify_news_feed_css']);
    }


    /**
     * Label: News Feed
     *
     * @return void
     */
    public function jltwp_adminify_news_feed()
    {
        wp_add_dashboard_widget(
            'jltwp_adminify_dash_news_feed',
            esc_html__('News Feed - Jewel Theme', 'adminify'),
            [$this, 'jltwp_adminify_news_feed_details']
        );
    }


    public function jltwp_adminify_news_feed_css()
    {
        $screen = get_current_screen();
        if ($screen->id == 'dashboard') {
        }
    }


    public function get_dashboard_overview_widget_footer_actions()
    {
        $base_actions = [
            'blog' => [
                'title' => esc_html__('Blog', 'adminify'),
                'link' => 'http://wpadminify.com/blog/',
            ],
            'help' => [
                'title' => esc_html__('Help', 'adminify'),
                'link' => 'http://wpadminify.com/docs/',
            ],
        ];

        $additions_actions = [
            'go-pro' => [
                'title' => esc_html__('Go Pro', 'adminify'),
                'link' => 'https://wpadminify.com/pricing/#utm_source=wpdashboard&utm_medium=dashboardwidget&utm_campaign=wpdashboardwidget&utm_id=wpdashboard&utm_term=wpdashboardwidget&utm_content=wpdashboardwidget',
            ],
        ];

        $additions_actions = apply_filters(
            'master_addons/admin/dashboard_overview_widget/footer_actions',
            $additions_actions
        );

        $actions = $base_actions + $additions_actions;

        return $actions;
    }


    /**
     * Dashboard Widgets: News Feed Widget Details
     *
     * @return void
     */
    public function jltwp_adminify_news_feed_details()
    {
        // <span class="dashicons dashicons-edit"></span>
        echo '<div class="wp-adminify-news-feed-posts">';
        wp_widget_rss_output(array(
            'url'          => 'https://jeweltheme.com/feed',
            'title'        => esc_html__('Jewel Theme News & Updates', 'adminify'),
            'items'        => 5,
            'show_summary' => 0,
            'show_author'  => 0,
            'show_date'    => 0
        ));
        echo "</div>";
?>


        <div class="wp-adminify-news-feed-dashboard_footer">
            <ul class="m-0 is-inline-block">
                <?php foreach ($this->get_dashboard_overview_widget_footer_actions() as $action_id => $action) : ?>
                    <li class="is-pulled-left mr-3 wp-adminify_overview__<?php echo esc_attr($action_id); ?>">
                        <a href="<?php echo esc_attr($action['link']); ?>" target="_blank">
                            <?php echo esc_html($action['title']); ?>
                            <span class="screen-reader-text">
                                <?php echo __('(opens in a new window)', 'adminify'); ?>
                            </span>
                            <span aria-hidden="true" class="dashicons dashicons-external">
                            </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

<?php

    }
}
