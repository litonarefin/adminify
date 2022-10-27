<?php

namespace WPAdminify\Inc\Classes\Wizard;

use \WPAdminify\Inc\Admin\AdminSettings;
use WPAdminify\Inc\Utils;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

class Adminify_Setup_Wizard
{
    private $step   = '';
    private $steps  = array();

    public function __construct()
    {
        if (current_user_can('manage_options') && current_user_can('administrator')) {
            $this->options = (array) AdminSettings::get_instance()->get();
            $this->jltwp_adminify_setup_wizard();
            add_action('wp_ajax_wpadminify_save_wizard_data', [$this, 'wpadminify_save_wizard_data']);
        }
    }

    public function validate_before_save($settings)
    {
        // Customize
        $settings['admin_bar_mode'] = wp_validate_boolean($settings['admin_bar_mode']) ? '' : 'dark';

        // Admin Bar
        if (empty($settings['admin_bar_settings']['admin_bar_position'])) $settings['admin_bar_settings']['admin_bar_position'] = 'top';

        foreach ($settings as $key => $setting) {
            $settings[$key] = $this->maybe_convert_to_boolean($setting);
        }

        return $settings;
    }

    public function maybe_convert_to_boolean(&$setting)
    {
        if (gettype($setting) == 'string' && ($setting === 'true' || $setting === 'false')) {
            $setting = wp_validate_boolean($setting);
        } else if (gettype($setting) == 'array') {
            foreach ($setting as $key => $_setting) {
                $setting[$key] = $this->maybe_convert_to_boolean($_setting);
            }
        }
        return $setting;
    }

    /**
     * Recursive sanitation for an array
     * This will use later with time
     */
    function array_recursive_sanitize_text_field($array) {
        foreach ( $array as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = recursive_sanitize_text_field($value);
            }
            else {
                $value = sanitize_text_field( $value );
            }
        }

