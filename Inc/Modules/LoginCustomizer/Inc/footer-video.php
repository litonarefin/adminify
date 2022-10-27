<?php
defined('ABSPATH') or die('No Direct Access Sir!');

$video_type = $this->options['jltwp_adminify_login_bg_video_type'];

if ( $video_type == 'youtube' ) {
    $source = $this->options['jltwp_adminify_login_bg_video_youtube'];
} else {
    $source = $this->options['jltwp_adminify_login_bg_video_self_hosted']['url'];
}

if ( empty($source) ) return;

if ( $video_type ) {

    $video_autoloop = $this->options['jltwp_adminify_login_bg_video_loop'];
    $video_poster   = '';

    if ( !empty($this->options['jltwp_adminify_login_bg_video_poster']) && !empty($this->options['jltwp_adminify_login_bg_video_poster']['url']) ) {
        $this->options['jltwp_adminify_login_bg_video_poster']['url'];
    }

    ob_start(); ?>
    <script type='text/javascript' src='<?php echo WP_ADMINIFY_ASSETS . 'vendors/vidim/vidim.min.js'; ?>?ver=<?php echo WP_ADMINIFY_VER; ?>'></script>
    <script>
        <?php
        switch ($video_type) {

            case 'youtube': ?>
                var src = '<?php echo esc_url($source); ?>';
               new vidim('.login-background', {
                    src: src,
                    type: 'YouTube',
                    quality: 'hd1080',
                    muted: true,
                    startAt: 0,
                    poster: '<?php echo esc_url($video_poster); ?>',
                    loop: '<?php echo wp_validate_boolean($video_autoloop); ?>',
                    showPosterBeforePlay: '<?php echo !empty($video_poster); ?>'
                });
            <?php break;

            case 'self_hosted': ?>
               new vidim('.login-background', {
                    src: [{
                        type: 'video/mp4',
                        src: '<?php echo esc_url($source); ?>',
                    }],
                    poster: '<?php echo esc_url($video_poster); ?>',
                    loop: '<?php echo wp_validate_boolean($video_autoloop); ?>',
                    showPosterBeforePlay: '<?php echo !empty($video_poster); ?>'
                });
            <?php break;

            default:
                break;
        } ?>
    </script>
    <?php

    echo ob_get_clean();
}
