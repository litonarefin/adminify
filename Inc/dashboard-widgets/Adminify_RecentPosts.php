<?php

namespace WPAdminify\Inc\DashboardWidgets;
// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * Recent Posts Dashboard Widget
 *
 * @return void
 */
/**
 * WPAdminify
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */
class Adminify_RecentPosts
{
    public function __construct()
    {
        add_action('wp_dashboard_setup', [$this, 'jltwp_adminify_recent_posts_widget_register']);
    }
    public function jltwp_adminify_recent_posts_widget_register()
    {
        wp_add_dashboard_widget(
            'jltwp_adminify_dash_recent_posts',
            esc_html__('Recent Posts - Adminify', 'adminify'),
            [$this, 'jltwp_adminify_recent_posts_widget']
        );
    }

    public function jltwp_adminify_recent_posts_widget()
    {
        $args = array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => 6,
            'orderby'             => 'date',
            'ignore_sticky_posts' => 1,
            'tax_query'           => array(),
        );
?>

        <div class="jltwp-adminify-list">
            <?php $adminify_dash_recent_posts = new \WP_Query($args);
            if ($adminify_dash_recent_posts->have_posts()) { ?>

                <div class="wp-adminify-recent-posts">
                    <table class="adminify-recent-posts-table">
                        <tr>
                            <th><?php echo esc_html__('Post Title', 'adminify'); ?></th>
                            <th><?php echo esc_html__('Author', 'adminify'); ?></th>
                            <th><?php echo esc_html__('Category', 'adminify'); ?></th>
                            <th>
                                <img src="<?php echo WP_ADMINIFY_ASSETS_IMAGE; ?>widgets/comment.svg" alt="Icon">
                            </th>
                        </tr>

                        <?php while ($adminify_dash_recent_posts->have_posts()) {
                            $adminify_dash_recent_posts->the_post();

                            $post_title = get_the_title();
                            $edit_url = admin_url('post.php?post=' . get_the_ID() . '&action=edit');
                            $image_id = get_post_thumbnail_id();
                            $thumb_image = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID(), array(36, 36)));
                            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                        ?>

                            <tr>
                                <td>
                                    <div class="media">

                                        <?php if (has_post_thumbnail()) { ?>
                                            <a href="<?php echo esc_url($edit_url); ?>">
                                                <div class="media-left adminify-author-avatar image is-36x36">
                                                    <img src="<?php echo esc_url($thumb_image); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                                </div>
                                            </a>
                                        <?php } ?>

                                        <div class="content-body">
                                            <a href="<?php echo esc_url($edit_url); ?>" class="adminify-post-title is-inline-block is-capitalized">
                                                <?php echo get_the_title(); ?>
                                            </a>
                                            <span class="adminify-post-time">
                                                <time datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="adminify-author-name is-capitalized">
                                        <?php echo '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" rel="author" target="_blank">' . esc_html(get_the_author()) . '</a>'; ?>
                                    </h5>
                                </td>
                                <td>
                                    <?php
                                    $categories_list = get_the_category_list(__(', ', 'adminify'));
                                    if ($categories_list) {
                                        printf(
                                            /* translators: %s: List of categories. */
                                            '<div class="adminify-post-category">' . esc_html__('%s', 'adminify') . ' </div>',
                                            $categories_list // phpcs:ignore WordPress.Security.EscapeOutput
                                        );
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="adminify-post-comments">
                                        <span class="adminify-post-counter">
                                            <?php comments_number(esc_html__('0', 'adminify'), esc_html__('1', 'adminify'), esc_html__('%', 'adminify')); ?>
                                        </span>
                                    </div>
                                </td>
                            </tr>

                        <?php } ?>
                    </table>
                </div>

            <?php
                wp_reset_postdata();
            }
            ?>
        </div>
<?php

    }
}
