<?php

namespace WPAdminify\Inc\Modules\PostTypesOrder;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WP Adminify
 * @package WP Adminify: Post Types Order
 *
 * @author WP Adminify <support@wpadminify.com>
 */


class PostTypesOrderWalker extends \Walker
{

    var $db_fields = array(
        'parent' => 'post_parent',
        'id' => 'ID'
    );


    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class='children'>\n";
    }


    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }


    function start_el(&$output, $page, $depth = 0, $args = array(), $id = 0)
    {
        if ($depth)
            $indent = str_repeat("\t", $depth);
        else
            $indent = '';

        extract($args, EXTR_SKIP);

        $item_details   =   apply_filters('the_title', $page->post_title, $page->ID);

        $item_details   =   apply_filters('adminify_pto/pto_media_item_data', $item_details, $page);

        $output .= $indent . '<li id="item_' . $page->ID . '"><span>' . $item_details . '</span>';
    }


    function end_el(&$output, $page, $depth = 0, $args = array())
    {
        $output .= "</li>\n";
    }
}
