<?php

namespace WPAdminify\Inc\Modules\ServerInformation;

use WPAdminify\Inc\Utils;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WPAdminify
 * @package Server Information: Robots.txt file
 *
 * @author WP Adminify <support@wpadminify.com>
 */

class ServerInfo_Robots_Details
{

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
?>

        <div class="wrap">

            <h1>
                <?php echo Utils::admin_page_title(esc_html__('Robots.txt File', 'adminify')); ?>
            </h1>

            <p style="color: #ce2754; font-weight: bold">
                <?php $name = 'robots.txt';
                printf(wp_kses_post(__('For security reasons you can only read the %1$s file! Please connect to your server and modify the file in a file editor.', 'adminify')), $name); ?>
            </p>

            <p>
                <strong><?php esc_html_e('To affect your custom configuration in the robots.txt file, you have to save the file in the "root" folder of your WordPress installation.', 'adminify'); ?></strong>
            </p>

            <p>
                <?php esc_html_e("Search Engines read a file at yourdomain.com/robots.txt to get information on what they should and shouldn’t check. Adding entries to robots.txt to help SEO is popular misconception. Google says you are welcome to use robots.txt to block parts of your site but these days prefers you don’t.", 'adminify'); ?>
                <br>
                <a href="https://wordpress.org/support/article/search-engine-optimization/#robots-txt-optimization" target="_blank" rel="noopener"><?php esc_html_e('Learn more about the robots.txt file in WordPress.', 'adminify'); ?></a>
            </p>
        </div>

        <?php

        // Get the wp "robots.txt" file
        $file = $this->jltwp_adminify_robots_txt_file();

        // Get the wp "robots.txt" file content
        $file_content = $this->jltwp_adminify_robots_txt_file_content($file);

        if ($file) { ?>
            <p>
                <?php echo esc_html__('robots.txt file was found at:', 'adminify') . ' <strong>' . esc_html($file) . '</strong>'; ?>
                <br>
            </p>
        <?php } ?>

        <textarea id="robots_log_area" class="adminify-info-text-area" readonly><?php echo esc_html($file_content); ?></textarea>



<?php
    }


    function jltwp_adminify_robots_txt_file()
    {

        // Call wp file system
        global $wp_filesystem;
        WP_Filesystem();

        // Get the path of wp "robots.txt" file
        $file = get_home_path() . 'robots.txt';

        // Check if "robots.txt" file exist
        if (
            $wp_filesystem->exists($file)
        ) {
            return $file;
        }

        // File not exist
        return false;
    }



    function jltwp_adminify_robots_txt_file_content($file)
    {

        // Call wp file system
        global $wp_filesystem;
        WP_Filesystem();

        // Show this notice, if no file exist
        $content = esc_html__('robots.txt file not found!', 'adminify');

        // Check if "robots.txt" file exist
        if ($wp_filesystem->exists($file)) {
            $content = $wp_filesystem->get_contents($file);

            // Check if the file content is empty
            if ($wp_filesystem->get_contents($file) == '') {
                $content = esc_html__('File content is empty.', 'adminify');
            }
        }

        return $content;
    }
}
