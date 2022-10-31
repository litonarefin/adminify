<?php

namespace WPAdminify\Inc\Classes;

use  WPAdminify\Inc\Classes\MenuStyles\VerticalMainMenu ;
use  WPAdminify\Pro\Classes\HorizontalMenu ;
// no direct access allowed
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class MenuStyle
{
    public function __construct( $options )
    {
        $layout_type = ( !empty($options['menu_layout_settings']['layout_type']) ? $options['menu_layout_settings']['layout_type'] : 'vertical' );
        new VerticalMainMenu();
    }

}