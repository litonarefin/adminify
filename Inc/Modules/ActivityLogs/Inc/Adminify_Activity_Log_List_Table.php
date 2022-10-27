<?php

namespace WPAdminify\Inc\Modules\ActivityLogs\Inc;

use WP_List_Table;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * WPAdminify
 * @package Activity Logs
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */
if (!class_exists('WP_List_Table'))
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');


class Adminify_Activity_Log_List_Table extends WP_List_Table
{
    public $url;

    // User Roles
    protected $_roles = array();

    // Capabilities
    protected $_caps = array();

    protected $_allow_caps = array();

    public function __construct($args = array())
    {
        global $wp_roles;
        $this->url = WP_ADMINIFY_URL . 'Inc/Modules/ActivityLogs';

        parent::__construct(
            array(
                'singular'  => 'activity',
                'screen' => isset($args['screen']) ? $args['screen'] : null,
            )
        );

        $this->_roles = apply_filters(
            'adminify_activity_logs_roles',
            [
                // admin
                'manage_options' => [
                    'Core',
                    'Export',
                    'Post',
                    'Taxonomy',
                    'User',
                    'Options',
                    'Attachment',
                    'Plugin',
                    'Widget',
                    'Theme',
                    'Menu',
                    'Comments'
                ],

                // editor
                'edit_pages' => [
                    'Post',
                    'Taxonomy',
                    'Attachment',
                    'Comments'
                ],
            ]
        );

        $default_rules = ['administrator', 'editor', 'author', 'guest'];


        $all_roles = [];
        foreach ($wp_roles->roles as $key => $wp_role) {
            $all_roles[] = $key;
        }

        $this->_caps = apply_filters(
            'adminify_activity_logs_caps',
            array(
                'administrator' => array_unique(array_merge($default_rules, $all_roles)),
                'editor'        => ['editor', 'author', 'guest'],
                'author'        => ['author', 'guest'],
            )
        );

        add_screen_option(
            'per_page',
            [
                'default' => 50,
                'label'   => __('Activities', 'adminify'),
                'option'  => 'edit_adminify_activity_logs_per_page',
            ]
        );

        add_filter('set-screen-option', [$this, 'adminify_activity_logs_set_screen_option'], 10, 3);
        set_screen_options();
    }

    public function get_columns()
    {
        $columns = [
            'date'        => __('Date', 'adminify'),
            'author'      => __('Author', 'adminify'),
            'ip'          => __('IP Address', 'adminify'),
            'type'        => __('Type', 'adminify'),
            'label'       => __('Label', 'adminify'),
            'action'      => __('Action', 'adminify'),
            'description' => __('Description', 'adminify'),
            'delete'      => __('Delete', 'adminify'),
        ];

        return $columns;
    }

    public function get_sortable_columns()
    {
        return array(
            'ip'   => 'log_ip',
            'date' => ['log_time', true],
        );
    }

    public function get_action_label($action)
    {
        return ucwords(str_replace('_', ' ', __($action, 'adminify')));
    }

    protected function _get_where_by_role()
    {
        $allow_modules = [];

        foreach ($this->_roles as $key => $role) {
            if (current_user_can($key) || current_user_can('view_all_adminify_activity_logs')) {
                $allow_modules = array_merge($allow_modules, $role);
            }
        }

        if (empty($allow_modules)) {
            wp_die('Not allowed here.');
        }

        $allow_modules = array_unique($allow_modules);

        $where = [];
        foreach ($allow_modules as $type)
            $where[] .= '`object_type` = \'' . $type . '\'';

        $where_caps = array();
        foreach ($this->_get_allow_caps() as $cap)
            $where_caps[] .= '`user_caps` = \'' . $cap . '\'';

        return 'AND (' . implode(' OR ', $where) . ') AND (' . implode(' OR ', $where_caps) . ')';
    }

    protected function _get_allow_caps()
    {
        if (empty($this->_allow_caps)) {
            $user = get_user_by('id', get_current_user_id());
            if (!$user) {
                wp_die('Not allowed here.');
            }

            $user_cap   = strtolower(key($user->caps));
            $allow_caps = array();

            foreach ($this->_caps as $key => $cap_allow) {
                if ($key === $user_cap) {
                    $allow_caps = array_merge($allow_caps, $cap_allow);

                    break;
                }
            }

            // TODO: Find better way to Multisite compatibility.
            if (is_super_admin() || current_user_can('view_all_adminify_activity_logs')) {
                $allow_caps = $this->_caps['administrator'];
            }

            if (empty($allow_caps)) {
                wp_die('Not allowed here.');
            }

            $this->_allow_caps = array_unique($allow_caps);
        }
        return $this->_allow_caps;
    }

