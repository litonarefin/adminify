<?php

namespace WPAdminify\Inc\DashboardWidgets;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * System Info Dashboard Widget
 *
 * @return void
 */
/**
 * WPAdminify
 *`
 * @author Jewel Theme <support@jeweltheme.com>
 */

class Adminify_Memory_Usage
{

	public function __construct()
	{

		add_action('wp_dashboard_setup', [$this, 'jltwp_adminify_memory_usage_widget']);
		add_action('admin_enqueue_scripts', [$this, 'jltwp_adminify_memory_usage_admin_css']);
	}

	// Register Memory Usage Dashboard Widget
	public function jltwp_adminify_memory_usage_widget()
	{
		add_meta_box(
			'jltwp_adminify_memory_usage',
			__('WP Memory Usage - Adminify', 'adminify'),
			[$this, 'jltwp_adminify_memory_usage_widget_details'],
			'dashboard',
			'side',
			'high'
		);
	}

	public function jltwp_adminify_memory_usage_admin_css()
	{
		$screen = get_current_screen();
		if ($screen->id == 'dashboard') {
			$my_site_space_css = '';
			$my_site_space_css .= '';
			echo '<style>' . wp_strip_all_tags($my_site_space_css) . '</style>';
		}
	}


	public function jltwp_adminify_memory_usage_get_memory()
	{

		$memory['memory_limit'] = ini_get('memory_limit');
		$memory['memory_usage'] = function_exists('memory_get_usage') ? round(memory_get_usage(), 2) : 0;

		return $memory;
	}

	// Create the function to output the contents of our Dashboard Widget
	public function jltwp_adminify_memory_usage_widget_details()
	{

		global $wpdb;
		$dbname = $wpdb->dbname;

		$phpversion = PHP_VERSION;

		$memory = $this->jltwp_adminify_memory_usage_get_memory();
		$memory_limit = $memory['memory_limit'];
		$memory_usage = $memory['memory_usage'];

		// Get Memory
		if (!empty($memory_usage) && !empty($memory_limit)) {
			$memory_percent = round((int)$memory_usage / (int)$memory_limit * 100, 0);
		}

		// Get Database Size
		$result = $wpdb->get_results('SHOW TABLE STATUS', ARRAY_A);
		$rows = count($result);
		$dbsize = 0;

		if ($wpdb->num_rows > 0) {
			foreach ($result as $row) {
				$dbsize += $row["Data_length"] + $row["Index_length"];
			}
		}

		// PHP version, memory, database size and entire site usage (may include not WP items)
		$topitems = array(
			'PHP Version' => $phpversion . ' ' . (PHP_INT_SIZE * 8) . ' ' . __('Bit OS', 'adminify'),
			'Memory'      => size_format($memory_usage, 2) . __(' of ', 'adminify') . $memory_limit,
			'Database'    => size_format($dbsize, 2)
		);

		// Check if WP_CONTENT_DIR outside of base path (ABSPATH)
		if (strpos(WP_CONTENT_DIR, ABSPATH) !== false) {
			// WP_CONTENT_DIR in ABSPATH
			$entire_site_size = $this->jltwp_adminify_memory_usage_dir_size(ABSPATH);
			if ( $entire_site_size > 0 ) {
				$topitems['Entire Site'] = $this->jltwp_adminify_memory_usage_dir_size_display([ $entire_site_size ]);
			}
		} else {
			// WP_CONTENT_DIR outside ABSPATH
			$entire_abs_size = $this->jltwp_adminify_memory_usage_dir_size(ABSPATH);
			$entire_content_size = $this->jltwp_adminify_memory_usage_dir_size(WP_CONTENT_DIR);

			if ( $entire_abs_size > 0 && $entire_content_size > 0 ) {
				$topitems['Entire Site'] = $this->jltwp_adminify_memory_usage_dir_size_display([ $entire_abs_size, $entire_content_size ]);
			}

		}

		foreach ($topitems as $name => $value) {
			echo '<p class="halfspace"><span class="spacedark">' . $name . '</span>: ' . $value . '</p>';
		}

		echo '<div class="halfspace">
		<p><span class="spacedark">' . __('Memory Used by ', 'adminify') . '</span></p>';

		$uploads = wp_get_upload_dir(); 	// Get upload directory array without creating it

		// WP Content and selected subfolders
		$contents = array(
			"wp-content" => WP_CONTENT_DIR,
			"plugins"    => WP_PLUGIN_DIR,
			"themes"     => get_theme_root(),
			"uploads"    => $uploads['basedir']
		);

		foreach ($contents as $name => $value) {

			$name = __($name, 'adminify'); // Make translatable
			if (false === (get_transient($value)))
				echo '<span class="spacedark">' . $name . '</span>: ' . $this->jltwp_adminify_memory_usage_dir_size_display([$this->jltwp_adminify_memory_usage_dir_size($value)]) . '<br />';
			else
				echo '<span class="spacedark">' . $name . '</span>: ' . size_format(get_transient($value), 2) . '<br />';
		}

		echo '</div>';

		// WordPress Admin and Includes folders
		$wpadmin    = ABSPATH . 'wp-admin/';
		$wpincludes = ABSPATH . 'wp-includes/';

		echo '<div class="halfspace">
		<p><span class="spacedark">Other WP Folders</span></p>';

		// wp-admin and wp-includes folders
		$folders = array(
			"wp-admin"    => $wpadmin,
			"wp-includes" => $wpincludes
		);

		foreach ($folders as $name => $value) {

			$name = __($name, 'adminify'); // Make translatable

			if (false === (get_transient($value)))
				echo '<span class="spacedark">' . $name . '</span>: ' . $this->jltwp_adminify_memory_usage_dir_size_display([$this->jltwp_adminify_memory_usage_dir_size($value)]) . '<br />';
			else
				echo '<span class="spacedark">' . $name . '</span>: ' . size_format(get_transient($value), 2) . '<br />';
		}

		echo '</div>';
	}

	public function jltwp_adminify_memory_usage_dir_size_display($sizes = [])
	{
		$found_error = '';
		$total_size = 0;

		foreach ($sizes as $size) {
			if (is_numeric($size)) {
				$total_size += $size;
			} else {
				$found_error = $size;
				break;
			}
		}

		if (!empty($found_error)) {
			if ($found_error == 'error_not_readable') {
				return __('Failed to read', 'adminify');
			}
		}

		return size_format($total_size, 2);
	}

	public function jltwp_adminify_memory_usage_dir_size($path)
	{

		// Add trailing slash to path if missing
		if (substr($path, -1) != '/') $path .= '/';

		$readable = @is_readable($path);

		if ($readable) {

			if (false === ($total_size = get_transient($path))) {

				$total_size = 0;
				foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \FilesystemIterator::FOLLOW_SYMLINKS)) as $file) {
					if ( @is_readable($file) ) {
						$total_size += $file->getSize();
					}
				}

				// Set transient, expires in 1 hour
				set_transient($path, $total_size, 1 * HOUR_IN_SECONDS);

				return $total_size;
			} else {

				return $total_size;
			}
		} else {
			return 'error_not_readable';
		}
	}
}
