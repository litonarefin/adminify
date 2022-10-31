<?php

namespace WPAdminify\Inc\Modules\NotificationBar\Inc\Settings;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Modules\NotificationBar\Inc\Notification_Customize ;
if ( !defined( 'ABSPATH' ) ) {
    die;
}
// Cannot access directly.
class Content extends Notification_Customize
{
    public function __construct()
    {
        $this->content_notif_bar_customizer();
    }
    
    public function get_defaults()
    {
        return [
            'notif_bar_content_section' => [
            'notif_bar_content'             => 'This is your default message which you can use to announce a sale or discount.',
            'show_notif_bar_btn'            => false,
            'notif_btn'                     => 'Learn More',
            'notif_btn_url'                 => [
            'url'    => 'https://wpadminify.com/',
            'text'   => __( 'WP Adminify', 'adminify' ),
            'target' => '_blank',
        ],
            'mobile_show_notif_bar_content' => false,
            'mobile_notif_bar_content'      => __( 'This is your default message which you can use to announce a sale or discount.', 'adminify' ),
            'mobile_show_notif_bar_btn'     => false,
            'mobile_notif_btn'              => '',
            'mobile_notif_btn_url'          => '',
            'mobile_show_btn_close'         => true,
        ],
            'typography_sets'           => [
            'color'       => '#fff',
            'font-family' => 'inherit',
            'font-size'   => '12',
            'unit'        => 'px',
            'type'        => 'google',
        ],
        ];
    }
    
    /**
     * Notification Bar: Content Section
     */
    public function content_notif_bar_settings( &$content_notif_settings )
    {
        $desktop_fields = [];
        $this->notif_bar_desktop_fields( $desktop_fields );
        // $mobile_fields = [];
        // $this->notif_bar_mobile_fields($mobile_fields);
        $content_notif_settings[] = [
            'id'   => 'notif_bar_content_section',
            'type' => 'tabbed',
            'tabs' => [ [
            'title'  => __( 'Content', 'adminify' ),
            'fields' => $desktop_fields,
        ] ],
        ];
        $content_notif_settings[] = [
            'type'    => 'notice',
            'title'   => __( 'Font Settings', 'adminify' ),
            'style'   => 'warning',
            'content' => Utils::adminify_upgrade_pro(),
        ];
    }
    
    public function notif_bar_desktop_fields( &$desktop_fields )
    {
        $desktop_fields[] = [
            'id'      => 'notif_bar_content',
            'type'    => 'textarea',
            'title'   => __( 'Content', 'adminify' ),
            'help'    => __( 'Notification Bar contents here', 'adminify' ),
            'default' => $this->get_default_field( 'notif_bar_content_section' )['notif_bar_content'],
        ];
        $desktop_fields[] = [
            'id'       => 'show_notif_bar_btn',
            'type'     => 'switcher',
            'title'    => __( 'Show "Learn More" Button?', 'adminify' ),
            'text_on'  => 'Yes',
            'text_off' => 'No',
            'class'    => 'wp-adminify-cs',
            'default'  => $this->get_default_field( 'notif_bar_content_section' )['show_notif_bar_btn'],
        ];
        $desktop_fields[] = [
            'id'         => 'notif_btn',
            'type'       => 'text',
            'title'      => __( 'Button Text', 'adminify' ),
            'default'    => $this->get_default_field( 'notif_bar_content_section' )['notif_btn'],
            'dependency' => [
            'show_notif_bar_btn',
            '==',
            'true',
            true
        ],
        ];
        $desktop_fields[] = [
            'id'         => 'notif_btn_url',
            'type'       => 'link',
            'title'      => __( 'Button URL', 'adminify' ),
            'default'    => $this->get_default_field( 'notif_bar_content_section' )['notif_btn_url'],
            'add_title'  => __( 'Button Link', 'adminify' ),
            'dependency' => [
            'show_notif_bar_btn',
            '==',
            'true',
            true
        ],
        ];
    }
    
    public function notif_bar_mobile_fields( &$mobile_fields )
    {
        $mobile_fields[] = [
            'id'       => 'mobile_show_notif_bar_content',
            'type'     => 'switcher',
            'title'    => __( 'Show Different Content on Mobile?', 'adminify' ),
            'text_on'  => 'Yes',
            'text_off' => 'No',
            'class'    => 'wp-adminify-cs',
            'default'  => $this->get_default_field( 'notif_bar_content_section' )['mobile_show_notif_bar_content'],
        ];
        $mobile_fields[] = [
            'id'         => 'mobile_notif_bar_content',
            'type'       => 'textarea',
            'title'      => __( 'Content', 'adminify' ),
            'help'       => __( 'Notification Bar contents here', 'adminify' ),
            'default'    => $this->get_default_field( 'notif_bar_content_section' )['mobile_notif_bar_content'],
            'dependency' => [
            'mobile_show_notif_bar_content',
            '==',
            'true',
            true
        ],
        ];
        $mobile_fields[] = [
            'id'         => 'mobile_show_notif_bar_btn',
            'type'       => 'switcher',
            'title'      => __( 'Show Button?', 'adminify' ),
            'text_on'    => 'Yes',
            'text_off'   => 'No',
            'class'      => 'wp-adminify-cs',
            'default'    => $this->get_default_field( 'notif_bar_content_section' )['mobile_show_notif_bar_btn'],
            'dependency' => [
            'mobile_show_notif_bar_content',
            '==',
            'true',
            true
        ],
        ];
        $mobile_fields[] = [
            'id'         => 'mobile_notif_btn',
            'type'       => 'text',
            'title'      => __( 'Button Text', 'adminify' ),
            'default'    => $this->get_default_field( 'notif_bar_content_section' )['mobile_notif_btn'],
            'dependency' => [
            'mobile_show_notif_bar_btn|mobile_show_notif_bar_content',
            '==|==',
            'true|true',
            true
        ],
        ];
        $mobile_fields[] = [
            'id'         => 'mobile_notif_btn_url',
            'type'       => 'link',
            'title'      => __( 'Button URL', 'adminify' ),
            'default'    => $this->get_default_field( 'notif_bar_content_section' )['mobile_notif_btn_url'],
            'dependency' => [
            'mobile_show_notif_bar_btn|mobile_show_notif_bar_content',
            '==|==',
            'true|true',
            true
        ],
        ];
        $mobile_fields[] = [
            'id'       => 'mobile_show_btn_close',
            'type'     => 'switcher',
            'title'    => __( 'Show Close Button?', 'adminify' ),
            'text_on'  => 'Yes',
            'text_off' => 'No',
            'class'    => 'wp-adminify-cs',
            'default'  => $this->get_default_field( 'notif_bar_content_section' )['mobile_show_btn_close'],
        ];
    }
    
    /**
     * Notification bar: Content
     *
     * @return void
     */
    public function content_notif_bar_customizer()
    {
        $content_notif_settings = [];
        $this->content_notif_bar_settings( $content_notif_settings );
        /**
         * Section: Content Settings
         */
        \ADMINIFY::createSection( $this->prefix, [
            'assign' => 'content_section',
            'title'  => __( 'Content Section', 'adminify' ),
            'fields' => $content_notif_settings,
        ] );
    }

}