<?php
defined('ABSPATH') || die("Can't access directly");

/**
 * Login custom styles.
 *
 * @package WP Adminify
 *
 * @subpackage Login_Customizer
 */


class WP_Adminify_Custom_CSS
{

    public $styles = [];

    public function addCSS($selector, $property, $value)
    {
        if (!array_key_exists($selector, $this->styles)) $this->styles[$selector] = [];
        $this->styles[$selector][$property] = $value;
    }

    public function removeCSS($selector, $property)
    {
        if (!array_key_exists($selector, $this->styles)) return;
        if (gettype($property) == 'string') {
            unset($this->styles[$selector][$property]);
        } else {
            foreach ($property as $prop) {
                unset($this->styles[$selector][$prop]);
            }
        }
    }

    public function getCSS()
    {
        $_styles = '';
        foreach ($this->styles as $selector => $styles) {
            $css = '';
            foreach ($styles as $prop => $value) $css .= sprintf('%s:%s;', $prop, $value);
            $_styles .= sprintf('%s{%s}', $selector, $css);
        }
        return $_styles;
    }

    public function getStyle()
    {
        return printf('<style id="wpadminify-customizer-custom-css">%s</style>', $this->getCSS());
    }
}
$customizer_css = new WP_Adminify_Custom_CSS();

function getBoxedFormTemplates()
{
    return ['template-02', 'template-13', 'template-15', 'template-16'];
}


/* ==============================================
 * Change Logo Image
 * ============================================== */

$image = $this->options['logo_image'];
if ($image && $image['url'] != '') {
    $customizer_css->addCSS('body.wp-adminify-login-customizer #login h1 a', 'background-image', sprintf('url(%s)', $image['url']));
}


/* ==============================================
 * Login title Style
 * ============================================== */

$logo_settings = $this->options['logo_settings'];
$modules = (array)$this->options['login_title_style'];

foreach ($modules as $module => $module_val) {

    // Logo Width Height
    if ($module == 'logo_heigh_width') {

        $unit = empty($module_val['unit']) ? 'px' : $module_val['unit'];

        if ($logo_settings == 'image-only') {
            if (!empty($module_val['width'])) $customizer_css->addCSS('body.wp-adminify-login-customizer #login h1 a', 'width', $module_val['width'] . $module_val['unit'] . '!important');
            if (!empty($module_val['height'])) $customizer_css->addCSS('body.wp-adminify-login-customizer #login h1 a', 'height', $module_val['height'] . $module_val['unit'] . '!important');
        }

        if ($logo_settings == 'both') {
            if (!empty($module_val['height'])) $customizer_css->addCSS('body.wp-adminify-login-customizer #login h1 a:before', 'height', $module_val['height'] . $module_val['unit'] . '!important');
        }
    }

    // Logo Padding
    if ( jltwp_adminify()->can_use_premium_code__premium_only() && $module == 'logo_padding' ) {

        $unit = empty($module_val['unit']) ? 'px' : $module_val['unit'];

        if (!empty($module_val['top'])) $customizer_css->addCSS('body.wp-adminify-login-customizer #login h1', 'padding-top', $module_val['top'] . $unit);
        if (!empty($module_val['right'])) $customizer_css->addCSS('body.wp-adminify-login-customizer #login h1', 'padding-right', $module_val['right'] . $unit);
        if (!empty($module_val['bottom'])) $customizer_css->addCSS('body.wp-adminify-login-customizer #login h1', 'padding-bottom', $module_val['bottom'] . $unit);
        if (!empty($module_val['left'])) $customizer_css->addCSS('body.wp-adminify-login-customizer #login h1', 'padding-left', $module_val['left'] . $unit);
    }

    // Login Title Typography
    if ( jltwp_adminify()->can_use_premium_code__premium_only() && $module == 'login_title_typography' ) {

        $selector = 'body.wp-adminify-login-customizer #login h1 a';

        if (!empty($module_val['color']))
            $customizer_css->addCSS($selector, 'color', $module_val['color']);

        if (!empty($module_val['font-size']))
            $customizer_css->addCSS($selector, 'font-size', $module_val['font-size'] . $module_val['unit']);

        if (!empty($module_val['font-family']))
            $customizer_css->addCSS($selector, 'font-family', $module_val['font-family']);

        if (!empty($module_val['font-style']))
            $customizer_css->addCSS($selector, 'font-style', $module_val['font-style']);

        if (!empty($module_val['font-weight']))
            $customizer_css->addCSS($selector, 'font-weight', $module_val['font-weight']);

        if (!empty($module_val['letter-spacing']))
            $customizer_css->addCSS($selector, 'letter-spacing', $module_val['letter-spacing'] . $module_val['unit']);

        if (!empty($module_val['line-height']))
            $customizer_css->addCSS($selector, 'line-height', $module_val['line-height'] . $module_val['unit']);

        if (!empty($module_val['text-decoration']))
            $customizer_css->addCSS($selector, 'text-decoration', $module_val['text-decoration']);

        if (!empty($module_val['text-transform']))
            $customizer_css->addCSS($selector, 'text-transform', $module_val['text-transform']);
    }
}


