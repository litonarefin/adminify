<?php

// no direct access allowed
if (!defined('ABSPATH'))  exit;
/**
 * WPAdminify
 * @package Admin Pages
 *
 * @author WP Adminify <support@wpadminify.com>
 */

$remove_page_title = get_post_meta($post->ID, '_wp_adminify_page_title', true);

?>

<!doctype html>

<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php wp_body_open();

    while (have_posts()) : the_post();

        if (!$remove_page_title) : ?>
            <h1 class="adminify-admin-page--title"><?php the_title(); ?></h1>
        <?php endif; ?>

        <main id="content" class="site-content">
            <?php the_content(); ?>
        </main>

    <?php endwhile;

    wp_footer(); ?>

</body>

</html>
