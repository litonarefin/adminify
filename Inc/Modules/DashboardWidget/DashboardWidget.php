<?php

namespace WPAdminify\Inc\Modules\DashboardWidget;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Classes\Multisite_Helper ;
use  WPAdminify\Inc\Modules\DashboardWidget\DashboardWidgetModel ;
// no direct access allowed
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * WPAdminify
 *
 * @package Module: Dashboard Widget
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */
class DashboardWidget extends DashboardWidgetModel
{
    public  $url ;
    public  $roles ;
    public  $options ;
    public  $current_role ;
    public function __construct()
    {
        $this->options = ( new DashboardWidget_Setttings() )->get();
        $this->url = WP_ADMINIFY_URL . 'Inc/Modules/DashboardWidget';
        
        if ( is_admin() ) {
            add_action( 'admin_enqueue_scripts', array( $this, 'jltwp_adminify_enqueue_scripts' ) );
            add_action( 'wp_dashboard_setup', array( $this, 'create_dashboard_widgets' ), 999 );
            add_action( 'wp_loaded', array( $this, 'override_elementor_shortcodes' ) );
            // Welcome Panel Initialize
            add_action( 'admin_init', array( $this, 'jltwp_adminify_welcome_init' ) );
        }
    
    }
    
    /**
     * Override elementor-template shortcode
     */
    public function override_elementor_shortcodes()
    {
        if ( is_admin() && shortcode_exists( 'elementor-template' ) ) {
            add_shortcode( 'elementor-template', array( $this, 'override_elementor_template' ) );
        }
    }
    
    public function override_elementor_template( $atts )
    {
        extract( shortcode_atts( array(
            'id' => '',
        ), $atts ) );
        $elementor = \Elementor\Plugin::$instance;
        $output = '';
        $output .= $elementor->frontend->register_styles();
        $output .= $elementor->frontend->enqueue_styles();
        $output .= $elementor->frontend->get_builder_content( $id, true );
        $output .= $elementor->frontend->register_scripts();
        $output .= $elementor->frontend->enqueue_scripts();
        return $output;
    }
    
    /**
     * Welcome Panel Initialize
     */
    public function jltwp_adminify_welcome_init()
    {
        if ( empty($this->options['dashboard_widget_types']) ) {
            return;
        }
        $option = ( !empty($this->options['dashboard_widget_types']['welcome_dash_widget']) ? $this->options['dashboard_widget_types']['welcome_dash_widget'] : '' );
        if ( !empty($option['enable_custom_welcome_dash_widget']) ) {
            
            if ( !empty($option['widget_template_type']) ) {
                // Restricted for User Roles
                $restricted_for_dash_widget = ( !empty($option['user_roles']) ? $option['user_roles'] : '' );
                if ( !Utils::restricted_for( $restricted_for_dash_widget ) ) {
                    return;
                }
                $this->render_welcome_panel_output();
            }
        
        }
    }
    
    /**
     * Render Welcome Panel Content
     *
     * @return void
     */
    public function render_welcome_panel_output()
    {
        remove_action( 'welcome_panel', 'wp_welcome_panel' );
        add_action( 'welcome_panel', array( $this, 'render_welcome_panel' ) );
        // custom fallback for the users who don't have
        // enough capabilities to display welcome panel.
        if ( !current_user_can( 'edit_theme_options' ) ) {
            add_action( 'admin_notices', array( $this, 'render_welcome_panel' ) );
        }
    }
    