/* ==============================================
 * Login Page Background
 * ============================================== */

$bg_type             = $this->options['jltwp_adminify_login_bg_type'];
$bg_overlay_type     = !empty($this->options['jltwp_adminify_login_bg_overlay_type']) ? $this->options['jltwp_adminify_login_bg_overlay_type'] : '';
$bg_overlay_color    = !empty($this->options['jltwp_adminify_login_bg_overlay_color']) ? $this->options['jltwp_adminify_login_bg_overlay_color'] : '';
$bg_overlay_g_color  = !empty($this->options['jltwp_adminify_login_bg_overlay_gradient_color']) ? $this->options['jltwp_adminify_login_bg_overlay_gradient_color'] : '';
$overlay_opacity     = !empty($this->options['jltwp_adminify_login_overlay_opacity']) ? $this->options['jltwp_adminify_login_overlay_opacity'] : '';
$selector            = 'body.wp-adminify-login-customizer .login-background';

if ($bg_type == 'color_image') {

    $bg_color_opt = $this->options['jltwp_adminify_login_bg_color_opt'];

    if ($bg_color_opt == 'color') {
        $bg_color = $this->options['jltwp_adminify_login_bg_color'];
    } else {
        $gradient_bg = $this->options['jltwp_adminify_login_gradient_bg'];
    }
}

if ($bg_type == 'color_image') {

    if ($bg_color_opt == 'color') {

        if (!empty($bg_color)) {

            if (!empty($bg_color['background-color'])) $customizer_css->addCSS($selector, 'background', $bg_color['background-color']);

            if (!empty($bg_color['background-image']) && !empty($bg_color['background-image']['url'])) {
                if (!empty($bg_color['background-color'])) $customizer_css->addCSS($selector, 'background-color', $bg_color['background-color']);
                if (!empty($bg_color['background-image']['url'])) $customizer_css->addCSS($selector, 'background-image', sprintf('url(%s)', $bg_color['background-image']['url']));
                if (!empty($bg_color['background-position'])) $customizer_css->addCSS($selector, 'background-position', $bg_color['background-position']);
                if (!empty($bg_color['background-repeat'])) $customizer_css->addCSS($selector, 'background-repeat', $bg_color['background-repeat']);
                if (!empty($bg_color['background-attachment'])) $customizer_css->addCSS($selector, 'background-attachment', $bg_color['background-attachment']);
                if (!empty($bg_color['background-size'])) $customizer_css->addCSS($selector, 'background-size', $bg_color['background-size']);
            }
        }
    } else {

        if ( jltwp_adminify()->can_use_premium_code__premium_only() && !empty($gradient_bg)) {

            if (!empty($gradient_bg['background-color'])) $customizer_css->addCSS($selector, 'background', $gradient_bg['background-color']);

            if (!empty($gradient_bg['background-color']) && !empty($gradient_bg['background-gradient-color'])) {
                $gradient_color = $gradient_bg['background-color'] . ', ' . $gradient_bg['background-gradient-color'];
                if (!empty($gradient_bg['background-gradient-direction'])) $gradient_color = $gradient_bg['background-gradient-direction'] . ', ' . $gradient_color;
                $customizer_css->addCSS($selector, 'background', 'linear-gradient(' . $gradient_color . ')');
            }
        }
    }
}

if ($bg_overlay_type == 'color' && !empty($bg_overlay_color) && !empty($bg_overlay_color['background-color'])) {
    $customizer_css->addCSS($selector . ':after', 'background', $bg_overlay_color['background-color']);
}

