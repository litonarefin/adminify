<?php

namespace WPAdminify\Inc\Modules\DashboardWidget;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Classes\Multisite_Helper;
use WPAdminify\Inc\Modules\DashboardWidget\DashboardWidgetModel;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WPAdminify
 * @package Module: Dashboard Widget
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class DashboardWidget extends DashboardWidgetModel
{
    public $url;
    public $roles;
    public $options;
    public $current_role;

    public function __construct()
    {
        $this->options = (new DashboardWidget_Setttings())->get();
        $this->url     = WP_ADMINIFY_URL . 'Inc/Modules/DashboardWidget';

        if (is_admin()) {
            add_action('admin_enqueue_scripts', [$this, 'jltwp_adminify_enqueue_scripts']);
            add_action('wp_dashboard_setup', [$this, 'create_dashboard_widgets'], 999);
            add_action('wp_loaded',[$this,'override_elementor_shortcodes']);

            //Welcome Panel Initialize
            add_action('admin_init', [$this, 'jltwp_adminify_welcome_init']);
        }
    }
    /**
     * Override elementor-template shortcode
     */
    public function override_elementor_shortcodes()
    {

        if( is_admin() && shortcode_exists( 'elementor-template' ) ){
            add_shortcode('elementor-template', [$this,'override_elementor_template']);
        }
    }

    public function override_elementor_template( $atts )
    {
        extract(shortcode_atts(array(
            'id' => ''
        ), $atts));

        $elementor = \Elementor\Plugin::$instance;
        $output = '';
        $output .= $elementor->frontend->register_styles();
        $output .= $elementor->frontend->enqueue_styles();

        $output .= $elementor->frontend->get_builder_content($id, true);

        $output .= $elementor->frontend->register_scripts();
        $output .= $elementor->frontend->enqueue_scripts();

        return $output;
    }

    /**
     * Welcome Panel Initialize
     */
    public function jltwp_adminify_welcome_init()
    {

        if (empty($this->options['dashboard_widget_types'])) return;

        $option = !empty($this->options['dashboard_widget_types']['welcome_dash_widget']) ? $this->options['dashboard_widget_types']['welcome_dash_widget'] : '';

        if (!empty($option['enable_custom_welcome_dash_widget'])) {
            if (!empty($option['widget_template_type'])) {

                // Restricted for User Roles
                $restricted_for_dash_widget = !empty($option['user_roles']) ? $option['user_roles'] : '';
                if (!Utils::restricted_for($restricted_for_dash_widget)) {
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
        remove_action('welcome_panel', 'wp_welcome_panel');
        add_action('welcome_panel', [$this, 'render_welcome_panel']);

        // custom fallback for the users who don't have
        // enough capabilities to display welcome panel.
        if (
            !current_user_can('edit_theme_options')
        ) {
            add_action('admin_notices', [$this, 'render_welcome_panel']);
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
            <?php if (!current_user_can('edit_theme_options')) { ?>
                <a class="welcome-panel-close" href="<?php echo admin_url('welcome=0'); ?>"><?php _e('Dismiss'); ?></a>
            <?php } ?>

            <?php $this->render_welcome_template(); ?>
        </div>

        <?php if (!current_user_can('edit_theme_options')) { ?>
            <script type="text/javascript">
                ;
                (function($) {
                    $(document).ready(function() {
                        $('<div id="adminify-welcome-panel" class="adminify-welcome-panel"></div>').insertBefore('#dashboard-widgets-wrap').append($('.adminify-panel-content'));
                    });
                })(jQuery);
            </script>
        <?php } ?>
<?php
    }

    public function render_welcome_template()
    {

        $option = isset($this->options['dashboard_widget_types']['welcome_dash_widget']) ? $this->options['dashboard_widget_types']['welcome_dash_widget'] : '';

        if (isset($option['widget_template_type']) && !empty($option['widget_template_type'])) {

            $from_multisite = false;
            $ms_helper   = new Multisite_Helper();
            $switch_blog = $from_multisite && $ms_helper->needs_to_switch_blog() ? true : false;

            if (is_plugin_active('elementor/elementor.php')) {
                $elementor = \Elementor\Plugin::$instance;
            }

            echo '<style>';
            $css = '';

            if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                $dismissible = isset($option['dismissible']) ? true : false;
                if ($dismissible) {
                    $css .= '.adminify-welcome-panel .welcome-panel-close { display: none; }';
                }
            }

            // $css .= '.welcome-panel-content{max-width:95%;}';
            $css = str_replace(array("\r\n", "\n", "\r\t", "\t", "\r"), '', $css);
            $css = preg_replace('/\s+/', ' ', $css);

            echo $css;
            echo '</style>';

            if ($switch_blog) {
                global $blueprint;
                switch_to_blog($blueprint);
            }

            switch ($option['widget_template_type']) {
                case 'specific_page':
                    $page_id = $option['custom_page'];
                    if ($page_id) {
                        $page = get_page($page_id);
                        $content = apply_filters('the_content', $page->post_content);
                        $content = str_replace(']]>', ']]&gt;', $content);
                        echo $content;
                    }
                    break;

                case 'elementor_template':
                    if (is_plugin_active('elementor/elementor.php')) {
                        $template_id = $option['elementor_template_id'];
                        if ($template_id) {
                            $elementor->frontend->register_styles();
                            $elementor->frontend->enqueue_styles();

                            echo $elementor->frontend->get_builder_content($template_id, true);

                            $elementor->frontend->register_scripts();
                            $elementor->frontend->enqueue_scripts();
                        }
                    }
                    break;

                case 'elementor_section':
                    if (is_plugin_active('elementor/elementor.php')) {
                        $template_id = $option['elementor_section_id'];
                        if ($template_id) {
                            $elementor->frontend->register_styles();
                            $elementor->frontend->enqueue_styles();

                            echo $elementor->frontend->get_builder_content($template_id, true);

                            $elementor->frontend->register_scripts();
                            $elementor->frontend->enqueue_scripts();
                        }
                    }
                    break;

                case 'elementor_widget':
                    if (is_plugin_active('elementor/elementor.php')) {
                        $template_id = $option['elementor_widget_id'];
                        if ($template_id) {
                            $elementor->frontend->register_styles();
                            $elementor->frontend->enqueue_styles();

                            echo $elementor->frontend->get_builder_content($template_id, true);

                            $elementor->frontend->register_scripts();
                            $elementor->frontend->enqueue_scripts();
                        }
                    }
                    break;

                case 'oxygen_template':
                    if (is_plugin_active('oxygen/functions.php')) {
                        $template_id = $option['oxygen_template_id'];
                        if ($template_id) {
                            echo do_shortcode(get_post_meta($template_id, 'ct_builder_shortcodes', true));
                        }
                    }
                    break;
            }

            if ($switch_blog) {
                restore_current_blog();
            }
        }
    }

    // Add Custom Dashboard Widgets
    public function create_dashboard_widgets()
    {
        $options = $this->options;

        $options = !empty($this->options['dashboard_widget_types']['dashboard_widgets']) ? $this->options['dashboard_widget_types']['dashboard_widgets'] : '';
        if (empty($options)) {
            return;
        }


        $before_content = '';
        $after_content  = '';
        $dash_widget_data = array();

        foreach ($options as $value) {
            if (is_array($value) && !empty($value)) {

                // Restricted for User Roles
                $restricted_for_dash_widget = !empty($value['user_roles']) ? $value['user_roles'] : '';

                if (!Utils::restricted_for($restricted_for_dash_widget)) {
                    return;
                }

                $dash_widget_title    = isset($value['title']) ? $value['title'] : "";
                $dash_widget_position = isset($value['widget_pos']) ? $value['widget_pos'] : "normal";

                add_meta_box(
                    'adminify_widget_' . Utils::jltwp_adminify_class_cleanup($dash_widget_title),
                    $dash_widget_title,
                    [$this, 'render_dashboard_widget'],
                    'dashboard',
                    $dash_widget_position,
                    'high',
                    $value
                );
            }
        }
    }


    // Render Dashboard Widget
    public function render_dashboard_widget($content = '', $value = '')
    {
        switch ($value['args']['widget_type']) {

            case 'editor':
                echo $value['args']['dashw_type_editor'];
                break;

            case 'icon':
                if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                    if (!empty($value['args']['dashw_type_icon'])) {
                        echo '<div class="adminify-dash-icon">
                        <div class="icon">
                            <i class="' . $value['args']['dashw_type_icon'] . '"></i>
                        </div>
                        <div>
                        <a href="' . $value['args']['dashw_type_icon_link']['url'] . '" target="' . $value['args']['dashw_type_icon_link']['target'] . '">
                        ' . $value['args']['dashw_type_icon_tooltip'] . '</a></div>
                    </div>';
                    }
                }
                break;

            case 'video':
                if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                    $video_type = $value['args']['dashw_video']['dashw_type_video_type'];
                    $video_title = isset($value['args']['dashw_video']['dashw_type_video_title']) ? $value['args']['dashw_video']['dashw_type_video_title'] : '';
                    if ($video_type === 'self_hosted') {
                        echo '<video width="640" height="280" src="' . $value['args']['dashw_video']['dashw_type_video_type_self_hosted']['url'] . '" controls>
                        Sorry, your browser doesn\'t support HTML5 <code>video</code>, but you can download this video from the
                        <a href="https://archive.org/details/Popeye_forPresident" target="_blank">Internet Archive</a>. </video>';
                    } elseif ($video_type === 'youtube') {
                        echo '<iframe width="420" height="280" src="' . $value['args']['dashw_video']['dashw_type_video_type_youtube'] . '?controls=0&autoplay=1"></iframe>';
                    } elseif ($video_type === 'vimeo') {
                        echo '<iframe src="https://player.vimeo.com/video/' . $value['args']['dashw_video']['dashw_type_video_type_vimeo'] . '?title=0&byline=0&portrait=0" width="640" height="280" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
                    }
                }
                break;

            case 'shortcode':
                if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                    echo do_shortcode($value['args']['dashw_type_shortcode']);
                }
                break;

            case 'rss_feed':
                if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                    // Render RSS Widget Content
                    echo '<div class="wp-adminify-rss-widget">';
                    wp_widget_rss_output($value['args']['dashw_type_rss_feed'], array(
                        'items'        => isset($value['args']['dashw_type_rss_count']) ? $value['args']['dashw_type_rss_count'] : 5,
                        'show_summary' => isset($value['args']['dashw_type_rss_excerpt']) ? $value['args']['dashw_type_rss_excerpt'] : 1,
                        'show_author'  => isset($value['args']['dashw_type_rss_author']) ? $value['args']['dashw_type_rss_author'] : 1,
                        'show_date'    => isset($value['args']['dashw_type_rss_date']) ? $value['args']['dashw_type_rss_date'] : 1
                    ));
                    echo "</div>";
                }
                break;

            case 'script':
                if (jltwp_adminify()->can_use_premium_code__premium_only()) {
                    if(!empty($value['args']['dashw_type_script'])){
                        $stat_tag     = "/<script>/m";
                        $end_tag      = "#</script>#m";
                        $result_start = preg_match($stat_tag, $value['args']['dashw_type_script']);
                        $result_end   = preg_match($end_tag, $value['args']['dashw_type_script']);
                        echo "\n<!-- Start of WP Adminify - Dashboard Widget Custom CSS -->\n";
                        echo (!$result_start && !$result_end) ? '<script>' : '';
                        echo "\n{$value['args']['dashw_type_script']}\n";
                        echo (!$result_start && !$result_end) ? '</script>' : '';
                        echo "\n<!-- /End of WP Adminify - Dashboard Widget Custom CSS -->\n";
                    }
                }
                break;
        }
    }




    /**
     * Scripst / Styles
     */
    public function jltwp_adminify_enqueue_scripts()
    {
        global $pagenow;

        // Load Scripts/Styles only WP Adminify Dashboard Widget
        if (('admin.php' === $pagenow) && ('adminify-dashboard-widgets' === $_GET['page'])) {
            $this->dashboard_widgets_admin_script();
        }
    }


    // WP Adminify Dashboard Widgets Style
    public function dashboard_widgets_admin_script()
    {
        echo '<style>.wp-adminify-dashboard-widgets .adminify-container{ max-width:60%; margin:0 auto;} .wp-adminify-dashboard-widgets .adminify-header-inner{padding:0;}.wp-adminify-dashboard-widgets .adminify-field-subheading{font-size:20px; padding-left:0;}.adminify-dashboard-widgets .adminify-nav,.adminify-dashboard-widgets .adminify-search,.adminify-dashboard-widgets .adminify-footer,.adminify-dashboard-widgets .adminify-reset-all,.adminify-dashboard-widgets .adminify-expand-all,.adminify-dashboard-widgets .adminify-header-left,.adminify-dashboard-widgets .adminify-reset-section,.adminify-dashboard-widgets .adminify-nav-background{display: none !important;}.adminify-dashboard-widgets .adminify-nav-normal + .adminify-content{margin-left: 0;}
        /*
        .wp-adminify #wpbody-content .adminify-section[data-section-id] .adminify-data-wrapper .adminify-cloneable-item .adminify-cloneable-title{ border:none !important; }
*/
        /* If needed for white top-bar */
        .adminify-dashboard-widgets .adminify-header-inner {
            background-color: #fafafa !important;
            border-bottom: 1px solid #f5f5f5;
        }
        </style>';
    }
}
