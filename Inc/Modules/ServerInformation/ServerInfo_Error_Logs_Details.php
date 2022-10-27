<?php

namespace WPAdminify\Inc\Modules\ServerInformation;

use WPAdminify\Inc\Utils;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WPAdminify
 * @package Server Information: Error Logs
 *
 * @author WP Adminify <support@wpadminify.com>
 */

class ServerInfo_Error_Logs_Details
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    { ?>

        <div class="wrap">
            <h1>
                <?php echo Utils::admin_page_title(esc_html__('Error Logs', 'adminify')); ?>
            </h1>
            <?php if ((defined('WP_DEBUG') && !WP_DEBUG) || (defined('WP_DEBUG_LOG') && !WP_DEBUG_LOG)) { ?>
                <p style="color: #ce2754; font-weight: bold">
                    <?php echo esc_html__('You have to set and enable "WP_DEBUG" and "WP_DEBUG_LOG" in your "wp-config.php" file, to show the error log here!', 'adminify'); ?>
                </p>
            <?php } ?>

            <p>
                <?php esc_html_e('Note that debugging (the process of finding and resolving issues in software) is disabled by default in WordPress and should not be enabled on live websites. However it can be enabled temporarily to troubleshoot issues.', 'adminify'); ?>
                <br>
                <a href="https://wordpress.org/support/article/debugging-in-wordpress/" target="_blank" rel="noopener"><?php esc_html_e('Learn more about debugging in WordPress.', 'adminify'); ?></a>
            </p>
        </div>

        <?php

        // Get the wp "debug.log" file
        $file = self::jltwp_adminify_error_log();

        // Get the wp "debug.log" file content
        $file_content = self::jltwp_adminify_error_log_content($file);

        // Check for custom "debug.log" file path
        $custom_file_path = (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG != false && WP_DEBUG_LOG != 1);

        // Check for depug modes
        $debug_modes = array();

        $debug_modes['WP_DEBUG'] = '';
        if (defined('WP_DEBUG') && WP_DEBUG) {
            $debug_modes['WP_DEBUG'] = true;
        }

        $debug_modes['WP_DEBUG_DISPLAY'] = '';
        if (defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY) {
            $debug_modes['WP_DEBUG_DISPLAY'] = true;
        }

        $debug_modes['WP_DEBUG_LOG'] = '';
        if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
            $debug_modes['WP_DEBUG_LOG'] = true;
        }

        $debug_modes['SCRIPT_DEBUG'] = '';
        if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) {
            $debug_modes['SCRIPT_DEBUG'] = true;
        }

        $debug_modes['SAVEQUERIES'] = '';
        if (defined('SAVEQUERIES') && SAVEQUERIES) {
            $debug_modes['SAVEQUERIES'] = true;
        } ?>

        <br>

        <div class="wp-adminify-error-logs block">
            <ul>
                <?php foreach ($debug_modes as $debug_mode => $value) {

                    $status = 'disable has-text-white p-1 pl-3 pr-3 is-rounded';
                    $label = esc_html__('Disabled', 'adminify');
                    if ($value) {
                        $status = 'enable has-text-white p-1 pl-3 pr-3 is-rounded';
                        $label = esc_html__('Enabled', 'adminify');
                    } ?>

                    <li class="is-inline-block mr-4">
                        <span>
                            <?php echo esc_html($debug_mode) . ' '; ?>
                            <span class="field-status <?php echo esc_html($status); ?>"><?php echo esc_html($label); ?></span>
                            <?php if ($debug_mode === 'WP_DEBUG_LOG' && $custom_file_path) { ?>
                                <span class="field-status"><?php echo esc_html__('Custom path', 'adminify'); ?></span>
                            <?php } ?>
                        </span>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="buttons-group is-pulled-right">
            <button id="adminify_error_log_clear" class="button clear-button">
                <?php echo esc_html__('Clear file content', 'adminify'); ?>
            </button>

            <button id="adminify_error_log_refresh" class="button button-primary ml-3">
                <?php echo esc_html__('Refresh', 'adminify'); ?>
            </button>
        </div>

        <p class="mt-4">
            <?php echo esc_html__('Debug log file was found at:', 'adminify') . ' <strong>' . esc_html($file) . '</strong>'; ?>
            <br>
        </p>

        <textarea id="adminify_error_log_area" class="adminify-info-text-area" readonly><?php echo esc_html($file_content); ?></textarea>
<?php
    }



    public static function jltwp_adminify_error_log()
    {

        // Get the path of wp "debug.log"
        $file = get_home_path() . 'wp-content/debug.log';

        // Check for custom "debug.log" file path
        $custom_file_path = (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG != false && WP_DEBUG_LOG != 1);
        if ($custom_file_path) {
            $file = WP_DEBUG_LOG;
        }

        return $file;
    }

    /**
     * * Get Error Log File Contents
     */
    public static function jltwp_adminify_error_log_content($file)
    {

        // Call wp file system
        global $wp_filesystem;
        WP_Filesystem();

        // Show this notice, if no file exist
        $content = esc_html__('debug.log file not found!', 'adminify');

        // Check if "debug.log" file exist
        if ($wp_filesystem->exists($file)) {
            $content = $wp_filesystem->get_contents($file);

            // Check if the file content is empty
            if ($wp_filesystem->get_contents($file) == '') {
                $content = esc_html__('File content is empty. No errors logged.', 'adminify');
            }
        }

        return $content;
    }
}