if ( jltwp_adminify()->can_use_premium_code__premium_only() && $bg_overlay_type == 'gradient' && !empty($bg_overlay_g_color) ) {

    if (!empty($bg_overlay_g_color['background-color'])) $customizer_css->addCSS($selector . ':after', 'background', $bg_overlay_g_color['background-color']);

    if (!empty($bg_overlay_g_color['background-color']) && !empty($bg_overlay_g_color['background-gradient-color'])) {
        $gradient_color = $bg_overlay_g_color['background-color'] . ', ' . $bg_overlay_g_color['background-gradient-color'];
        if (!empty($bg_overlay_g_color['background-gradient-direction'])) $gradient_color = $bg_overlay_g_color['background-gradient-direction'] . ', ' . $gradient_color;
        $customizer_css->addCSS($selector . ':after', 'background', 'linear-gradient(' . $gradient_color . ')');
    }
}

if (!empty($bg_overlay_type) && !empty($overlay_opacity)) {
    $overlay_opacity = (float) $overlay_opacity;
    $customizer_css->addCSS($selector . ':after', 'opacity', $overlay_opacity / 100);
}


/* ==============================================
 * Layout Style
 * ============================================== */

$login_width        = $this->options['alignment_login_width'];
$login_bg_type      = !empty($this->options['alignment_login_bg_type']) ? $this->options['alignment_login_bg_type'] : '';
$login_bg_color     = !empty($this->options['alignment_login_bg_color']) ? $this->options['alignment_login_bg_color'] : '';
$login_bg_g_color   = !empty($this->options['alignment_login_bg_gradient_color']) ? $this->options['alignment_login_bg_gradient_color'] : '';
$login_bg_skew      = !empty($this->options['alignment_login_bg_skew']) ? $this->options['alignment_login_bg_skew'] : '';

$selector_fullwidth = 'body.wp-adminify-login-customizer.wp-adminify-fullwidth .wp-adminify-form-container:after';
$selector_half      = 'body.wp-adminify-login-customizer.wp-adminify-half-screen .wp-adminify-container:before';
$selector           = $login_width == 'fullwidth' ? $selector_fullwidth : $selector_half;

if ( jltwp_adminify()->can_use_premium_code__premium_only() && $login_width == 'fullwidth' ) {
    if ($login_bg_skew > 0) {
        $customizer_css->addCSS($selector, 'transform', 'skewX(' . $login_bg_skew . 'deg)');
        $customizer_css->addCSS($selector, 'clip-path', 'none');
    } else {
        $customizer_css->addCSS($selector, 'transform', 'skewY(' . $login_bg_skew . 'deg)');
        $customizer_css->addCSS($selector, 'clip-path', 'none');
    }
}

if ($login_bg_type == 'color' && !empty($login_bg_color)) {

    if (!empty($login_bg_color['background-color'])) $customizer_css->addCSS($selector, 'background', $login_bg_color['background-color']);

    if (!empty($login_bg_color['background-image']) && !empty($login_bg_color['background-image']['url'])) {
        if (!empty($login_bg_color['background-image']['url'])) $customizer_css->addCSS($selector, 'background-image', sprintf('url(%s)', $login_bg_color['background-image']['url']));
        if (!empty($login_bg_color['background-position'])) $customizer_css->addCSS($selector, 'background-position', $login_bg_color['background-position']);
        if (!empty($login_bg_color['background-repeat'])) $customizer_css->addCSS($selector, 'background-repeat', $login_bg_color['background-repeat']);
        if (!empty($login_bg_color['background-attachment'])) $customizer_css->addCSS($selector, 'background-attachment', $login_bg_color['background-attachment']);
        if (!empty($login_bg_color['background-size'])) $customizer_css->addCSS($selector, 'background-size', $login_bg_color['background-size']);
    }
} else if ( jltwp_adminify()->can_use_premium_code__premium_only() && $login_bg_type == 'gradient' && !empty($login_bg_g_color) ) {

    if (!empty($login_bg_g_color['background-color'])) $customizer_css->addCSS($selector, 'background', $login_bg_g_color['background-color']);

    if (!empty($login_bg_g_color['background-color']) && !empty($login_bg_g_color['background-gradient-color'])) {
        $gradient_color = $login_bg_g_color['background-color'] . ', ' . $login_bg_g_color['background-gradient-color'];
        if (!empty($login_bg_g_color['background-gradient-direction'])) $gradient_color = $login_bg_g_color['background-gradient-direction'] . ', ' . $gradient_color;
        $customizer_css->addCSS($selector, 'background', 'linear-gradient(' . $gradient_color . ')');
    }
}


/* ==============================================
 * Login Form
 * ============================================== */

