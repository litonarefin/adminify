<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Classes\Adminify_Rollback;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

class RollbackVersion
{
    private $prefix;
    public function __construct()
    {

        if (is_multisite() && !is_network_admin()) return; // only display to network admin if multisite is enbaled

        $this->prefix = '_adminify_rollback';
        $this->jltwp_adminify_rollback_options();

        add_action('admin_enqueue_scripts', [$this, 'jltwp_adminify_rollback_enqueue_scripts']);
    }

    public function get_defaults()
    {
        return [
            'adminify_rollback'   => ''
        ];
    }

    /**
     * Scripts/Styles
     */
    public function jltwp_adminify_rollback_enqueue_scripts()
    {
        global $pagenow;

        // Load Scripts/Styles only WP Adminify Custom CSS/JS Page
        if (('admin.php' === $pagenow) && ('adminify-rollback-version' === $_GET['page'])) {
            $this->version_rollback_admin_script();
        }
    }


    public function version_rollback_admin_script()
    {
        echo '<style>.adminify-rollback-version .adminify-container{ max-width:60%; margin:0 auto;} .adminify-rollback-version .adminify-header{display:none ;}
        .adminify-rollback-version .adminify-header-inner{padding:0;}.adminify-rollback-version .adminify-field-subheading{font-size:20px; padding-left:0;} .adminify-rollback-version .adminify-nav,.adminify-rollback-version .adminify-search,.adminify-rollback-version .adminify-footer,.adminify-rollback-version .adminify-reset-all,.adminify-rollback-version .adminify-expand-all,.adminify-rollback-version .adminify-header-left,.adminify-rollback-version .adminify-reset-section,.adminify-rollback-version .adminify-nav-background{display: none !important;}.adminify-rollback-version .adminify-nav-normal + .adminify-content{margin-left: 0;}
            /* If needed for white top-bar */
            .adminify-rollback-version .adminify-header-inner {
                background-color: #fafafa !important;
                border-bottom: 1px solid #f5f5f5;
            }
            .adminify-rollback-version .adminify-field-callback a.dashicons{ width: inherit; }
        </style>';
    }


