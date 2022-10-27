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

class ServerInfo_PHP_INI_Details
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
                <?php echo Utils::admin_page_title(esc_html__('PHP_INI_Details File', 'adminify')); ?>
            </h1>

            <p style="color: #ce2754; font-weight: bold">
                <?php $name = 'php.ini';
                printf(wp_kses_post(__('For security reasons you can only read the %1$s file! Please connect to your server and modify the file in a file editor.', 'adminify')), $name); ?>
            </p>

            <p>
                <strong><?php esc_html_e('To affect your custom configuration in the php.ini file, you have to save the file in the "../wp-admin" folder.', 'adminify'); ?></strong>
            </p>

            <p>
                <?php esc_html_e("The PHP configuration file, php.ini, is the final and most immediate way to affect PHP's functionality. The php.ini file is read each time PHP is initialized.", 'adminify'); ?>
                <br>
                <a href="https://www.php.net/manual/en/ini.core.php" target="_blank" rel="noopener"><?php esc_html_e('Learn more about the php.ini file.', 'adminify'); ?></a>
            </p>
        </div>

        <?php

        // Get the wp "php.ini" file
        $file = $this->jltwp_adminify_php_ini_file();

        // Get the wp "php.ini" file content
        $file_content = $this->jltwp_adminify_php_ini_file_content($file);

        if ($file) { ?>
            <p>
                <?php echo esc_html__('php.ini file was found at:', 'adminify') . ' <strong>' . esc_html($file) . '</strong>'; ?>
                <br>
            </p>
        <?php } ?>

        <textarea id="php_ini_log_area" class="adminify-info-text-area" readonly><?php echo esc_html($file_content); ?></textarea>


<?php
    }


    /**
     * PHP.ini file
     *
     * @return void
     */
    public function jltwp_adminify_php_ini_file()
    {

        // Call wp file system
        global $wp_filesystem;
        WP_Filesystem();

        // Get the path of wp "php.ini" file
        $file = get_home_path() . 'wp-admin/php.ini';

        // Check if "php.ini" file exist
        if (
            $wp_filesystem->exists($file)
        ) {
            return $file;
        }

        // File not exist
        return false;
    }


    /**
     * PHP.ini File Contents
     *
     * @param [type] $file
     *
     * @return void
     */
    public function jltwp_adminify_php_ini_file_content($file)
    {

        // Call wp file system
        global $wp_filesystem;
        WP_Filesystem();

        // Show this notice, if no file exist
        $content = esc_html__('php.ini file not found!', 'adminify');

        // Check if "php.ini" file exist
        if (
            $wp_filesystem->exists($file)
        ) {
            $content = $wp_filesystem->get_contents($file);

            // Check if the file content is empty
            if ($wp_filesystem->get_contents($file) == '') {
                $content = esc_html__('File content is empty.', 'adminify');
            }
        }

        return $content;
    }
}
