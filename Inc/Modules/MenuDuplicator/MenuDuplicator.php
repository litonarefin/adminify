<?php

namespace WPAdminify\Inc\Modules\MenuDuplicator;

// no direct access allowed
if (!defined('ABSPATH'))  exit;

/**
 * @package WP Adminify
 * Module: Menu Duplicator
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */

class MenuDuplicator
{
    public function __construct()
    {
        add_action('admin_footer', [$this, 'jltwp_adminify_add_duplicate_button'], 11);
        add_action('admin_footer', [$this, 'jltwp_adminify_creating_menu_duplicate'], 6);

        // Duplicate Nav Menu Item
        add_action('admin_footer', [$this, 'jltwp_adminify_duplicate_nav_menu_item'], 12);
    }

    /**
     * Duplicate Menu Button
     *
     * @return void
     */
    public function jltwp_adminify_add_duplicate_button()
    {
        $current_screen = get_current_screen();
        $current_menu   = get_user_option('nav_menu_recently_edited');
        if ($current_screen->id == 'nav-menus' && $_GET['menu'] != '0') {
            $return = '';
            $return .= '<div style="display:none;" class="AdminifyDuplicateMenuSpinenr spinner is-active"></div><a class="AdminifyDuplicateMenuClick button button-primary button-large menu-save" href="?adminify-menu-duplicate=' . $current_menu . '">' . __('Duplicate Menu', 'adminify') . '</a>';
?>
            <script type="text/javascript">
                var update_menu_form = jQuery('#update-nav-menu');
                update_menu_form.find('.publishing-action').append('<?php echo addslashes_gpc($return); ?>');
                jQuery('.AdminifyDuplicateMenuClick').click(function() {
                    jQuery('.AdminifyDuplicateMenuSpinenr').show();
                });
            </script>

            <?php
        }
    }

    /**
     * Creating Menu Duplication
     *
     * @return void
     */
    public function jltwp_adminify_creating_menu_duplicate()
    {
        $current_screen = get_current_screen();
        if ($current_screen->id == 'nav-menus') {
            if (isset($_GET['adminify-menu-duplicate'])) {
                $id = intval($_GET['adminify-menu-duplicate']);
                $source = wp_get_nav_menu_object($id);
                $duplicate = $this->render_menu_duplicate($_GET['adminify-menu-duplicate'], $source->name . ' ' . __('(Copy)', 'adminify'));
                if ($duplicate) {
            ?>
                    <script type="text/javascript">
                        window.location.replace("<?php echo admin_url('nav-menus.php?action=edit&menu=' . $duplicate); ?>");
                    </script>
                <?php
                } else {
                ?>
                    <script type="text/javascript">
                        window.location.replace("<?php echo admin_url('nav-menus.php'); ?>");
                    </script>
        <?php
                }
            }
        }
    }


    /**
     * Render Menu Duplicate
     *
     * @return void
     */
    public function render_menu_duplicate($id = null, $name = null)
    {

        // Sanity check
        if (empty($id) || empty($name)) {
            return false;
        }

        $id = intval($id);
        $name = sanitize_text_field($name);
        $source = wp_get_nav_menu_object($id);
        $source_items = wp_get_nav_menu_items($id);

        $menu_exists = wp_get_nav_menu_object($name);

        if (!$menu_exists) {
            $new_id = wp_create_nav_menu($name);
        } else {
            return $new_id = $this->render_menu_duplicate($id, $name . ' ' . __('(Copy)', 'adminify'));
        }

        if (!$new_id || is_array($new_id)) {
            return false;
        }

        // Key is the original db ID, val is the new
        $rel = array();

        $i = 1;
        foreach ($source_items as $menu_item) {
            $args = array(
                'menu-item-db-id'       => $menu_item->db_id,
                'menu-item-object-id'   => $menu_item->object_id,
                'menu-item-object'      => $menu_item->object,
                'menu-item-position'    => $i,
                'menu-item-type'        => $menu_item->type,
                'menu-item-title'       => $menu_item->title,
                'menu-item-url'         => $menu_item->url,
                'menu-item-description' => $menu_item->description,
                'menu-item-attr-title'  => $menu_item->attr_title,
                'menu-item-target'      => $menu_item->target,
                'menu-item-classes'     => implode(' ', $menu_item->classes),
                'menu-item-xfn'         => $menu_item->xfn,
                'menu-item-status'      => $menu_item->post_status
            );

            $parent_id = wp_update_nav_menu_item($new_id, 0, $args);

            $rel[$menu_item->db_id] = $parent_id;

            // did it have a parent? if so, we need to update with the NEW ID
            if ($menu_item->menu_item_parent) {
                $args['menu-item-parent-id'] = $rel[$menu_item->menu_item_parent];
                $parent_id = wp_update_nav_menu_item($new_id, $parent_id, $args);
            }

            // allow developers to run any custom functionality they'd like
            do_action('duplicate_menu_item', $menu_item, $args);

            $i++;
        }

        return $new_id;
    }