        return $array;
    }

    public function wpadminify_save_wizard_data()
    {

        check_ajax_referer('jltwp_adminify_sw');

        $this->setup_steps();

        if (!empty($_POST['active_step'])) $this->step = sanitize_text_field($_POST['active_step']);

        $settings = empty($_POST['settings']) ? [] : (array) $_POST['settings'];

        $settings = $this->validate_before_save($settings);

        update_option('_wpadminify', $settings);

        wp_send_json_success([
            'redirect' => $this->get_next_step_link()
        ]);
    }

    public function load_scripts()
    {

        // Register
        // wp_register_script('wp-adminify-vue-manifest', WP_ADMINIFY_ASSETS . 'admin/js/manifest.js', [], WP_ADMINIFY_VER, true);
        // wp_register_script('wp-adminify-vue-vendors', WP_ADMINIFY_ASSETS . 'admin/js/vendor' . Utils::assets_ext('.js'), ['wp-adminify-vue-manifest'], WP_ADMINIFY_VER, true);
        wp_register_style('wp-adminify-sw-setup', WP_ADMINIFY_ASSETS . 'css/setup.css', array('dashicons', 'install'));
        wp_register_script('wp-adminify-sw-setup', WP_ADMINIFY_ASSETS . 'admin/js/wp-adminify--setup-wizard' . Utils::assets_ext('.js'), ['jquery', 'wp-adminify-vue-vendors'], WP_ADMINIFY_VER, true);

        // Media Uploader
        wp_enqueue_media();

        // Load
        wp_enqueue_style('wp-adminify-sw-setup');
        wp_enqueue_script('wp-adminify-sw-setup');

        // Localize Script
        $adminify_data = [
            "settings" => $this->get_validated_settings(),
            "wpnonce" => wp_create_nonce('jltwp_adminify_sw')
        ];

        wp_localize_script('wp-adminify-sw-setup', 'adminify_setup_wizard_data', $adminify_data);
    }

    public function get_validated_settings()
    {
        // Module
        $boolean_settings = ['admin_ui', 'folders', 'login_customizer', 'admin_columns', 'menu_editor', 'dashboard_widgets', 'pagespeed_insights', 'custom_css_js', 'quick_menu', 'menu_duplicator', 'notification_bar', 'activity_logs', 'post_duplicator', 'admin_pages', 'sidebar_generator', 'post_types_order', 'server_info', 'disable_comments'];
        foreach ($boolean_settings as $b_setting) $this->options[$b_setting] = wp_validate_boolean($this->options[$b_setting]);

        // Customize
        $this->options['admin_bar_mode'] = $this->options['admin_bar_mode'] == 'light';

        // Admin Bar
        $admin_bar_settings = ['admin_bar_menu', 'admin_bar_search', 'admin_bar_comments', 'admin_bar_view_website', 'admin_bar_dark_light_btn'];
        foreach ($admin_bar_settings as $admin_bar_setting) {
            if (isset($this->options['admin_bar_settings'][$admin_bar_setting])) $this->options['admin_bar_settings'][$admin_bar_setting] = wp_validate_boolean($this->options['admin_bar_settings'][$admin_bar_setting]);
        }
        if (empty($this->options['admin_bar_settings']['admin_bar_position'])) $this->options['admin_bar_settings']['admin_bar_position'] = 'top';

        // Tweaks
        $tweaks = ['generator_wp_version', 'remove_version_strings', 'remove_dashicons', 'remove_shortlink', 'remove_canonical', 'remove_emoji', 'disable_xmlrpc', 'remove_feed', 'remove_pingback', 'remove_powered', 'gravatar_query_strings'];
        foreach ($tweaks as $tweak) $this->options[$tweak] = wp_validate_boolean($this->options[$tweak]);

        $admin_notices = ['hide_notices', 'remove_welcome_panel', 'remove_php_update_required_nag', 'remove_try_gutenberg_panel', 'core_update_notice', 'plugin_update_notice', 'theme_update_notice'];
        foreach ($admin_notices as $admin_notice) $this->options[$admin_notice] = wp_validate_boolean($this->options[$admin_notice]);

        return $this->options;
    }

    public function setup_steps()
    {

        $this->steps = array(
            'intro' => [
                'name'    =>  esc_html__('Introduction', 'adminify'),
                'view'    => [$this, 'jltwp_adminify_step_introduction']
            ],
            'module' => [
                'name'    =>  esc_html__('Module', 'adminify'),
                'view'    => [$this, 'setup_step_modules']
            ],
            'customize' => [
                'name'    =>  esc_html__('Customize', 'adminify'),
                'view'    => [$this, 'setup_step_customize']
            ],
            'menu' => [
                'name'    =>  esc_html__('Menu', 'adminify'),
                'view'    => [$this, 'setup_step_menu']
            ],
            'admin_bar' => [
                'name'    =>  esc_html__('Admin Bar', 'adminify'),
                'view'    => [$this, 'setup_step_admin_bar']
            ],
            'tweaks' => [
                'name'    =>  esc_html__('Tweaks', 'adminify'),
                'view'    => [$this, 'setup_step_tweaks']
            ],
            'admin_notices' => array(
                'name'    =>  esc_html__('Admin Notices', 'adminify'),
                'view'    => array($this, 'setup_step_admin_notices')
            ),
            'next_steps' => array(
                'name'    =>  esc_html__('Ready!', 'adminify'),
                'view'    => array($this, 'setup_step_ready')
            )
        );

        $this->step = isset($_GET['step']) ? sanitize_key($_GET['step']) : current(array_keys($this->steps));
    }

    public function jltwp_adminify_setup_wizard()
    {
        if (empty($_GET['page']) || 'wp-adminify-setup-wizard' !== $_GET['page']) return;

        $this->setup_steps();
        $this->load_scripts();

        $this->setup_wizard_header();
        $this->setup_wizard_steps();
        $this->setup_wizard_content();
        $this->setup_wizard_footer();

        exit;
    }

    function jltwp_adminify_get_content_info(&$site_title, &$tagline, &$admin_email, &$defa_cat, &$set_permalink, &$users_can_register, &$wpsw_date_format, &$wpsw_time_format)
    {
        $site_title = get_bloginfo('name');
        $tagline = get_bloginfo('description');
        $admin_email = get_bloginfo('admin_email');
        $default_category = get_option('default_category');
        $defa_cat = get_cat_name($default_category);
        $set_permalink = get_option('permalink_structure');
        $users_can_register = get_option('users_can_register');
        $wpsw_date_format = get_option('date_format');
        $wpsw_time_format = get_option('time_format');
    }

    public function get_wizard_url()
    {
        return admin_url('index.php?page=wp-adminify-setup-wizard');
    }

    public function get_next_step_link()
    {
        $keys = array_keys($this->steps);
        return add_query_arg('step', $keys[array_search($this->step, array_keys($this->steps)) + 1], $this->get_wizard_url());
    }

    public function get_prev_step_link()
    {
        $keys = array_keys($this->steps);
        return add_query_arg('step', $keys[array_search($this->step, array_keys($this->steps)) - 1], $this->get_wizard_url());
    }

    public function setup_wizard_header()
    {

        header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
        if (!defined('WP_ADMIN')) {
            require_once ABSPATH . 'wp-admin/admin.php';
        }

        global $title, $hook_suffix, $current_screen, $wp_locale, $pagenow, $update_title, $total_update_count, $parent_file;

        if (empty($current_screen)) {
            set_current_screen();
        }

        get_admin_page_title();
        $title = strip_tags($title);

        if (is_network_admin()) {
            $admin_title = sprintf(__('Network Admin: %s'), get_network()->site_name);
        } elseif (is_user_admin()) {
            $admin_title = sprintf(__('User Dashboard: %s'), get_network()->site_name);
        } else {
            $admin_title = get_bloginfo('name');
        }

        if ($admin_title === $title) {
            $admin_title = sprintf(__('%s &#8212; WordPress'), $title);
        } else {
            $admin_title = sprintf(__('%1$s &lsaquo; %2$s &#8212; WordPress'), $title, $admin_title);
        }

        if (wp_is_recovery_mode()) {
            $admin_title = sprintf(__('Recovery Mode &#8212; %s'), $admin_title);
        }

        $admin_title = apply_filters('admin_title', $admin_title, $title);

        wp_user_settings();

        _wp_admin_html_begin();

?>

        <title><?php echo esc_html($admin_title); ?></title>

        <?php

        $admin_body_class = preg_replace('/[^a-z0-9_-]+/i', '-', $hook_suffix);

        ?>

        <script type="text/javascript">
            addLoadEvent = function(func) {
                if (typeof jQuery !== 'undefined') jQuery(document).ready(func);
                else if (typeof wpOnload !== 'function') {
                    wpOnload = func;
                } else {
                    var oldonload = wpOnload;
                    wpOnload = function() {
                        oldonload();
                        func();
                    }
                }
            };
            var ajaxurl = '<?php echo esc_js(admin_url('admin-ajax.php', 'relative')); ?>',
                pagenow = '<?php echo esc_js($current_screen->id); ?>',
                typenow = '<?php echo esc_js($current_screen->post_type); ?>',
                adminpage = '<?php echo esc_js($admin_body_class); ?>',
                thousandsSeparator = '<?php echo esc_js($wp_locale->number_format['thousands_sep']); ?>',
                decimalPoint = '<?php echo esc_js($wp_locale->number_format['decimal_point']); ?>',
                isRtl = <?php echo (int) is_rtl(); ?>;
        </script>

        <?php

        do_action('admin_enqueue_scripts', $hook_suffix);
        do_action("admin_print_styles-{$hook_suffix}");
        do_action('admin_print_styles');
        do_action("admin_print_scripts-{$hook_suffix}");
        do_action('admin_print_scripts');
        do_action("admin_head-{$hook_suffix}");

        ?>

        <style>
            body.wp-adminify-sw-setup .wp-adminify-loader,
            body.wp-adminify-sw-setup #wp-adminify--circle--menu {
                display: none !important;
            }
        </style>

        </head>

        <body class="wp-adminify-sw-setup wp-core-ui">

            <script type="text/javascript">
                document.body.className = document.body.className.replace('no-js', 'js');
            </script>

            <h1 class="wp-adminify-sw-logo">
                <a target="_blank" href="https://wpadminify.com/">
                    <img src="<?php echo WP_ADMINIFY_ASSETS_IMAGE . 'logos/logo-text-light.svg'; ?>" alt="WP Adminify Logo" height="80" width="200">
                </a>
            </h1>

            <?php

        }

        public function setup_wizard_footer()
        {

            global $hook_suffix;

            do_action('admin_footer', '');
            do_action("admin_print_footer_scripts-{$hook_suffix}");
            do_action('admin_print_footer_scripts');
            do_action("admin_footer-{$hook_suffix}");

            if ('next_steps' === $this->step) : ?>
                <a class="wp-adminify-sw-return-to-dashboard" href="<?php echo esc_url(admin_url() . '?adminify_setup_done_config=1'); ?>">
                    <?php esc_html_e('Return to the WordPress Dashboard', 'adminify'); ?>
                </a>
            <?php endif; ?>

        </body>

        </html>
    <?php
        }

        public function item_class($step_key)
        {
            if ($step_key === $this->step) return 'active';
            if (array_search($this->step, array_keys($this->steps)) > array_search($step_key, array_keys($this->steps))) return 'done';
            return '';
        }

        public function setup_wizard_steps()
        {
            $output_steps = $this->steps;
            array_shift($output_steps);
    ?>
        <ol class="wp-adminify-sw-setup-steps">
            <?php foreach ($output_steps as $step_key => $step) : ?>
                <li class="<?php echo $this->item_class($step_key); ?>">
                    <a href="<?php echo esc_url(admin_url('index.php?page=wp-adminify-setup-wizard&step=' . $step_key)); ?>"><?php echo esc_html($step['name']); ?></a>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php
        }

        public function setup_wizard_content()
        {
            echo '<div id="wp-adminify--setup-wizard" class="wp-adminify-sw-setup-content">';
            call_user_func($this->steps[$this->step]['view']);
            echo '</div>';
        }

        // Buttons
        public function next_step_buttons($first = false)
        {
    ?>
        <p class="wp-adminify-sw-setup-actions step">
            <input type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e('Continue', 'adminify'); ?>" />
            <a href="<?php echo esc_url($this->get_next_step_link()); ?>" class="button button-large button-next"><?php esc_html_e('Skip this step', 'adminify'); ?></a>
            <?php
            if ($first == false) {
                echo '<a href="' . esc_url($this->get_prev_step_link()) . '" class="button button-large button-next">' . esc_html__('Back', 'adminify') . '</a>';
            } else {
                echo '<a href="' . esc_url(admin_url('admin.php?page=wp-adminify-settings&adminify_setup_done_config=1')) . '" class="button button-large button-next">' . esc_html__('Abort', 'adminify') . '</a>';
            }
            ?>
        </p>
    <?php
        }

        // Step: Introduction
        public function jltwp_adminify_step_introduction()
        {
    ?>
        <h1><?php esc_html_e('Welcome to the future of configuring WordPress!', 'adminify'); ?></h1>
        <p>
            <?php
            $intro_content = sprintf(
                __('Thank you for choosing <a href="%1$s" target="_blank>%2$s</a>. An easier way to set up and manage your WordPress website! This quick setup wizard will help you configure the basic settings for your site. It’s completely optional and shouldn’t take longer than five minutes.', 'adminify'),
                esc_url('https://wpadminify.com'),
                __('WP Adminify', 'adminify')
            );
            echo wp_kses_post($intro_content); ?>
        </p>
        <p>
            <?php esc_html_e('Need help with configuring WP Adminify? Check this tutorial on: ', 'adminify'); ?>
            <a href="https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8" target="_blank">
                <?php esc_html_e('Youtube', 'adminify'); ?>
            </a>
        </p>
        <p>
            <?php esc_html_e('No time right now? If you don’t want to go through the wizard, you can skip and return to the plugin\'s dashboard. Come back anytime if you change your mind!', 'adminify'); ?>
        </p>
        <p class="wp-adminify-sw-setup-actions step">
            <a href="<?php echo esc_url($this->get_next_step_link()); ?>" class="button-primary button button-large button-next">
                <?php esc_html_e('Let\'s Go!', 'adminify'); ?>
            </a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=wp-adminify-settings')); ?>" class="button button-large">
                <?php esc_html_e('Not right now', 'adminify'); ?>
            </a>
        </p>
    <?php
        }

        // Step: Module Settings
        public function setup_step_modules()
        {
    ?>
        <h1><?php esc_html_e('Module Settings', 'adminify'); ?></h1>
        <form method="post" @submit.prevent="handleSubmit">

            <table class="form-table">

                <tr>
                    <th scope="row">
                        <label for="admin_ui">
                            <?php esc_html_e('Dashboard Design UI', 'adminify'); ?>
                        </label>
                    </th>

                    <td class="updated">
                        <input type="checkbox" name="admin_ui" id="admin_ui" class="switch-input" v-model="settings.admin_ui" />
                        <label for="admin_ui" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('WP Adminify', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('WordPress Default', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Select which design you want - WordPress UI / Adminify UI', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="folders"><?php esc_html_e('Folders', 'adminify'); ?></label>
                    </th>

                    <td class="updated">
                        <input type="checkbox" name="folders" id="folders" class="switch-input" v-model="settings.folders">
                        <label for="folders" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Folders Module for Post/Page/Media', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="login_customizer"><?php esc_html_e('Login Customizer', 'adminify'); ?></label>
                    </th>

                    <td class="updated">
                        <input type="checkbox" name="login_customizer" id="login_customizer" class="switch-input" v-model="settings.login_customizer">
                        <label for="login_customizer" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Login Customizer Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="admin_columns"><?php esc_html_e('Admin Columns', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="admin_columns" id="admin_columns" class="switch-input" v-model="settings.admin_columns">
                        <label for="admin_columns" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Admin Columns Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="menu_editor"><?php esc_html_e('Menu Editor', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="menu_editor" id="menu_editor" class="switch-input" v-model="settings.menu_editor">
                        <label for="menu_editor" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Menu Editor Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="dashboard_widgets"><?php esc_html_e('Dashboard & Welcome Widget', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="dashboard_widgets" id="dashboard_widgets" class="switch-input" v-model="settings.dashboard_widgets">
                        <label for="dashboard_widgets" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Dashboard & Welcome Widget Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="pagespeed_insights"><?php esc_html_e('Pagespeed Insights', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="pagespeed_insights" id="pagespeed_insights" class="switch-input" v-model="settings.pagespeed_insights">
                        <label for="pagespeed_insights" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Pagespeed Insights Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="custom_css_js"><?php esc_html_e('Header/Footer Scripts', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="custom_css_js" id="custom_css_js" class="switch-input" v-model="settings.custom_css_js">
                        <label for="custom_css_js" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Header/Footer Scripts Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="quick_menu"><?php esc_html_e('Quick Menu', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="quick_menu" id="quick_menu" class="switch-input" v-model="settings.quick_menu">
                        <label for="quick_menu" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Quick Menu Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="menu_duplicator"><?php esc_html_e('Menu Duplicator', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="menu_duplicator" id="menu_duplicator" class="switch-input" v-model="settings.menu_duplicator">
                        <label for="menu_duplicator" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Menu Duplicator Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="notification_bar"><?php esc_html_e('Notification Bar', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="notification_bar" id="notification_bar" class="switch-input" v-model="settings.notification_bar">
                        <label for="notification_bar" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Notification Bar Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="activity_logs"><?php esc_html_e('Activity Logs', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="activity_logs" id="activity_logs" class="switch-input" v-model="settings.activity_logs">
                        <label for="activity_logs" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Activity Logs Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="post_duplicator"><?php esc_html_e('Post Duplicator', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="post_duplicator" id="post_duplicator" class="switch-input" v-model="settings.post_duplicator">
                        <label for="post_duplicator" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Post Duplicator Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="admin_pages"><?php esc_html_e('Admin Pages', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="admin_pages" id="admin_pages" class="switch-input" v-model="settings.admin_pages">
                        <label for="admin_pages" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Admin Pages Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="sidebar_generator"><?php esc_html_e('Sidebar Generator', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="sidebar_generator" id="sidebar_generator" class="switch-input" v-model="settings.sidebar_generator">
                        <label for="sidebar_generator" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Sidebar Generator Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="post_types_order"><?php esc_html_e('Post Types Order', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="post_types_order" id="post_types_order" class="switch-input" v-model="settings.post_types_order">
                        <label for="post_types_order" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Post Types Order Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="server_info"><?php esc_html_e('Server Info', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="server_info" id="server_info" class="switch-input" v-model="settings.server_info">
                        <label for="server_info" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Server Info Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="disable_comments"><?php esc_html_e('Disable Comments', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="disable_comments" id="disable_comments" class="switch-input" v-model="settings.disable_comments">
                        <label for="disable_comments" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Enable', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Disable', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Enable/Disable Disable Comments Module', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

            </table>

            <?php $this->next_step_buttons(true); ?>
        </form>
        <span><?php esc_html_e('For more settings, check the WP Adminify\'s ', 'adminify');
                echo '"<a href="' . esc_url(admin_url('admin.php?page=wp-adminify-settings#tab=modules')) . '" target="_blank">';
                esc_html_e('Module Settings', 'adminify');
                echo '</a>".'; ?></span>
        <br /><br />
    <?php
        }

        // Customize Step
        public function setup_step_customize()
        {
    ?>
        <h1><?php esc_html_e('Design Settings', 'adminify'); ?></h1>

        <form method="post" @submit.prevent="handleSubmit">

            <table class="form-table">
                <tr>
                    <th scope="row"><label for="admin_bar_mode">
                            <?php esc_html_e('Color Mode', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="admin_bar_mode" id="admin_bar_mode" class="switch-input" v-model="settings.admin_bar_mode">
                        <label for="admin_bar_mode" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Light', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Dark', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('You can choose Light/Dark Mode', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr class="admin_bar_logo_type">
                    <th scope="row">
                        <label for="admin_bar_logo_type"><?php esc_html_e('Logo Type', 'adminify'); ?></label>
                    </th>
                    <td>
                        <select id="admin_bar_logo_type" name="admin_bar_logo_type" v-model="settings.admin_bar_logo_type">
                            <option value="image_logo"><?php esc_html_e('Image', 'adminify'); ?></option>
                            <option value="text_logo"><?php esc_html_e('Text', 'adminify'); ?></option>
                        </select>
                        <span class="description">
                            <?php esc_html_e('Select Admin Logo Type.', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr class="admin_bar_light_logo" v-if="settings.admin_bar_mode && settings.admin_bar_logo_type == 'image_logo'">
                    <!-- If color mode is light -->
                    <th scope="row">
                        <label for="admin_bar_light_logo"><?php esc_html_e('Light Logo', 'adminify'); ?></label>
                    </th>
                    <td>
                        <div>
                            <input type="text" name="admin_bar_light_logo" class="adminify--url" readonly="readonly" placeholder="Not selected" v-model="settings.admin_bar_light_mode.admin_bar_light_logo.url">
                            <a href="#" class="button button-primary adminify--button" @click.prevent="handle_media( settings.admin_bar_light_mode.admin_bar_light_logo )">
                                <?php esc_html_e('Add Light Logo', 'adminify'); ?>
                            </a>
                        </div>
                        <span class="description">
                            <?php esc_html_e('Set Logo Image for Light Mode.', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr v-if="settings.admin_bar_mode && settings.admin_bar_logo_type == 'text_logo'">
                    <!-- If color mode is light -->
                    <th scope="row">
                        <label for="admin_bar_light_logo_text"><?php esc_html_e('Logo Text', 'adminify'); ?></label>
                    </th>
                    <td>
                        <div>
                            <input type="text" placeholder="<?php esc_html_e('Logo Text', 'adminify'); ?>" name="admin_bar_light_logo_text" v-model="settings.admin_bar_light_mode.admin_bar_light_logo_text" id="admin_bar_light_logo_text" class="wp-adminify-sw-date-field">
                        </div>
                        <span class="description">
                            <?php esc_html_e('Light Logo Text', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr class="admin_bar_dark_logo" v-if="!settings.admin_bar_mode && settings.admin_bar_logo_type == 'image_logo'">
                    <!-- If color mode is dark -->
                    <th scope="row">
                        <label for="admin_bar_dark_logo"><?php esc_html_e('Dark Logo', 'adminify'); ?></label>
                    </th>
                    <td>
                        <div>
                            <input type="text" name="admin_bar_dark_logo" class="adminify--url" readonly="readonly" placeholder="Not selected" v-model="settings.admin_bar_dark_mode.admin_bar_dark_logo.url">
                            <a href="#" class="button button-primary adminify--button" @click.prevent="handle_media( settings.admin_bar_dark_mode.admin_bar_dark_logo )">
                                <?php esc_html_e('Add Dark Logo', 'adminify'); ?>
                            </a>
                        </div>
                        <span class="description">
                            <?php esc_html_e('Set Logo Image for Dark Mode', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr v-if="!settings.admin_bar_mode && settings.admin_bar_logo_type == 'text_logo'">
                    <!-- If color mode is dark -->
                    <th scope="row">
                        <label for="admin_bar_dark_logo_text"><?php esc_html_e('Logo Text', 'adminify'); ?></label>
                    </th>
                    <td>
                        <div>
                            <input type="text" placeholder="<?php esc_html_e('Logo Text', 'adminify'); ?>" name="admin_bar_dark_logo_text" value="<?php echo (!empty($this->options['admin_bar_dark_mode']['admin_bar_dark_logo_text'])) ? $this->options['admin_bar_dark_mode']['admin_bar_dark_logo_text'] : ""; ?>" id="admin_bar_dark_logo_text" class="wp-adminify-sw-text-field">
                        </div>
                        <span class="description">
                            <?php esc_html_e('Light Logo Text', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr class="footer_text">
                    <th scope="row">
                        <label for="footer_text"><?php esc_html_e('Admin Footer Text', 'adminify'); ?></label>
                    </th>
                    <td>
                        <div>
                            <textarea name="footer_text" id="footer_text" cols="30" rows="4" v-model="settings.footer_text"></textarea>
                        </div>
                        <span class="description">
                            <?php esc_html_e('Set the Admin Footer Text.', 'adminify'); ?>
                        </span>
                    </td>
                </tr>
            </table>

            <?php $this->next_step_buttons(); ?>
        </form>
        <span>
            <?php esc_html_e('For more settings, check the plugin\'s ', 'adminify');
            echo '"<a href="' . esc_url(admin_url('admin.php?page=wp-adminify-settings#tab=dark-light-mode')) . '" target="_blank">';
            esc_html_e('Customize Settings', 'adminify');
            echo '</a>".';
            ?>
        </span>
        <br /><br />
    <?php
        }

        // Step: Menu Settings
        public function setup_step_menu()
        {

    ?>

        <h1><?php esc_html_e('Menu Settings', 'adminify'); ?></h1>

        <form method="post" @submit.prevent="handleSubmit">

            <table class="form-table">

                <tr class="layout_type">
                    <th scope="row">
                        <label for="layout_type"><?php esc_html_e('Menu Type', 'adminify'); ?></label>
                    </th>
                    <td>
                        <select id="layout_type" name="layout_type" v-model="settings.menu_layout_settings.layout_type">
                            <option value="vertical"><?php esc_html_e('Vertical Menu', 'adminify'); ?></option>
                            <?php if (jltwp_adminify()->can_use_premium_code__premium_only()) { ?>
                                <option value="horizontal"><?php esc_html_e('Horizontal Menu', 'adminify'); ?></option>
                            <?php } else { ?>
                                <option value="pro_menu_type"><?php esc_html_e('Horizontal Menu(Pro)', 'adminify'); ?></option>
                            <?php } ?>
                        </select>
                        <span class="description">
                            <?php esc_html_e('Select Menu Layout Type.', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <!-- Start of Horizontal Layout -->
                <tr class="icon_style" v-if="settings.menu_layout_settings.layout_type == 'horizontal'">
                    <th scope="row">
                        <label for="site_name"><?php esc_html_e('Menu Item Style', 'adminify'); ?></label>
                    </th>
                    <td>
                        <div class="wp-adminify-sw-radio-group">
                            <input type="radio" id="horz_menu_type_icons_only" value="icons_only" v-model="settings.menu_layout_settings.horz_menu_type">
                            <label for="horz_menu_type_icons_only"><?php esc_html_e('Icon Only', 'adminify'); ?></label>

                            <input type="radio" id="horz_menu_type_text_only" value="text_only" v-model="settings.menu_layout_settings.horz_menu_type">
                            <label for="horz_menu_type_text_only"><?php esc_html_e('Text Only', 'adminify'); ?></label>

                            <input type="radio" id="horz_menu_type_both" value="both" v-model="settings.menu_layout_settings.horz_menu_type">
                            <label for="horz_menu_type_both"><?php esc_html_e('Both', 'adminify'); ?></label>
                        </div>
                    </td>
                </tr>
                <!-- End of Horizontal Layout -->


                <!-- Start of Vertical Layout -->
                <tr class="menu_hover_submenu" v-if="settings.menu_layout_settings.layout_type == 'vertical'">
                    <th scope="row">
                        <label for="site_name"><?php esc_html_e('Sub Menu Style', 'adminify'); ?></label>
                    </th>
                    <td>
                        <div class="wp-adminify-sw-radio-group">
                            <input type="radio" id="menu_hover_submenu_classic" value="classic" v-model="settings.menu_layout_settings.menu_hover_submenu">
                            <label for="menu_hover_submenu_classic"><?php esc_html_e('Classic', 'adminify'); ?></label>

                            <input type="radio" id="menu_hover_submenu_accordion" value="accordion" v-model="settings.menu_layout_settings.menu_hover_submenu">
                            <label for="menu_hover_submenu_accordion"><?php esc_html_e('Accordion', 'adminify'); ?></label>

                            <input type="radio" id="menu_hover_submenu_toggle" value="toggle" v-model="settings.menu_layout_settings.menu_hover_submenu">
                            <label for="menu_hover_submenu_toggle"><?php esc_html_e('Toggle', 'adminify'); ?></label>
                        </div>
                    </td>
                </tr>

                <tr class="icon_style" v-if="settings.menu_layout_settings.layout_type == 'vertical'">
                    <th scope="row">
                        <label for="site_name"><?php esc_html_e('Active Menu Style', 'adminify'); ?></label>
                    </th>
                    <td>
                        <div class="wp-adminify-sw-radio-group">
                            <input type="radio" id="icon_style_classic" value="classic" v-model="settings.menu_layout_settings.icon_style">
                            <label for="icon_style_classic"><?php esc_html_e('Classic', 'adminify'); ?></label>

                            <input type="radio" id="icon_style_rounded" value="rounded" v-model="settings.menu_layout_settings.icon_style">
                            <label for="icon_style_rounded"><?php esc_html_e('Rounded', 'adminify'); ?></label>
                        </div>
                    </td>
                </tr>

                <!-- End of Vertical Layout -->

            </table>

            <?php $this->next_step_buttons(); ?>
        </form>
        <span><?php esc_html_e('For more settings, check the plugin\'s ', 'adminify');
                echo '"<a href="' . esc_url(admin_url('admin.php?page=wp-adminify-settings#tab=menu-settings')) . '" target="_blank">';
                esc_html_e('Menu Settings', 'adminify');
                echo '</a>".'; ?></span>
        <br /><br />
    <?php
        }

        public function setup_step_admin_notices()
        {
    ?>
        <h1><?php esc_html_e('Admin Notices', 'adminify'); ?></h1>
        <form method="post" @submit.prevent="handleSubmit">
            <table class="form-table">

                <?php if (jltwp_adminify()->can_use_premium_code__premium_only()) { ?>
                    <tr>
                        <th scope="row">
                            <label for="hide_notices"><?php esc_html_e('Hide All "Admin Notices"?', 'adminify'); ?></label>
                        </th>
                        <td class="updated">
                            <input type="checkbox" name="hide_notices" id="hide_notices" class="switch-input" v-model="settings.hide_notices">
                            <label for="hide_notices" class="switch-label">
                                <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                                <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                            </label>
                            <span class="description">
                                <?php esc_html_e('Hide All Admin Notices to make your Dashboard Clean', 'adminify'); ?>
                            </span>
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <th scope="row">
                        <label for="remove_welcome_panel"><?php esc_html_e('Remove Welcome Panel?', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="remove_welcome_panel" id="remove_welcome_panel" class="switch-input" v-model="settings.remove_welcome_panel">
                        <label for="remove_welcome_panel" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Show/Remove Dashboard Welcome Panel', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <?php if (jltwp_adminify()->can_use_premium_code__premium_only()) { ?>
                    <tr>
                        <th scope="row">
                            <label for="remove_php_update_required_nag"><?php esc_html_e('Remove "PHP Update Required" Notice?', 'adminify'); ?></label>
                        </th>
                        <td class="updated">
                            <input type="checkbox" name="remove_php_update_required_nag" id="remove_php_update_required_nag" class="switch-input" v-model="settings.remove_php_update_required_nag">
                            <label for="remove_php_update_required_nag" class="switch-label">
                                <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                                <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                            </label>
                            <span class="description">
                                <?php esc_html_e('Show/Remove "PHP Update Required" Notice', 'adminify'); ?>
                            </span>
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <th scope="row">
                        <label for="remove_try_gutenberg_panel"><?php esc_html_e('Remove "Try Gutenberg" Panel?', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="remove_try_gutenberg_panel" id="remove_try_gutenberg_panel" class="switch-input" v-model="settings.remove_try_gutenberg_panel">
                        <label for="remove_try_gutenberg_panel" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Show/Remove "Try Gutenberg" Panel', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <?php if (jltwp_adminify()->can_use_premium_code__premium_only()) { ?>
                    <tr>
                        <th scope="row">
                            <label for="core_update_notice"><?php esc_html_e('Hide Core Update Notice?', 'adminify'); ?></label>
                        </th>
                        <td class="updated">
                            <input type="checkbox" name="core_update_notice" id="core_update_notice" class="switch-input" v-model="settings.core_update_notice">
                            <label for="core_update_notice" class="switch-label">
                                <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                                <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                            </label>
                            <span class="description">
                                <?php esc_html_e('Show/Hide Core Update Notice', 'adminify'); ?>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="plugin_update_notice"><?php esc_html_e('Hide Plugin Update Notice?', 'adminify'); ?></label>
                        </th>
                        <td class="updated">
                            <input type="checkbox" name="plugin_update_notice" id="plugin_update_notice" class="switch-input" v-model="settings.plugin_update_notice">
                            <label for="plugin_update_notice" class="switch-label">
                                <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                                <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                            </label>
                            <span class="description">
                                <?php esc_html_e('Show/Hide Plugin Update Notice', 'adminify'); ?>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="theme_update_notice"><?php esc_html_e('Hide Theme Update Notice?', 'adminify'); ?></label>
                        </th>
                        <td class="updated">
                            <input type="checkbox" name="theme_update_notice" id="theme_update_notice" class="switch-input" v-model="settings.theme_update_notice">
                            <label for="theme_update_notice" class="switch-label">
                                <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                                <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                            </label>
                            <span class="description">
                                <?php esc_html_e('Show/Hide Theme Update Notice', 'adminify'); ?>
                            </span>
                        </td>
                    </tr>

                <?php } ?>


            </table>

            <?php $this->next_step_buttons(); ?>
        </form>
        <span><?php esc_html_e('For more settings, check the plugin\'s ', 'adminify');
                echo '"<a href="' . esc_url(admin_url('admin.php?page=wp-adminify-settings#tab=admin-notices')) . '" target="_blank">';
                esc_html_e('Admin Notices Settings', 'adminify');
                echo '</a>".'; ?></span>
        <br /><br />
    <?php
        }

        public function setup_step_admin_bar()
        {

    ?>

        <h1><?php esc_html_e('Admin Bar Settings', 'adminify'); ?></h1>

        <form method="post" class="form-table" @submit.prevent="handleSubmit">

            <table class="form-table">

                <?php if (jltwp_adminify()->can_use_premium_code__premium_only()) { ?>

                    <tr class="admin_bar_position">
                        <th scope="row">
                            <label for="admin_bar_position"><?php esc_html_e('Admin Bar Position', 'adminify'); ?></label>
                        </th>
                        <td>
                            <select id="admin_bar_position" name="admin_bar_position" v-model="settings.admin_bar_settings.admin_bar_position">
                                <option value="top"><?php esc_html_e('Top', 'adminify'); ?></option>
                                <option value="bottom"><?php esc_html_e('Bottom', 'adminify'); ?></option>
                            </select>
                            <span class="description">
                                <?php esc_html_e('Where you want to show Admin Bar on Top/Bottom', 'adminify'); ?>
                            </span>
                        </td>
                    </tr>

                <?php } ?>

                <tr>
                    <th scope="row">
                        <label for="admin_bar_menu">
                            <?php esc_html_e('"WP Adminify" Menu', 'adminify'); ?>
                        </label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="admin_bar_menu" id="admin_bar_menu" class="switch-input" v-model="settings.admin_bar_settings.admin_bar_menu">
                        <label for="admin_bar_menu" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Show', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Hide', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Show/Hide Admin "WP Adminify" Menu on Admin bar', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="admin_bar_search">
                            <?php esc_html_e('Search Form', 'adminify'); ?>
                        </label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="admin_bar_search" id="admin_bar_search" class="switch-input" v-model="settings.admin_bar_settings.admin_bar_search">
                        <label for="admin_bar_search" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Show', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Hide', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Show/Hide Admin Bar Search Form', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="admin_bar_comments">
                            <?php esc_html_e('Comments Icon', 'adminify'); ?>
                        </label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="admin_bar_comments" id="admin_bar_comments" class="switch-input" v-model="settings.admin_bar_settings.admin_bar_comments">
                        <label for="admin_bar_comments" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Show', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Hide', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Show/Hide Admin Bar Comments Icon', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="admin_bar_view_website">
                            <?php esc_html_e('View Website Icon', 'adminify'); ?>
                        </label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="admin_bar_view_website" id="admin_bar_view_website" class="switch-input" v-model="settings.admin_bar_settings.admin_bar_view_website">
                        <label for="admin_bar_view_website" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Show', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Hide', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Show/Hide Admin Bar View Website Icon', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="admin_bar_dark_light_btn">
                            <?php esc_html_e('Light/Dark Switcher', 'adminify'); ?>
                        </label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="admin_bar_dark_light_btn" id="admin_bar_dark_light_btn" class="switch-input" v-model="settings.admin_bar_settings.admin_bar_dark_light_btn">
                        <label for="admin_bar_dark_light_btn" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Show', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('Hide', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Show/Hide Admin Bar Light/Dark Switcher', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

            </table>

            <?php $this->next_step_buttons(); ?>
        </form>
        <span><?php esc_html_e('For more settings, check the plugin\'s ', 'adminify');
                echo '"<a href="' . esc_url(admin_url('admin.php?page=wp-adminify-settings#tab=admin-bar')) . '" target="_blank">';
                esc_html_e('Admin Bar Settings', 'adminify');
                echo '</a>".'; ?></span>
        <br /><br />
    <?php
        }

        // Step: Tweaks
        public function setup_step_tweaks()
        {
    ?>
        <h1><?php esc_html_e('Tweaks Settings', 'adminify'); ?></h1>
        <form method="post" class="form-table" @submit.prevent="handleSubmit">

            <table class="form-table">

                <tr>
                    <th scope="row">
                        <label for="generator_wp_version"><?php esc_html_e('Remove Generator Version', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="generator_wp_version" id="generator_wp_version" class="switch-input" v-model="settings.generator_wp_version">
                        <label for="generator_wp_version" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Remove WordPress Generator WordPress Version from Frontend and RSS Feed', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="remove_version_strings"><?php esc_html_e('Remove Version from Style and Script', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="remove_version_strings" id="remove_version_strings" class="switch-input" v-model="settings.remove_version_strings">
                        <label for="remove_version_strings" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Remove Version Number from Styles/Scripts', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="remove_dashicons"><?php esc_html_e('Remove Dashicons', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="remove_dashicons" id="remove_dashicons" class="switch-input" v-model="settings.remove_dashicons">
                        <label for="remove_dashicons" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Remove Dashicons from Admin Bar for non logged in users', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="remove_shortlink"><?php esc_html_e('Remove Shortlink', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="remove_shortlink" id="remove_shortlink" class="switch-input" v-model="settings.remove_shortlink">
                        <label for="remove_shortlink" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Remove "<link rel=\'shortlink\'..." from head section', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="remove_canonical"><?php esc_html_e('Remove Canonical URL', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="remove_canonical" id="remove_canonical" class="switch-input" v-model="settings.remove_canonical">
                        <label for="remove_canonical" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Remove &lt;link rel="canonical" href="http://www.site.com/some-url" /&gt; from head section', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="remove_emoji"><?php esc_html_e('Remove Emoji Styles and Scripts', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="remove_emoji" id="remove_emoji" class="switch-input" v-model="settings.remove_emoji">
                        <label for="remove_emoji" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Remove Emoji styles and scripts from head section', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="disable_xmlrpc"><?php esc_html_e('Disable XML-RPC', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="disable_xmlrpc" id="disable_xmlrpc" class="switch-input" v-model="settings.disable_xmlrpc">
                        <label for="disable_xmlrpc" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Disable XML-RPC from head section', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="remove_feed"><?php esc_html_e('Remove Feed Links', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="remove_feed" id="remove_feed" class="switch-input" v-model="settings.remove_feed">
                        <label for="remove_feed" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('It will not disable feed functionality, just cleans head section', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="remove_pingback"><?php esc_html_e('Remove X-Pingback from HTTP Headers', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="remove_pingback" id="remove_pingback" class="switch-input" v-model="settings.remove_pingback">
                        <label for="remove_pingback" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Remove "X-Pingback:..." from server response HTTP headers', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="remove_powered"><?php esc_html_e('Remove X-Powered-By from HTTP Headers', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="remove_powered" id="remove_powered" class="switch-input" v-model="settings.remove_powered">
                        <label for="remove_powered" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Remove "X-Pingback:..." from server response HTTP headers', 'adminify'); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="gravatar_query_strings"><?php esc_html_e('Remove Gravatar Query Strings', 'adminify'); ?></label>
                    </th>
                    <td class="updated">
                        <input type="checkbox" name="gravatar_query_strings" id="gravatar_query_strings" class="switch-input" v-model="settings.gravatar_query_strings">
                        <label for="gravatar_query_strings" class="switch-label">
                            <span class="toggle--on"><?php esc_html_e('Yes', 'adminify'); ?></span>
                            <span class="toggle--off"><?php esc_html_e('No', 'adminify'); ?></span>
                        </label>
                        <span class="description">
                            <?php esc_html_e('Remove Query Strings from Gravatar', 'adminify'); ?>
                        </span>
                    </td>
                </tr>


            </table>

            <?php $this->next_step_buttons(); ?>
        </form>
        <span>
            <?php esc_html_e('For more settings, check the plugin\'s ', 'adminify');
            echo '"<a href="' . esc_url(admin_url('admin.php?page=wp-adminify-settings#tab=tweaks')) . '" target="_blank">';
            esc_html_e('Tweaks Settings', 'adminify');
            echo '</a>".'; ?>
        </span>
    <?php
        }

        public function setup_step_ready()
        {
    ?>
        <div class="final-step">
            <h1><?php esc_html_e('Your Site is Ready!', 'adminify'); ?></h1>

            <div class="wp-adminify-sw-setup-next-steps">
                <div class="wp-adminify-sw-setup-next-steps-first">
                    <h2><?php esc_html_e('Next Steps', 'adminify'); ?> &rarr;</h2>
                    <a class="button button-primary button-large" href="<?php echo esc_url(admin_url('admin.php?page=wp-adminify-settings&adminify_setup_done_config=1')); ?>">
                        <?php esc_html_e('Go to WP Adminify Dashboard!', 'adminify'); ?>
                    </a>
                </div>
            </div>
        </div>
<?php
        }
    }
