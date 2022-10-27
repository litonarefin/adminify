<?php

namespace WPAdminify\Inc\Classes;

class Upgrade {

    /**
     * Plugin version option key
     *
     * @var string $option_name
     */
    protected $option_name = 'wp_adminify_version';

    /**
     * Lists of upgrades
     *
     * @var string[] $upgrades
     */
    protected $upgrades = [
        '3.0.2' => 'Upgrades/upgrade-3.0.2.php'
    ];

    /**
     * Get plugin installed version
     *
     * @return string
     */
    protected function get_installed_version() {
        return get_option( $this->option_name, '1.0.0' );
    }

    /**
     * Check if plugin's update is available
     *
        * @return bool
     */
    public function if_updates_available() {
        if ( version_compare( $this->get_installed_version(), WP_ADMINIFY_VER, '<' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Run plugin updates
     *
     * @return void
     */
    public function run_updates() {
        $installed_version = $this->get_installed_version();
        $path              = trailingslashit( __DIR__ );

        foreach ( $this->upgrades as $version => $file ) {
            if ( version_compare( $installed_version, $version, '<' ) ) {
                include $path . $file;
            }
        }

        // update_option( $this->option_name, WP_ADMINIFY_VER );
    }

}
