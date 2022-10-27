<?php
defined('ABSPATH') || die("Can't access directly");

/**
 * Login styles.
 *
 * @package WP Adminify
 *
 * @subpackage Login_Customizer
 */

?>

<style class="wp-adminify-login-customizer-style">
    <?php ob_start(); ?>

    /* Logo: None */
    body.wp-adminify-login-customizer:not(.wp-adminify-text-logo):not(.wp-adminify-image-logo) h1 {
        display: none;
    }

    body.wp-adminify-login-customizer:not(.wp-adminify-text-logo):not(.wp-adminify-image-logo) #login {
        padding-top: 0px;
    }

    /* Logo: Text Only */
    body.wp-adminify-login-customizer.wp-adminify-text-logo:not(.wp-adminify-image-logo) h1 a {
        background: none !important;
        text-indent: unset;
        width: auto !important;
        height: auto !important;
    }

    /* Logo: Image Only */
    body.wp-adminify-login-customizer.wp-adminify-image-logo:not(.wp-adminify-text-logo) #login h1 a {
        background-size: contain;
    }

    /* Logo: Image & Text */
    body.wp-adminify-login-customizer.wp-adminify-text-logo.wp-adminify-image-logo #login h1 {
        overflow: hidden;
        width: 350px;
        max-width: 80%;
        margin: 0 auto;
    }

    body.wp-adminify-login-customizer.wp-adminify-text-logo.wp-adminify-image-logo #login h1 a {
        width: 100%;
        height: auto;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-box-align: end;
        -webkit-align-items: flex-end;
        -ms-flex-align: end;
        align-items: flex-end;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        margin-bottom: 0px;
        background-size: 0px;
    }

    body.wp-adminify-login-customizer.wp-adminify-text-logo.wp-adminify-image-logo #login h1 a:before {
        content: "";
        background: inherit;
        background-size: contain;
        background-position: center;
        display: block;
        width: 100%;
        height: 84px;
        margin-bottom: 16px;
    }

    body.wp-adminify-login-customizer.wp-adminify-text-logo #login h1 a {
        text-indent: unset;
    }

    body.wp-adminify-login-customizer .wp-adminify-general-actions {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 100;
    }

    body.wp-adminify-login-customizer .wp-adminify-preview-event {
        cursor: pointer;
        background-color: #008ec2;
        -webkit-border-radius: 100%;
        border-radius: 100%;
        color: #fff;
        width: 30px;
        height: 30px;
        text-align: center;
        border: 2px solid #fff;
        -webkit-box-shadow: 0 2px 1px rgba(46, 68, 83, .15);
        box-shadow: 0 2px 1px rgba(46, 68, 83, .15);
    }

    body.wp-adminify-login-customizer .wp-adminify-preview-event>span {
        margin-top: 5px;
    }

    body.wp-adminify-login-customizer .wp-adminify-general-actions>.wp-adminify-preview-event {
        display: inline-block;
    }

    body.wp-adminify-login-customizer .wp-adminify-form-container {
        width: 100%;
        position: relative;
    }

    body.wp-adminify-login-customizer #login {
        padding: 8% 0 0;
        position: relative;
        z-index: 2;
    }

    body.wp-adminify-login-customizer #login h1 a {
        position: relative;
        overflow: visible;
    }

    body.wp-adminify-login-customizer #login h1 a .wp-adminify-preview-event {
        position: absolute;
        left: -15px;
        top: -15px;
    }

    body.wp-adminify-login-customizer .customize-partial--loginform {
        top: 0 !important;
        left: -10px !important;
    }

    body.wp-adminify-login-customizer .wp-adminify-edit-loginform .customize-partial--loginform {
        opacity: 0 !important;
        visibility: hidden !important;
    }

    body.wp-adminify-login-customizer #login #nav {
        left: 0;
    }

    body.wp-adminify-login-customizer .wp-adminify-background .login-overlay {
        background-color: rgba(0, 0, 0, 0.4);
    }

    body.wp-adminify-login-customizer .wp-adminify-container {
        position: relative;
        height: 100vh;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        width: 100%;
        overflow: hidden;
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen .wp-adminify-container:before {
        content: "";
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen .wp-adminify-container:after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen .wp-adminify-container:before,
    body.wp-adminify-login-customizer.wp-adminify-half-screen .wp-adminify-container:after,
    body.wp-adminify-login-customizer.wp-adminify-half-screen .wp-adminify-form-container {
        height: 100%;
        width: 50%;
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-top .wp-adminify-container:before,
    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-top .wp-adminify-container:after,
    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-bottom .wp-adminify-container:before,
    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-bottom .wp-adminify-container:after,
    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-top .wp-adminify-form-container,
    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-bottom .wp-adminify-form-container {
        height: 50%;
        width: 100%;
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-left .wp-adminify-container:before,
    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-left .wp-adminify-container:after,
    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-right .wp-adminify-container:before,
    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-right .wp-adminify-container:after,
    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-left .wp-adminify-form-container,
    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-right .wp-adminify-form-container {
        height: 100%;
        width: 50%;
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-left .wp-adminify-container {
        -webkit-box-orient: horizontal;
        -webkit-box-direction: reverse;
        -webkit-flex-direction: row-reverse;
        -ms-flex-direction: row-reverse;
        flex-direction: row-reverse;
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-left .wp-adminify-container:after {
        right: 0;
        left: auto;
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-top .wp-adminify-container {
        -webkit-box-orient: vertical;
        -webkit-box-direction: reverse;
        -webkit-flex-direction: column-reverse;
        -ms-flex-direction: column-reverse;
        flex-direction: column-reverse;
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-top .wp-adminify-container:after {
        bottom: 0;
        top: auto;
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-top #login h1 {
        top: 75%;
        left: 50%
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-bottom #login h1 {
        top: 25%;
        left: 50%
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-left #login h1 {
        top: 50%;
        left: 75%
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-right #login h1 {
        top: 50%;
        left: 25%
    }

    body.wp-adminify-login-customizer .wp-adminify-form-container {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        overflow: hidden;
    }

    body.wp-adminify-login-customizer:not(.wp-adminify-half-screen) .wp-adminify-container .wp-adminify-form-container {
        width: 100%;
        min-height: 100vh
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen .wp-adminify-container {
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap
    }

    body.wp-adminify-login-customizer.wp-adminify-half-screen .wp-adminify-form-container {
        z-index: 0;
    }

    body.wp-adminify-login-customizer.wp-adminify-horizontal-align-left_center .wp-adminify-form-container {
        -webkit-box-pack: start;
        -webkit-justify-content: flex-start;
        -ms-flex-pack: start;
        justify-content: flex-start
    }

    body.wp-adminify-login-customizer.wp-adminify-horizontal-align-right_center .wp-adminify-form-container {
        -webkit-box-pack: end;
        -webkit-justify-content: flex-end;
        -ms-flex-pack: end;
        justify-content: flex-end
    }

    body.wp-adminify-login-customizer.wp-adminify-vertical-align-center_top .wp-adminify-form-container {
        -webkit-box-align: start;
        -webkit-align-items: flex-start;
        -ms-flex-align: start;
        align-items: flex-start
    }

    body.wp-adminify-login-customizer.wp-adminify-vertical-align-center_bottom .wp-adminify-form-container {
        -webkit-box-align: end;
        -webkit-align-items: flex-end;
        -ms-flex-align: end;
        align-items: flex-end
    }

    body.wp-adminify-login-customizer.ml-login-horizontal-align-1 .wp-adminify-form-container {
        -webkit-box-pack: start;
        -webkit-justify-content: flex-start;
        -ms-flex-pack: start;
        justify-content: flex-start
    }

    body.wp-adminify-login-customizer.ml-login-horizontal-align-3 .wp-adminify-form-container {
        -webkit-box-pack: end;
        -webkit-justify-content: flex-end;
        -ms-flex-pack: end;
        justify-content: flex-end
    }

    @media only screen and (max-width: 768px) {
        body.wp-adminify-login-customizer.wp-adminify-half-screen .wp-adminify-container>.wp-adminify-form-container {
            width: 50% !important;
        }
    }

    @media only screen and (max-width: 577px) {
        body.wp-adminify-login-customizer.wp-adminify-half-screen .wp-adminify-container>.wp-adminify-form-container {
            width: 100% !important;
        }

        body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-left .wp-adminify-container .wp-adminify-form-container,
        body.wp-adminify-login-customizer.wp-adminify-half-screen.jltwp-adminify-login-right .wp-adminify-container .wp-adminify-form-container {
            width: 100%;
        }
    }

    /* Skew */
    body.wp-adminify-login-customizer .wp-adminify-form-container:after {
        content: '';
        z-index: -1;
        top: 0px;
        left: -100%;
        width: 200%;
        height: 200%;
        position: absolute;
        -webkit-transform-origin: center right;
        -ms-transform-origin: center right;
        transform-origin: center right;
        display: none;
    }

    body.wp-adminify-login-customizer.wp-adminify-fullwidth .wp-adminify-form-container:after {
        display: block;
    }

    body.wp-adminify-login-customizer.wp-adminify-fullwidth.jltwp-adminify-login-right .wp-adminify-form-container:after {
        left: inherit;
        right: -100%;
    }

    body.wp-adminify-login-customizer.wp-adminify-fullwidth.jltwp-adminify-login-top .wp-adminify-form-container:after {
        top: inherit;
        bottom: 0;
    }

    body.wp-adminify-login-customizer .wp-adminify-background-wrapper {
        overflow: hidden;
    }

    body.wp-adminify-login-customizer .login-background,
    body.wp-adminify-login-customizer .login-background:after,
    body.wp-adminify-login-customizer .login-overlay,
    body.wp-adminify-login-customizer .wp-adminify-background-wrapper {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    body.wp-adminify-login-customizer .login-background:after {
        content: '';
        z-index: 1;
    }

    #login #backtoblog,
    #login #nav {
        text-align: center;
    }

    <?php echo apply_filters('wp_adminify_login_styles', ob_get_clean()); ?>
</style>
