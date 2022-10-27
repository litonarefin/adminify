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

class ServerInfo_Constant_Details
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
                <?php echo Utils::admin_page_title(esc_html__('WordPress Constants', 'adminify')); ?>
            </h1>
        </div>

        <p><?php echo __('Use the following constants to manage important settings of your WordPress installation in the <code>wp-config.php</code> file. Learn more about <a href="https://wordpress.org/support/article/editing-wp-config-php/" target="_blank" rel="noopener">here</a>', 'adminify'); ?>.</p>

        <table class="wp-list-table widefat posts mt-6">
            <thead>
                <tr>
                    <th class="manage-column"><?php esc_html_e('Info', 'adminify'); ?></th>
                    <th class="manage-column"><?php esc_html_e('Result', 'adminify'); ?></th>
                    <th class="manage-column"><?php echo esc_html__('Example', 'adminify'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php esc_html_e('WP Language', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#language-and-language-directory" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('WPLANG') && WPLANG) :
                            echo WPLANG;
                        else :
                            echo $not_entered . ' / ' . get_locale();
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WPLANG', 'de_DE' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Force SSL Admin', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#require-ssl-for-admin-and-logins" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('FORCE_SSL_ADMIN') && true === FORCE_SSL_ADMIN) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'FORCE_SSL_ADMIN', true );"; ?></code></td>
                </tr>
                <tr class="table-border-top">
                    <td><?php esc_html_e('WP PHP Memory Limit', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#increasing-memory-allocated-to-php" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (WP_MEMORY_LIMIT == '-1') {
                            echo '-1 / ' . esc_html__('Unlimited', 'adminify');
                        } else {
                            echo (int)WP_MEMORY_LIMIT . ' MB';
                        }
                        echo ' (' . esc_html__('defined limit', 'adminify') . ')';

                        if ((int)WP_MEMORY_LIMIT < (int)ini_get('memory_limit') && WP_MEMORY_LIMIT != '-1') {
                            echo ' <span class="warning"><span class="dashicons dashicons-warning"></span> ' . sprintf(__('The WP PHP Memory Limit is less than the %s Server PHP Memory Limit', 'adminify'), (int)ini_get('memory_limit') . ' MB') . '!</span>';
                        } ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_MEMORY_LIMIT', '64M' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP PHP Max Memory Limit', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#increasing-memory-allocated-to-php" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (WP_MAX_MEMORY_LIMIT == '-1') {
                            echo '-1 / ' . esc_html__('Unlimited', 'adminify');
                        } else {
                            echo (int)WP_MAX_MEMORY_LIMIT . ' MB';
                        }
                        echo ' (' . esc_html__('defined limit', 'adminify') . ')'; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_MAX_MEMORY_LIMIT', '256M' );"; ?></code></td>
                </tr>
                <tr class="table-border-top">
                    <td><?php esc_html_e('WP Post Revisions', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#disable-post-revisions" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('WP_POST_REVISIONS') && WP_POST_REVISIONS == false) {
                            esc_html_e('Disabled', 'adminify');
                        } else {
                            echo WP_POST_REVISIONS;
                        } ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_POST_REVISIONS', false );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Autosave Interval', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#modify-autosave-interval" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('AUTOSAVE_INTERVAL') && AUTOSAVE_INTERVAL) :
                            echo AUTOSAVE_INTERVAL . ' ' . esc_html__('Seconds', 'adminify');
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'AUTOSAVE_INTERVAL', 160 );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Mail Interval', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('WP_MAIL_INTERVAL') && WP_MAIL_INTERVAL) :
                            echo WP_MAIL_INTERVAL . ' ' . esc_html__('Seconds', 'adminify');
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_MAIL_INTERVAL', 60 );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Empty Trash', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#empty-trash" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (EMPTY_TRASH_DAYS == 0) {
                            echo $disabled;
                        } else {
                            echo EMPTY_TRASH_DAYS . ' ' . 'Days';
                        } ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'EMPTY_TRASH_DAYS', 30 );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Media Trash', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('MEDIA_TRASH') && true === MEDIA_TRASH) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'MEDIA_TRASH', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Cleanup Image Edits', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#cleanup-image-edits" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('IMAGE_EDIT_OVERWRITE') && true === IMAGE_EDIT_OVERWRITE) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'IMAGE_EDIT_OVERWRITE', true );"; ?></code></td>
                </tr>
                <tr class="table-border-top">
                    <td><?php esc_html_e('WP Multisite', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#enable-multisite-network-ability" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('WP_ALLOW_MULTISITE') && true === WP_ALLOW_MULTISITE) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_ALLOW_MULTISITE', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Main Site Domain', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('DOMAIN_CURRENT_SITE') && DOMAIN_CURRENT_SITE) :
                            echo DOMAIN_CURRENT_SITE;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'DOMAIN_CURRENT_SITE', 'www.domain.com' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Main Site Path', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('PATH_CURRENT_SITE') && PATH_CURRENT_SITE) :
                            echo PATH_CURRENT_SITE;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'PATH_CURRENT_SITE', '/path/to/wordpress/' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Main Site ID', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('SITE_ID_CURRENT_SITE') && SITE_ID_CURRENT_SITE) :
                            echo SITE_ID_CURRENT_SITE;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'SITE_ID_CURRENT_SITE', 1 );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Main Site Blog ID', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('BLOG_ID_CURRENT_SITE') && BLOG_ID_CURRENT_SITE) :
                            echo BLOG_ID_CURRENT_SITE;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'BLOG_ID_CURRENT_SITE', 1 );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Allow Subdomain Install', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('SUBDOMAIN_INSTALL') && true === SUBDOMAIN_INSTALL) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'SUBDOMAIN_INSTALL', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Allow Subdirectory Install', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('ALLOW_SUBDIRECTORY_INSTALL') && true === ALLOW_SUBDIRECTORY_INSTALL) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'ALLOW_SUBDIRECTORY_INSTALL', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Site Specific Upload Directory', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('BLOGUPLOADDIR') && BLOGUPLOADDIR) :
                            echo BLOGUPLOADDIR;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'BLOGUPLOADDIR', '' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Upload Base Directory', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('UPLOADBLOGSDIR') && UPLOADBLOGSDIR) :
                            echo UPLOADBLOGSDIR;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'UPLOADBLOGSDIR', 'wp-content/blogs.dir' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Load Sunrise', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('SUNRISE') && true === SUNRISE) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'SUNRISE', true );"; ?></code></td>
                </tr>
                <tr class="table-border-top">
                    <td><?php esc_html_e('WP Debug Mode', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#wp_debug" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('WP_DEBUG') && WP_DEBUG) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_DEBUG', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Debug Log', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#wp_debug" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_DEBUG_LOG', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Debug Display', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#wp_debug" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_DEBUG_DISPLAY', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Script Debug', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#script_debug" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'SCRIPT_DEBUG', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Save Queries', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#save-queries-for-analysis" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('SAVEQUERIES') && SAVEQUERIES) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'SAVEQUERIES', true );"; ?></code></td>
                </tr>
                <tr class="table-border-top">
                    <td><?php esc_html_e('WP Automatic Updates', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#disable-wordpress-auto-updates" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('AUTOMATIC_UPDATER_DISABLED') && AUTOMATIC_UPDATER_DISABLED) :
                            echo $disabled;
                        else :
                            echo $enabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'AUTOMATIC_UPDATER_DISABLED', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Core Updates', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#disable-wordpress-core-updates" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('WP_AUTO_UPDATE_CORE') && false === WP_AUTO_UPDATE_CORE) :
                            echo $disabled;
                        elseif (defined('WP_AUTO_UPDATE_CORE') && 'minor' === WP_AUTO_UPDATE_CORE) :
                            echo $enabled . ' / <span class="error"><span class="dashicons dashicons-warning"></span> ' . esc_html__('Only for minor updates', 'adminify') . '</span>';
                        else :
                            echo $enabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_AUTO_UPDATE_CORE', false );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Default Theme Updates', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('CORE_UPGRADE_SKIP_NEW_BUNDLED') && true === CORE_UPGRADE_SKIP_NEW_BUNDLED) :
                            echo $disabled;
                        else :
                            echo $enabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'CORE_UPGRADE_SKIP_NEW_BUNDLED', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Plugin and Theme Editor', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#disable-the-plugin-and-theme-editor" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('DISALLOW_FILE_EDIT') && true === DISALLOW_FILE_EDIT) :
                            echo $disabled;
                        else :
                            echo $enabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'DISALLOW_FILE_EDIT', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Plugin and Theme Updates', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#disable-plugin-and-theme-update-and-installation" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('DISALLOW_FILE_MODS') && true === DISALLOW_FILE_MODS) :
                            echo $disabled;
                        else :
                            echo $enabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'DISALLOW_FILE_MODS', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Default Theme', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('WP_DEFAULT_THEME') && WP_DEFAULT_THEME) :
                            echo WP_DEFAULT_THEME;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_DEFAULT_THEME', 'default-theme-folder-name' );" ?></td>
                </tr>
                <tr class="table-border-top">
                    <td><?php esc_html_e('WP Alternate Cron', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#alternative-cron" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('ALTERNATE_WP_CRON') && true === ALTERNATE_WP_CRON) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'ALTERNATE_WP_CRON', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Cron', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#disable-cron-and-cron-timeout" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('DISABLE_WP_CRON') && DISABLE_WP_CRON) :
                            echo $disabled;
                        else :
                            echo $enabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'DISABLE_WP_CRON', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Cron Lock Timeout', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#disable-cron-and-cron-timeout" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('WP_CRON_LOCK_TIMEOUT') && WP_CRON_LOCK_TIMEOUT) :
                            echo WP_CRON_LOCK_TIMEOUT . ' ' . esc_html__('Seconds', 'adminify');
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_CRON_LOCK_TIMEOUT', 60 );"; ?></code></td>
                </tr>
                <tr class="table-border-top">
                    <td><?php esc_html_e('WP Cache', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#cache" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('WP_CACHE') && true === WP_CACHE) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_CACHE', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Concatenate Admin JS/CSS', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#disable-javascript-concatenation" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('CONCATENATE_SCRIPTS') && false === CONCATENATE_SCRIPTS || true === SCRIPT_DEBUG) :
                            echo $disabled;
                            if (true === SCRIPT_DEBUG) :
                                echo ' / <span class="warning"><span class="dashicons dashicons-warning"></span> ' . esc_html__('Not available if WP Script Debug is true', 'adminify') . '</span>';
                            endif;
                        else :
                            echo $enabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'CONCATENATE_SCRIPTS', false );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Compress Admin JS', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('COMPRESS_SCRIPTS') && false === COMPRESS_SCRIPTS || true === SCRIPT_DEBUG) :
                            echo $disabled;
                            if (true === SCRIPT_DEBUG) :
                                echo ' / <span class="warning"><span class="dashicons dashicons-warning"></span> ' . esc_html__('Not available if WP Script Debug is true', 'adminify') . '</span>';
                            endif;
                        else :
                            echo $enabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'COMPRESS_SCRIPTS', false );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Compress Admin CSS', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('COMPRESS_CSS') && false === COMPRESS_CSS || true === SCRIPT_DEBUG) :
                            echo $disabled;
                            if (true === SCRIPT_DEBUG) :
                                echo ' / <span class="warning"><span class="dashicons dashicons-warning"></span> ' . esc_html__('Not available if WP Script Debug is true', 'adminify') . '</span>';
                            endif;
                        else :
                            echo $enabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'COMPRESS_CSS', false );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Enforce GZip Admin JS/CSS', 'adminify'); ?>:</td>
                    <td>
                        <?php if (!defined('ENFORCE_GZIP') || defined('ENFORCE_GZIP') && false === ENFORCE_GZIP || true === SCRIPT_DEBUG) :
                            echo $disabled;
                            if (true === SCRIPT_DEBUG) :
                                echo ' / <span class="warning"><span class="dashicons dashicons-warning"></span> ' . esc_html__('Not available if WP Script Debug is true', 'adminify') . '</span>';
                            endif;
                        else :
                            echo $enabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'ENFORCE_GZIP', true );"; ?></code></td>
                </tr>
                <tr class="table-border-top">
                    <td><?php esc_html_e('WP Allow unfiltered HTML', 'adminify'); ?>: <a href="https://codex.wordpress.org/Editing_wp-config.php#Disable_unfiltered_HTML_for_all_users" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('DISALLOW_UNFILTERED_HTML') && true === DISALLOW_UNFILTERED_HTML) :
                            echo $disabled . ' ' . esc_html__('for all users', 'adminify');
                        else :
                            echo $enabled . ' ' . esc_html__('for users with administrator or editor roles', 'adminify');
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'DISALLOW_UNFILTERED_HTML', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Allow unfiltered Uploads', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('ALLOW_UNFILTERED_UPLOADS') && true === ALLOW_UNFILTERED_UPLOADS) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'ALLOW_UNFILTERED_UPLOADS', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Block External URL Requests', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#block-external-url-requests" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('WP_HTTP_BLOCK_EXTERNAL') && true === WP_HTTP_BLOCK_EXTERNAL) :
                            echo $enabled;
                            if (defined('WP_ACCESSIBLE_HOSTS')) :
                                echo ' / ' . esc_html__('Accessible Hosts', 'adminify') . ': ' . WP_ACCESSIBLE_HOSTS;
                            endif;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_HTTP_BLOCK_EXTERNAL', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Redirect Nonexistent Blogs', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#redirect-nonexistent-blogs" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('NOBLOGREDIRECT') && NOBLOGREDIRECT != '') :
                            echo NOBLOGREDIRECT;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'NOBLOGREDIRECT', 'http://example.com' );"; ?></code></td>
                </tr>
                <tr class="table-border-top">
                    <td><?php esc_html_e('WP Cookie Domain', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#set-cookie-domain" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('COOKIE_DOMAIN') && COOKIE_DOMAIN != '') :
                            echo COOKIE_DOMAIN;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'COOKIE_DOMAIN', 'www.example.com' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Cookie Hash', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('COOKIEHASH') && COOKIEHASH) :
                            echo COOKIEHASH;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'COOKIEHASH', '' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Auth Cookie', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('AUTH_COOKIE') && AUTH_COOKIE) :
                            echo AUTH_COOKIE;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'AUTH_COOKIE', '' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Secure Auth Cookie', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('SECURE_AUTH_COOKIE') && SECURE_AUTH_COOKIE) :
                            echo SECURE_AUTH_COOKIE;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'SECURE_AUTH_COOKIE', '' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Cookie Path', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#additional-defined-constants" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('COOKIEPATH') && COOKIEPATH) :
                            echo COOKIEPATH;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'COOKIEPATH', '' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Site Cookie Path', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#additional-defined-constants" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('SITECOOKIEPATH') && SITECOOKIEPATH) :
                            echo SITECOOKIEPATH;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'SITECOOKIEPATH', '' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Admin Cookie Path', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#additional-defined-constants" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('ADMIN_COOKIE_PATH') && ADMIN_COOKIE_PATH) :
                            echo ADMIN_COOKIE_PATH;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'ADMIN_COOKIE_PATH', '' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Plugins Cookie Path', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#additional-defined-constants" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('PLUGINS_COOKIE_PATH') && PLUGINS_COOKIE_PATH) :
                            echo PLUGINS_COOKIE_PATH;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'PLUGINS_COOKIE_PATH', '' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Logged In Cookie', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('LOGGED_IN_COOKIE') && LOGGED_IN_COOKIE) :
                            echo LOGGED_IN_COOKIE;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'LOGGED_IN_COOKIE', '' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Test Cookie', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('TEST_COOKIE') && TEST_COOKIE) :
                            echo TEST_COOKIE;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'TEST_COOKIE', '' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP User Cookie', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('USER_COOKIE') && USER_COOKIE) :
                            echo USER_COOKIE;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'USER_COOKIE', '' );"; ?></code></td>
                </tr>
                <tr class="table-border-top">
                    <td><?php esc_html_e('WP Directory Permission', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#override-of-default-file-permissions" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('FS_CHMOD_DIR') && FS_CHMOD_DIR) :
                            echo 'chmod' . ' ' . FS_CHMOD_DIR;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'FS_CHMOD_DIR', ( 0755 & ~ umask() ) );" ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP File Permission', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#override-of-default-file-permissions" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('FS_CHMOD_FILE') && FS_CHMOD_FILE) :
                            echo 'chmod' . ' ' . FS_CHMOD_FILE;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'FS_CHMOD_FILE', ( 0644 & ~ umask() ) );" ?></td>
                </tr>
                <tr class="table-border-top">
                    <td><?php esc_html_e('WP FTP Method', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#wordpress-upgrade-constants" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('FS_METHOD') && FS_METHOD) :
                            echo FS_METHOD;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'FS_METHOD', 'ftpext' );" ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP FTP Base', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#wordpress-upgrade-constants" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('FTP_BASE') && FTP_BASE) :
                            echo FTP_BASE;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'FTP_BASE', '/path/to/wordpress/' );" ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP FTP Content Dir', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#wordpress-upgrade-constants" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('FTP_CONTENT_DIR') && FTP_CONTENT_DIR) :
                            echo FTP_CONTENT_DIR;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'FTP_CONTENT_DIR', '/path/to/wordpress/wp-content/' );" ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP FTP Plugin Dir', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#wordpress-upgrade-constants" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('FTP_PLUGIN_DIR') && FTP_PLUGIN_DIR) :
                            echo FTP_PLUGIN_DIR;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'FTP_PLUGIN_DIR ', '/path/to/wordpress/wp-content/plugins/' );" ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP SSH Public Key', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#wordpress-upgrade-constants" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('FTP_PUBKEY') && FTP_PUBKEY) :
                            echo FTP_PUBKEY;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'FTP_PUBKEY', '/home/username/.ssh/id_rsa.pub' );" ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP SSH Private Key', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#wordpress-upgrade-constants" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('FTP_PRIKEY') && FTP_PRIKEY) :
                            echo FTP_PRIKEY;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'FTP_PRIKEY', '/home/username/.ssh/id_rsa' );" ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP FTP Username', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#wordpress-upgrade-constants" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('FTP_USER') && FTP_USER) :
                            echo FTP_USER;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'FTP_USER', 'username' );" ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP FTP Password', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#wordpress-upgrade-constants" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('FTP_PASS') && FTP_PASS) :
                            echo '****';
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'FTP_PASS', 'password' );" ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP FTP Host', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#wordpress-upgrade-constants" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('FTP_HOST') && FTP_HOST) :
                            echo FTP_HOST;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'FTP_HOST', 'ftp.example.org' );" ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP FTP SSL', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#wordpress-upgrade-constants" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('FTP_SSL') && true === FTP_SSL) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'FTP_SSL', false );" ?></td>
                </tr>
                <tr class="table-border-top">
                    <td><?php esc_html_e('WP Site URL', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#wp_siteurl" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('WP_SITEURL') && WP_SITEURL) :
                            echo WP_SITEURL;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_SITEURL', 'http://example.com/wordpress' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Home', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#blog-address-url" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('WP_HOME') && WP_HOME) :
                            echo WP_HOME;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_HOME', 'http://example.com' );"; ?></code></td>
                </tr>
                <tr class="table-border-top">
                    <td><?php esc_html_e('WP Uploads Path', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#moving-uploads-folder" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('UPLOADS') && '' != UPLOADS) :
                            echo UPLOADS;
                        else :
                            $upload_dir = wp_upload_dir();
                            echo $upload_dir['basedir'];
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'UPLOADS', dirname(__FILE__) . 'wp-content/media' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Template Path', 'adminify'); ?>:</td>
                    <td>
                        <?php echo TEMPLATEPATH; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'TEMPLATEPATH', dirname(__FILE__) . 'wp-content/themes/theme-folder' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Stylesheet Path', 'adminify'); ?>:</td>
                    <td>
                        <?php echo STYLESHEETPATH; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'STYLESHEETPATH', dirname(__FILE__) . 'wp-content/themes/theme-folder' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Content Path', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#moving-wp-content-folder" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php echo WP_CONTENT_DIR; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_CONTENT_DIR', dirname(__FILE__) . '/blog/wp-content' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Content URL', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#moving-wp-content-folder" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php echo WP_CONTENT_URL; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_CONTENT_URL', 'http://example/blog/wp-content' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Plugin Path', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#moving-plugin-folder" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php echo WP_PLUGIN_DIR; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_PLUGIN_DIR', dirname(__FILE__) . '/blog/wp-content/plugins' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Plugin URL', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#moving-plugin-folder" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php echo WP_PLUGIN_URL; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_PLUGIN_URL', 'http://example/blog/wp-content/plugins' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Language Path', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#language-and-language-directory" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php echo WP_LANG_DIR; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_LANG_DIR', dirname(__FILE__) . '/wordpress/languages' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Temporary Files Path', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('WP_TEMP_DIR') && '' != WP_TEMP_DIR) :
                            echo WP_TEMP_DIR;
                        else :
                            echo get_temp_dir();
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_TEMP_DIR', dirname(__FILE__) . 'wp-content/temp' );"; ?></code></td>
                </tr>
            </tbody>
        </table>

        <h2 class="mb-0 mt-6"><?php echo esc_html__('Database', 'adminify'); ?></h2>

        <p class="mb-4"><?php echo __('Use the following constants to manage important database settings of your WordPress installation in the <code>wp-config.php</code> file. Learn more about <a href="https://wordpress.org/support/article/editing-wp-config-php/#configure-database-settings" target="_blank">here</a>', 'adminify'); ?>.</p>

        <table class="wp-list-table widefat posts mt-5">
            <thead>
                <tr>
                    <th class="manage-column"><?php echo esc_html__('Info', 'adminify'); ?></th>
                    <th class="manage-column"><?php echo esc_html__('Result', 'adminify'); ?></th>
                    <th class="manage-column"><?php echo esc_html__('Example', 'adminify'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php esc_html_e('MySQL Version', 'adminify'); ?>:</td>
                    <td colspan="2"><?php echo $server_info->get_mysql_version(); ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('DB Name', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#set-database-name" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td><?php echo DB_NAME; ?></td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'DB_NAME', 'MyDatabaseName' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('DB User', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#set-database-user" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td><?php echo DB_USER; ?></td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'DB_USER', 'MyUserName' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('DB Host', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#set-database-host" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td><?php echo DB_HOST; ?></td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'DB_HOST', 'MyDatabaseHost' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('DB Password', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#set-database-password" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td><?php echo '***'; ?></td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'DB_PASSWORD', 'MyPassWord' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('DB Charset', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#database-character-set" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td><?php echo DB_CHARSET; ?></td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'DB_CHARSET', 'utf8' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('DB Collate', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#database-collation" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('DB_COLLATE') && empty(DB_COLLATE)) {
                            echo $not_entered;
                        } else {
                            echo DB_COLLATE;
                        } ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'DB_COLLATE', 'utf8_general_ci' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Allow DB Repair', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#automatic-database-optimizing" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('WP_ALLOW_REPAIR') && WP_ALLOW_REPAIR) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'WP_ALLOW_REPAIR', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Disallow Upgrade Global Tables', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#do_not_upgrade_global_tables" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('DO_NOT_UPGRADE_GLOBAL_TABLES') && true === DO_NOT_UPGRADE_GLOBAL_TABLES) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'DO_NOT_UPGRADE_GLOBAL_TABLES', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Custom User Table', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#custom-user-and-usermeta-tables" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('CUSTOM_USER_TABLE') && CUSTOM_USER_TABLE) :
                            echo CUSTOM_USER_TABLE;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'CUSTOM_USER_TABLE', &dollar;table_prefix.'my_users' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Custom User Meta Table', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#custom-user-and-usermeta-tables" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (defined('CUSTOM_USER_META_TABLE') && CUSTOM_USER_META_TABLE) :
                            echo CUSTOM_USER_META_TABLE;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"> <?php echo "define( 'CUSTOM_USER_META_TABLE', &dollar;table_prefix.'my_usermeta' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Display Database Errors', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('DIEONDBERROR') && true === DIEONDBERROR) :
                            echo $enabled;
                        else :
                            echo $disabled;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"><?php echo "define( 'DIEONDBERROR', true );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Database Error Log File', 'adminify'); ?>:</td>
                    <td>
                        <?php if (defined('ERRORLOGFILE') && ERRORLOGFILE) :
                            echo ERRORLOGFILE;
                        else :
                            echo $not_entered;
                        endif; ?>
                    </td>
                    <td><code class="is-pulled-left p-2"><?php echo "define( 'ERRORLOGFILE', '/absolute-path-to-file/' );"; ?></code></td>
                </tr>
                <tr class="table-border-top">
                    <td><?php esc_html_e('Table Prefix', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#table_prefix" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td colspan="2"><?php echo $server_info->get_table_prefix()['tablePrefix']; ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('Table Base Prefix', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#table_prefix" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td colspan="2"><?php echo $server_info->get_table_prefix()['tableBasePrefix'] . ' (' . esc_html__('defined', 'adminify') . ')'; ?></td>
                </tr>
            </tbody>
        </table>

        <h2 class="mb-0 mt-6"><?php echo esc_html__('Security Keys', 'adminify'); ?></h2>

        <p class="mb-4"><?php echo __('Use the following constants to set the security keys for your WordPress installation in the <code>wp-config.php</code> file. Learn more about <a href="https://wordpress.org/support/article/editing-wp-config-php/#security-keys" target="_blank" rel="noopener">here</a>', 'adminify'); ?>.</p>

        <table class="wp-list-table widefat posts mt-5">
            <thead>
                <tr>
                    <th class="manage-column"><?php echo esc_html__('Info', 'adminify'); ?></th>
                    <th class="manage-column"><?php echo esc_html__('Result', 'adminify'); ?></th>
                    <th class="manage-column"><?php echo esc_html__('Example', 'adminify'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php esc_html_e('WP Auth Key', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#security-keys" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (empty(AUTH_KEY)) {
                            echo $sec_key;
                        } else {
                            echo $entered;
                        } ?>
                    </td>
                    <td><code class="is-pulled-left p-2"><?php echo "define( 'AUTH_KEY', 'MyKey' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Secure Auth Key', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#security-keys" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (empty(SECURE_AUTH_KEY)) {
                            echo $sec_key;
                        } else {
                            echo $entered;
                        } ?>
                    </td>
                    <td><code class="is-pulled-left p-2"><?php echo "define( 'SECURE_AUTH_KEY', 'MyKey' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Logged In Key', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#security-keys" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (empty(LOGGED_IN_KEY)) {
                            echo $sec_key;
                        } else {
                            echo $entered;
                        } ?>
                    </td>
                    <td><code class="is-pulled-left p-2"><?php echo "define( 'LOGGED_IN_KEY', 'MyKey' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Nonce Key', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#security-keys" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (empty(NONCE_KEY)) {
                            echo $sec_key;
                        } else {
                            echo $entered;
                        } ?>
                    </td>
                    <td><code class="is-pulled-left p-2"><?php echo "define( 'NONCE_KEY', 'MyKey' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Auth Salt', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#security-keys" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (empty(AUTH_SALT)) {
                            echo $sec_key;
                        } else {
                            echo $entered;
                        } ?>
                    </td>
                    <td><code class="is-pulled-left p-2"><?php echo "define( 'AUTH_SALT', 'MyKey' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Secure Auth Salt', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#security-keys" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (empty(SECURE_AUTH_SALT)) {
                            echo $sec_key;
                        } else {
                            echo $entered;
                        } ?>
                    </td>
                    <td><code class="is-pulled-left p-2"><?php echo "define( 'SECURE_AUTH_SALT', 'MyKey' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Logged In Auth Salt', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#security-keys" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (empty(LOGGED_IN_SALT)) {
                            echo $sec_key;
                        } else {
                            echo $entered;
                        } ?>
                    </td>
                    <td><code class="is-pulled-left p-2"><?php echo "define( 'LOGGED_IN_SALT', 'MyKey' );"; ?></code></td>
                </tr>
                <tr>
                    <td><?php esc_html_e('WP Nonce Salt', 'adminify'); ?>: <a href="https://wordpress.org/support/article/editing-wp-config-php/#security-keys" target="_blank" rel="noopener"><?php echo $help; ?></a></td>
                    <td>
                        <?php if (empty(NONCE_SALT)) {
                            echo $sec_key;
                        } else {
                            echo $entered;;
                        } ?>
                    </td>
                    <td><code class="is-pulled-left p-2"><?php echo "define( 'NONCE_SALT', 'MyKey' );"; ?></code></td>
                </tr>
            </tbody>
        </table>

<?php }
}
