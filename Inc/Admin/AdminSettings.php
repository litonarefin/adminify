<?php

namespace WPAdminify\Inc\Admin;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;
use WPAdminify\Inc\Admin\Options\General;
use WPAdminify\Inc\Admin\Options\Modules;
use WPAdminify\Inc\Admin\Options\DismissNotices;
use WPAdminify\Inc\Admin\Options\MenuLayout;
use WPAdminify\Inc\Admin\Options\Tweaks;
use WPAdminify\Inc\Admin\Options\AdminBar;
use WPAdminify\Inc\Admin\Options\Admin_Footer;
use WPAdminify\Inc\Admin\Options\WidgetSettings;
use WPAdminify\Inc\Admin\Options\Module_Settings;
use WPAdminify\Inc\Admin\Options\Assets_Manager;
use WPAdminify\Inc\Admin\Options\White_Label;
use WPAdminify\Inc\Admin\Options\Custom_CSS_JS_Admin_Area;

if (!defined('ABSPATH')) {
  die;
} // Cannot access directly.

if (!class_exists('AdminSettings')) {
  class AdminSettings extends AdminSettingsModel
  {
    // AdminSettings cannot be extended by creating instances
    public static $instance = null;

    public $defaults = [];

    private $message = [];

    public function __construct()
    {
      // this should be first so the default values get stored
      $this->jltwp_adminify_options();

      parent::__construct((array) get_option($this->prefix));

      add_action('network_admin_menu', [$this, 'network_panel']);

      if (jltwp_adminify()->can_use_premium_code__premium_only()) {
        add_action('admin_init', [$this, 'maybe_clone_blog_options']);
        add_action('admin_enqueue_scripts', [$this, 'jltwp_adminify_admin_scripts'], 9999);
      }
    }

    public function network_panel()
    {
      add_menu_page($this->get_plugin_menu_label(), $this->get_plugin_menu_label(), 'manage_options', 'wp-adminify-settings', [$this, 'network_panel_display'], WP_ADMINIFY_ASSETS_IMAGE . 'logos/menu-icon.svg', 30);
    }

    public function get_bloginfo($blog_id, $fields = [])
    {

      switch_to_blog($blog_id);

      $_fields = [];

      foreach ($fields as $field) {
        $_fields[$field] = get_bloginfo($field);
      }

      restore_current_blog();

      return $_fields;
    }

    public function get_sites()
    {
      $sites = get_sites();
      foreach ($sites as $site) {
        $info = $this->get_bloginfo($site->blog_id, ['name']);
        $site->name = $info['name'];
      }
      return $sites;
    }

    public function get_sites_option_empty()
    {
      return sprintf('<option value="%s">%s</option>', 0, __('Select', 'adminify'));
    }
    public function get_sites_option($sites = [], $add_empty_slot = false)
    {
      if (empty($sites)) {
        $sites = $this->get_sites();
      }

      $_sites = [];

      if ($add_empty_slot) {
        $_sites[] = $this->get_sites_option_empty();
      }

      foreach ($sites as $site) {
        $_sites[] = sprintf('<option value="%s">%s</option>', $site->blog_id, $site->name);
      }

      return implode('', $_sites);
    }

    public function maybe_display_message()
    {

      if (empty($this->message)) return;

      $classes = 'adminify-status adminify-status--' . $this->message['type'];

      printf('<div class="%s"><p>%s</p></div>', $classes, $this->message['message']);
    }

    public function network_panel_display()
    {
      if (jltwp_adminify()->can_use_premium_code__premium_only()) {

        $sites = $this->get_sites();

        $this->maybe_display_message();

?>

        <div class="container wp-clone-sites-options">
          <form method="post" action="<?php echo network_admin_url('admin.php?page=wp-adminify-settings'); ?>">

            <h1><?php _e('Network Settings', 'adminify'); ?>
              <p><?php _e('Clone Site Option\'s. You can copy a site settings to another. Also, you can Copy and "Apply to All Sites", exclude sites settings etc', 'adminify'); ?></p>
            </h1>


            <div class="line-single--wrapper copy_from-field-wrapper">
              <div class="line-single--title"><?php _e('Copy From', 'adminify'); ?></div>
              <div class="line-single--content">
                <select class="select-field copy_from" name="copy_from">
                  <?php echo $this->get_sites_option($sites, true); ?>
                </select>
              </div>
            </div>

            <div class="line-single--wrapper copy_to-field-wrapper">
              <div class="line-single--title"><?php _e('Copy To', 'adminify'); ?></div>
              <div class="line-single--content">
                <select class="select-field copy_to" name="copy_to">
                  <?php echo $this->get_sites_option_empty(); ?>
                  <option value="copy_to_all"><?php _e('Copy to All Sites', 'adminify'); ?></option>
                  <?php echo $this->get_sites_option($sites); ?>
                </select>
              </div>
            </div>

            <div class="line-single--wrapper copy_exclude-field-wrapper" style="display: none;">
              <div class="line-single--title"><?php _e('Exclude', 'adminify'); ?></div>
              <div class="line-single--content">
                <select class="select-field copy_exclude" name="copy_exclude[]" multiple>
                  <?php echo $this->get_sites_option($sites, false); ?>
                </select>
              </div>
            </div>

            <div class="line-single--wrapper option_modules-field-wrapper" style="display: block;">
              <div class="line-single--title"><?php _e('Options', 'adminify'); ?></div>
              <div class="line-single--content">

                <?php foreach ($this->option_modules() as $option_module_key => $option_module) : ?>
                  <div>
                    <label for="<?php echo 'adminify_clone_' . $option_module_key; ?>">
                      <input id="<?php echo 'adminify_clone_' . $option_module_key; ?>" type="checkbox" name="option_modules[]" value="<?php echo $option_module_key; ?>" checked />
                      <span><?php echo $option_module; ?></span>
                    </label>
                  </div>
                <?php endforeach; ?>

                <button id="option_modules_toggle" type="none">Toggle Options</button>

              </div>
            </div>

            <div>
              <input type="hidden" name="action" value="adminify_site_option_clone">
              <?php wp_nonce_field('adminify_site_option_clone', '_wpnonce'); ?>
              <input type="submit" class="button button-small" value="<?php _e('Clone Adminify Options', 'adminify'); ?>" />
            </div>

          </form>
        </div>


      <?php
      } else {
        echo '<h2>Network Settings</h2>';
        echo '<div>';
        echo Utils::adminify_upgrade_pro('Upgrade to Pro');
        echo '</div>';
      }
    }

    public function option_modules()
    {
      return (array) apply_filters('adminify_clone_blog_option_modules', [
        '_wpadminify' => __('Adminify Core'),
        '_wp_adminify_sidebar_settings' => __('Sidebar Settings'),
        '_wpadminify_custom_js_css' => __('Custom JS CSS'),
        '_adminify_admin_columns_adminify_admin_page' => __('Admin Page Columns Data'),
        '_adminify_admin_columns_page' => __('Page Columns Data'),
        '_adminify_admin_columns_post' => __('Post Columns Data'),
        '_wpadminify_admin_saved_notices' => __('Saved Notices'),
        '_adminify_notification_bar' => __('Notification Bar'),
        'jltwp_adminify_login' => __('Login Customizer'),
      ]);
    }

    public function maybe_clone_blog_options()
    {
      if (jltwp_adminify()->can_use_premium_code__premium_only()) {
        if (empty($_POST)) return;
        if (!is_multisite() || !is_network_admin()) return;
        if (empty($_POST['action']) || $_POST['action'] !== 'adminify_site_option_clone') return;

        check_admin_referer('adminify_site_option_clone');

        if (empty($copy_from = $_POST['copy_from']) || empty($copy_to = $_POST['copy_to'])) return;

        if ($copy_to == 'copy_to_all') {
          $copy_exclude = empty($_POST['copy_exclude']) ? [] : (array) $_POST['copy_exclude'];
        } else {
          $copy_exclude = [];
        }

        if ($copy_from == $copy_to) {
          $this->message = [
            'type' => 'error',
            'message' => __('Source Site and Target Site should not be same.', 'adminify')
          ];
          return;
        }

        $option_modules = empty($_POST['option_modules']) ? [] : (array) $_POST['option_modules'];

        $options_to_copy = (array) apply_filters('adminify_clone_blog_options', $option_modules, $copy_from, $copy_to, $copy_exclude);

        if ($copy_to == 'copy_to_all') {

          $sites = $this->get_sites();

          foreach ($sites as $site) {
            if ($site->id == $copy_from) continue;
            if (!empty($copy_exclude) && in_array($site->id, $copy_exclude)) continue;
            foreach ($options_to_copy as $option) {
              $data = get_blog_option($copy_from, $option);
              update_blog_option($site->id, $option, $data);
            }
          }
        } else {

          foreach ($options_to_copy as $option) {
            $data = get_blog_option($copy_from, $option);
            update_blog_option($copy_to, $option, $data);
          }
        }

        if (empty($this->message)) {
          $this->message = [
            'type' => 'success',
            'message' => __('Options are successfully copied to target site.', 'adminify')
          ];
        }
      }
    }

    public function get_pagespeed_data($copy_from)
    {

      switch_to_blog($copy_from);

      global $wpdb;
      $table_name = $wpdb->prefix . 'adminify_page_speed';
      $histories = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

      restore_current_blog();

      return $histories;
    }

    public function clone_pagespeed_data($histories, $copy_to)
    {

      switch_to_blog($copy_to);

      global $wpdb;
      $table_name = $wpdb->prefix . 'adminify_page_speed';

      foreach ($histories as $history) {
        unset($history['id']);
        $wpdb->insert("$table_name", $history, array(
          'url' => '%s',
          'score_desktop' => '%d',
          'score_mobile' => '%d',
          'data_desktop' => '%s',
          'data_mobile' => '%s',
          'screenshot' => '%s',
          'time' => '%s',
        ));
      }

      restore_current_blog();
    }

    public function get_admin_columns_options($copy_from)
    {

      $options = [];

      switch_to_blog($copy_from);
      $args = array(
        'public'   => true
      );
      $types = get_post_types($args);
      unset($types['attachment']);
      restore_current_blog();

      foreach ($types as $type) {
        $options[] = '_adminify_admin_columns_meta_' . $type;
      }

      return $options;
    }

    public static function get_instance()
    {
      if (!is_null(self::$instance)) return self::$instance;
      self::$instance = new self();
      return self::$instance;
    }


    protected function get_defaults()
    {
      return $this->defaults;
    }

    /**
     * Admin Settings CSS
     *
     * @return void
     */
    public function jltwp_adminify_admin_scripts()
    {
      if (jltwp_adminify()->can_use_premium_code__premium_only()) {

        wp_enqueue_style('wp-adminify-select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
        wp_enqueue_script('wp-adminify-select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['jquery'], false, true);

        ob_start();

      ?>

        jQuery(function($) {

        $('.select-field').select2({width: '100%'});

        $('.copy_to').on('change', function() {
        if ( $(this).val() == 'copy_to_all' ) {
        $(this).closest('.wp-clone-sites-options').find('.copy_exclude-field-wrapper').show();
        } else {
        $(this).closest('.wp-clone-sites-options').find('.copy_exclude-field-wrapper').hide();
        }
        });

        $('#option_modules_toggle').on('click', function(e) {
        e.preventDefault();
        $checkboxes = $(this).closest('.line-single--content').find('input[type="checkbox"]');
        $checked = $checkboxes.filter(':checked');
        $status = true;
        if ( $checked.length == $checkboxes.length ) $status = false;
        $checkboxes.each(function(){ $(this).prop('checked', $status) });
        });

        });

<?php

        $script = ob_get_clean();

        wp_add_inline_script('wp-adminify-select2', $script);

        $output_css = '.wp-adminify-settings .dashicons,.wp-adminify-settings .dashicons-before:before{vertical-align:middle}.adminify-status{background:#fff;padding:12px 10px;margin:30px 0;-webkit-border-radius:4px;border-radius:4px;-webkit-box-shadow:0 0 8px rgba(139,148,169,.15);box-shadow:0 0 8px rgba(139,148,169,.15)}.adminify-status.adminify-status--success{border-left:4px solid #48cf5b}.adminify-status.adminify-status--error{border-left:4px solid #f16b6b}.adminify-status p{margin:0}.adminify-status p:not(:last-child){margin-bottom:10px}.wp-clone-sites-options h1{margin:10px 0 30px}.wp-clone-sites-options{max-width:800px}.container.wp-clone-sites-options form{padding:30px;background:#fff;margin:20px 0;-webkit-border-radius:4px;border-radius:4px;-webkit-box-shadow:0 0 24px rgba(108,111,120,.15);box-shadow:0 0 24px rgba(108,111,120,.15)}.wp-clone-sites-options .select-field{width:100%}.line-single--wrapper{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center;margin-bottom:24px;-webkit-flex-wrap:wrap;-ms-flex-wrap:wrap;flex-wrap:wrap;background:#eff0f3;padding:24px 20px;-webkit-border-radius:4px;border-radius:4px}.line-single--title{width:100%;margin-bottom:10px;font-weight:700}.line-single--content{width:100%;display:-webkit-inline-box;display:-webkit-inline-flex;display:-ms-inline-flexbox;display:inline-flex;-webkit-flex-wrap:wrap;-ms-flex-wrap:wrap;flex-wrap:wrap}.line-single--content>div{width:33.333333%;margin-bottom:8px}button#option_modules_toggle{padding:8px 10px;line-height:1;margin-top:5px;border:none;background:#fff;-webkit-border-radius:4px;border-radius:4px;cursor:pointer;-webkit-box-shadow:0 0 4px #ddd;box-shadow:0 0 4px #ddd}';

        wp_add_inline_style('wp-adminify-admin', $output_css);



        $select2_css = '.wp-adminify .select2-container .select2-selection--single .select2-selection__rendered {
          color: #000;
          line-height: 34px;
        }

        .select2-container--default .select2-selection--single, .select2-dropdown, .select2-container--default .select2-search--dropdown .select2-search__field {
          border: 1px solid #d1d1d1;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
          height: 34px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
          line-height: 1.6;
        }

        .select2-container .select2-selection--multiple .select2-selection__rendered {
          vertical-align: sub;
        }

        span.select2-search.select2-search--inline {
          vertical-align: super;
        }

        .select2-container--default .select2-search--inline .select2-search__field {
          background: none !important;
          padding: 0 !important;
        }';

        // Combine the values from above and minifiy them.
        $select2_css = preg_replace('#/\*.*?\*/#s', '', $select2_css);
        $select2_css = preg_replace('/\s*([{}|:;,])\s+/', '$1', $select2_css);
        $select2_css = preg_replace('/\s\s+(.*)/', '$1', $select2_css);
        wp_add_inline_style('wp-adminify-select2', $select2_css);
      }
    }

    public function get_plugin_menu_label()
    {
      $plugin_menu_label = WP_ADMINIFY;
      $saved_data = get_option($this->prefix);

      if (jltwp_adminify()->can_use_premium_code__premium_only()) {
        if (jltwp_adminify()->is_plan('agency')) {
          // Menu Label
          if (!empty($saved_data['jltwp_adminify_wl_plugin_menu_label'])) {
            $plugin_menu_label = $saved_data['jltwp_adminify_wl_plugin_menu_label'];
          }
        }
      }

      return $plugin_menu_label;
    }


    public function jltwp_adminify_options()
    {

      if (!class_exists('ADMINIFY')) {
        return;
      }

      $saved_data = get_option($this->prefix);
      
      $admin_bar_mode = empty($saved_data['admin_bar_mode']) ? 'light' : $saved_data['admin_bar_mode'];

      if ( $admin_bar_mode == 'light' ) {
        $logo_image_url = WP_ADMINIFY_ASSETS_IMAGE . 'logos/logo-text-light.svg';
      } else {
        $logo_image_url = WP_ADMINIFY_ASSETS_IMAGE . 'logos/logo-text-dark.svg';
      }
      $plugin_author_name = WP_ADMINIFY_AUTHOR;

      if (jltwp_adminify()->can_use_premium_code__premium_only()) {
        if (jltwp_adminify()->is_plan('agency')) {
          // Logo Options
          if (!empty($saved_data['jltwp_adminify_wl_plugin_logo']['url'])) {
            $logo_image_url = $saved_data['jltwp_adminify_wl_plugin_logo']['url'];
          }
          // Author Name
          if (!empty($saved_data['jltwp_adminify_wl_plugin_author_name'])) {
            $plugin_author_name = $saved_data['jltwp_adminify_wl_plugin_author_name'];
          }
        }
      }

      // WP Adminify Options
      \ADMINIFY::createOptions($this->prefix, array(

        // Framework Title
        'framework_title'         => '<img class="wp-adminify-settings-logo" src=' . $logo_image_url . '>' . ' <small>by ' . $plugin_author_name . '</small>',
        'framework_class'         => '',

        // menu settings
        'menu_title'              => $this->get_plugin_menu_label(),
        'menu_slug'               => 'wp-adminify-settings',
        'menu_capability'         => 'manage_options',
        'menu_icon'               => WP_ADMINIFY_ASSETS_IMAGE . 'logos/menu-icon.svg',
        'menu_position'           => 30,
        'menu_hidden'             => false,
        'menu_parent'             => 'admin.php?page=wp-adminify-settings',

        // menu extras
        'show_bar_menu'           => true,
        'show_sub_menu'           => false,
        'show_in_network'         => false,
        'show_in_customizer'      => false,

        'show_search'             => false,
        'show_reset_all'          => true,
        'show_reset_section'      => true,
        'show_footer'             => true,
        'show_all_options'        => false,
        'show_form_warning'       => true,
        'sticky_header'           => false,
        'save_defaults'           => false,
        'ajax_save'               => true,

        // admin bar menu settings
        'admin_bar_menu_icon'     => '',
        'admin_bar_menu_priority' => 80,

        // footer
        'footer_text'             => ' ',
        'footer_after'            => ' ',
        'footer_credit'           => ' ',

        // database model
        'database'                => 'options', // options, transient, theme_mod, network(multisite support)
        'transient_time'          => 0,

        // contextual help
        'contextual_help'         => array(),
        'contextual_help_sidebar' => '',

        // typography options
        'enqueue_webfont'         => true,
        'async_webfont'           => false,

        // others
        'output_css'              => true,

        // theme and wrapper classname
        'nav'                     => 'normal',
        'theme'                   => 'dark',
        'class'                   => 'wp-adminify-settings',

        // external default values
        'defaults'                => array(),
      ));

      $this->defaults = array_merge($this->defaults, (new Modules())->get_defaults());
      $this->defaults = array_merge($this->defaults, (new General())->get_defaults());
      $this->defaults = array_merge($this->defaults, (new Admin_Footer())->get_defaults());
      $this->defaults = array_merge($this->defaults, (new MenuLayout())->get_defaults());
      $this->defaults = array_merge($this->defaults, (new AdminBar())->get_defaults());
      $this->defaults = array_merge($this->defaults, (new Tweaks())->get_defaults());
      $this->defaults = array_merge($this->defaults, (new WidgetSettings())->get_defaults());
      $this->defaults = array_merge($this->defaults, (new DismissNotices())->get_defaults());
      $this->defaults = array_merge($this->defaults, (new Module_Settings())->get_defaults());
      $this->defaults = array_merge($this->defaults, (new Assets_Manager())->get_defaults());
      $this->defaults = array_merge($this->defaults, (new Custom_CSS_JS_Admin_Area())->get_defaults());

      if (jltwp_adminify()->can_use_premium_code__premium_only()) {
        if (jltwp_adminify()->is_plan('agency')) {
          if (empty($saved_data['jltwp_adminify_wl_plugin_option'])) {
            $this->defaults = array_merge($this->defaults, (new White_Label())->get_defaults());
          }
        }
      } else {
        $this->defaults = array_merge($this->defaults, (new White_Label())->get_defaults());
      }



      // Backup Settings
      \ADMINIFY::createSection($this->prefix, array(
        'title'       => 'Backup',
        'icon'        => 'fas fa-shield-alt',
        'fields'      => array(

          array(
            'type'    => 'subheading',
            'content'   => Utils::adminfiy_help_urls(
              __('Backup Config Settings', 'adminify'),
              'https://wpadminify.com/kb/wp-adminify-options-panel/#adminify-backup',
              'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
              'https://www.facebook.com/groups/jeweltheme',
              'https://wpadminify.com/support/'
            )
          ),

          array(
            'type' => 'backup',
          ),
        )
      ));
    }
  }
}