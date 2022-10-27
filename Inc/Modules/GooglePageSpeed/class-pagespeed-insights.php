<?php

namespace WPAdminify\Inc\Modules\PageSpeed_Insight;

class PageSpeed_Insight
{

	private $api_baseurl = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed';
	private $key;
	private $lab_datas_to_store;
	private $audit_keys_to_skip;

	public function __construct($key)
	{

		$this->key = $key;

		$this->lab_datas_to_store = apply_filters('wpadminify_lab_datas_to_store', array(
			'first-meaningful-paint',
			'first-contentful-paint',
			'interactive',
			'speed-index',
			'estimated-input-latency',
			'first-cpu-idle'
		));

		$this->audit_keys_to_skip = apply_filters('wpadminify_audit_keys_to_skip', array(
			// 'metrics',
			// 'network-requests'
		));
	}

	public function run_insight($object_url, $options = [])
	{

		$query_args = array(
			'url'		=> $object_url,
			'key'		=> $this->key,
			'locale'	=> isset($options['locale']) ? $options['locale'] : 'en_US',
			'strategy'	=> isset($options['strategy']) ? $options['strategy'] : 'desktop'
		);

		$api_url = add_query_arg($query_args, $this->api_baseurl);

		$api_request = wp_remote_get($api_url, array(
			'timeout'	=> apply_filters('wpadminify_remote_get_timeout', 300)
		));

		$api_response_code = wp_remote_retrieve_response_code($api_request);
		$api_response_body = json_decode(wp_remote_retrieve_body($api_request));

		$data = $this->get_final_data($api_response_body);

		return array(
			'responseCode'	=> $api_response_code,
			'data'			=> $data
		);
	}

	public function get_final_data($data)
	{

		$audits = $data->lighthouseResult->audits;

		$_audits = new \stdClass();;

		foreach ($audits as $audit_key => $audit) {

			if (in_array($audit_key, $this->audit_keys_to_skip)) continue;

			$audit->description	= $this->parse_markdown_style_links($audit->description);

			$_audits->$audit_key = $audit;
		}

		$data->lighthouseResult->audits = $_audits;

		return $data;
	}

	private function parse_markdown_style_links($string)
	{
		$replace = '<a href="${2}" target="_blank">${1}</a>';
		return preg_replace('/\[(.*?)\]\((.*?)\)/', $replace, $string);
	}




	public function get_lab_data($result, $lab_data = array())
	{

		foreach ($this->lab_datas_to_store as $index) {

			if (!isset($result->lighthouseResult->audits->$index)) continue;

			$lab_data[] = array(
				'title'			=> $result->lighthouseResult->audits->$index->title,
				'description'	=> $this->parse_markdown_style_links($result->lighthouseResult->audits->$index->description),
				'score'			=> $result->lighthouseResult->audits->$index->score,
				'displayValue'	=> $result->lighthouseResult->audits->$index->displayValue
			);
		}

		return serialize($lab_data);
	}

	public function get_field_data($result, $field_data = array())
	{

		if (!isset($result->loadingExperience->metrics)) return $field_data;

		return serialize($result->loadingExperience->metrics);
	}

	public function get_page_reports($result, $page_id, $strategy, $options, $page_reports = array())
	{

		$rule_results = $result->lighthouseResult->audits;

		if (!empty($rule_results)) {
			foreach ($rule_results as $rulename => $results_obj) {

				if (in_array($rulename, $this->lab_datas_to_store)) continue;

				if (in_array($rulename, $this->audit_keys_to_skip)) continue;

				if ('screenshot-thumbnails' == $rulename && !$options['store_screenshots']) continue;

				$page_reports[] = array(
					'page_id'		=> $page_id,
					'strategy'		=> $strategy,
					'rule_key'		=> $rulename,
					'rule_name'		=> $results_obj->title,
					'rule_score'	=> $results_obj->score,
					'rule_type'		=> isset($results_obj->details->type) ? $results_obj->details->type : 'n/a',
					'rule_blocks'	=> $this->get_rule_blocks($results_obj)
				);
			}
		}

		return $page_reports;
	}

	private function get_rule_blocks($results_obj, $rule_blocks = array())
	{

		if (isset($results_obj->description)) {
			$rule_blocks['description'] = $this->parse_markdown_style_links($results_obj->description);
		}

		if (isset($results_obj->scoreDisplayMode)) {
			$rule_blocks['score_display_mode'] = $results_obj->scoreDisplayMode;
		}

		if (isset($results_obj->displayValue)) {
			$rule_blocks['display_value'] = $results_obj->displayValue;
		} else {
			$rule_blocks['display_value'] = '';
		}

		$keys_to_number_format = array(
			'url',
			'wastedMs',
			'scriptParseCompile',
			'total',
			'scripting',
			'duration',
			'totalBytes',
			'wastedBytes',
			'cacheLifetimeMs'
		);

		if (isset($results_obj->details->items)) {
			foreach ($results_obj->details->items as $index => $data) {
				foreach ($data as $key => $value) {
					if (!in_array($key, $keys_to_number_format)) continue;

					if ('url' == $key) {
						$value = $this->link_urls($value);
					} else if ('cacheLifetimeMs' == $key) {
						$value = $this->human_readable_timing($value);
					} else {
						$value = number_format($value);
					}

					$results_obj->details->items[$index]->$key = $value;
				}
			}
		}

		if (isset($results_obj->details)) {
			$rule_blocks['details'] = $results_obj->details;
		}

		return serialize($rule_blocks);
	}

	private function human_readable_timing($value)
	{

		if (empty($value)) return $value;

		$time = $value / 1000;

		$tokens = array(
			YEAR_IN_SECONDS => __('year', 'gpagespeedi'),
			MONTH_IN_SECONDS => __('month', 'gpagespeedi'),
			WEEK_IN_SECONDS => __('week', 'gpagespeedi'),
			DAY_IN_SECONDS => __('day', 'gpagespeedi'),
			HOUR_IN_SECONDS => __('hour', 'gpagespeedi'),
			MINUTE_IN_SECONDS => __('minute', 'gpagespeedi'),
			1 => __('second', 'gpagespeedi')
		);

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;

			$number_of_units = floor($time / $unit);

			return $number_of_units . ' ' . $text . (($number_of_units > 1) ? _x('s', 'make preceeding time unit plural', 'gpagespeedi') : '');
		}
	}

	private function link_urls($value)
	{

		$url = esc_url($value);

		if (!$url) return $value;

		return '<a href="' . $url . '" target="_blank">' . $value . '</a>';
	}
}
