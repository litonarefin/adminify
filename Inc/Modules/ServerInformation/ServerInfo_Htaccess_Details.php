<?php

namespace WPAdminify\Inc\Modules\ServerInformation;

use WPAdminify\Inc\Classes\ServerInfo;
use WPAdminify\Inc\Utils;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WPAdminify
 * @package Server Information
 *
 * @author WP Adminify <support@wpadminify.com>
 */

class ServerInfo_Htaccess_Details
{

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $server_info = new ServerInfo();

        $help = '<span class="dashicons dashicons-editor-help"></span>';
        $enabled = '<span class="adminify-compability enable"><span class="dashicons dashicons-yes"></span> ' . esc_html__('Enabled', 'adminify') . '</span>';
        $disabled = '<span class="adminify-compability disable"><span class="dashicons dashicons-no"></span> ' . esc_html__('Disabled', 'adminify') . '</span>';
        $yes = '<span class="adminify-compability enable"><span class="dashicons dashicons-yes"></span> ' . esc_html__('Yes', 'adminify') . '</span>';
        $no = '<span class="adminify-compability disable"><span class="dashicons dashicons-no"></span> ' . esc_html__('No', 'adminify') . '</span>';
        $entered = '<span class="adminify-compability enable"><span class="dashicons dashicons-yes"></span> ' . esc_html__('Defined', 'adminify') . '</span>';
        $not_entered = '<span class="adminify-compability disable"><span class="dashicons dashicons-no"></span> ' . esc_html__('Not defined', 'adminify') . '</span>';
        $sec_key = '<span class="error"><span class="dashicons dashicons-warning"></span> ' . esc_html__('Please enter this security key in the wp-confiq.php file', 'adminify') . '!</span>';
?>
        <div class="wrap">
            <h1>
                <?php echo Utils::admin_page_title(esc_html__('.htaccess file', 'adminify')); ?>
            </h1>
        </div>

        <p style="color: #ce2754; font-weight: bold">
            <?php $name = '.htaccess';
            printf(wp_kses_post(__('For security reasons you can only read the %1$s file! Please connect to your server and modify the file in a file editor.', 'adminify')), $name); ?>
        </p>

        <p>
            <?php esc_html_e('The .htaccess is a distributed configuration file, and is how Apache server handles configuration changes on a per-directory basis.', 'adminify'); ?>
            <br>
            <a href="https://wordpress.org/support/article/htaccess/" target="_blank" rel="noopener"><?php esc_html_e('Learn more about the .htaccess file in WordPress.', 'adminify'); ?></a>
        </p>

        <?php

        // Get the wp ".htaccess" file
        $file = $this->jltwp_adminify_htaccess_file();

        // Get the wp ".htaccess" file content
        $file_content = $this->jltwp_adminify_htaccess_file_content($file);

        if ($file) { ?>
            <p>
                <?php echo esc_html__('.htaccess file was found at:', 'adminify') . ' <strong>' . esc_html($file) . '</strong>'; ?>
                <br>
            </p>
        <?php } ?>

        <textarea id="htaccess_log_area" class="adminify-info-text-area" readonly><?php echo esc_html($file_content); ?></textarea>

<?php
    }


    /**
     * htaccess file
     */
    public function jltwp_adminify_htaccess_file()
    {

        // Call wp file system
        global $wp_filesystem;
        WP_Filesystem();

        // Get the path of wp ".htaccess" file
        $file = get_home_path() . '.htaccess';

        // Check if ".htaccess" file exist
        if (
            $wp_filesystem->exists($file)
        ) {
            return $file;
        }

        // File not exist
        return false;
    }

    /**
     * .htaccess file contents
     */

    public function jltwp_adminify_htaccess_file_content($file)
    {

        // Call wp file system
        global $wp_filesystem;
        WP_Filesystem();

        // Show this notice, if no file exist
        $content = esc_html__('.htaccess file not found!', 'wphave-admin');

        // Check if ".htaccess" file exist
        if ($wp_filesystem->exists($file)) {
            $content = $wp_filesystem->get_contents($file);

            // Check if the file content is empty
            if ($wp_filesystem->get_contents($file) == '') {
                $content = esc_html__('File content is empty.', 'wphave-admin');
            }
        }

        return $content;
    }
}