$template                     = $this->options['templates'];
$login_form_bg_type         = $this->options['login_form_bg_type'];
$login_form_bg_color         = $this->options['login_form_bg_color'];
$login_form_bg_gradient     = $this->options['login_form_bg_gradient'];
$login_form_height_width     = $this->options['login_form_height_width'];
$login_form_margin             = $this->options['login_form_margin'];
$login_form_padding         = $this->options['login_form_padding'];
$login_form_border             = $this->options['login_form_border'];
$login_form_border_radius     = $this->options['login_form_border_radius'];
$login_form_box_shadow         = $this->options['login_form_box_shadow'];

$selector_login = 'body.wp-adminify-login-customizer #login';
$selector_login_form = 'body.wp-adminify-login-customizer #loginform';

$selector = (in_array($template, getBoxedFormTemplates())) ? $selector_login : $selector_login_form;

// Background Color
if ($login_form_bg_type == 'color') {
    if (!empty($login_form_bg_color)) {
        if (!empty($login_form_bg_color['background-color'])) $customizer_css->addCSS($selector, 'background', $login_form_bg_color['background-color']);
        if (!empty($login_form_bg_color['background-image']) && !empty($login_form_bg_color['background-image']['url'])) {
            if (!empty($login_form_bg_color['background-image']['url'])) $customizer_css->addCSS($selector, 'background-image', sprintf('url(%s)', $login_form_bg_color['background-image']['url']));
            if (!empty($login_form_bg_color['background-position'])) $customizer_css->addCSS($selector, 'background-position', $login_form_bg_color['background-position']);
            if (!empty($login_form_bg_color['background-repeat'])) $customizer_css->addCSS($selector, 'background-repeat', $login_form_bg_color['background-repeat']);
            if (!empty($login_form_bg_color['background-attachment'])) $customizer_css->addCSS($selector, 'background-attachment', $login_form_bg_color['background-attachment']);
            if (!empty($login_form_bg_color['background-size'])) $customizer_css->addCSS($selector, 'background-size', $login_form_bg_color['background-size']);
        }
    }
}

// Background Gradient
if ( jltwp_adminify()->can_use_premium_code__premium_only() && $login_form_bg_type == 'gradient' && !empty($login_form_bg_gradient) ) {
    if ($login_form_bg_gradient['background-color']) $customizer_css->addCSS($selector, 'background', $login_form_bg_gradient['background-color']);
    if ($login_form_bg_gradient['background-color'] && $login_form_bg_gradient['background-gradient-color']) {
        $gradient_color = $login_form_bg_gradient['background-color'] . ', ' . $login_form_bg_gradient['background-gradient-color'];
        if ($login_form_bg_gradient['background-gradient-direction']) $gradient_color = $login_form_bg_gradient['background-gradient-direction'] . ', ' . $gradient_color;
        $customizer_css->addCSS($selector, 'background', 'linear-gradient(' . $gradient_color . ')');
    }
}

// Height Width
if (!empty($login_form_height_width)) {
    $unit = empty($login_form_height_width['unit']) ? 'px' : $login_form_height_width['unit'];
    if (!empty($login_form_height_width['width'])) $customizer_css->addCSS($selector_login, 'width', $login_form_height_width['width'] . $unit);
    if (!empty($login_form_height_width['height'])) $customizer_css->addCSS($selector_login_form, 'height', $login_form_height_width['height'] . $unit);
}

// Margin
if ( jltwp_adminify()->can_use_premium_code__premium_only() && !empty($login_form_margin) ) {
    $unit = empty($login_form_margin['unit']) ? 'px' : $login_form_margin['unit'];
    if ($login_form_margin['top']) $customizer_css->addCSS($selector_login_form, 'margin-top', $login_form_margin['top'] . $unit);
    if ($login_form_margin['right']) $customizer_css->addCSS($selector_login_form, 'margin-right', $login_form_margin['right'] . $unit);
    if ($login_form_margin['bottom']) $customizer_css->addCSS($selector_login_form, 'margin-bottom', $login_form_margin['bottom'] . $unit);
    if ($login_form_margin['left']) $customizer_css->addCSS($selector_login_form, 'margin-left', $login_form_margin['left'] . $unit);
}

// Padding
if ( jltwp_adminify()->can_use_premium_code__premium_only() && !empty($login_form_padding) ) {
    $unit = empty($login_form_padding['unit']) ? 'px' : $login_form_padding['unit'];
    if ($login_form_padding['top']) $customizer_css->addCSS($selector, 'padding-top', $login_form_padding['top'] . $unit);
    if ($login_form_padding['right']) $customizer_css->addCSS($selector, 'padding-right', $login_form_padding['right'] . $unit);
    if ($login_form_padding['bottom']) $customizer_css->addCSS($selector, 'padding-bottom', $login_form_padding['bottom'] . $unit);
    if ($login_form_padding['left']) $customizer_css->addCSS($selector, 'padding-left', $login_form_padding['left'] . $unit);
}