    public function column_default($item, $column_name)
    {
        $return = '';

        switch ($column_name) {
            case 'action':
                $return = $this->get_action_label($item->action);
                break;
            case 'date':
                $return  = sprintf('<strong>' . __('%s ago', 'adminify') . '</strong>', human_time_diff($item->log_time, current_time('timestamp')));
                $return .= '<br />' . date('d/m/Y', $item->log_time);
                $return .= '<br />' . date('H:i:s', $item->log_time);
                break;
            case 'ip':
                $return = $item->log_ip;
                break;
            default:
                if (isset($item->$column_name))
                    $return = $item->$column_name;
        }

        $return = apply_filters('adminify_activity_logs_table_list_column_default', $return, $item, $column_name);

        return $return;
    }

    public function column_author($item)
    {
        global $wp_roles;

        if (!empty($item->user_id) && 0 !== (int) $item->user_id) {
            $user = get_user_by('id', $item->user_id);
            if ($user instanceof \WP_User && 0 !== $user->ID) {
                return sprintf(
                    '<a href="%s">%s <span class="wp-adminify-author-name">%s</span></a><br /><small>%s</small>',
                    get_edit_user_link($user->ID),
                    get_avatar($user->ID, 40),
                    $user->display_name,
                    isset($user->roles[0]) && isset($wp_roles->role_names[$user->roles[0]]) ? $wp_roles->role_names[$user->roles[0]] : __('Unknown', 'adminify')
                );
            }
        }

        return sprintf(
            '<span class="wp-adminify-author-name">%s</span>',
            __('N/A', 'adminify')
        );
    }

    public function column_type($item)
    {
        $return = __($item->object_type, 'adminify');

        $return = apply_filters('adminify_activity_logs_table_list_column_type', $return, $item);
        return $return;
    }

    public function column_label($item)
    {
        $return = '';
        if (!empty($item->object_subtype)) {
            $pt     = get_post_type_object($item->object_subtype);
            $return = !empty($pt->label) ? $pt->label : $item->object_subtype;
        }

        $return = apply_filters('adminify_activity_logs_table_list_column_label', $return, $item);
        return $return;
    }


    public function column_description($item)
    {
        $return = esc_html($item->object_name);

        switch ($item->object_type) {
            case 'Post':
                $return = sprintf('<a href="%s">%s</a>', get_edit_post_link($item->object_id), esc_html($item->object_name));
                break;

            case 'Taxonomy':
                if (!empty($item->object_id))
                    $return = sprintf('<a href="%s">%s</a>', get_edit_term_link($item->object_id, $item->object_subtype), esc_html($item->object_name));
                break;

            case 'Comments':
                if (!empty($item->object_id) && $comment = get_comment($item->object_id)) {
                    $return = sprintf('<a href="%s">%s #%d</a>', get_edit_comment_link($item->object_id), $item->object_name, $item->object_id);
                }
                break;

            case 'Export':
                if ('all' === $item->object_name) {
                    $return = __('All', 'adminify');
                } else {
                    $pt = get_post_type_object($item->object_name);
                    $return = !empty($pt->label) ? $pt->label : $item->object_name;
                }
                break;

            case 'Options':
            case 'Core':
                $return = __($item->object_name, 'adminify');
                break;
        }

        $return = apply_filters('adminify_activity_logs_table_list_column_description', $return, $item);

        return $return;
    }

    public function column_delete($item)
    {

        $url = admin_url(wp_nonce_url("admin.php?page=adminify-activity-logs&action=delete&log_id=$item->log_id", 'delete-log_' . $item->log_id));
        return sprintf('<a href="%s" class="button button-small">%s</button>', $url, __('Delete', 'adminify'));
    }

    public function display_tablenav($which)
    {
        if ('top' == $which) {
            $this->search_box(__('Search', 'adminify'), 'wp-adminify-search');
        }
?>
        <p>
            <?php
            echo sprintf(
                __('<h3>You can set how many days to store Activity Logs Data <strong><em><small>Default: 30 days</small></em></strong></h3><p>Settings: <a href="%1$s">%1$s</a></p>', 'adminify'),
                admin_url('admin.php?page=wp-adminify-settings#tab=module-settings/activity-logs')
            );
            ?>
        </p>
        <div class="tablenav <?php echo esc_attr($which); ?>">
            <?php
            $this->extra_tablenav($which);
            $this->pagination($which);
            ?>
            <br class="clear" />
        </div>
    <?php
    }

