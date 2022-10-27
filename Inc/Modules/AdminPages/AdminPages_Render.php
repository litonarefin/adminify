<?php

namespace WPAdminify\Inc\Modules\AdminPages;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WPAdminify
 * @package Admin Pages
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */


class AdminPages_Render extends AdminPagesModel
{

    public function __construct($post, $from_multisite = false)
    {
        $this->init_admin_page_content_new($post, $from_multisite);
    }

    public function init_admin_page_content_new($post, $from_multisite)
    {

        $remove_page_title  = $post->remove_page_title;
        $remove_page_margin = $post->remove_page_margin;

        $custom_css = $post->custom_css;

        $link = get_permalink($post);
        $link = add_query_arg('bknd', 1, $link);

        printf('<iframe class="wp-adminify--admin-page" src="%s"></iframe>', $link);

?>

        <style>
            .wp-adminify #wpbody-content {
                position: relative;
                overflow: hidden;
            }

            iframe.wp-adminify--admin-page {
                width: 100%;
                height: 100%;
                position: relative;
            }

            <?php if ($remove_page_margin) : ?>#wpcontent {
                padding-left: 0;
            }

            .wrap {
                margin: 0;
            }

            <?php endif; ?>
        </style>

        <?php

        return;

        ?>

        <div class="wrap">

            <?php if (!$remove_page_title) : ?>
                <h1><?php echo esc_html($post->post_title); ?></h1>
            <?php else : ?>
                <h1 style="display: none;"></h1>
            <?php endif; ?>

            <?php if (jltwp_adminify()->can_use_premium_code__premium_only()) :
                if ('html' === $post->content_type) {
                    echo $post->html_content;
                } else {
                    echo apply_filters('the_content', $post->post_content);
                }
            endif; ?>

        </div>

<?php

    }
}
