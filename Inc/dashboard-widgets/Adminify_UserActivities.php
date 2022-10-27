<?php

namespace WPAdminify\Inc\DashboardWidgets;
// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * User Activities Dashboard Widget
 *
 * @return void
 */
/**
 * WPAdminify
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class Adminify_UserActivities
{
    public function __construct()
    {
        add_action('wp_dashboard_setup', [$this, 'jltwp_adminify_user_activities']);
        add_action('auth_cookie_expired', [$this, 'jltwp_adminify_auth_cookie_expired'], 10, 1);
        add_action('admin_init', [$this, 'jltwp_adminify_first_login_status'], 1);
        add_action('wp_login', [$this, 'jltwp_adminify_last_user_login'], 10, 2);
    }


    /**
     * Label: User Activities
     *
     * @return void
     */
    public function jltwp_adminify_user_activities()
    {
        wp_add_dashboard_widget(
            'jltwp_adminify_dash_user_activities',
            esc_html__('User Activities - Adminify', 'adminify'),
            [$this, 'jltwp_adminify_user_activities_details']
        );
    }

    /**
     * Cookie Expired
     */
    public function jltwp_adminify_auth_cookie_expired($user)
    {

        $user = get_user_by('login', $user['username']);

        if ($user) {

            // Update user last logout date/time
            update_user_meta($user->ID, '_last_logout', $this->jltwp_adminify_set_date_time());

            // Update user login status to logged out
            update_user_meta($user->ID, '_logged_in', 0);
        }
    }

    /**
     * Set Date Time
     */
    public function jltwp_adminify_set_date_time()
    {

        // Update user last login date/time
        $timezone_string = get_option('timezone_string');
        if (!empty($timezone_string)) {
            date_default_timezone_set($timezone_string); // --> Set default timezone by wp settings
        }

        // Get date / time in wp format
        $date = date_i18n(get_option('date_format'), strtotime(date('Y-m-d', current_time('timestamp', 1))));
        $time = date_i18n(get_option('time_format'), strtotime(date('H:i:s', current_time('timestamp', 1))));

        return $date . ' ' . $time;
    }

    /**
     * First login status
     *
     * @return void
     */
    public function jltwp_adminify_first_login_status()
    {
        // Get current logged in user ID
        $current_user = wp_get_current_user();

        // Check if user login status is false
        if (get_user_meta($current_user->ID, '_logged_in', true)) {
            // update user login status to logged in
            update_user_meta($current_user->ID, '_logged_in', 1);
        }

        // Check if user last login is empty
        if (empty(get_user_meta($current_user->ID, '_last_login', true))) {
            // Update user last login date/time
            update_user_meta($current_user->ID, '_last_login', $this->jltwp_adminify_set_date_time());
        }
    }

    /**
     * Last Login Status
     */
    public function jltwp_adminify_last_user_login($user)
    {
        // Get current logged in user ID
        $current_user = get_user_by('login', $user);

        update_user_meta($current_user->ID, '_last_login', $this->jltwp_adminify_set_date_time());

        // Update user login status to logged in
        update_user_meta($current_user->ID, '_logged_in', 1);
    }

    /**
     * Last Login Status
     */
    public function jltwp_adminify_current_logged_in_user($current_user)
    {
        // Get current logged in user ID
        $current_user = wp_get_current_user();

        // Update user last logout date/time
        update_user_meta($current_user->ID, '_last_logout', $this->jltwp_adminify_set_date_time());

        // Update user login status to logged out
        update_user_meta($current_user->ID, '_logged_in', 0);
    }

    /**
     * User Activity lists
     *
     * @return void
     */
    public function jltwp_adminify_get_logged_in_users()
    {

        $user_list = array();

        $blog_id = '1';

        // Check for multisite
        if (is_multisite()) {
            $blog_id = get_current_blog_id();
            $options = get_blog_option($blog_id, 'wp_admin_theme_settings_options');
        }

        // Build the user count query
        $user_count_args  = array(
            'blog_id' => $blog_id,
            'number' => 999999,
        );

        $user_count_query = new \WP_User_Query($user_count_args);
        $user_count = $user_count_query->get_results();

        // Count the number of users found in the query
        $total_users = isset($user_count) ? count($user_count) : 1;

        // Grab the current page number and set to 1 if no page number is set
        $page = isset($_GET['p']) ? $_GET['p'] : 1;

        // Limit users to show per page
        $users_per_page = 5;

        // Calculate the total number of pages
        $total_pages = 1;
        $offset = $users_per_page * ($page - 1);
        $total_pages = ceil($total_users / $users_per_page);

        // Build the user query
        $args  = array(
            'blog_id' => $blog_id,
            'orderby' => 'login',
            'order' => 'ASC',
            'number' => $users_per_page,
            'offset' => $offset,
        );

        // Create the WP_User_Query object
        $wp_user_query = new \WP_User_Query($args);

        // Get the user results
        $users = $wp_user_query->get_results();

        foreach ($users as $current_user) {

            // check last login date/time is false
            $getLastLogin = get_user_meta($current_user->ID, '_last_login', true);

            $last_user_login = $getLastLogin;
            if (empty($getLastLogin)) {
                $last_user_login = esc_html__('N/A', 'adminify');
            }

            // check last logout date/time is false
            $getLastLogout = get_user_meta($current_user->ID, '_last_logout', true);

            $last_user_logout = $getLastLogout;
            if (empty($getLastLogout)) {
                $last_user_logout = esc_html__('N/A', 'adminify');
            }

            // check if user login status is false
            $is_logged_in = '0';
            if (get_user_meta($current_user->ID, '_logged_in', true)) {
                // check user is logged in
                $get_user_logged_in_status = get_user_meta($current_user->ID);
                $is_logged_in = $get_user_logged_in_status['_logged_in'][0];
            }

            // get logged in status
            if ($is_logged_in != '1') {
                $login_status = '<span class="user-status-text logged-out">' . esc_html__('logged out', 'adminify') . '</span>';
                if (is_rtl()) {
                    $login_status = '<span class="user-status-text logged-out">' . esc_html__('logged out', 'adminify') . '</span>' . esc_html__('is', 'adminify');
                }
            } else {
                $login_status = '<span class="user-status-text logged-in">' . esc_html__('logged in', 'adminify') . '</span>';
                if (is_rtl()) {
                    $login_status = '<span class="user-status-text logged-in">' . esc_html__('logged in', 'adminify') . '</span>' . esc_html__('is', 'adminify');
                }
            }


            // Logged In/Logout Status Symbol
            if ($is_logged_in) {
                $status_class = 'logged-in';
            } else {
                $status_class = 'logged-out';
            }


            // show logged in status
            if (is_rtl()) {
                $user_list['users'][] = '<tr>
                        <td>
                            <div class="media">
                                <div class="wp-adminify-user-avatar media-left is-pulled-left image">
                                    ' . get_avatar($current_user->user_email, 36, '', '', array('class' => 'is-rounded')) . '
                                    <div class="user-status ' . $status_class . '"></div>
                                </div>

                                <div class="media-content">
                                    <h5 class="wp-adminify-user-name">' . esc_html($current_user->display_name) . '</h5>
                                    ' . $login_status . '
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="wp-adminify-user-time-tracker">
                                <time datetime="' . $last_user_login . '"><span>' . $last_user_login . '</span></time>
                            </div>
                        </td>
                        <td>
                            <div class="wp-adminify-user-time-tracker">
                                <time datetime="' . $last_user_logout . '"><span>' . $last_user_logout . '</span></time>
                            </div>
                        </td>
                    </tr>';
            } else {
                $user_list['users'][] = '<tr>
                        <td>
                            <div class="media">
                                <div class="wp-adminify-user-avatar media-left is-pulled-left image">
                                    ' . get_avatar($current_user->user_email, 36, '', '', array('class' => 'is-rounded')) . '
                                    <div class="user-status ' . $status_class . '"></div>
                                </div>

                                <div class="media-content">
                                    <h5 class="wp-adminify-user-name">' . esc_html($current_user->display_name) . '</h5>
                                    ' . $login_status . '
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="wp-adminify-user-time-tracker">
                                <time datetime="' . $last_user_login . '"><span class="is-pulled-left">' . $last_user_login . '</span></time>
                            </div>
                        </td>
                        <td>
                            <div class="wp-adminify-user-time-tracker">
                                <time datetime="' . $last_user_logout . '"><span class="is-pulled-left">' . $last_user_logout . '</span></time>
                            </div>
                        </td>
                    </tr>';
            }
        }

        // Grab the current query parameters
        $query_string = $_SERVER['QUERY_STRING'];

        // If in the admin, your base should be the admin URL + your page
        $base = admin_url('index.php') . '?' . remove_query_arg('p', $query_string) . '%_%';

        $user_list['pagination'] = paginate_links(array(
            'base' => $base, // the base URL, including query arg
            'format' => '&p=%#%', // this defines the query parameter that will be used, in this case "p"
            'total' => $total_pages, // the total number of pages we have
            'current' => $page, // the current page
            'prev_text' => '‹',
            'next_text' => '›',
            'show_all' => false,
            'before_page_number' => '',
            'after_page_number' => '',
        ));

        return $user_list;
    }


    /**
     * Dashboard Widgets: Logged in Users
     *
     * @return void
     */
    public function jltwp_adminify_user_activities_details()
    { ?>

        <div class="wp-adminify-dash-users-activity">
            <table class="wp-adminify-dash-user-activity-table">
                <tr>
                    <th><?php echo esc_html__('User', 'adminify'); ?></th>
                    <th><?php echo esc_html__('Last Login', 'adminify'); ?></th>
                    <th><?php echo esc_html__('Last Logout', 'adminify'); ?></th>
                </tr>
                <?php
                $users = isset($this->jltwp_adminify_get_logged_in_users()['users']) ? $this->jltwp_adminify_get_logged_in_users()['users'] : false;
                foreach ($users as $current_user) {
                    echo $current_user;
                }
                ?>


                <?php
                $pagination = isset($this->jltwp_adminify_get_logged_in_users()['pagination']) ? $this->jltwp_adminify_get_logged_in_users()['pagination'] : false;
                if ($pagination) { ?>
                    <div class="user-pagination">
                        <?php echo $pagination; ?>
                    </div>
                <?php }
                ?>

            </table>
        </div>
<?php

    }
}