    /**
     * Duplicate Nav Menu Item
     *
     * @return void
     */
    public function jltwp_adminify_duplicate_nav_menu_item()
    {

        global $pagenow;

        if ($pagenow != 'nav-menus.php' || !current_user_can('edit_theme_options')) {
            return;
        }

        ?>
        <script type="text/javascript">
            (function($) {

                "use strict";

                function adminifyGetMenuID(el) {
                    return el.attr('id').replace('menu-item-', '') * 1;
                }

                function adminifyGetMenu(el) {
                    return el.get(0).className.split('menu-item-depth-')[1].split(' ')[0];
                }

                $(document).on('mouseover', 'li.menu-item:not(.adminify-duplicator-enabled)', function(e) {

                    var menu_item_enable = $(this).addClass('adminify-duplicator-enabled');

                    menu_item_enable.find('.menu-item-actions').append('<span class="meta-sep hide-if-no-js"> | </span><a class="item-duplicate-this submitcancel hide-if-no-js" href="#">Duplicate</a>');

                });

                $(document).on('click', 'li.menu-item.adminify-duplicator-enabled .item-duplicate-this', function(e) {

                    e.preventDefault();
                    var li = $(this).closest('li.menu-item'),
                        depth = 'menu-item-depth-' + adminifyGetMenu(li),
                        availables = $('#menu-to-edit li[id^=menu-item-]'),
                        ids = [],
                        nowId = adminifyGetMenuID(li),
                        newId, newEl, form_data;

                    form_data = {
                        action: 'add-menu-item',
                        menu: $('#menu').val(),
                        'menu-settings-column-nonce': $('#menu-settings-column-nonce').val(),
                        'menu-item': {
                            '-1': {
                                'menu-item-db-id': 0,
                                'menu-item-object-id': li.find('input.menu-item-data-object-id').val(),
                                'menu-item-object': li.find('input.menu-item-data-object').val(),
                                'menu-item-parent-id': li.find('input.menu-item-data-parent-id').val(),
                                'menu-item-type': li.find('input.menu-item-data-type').val(),
                                'menu-item-title': li.find('input.edit-menu-item-title').val(),
                                'menu-item-url': li.find('input.edit-menu-item-url').val(),
                                'menu-item-description': li.find('textarea.edit-menu-item-description').val(),
                                'menu-item-attr-title': li.find('input.edit-menu-item-attr-title').val(),
                                'menu-item-target': li.find('.field-link-target input[type=checkbox]').is(':checked') ? '_blank' : '',
                                'menu-item-classes': li.find('input.edit-menu-item-classes').val(),
                                'menu-item-xfn': li.find('input.edit-menu-item-xfn').val()
                            }
                        }
                    };

                    $.post(ajaxurl, form_data, function(menuMarkup) {
                        console.log($(menuMarkup));

                        var newElement = $(menuMarkup);

                        $('.hide-column-tog').not(':checked').each(function() {
                            newElement.find('.field-' + $(this).val()).addClass('hidden-field');
                        });

                        newElement.removeClass('menu-item-depth-0');
                        newElement.addClass(depth);

                        newElement = newElement.wrap('<div>').parent().html();

                        if (li.next().hasClass(depth) || li.parent().children('li').last().get(0) === li.get(0)) {
                            li.after(newElement);
                        } else if (adminifyGetMenu(li.next()) < adminifyGetMenu(li)) {
                            li.after(newElement);
                        } else {
                            if (adminifyGetMenu(li) != 0) {
                                depth = 'menu-item-depth-' + (adminifyGetMenu(li) - 1);
                            }
                            li.nextUntil('.' + depth).last().after(newElement);
                        }
                    });

                });

            })(jQuery)
        </script>
<?php
    }
}