// Border
if ($login_form_border) {
    $style = $login_form_border['style'];
    $color = $login_form_border['color'];
    if (!empty($color) && !empty($style)) {
        if ($login_form_border['top']) $customizer_css->addCSS($selector, 'border-top', sprintf('%spx %s %s', $login_form_border['top'], $style, $color));
        if ($login_form_border['right']) $customizer_css->addCSS($selector, 'border-right', sprintf('%spx %s %s', $login_form_border['right'], $style, $color));
        if ($login_form_border['bottom']) $customizer_css->addCSS($selector, 'border-bottom', sprintf('%spx %s %s', $login_form_border['bottom'], $style, $color));
        if ($login_form_border['left']) $customizer_css->addCSS($selector, 'border-left', sprintf('%spx %s %s', $login_form_border['left'], $style, $color));
    }
}

// Border Radius
if ( jltwp_adminify()->can_use_premium_code__premium_only() && !empty($login_form_border_radius) ) {

    $border_radius = $login_form_border_radius;
    $unit = empty($border_radius['unit']) ? 'px' : $border_radius['unit'];
    $form_borders = [$border_radius['top'], $border_radius['right'], $border_radius['bottom'], $border_radius['left']];

    $found = false;
    foreach ($form_borders as $border) {
        if (!$found && !empty($border)) $found = true;
    }

    if ($found) {

        $form_borders = array_map(function ($border) use ($unit) {
            return (empty($border) ? 0 : $border) . $unit;
        }, $form_borders);

        $customizer_css->addCSS($selector, 'border-radius', implode(' ', $form_borders));
    }
}

// Box Shadow
if ( jltwp_adminify()->can_use_premium_code__premium_only() && !empty($login_form_box_shadow) && !empty($login_form_box_shadow['bs_color']) ) {

    $bs_color       = $login_form_box_shadow['bs_color'] . ' ';
    $bs_hz          = (empty($login_form_box_shadow['bs_hz']) ? 0 : $login_form_box_shadow['bs_hz']) . 'px ';
    $bs_ver         = (empty($login_form_box_shadow['bs_ver']) ? 0 : $login_form_box_shadow['bs_ver']) . 'px ';
    $bs_blur        = (empty($login_form_box_shadow['bs_blur']) ? 0 : $login_form_box_shadow['bs_blur']) . 'px ';
    $bs_spread      = (empty($login_form_box_shadow['bs_spread']) ? 0 : $login_form_box_shadow['bs_spread']) . 'px ';
    $bs_spread_pos  = $login_form_box_shadow['bs_spread_pos'];

    $customizer_css->addCSS($selector, 'box-shadow', $bs_hz . $bs_ver . $bs_blur . $bs_spread . $bs_color . $bs_spread_pos);
}


/* ==============================================
 * Form Fields
 * ============================================== */

$login_form_fields = (array)$this->options['login_form_fields'];