    public static function jltwp_adminify_rollback_contents()
    { ?>

        <div class="border border-muted">

            <h3><?php echo __('Rollback Version', 'adminify'); ?></h3>


            <?php
            $rollback_html = '<select class="wp-adminify-rollback-select">';
            $ger_versions = Adminify_Rollback::get_instance();

            foreach ($ger_versions->get_rollback_versions() as $version) {
                $rollback_html .= "<option value='{$version}'>$version</option>";
            }
            $rollback_html .= '</select>';
            echo $rollback_html;

            echo sprintf('<a data-placeholder-text="' . esc_html__('Reinstall', WP_ADMINIFY_VER) . ' v{VERSION}" href="#" data-placeholder-url="%s" class="button button-primary wp-adminify-btn wp-adminify-rollback-button dashicons dashicons-update-alt ml-2">%s</a>', wp_nonce_url(admin_url('admin-post.php?action=wp_adminify_rollback_version&version=VERSION'), 'wp_adminify_rollback_version'), __('Reinstall', WP_ADMINIFY_VER));
            ?>
            <p class="wp-adminify-roll-desc pt-2 has-text-danger">
                <?php echo __('Warning: Please backup your database before making the rollback.', 'adminify'); ?>
            </p>
        </div>


        <div class="wp-adminify--popup-area is-flex is-align-items-center is-justify-content-center">
            <div class="wp-adminify--popup-container has-text-centered">
                <div class="wp-adminify--popup-container_inner pt-6 pb-6">
                    <div class="wp-adminify-popup-header">
                        <?php echo __('Rollback to Previous Version', 'adminify'); ?>
                    </div>
                    <div class="wp-adminify-dialog-message wp-adminify-dialog-confirm-message slow">
                        <?php echo __('Are you sure you want to reinstall previous version?', 'adminify'); ?>
                    </div>
                    <div class="wp-adminify-dialog-buttons-wrapper wp-adminify-dialog-confirm-buttons-wrapper mt-5">
                        <button class="wp-adminify-dialog-button button-secondary wp-adminify-dialog-cancel wp-adminify-dialog-confirm-cancel">
                            <?php echo __('Cancel', 'adminify'); ?>
                        </button>
                        <button class="wp-adminify-dialog-button button-primary wp-adminify-dialog-ok wp-adminify-dialog-confirm-ok">
                            <?php echo __('Continue', 'adminify'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>




<?php }


    public function jltwp_adminify_rollback_fields(&$fields)
    {
        $fields[] = array(
            'type'    => 'subheading',
            'content'   => Utils::adminfiy_help_urls(
                __('Rollback to Previous Version', 'adminify'),
                'https://wpadminify.com/kb/version-rollback/',
                'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
                'https://www.facebook.com/groups/jeweltheme',
                'https://wpadminify.com/support/'
            )
        );

        $fields[] = array(
            'type'    => 'submessage',
            'style'   => 'info',
            'content' => sprintf(__('<strong>Experiencing an issue with %1$s <em>v%2$s</em>? Rollback to a previous version before the issue appeared.</strong>', 'adminify'), WP_ADMINIFY, WP_ADMINIFY_VER),
        );

        $fields[] = array(
            'id'         => 'adminify_rollback',
            'type'       => 'callback',
            'function' => '\WPAdminify\Inc\Admin\Options\RollbackVersion::jltwp_adminify_rollback_contents',
        );
    }

    public function jltwp_adminify_rollback_options()
    {
        if (!class_exists('ADMINIFY')) {
            return;
        }

        // WP Adminify Custom Header & Footer Options
        \ADMINIFY::createOptions($this->prefix, array(

            // Framework Title
            'framework_title' => 'Rollback Version <small>for WP Adminify</small>',
            'framework_class' => 'adminify-rollback-version',

            // menu settings
            'menu_title'      => 'Rollback Version',
            'menu_slug'       => 'adminify-rollback-version',
            'menu_type'       => 'submenu',                  // menu, submenu, options, theme, etc.
            'menu_capability' => 'manage_options',
            'menu_icon'       => '',
            'menu_position'   => 54,
            'menu_hidden'     => false,
            'menu_parent'     => 'wp-adminify-settings',

            // footer
            'footer_text'   => ' ',
            'footer_after'  => ' ',
            'footer_credit' => ' ',

            // menu extras
            'show_bar_menu'      => false,
            'show_sub_menu'      => false,
            'show_in_network'    => true,
            'show_in_customizer' => false,

            'show_search'        => false,
            'show_reset_all'     => false,
            'show_reset_section' => false,
            'show_header'        => false,
            'show_footer'        => false,
            'show_all_options'   => false,
            'show_form_warning'  => false,
            'sticky_header'      => false,
            'save_defaults'      => false,
            'ajax_save'          => false,

            // admin bar menu settings
            'admin_bar_menu_icon'     => '',
            'admin_bar_menu_priority' => 45,


            // database model
            'database'       => 'network',   // options, transient, theme_mod, network(multisite support)
            'transient_time' => 0,


            // typography options
            'enqueue_webfont' => false,
            'async_webfont'   => false,

            // others
            'output_css' => false,

            // theme and wrapper classname
            'nav'   => 'normal',
            'theme' => 'dark',
            'class' => 'wp-adminify-rollback',
        ));



        $fields = [];
        $this->jltwp_adminify_rollback_fields($fields);


        // Rollback Section
        \ADMINIFY::createSection($this->prefix, array(
            'title'  => __('Rollback Version', 'adminify'),
            'icon'   => 'fas fa-layer-group',
            'fields' => $fields
        ));
    }
}