    /**
     * Render Welcome Panel
     *
     * @return void
     */
    public function render_welcome_panel()
    {
        ?>
		<div class="welcome-panel-content adminify-panel-content">
			<?php 
        
        if ( !current_user_can( 'edit_theme_options' ) ) {
            ?>
				<a class="welcome-panel-close" href="<?php 
            echo  admin_url( 'welcome=0' ) ;
            ?>"><?php 
            _e( 'Dismiss' );
            ?></a>
			<?php 
        }
        
        ?>

			<?php 
        $this->render_welcome_template();
        ?>
		</div>

		<?php 
        if ( !current_user_can( 'edit_theme_options' ) ) {
            ?>
			<script type="text/javascript">
				;
				(function($) {
					$(document).ready(function() {
						$('<div id="adminify-welcome-panel" class="adminify-welcome-panel"></div>').insertBefore('#dashboard-widgets-wrap').append($('.adminify-panel-content'));
					});
				})(jQuery);
			</script>
		<?php 
        }
        ?>
		<?php 
    }
    
    public function render_welcome_template()
    {
        $option = ( isset( $this->options['dashboard_widget_types']['welcome_dash_widget'] ) ? $this->options['dashboard_widget_types']['welcome_dash_widget'] : '' );
        
        if ( isset( $option['widget_template_type'] ) && !empty($option['widget_template_type']) ) {
            $from_multisite = false;
            $ms_helper = new Multisite_Helper();
            $switch_blog = ( $from_multisite && $ms_helper->needs_to_switch_blog() ? true : false );
            if ( is_plugin_active( 'elementor/elementor.php' ) ) {
                $elementor = \Elementor\Plugin::$instance;
            }
            echo  '<style>' ;
            $css = '';
            // $css .= '.welcome-panel-content{max-width:95%;}';
            $css = str_replace( array(
                "\r\n",
                "\n",
                "\r\t",
                "\t",
                "\r"
            ), '', $css );
            $css = preg_replace( '/\\s+/', ' ', $css );
            echo  Utils::wp_kses_custom( $css ) ;
            echo  '</style>' ;
            
            if ( $switch_blog ) {
                global  $blueprint ;
                switch_to_blog( $blueprint );
            }
            
            switch ( $option['widget_template_type'] ) {
                case 'specific_page':
                    $page_id = $option['custom_page'];
                    
                    if ( $page_id ) {
                        $page = get_page( $page_id );
                        $content = apply_filters( 'the_content', $page->post_content );
                        $content = str_replace( ']]>', ']]&gt;', $content );
                        echo  wp_kses_post( $content ) ;
                    }
                    
                    break;
                case 'elementor_template':
                    
                    if ( is_plugin_active( 'elementor/elementor.php' ) ) {
                        $template_id = $option['elementor_template_id'];
                        
                        if ( $template_id ) {
                            $elementor->frontend->register_styles();
                            $elementor->frontend->enqueue_styles();
                            echo  wp_kses_post( $elementor->frontend->get_builder_content( $template_id, true ) ) ;
                            $elementor->frontend->register_scripts();
                            $elementor->frontend->enqueue_scripts();
                        }
                    
                    }
                    
                    break;
                case 'elementor_section':
                    
                    if ( is_plugin_active( 'elementor/elementor.php' ) ) {
                        $template_id = $option['elementor_section_id'];
                        
                        if ( $template_id ) {
                            $elementor->frontend->register_styles();
                            $elementor->frontend->enqueue_styles();
                            echo  wp_kses_post( $elementor->frontend->get_builder_content( $template_id, true ) ) ;
                            $elementor->frontend->register_scripts();
                            $elementor->frontend->enqueue_scripts();
                        }
                    
                    }
                    
                    break;
                case 'elementor_widget':
                    
                    if ( is_plugin_active( 'elementor/elementor.php' ) ) {
                        $template_id = $option['elementor_widget_id'];
                        
                        if ( $template_id ) {
                            $elementor->frontend->register_styles();
                            $elementor->frontend->enqueue_styles();
                            echo  wp_kses_post( $elementor->frontend->get_builder_content( $template_id, true ) ) ;
                            $elementor->frontend->register_scripts();
                            $elementor->frontend->enqueue_scripts();
                        }
                    
                    }
                    
                    break;
                case 'oxygen_template':
                    
                    if ( is_plugin_active( 'oxygen/functions.php' ) ) {
                        $template_id = $option['oxygen_template_id'];
                        if ( $template_id ) {
                            echo  do_shortcode( get_post_meta( $template_id, 'ct_builder_shortcodes', true ) ) ;
                        }
                    }
                    
                    break;
            }
            if ( $switch_blog ) {
                restore_current_blog();
            }
        }
    
    }
    
