<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

class Module_Disable_Comments extends AdminSettingsModel
{
    public function __construct()
    {
        $this->disable_comments_settings();
    }

    public function get_defaults()
    {
        return [
            'disable_comments_post_types'           => ['page'],
            'disable_comments_menu_redirect'        => false,
            'disable_comments_media'                => false,
            'disable_comments_dashboard_widget'     => false,
            'disable_comments_admin_menu'           => false,
            'disable_comments_discussion_menu'      => false,
            'disable_comments_close_front'          => false,
            'disable_comments_hide_existing'        => false,
            'disable_comments_admin_bar'            => false,
            'disable_comments_url_field'            => false,
            'disable_comments_replace_comment_link' => false,
            'disable_comments_replace_author_link'  => false,
        ];
    }


    /**
     * Option Settings
     */
    public function disable_comments_default_settings(&$fields)
    {
        $fields[] = array(
            'type'    => 'subheading',
            'content'   => Utils::adminfiy_help_urls(
                __('Disable Comments Settings', 'adminify'),
                'https://wpadminify.com/kb/disable-comments-in-wordpress/',
                'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
                'https://www.facebook.com/groups/jeweltheme',
                'https://wpadminify.com/support/disable-comments/'
            )
        );

        $fields[] = array(
            'id'      => 'disable_comments_post_types',
            'type'    => 'checkbox',
            'title'   => __('Disable Comments for', 'adminify'),
            'label'   => __('Select Post Types where you want to Disable Comments', 'adminify'),
            'options' => 'post_types',
            'default' => $this->get_default_field('disable_comments_post_types'),
        );

        if (!jltwp_adminify()->can_use_premium_code__premium_only()) {
            $fields[] = array(
                'type'       => 'notice',
                'style'      => 'warning',
                'content'    => Utils::adminify_upgrade_pro(),
                'dependency' => array(
                    array('disable_comments_post_types', 'not-any', 'post,page'),
                    array('disable_comments_post_types', '!=', ''),
                ),
            );
        }

        $fields[] = array(
            'id'         => 'disable_comments_menu_redirect',
            'type'       => 'switcher',
            'title'      => __('"Comments" Menu Redirect to Admin?', 'adminify'),
            'subtitle'   => __('Admin Menu "Comments" redirect to Admin', 'adminify'),
            'text_on'    => 'Yes',
            'text_off'   => 'No',
            'text_width' => 70,
            'default'    => $this->get_default_field('disable_comments_menu_redirect'),

        );

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $fields[] = array(
                'id'         => 'disable_comments_media',
                'type'       => 'switcher',
                'title'      => __('Remove Comments for Attachments?', 'adminify'),
                'subtitle'   => __('Remove Comments for Attachments File', 'adminify'),
                'text_on'    => 'Yes',
                'text_off'   => 'No',
                'text_width' => 70,
                'default'    => $this->get_default_field('disable_comments_media'),
            );
        } else {
            $fields[] = array(
                'type'     => 'notice',
                'title'    => __('Remove Comments for Attachments?', 'adminify'),
                'subtitle' => __('Remove Comments for Attachments File', 'adminify'),
                'style'    => 'warning',
                'content'  => Utils::adminify_upgrade_pro()
            );
        }

        $fields[] = array(
            'id'         => 'disable_comments_dashboard_widget',
            'type'       => 'switcher',
            'title'      => __('Remove Dashboard Comments Widget?', 'adminify'),
            'subtitle'   => __('Do you want to Remove Dashboard <a href="https://wpadminify.com/kb/disable-comments-in-wordpress/" target="_blank">Comments Widget </a>', 'adminify'),
            'text_on'    => 'Yes',
            'text_off'   => 'No',
            'text_width' => 70,
            'default'    => $this->get_default_field('disable_comments_dashboard_widget'),
        );

        $fields[] = array(
            'id'         => 'disable_comments_admin_menu',
            'type'       => 'switcher',
            'title'      => __('Remove Admin Menu "Comments"', 'adminify'),
            'subtitle'   => __('Remove Comments Menu from Admin Menu', 'adminify'),
            'text_on'    => 'Yes',
            'text_off'   => 'No',
            'text_width' => 70,
            'default'    => $this->get_default_field('disable_comments_admin_menu'),
        );

        $fields[] = array(
            'id'         => 'disable_comments_discussion_menu',
            'type'       => 'switcher',
            'title'      => __('Remove Submenu "Discussion"', 'adminify'),
            'subtitle'   => __('Remove Discussion Menu from "Settings>Discussion" Sub Menu', 'adminify'),
            'text_on'    => 'Yes',
            'text_off'   => 'No',
            'text_width' => 70,
            'default'    => $this->get_default_field('disable_comments_discussion_menu'),
        );

