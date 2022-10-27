<?php

namespace WPAdminify\Inc\Admin\Options;

use WPAdminify\Inc\Utils;
use WPAdminify\Inc\Admin\AdminSettingsModel;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

if (!class_exists('Module_Google_PagesSpeed')) {
    class Module_Google_PagesSpeed extends AdminSettingsModel
    {
        public function __construct()
        {
            $this->google_pagepseed_settings();
        }


        public function get_defaults()
        {
            return [
                'google_pagepseed_user_roles' => [],
                'google_pagepseed_api_key'    => ''
            ];
        }


        /**
         * Media Elements Sortable
         *
         * @return void
         */

        public function google_pagepseed_api_key(&$fields)
        {
            $fields[] = array(
                'type'    => 'subheading',
                'content'   => Utils::adminfiy_help_urls(
                    __('Google Pagespeed Settings', 'adminify'),
                    'https://wpadminify.com/kb/google-pagespeed-insights/',
                    'https://www.youtube.com/playlist?list=PLqpMw0NsHXV-EKj9Xm1DMGa6FGniHHly8',
                    'https://www.facebook.com/groups/jeweltheme',
                    'https://wpadminify.com/support/google-pagespeed-insights/'
                )
            );

            $fields[] = array(
                'id'          => 'google_pagepseed_user_roles',
                'type'        => 'select',
                'title'       => 'Disable for',
                'placeholder' => 'Select User roles you want to show',
                'options'     => 'roles',
                'multiple'    => true,
                'chosen'      => true,
                'default'     => $this->get_default_field('google_pagepseed_user_roles'),
            );

            $fields[] = array(
                'id'      => 'google_pagepseed_api_key',
                'type'    => 'textarea',
                'title'   => 'Google API Key',
                'after'   => sprintf(__('Don\'t have API key? Create one from <a href="%1$s" target="_blank">Google Console</a> to Unlock this feature. Read the full <a href="%2$s" target="_blank">Documentation</a>', 'adminify'), esc_url('https://console.developers.google.com'), esc_url('https://wpadminify.com/kb/how-to-create-google-api-key')),
                'default' => $this->get_default_field('google_pagepseed_api_key'),
            );
        }


        public function google_pagepseed_settings()
        {

            if (!class_exists('ADMINIFY')) {
                return;
            }

            $fields = [];
            $this->google_pagepseed_api_key($fields);

            // Google PageSpeed Order Section
            \ADMINIFY::createSection($this->prefix, array(
                'title'  => __('Google PageSpeed', 'adminify'),
                'id'     => 'module_google_pagespeed_section',
                'parent' => 'module_settings',
                'icon'   => 'fas fa-tachometer-alt',
                'fields' => $fields
            ));
        }
    }
}
