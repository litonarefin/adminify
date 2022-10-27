<?php

namespace WPAdminify\Inc\Modules\DismissNotices;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettings;
use WPAdminify\Inc\Admin\AdminSettingsModel;


// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WP Adminify
 * Module: Dismiss Admin Notices
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

if (!class_exists('Dismiss_Admin_Notices')) {
    class Dismiss_Admin_Notices extends AdminSettingsModel
    {

        public $saved_notices   = '_wpadminify_admin_saved_notices';
        public $iNoticesAvoided = 0;

        public function __construct()
        {
            $this->saved_notices = get_option($this->saved_notices);
            $this->options = (array) AdminSettings::get_instance()->get();

            $restrict_for = !empty($this->options['admin_notice_user_roles']) ? $this->options['admin_notice_user_roles'] : '';
            if ($restrict_for) {
                return;
            }

            if (is_admin()) {
                // add_action('admin_enqueue_scripts', [$this, 'admin_notice_styles']);
                // add_action('login_enqueue_scripts', [$this, 'admin_notice_styles']);

                if (is_multisite()) {
                    add_action('network_admin_menu',  array($this, 'adminify_dashboard_menu'));
                } else {
                    add_action('admin_menu',  array($this, 'adminify_dashboard_menu'));
                }

                if (!class_exists('DOMDocument')) {
                    return;
                }

                if (!empty($this->options['hide_notices'])) {
                    add_action('admin_notices', [$this, 'jltwp_adminify_notices_loading'], 0);
                    add_action('network_admin_notices', [$this, 'jltwp_adminify_notices_loading'], 0);
                }

                add_action('admin_footer', [$this, 'show_count'], 0);
                add_action('init', [$this, 'remove_notices_user_roles']);
            }
        }

        /**
         * Remove Admin Notices by User roles
         */
        public function remove_notices_user_roles()
        {
            require_once(ABSPATH . '/wp-includes/pluggable.php');
            if (!current_user_can('edit_users')) {
                add_action('admin_notices', [$this, 'no_update_notification'], 1);
            }
        }

        public function no_update_notification()
        {
            remove_action('admin_notices', 'update_nag', 3);
        }

        public function admin_notice_styles()
        {
            require_once(ABSPATH . '/wp-includes/pluggable.php');
            $screen = get_current_screen();
            if ($screen->id !== 'dashboard_page_wp-adminify-notices') {
                if (!current_user_can('manage_options')) {
                    echo '<style>
                    .update-nag, .updated, .error, .notice, .is-dismissible, #e-admin-top-bar-root {
                        display: none;
                    }

                    // Hide Update notifications
                    body.wp-admin .update-plugins, body.wp-admin #wp-admin-bar-updates {display: none !important;}

                    // Hide notices from the wordpress backend
                    body.wp-admin .updated, body.wp-admin .error, body.wp-admin .is-dismissible, body.wp-admin .notice, #yoast-indexation-warning{display: none !important;}
                    body.wp-admin #loco-content .notice, body.wp-admin #loco-notices .notice{display:block !important;}

                    // Hide PHP Updates from the WordPress backend
                    #dashboard_php_nag {display:none;}

                </style>';
                }
            }
        }

        public function jltwp_adminify_store_notices()
        {
            $junk = ob_get_clean();

            if (!$junk) return;

            $dom = new \DOMDocument();
            $junk = mb_convert_encoding($junk, 'HTML-ENTITIES', "UTF-8");
            @$dom->loadHTML($junk);

            $aMatches = array();
            foreach ($dom->getElementsByTagName('div') as $objDiv) {
                if (
                    !$objDiv->hasAttribute('class')
                ) {
                    continue;
                }

                $sHTML = $this->outerHTML($objDiv);

                // simple whitelisting
                $whitelist = array(
                    'Settings updated.',
                    'Your email address has not been updated yet', // core WP email change action
                    'FV Player Pro extension activated', // FV Player
                    'poll ', // Polldaddy Polls & Ratings
                    'admin.php?page=sucuriscan_lastlogins', // Sucuri Security - Auditing, Malware Scanner and Hardening login notice
                    'Your email address has not been updated yet', // Your email address has not been updated yet. Please check your inbox at user@host.com for a confirmation email.

                    // EDD
                    'The purchase receipt has been resent.',
                    'The reports have been refreshed.',
                    'The payment has been created.',
                    'The payment has been deleted.',
                    'The payment has been successfully updated.',
                    'Customer successfully deleted',

                    // edd-per-product-emails
                    'Email added.',
                    'Email updated.',
                    'Test Email Sent.',

                    // Shield Security
                    '[Shield]',

                    // User Switching
                    'Switched to',
                    'Switched back to',

                    // WooCommerce
                    'order status changed',
                    'Removed personal data from',
                    'subscription status changed',

                    // WP Rocket
                    'Critical CSS generation',
                    'Post cache cleared.',
                    'Cache cleared.',
                    'Preload: ',
                    'Preload complete: ',
                    'One or more plugins have been enabled or disabled',
                );

                $skip = false;
                foreach ($whitelist as $rule) {
                    if (stripos($sHTML, $rule) !== false) {
                        $skip = true;
                    }
                }

                // special rules, bbPress actions
                if (stripos($sHTML, 'Topic "') !== false && preg_match('~successfully (un)?marked as~', $sHTML)) {
                    $skip = true;
                }

                if ($skip) continue;

                $aClass = explode(' ', $objDiv->getAttribute('class'));

                if (in_array('notice', $aClass)) {
                    $aMatches[] = $sHTML;
                }

                if (in_array('error', $aClass)) {
                    $aMatches[] = $sHTML;
                }

                if (in_array('updated', $aClass)) {
                    $aMatches[] = $sHTML;
                }

                if (in_array('update-nag', $aClass)) {
                    $aMatches[] = $sHTML;
                }
            }

            $aStored = $this->get_data();
            $aNew = $aStored;
            if (count($aMatches) > 0) {
                foreach ($aMatches as $sNotice) {

                    $check_one = $this->prepare_compare($sNotice);

                    $bSkip = false;
                    foreach ($aStored as $key => $aNotice) {
                        $notice_html = !empty($aNotice['html']) ? $aNotice['html'] : '';
                        $check_two = $this->prepare_compare($notice_html);

                        if ($check_one == $check_two) {  //  if the notice is already recorded
                            if (isset($aNotice['dismissed']) && $aNotice['dismissed']) { //  and it's dismissed, then record it again
                                unset($aNew[$key]);
                            } else {  //  if it's already recorded and not dismissed, do nothing
                                $bSkip = true;
                                break;
                            }
                        }
                    }

                    if (!$bSkip) {
                        $aNew[] = array('time' => time(), 'html' => $sNotice);
                    }
                }

                $this->save($aNew);
            }

            // Woocommerce Products pages page broken issue fix
            $started_divs = substr_count($junk, '<div');
            $ended_divs = substr_count($junk, '</div>');

            if ($started_divs < $ended_divs) {
                $add_extra = $ended_divs - $started_divs;
                while ($add_extra) {
                    echo '</div>';
                    --$add_extra;
                }
            }
            // Fix end

        }

        public function get_count()
        {
            $aStored = $this->get_data();
            foreach ($aStored as $aNotice) {
                if (
                    !isset($aNotice['dismissed']) || $aNotice['dismissed'] == false
                ) {
                    $this->iNoticesAvoided++;
                }
            }
            return $this->iNoticesAvoided;
        }

        public function show_count()
        {
            $this->get_count();

            if ($this->iNoticesAvoided == 0) return;
?>
            <script>
                (function($) {
                    var count = <?php echo $this->iNoticesAvoided; ?>;
                    $('[href="index.php?page=wp-adminify-notices"]').append('<span class="update-plugins count-' + count + '"><span class="update-count">' + count + '</span></span>');
                })(jQuery);
            </script>
        <?php
        }

        public function jltwp_adminify_notices_loading()
        {
            ob_start();
            add_action('all_admin_notices', [$this, 'jltwp_adminify_store_notices'], 999999999999);
        }

        public function adminify_dashboard_menu()
        {
            add_dashboard_page('Notices', 'Notices', 'manage_options', 'wp-adminify-notices', [$this, 'adminify_notice_contents']);
        }

        public function adminify_notice_contents()
        {
            if (isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'wp_adminify_notice_dismiss')) {
                if (isset($_GET['dismiss'])) {

                    $aStored = $this->get_data();

                    foreach ($aStored as $k => $v) {
                        if ($aStored[$k]['reversed_key'] == intval($_GET['dismiss'])) {
                            $aStored[$k]['dismissed'] = true;
                        }
                    }
                    $this->save($aStored);
                    echo "<div class='updated'><p>Notice marked as dismissed. If it keeps coming back, we recommend that you fix the issue that is causing it or <a href='https://wpadminify.com/contact-us' target='_blank'>let us know about it</a>.</p></div>";
                }
            }

        ?>
            <style>
                .wp-adminify-notices .notice-dismiss {
                    display: none
                }
            </style>
            <div class="wrap">
                <div class="wp-adminify-notices">
                    <?php $aStored = $this->get_data();
                    $sAdminURL = is_network_admin() ? network_admin_url('wp-admin/network/index.php?page=wp-adminify-notices') : admin_url('admin.php?page=wp-adminify-notices');
                    ?>
                    <h3>
                        <?php _e('New Notices', 'adminify'); ?>
                    </h3>
                    <p>
                        <?php _e('Notices generated by date and time when it\'s been created, you can dismiss them', 'adminify'); ?>
                    </p>
                    <?php
                    $iNew = 0;
                    foreach ($aStored as $key => $aNotice) {
                        if (isset($aNotice['dismissed']) && $aNotice['dismissed']) continue;

                        $iNew++;
                        $sDismiss = (!isset($aNotice['dismissed']) || $aNotice['dismissed'] == false) ? " - <a href='" . wp_nonce_url($sAdminURL, 'wp_adminify_notice_dismiss') . "&dismiss=" . $aNotice['reversed_key'] . "'>" . __('Dismiss Now', 'adminify') . "</a>" : false;

                        echo '<div class="wp-adminify-notice-container">';
                    ?>
                        <p>
                            <?php if ($sDismiss) : ?><strong><?php endif; ?>
                                <?php if (isset($aNotice['time'])) {
                                    echo date('Y-m-d h:m:s', $aNotice['time']);
                                } ?>
                                <?php if ($sDismiss) : ?></strong><?php endif; ?>
                            <?php echo $sDismiss; ?>
                        </p>
                    <?php if (isset($aNotice['html'])) {
                            echo $aNotice['html'];
                        }
                        echo '</div>';
                    }

                    if ($iNew == 0) _e('There\'s no new notices.', 'adminify');
                    ?>


                    <h3 style="padding-top:30px;">
                        <?php _e('Dismissed Notices', 'adminify'); ?>
                    </h3>

                    <?php

                    $iViewed = 0;
                    foreach ($aStored as $key => $aNotice) {
                        if (!isset($aNotice['dismissed']) || $aNotice['dismissed'] == false) continue;

                        $iViewed++;
                    ?>
                        <p>
                            <?php
                            if (isset($aNotice['time'])) {
                                echo date('Y-m-d h:m:s', $aNotice['time']);
                            }
                            ?>
                        </p>
                    <?php
                        if (isset($aNotice['html'])) {
                            echo $aNotice['html'];
                        }
                    }

                    if ($iViewed == 0) _e('No dismissed notices.', 'adminify')
                    ?>
                </div>
            </div>
<?php
        }

        public function prepare_compare($html)
        {
            $html = preg_replace('~nonce=[0-9a-z_-]+~', '', $html);
            $html = preg_replace('~[^A-Za-z0-9]~', '', strip_tags($html));
            return $html;
        }

        public function outerHTML($e)
        {
            $doc = new \DOMDocument();
            $doc->appendChild($doc->importNode($e, true));
            return $doc->saveHTML();
        }

        public function save($aNotices)
        {
            update_option('_wpadminify_admin_saved_notices', $aNotices);
        }

        public function get_data()
        {
            $aNotices = (array) $this->saved_notices;

            // sort oldest to newest
            usort($aNotices, [$this, 'sort_notices']);

            $count = 0;
            foreach ($aNotices as $k => $v) {
                $aNotices[$k]['reversed_key'] = $count;
                $count++;
            }

            // finally sort newest to oldest
            $aNotices = array_reverse($aNotices);

            return $aNotices;
        }

        public function sort_notices($a, $b)
        {
            $a_time = !empty($a['time']) ? $a['time'] : 0;
            $b_time = !empty($b['time']) ? $b['time'] : 0;

            if ($a_time < $b_time) return -1;
            if ($a_time == $b_time) return 0;
            if ($a_time > $b_time) return 1;
        }
    }
}