foreach ($login_form_fields as $setting => $value) {

    $selectors = '';
    $selector_prefix = 'body.wp-adminify-login-customizer ';
    $selectors_a = ['#loginform label', '#backtoblog a'];
    $selectors_b = ['#loginform input[type=text]', '#loginform input[type=email]', '#loginform textarea', '#loginform input[type=password]'];
    $selectors_c = ['#loginform label', '#wp-adminify-lost-password', '#backtoblog a'];

    switch ($setting) {

        case 'style_label_font_size': {
                if (!empty($value)) $customizer_css->addCSS(implode(',', $selectors_a), 'font-size', $value . 'px');
                break;
            }

        case 'style_fields_height':
            if (!empty($value)) {
                $selectors = array_map(function ($sel) use ($selector_prefix) {
                    return $selector_prefix . $sel;
                }, $selectors_b);
                $customizer_css->addCSS(implode(',', $selectors), 'height', $value . 'px');
            }
            break;

        case 'style_fields_font_size':
            if (!empty($value)) {
                $selectors = array_map(function ($sel) use ($selector_prefix) {
                    return $selector_prefix . $sel;
                }, $selectors_b);
                $customizer_css->addCSS(implode(',', $selectors), 'font-size', $value . 'px');
            }
            break;

        case 'style_fields_bg':
            if ( jltwp_adminify()->can_use_premium_code__premium_only() ) {
                if (!empty($value['color'])) {
                    $selectors = array_map(function ($sel) use ($selector_prefix) {
                        return $selector_prefix . $sel;
                    }, $selectors_b);
                    $customizer_css->addCSS(implode(',', $selectors), 'background', $value['color']);
                }
                if (!empty($value['focus'])) {
                    $selectors = array_map(function ($sel) use ($selector_prefix) {
                        return $selector_prefix . $sel . ':focus';
                    }, $selectors_b);
                    $customizer_css->addCSS(implode(',', $selectors), 'background', $value['focus'] . ' !important');
                }
            }
            break;

        case 'style_label_color':
            if (!empty($value)) {
                $selectors = array_map(function ($sel) use ($selector_prefix) {
                    return $selector_prefix . $sel;
                }, $selectors_c);
                $customizer_css->addCSS(implode(',', $selectors), 'color', $value);
            }
            break;

        case 'style_fields_color':

            if (!empty($value['color'])) {
                $selectors = array_merge($selectors_b, array_map(function ($sel) {
                    return $sel . '::placeholder';
                }, $selectors_b));
                $selectors = array_map(function ($sel) use ($selector_prefix) {
                    return $selector_prefix . $sel;
                }, $selectors);
                $customizer_css->addCSS(implode(',', $selectors), 'color', $value['color']);
            }

            if (!empty($value['focus'])) {
                $selectors = array_map(function ($sel) {
                    return $sel . ':focus';
                }, $selectors_b);
                $selectors = array_merge($selectors, array_map(function ($sel) {
                    return $sel . '::placeholder';
                }, $selectors));
                $selectors = array_map(function ($sel) use ($selector_prefix) {
                    return $selector_prefix . $sel;
                }, $selectors);
                $customizer_css->addCSS(implode(',', $selectors), 'color', $value['focus']);
            }

            break;

        case 'style_border':

            if ( jltwp_adminify()->can_use_premium_code__premium_only() && !empty($value) ) {

                if (!empty($value['color']) && !empty($value['style'])) {
                    $selectors = array_map(function ($sel) use ($selector_prefix) {
                        return $selector_prefix . $sel;
                    }, $selectors_b);
                    if (!empty($value['top'])) $customizer_css->addCSS(implode(',', $selectors), 'border-top', sprintf('%spx %s %s', $value['top'], $value['style'], $value['color']));
                    if (!empty($value['right'])) $customizer_css->addCSS(implode(',', $selectors), 'border-right', sprintf('%spx %s %s', $value['right'], $value['style'], $value['color']));
                    if (!empty($value['bottom'])) $customizer_css->addCSS(implode(',', $selectors), 'border-bottom', sprintf('%spx %s %s', $value['bottom'], $value['style'], $value['color']));
                    if (!empty($value['left'])) $customizer_css->addCSS(implode(',', $selectors), 'border-left', sprintf('%spx %s %s', $value['left'], $value['style'], $value['color']));
                }
            }

            break;

        case 'style_border_radius':

            if ( jltwp_adminify()->can_use_premium_code__premium_only() ) {

                $selectors = array_map(function ($sel) use ($selector_prefix) {
                    return $selector_prefix . $sel;
                }, $selectors_b);

                $unit = $value['unit'];

                $input_borders = [$value['top'], $value['right'], $value['bottom'], $value['left']];
    
                $found = false;

                foreach ($input_borders as $border) {
                    if (!$found && !empty($border)) $found = true;
                }
    
                if ($found) {
    
                    $input_borders = array_map(function ($border) use ($unit) {
                        return (empty($border) ? 0 : $border) . $unit;
                    }, $input_borders);
    
                    $customizer_css->addCSS(implode(',', $selectors), 'border-radius', implode(' ', $input_borders));

                }

            }

            break;

        case 'fields_margin':

            if ( jltwp_adminify()->can_use_premium_code__premium_only() ) {

                $selectors = array_map(function ($sel) use ($selector_prefix) {
                    return $selector_prefix . $sel;
                }, $selectors_b);
    
                $unit = empty($value['unit']) ? 'px' : $value['unit'];
                if ($value['top']) $customizer_css->addCSS(implode(',', $selectors), 'margin-top', $value['top'] . $unit);
                if ($value['right']) $customizer_css->addCSS(implode(',', $selectors), 'margin-right', $value['right'] . $unit);
                if ($value['bottom']) $customizer_css->addCSS(implode(',', $selectors), 'margin-bottom', $value['bottom'] . $unit);
                if ($value['left']) $customizer_css->addCSS(implode(',', $selectors), 'margin-left', $value['left'] . $unit);

            }

            break;

        case 'fields_padding':

            if ( jltwp_adminify()->can_use_premium_code__premium_only() ) {

                $selectors = array_map(function ($sel) use ($selector_prefix) {
                    return $selector_prefix . $sel;
                }, $selectors_b);
    
                $unit = empty($value['unit']) ? 'px' : $value['unit'];
                if ($value['top']) $customizer_css->addCSS(implode(',', $selectors), 'padding-top', $value['top'] . $unit);
                if ($value['right']) $customizer_css->addCSS(implode(',', $selectors), 'padding-right', $value['right'] . $unit);
                if ($value['bottom']) $customizer_css->addCSS(implode(',', $selectors), 'padding-bottom', $value['bottom'] . $unit);
                if ($value['left']) $customizer_css->addCSS(implode(',', $selectors), 'padding-left', $value['left'] . $unit);

            }

            break;

        case 'fields_bs_color':

            if ( jltwp_adminify()->can_use_premium_code__premium_only() ) {

                $selectors = array_map(function ($sel) use ($selector_prefix) {
                    return $selector_prefix . $sel;
                }, $selectors_b);
    
                if (!empty($value)) {
    
                    $bs_color       = $value . ' ';
                    $bs_hz          = (empty($login_form_fields['fields_bs_hz']) ? 0 : $login_form_fields['fields_bs_hz']) . 'px ';
                    $bs_ver         = (empty($login_form_fields['fields_bs_ver']) ? 0 : $login_form_fields['fields_bs_ver']) . 'px ';
                    $bs_blur        = (empty($login_form_fields['fields_bs_blur']) ? 0 : $login_form_fields['fields_bs_blur']) . 'px ';
                    $bs_spread      = (empty($login_form_fields['fields_bs_spread']) ? 0 : $login_form_fields['fields_bs_spread']) . 'px ';
                    $bs_spread_pos  = $login_form_fields['fields_bs_spread_pos'];
    
                    $customizer_css->addCSS(implode(',', $selectors), 'box-shadow', $bs_hz . $bs_ver . $bs_blur . $bs_spread . $bs_color . $bs_spread_pos);
                }

            }

            break;
    }
}


