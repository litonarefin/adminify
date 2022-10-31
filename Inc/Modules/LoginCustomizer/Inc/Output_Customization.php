<?php

namespace WPAdminify\Inc\Modules\LoginCustomizer\Inc;

use  WPAdminify\Inc\Utils ;
use  WPAdminify\Inc\Classes\Assets ;
// Cannot access directly.
if ( !defined( 'ABSPATH' ) ) {
    die;
}
if ( !class_exists( 'Output_Customization' ) ) {
    class Output_Customization
    {
        public  $url ;
        public  $options ;
        public function __construct()
        {
            $this->options = ( new Customize_Settings() )->get();
            $this->url = WP_ADMINIFY_URL . 'Inc/Modules/LoginCustomizer';
            // Don't index any of these forms
            add_action( 'login_head', [ $this, 'login_viewport_meta' ] );
            add_action( 'login_init', [ $this, 'check_general_texts' ] );
            add_action( 'login_form_login', [ $this, 'check_login_texts' ] );
            add_action( 'login_form_register', [ $this, 'check_register_texts' ] );
            add_action( 'login_form_lostpassword', [ $this, 'check_lostpasswords_texts' ] );
            add_action( 'login_header', [ $this, 'add_extra_div' ] );
            add_action( 'jltwp_adminify_login_header', [ $this, 'add_extra_div' ] );
            add_action( 'login_footer', [ $this, 'close_extra_div' ] );
            add_action( 'jltwp_adminify_login_footer', [ $this, 'close_extra_div' ] );
            add_action( 'login_header', [ $this, 'add_header_html' ] );
            add_action( 'jltwp_adminify_login_header', [ $this, 'add_header_html' ] );
            add_action( 'login_footer', [ $this, 'add_footer_html' ] );
            add_action( 'jltwp_adminify_login_footer', [ $this, 'add_footer_html' ] );
            add_action( 'login_footer', [ $this, 'add_video_html' ] );
            add_action( 'jltwp_adminify_login_footer', [ $this, 'add_video_html' ] );
            add_action( 'login_footer', [ $this, 'add_slideshow_html' ] );
            add_action( 'jltwp_adminify_login_footer', [ $this, 'add_slideshow_html' ] );
            add_action(
                'wp_adminify_add_templates',
                [ $this, 'add_templates' ],
                10,
                1
            );
            // add_action('login_head', [$this, 'print_login_styles'], 20);
            add_action( 'login_head', [ $this, 'print_login_styles' ] );
            add_action( 'customize_preview_init', [ $this, 'login_inline_style' ], 99 );
            if ( !is_customize_preview() ) {
                add_action( 'login_enqueue_scripts', [ $this, 'login_inline_style' ], 99 );
            }
            add_action( 'login_enqueue_scripts', [ $this, 'jltwp_adminify_login_enqueue_scripts' ], 99 );
            add_filter( 'login_body_class', [ $this, 'jltwp_adminify_login_body_class' ] );
            add_filter( 'login_headerurl', [ $this, 'login_logo_url' ], 99 );
            
            if ( version_compare( $GLOBALS['wp_version'], '5.2', '<' ) ) {
                add_filter( 'login_headertitle', [ $this, 'logo_title' ] );
            } else {
                add_filter( 'login_headertext', [ $this, 'logo_title' ] );
            }
            
            add_filter( 'login_errors', [ $this, 'login_error_messages' ] );
            add_filter( 'login_title', [ $this, 'login_page_title' ], 99 );
            // TODO
            // add_filter('login_messages', [$this, 'change_welcome_message']);
            // add_filter('woocommerce_process_login_errors',     [$this, 'woo_login_errors'], 10, 3);
            $this->enable_wp_shake_js();
        }
        
        // Body class
        public function jltwp_adminify_login_body_class( $classes )
        {
            $position = !empty($this->options['credits_logo_position']['background-position']);
            $position = Utils::jltwp_adminify_class_cleanup( $position );
            $position = 'wp-adminify-badge-' . esc_attr( $position );
            $classes[] = $position;
            $classes[] = 'wp-adminify';
            $classes[] = 'wp-adminify-login-customizer';
            // Logo Settings
            if ( isset( $this->options['logo_settings'] ) && 'text-only' == $this->options['logo_settings'] ) {
                $classes[] = 'wp-adminify-text-logo';
            }
            if ( isset( $this->options['logo_settings'] ) && 'both' == $this->options['logo_settings'] ) {
                $classes[] = 'wp-adminify-image-logo wp-adminify-text-logo';
            }
            if ( isset( $this->options['logo_settings'] ) && 'image-only' == $this->options['logo_settings'] ) {
                $classes[] = 'wp-adminify-image-logo';
            }
            // Column Widths
            if ( !empty($this->options['alignment_login_width']) && $this->options['alignment_login_width'] == 'fullwidth' ) {
                if ( !empty($this->options['alignment_login_bg_skew']) != 0 ) {
                    $classes[] = 'wp-adminify-fullwidth';
                }
            }
            
            if ( !empty($this->options['alignment_login_width']) && $this->options['alignment_login_width'] == 'width_two_column' ) {
                $classes[] = 'wp-adminify-half-screen';
                if ( isset( $this->options['alignment_login_column'] ) ) {
                    $classes[] = 'jltwp-adminify-login-' . esc_attr( $this->options['alignment_login_column'] );
                }
            }
            
            if ( !empty($this->options['alignment_login_vertical']) ) {
                $classes[] = 'wp-adminify-vertical-align-' . esc_attr( $this->options['alignment_login_vertical'] );
            }
            if ( !empty($this->options['alignment_login_horizontal']) ) {
                $classes[] = 'wp-adminify-horizontal-align-' . esc_attr( $this->options['alignment_login_horizontal'] );
            }
            if ( !empty($this->options['jltwp_adminify_login_bg_type']) == 'slideshow' ) {
                $classes[] = 'adminify-slideshow';
            }
            return $classes;
        }
        
        public function get_free_templates()
        {
            return [
                'template-01',
                'template-02',
                'template-03',
                'template-04'
            ];
        }
        
        public function is_pro_template( $template )
        {
            return !in_array( $template, (array) $this->get_free_templates() );
        }
        
        public function add_templates( $selected_template )
        {
            if ( empty($selected_template) ) {
                return include_once plugin_dir_path( __FILE__ ) . 'templates/template-01.php';
            }
            if ( !$this->is_pro_template( $selected_template ) ) {
                return include_once plugin_dir_path( __FILE__ ) . 'templates/' . $selected_template . '.php';
            }
            include_once plugin_dir_path( __FILE__ ) . 'templates/template-01.php';
        }
        
        public function jltwp_adminify_login_enqueue_scripts()
        {
            
            if ( !empty($this->options['jltwp_adminify_login_bg_type']) == 'slideshow' ) {
                wp_enqueue_style( 'wp-adminify-vegas', WP_ADMINIFY_ASSETS . 'vendors/vegas/vegas.min.css' );
                wp_enqueue_script(
                    'wp-adminify-vegas',
                    WP_ADMINIFY_ASSETS . 'vendors/vegas/vegas.min.js',
                    [ 'jquery' ],
                    WP_ADMINIFY_VER,
                    true
                );
            }
        
        }
        
        public function login_inline_style()
        {
            $css = '';
            // register & lost pasword disable from login form
            if ( !is_customize_preview() ) {
                
                if ( get_option( 'users_can_register' ) == 1 ) {
                    
                    if ( !empty($this->options['login_form_disable_register']) ) {
                        $css .= 'body.wp-adminify-login-customizer p#nav a:nth-child(1) { display:none;}';
                        $css .= 'body.wp-adminify-login-customizer p#nav { color:transparent !important;}';
                    } else {
                        $css .= 'body.wp-adminify-login-customizer p#nav a:nth-child(1) { display:revert;}';
                    }
                    
                    
                    if ( !empty($this->options['login_form_disable_lost_pass']) ) {
                        $css .= 'body.wp-adminify-login-customizer p#nav a:nth-child(2) { display:none;}';
                        $css .= 'body.wp-adminify-login-customizer p#nav { color:transparent !important;}';
                    } else {
                        $css .= 'body.wp-adminify-login-customizer p#nav a:nth-child(2) { display:revert;}';
                    }
                
                } else {
                    if ( !empty($this->options['login_form_disable_lost_pass']) ) {
                        $css .= 'body.wp-adminify-login-customizer p#nav { display:none;}';
                    }
                }
            
            }
            $css .= '
			.wp-adminify-badge {
				overflow: hidden;
				position: absolute;
				bottom: 15px;
				display: none;
				right: 15px;
				z-index: 2;
			}

			.wp-adminify-badge.left {
				left: 15px;
				right: inherit;
			}
            .wp-adminify-badge.left-center {
                right: inherit;
                top: 48.25%;
                bottom: inherit;
                transform: translateY(-50%);
            }
            .wp-adminify-badge.left-top {
                right: inherit;
                left: 15px;
                top: 15px;
            }
            .wp-adminify-badge.left-bottom {
                right: inherit;
                left: 20px;
            }
            .wp-adminify-badge.center-top{
                right: inherit;
                left: 50%;
                top: 0;
                transform: translateX(-50%);
            }
            .wp-adminify-badge.center-center {
                top: 50%;
                left: 50%;
                bottom: inherit;
                right: inherit;
                transform: translate(-50%, -50%);
            }
            .wp-adminify-badge.center-bottom{
                right: inherit;
                left: 50%;
                bottom: 15px;
                transform: translateX(-50%);
            }
            .wp-adminify-badge.right-top {
                top: 15px;
            }
            .wp-adminify-badge.right-center {
                top: 50%;
                bottom: inherit;
                transform: translateY(-50%);
            }

			.wp-adminify-badge.right {
				right: 15px;
			}

			.wp-adminify-badge.middle {
				left: 15px;
				right: 15px;
				margin: 0 auto;
			}

			.wp-adminify-badge.top-right {
				top: 15px;
				right: 15px;
				bottom: inherit;
			}

			@media screen and (min-width: 600px) {
				.wp-adminify-badge {
					display: block;
				}
			}

			@media screen and (max-height: 600px) {
				.wp-adminify-badge {
					display: none;
				}
			}

			.wp-adminify-badge.is-hidden .wp-adminify-badge__inner {
				opacity: 0;
				transform: scale(0);
				transition: transform 500ms cubic-bezier(0.694, 0.0482, 0.335, 1), opacity 200ms cubic-bezier(0.694, 0.0482, 0.335, 1);
			}

			.wp-adminify-badge__inner {
				display: -webkit-box;
				display: -webkit-flex;
				display: -ms-flexbox;
				display: flex;
				-webkit-align-content: center;
				-ms-flex-line-pack: center;
				align-content: center;
				-webkit-box-pack: center;
				-webkit-justify-content: center;
				-ms-flex-pack: center;
				justify-content: center;
				-webkit-box-align: center;
				-webkit-align-items: center;
				-ms-flex-align: center;
				align-items: center;
				position: relative;
				padding: 8px 15px;
				transition: transform 500ms cubic-bezier(0.694, 0.0482, 0.335, 1), opacity 200ms cubic-bezier(0.694, 0.0482, 0.335, 1) 300ms;
			}

			.wp-adminify-badge__text {
				position: relative;
				padding-right: 7px;
				line-height: 1;
                font-size:16px;
			}

			.wp-adminify-badge .icon {
				width: 164px;
				height: 35px;
			}

			.wp-adminify-badge__link {
				position: absolute;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				height: 100%;
				width: 100%;
				z-index: 9;
			}
			';
            // Branding text color.
            if ( isset( $this->options['credits_text_color'] ) ) {
                $css .= '.wp-adminify-badge__text { color:' . esc_attr( $this->options['credits_text_color'] ) . ';}';
            }
            // Icon color.
            if ( isset( $this->options['branding_icon_color'] ) ) {
                $css .= '.wp-adminify-badge .icon { color:' . esc_attr( $this->options['branding_icon_color'] ) . ';}';
            }
            if ( is_customize_preview() ) {
                $css .= '
				body:not(.wp-adminify) .wp-adminify-badge {
					display: none !important;
				}
				';
            }
            // Combine the values from above and minifiy them.
            $css = preg_replace( '#/\\*.*?\\*/#s', '', $css );
            $css = preg_replace( '/\\s*([{}|:;,])\\s+/', '$1', $css );
            $css = preg_replace( '/\\s\\s+(.*)/', '$1', $css );
            // Add inline style.
            wp_add_inline_style( 'login', wp_strip_all_tags( $css ) );
            if ( is_customize_preview() ) {
                wp_add_inline_style( 'customize-preview', wp_strip_all_tags( $css ) );
            }
        }
        
        // WP Shake JS
        public function enable_wp_shake_js()
        {
            if ( !empty($this->options['login_form_disable_login_shake']) && $this->options['login_form_disable_login_shake'] ) {
                remove_action( 'login_head', [ $this, 'wp_shake_js' ], 15 );
            }
        }
        
        public function login_logo_url( $logo_url )
        {
            $logo_link = $this->options['logo_login_url'];
            if ( !empty($logo_link) && !empty($logo_link['url']) ) {
                return $logo_link['url'];
            }
            return $logo_url;
        }
        
        /**
         * Filters the logo image title attribute.
         *
         * @see https://developer.wordpress.org/reference/hooks/login_headertext/
         *
         * @access public
         */
        public function logo_title( $title )
        {
            if ( isset( $this->options['logo_text'] ) ) {
                return wp_kses_post( $this->options['logo_text'] );
            }
            return $title;
        }
        
        public function login_page_title( $title )
        {
            if ( !empty($this->options['login_page_title']) ) {
                return esc_html( $this->options['login_page_title'] );
            }
            return $title;
        }
        
        /*
         * Output the Inline CSS
         */
        public function print_login_styles()
        {
            $position_class = !empty($this->options['credits_logo_position']['background-position']);
            $position_class = Utils::jltwp_adminify_class_cleanup( $position_class );
            // Login Style
            require dirname( __FILE__ ) . '/login-styles.php';
            // Login Preset Style
            include dirname( __FILE__ ) . '/login-preset-styles.php';
            // Login Custom Style
            include dirname( __FILE__ ) . '/login-custom-styles.php';
            // Google Font
            require dirname( __FILE__ ) . '/google-font.php';
            // Branding
            require dirname( __FILE__ ) . '/branding.php';
        }
        
        /**
         * Remove the filter login_errors from woocommerce login form.
         * * * * * * * * * * * * */
        function woo_login_errors( $validation_error, $arg1, $arg2 )
        {
            remove_filter( 'login_errors', [ $this, 'login_error_messages' ] );
            return $validation_error;
        }
        
        /**
         * Set Errors Messages to Show off
         * * * * * * * * * * * * * * * * */
        public function login_error_messages( $error )
        {
            global  $errors ;
            
            if ( isset( $errors ) && apply_filters( 'wp_adminify_display_custom_errors', true ) ) {
                $error_codes = $errors->get_error_codes();
                
                if ( $this->options['login_error_messages'] ) {
                    // Username
                    $invalid_username = ( array_key_exists( 'error_incorrect_username', $this->options['login_error_messages'] ) && !empty($this->options['login_error_messages']['error_incorrect_username']) ? $this->options['login_error_messages']['error_incorrect_username'] : sprintf( __( '%1$sError:%2$s Invalid Username.', 'adminify' ), '<strong>', '</strong>' ) );
                    $empty_username = ( array_key_exists( 'error_empty_username', $this->options['login_error_messages'] ) && !empty($this->options['login_error_messages']['error_empty_username']) ? $this->options['login_error_messages']['error_empty_username'] : sprintf( __( '%1$sError:%2$s The username field is empty.', 'adminify' ), '<strong>', '</strong>' ) );
                    $username_exists = ( array_key_exists( 'error_exists_username', $this->options['login_error_messages'] ) && !empty($this->options['login_error_messages']['error_exists_username']) ? $this->options['login_error_messages']['error_exists_username'] : sprintf( __( '%1$sError:%2$s This username is already registered. Please choose another one.', 'adminify' ), '<strong>', '</strong>' ) );
                    // Password
                    $invalid_pasword = ( array_key_exists( 'error_incorrect_password', $this->options['login_error_messages'] ) && !empty($this->options['login_error_messages']['error_incorrect_password']) ? $this->options['login_error_messages']['error_incorrect_password'] : sprintf( __( '%1$sError:%2$s Invalid Password.', 'adminify' ), '<strong>', '</strong>' ) );
                    $empty_password = ( array_key_exists( 'error_empty_password', $this->options['login_error_messages'] ) && !empty($this->options['login_error_messages']['error_empty_password']) ? $this->options['login_error_messages']['error_empty_password'] : sprintf( __( '%1$sError:%2$s The password field is empty.', 'adminify' ), '<strong>', '</strong>' ) );
                    // Email
                    $invalid_email = ( array_key_exists( 'error_incorrect_email', $this->options['login_error_messages'] ) && !empty($this->options['login_error_messages']['error_incorrect_email']) ? $this->options['login_error_messages']['error_incorrect_email'] : sprintf( __( '%1$sError:%2$s The email address isn\'t correct..', 'adminify' ), '<strong>', '</strong>' ) );
                    $empty_email = ( array_key_exists( 'error_empty_email', $this->options['login_error_messages'] ) && !empty($this->options['login_error_messages']['error_empty_email']) ? $this->options['login_error_messages']['error_empty_email'] : sprintf( __( '%1$sError:%2$s Please type your email address.', 'adminify' ), '<strong>', '</strong>' ) );
                    $email_exists = ( array_key_exists( 'error_exists_email', $this->options['login_error_messages'] ) && !empty($this->options['login_error_messages']['error_exists_email']) ? $this->options['login_error_messages']['error_exists_email'] : sprintf( __( '%1$sError:%2$s This email is already registered, please choose another one.', 'adminify' ), '<strong>', '</strong>' ) );
                    $invalidcombo = ( array_key_exists( 'invalidcombo_message', $this->options['login_error_messages'] ) && !empty($this->options['login_error_messages']['invalidcombo_message']) ? $this->options['login_error_messages']['invalidcombo_message'] : sprintf( __( '%1$sError:%2$s Invalid username or email.', 'adminify' ), '<strong>', '</strong>' ) );
                    // Username
                    if ( in_array( 'error_incorrect_username', $error_codes ) ) {
                        return $invalid_username;
                    }
                    if ( in_array( 'error_empty_username', $error_codes ) ) {
                        return $empty_username;
                    }
                    if ( in_array( 'error_exists_username', $error_codes ) ) {
                        return $username_exists;
                    }
                    // Password
                    if ( in_array( 'error_incorrect_password', $error_codes ) ) {
                        return $invalid_pasword;
                    }
                    if ( in_array( 'error_empty_password', $error_codes ) ) {
                        return $empty_password;
                    }
                    // Email
                    if ( in_array( 'error_incorrect_email', $error_codes ) ) {
                        return $invalid_email;
                    }
                    if ( in_array( 'error_empty_email', $error_codes ) ) {
                        return '</br>' . $empty_email;
                    }
                    // registeration Form enteries.
                    if ( in_array( 'error_exists_email', $error_codes ) ) {
                        return $email_exists;
                    }
                    // forget password entery.
                    if ( in_array( 'invalidcombo', $error_codes ) ) {
                        return $invalidcombo;
                    }
                }
            
            }
            
            return $error;
        }
        
        /**
         * Manage Welcome Messages
         *
         * @param   $message
         * @since   1.0.0
         * @return string
         * * * * * * * * * * * * */
        public function change_welcome_message( $message )
        {
            
            if ( $this->options ) {
                // Check, User Logedout.
                
                if ( isset( $_GET['loggedout'] ) && true == $_GET['loggedout'] ) {
                    if ( array_key_exists( 'logout_message', $this->options ) && !empty($this->options['logout_message']) ) {
                        $loginpress_message = $this->options['logout_message'];
                    }
                } elseif ( strpos( $message, __( 'Please enter your username or email address. You will receive a link to create a new password via email.' ) ) == true ) {
                    if ( array_key_exists( 'lostpwd_welcome_message', $this->options ) && !empty($this->options['lostpwd_welcome_message']) ) {
                        $loginpress_message = $this->options['lostpwd_welcome_message'];
                    }
                } elseif ( strpos( $message, __( 'Register For This Site' ) ) == true ) {
                    if ( array_key_exists( 'register_welcome_message', $this->options ) && !empty($this->options['register_welcome_message']) ) {
                        $loginpress_message = $this->options['register_welcome_message'];
                    }
                } elseif ( strpos( $message, __( 'Your password has been reset.' ) ) == true ) {
                    // if ( array_key_exists( 'after_reset_message', $this->options ) && ! empty( $this->options['after_reset_message'] ) ) {
                    $loginpress_message = __( 'Your password has been reset.' ) . ' <a href="' . esc_url( wp_login_url() ) . '">' . __( 'Log in' ) . '</a></p>';
                    // }
                } else {
                    if ( array_key_exists( 'welcome_message', $this->options ) && !empty($this->options['welcome_message']) ) {
                        $loginpress_message = $this->options['welcome_message'];
                    }
                }
                
                return ( !empty($loginpress_message) ? "<p class='custom-message'>" . $loginpress_message . '</p>' : $message );
            }
        
        }
        
        public function add_header_html()
        {
            ?>
			<div class="wp-adminify-background">
				<div class="wp-adminify-background-wrapper">
					<div class="login-background"></div>
				</div>
			</div>
			<div class="columns all-centered">
			<?php 
        }
        
        public function add_footer_html()
        {
            echo  '</div></div></div>' ;
        }
        
        // Video Background
        public function add_video_html()
        {
            
            if ( !empty($this->options['jltwp_adminify_login_bg_type']) && $this->options['jltwp_adminify_login_bg_type'] === 'video' ) {
                $video_html = '';
                require dirname( __FILE__ ) . '/footer-video.php';
                return $video_html;
            } elseif ( is_customize_preview() ) {
                printf( '<script type="text/javascript" src="%s?ver=%s"></script>', WP_ADMINIFY_ASSETS . 'vendors/vidim/vidim.min.js', WP_ADMINIFY_VER );
            }
        
        }
        
        // Slideshow
        public function add_slideshow_html()
        {
            
            if ( !empty($this->options['jltwp_adminify_login_bg_type']) && $this->options['jltwp_adminify_login_bg_type'] === 'slideshow' ) {
                $slideshow_html = '';
                require dirname( __FILE__ ) . '/footer-slideshow.php';
                return $slideshow_html;
            }
        
        }
        
        public function add_extra_div()
        {
            echo  '<div class="wp-adminify-container"><div class="wp-adminify-form-container">' ;
        }
        
        public function close_extra_div()
        {
            echo  '</div></div>' ;
        }
        
        // Check Login page texts
        public function check_login_texts()
        {
            add_filter(
                'gettext',
                [ $this, 'change_username_label' ],
                99,
                3
            );
            add_filter(
                'gettext',
                [ $this, 'change_password_label' ],
                99,
                3
            );
            add_filter(
                'gettext',
                [ $this, 'change_rememberme_label' ],
                99,
                3
            );
            add_filter(
                'gettext',
                [ $this, 'change_login_label' ],
                99,
                3
            );
            add_filter(
                'gettext',
                [ $this, 'change_register_login_link_text' ],
                99,
                3
            );
        }
        
        // Check Register page texts
        public function check_register_texts()
        {
            add_filter(
                'gettext',
                [ $this, 'change_register_username_label' ],
                99,
                3
            );
            add_filter(
                'gettext',
                [ $this, 'change_register_email_label' ],
                99,
                3
            );
            add_filter(
                'gettext',
                [ $this, 'change_register_register_label' ],
                99,
                3
            );
            add_filter(
                'gettext',
                [ $this, 'change_register_confirmation_text' ],
                99,
                3
            );
            add_filter(
                'gettext',
                [ $this, 'change_login_register_link_text' ],
                99,
                3
            );
        }
        
        // Check Lost Password page texts
        public function check_lostpasswords_texts()
        {
            add_filter(
                'gettext',
                [ $this, 'change_lostpasswords_username_label' ],
                99,
                3
            );
            add_filter(
                'gettext',
                [ $this, 'change_lostpasswords_button_label' ],
                99,
                3
            );
            add_filter(
                'gettext',
                [ $this, 'change_register_login_link_text' ],
                99,
                3
            );
            add_filter(
                'gettext',
                [ $this, 'change_login_register_link_text' ],
                99,
                3
            );
        }
        
        public function get_image_urls_by_ids( $ids = '' )
        {
            if ( empty($ids) ) {
                return [];
            }
            $image_ids = explode( ',', $ids );
            $images = [];
            foreach ( $image_ids as $image_id ) {
                $image_url = wp_get_attachment_url( $image_id );
                if ( !empty($image_url) ) {
                    $images[] = [
                        'src' => $image_url,
                    ];
                }
            }
            return $images;
        }
        
        /**
         * Customizer output for custom register username label.
         *
         * @param string|string $translated_text The translated text.
         * @param string|string $text The label we want to replace.
         * @param string|string $domain The text domain of the site.
         * @return string
         */
        public function change_register_username_label( $translated_text, $text, $domain )
        {
            $default = 'Username';
            // Check if is our text
            if ( $default !== $text ) {
                return $translated_text;
            }
            $label = ( isset( $this->options['login_form_fields']['label_username'] ) ? $this->options['login_form_fields']['label_username'] : $default );
            // Check if the label is changed
            
            if ( $label === $text ) {
                return $translated_text;
            } else {
                $translated_text = wp_kses_post( $label );
            }
            
            return $translated_text;
        }
        
        /**
         * Customizer output for custom register email label.
         *
         * @param string|string $translated_text The translated text.
         * @param string|string $text The label we want to replace.
         * @param string|string $domain The text domain of the site.
         * @return string
         */
        public function change_register_email_label( $translated_text, $text, $domain )
        {
            $default = 'Username or Email Address';
            // Check if is our text
            if ( $default !== $text ) {
                return $translated_text;
            }
            $label = ( isset( $this->options['login_form_fields']['label_username'] ) ? $this->options['login_form_fields']['label_username'] : $default );
            // Check if the label is changed
            
            if ( $label === $text ) {
                return $translated_text;
            } else {
                $translated_text = esc_html( $label );
            }
            
            return $translated_text;
        }
        
        /**
         * Customizer output for custom register button text.
         *
         * @param string|string $translated_text The translated text.
         * @param string|string $text The label we want to replace.
         * @param string|string $domain The text domain of the site.
         * @return string
         */
        public function change_register_register_label( $translated_text, $text, $domain )
        {
            $default = 'Register';
            // Check if is our text
            if ( $default !== $text ) {
                return $translated_text;
            }
            $label = ( isset( $this->options['login_form_fields']['label_register'] ) ? $this->options['login_form_fields']['label_register'] : $default );
            // Check if the label is changed
            
            if ( $label === $text ) {
                return $translated_text;
            } else {
                $translated_text = esc_html( $label );
            }
            
            return $translated_text;
        }
        
        /**
         * Customizer output for custom registration confirmation text.
         *
         * @param string|string $translated_text The translated text.
         * @param string|string $text The label we want to replace.
         * @param string|string $domain The text domain of the site.
         * @return string
         */
        public function change_register_confirmation_text( $translated_text, $text, $domain )
        {
            $default = 'Registration confirmation will be emailed to you.';
            // Check if is our text
            if ( $default !== $text ) {
                return $translated_text;
            }
            // $label   = $this->options['register-confirmation-email'];
            $label = 'Confirm your Email';
            // Check if the label is changed
            
            if ( $label === $text ) {
                return $translated_text;
            } else {
                $translated_text = wp_kses_post( $label );
            }
            
            return $translated_text;
        }
        
        public function change_login_register_link_text( $translated_text, $text, $domain )
        {
            $default = 'Log in';
            // Check if is our text
            if ( $default !== $text ) {
                return $translated_text;
            }
            $label = ( isset( $this->options['login_form_fields']['input_login'] ) ? $this->options['login_form_fields']['input_login'] : $default );
            // Check if the label is changed
            
            if ( $label === $text ) {
                return $translated_text;
            } else {
                $translated_text = esc_html( $label );
            }
            
            return $translated_text;
        }
        
        /**
         * Customizer output for custom username label.
         *
         * @param string|string $translated_text The translated text.
         * @param string|string $text The label we want to replace.
         * @param string|string $domain The text domain of the site.
         * @return string
         */
        public function change_username_label( $translated_text, $text, $domain )
        {
            $default = 'Username or Email Address';
            // Check if is our text
            if ( $default !== $text ) {
                return $translated_text;
            }
            $label = ( isset( $this->options['login_form_fields']['label_username'] ) ? $this->options['login_form_fields']['label_username'] : $default );
            // Check if the label is changed
            
            if ( $label === $text ) {
                return $translated_text;
            } else {
                $translated_text = wp_kses_post( $label );
            }
            
            return $translated_text;
        }
        
        /**
         * Customizer output for custom password label.
         *
         * @param string|string $translated_text The translated text.
         * @param string|string $text The label we want to replace.
         * @param string|string $domain The text domain of the site.
         * @return string
         */
        public function change_password_label( $translated_text, $text, $domain )
        {
            $default = 'Password';
            // Check if is our text
            if ( $default !== $text ) {
                return $translated_text;
            }
            $label = ( isset( $this->options['login_form_fields']['label_password'] ) ? $this->options['login_form_fields']['label_password'] : $default );
            // Check if the label is changed
            
            if ( $label === $text ) {
                return $translated_text;
            } else {
                $translated_text = esc_html( $label );
            }
            
            return $translated_text;
        }
        
        /**
         * Customizer output for custom remember me text.
         *
         * @param string|string $translated_text The translated text.
         * @param string|string $text The label we want to replace.
         * @param string|string $domain The text domain of the site.
         * @return string
         */
        public function change_rememberme_label( $translated_text, $text, $domain )
        {
            $default = 'Remember Me';
            // Check if is our text
            if ( $default !== $text ) {
                return $translated_text;
            }
            $label = ( isset( $this->options['login_form_fields']['label_remember_me'] ) ? $this->options['login_form_fields']['label_remember_me'] : $default );
            // Check if the label is changed
            
            if ( $label === $text ) {
                return $translated_text;
            } else {
                $translated_text = esc_html( $label );
            }
            
            return $translated_text;
        }
        
        // Check general texts
        public function check_general_texts()
        {
            add_filter(
                'gettext',
                [ $this, 'change_lost_password_text' ],
                99,
                3
            );
            add_filter(
                'gettext_with_context',
                [ $this, 'change_back_to_text' ],
                99,
                4
            );
        }
        
        /**
         * Customizer output for custom lost your password text.
         *
         * @param string|string $translated_text The translated text.
         * @param string|string $text The label we want to replace.
         * @param string|string $domain The text domain of the site.
         * @return string
         */
        public function change_lost_password_text( $translated_text, $text, $domain )
        {
            $default = 'Lost your password?';
            $label = ( isset( $this->options['login_form_fields']['label_lost_password'] ) ? $this->options['login_form_fields']['label_lost_password'] : $default );
            // Check if is our text
            if ( $default !== $text ) {
                return $translated_text;
            }
            // Check if the label is changed
            
            if ( $label === $text ) {
                return $translated_text;
            } else {
                $translated_text = esc_html( $label );
            }
            
            return $translated_text;
        }
        
        /**
         * Customizer output for custom login text.
         *
         * @param string|string $translated_text The translated text.
         * @param string|string $text The label we want to replace.
         * @param string|string $domain The text domain of the site.
         * @return string
         */
        public function change_login_label( $translated_text, $text, $domain )
        {
            $default = 'Log In';
            // Check if is our text
            if ( $default !== $text ) {
                return $translated_text;
            }
            $label = ( isset( $this->options['login_form_fields']['input_login'] ) ? $this->options['login_form_fields']['input_login'] : $default );
            // Check if the label is changed
            
            if ( $label === $text ) {
                return $translated_text;
            } else {
                $translated_text = esc_attr( $label );
            }
            
            return $translated_text;
        }
        
        public function change_register_login_link_text( $translated_text, $text, $domain )
        {
            $default = 'Register';
            // Check if is our text
            if ( $default !== $text ) {
                return $translated_text;
            }
            $label = ( isset( $this->options['login_form_fields']['label_register'] ) ? $this->options['login_form_fields']['label_register'] : $default );
            // Check if the label is changed
            
            if ( $label === $text ) {
                return $translated_text;
            } else {
                $translated_text = esc_html( $label );
            }
            
            return $translated_text;
        }
        
        public function change_lostpasswords_username_label( $translated_text, $text, $domain )
        {
            $default = 'Username or Email Address';
            // Check if is our text
            if ( $default !== $text ) {
                return $translated_text;
            }
            $label = ( isset( $this->options['login_form_fields']['label_lost_password'] ) ? $this->options['login_form_fields']['label_lost_password'] : $default );
            // Check if the label is changed
            
            if ( $label === $text ) {
                return $translated_text;
            } else {
                $translated_text = wp_kses_post( $label );
            }
            
            return $translated_text;
        }
        
        public function change_lostpasswords_button_label( $translated_text, $text, $domain )
        {
            $default = 'Reset Password';
            // Check if is our text
            if ( $default !== $text ) {
                return $translated_text;
            }
            $label = 'Reset Password';
            // Check if the label is changed
            
            if ( $label === $text ) {
                return $translated_text;
            } else {
                $translated_text = esc_html( $label );
            }
            
            return $translated_text;
        }
        
        /**
         * Customizer output for custom back to text.
         *
         * @param string|string $translated_text The translated text.
         * @param string|string $text The label we want to replace.
         * @param string|string $domain The text domain of the site.
         * @return string
         */
        public function change_back_to_text(
            $translated_text,
            $text,
            $context,
            $domain
        )
        {
            $default = '&larr; Back to %s';
            $label = ( isset( $this->options['login_form_fields']['label_back_to_site'] ) ? $this->options['login_form_fields']['label_back_to_site'] : $default );
            // Check if is our text
            if ( $default !== $text ) {
                return $translated_text;
            }
            // Check if the label is changed
            
            if ( $label === $text ) {
                return $translated_text;
            } else {
                $translated_text = '&larr; ' . esc_html( $label ) . ' %s';
            }
            
            return $translated_text;
        }
        
        /**
         * Outputs the viewport meta tag.
         */
        function login_viewport_meta()
        {
            ?>
				<meta name="viewport" content="width=device-width" />
			<?php 
        }
    
    }
}