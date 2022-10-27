<?php

namespace WPAdminify\Inc\Classes;

use WPAdminify\Inc\Classes\MenuStyles\VerticalMainMenu;
use WPAdminify\Pro\Classes\HorizontalMenu;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

class MenuStyle
{
    public function __construct($options)
    {
        $layout_type = (!empty($options['menu_layout_settings']['layout_type'])) ? $options['menu_layout_settings']['layout_type'] : 'vertical';
        if (jltwp_adminify()->can_use_premium_code__premium_only()) {
            if ($layout_type  == "vertical") {
                new VerticalMainMenu();
            } elseif ($layout_type == "horizontal") {
                new HorizontalMenu();
            }
        } else {
            new VerticalMainMenu();
        }
    }
}