/* ==============================================
 * Submit Button
 * ============================================== */

$button_size         = $this->options['button_size'];
$button_font_size    = $this->options['button_font_size'];
$button_settings     = (array) $this->options['login_form_button_settings'];
$selector            = 'body.wp-adminify-login-customizer #loginform #wp-submit';

// Button Width Height
if (!empty($button_size) && !empty($button_size['unit'])) {
    if (!empty($button_size['width'])) $customizer_css->addCSS($selector, 'width', $button_size['width'] . $button_size['unit']);
    if (!empty($button_size['height'])) $customizer_css->addCSS($selector, 'height', $button_size['height'] . $button_size['unit']);
}

// Button Font Size
if (!empty($button_font_size)) $customizer_css->addCSS($selector, 'font-size', $button_font_size . 'px');

// Button Settings
foreach ($button_settings as $setting => $value) {

    switch ($setting) {

        case 'button_bg': {
                if (!empty($value)) $customizer_css->addCSS($selector, 'background', $value);
                break;
            }

        case 'button_text_color': {
                if (!empty($value)) $customizer_css->addCSS($selector, 'color', $value);
                break;
            }

        case 'button_text_shadow': {

                if ( jltwp_adminify()->can_use_premium_code__premium_only() && !empty($value['ts_color']) ) {

                    $btn_ts_color   = $value['ts_color'] . ' ';
                    $btn_ts_hz      = (empty($value['ts_hz']) ? 0 : $value['ts_hz']) . 'px ';
                    $btn_ts_ver     = (empty($value['ts_ver']) ? 0 : $value['ts_ver']) . 'px ';
                    $btn_ts_blur    = (empty($value['ts_ver']) ? 0 : $value['ts_ver']) . 'px ';

                    $customizer_css->addCSS($selector, 'text-shadow', $btn_ts_hz . $btn_ts_ver . $btn_ts_blur . $btn_ts_color);
                }

                break;
            }

        case 'button_bg_hover': {
                if (!empty($value)) $customizer_css->addCSS($selector . ':hover', 'background', $value);
                break;
            }

        case 'button_text_hover': {
                if (!empty($value)) $customizer_css->addCSS($selector . ':hover', 'color', $value);
                break;
            }

        case 'button_text_shadow_hover': {

                if ( jltwp_adminify()->can_use_premium_code__premium_only() && !empty($value['ts_color']) ) {

                    $btn_ts_color   = $value['ts_color'] . ' ';
                    $btn_ts_hz      = (empty($value['ts_hz']) ? 0 : $value['ts_hz']) . 'px ';
                    $btn_ts_ver     = (empty($value['ts_ver']) ? 0 : $value['ts_ver']) . 'px ';
                    $btn_ts_blur    = (empty($value['ts_ver']) ? 0 : $value['ts_ver']) . 'px ';

                    $customizer_css->addCSS($selector . ':hover', 'text-shadow', $btn_ts_hz . $btn_ts_ver . $btn_ts_blur . $btn_ts_color);
                }

                break;
            }

        case 'button_margin': {

                $unit = empty($value['unit']) ? 'px' : $value['unit'];

                if ($value['top']) $customizer_css->addCSS($selector, 'margin-top', $value['top'] . $unit);
                if ($value['right']) $customizer_css->addCSS($selector, 'margin-right', $value['right'] . $unit);
                if ($value['bottom']) $customizer_css->addCSS($selector, 'margin-bottom', $value['bottom'] . $unit);
                if ($value['left']) $customizer_css->addCSS($selector, 'margin-left', $value['left'] . $unit);

                break;
            }

        case 'button_padding': {

                $unit = empty($value['unit']) ? 'px' : $value['unit'];

                if ($value['top']) $customizer_css->addCSS($selector, 'padding-top', $value['top'] . $unit);
                if ($value['right']) $customizer_css->addCSS($selector, 'padding-right', $value['right'] . $unit);
                if ($value['bottom']) $customizer_css->addCSS($selector, 'padding-bottom', $value['bottom'] . $unit);
                if ($value['left']) $customizer_css->addCSS($selector, 'padding-left', $value['left'] . $unit);

                break;
            }

        case 'button_border': {

                if (!empty($value)) {

                    if (!empty($value['color']) && !empty($value['style'])) {
                        if (!empty($value['top'])) $customizer_css->addCSS($selector, 'border-top', sprintf('%spx %s %s', $value['top'], $value['style'], $value['color']));
                        if (!empty($value['right'])) $customizer_css->addCSS($selector, 'border-right', sprintf('%spx %s %s', $value['right'], $value['style'], $value['color']));
                        if (!empty($value['bottom'])) $customizer_css->addCSS($selector, 'border-bottom', sprintf('%spx %s %s', $value['bottom'], $value['style'], $value['color']));
                        if (!empty($value['left'])) $customizer_css->addCSS($selector, 'border-left', sprintf('%spx %s %s', $value['left'], $value['style'], $value['color']));
                    }
                }

                break;
            }

        case 'button_border_radius': {

                if ( jltwp_adminify()->can_use_premium_code__premium_only() ) {

                    $unit = $value['unit'];
                    $input_borders = [$value['top'], $value['right'], $value['bottom'], $value['left']];
    
                    $found = false;
                    foreach ($input_borders as $border) {
                        if (!$found && !empty($border)) $found = true;
                    }
    
                    if ($found) {
    
                        $input_borders = array_map(function ($border) use ($unit) {
                            return (empty($border) ? 0 : $border) . $unit;
                        }, $input_borders);
    
                        $customizer_css->addCSS($selector, 'border-radius', implode(' ', $input_borders));
                    }

                }

                break;
            }

        case 'button_box_shadow': {

                if ( jltwp_adminify()->can_use_premium_code__premium_only() && !empty($value['bs_color']) ) {

                    $bs_color         = $value['bs_color'] . ' ';
                    $bs_hz             = (empty($value['bs_hz']) ? 0 : $value['bs_hz']) . 'px ';
                    $bs_ver         = (empty($value['bs_ver']) ? 0 : $value['bs_ver']) . 'px ';
                    $bs_blur         = (empty($value['bs_blur']) ? 0 : $value['bs_blur']) . 'px ';
                    $bs_spread         = (empty($value['bs_spread']) ? 0 : $value['bs_spread']) . 'px ';
                    $bs_spread_pos     = $value['bs_spread_pos'];

                    $customizer_css->addCSS($selector, 'box-shadow', $bs_hz . $bs_ver . $bs_blur . $bs_spread . $bs_color . $bs_spread_pos);

                    break;
                }
            }
    }
}





$customizer_css->getStyle();