    // Add Custom Dashboard Widgets
    public function create_dashboard_widgets()
    {
        $options = $this->options;
        $options = ( !empty($this->options['dashboard_widget_types']['dashboard_widgets']) ? $this->options['dashboard_widget_types']['dashboard_widgets'] : '' );
        if ( empty($options) ) {
            return;
        }
        $before_content = '';
        $after_content = '';
        $dash_widget_data = array();
        foreach ( $options as $value ) {
            
            if ( is_array( $value ) && !empty($value) ) {
                // Restricted for User Roles
                $restricted_for_dash_widget = ( !empty($value['user_roles']) ? $value['user_roles'] : '' );
                if ( !Utils::restricted_for( $restricted_for_dash_widget ) ) {
                    return;
                }
                $dash_widget_title = ( isset( $value['title'] ) ? $value['title'] : '' );
                $dash_widget_position = ( isset( $value['widget_pos'] ) ? $value['widget_pos'] : 'normal' );
                add_meta_box(
                    'adminify_widget_' . Utils::jltwp_adminify_class_cleanup( $dash_widget_title ),
                    $dash_widget_title,
                    array( $this, 'render_dashboard_widget' ),
                    'dashboard',
                    $dash_widget_position,
                    'high',
                    $value
                );
            }
        
        }
    }
    
    // Render Dashboard Widget
    public function render_dashboard_widget( $content = '', $value = '' )
    {
        switch ( $value['args']['widget_type'] ) {
            case 'editor':
                echo  wp_kses_post( $value['args']['dashw_type_editor'] ) ;
                break;
            case 'icon':
                break;
            case 'video':
                break;
            case 'shortcode':
                break;
            case 'rss_feed':
                break;
            case 'script':
                break;
        }
    }
    
    /**
     * Scripst / Styles
     */
    public function jltwp_adminify_enqueue_scripts()
    {
        global  $pagenow ;
        // Load Scripts/Styles only WP Adminify Dashboard Widget
        if ( 'admin.php' === $pagenow && 'adminify-dashboard-widgets' === $_GET['page'] ) {
            $this->dashboard_widgets_admin_script();
        }
    }
    
    // WP Adminify Dashboard Widgets Style
    public function dashboard_widgets_admin_script()
    {
        echo  '<style>.wp-adminify-dashboard-widgets .adminify-container{ max-width:60%; margin:0 auto;} .wp-adminify-dashboard-widgets .adminify-header-inner{padding:0;}.wp-adminify-dashboard-widgets .adminify-field-subheading{font-size:20px; padding-left:0;}.adminify-dashboard-widgets .adminify-nav,.adminify-dashboard-widgets .adminify-search,.adminify-dashboard-widgets .adminify-footer,.adminify-dashboard-widgets .adminify-reset-all,.adminify-dashboard-widgets .adminify-expand-all,.adminify-dashboard-widgets .adminify-header-left,.adminify-dashboard-widgets .adminify-reset-section,.adminify-dashboard-widgets .adminify-nav-background{display: none !important;}.adminify-dashboard-widgets .adminify-nav-normal + .adminify-content{margin-left: 0;}
        /*
        .wp-adminify #wpbody-content .adminify-section[data-section-id] .adminify-data-wrapper .adminify-cloneable-item .adminify-cloneable-title{ border:none !important; }
*/
        /* If needed for white top-bar */
        .adminify-dashboard-widgets .adminify-header-inner {
            background-color: #fafafa !important;
            border-bottom: 1px solid #f5f5f5;
        }
        </style>' ;
    }

}