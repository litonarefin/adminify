<?php

namespace WPAdminify\Inc\Classes;

use WPAdminify\Inc\Utils;

// no direct access allowed
if (!defined('ABSPATH'))  exit;
/**
 * WPAdminify
 * Admin Menu: Server Info
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class ServerInfo
{

    /**
     * SERVER CPU LOAD
     * Get the server CPU load in percentage.
     */

    public function get_server_cpu_load_percentage()
    {

        $result = -1;
        $lines = null;

        $os = '';
        if (defined('PHP_OS')) {
            $os = PHP_OS;
        }

        // Linux server
        if ($os == 'Linux') {

            $checks = array();
            foreach (array(0, 1) as $i) {
                $cmd = '/proc/stat';
                $lines = array();
                $fh = fopen($cmd, 'r');
                while ($line = fgets($fh)) {
                    $lines[] = $line;
                }
                fclose($fh);
                foreach ($lines as $line) {
                    $ma = array();
                    if (!preg_match('/^cpu  (\d+) (\d+) (\d+) (\d+) (\d+) (\d+) (\d+) (\d+) (\d+) (\d+)$/', $line, $ma)) {
                        continue;
                    }
                    $total = $ma[1] + $ma[2] + $ma[3] + $ma[4] + $ma[5] + $ma[6] + $ma[7] + $ma[8] + $ma[9];
                    //$totalCpu = $ma[1] + $ma[2] + $ma[3];
                    //$result = (100 / $total) * $totalCpu;
                    $ma['total'] = $total;
                    $checks[] = $ma;
                    break;
                }
                if ($i == 0) {
                    // Wait before checking again.
                    sleep(1);
                }
            }
            // Idle - prev idle
            $diffIdle = $checks[1][4] - $checks[0][4];
            // Total - prev total
            $diffTotal = $checks[1]['total'] - $checks[0]['total'];
            // Usage in %
            $diffUsage = round((1000 * ($diffTotal - $diffIdle) / $diffTotal + 5) / 10, 2);
            $result = $diffUsage;

            return (float) $result;
        }

        return 'N/A';
    }




    /**
     *******************
     * SERVER CPU CORE COUNT
     *******************
     *
     *	Get the count of available server CPU cores.
     */

    function check_core_count()
    {

        $cmd = "uname";

        $OS = strtolower(trim(shell_exec($cmd)));

        switch ($OS) {
            case ('linux'):
                $cmd = "cat /proc/cpuinfo | grep processor | wc -l";
                break;
            case ('freebsd'):
                $cmd = "sysctl -a | grep 'hw.ncpu' | cut -d ':' -f2";
                break;
            default:
                unset($cmd);
        }

        if (isset($cmd) && $cmd != '') {
            $cpuCoreNo = intval(trim(shell_exec($cmd)));
        }

        return empty($cpuCoreNo) ? 1 : $cpuCoreNo;
    }


    /**
     * Convert Memory Size
     *
     * @param [type] $size
     *
     * @return void
     */
    public function convert_memory_size($size)
    {

        $l = substr($size, -1);
        $ret = substr($size, 0, -1);

        switch (strtoupper($l)) {
            case 'P':
                $ret *= 1024;
            case 'T':
                $ret *= 1024;
            case 'G':
                $ret *= 1024;
            case 'M':
                $ret *= 1024;
            case 'K':
                $ret *= 1024;
        }

        return $ret;
    }

    /**
     * Get Server/WP Memory Limit
     */

    public function get_wp_memory_limit()
    {

        $memory_limit = (int)@ini_get('memory_limit') . ' MB' . ' (' . (int)WP_MEMORY_LIMIT . ' MB)';
        if (@ini_get('memory_limit') == '-1') {
            $memory_limit = '-1 / ' . esc_html__('Unlimited', 'adminify') . ' (' . (int)WP_MEMORY_LIMIT . ' MB)';
        }

        if ((int)WP_MEMORY_LIMIT < (int)@ini_get('memory_limit') && WP_MEMORY_LIMIT != '-1' || (int)WP_MEMORY_LIMIT < (int)@ini_get('memory_limit') && @ini_get('memory_limit') != '-1') {
            $memory_limit .= ' <span class="warning"><span class="dashicons dashicons-warning"></span> ' . sprintf(__('The WP PHP Memory Limit is less than the %s Server PHP Memory Limit', 'adminify'), (int)@ini_get('memory_limit') . ' MB') . '!</span>';
        }

        return $memory_limit;
    }

    /**
     * Get PHP Version
     */
    public function get_php_version()
    {

        $php_version = 'N/A';

        if (function_exists('phpversion')) {
            $php_version = phpversion();
        }

        if (defined('PHP_VERSION')) {
            $php_version = PHP_VERSION;
        }

        if ($php_version != 'N/A' && version_compare($php_version, '7.3', '<')) {
            $php_version = '<span class="warning"><span class="dashicons dashicons-warning"></span> ' . sprintf(__('%s - Recommend  PHP version of 7.3. See: %s', 'adminify'), esc_html($php_version), '<a href="https://wordpress.org/about/requirements/" target="_blank" rel="noopener">' . __('WordPress Requirements', 'adminify') . '</a>') . '</span>';
        }

        return $php_version;
    }

    /**
     * Get PHP Version Only
     * */
    public function get_php_version_lite()
    {

        $php_version = 'N/A';

        if (function_exists('phpversion')) {
            $php_version = phpversion();
        }

        if (defined('PHP_VERSION')) {
            $php_version = PHP_VERSION;
        }

        return $php_version;
    }

    /**
     * Get Curl Version
     *
     * @return void
     */
    public function get_cURL_version()
    {

        $curl_version = 'N/A';

        if (function_exists('curl_version')) {
            $curl_version = curl_version();
            $curl_version = $curl_version['version'] . ', ' . $curl_version['ssl_version'];
        }

        return $curl_version;
    }

    /**
     * Get MySQL Version
     *
     * @return void
     */
    public function get_mysql_version()
    {
        global $wpdb;

        // Short Version
        // $db_version = $wpdb->db_server_info();

        $db_version_dump = $wpdb->get_var("SELECT VERSION() AS version from DUAL");
        if (preg_match('/\d+(?:\.\d+)+/', $db_version_dump, $matches)) {
            $db_version = $matches[0]; //returning the first match
        } else {
            $db_version = __('N/A', 'adminify');
        }
        return $db_version;
    }


    /**
     * Get Get Database Software Name
     *
     * @return void
     */
    public function get_db_software()
    {

        global $wpdb;
        $db_software_query = $wpdb->get_row("SHOW VARIABLES LIKE 'version_comment'");
        $db_software_dump = $db_software_query->Value;
        if (!empty($db_software_dump)) {
            $db_soft_array = explode(" ", trim($db_software_dump));
            $db_software = $db_soft_array[0];
        } else {
            $db_software = __('N/A', 'adminify');
        }

        return $db_software;
    }

    /**
     * Get WP Table Prefix
     */
    public function get_table_prefix()
    {

        global $wpdb;

        $prefix = array(
            'tablePrefix' => $wpdb->prefix,
            'tableBasePrefix' => $wpdb->base_prefix,
        );

        return $prefix;
    }

    /**
     * Shell Enable/Disable
     */
    public function is_shell_enable()
    {

        if (function_exists('shell_exec') && !in_array('shell_exec', array_map('trim', explode(', ', ini_get('disable_functions'))))) {
            // If enabled, check if shell_exec() actually have execution power
            $returnVal = shell_exec('cat /proc/cpuinfo');
            if (!empty($returnVal)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get Server Uptime
     */
    public function get_server_uptime()
    {

        error_reporting(0);
        $disabled_funcs = [];

        if (ini_get('disable_functions')) {
            $disabled_funcs = array_map('trim', explode(',', ini_get('disable_functions')));
        }

        if (strpos(strtolower(PHP_OS), 'win') !== FALSE) {

            // For Windaz
            if (!in_array('exec', $disabled_funcs)) {

                set_time_limit(150); // 'systeminfo' command can take a while...

                $uptime = exec('systeminfo | find "System Up"');
                $parts = explode(':', $uptime);
                $parts = array_pop($parts);
                $parts = explode(',', trim($parts));

                foreach (array('days', 'hours', 'mins', 'secs') as $k => $v) {
                    $parts[$k] = explode(' ', trim($parts[$k]));
                    $$v = ($k) ? str_pad(array_shift($parts[$k]), 2, '0', STR_PAD_LEFT) : array_shift($parts[$k]);
                }

                return ($days * DAY_IN_SECONDS) + ($hours * HOUR_IN_SECONDS) + ($mins * MINUTE_IN_SECONDS) + $secs;
            }
        } else {

            // For *nix

            if (in_array('shell_exec', $disabled_funcs)) {
                $uptime_text = file_get_contents("/proc/uptime");
                $uptime = substr($uptime_text, 0, strpos($uptime_text, " "));
            } else {
                $uptime = shell_exec("cut -d. -f1 /proc/uptime");
            }

            $days   = floor($uptime / 60 / 60 / 24);
            $hours  = str_pad($uptime / 60 / 60 % 24, 2, "0", STR_PAD_LEFT);
            $mins   = str_pad($uptime / 60 % 60, 2, "0", STR_PAD_LEFT);
            $secs   = str_pad($uptime % 60, 2, "0", STR_PAD_LEFT);

            return ($days * DAY_IN_SECONDS) + ($hours * HOUR_IN_SECONDS) + ($mins * MINUTE_IN_SECONDS) + $secs;
        }

        return false;
    }


    /**
     * Get WP Timezone
     */

    public function get_wp_timezone()
    {

        $timezone = get_option('timezone_string'); // Direct value

        // Create a UTC+- zone if no timezone string exists
        if (empty($timezone)) {
            // Current offset
            $current_offset = get_option('gmt_offset');

            // Plus offset
            $timezone = 'UTC+' . $current_offset;

            // No offset
            if (0 == $current_offset) {
                $timezone = 'UTC+0';
                // Negative offset
            } elseif ($current_offset < 0) {
                $timezone = 'UTC' . $current_offset;
            }

            // Normalize
            $timezone = str_replace(array('.25', '.5', '.75'), array(':15', ':30', ':45'), $timezone);
        }

        return $timezone;
    }

    /**
     * Get Server/WP Total RAM
     *
     * @return void
     */
    public function get_server_total_ram()
    {

        $os = '';
        if (defined('PHP_OS')) {
            $os = PHP_OS;
        }

        $result = 0;

        // Linux server
        if ($os == 'Linux') {

            $fh = fopen('/proc/meminfo', 'r');
            while ($line = fgets($fh)) {
                $pieces = array();
                if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
                    $result = $pieces[1];
                    // KB to Bytes
                    $result = round($result / 1024 / 1024, 2);
                    break;
                }
            }
            fclose($fh);

            return $result;
        }

        return 'N/A';
    }


    /**
     * Get Server/WP Free RAM
     */
    public function get_server_free_ram()
    {

        $os = '';
        if (defined('PHP_OS')) {
            $os = PHP_OS;
        }

        $result = 0;

        // Linux server
        if ($os == 'Linux') {

            $fh = fopen('/proc/meminfo', 'r');
            while ($line = fgets($fh)) {
                $pieces = array();
                if (preg_match('/^MemFree:\s+(\d+)\skB$/', $line, $pieces)) {
                    // KB to Bytes
                    $result = round($pieces[1] / 1024 / 1024, 2);
                    break;
                }
            }
            fclose($fh);

            return $result;
        }

        return 'N/A';
    }

    /**
     * Get Server/WP RAM Details
     *
     * @return void
     */
    public function get_server_ram_details()
    {

        $os = '';
        if (defined('PHP_OS')) {
            $os = PHP_OS;
        }

        $ram_data = '';
        if ($os == 'Linux') {

            foreach (file('/proc/meminfo') as $ri) {
                $m[strtok($ri, ':')] = strtok('');
            }

            $ram_total     = round((int)$m['MemTotal'] / 1024 / 1024, 2);
            $ram_available = round((int)$m['MemAvailable'] / 1024 / 1024, 2);
            $ram_free      = round((int)$m['MemFree'] / 1024 / 1024, 2);
            $ram_buffers   = round((int)$m['Buffers'] / 1024 / 1024, 2);
            $ram_cached    = round((int)$m['Cached'] / 1024 / 1024, 2);

            $mem_kernel_app = round((100 - ($ram_buffers + $ram_cached + $ram_free) / $ram_total * 100), 2);
            $mem_cached     = round($ram_cached / $ram_total * 100, 2);
            $mem_buffers    = round($ram_buffers / $ram_total * 100, 2);

            $ram_data = array(
                'MemTotal'           => $ram_total,
                'MemAvailable'       => $ram_available,
                'MemFree'            => $ram_free,
                'Buffers'            => $ram_buffers,
                'Cached'             => $ram_cached,
                'MemUsagePercentage' => round($mem_kernel_app + $mem_buffers + $mem_cached, 2),   // Physical Memory
            );

            return $ram_data;
        }

        return 'N/A';
    }

    /**
     * Get Real Server Memory Usage
     */
    public function get_real_memory_usage()
    {
        $real_memory_usage = function_exists('memory_get_peak_usage') ? round(memory_get_peak_usage(true)) : 0;

        if ($real_memory_usage) {
            return $real_memory_usage;
        }

        return 'N/A';
    }

    /**
     * WP Memory Usage
     */
    public function get_wp_memory_usage()
    {
        // Get WP Memory Limit
        $get_memory_limit = WP_MEMORY_LIMIT;
        if ((int)WP_MEMORY_LIMIT > (int)@ini_get('memory_limit')) {
            // WP Limit can't be greater than Server Limiit
            $get_memory_limit = @ini_get('memory_limit');
        }

        $memory_limit_convert = $this->convert_memory_size($get_memory_limit);
        $memory_limit_format  = size_format($memory_limit_convert);
        $memory_limit         = $memory_limit_convert;

        // Get Real Memory Usage
        $get_memory_usage     = $this->get_real_memory_usage();
        $memory_usage_convert = round($get_memory_usage / 1024 / 1024);
        $memory_usage_format  = $memory_usage_convert . 'MB';
        $memory_usage         = $get_memory_usage;

        if ($get_memory_usage != false && $get_memory_limit != false) {

            // check memory limit is a numeric value
            if (!is_numeric($memory_limit)) $memory_limit = 999;

            $wp_mem_data = array(
                'MemLimit'        => $memory_limit,
                'MemLimitGet'     => $get_memory_limit,
                'MemLimitConvert' => $memory_limit_convert,
                'MemLimitFormat'  => $memory_limit_format,
                'MemUsage'        => $memory_usage,
                'MemUsageGet'     => $get_memory_usage,
                'MemUsageConvert' => $memory_usage_convert,
                'MemUsageFormat'  => $memory_usage_format,
                'MemUsageCalc'    => round($memory_usage / $memory_limit * 100, 0),
            );

            return $wp_mem_data;
        }

        return 'N/A';
    }

    /**
     * Server Memory Usage
     */
    public function get_server_memory_usage()
    {

        // Get Server Memory Limit
        $get_memory_limit = @ini_get('memory_limit');
        $memory_limit_convert = $this->convert_memory_size($get_memory_limit);
        $memory_limit_format = size_format($memory_limit_convert);
        $memory_limit = $memory_limit_convert;

        // Get Real Memory Usage
        $get_memory_usage = $this->get_real_memory_usage();
        $memory_usage_convert = round($get_memory_usage / 1024 / 1024);
        $memory_usage_format = $memory_usage_convert . ' MB';
        $memory_usage = $get_memory_usage;

        if ($get_memory_usage != false && $get_memory_limit != false) {

            // check memory limit is a numeric value
            if (!is_numeric($memory_limit)) $memory_limit = 999;

            $php_mem_data = array(
                'MemLimit'        => $memory_limit,
                'MemLimitGet'     => $get_memory_limit,
                'MemLimitConvert' => $memory_limit_convert,
                'MemLimitFormat'  => $memory_limit_format,
                'MemUsage'        => $memory_usage,
                'MemUsageGet'     => $get_memory_usage,
                'MemUsageConvert' => $memory_usage_convert,
                'MemUsageFormat'  => $memory_usage_format,
                'MemUsageCalc'    => round($memory_usage / $memory_limit * 100, 0),
            );

            return $php_mem_data;
        }

        return 'N/A';
    }


    public static function wp_memory_usage_percentage()
    {
        $memory_usage            = (new ServerInfo)->get_wp_memory_usage();
        $memory_usage_percentage = $memory_usage['MemUsageCalc'];
        return $memory_usage_percentage;
    }




    /**
     * Get Server Disk Size
     */

    public function get_server_disk_size($path = '/')
    {

        $os = '';
        if (defined('PHP_OS')) {
            $os = PHP_OS;
        }

        // Linux server
        if ($os == 'Linux') {

            $result = array();
            $result['size'] = 0;
            $result['free'] = 0;
            $result['used'] = 0;

            $lines = null;
            exec(sprintf('df /P %s', $path), $lines);

            foreach ($lines as $index => $line) {
                if ($index != 1) {
                    continue;
                }
                $values = preg_split('/\s{1,}/', $line);
                $result['size'] = round($values[1] / 1024 / 1024, 2);
                $result['free'] = round($values[3] / 1024 / 1024, 2);
                $result['used'] = round($values[2] / 1024 / 1024, 2);
                $result['usage'] = round($result['used'] / $result['size'] * 100, 2);
                break;
            }

            return $result;
        }

        return 'N/A';
    }



    /**
     * CPU Count
     */
    public function check_cpu_count()
    {

        if ($this->is_shell_enable()) {
            $cpu_count = shell_exec('cat /proc/cpuinfo |grep "physical id" | sort | uniq | wc -l');
            set_transient('wphave_admin_cpu_count', $cpu_count, WEEK_IN_SECONDS);
        } else {
            $cpu_count = 'N/A';
        }

        return $cpu_count;
    }

    /**
     * CPU Load Average
     *
     * @return void
     */

    public function get_cpu_load_average()
    {
        $load = 'N/A';

        // Check via PHP function
        $avg = function_exists('sys_getloadavg') ? sys_getloadavg() : false;
        if (!empty($avg) && is_array($avg) && 3 == count($avg)) {
            $load = implode(', ', $avg);
        }

        return $load;
    }

    /** CPU Load */
    public function get_cpu_load()
    {
        $cpu_load = 'N/A';
        if ($this->is_shell_enable()) {
            $cpu_load .= trim(shell_exec("echo $((`ps aux|awk 'NR > 0 { s +=$3 }; END {print s}'| cut -d . -f 1` / `cat /proc/cpuinfo | grep cores | grep -o '[0-9]' | wc -l`))"));
        }
        return $cpu_load;
    }

    /**
     * CPU Core Count
     */

    public function get_cpu_core_count()
    {

        $cmd = "uname";

        $OS = strtolower(trim(shell_exec($cmd)));

        switch ($OS) {
            case ('linux'):
                $cmd = "cat /proc/cpuinfo | grep processor | wc -l";
                break;
            case ('freebsd'):
                $cmd = "sysctl -a | grep 'hw.ncpu' | cut -d ':' -f2";
                break;
            default:
                unset($cmd);
        }

        if (isset($cmd) && $cmd != '') {
            $cpuCoreNo = intval(trim(shell_exec($cmd)));
        }

        return empty($cpuCoreNo) ? 1 : $cpuCoreNo;
    }

    /**
     * Get IP Address
     *
     * @return void
     */
    public function get_ip_address()
    {
        // Get ip address
        $ip_address = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
        if (!$ip_address) {
            $ip_address = isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : '';
        }
        return $ip_address;
    }

    /**
     * Get WordPress Version
     *
     * @return void
     */
    public function get_wp_version()
    {
        global $wp_version;
        return $wp_version;
    }



    public function check_limit()
    {
        $memory_limit = ini_get('memory_limit');
        if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches)) {
            if ($matches[2] == 'G') {
                $memory_limit = $matches[1] . ' ' . 'GB'; // nnnG -> nnn GB
            } else if ($matches[2] == 'M') {
                $memory_limit = $matches[1] . ' ' . 'MB'; // nnnM -> nnn MB
            } else if ($matches[2] == 'K') {
                $memory_limit = $matches[1] . ' ' . 'KB'; // nnnK -> nnn KB
            } else if ($matches[2] == 'T') {
                $memory_limit = $matches[1] . ' ' . 'TB'; // nnnT -> nnn TB
            } else if ($matches[2] == 'P') {
                $memory_limit = $matches[1] . ' ' . 'PB'; // nnnP -> nnn PB
            }
        }
        return $memory_limit;
    }

    public function format_filesize($bytes)
    {
        if (($bytes / pow(1024, 5)) > 1) {
            return number_format_i18n(($bytes / pow(1024, 5)), 0) . ' ' . __('PB', 'adminify');
        } elseif (($bytes / pow(1024, 4)) > 1) {
            return number_format_i18n(($bytes / pow(1024, 4)), 0) . ' ' . __('TB', 'adminify');
        } elseif (($bytes / pow(1024, 3)) > 1) {
            return number_format_i18n(($bytes / pow(1024, 3)), 0) . ' ' . __('GB', 'adminify');
        } elseif (($bytes / pow(1024, 2)) > 1) {
            return number_format_i18n(($bytes / pow(1024, 2)), 0) . ' ' . __('MB', 'adminify');
        } elseif ($bytes / 1024 > 1) {
            return number_format_i18n($bytes / 1024, 0) . ' ' . __('KB', 'adminify');
        } elseif ($bytes >= 0) {
            return number_format_i18n($bytes, 0) . ' ' . __('bytes', 'adminify');
        } else {
            return __('Unknown', 'adminify');
        }
    }

    public function format_filesize_kB($kiloBytes)
    {
        if (($kiloBytes / pow(1024, 4)) > 1) {
            return number_format_i18n(($kiloBytes / pow(1024, 4)), 0) . ' ' . __('PB', 'adminify');
        } elseif (($kiloBytes / pow(1024, 3)) > 1) {
            return number_format_i18n(($kiloBytes / pow(1024, 3)), 0) . ' ' . __('TB', 'adminify');
        } elseif (($kiloBytes / pow(1024, 2)) > 1) {
            return number_format_i18n(($kiloBytes / pow(1024, 2)), 0) . ' ' . __('GB', 'adminify');
        } elseif (($kiloBytes / 1024) > 1) {
            return number_format_i18n($kiloBytes / 1024, 0) . ' ' . __('MB', 'adminify');
        } elseif ($kiloBytes >= 0) {
            return number_format_i18n($kiloBytes / 1, 0) . ' ' . __('KB', 'adminify');
        } else {
            return __('Unknown', 'adminify');
        }
    }

    public function format_php_size($size)
    {
        if (!is_numeric($size)) {
            if (strpos($size, 'M') !== false) {
                $size = intval($size) * 1024 * 1024;
            } elseif (strpos($size, 'K') !== false) {
                $size = intval($size) * 1024;
            } elseif (strpos($size, 'G') !== false) {
                $size = intval($size) * 1024 * 1024 * 1024;
            }
        }
        return is_numeric($size) ? $this->format_filesize($size) : $size;
    }
}