    public function extra_tablenav($which)
    {
        global $wpdb;

        if ('top' !== $which)
            return;

        echo '<div class="alignleft actions">';

        $users = $wpdb->get_results(
            'SELECT DISTINCT `user_id` FROM `' . $wpdb->adminify_activity_logs . '`
				WHERE 1 = 1
				' . $this->_get_where_by_role() . '
				GROUP BY `user_id`
				ORDER BY `user_id`
			;'
        );

        $types = $wpdb->get_results(
            'SELECT DISTINCT `object_type` FROM `' . $wpdb->adminify_activity_logs . '`
				WHERE 1 = 1
				' . $this->_get_where_by_role() . '
				GROUP BY `object_type`
				ORDER BY `object_type`
			;'
        );

        // Make sure we get items for filter.
        if ($users || $types) {
            if (!isset($_REQUEST['dateshow']))
                $_REQUEST['dateshow'] = '';

            $date_options = [
                ''          => __('All Time', 'adminify'),
                'today'     => __('Today', 'adminify'),
                'yesterday' => __('Yesterday', 'adminify'),
                'week'      => __('Week', 'adminify'),
                'month'     => __('Month', 'adminify'),
            ];

            echo '<select name="dateshow" id="hs-filter-date">';
            foreach ($date_options as $key => $value)
                printf('<option value="%s"%s>%s</option>', $key, selected($_REQUEST['dateshow'], $key, false), $value);
            echo '</select>';

            submit_button(__('Filter', 'adminify'), 'button', 'adminify-activity-logs-filter', false, array('id' => 'activity-query-submit'));
        }

        if ($users) {
            if (!isset($_REQUEST['capshow']))
                $_REQUEST['capshow'] = '';

            $output = array();
            foreach ($this->_get_allow_caps() as $cap) {
                $output[$cap] = __(ucwords($cap), 'adminify');
            }

            if (!empty($output)) {
                echo '<select name="capshow" id="hs-filter-capshow">';
                printf('<option value="">%s</option>', __('All Roles', 'adminify'));
                foreach ($output as $key => $value) {
                    printf('<option value="%s"%s>%s</option>', $key, selected($_REQUEST['capshow'], $key, false), $value);
                }
                echo '</select>';
            }

            if (!isset($_REQUEST['usershow']))
                $_REQUEST['usershow'] = '';

            $output = array();
            foreach ($users as $_user) {
                if (0 === (int) $_user->user_id) {
                    $output[0] = __('N/A', 'adminify');
                    continue;
                }

                $user = get_user_by('id', $_user->user_id);
                if ($user)
                    $output[$user->ID] = $user->user_nicename;
            }

            if (!empty($output)) {
                echo '<select name="usershow" id="hs-filter-usershow">';
                printf('<option value="">%s</option>', __('All Users', 'adminify'));
                foreach ($output as $key => $value) {
                    printf('<option value="%s"%s>%s</option>', $key, selected($_REQUEST['usershow'], $key, false), $value);
                }
                echo '</select>';
            }
        }

        if ($types) {
            if (!isset($_REQUEST['typeshow']))
                $_REQUEST['typeshow'] = '';

            $output = array();
            foreach ($types as $type)
                $output[] = sprintf('<option value="%s"%s>%s</option>', $type->object_type, selected($_REQUEST['typeshow'], $type->object_type, false), __($type->object_type, 'adminify'));

            echo '<select name="typeshow" id="hs-filter-typeshow">';
            printf('<option value="">%s</option>', __('All Types', 'adminify'));
            echo implode('', $output);
            echo '</select>';
        }


        $actions = $wpdb->get_results(
            'SELECT DISTINCT `action` FROM  `' . $wpdb->adminify_activity_logs . '`
				WHERE 1 = 1
				' . $this->_get_where_by_role() . '
				GROUP BY `action`
				ORDER BY `action`
			;'
        );

        if ($actions) {
            if (!isset($_REQUEST['showaction']))
                $_REQUEST['showaction'] = '';

            $output = array();
            foreach ($actions as $type)
                $output[] = sprintf('<option value="%s"%s>%s</option>', $type->action, selected($_REQUEST['showaction'], $type->action, false), $this->get_action_label($type->action));

            echo '<select name="showaction" id="hs-filter-showaction">';
            printf('<option value="">%s</option>', __('All Actions', 'adminify'));
            echo implode('', $output);
            echo '</select>';
        }

        echo '</div>';
    }