        $fields[] = array(
            'id'         => 'disable_comments_close_front',
            'type'       => 'switcher',
            'title'      => __('Close Comments Front-end', 'adminify'),
            'subtitle'   => __('Close Comments from front-end', 'adminify'),
            'text_on'    => 'Yes',
            'text_off'   => 'No',
            'text_width' => 70,
            'default'    => $this->get_default_field('disable_comments_close_front'),
        );


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $fields[] = array(
                'id'         => 'disable_comments_hide_existing',
                'type'       => 'switcher',
                'title'      => __('Hide Existing Comments', 'adminify'),
                'subtitle'   => __('Hide Existing Comments from front-end', 'adminify'),
                'text_on'    => 'Yes',
                'text_off'   => 'No',
                'text_width' => 70,
                'default'    => $this->get_default_field('disable_comments_hide_existing'),
            );
        } else {
            $fields[] = array(
                'type'     => 'notice',
                'title'    => __('Hide Existing Comments', 'adminify'),
                'subtitle' => __('Hide Existing Comments from front-end', 'adminify'),
                'style'    => 'warning',
                'content'  => Utils::adminify_upgrade_pro()
            );
        }



        $fields[] = array(
            'id'         => 'disable_comments_admin_bar',
            'type'       => 'switcher',
            'title'      => __('Remove Comments Admin Bar', 'adminify'),
            'subtitle'   => __('Remove Comments from Admin Bar', 'adminify'),
            'text_on'    => 'Yes',
            'text_off'   => 'No',
            'text_width' => 70,
            'default'    => $this->get_default_field('disable_comments_admin_bar'),
        );

        $fields[] = array(
            'id'         => 'disable_comments_url_field',
            'type'       => 'switcher',
            'title'      => __('Remove Comment Form URL Field?', 'adminify'),
            'subtitle'   => __('Remove URL Field from Comment Form', 'adminify'),
            'text_on'    => 'Yes',
            'text_off'   => 'No',
            'text_width' => 70,
            'default'    => $this->get_default_field('disable_comments_url_field'),
        );


        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $fields[] = array(
                'id'         => 'disable_comments_replace_comment_link',
                'type'       => 'switcher',
                'title'      => __('Replace Comment Links to JavaScript?', 'adminify'),
                'subtitle'   => 'Replace external links in comments to JavaScript form to avoid',
                'help'       => __('Superfluous external links from comments, which can be typed from a dozen and more for one article, do not bring anything good for promotion.', 'adminify') . '<br><br><b>Clearfy: </b>' . sprintf(__('Replaces the links of this kind of %s, on links of this kind %s', 'adminify'), '<code>a href="http://yourdomain.com" rel="nofollow"</code>', '<code>span data-uri="http://yourdomain.com"</code>'),
                'text_on'    => 'Yes',
                'text_off'   => 'No',
                'text_width' => 70,
                'default'    => $this->get_default_field('disable_comments_replace_comment_link'),
            );
        } else {
            $fields[] = array(
                'type'     => 'notice',
                'title'    => __('Replace Comment Links to JavaScript?', 'adminify'),
                'subtitle' => 'Replace external links in comments to JavaScript form to avoid',
                'help'     => __('Superfluous external links from comments, which can be typed from a dozen and more for one article, do not bring anything good for promotion.', 'adminify') . '<br><br><b>Clearfy: </b>' . sprintf(__('Replaces the links of this kind of %s, on links of this kind %s', 'adminify'), '<code>a href="http://yourdomain.com" rel="nofollow"</code>', '<code>span data-uri="http://yourdomain.com"</code>'),
                'style'    => 'warning',
                'content'  => Utils::adminify_upgrade_pro()
            );
        }

        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            $fields[] = array(
                'id'         => 'disable_comments_replace_author_link',
                'type'       => 'switcher',
                'title'      => __('Replace Author Links to JavaScript?', 'adminify'),
                'subtitle'   => __('Replace external links in comments to JavaScript form to avoid', 'adminify'),
                'help'       => __('Up to 90 percent of comments in the blog can be left for the sake of an external link. Even nofollow from page weight loss here does not help.', 'adminify') . '<br><br><b>Clearfy: </b>' . __('Replaces the links of the authors of comments on the JavaScript code, it is impossible to distinguish it from usual links.', 'adminify') . '<br>--<br><i>' . __('In some Wordpress topics this may not work.', 'adminify') . '</i>',
                'text_on'    => 'Yes',
                'text_off'   => 'No',
                'text_width' => 70,
                'default'    => $this->get_default_field('disable_comments_replace_author_link'),
            );
        } else {
            $fields[] = array(
                'type'     => 'notice',
                'title'    => __('Replace Author Links to JavaScript?', 'adminify'),
                'subtitle' => __('Replace external links in comments to JavaScript form to avoid', 'adminify'),
                'help'     => __('Up to 90 percent of comments in the blog can be left for the sake of an external link. Even nofollow from page weight loss here does not help.', 'adminify') . '<br><br><b>Clearfy: </b>' . __('Replaces the links of the authors of comments on the JavaScript code, it is impossible to distinguish it from usual links.', 'adminify') . '<br>--<br><i>' . __('In some Wordpress topics this may not work.', 'adminify') . '</i>',
                'style'    => 'warning',
                'content'  => Utils::adminify_upgrade_pro()
            );
        }
    }

    public function disable_comments_settings()
    {
        if (!class_exists('ADMINIFY')) {
            return;
        }

        $fields = [];
        $this->disable_comments_default_settings($fields);

        \ADMINIFY::createSection($this->prefix, array(
            'title'  => __('Disable Comments', 'adminify'),
            'parent' => 'module_settings',
            'id'     => 'disable_comments',
            'icon'   => 'fas fa-comment-slash',
            'class'  => 'wp-adminify-two-columns aminify-title-width-65',
            'fields' => $fields
        ));
    }
}