    public function prepare_items()
    {
        global $wpdb;

        $items_per_page        = $this->get_items_per_page('edit_adminify_activity_logs_per_page', 20);
        $this->_column_headers = array($this->get_columns(), get_hidden_columns($this->screen), $this->get_sortable_columns());
        $where                 = ' WHERE 1 = 1';

        if (!isset($_REQUEST['order']) || !in_array($_REQUEST['order'], array('desc', 'asc'))) {
            $_REQUEST['order'] = 'DESC';
        }
        if (!isset($_REQUEST['orderby']) || !in_array($_REQUEST['orderby'], array('log_time', 'log_ip'))) {
            $_REQUEST['orderby'] = 'log_time';
        }

        if (!empty($_REQUEST['typeshow'])) {
            $where .= $wpdb->prepare(' AND `object_type` = %s', $_REQUEST['typeshow']);
        }

        if (isset($_REQUEST['showaction']) && '' !== $_REQUEST['showaction']) {
            $where .= $wpdb->prepare(' AND `action` = %s', $_REQUEST['showaction']);
        }

        if (isset($_REQUEST['usershow']) && '' !== $_REQUEST['usershow']) {
            $where .= $wpdb->prepare(' AND `user_id` = %d', $_REQUEST['usershow']);
        }

        if (isset($_REQUEST['capshow']) && '' !== $_REQUEST['capshow']) {
            $where .= $wpdb->prepare(' AND `user_caps` = %s', strtolower($_REQUEST['capshow']));
        }

        if (isset($_REQUEST['dateshow']) && in_array($_REQUEST['dateshow'], array('today', 'yesterday', 'week', 'month'))) {
            $current_time = current_time('timestamp');

            // Today
            $start_time = mktime(0, 0, 0, date('m', $current_time), date('d', $current_time), date('Y', $current_time));;
            $end_time = mktime(23, 59, 59, date('m', $current_time), date('d', $current_time), date('Y', $current_time));

            if ('yesterday' === $_REQUEST['dateshow']) {
                $start_time = strtotime('yesterday', $start_time);
                $end_time = mktime(23, 59, 59, date('m', $start_time), date('d', $start_time), date('Y', $start_time));
            } elseif ('week' === $_REQUEST['dateshow']) {
                $start_time = strtotime('-1 week', $start_time);
            } elseif ('month' === $_REQUEST['dateshow']) {
                $start_time = strtotime('-1 month', $start_time);
            }

            $where .= $wpdb->prepare(' AND `log_time` > %d AND `log_time` < %d', $start_time, $end_time);
        }

        if (isset($_REQUEST['s'])) {
            // Search only searches 'description' fields.
            $where .= $wpdb->prepare(' AND `object_name` LIKE %s', '%' . $wpdb->esc_like($_REQUEST['s']) . '%');
        }

        $offset = ($this->get_pagenum() - 1) * $items_per_page;


        $total_items = $wpdb->get_var(
            'SELECT COUNT(`log_id`) FROM  `' . $wpdb->adminify_activity_logs . '`
				' . $where . '
					' . $this->_get_where_by_role()
        );

        $items_orderby = filter_input(INPUT_GET, 'orderby', FILTER_SANITIZE_STRING);
        if (empty($items_orderby)) {
            $items_orderby = 'log_time'; // Sort by time by default.
        }

        $items_order = strtoupper($_REQUEST['order']);
        if (empty($items_order) || !in_array($items_order, array('DESC', 'ASC'))) {
            $items_order = 'DESC'; // Descending order by default.
        }

        $this->items = $wpdb->get_results($wpdb->prepare(
            'SELECT * FROM `' . $wpdb->adminify_activity_logs . '`
				' . $where . '
					' . $this->_get_where_by_role() . '
					ORDER BY ' . $items_orderby . ' ' . $items_order . '
					LIMIT %d, %d;',
            $offset,
            $items_per_page
        ));

        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page' => $items_per_page,
            'total_pages' => ceil($total_items / $items_per_page),
        ));
    }

    public function adminify_activity_logs_set_screen_option($status, $option, $value)
    {
        if ('edit_adminify_activity_logs_per_page' === $option)
            return $value;
        return $status;
    }

    public function search_box($text, $input_id)
    {
        $search_data = isset($_REQUEST['s']) ? sanitize_text_field($_REQUEST['s']) : '';

        $input_id = $input_id . '-search-input';
    ?>
        <p class="search-box">
            <label class="screen-reader-text" for="<?php echo $input_id ?>"><?php echo $text; ?>:</label>
            <input type="search" id="<?php echo $input_id ?>" name="s" value="<?php echo esc_attr($search_data); ?>" />
            <?php submit_button($text, 'button', false, false, array('id' => 'search-submit')); ?>
        </p>
<?php
    }
}
