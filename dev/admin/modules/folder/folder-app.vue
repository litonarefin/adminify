<template>

    <div id="wp-adminify--folder-app">

        <div class="wp-adminify--folder-widget">

            <!-- Widget -->
            <div class="wp-adminify--folder-app">
                <div class="wp-adminify--folder-app--inner">

                    <div class="folder--header">
                        <span>Folders</span> -
                        <a href="#" @click.prevent="showNewFolderPopup">Create New Folder</a>
                    </div>

                    <div class="folder--actions">
                        <span><input type="checkbox" v-model="folder_select_toggle" /></span>
                        <a href="#" class="btn--folder-rename" @click.prevent.stop="showRenameFolderPopup">Rename</a>
                        <a href="#" class="btn--folder-delete" @click.prevent.stop="showDeleteFolderPopup">Delete</a>
                        <ul class="folder-sort--list">
                            <li class="folder--expand">
                                <a href="#" class="btn--folder-expand"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
                            </li>
                            <li class="folder--sort has--sub-menu">
                                <a href="#" class="btn--folder-sort"><span class="dashicons dashicons-sort"></span></a>
                                <ul class="adminify--sub-menu">
                                    <li><a data-sort="a-z" href="#" @click.prevent="sortFolders( $event )">A → Z</a></li>
                                    <li><a data-sort="z-a" href="#" @click.prevent="sortFolders( $event )">Z → A</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="folder--search">
                        <input type="text" placeholder="Search folder" v-model="filter_folder">
                    </div>

                    <ul class="folder--stats">
                        <li class="folder--single-all" :class="is_folder('all') && 'active'" data-folder="all"><a :href="get_folder_url('all')"><span>All</span><span class="wp-adminify--count">{{ total_posts_count }}</span></a></li>
                        <li class="folder--single-uncategorized" :class="is_folder('uncategorized') && 'active'" data-folder="uncategorized"><a :href="get_folder_url('uncategorized')"><span>Uncategorized</span><span class="wp-adminify--count">{{ total_uncat_posts }}</span></a></li>
                    </ul>

                    <folders :folders="filtered_folders" :folder_select_toggle="folder_select_toggle" class="folder--lists" v-if="folders"></folders>

                    <!-- <div v-html="pro_notice"></div> -->

                </div>
            </div>

        </div>

        <!-- Popup -->
        <div class="wp-adminify--popup-area">

            <div class="wp-adminify--popup-container">

                <div class="wp-adminify--popup-container_inner">

                    <!-- Create Folder Popup -->
                    <div class="popup--create-new-folder" v-if="create_folder_popup">

                        <a class="wp-adminify--popup-close" href="#" @click.prevent="hide_create_folder_popup"><span class="dashicons dashicons-no-alt"></span></a>

                        <template v-if="parent_folder">

                            <h3>New Sub Folder</h3>

                            <template v-if="is_pro">

                                <div class="popup--new-folder__name">
                                    <div>Sub Folder Name</div>
                                    <div><input type="text" v-model="new_folder_name" @input="create_folder_error = null;" placeholder="Write here"></div>
                                </div>

                                <br />

                                <div class="popup--new-folder__color">
                                    <div>Colour Tag</div>
                                    <div>
                                        <ul class="wp-adminify--colors">
                                            <li v-for="color_tag in color_tags" :key="color_tag" :class="color_tag == active_color_tag ? 'active' : ''"><a href="#" @click.prevent="active_color_tag = color_tag" :style="`background: ${color_tag};`"></a></li>
                                        </ul>
                                    </div>
                                </div>

                                <a href="#" class="button button-primary" @click.prevent="saveNewFolder">Save Folder</a>

                                <div class="popup--new-folder-error" v-if="create_folder_error">{{ create_folder_error }}</div>

                            </template>

                            <template v-else>

                                <div class="wp-adminify-folder--pro-notice" v-html="pro_notice"></div>

                            </template>


                        </template>

                        <template v-else>

                            <h3>New Folder</h3>

                            <template v-if="is_reached_limit">

                                <div class="wp-adminify-folder--pro-notice" v-html="pro_notice"></div>

                            </template>

                            <template v-else>

                                <div class="popup--new-folder__name">
                                    <div>Folder Name</div>
                                    <div><input type="text" v-model="new_folder_name" @input="create_folder_error = null;" placeholder="Write here"></div>
                                </div>

                                <br />

                                <div class="popup--new-folder__color">
                                    <div>Colour Tag</div>
                                    <div>
                                        <ul class="wp-adminify--colors">
                                            <li v-for="color_tag in color_tags" :key="color_tag" :class="color_tag == active_color_tag ? 'active' : ''"><a href="#" @click.prevent="active_color_tag = color_tag" :style="`background: ${color_tag};`"></a></li>
                                        </ul>
                                    </div>
                                </div>

                                <a href="#" class="button button-primary" @click.prevent="saveNewFolder">Save Folder</a>

                                <div class="popup--new-folder-error" v-if="create_folder_error">{{ create_folder_error }}</div>

                            </template>

                        </template>

                    </div>

                    <!-- Rename Folder Popup -->
                    <div class="popup--rename-folder" v-if="rename_folder_popup">

                        <a class="wp-adminify--popup-close" href="#" @click.prevent="hide_rename_folder_popup"><span class="dashicons dashicons-no-alt"></span></a>

                        <h3>Rename Folder</h3>

                        <div class="popup--new-folder__name">
                            <div>Rename Folder</div>
                            <div><input type="text" v-model="rename_folder_name" @input="rename_folder_error = null;" placeholder="Write here"></div>
                        </div>

                        <br />

                        <div class="popup--new-folder__color">
                            <div>Change Color</div>
                            <div>
                                <ul class="wp-adminify--colors">
                                    <li v-for="color_tag in get_color_tags()" :key="color_tag" :class="color_tag == active_color_tag ? 'active' : ''">
                                        <a href="#" @click.prevent="active_color_tag = color_tag" :style="`background: ${color_tag};`"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <a href="#" class="button button-primary" @click.prevent="renameFolder">Save Folder</a>

                        <div class="popup--new-folder-error" v-if="rename_folder_error">{{ rename_folder_error }}</div>

                    </div>

                    <!-- Delete Folder Popup -->
                    <div class="popup--delete-folder" v-if="delete_folder_popup">

                        <a class="wp-adminify--popup-close" href="#" @click.prevent="hide_delete_folder_popup"><span class="dashicons dashicons-no-alt"></span></a>

                        <h3>Are you sure you want to delete the selected folder?</h3>

                        <p>Items in the folder will not be deleted.</p>

                        <div>
                            <a href="#" class="button" @click.prevent="hide_delete_folder_popup">No, Keep it</a>
                            <a href="#" class="button button-primary" @click.prevent="deleteFolders">Yes, Delete it!</a>
                        </div>

                    </div>

                    <!-- Copy/Move Mode Folder Popup -->
                    <div class="popup--move-to-folder" v-if="move_to_folder_popup">

                        <h3>Few posts are already in another Folder</h3>

                        <p>Please choose a option whether you want to copy or move to new Folder.</p>

                        <div>
                            <a href="#" class="button button-copy">Copy To Folder</a>
                            <a href="#" class="button button-primary button-move">Move To Folder</a>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</template>

<script>

import Cookies from 'js-cookie';
const $ = jQuery;

export default {

    data() {

        return {
            post_type: '',
            post_type_tax: '',
            folders: [],
            posts: {},
            filter_folder: '',
            total_uncat_posts: '',
            total_uncat_posts: '',
            folder_select_toggle: false,

            create_folder_popup: false,
            new_folder_name: null,
            create_folder_error: null,

            rename_folder_popup: false,
            rename_folder_name: null,
            rename_folder_error: null,

            delete_folder_popup: false,
            delete_folder_error: null,

            move_to_folder_popup: false,

            color_tags: ['#7B61FF', '#0347FF', '#F24AE1', '#ED2E7E', '#FFC804', '#00BA88'],
            active_color_tag: '#7B61FF',

            currentView: 'all',
            sort: 'a-z',

            is_pro: !! wp_adminify__folder_data.is_pro,
            pro_notice: wp_adminify__folder_data.pro_notice,

            total_posts: {
                'auto-draft': 0,
                'draft': 0,
                'future': 0,
                'inherit': 0,
                'pending': 0,
                'private': 0,
                'publish': 0,
                'request-completed': 0,
                'request-confirmed': 0,
                'request-failed': 0,
                'request-pending': 0,
                'trash': 0
            },
        }

    },

    mounted() {

        this.post_type          = wp_adminify__folder_data.post_type;
        this.post_type_tax      = wp_adminify__folder_data.post_type_tax;
        this.folders            = wp_adminify__folder_data.folders;
        this.total_posts        = wp_adminify__folder_data.total_posts;
        this.total_uncat_posts  = wp_adminify__folder_data.total_uncat_posts;
        this._active_color_tag  = this.active_color_tag;
        this.adminurl           = wp_adminify__folder_data.adminurl;
        this.folder_hierarchy   = wp_adminify__folder_data.folder_hierarchy;

        this.folders_to_edit    = [];

        let sort = Cookies.get( this.post_type_tax + '__sort' );
        if ( sort ) this.sort = sort;

        this.init_folder_events();

        $(function() {

            this.init_draggable_events();
            this.init_droppable_events();
            this.reset_on_other_ajax_events();
            this.init_submenu_events();

            this.set_posts_folders();

        }.bind(this));

    },

	methods: {

        set_posts_folders() {
            let that = this;
            $('#the-list .adminify-move-file').each(function() {
                let id = $(this).data('id');
                let folders = $(this).data('folders');
                folders = folders ? String( folders ).split( ',' ).map( folder => Number(folder) ) : [];
                that.posts[id] = folders;
            });
        },

        get_folder_by_id( id ) {
            return this.folders.find( folder => folder.term_id == id );
        },

        get_folder_ids_by_post_id( post_id ) {
            return this.posts[ post_id ];
        },

        init_submenu_events() {

            $('.folder--actions .has--sub-menu > a').on('click', function( event ) {
                event.preventDefault();
                event.stopImmediatePropagation();
                $(this).parent().toggleClass('sub-menu--open');
            });

            $('body').on('click', function() {
                $('.has--sub-menu.sub-menu--open').removeClass('sub-menu--open');
            });

        },

        reset_on_other_ajax_events() {

            $(document).ajaxComplete(function( event, xhr, settings ) {

                if ( settings.dataType == 'html' ) {
                    return this.init_draggable_events();
                }

                if ( ! settings.data ) return;

                let accepted = [ 'inline-save', 'query-attachments', 'delete-post' ].some( _action => settings.data.indexOf( `action=${_action}` ) != -1 );

                if ( accepted ) {
                    setTimeout( () => {
                        this.init_draggable_events();
                        this.refresh_folders_data_ajax();
                    }, 100 );
                }

            }.bind(this));

            if ( wp.Uploader && wp.Uploader.queue ) {

                wp.Uploader.queue.on('reset', () => {
                    this.init_draggable_events();
                    this.refresh_folders_data_ajax();
                });

            }

        },

        init_folder_events() {

            let that = this;

            if ( wp.media ) {

                var AttachmentsView = wp.media.view.Attachments;

                wp.media.view.Attachments = AttachmentsView.extend({

                    initialize: function() {

                        var _this = this;

                        AttachmentsView.prototype.initialize.apply( this, arguments );

                        $('.folder--lists, .folder--stats').on('click', 'li a', function( event ) {

                            event.preventDefault();

                            let url = $(this).attr('href');

                            if ( $('.attachments-browser .attachments').length ) {

                                _this.model.get('library').props.set( 'media_folder', that.getUrlParameter( url, 'media_folder' ) );

                                let state = that.getUrlParameter( url );
                                window.history.pushState( state, '', url )

                            }

                        });

                    }

                });

            } else {

                $('.folder--lists, .folder--stats').on('click', 'li a', function( event ) {

                    event.preventDefault();

                    let url = $(this).attr('href');

                    $('.folder--lists, .folder--stats').find('li').removeClass('active');
                    $(this).closest('li').addClass('active');

                    if ( $('#the-list').length ) {
                        $( '#the-list' ).load( `${url} #the-list > tr` );
                        let state = that.getUrlParameter( url );
                        window.history.pushState( state, '', url )
                    }

                });

            }

        },

        folderActions( event, folder ) {

            event.preventDefault();

            this.folders.forEach( _folder => {
                _folder.contexted = false;
            });

            folder.contexted = true;

            $('.folder--lists li').removeClass('sub-menu--open');

            $( event.target ).closest('li').addClass('sub-menu--open');

        },

        get_active_folder() {

            return $('.folder--lists li.active').toArray().map( _folder_dom => $(_folder_dom).data('folder') );

        },

        is_folder( folder ) {
            
            // let URLParams = new URLSearchParams( window.location.href );
            // let currentFolder = URLParams.get( 'folder' );

            // if ( folder == 'all' && ! currentFolder ) return true;
            // if ( this.get_folder_url(  ) == currentFolder ) return true;



            // return false;




            let currenturl = window.location.href;

            if ( folder == 'all' && currenturl.indexOf(wp_adminify__folder_data.post_type_tax) > -1 ) return false;

            return currenturl == this.get_folder_url(folder);

        },

        getUrlParameter( querystring, sParam ) {

            querystring = querystring.substring(querystring.indexOf('?') + 1);

            let params = new URLSearchParams(querystring);
            let obj = {};

            for (let key of params.keys()) {
                if (params.getAll(key).length > 1) {
                    obj[key] = params.getAll(key);
                } else {
                    obj[key] = params.get(key);
                }
            }

            if ( sParam ) {
                if ( sParam in obj ) return obj[sParam];
                return '';
            }

            return obj;

        },

        get_folder_url( folder ) {

            const queryStrings = location.search;
            const searchParams = new URLSearchParams( queryStrings );
            const postType = searchParams.get('post_type');
            const baseURL = new URL( location.protocol + '//' + location.host + location.pathname );

            if ( postType ) baseURL.searchParams.set( 'post_type', postType );

            if ( folder !== 'all' ) {
                const folderSlug = ( folder == 'uncategorized' ) ? '-1' : folder.slug;
                baseURL.searchParams.set( this.post_type_tax, folderSlug );
            }

            for ( const [key, value] of searchParams.entries() ) {
                if ( key == 'post_type' ) continue;
                if ( key == this.post_type_tax ) continue;
                baseURL.searchParams.set( key, value );
            }

            return baseURL.toJSON();

        },

        showPopupOverlay() {
            $('body').addClass('wp-adminify--popup-show');
        },

        hidePopupOverlay() {
            $('body').removeClass('wp-adminify--popup-show');
        },

        showNewFolderPopup() {

            this.showPopupOverlay();

            this.create_folder_popup = true;
            this.parent_folder = null;
            this.active_color_tag = this.color_tags[0];
            this._active_color_tag  = this.active_color_tag;

        },

        showNewSubFolderPopup( folder ) {

            this.showPopupOverlay();

            this.create_folder_popup = true;
            this.parent_folder = folder.term_id;
            this.active_color_tag = this.color_tags[0];
            this._active_color_tag  = this.active_color_tag;

        },

        showRenameFolderPopup( folder = false ) {

            // Set Editable Folders

            if ( folder && folder.term_id ) {
                this.folders_to_edit = [folder];
            } else if ( this.get_active_folder().length ) {
                this.folders_to_edit = [this.folders.find( _folder => _folder.term_id == this.get_active_folder()[0] )];
            } else {
                this.folders_to_edit = null;
            }

            if ( !this.folders_to_edit || !this.folders_to_edit.length ) return;

            folder = this.folders_to_edit[0];

            this._rename_folder_name = folder.name;
            this.rename_folder_name = folder.name;
            this.active_color_tag = folder.color;
            this._active_color_tag = this.active_color_tag;

            this.showPopupOverlay();
            this.rename_folder_popup = true;

        },

        showDeleteFolderPopup( folder = false ) {

            // Set Editable Folders

            if ( folder && folder.term_id ) {
                this.folders_to_edit = [folder];
            } else if ( this.folder_select_toggle ) {
                this.folders_to_edit = this.folders.filter( _folder => _folder.selected );
            } else if ( this.get_active_folder().length ) {
                this.folders_to_edit = [this.folders.find( _folder => _folder.term_id == this.get_active_folder()[0] )];
            } else {
                this.folders_to_edit = null;
            }

            if ( !this.folders_to_edit || !this.folders_to_edit.length ) return;

            this.showPopupOverlay();
            this.delete_folder_popup = true;

        },

        hide_rename_folder_popup() {
            this.hidePopupOverlay();
            this.rename_folder_popup = false;
            this.rename_folder_error = null;
        },

        hide_delete_folder_popup() {
            this.hidePopupOverlay();
            this.delete_folder_popup = false;
            this.delete_folder_error = null;
        },

        hide_move_to_folder_popup() {
            this.hidePopupOverlay();
            this.move_to_folder_popup = false;
        },

        hide_create_folder_popup() {

            this.hidePopupOverlay();

            this.create_folder_popup = false;
            this.new_folder_name = null;
            this.create_folder_error = null;
            this.active_color_tag = this._active_color_tag;

        },

        saveNewFolder() {

            let _this = this;

            let data = {
                post_type: wp_adminify__folder_data.post_type,
                post_type_tax: wp_adminify__folder_data.post_type_tax,
                new_folder_name: this.new_folder_name,
                folder_color_tag: this.active_color_tag,
                parent_folder: this.parent_folder,
                action: 'adminify_folder',
                route: 'create_new_folder',
                _ajax_nonce: wp_adminify__folder_data.nonce
            }

            if ( this.is_pro ) {
                data.parent_folder = this.parent_folder;
            }

            $.ajax({
                url: wp_adminify__folder_data.ajaxurl,
                method: 'post',
                data: data
            }).done( ( response, status, xhr ) => {

                if ( response.success && xhr.status == 200 ) {
                    _this.refresh_folders_data( response.data );
                    _this.hide_create_folder_popup();
                } else {
                    _this.create_folder_error = response.data.message;
                }

            });

        },

        renameFolder( folder = false ) {

            let _this = this;
            let changes = false;

            if ( this.active_color_tag != this._active_color_tag ) changes = true;

            if ( ! changes && this._rename_folder_name.trim() != this.rename_folder_name.trim() ) changes = true;

            if ( ! changes ) return this.hide_rename_folder_popup();

            $.ajax({
                url: wp_adminify__folder_data.ajaxurl,
                method: 'post',
                data: {
                    post_type: wp_adminify__folder_data.post_type,
                    post_type_tax: wp_adminify__folder_data.post_type_tax,
                    term_id: _this.folders_to_edit[0].term_id,
                    folder_name: _this.rename_folder_name,
                    folder_color_tag: _this.active_color_tag,
                    action: 'adminify_folder',
                    route: 'rename_folder',
                    _ajax_nonce: wp_adminify__folder_data.nonce
                }
            }).done( ( response, status, xhr ) => {

                if ( response.success && xhr.status == 200 ) {
                    _this.refresh_folders_data( response.data );
                    _this.hide_rename_folder_popup();
                    $('.folder--lists li.active > a').trigger('click');
                } else {
                    _this.rename_folder_error = response.data.message;
                }

            });

        },

        init_draggable_events() {

            $('.adminify-move-file:not(.ui-draggable), .adminify-move-multiple:not(.ui-draggable)').draggable({

                revert: "invalid",
                containment: "document",
                helper: "clone",
                cursor: "move",

                start: function( event, ui ) {
                    $(this).closest('td').addClass('adminify-draggable');
                    $('body').addClass('adminify--items-dragging');
                },

                stop: function( event, ui ) {
                    $(this).closest('td').removeClass('adminify-draggable');
                    $('body').removeClass('adminify--items-dragging');
                },

                // helper: function (event, ui) {
                //     console.log( event )
                //     console.log( this )
                //     // if ( ui.draggable.hasClass( 'adminify-move-multiple') ) {
                //     let items = $('#the-list .check-column input[type="checkbox"]:checked').length;
                //     return $(`<div>Move ${items} Items</div>`);
                    
                //     // $('.adminify--selected-items').remove();
                //     // let selectedItems = $('.attachments-browser li.attachment.selected').length;
                //     // selectedItems = (selectedItems < 2) ? '1 Item' : `${selectedItems} Items`;
                //     // return $(`<div class='adminify--selected-items'><span class='total-post-count'>${selectedItems} Selected</span></div>`);
                // },

            });

            $('.attachments-browser li.attachment:not(.ui-draggable)').draggable({

                revert: "invalid",
                containment: "document",
                cursor: "move",
                cursorAt: {
                    left: 0,
                    top: 0
                },

                start: function( event, ui ) {
                    $('body').addClass('adminify--items-dragging');
                },

                stop: function( event, ui ) {
				    $('.adminify--selected-items').remove();
                    $('body').removeClass('adminify--items-dragging');
                },

            });

        },

        async init_droppable_events() {

            let _this = this;

            $('.folder--lists li a:not(.ui-droppable), .folder--stats li.folder--single-uncategorized a:not(.ui-droppable)').droppable({

                accept: '.adminify-move-file, .adminify-move-multiple, .attachments-browser li.attachment',
                hoverClass: 'adminify-drop-hover',
                classes: {
                    'ui-droppable-active': 'ui-state-highlight'
                },
                tolerance: 'pointer',

                drop: async function( event, ui ) {

                    let folderID = $(this).parent("li").data('folder');

                    if ( ! folderID ) return;

                    let postIDs = [];

                    if ( ui.draggable.hasClass( 'adminify-move-multiple') ) {

                        postIDs = $('#the-list .check-column input[type=checkbox]:checked').toArray().map( _input => _input.value );

                        $('.wp-list-table .manage-column.check-column input').prop('checked', false);

                    } else if ( ui.draggable.hasClass('adminify-move-file') ) {

                        postIDs = [ ui.draggable[0].attributes['data-id'].nodeValue ];

                    } else if ( ui.draggable.hasClass('attachment') ) {

                        if ( $('.media-toolbar.wp-filter').hasClass('media-toolbar-mode-select') ) {
                            postIDs = $('.attachments-browser li.attachment.selected').toArray().map( _media => _media.dataset.id );
                        } else {
                            postIDs = [ ui.draggable[0].attributes['data-id'].nodeValue ];
                        }

                    }

                    if ( ! postIDs.length ) return;

                    var move_to_folder = false;

                    if ( folderID != 'uncategorized' ) {

                        let folder_found = postIDs.some( post_id => {
                            let folder_ids = _this.get_folder_ids_by_post_id( post_id );
                            if ( folder_ids.length ) return true;
                            return false;
                        });
    
                        if ( folder_found ) {
                            move_to_folder = await _this.shouldWeMoveToFolder();
                        }

                    }

                    if ( ! ui.draggable.hasClass('attachment') ) {

                        let mode = $('input[name=post_view]').first().val() || 'list';

                        $.ajax({

                            url: wp_adminify__folder_data.ajaxurl,
                            method: 'post',
                            data: {
                                post_ids: postIDs,
                                folder_id: folderID,
                                post_type: wp_adminify__folder_data.post_type,
                                post_type_tax: wp_adminify__folder_data.post_type_tax,
                                action: 'adminify_folder',
                                route: 'move_to_folder',
                                move_to_folder: move_to_folder,
                                screen: pagenow,
                                mode: mode,
                                _ajax_nonce: wp_adminify__folder_data.nonce
                            }

                        }).done( ( response, status ) => {

                            if ( response.success ) {
                                _this.refresh_rows();
                                _this.refresh_folders_data( response.data );
                            }

                        });

                    }

                    if ( ui.draggable.hasClass('attachment') ) {

                        $.ajax({
                            url: wp_adminify__folder_data.ajaxurl,
                            method: 'post',
                            data: {
                                post_ids: postIDs,
                                folder_id: folderID,
                                post_type: wp_adminify__folder_data.post_type,
                                post_type_tax: wp_adminify__folder_data.post_type_tax,
                                action: 'adminify_folder',
                                route: 'move_to_folder',
                                copy_type: copy_type,
                                screen: pagenow,
                                mode: 'grid',
                                _ajax_nonce: wp_adminify__folder_data.nonce
                            }
                        }).done( ( response, status ) => {

                            if ( response.success ) {
                                _this.refresh_rows();
                                _this.refresh_folders_data( response.data );
                            }

                        });

                    }

                }

            });

        },

        shouldWeMoveToFolder() {
            this.showPopupOverlay();
            this.move_to_folder_popup = true;

            return new Promise( resolve => {
                jQuery('body').on('click.promptDialog', '.button-move, .button-copy', function(e) {
                    e.preventDefault();
                    if ( jQuery(this).hasClass('button-move') ) resolve( true );
                    resolve( false );
                });
            })
            .finally( () => {
                jQuery('.button-move, .button-copy').off('click.promptDialog');
                this.hidePopupOverlay();
                this.move_to_folder_popup = false;
            });
        },

        refresh_rows() {

            let $currentItem = $('.folder--lists li.active, .folder--stats li.active').first();

            if ( ! $currentItem.length ) $currentItem = $('.folder--stats li').first();

            $currentItem.children('a').trigger('click');

        },

        get_allowed_status() {

            return [ 'pending', 'draft', 'future', 'private', 'publish', 'inherit'];

        },

        refresh_folders_data( data = {} ) {

            this.folders = data.folders;
            this.total_posts = data.total_posts;
            this.total_uncat_posts = data.total_uncat_posts;
            this.folder_hierarchy = data.folder_hierarchy;

            setTimeout( () => {
                this.init_droppable_events();
                this.init_draggable_events();
                this.set_posts_folders();
            }, 200 );

        },

        refresh_folders_data_ajax() {

            let _this = this;

            $.ajax({
                url: wp_adminify__folder_data.ajaxurl,
                method: 'post',
                data: {
                    post_type: wp_adminify__folder_data.post_type,
                    post_type_tax: wp_adminify__folder_data.post_type_tax,
                    action: 'adminify_folder',
                    route: 'refresh_folders',
                    _ajax_nonce: wp_adminify__folder_data.nonce
                }
            }).done( ( response, status ) => {

                if ( response.success ) {
                    _this.refresh_folders_data( response.data );
                }

            });

        },

        get_color_tags() {

            if ( !this.folders_to_edit && !this.folders_to_edit.length ) return;

            let folder = this.folders_to_edit[0];
            let active_color = '';

            if ( folder && folder.color ) {
                active_color = folder.color;
            }

            if ( ! active_color || this.color_tags.includes(active_color) ) return this.color_tags;

            return this.color_tags.concat( [active_color] );

        },

        deleteFolders() {

            let _this = this;
            let folders = this.folders_to_edit;

            if ( ! folders.length ) return this.hide_delete_folder_popup();

            folders = folders.map( _folder => _folder.term_id );

            $.ajax({
                url: wp_adminify__folder_data.ajaxurl,
                method: 'post',
                data: {
                    post_type: wp_adminify__folder_data.post_type,
                    post_type_tax: wp_adminify__folder_data.post_type_tax,
                    term_ids: folders,
                    action: 'adminify_folder',
                    route: 'delete_folders',
                    _ajax_nonce: wp_adminify__folder_data.nonce
                }
            }).done( ( response, status, xhr ) => {

                if ( response.success && xhr.status == 200 ) {
                    _this.refresh_folders_data( response.data );
                    _this.hide_delete_folder_popup();
                    $('.folder--lists, .folder--stats').find('li.active > a').trigger('click');
                }

            });

        },

        sortFolders( event ) {

            let sort = $(event.currentTarget).data('sort');

            if ( sort ) {
                Cookies.set( this.post_type_tax + '__sort', sort );
                this.sort = sort;
            }

        }

	},

    computed: {

        _filter_folder() {
            return this.filter_folder.trim().toLowerCase();
        },

        filtered_folders() {

            let that = this;

            // Set Default Options
            let folders = this.folders.map( _folder => {
                _folder.selected = false;
                _folder.contexted = false;
                _folder.children = [];
                return _folder;
            });

            // Sort for Folders
            folders = folders.sort( (a, b) => {

                if ( this.sort == 'a-z' ) {
                    if ( a.name < b.name) { return -1; }
                    if ( a.name > b.name) { return 1; }
                }

                if ( this.sort == 'z-a' ) {
                    if ( a.name < b.name) { return 1; }
                    if ( a.name > b.name) { return -1; }
                }

                return 0;

            });

            function addChild( folder, _folders ) {

                that.folder_hierarchy[folder.term_id].forEach( child_id => {

                    let child_folder = folders.find( _folder => _folder.term_id == child_id );
                    let child_folder_index = folders.findIndex( _folder => _folder.term_id == child_id );

                    if ( child_folder && child_folder_index > -1 ) {

                        if ( ! folder.children.find( _fol_ch => _fol_ch.term_id == child_folder.term_id ) ) {

                            folder.children.push( child_folder );

                            child_folder = folder.children.find( _folder => _folder.term_id == child_id );

                            if ( child_id in that.folder_hierarchy ) addChild( child_folder, _folders );

                        }

                    }

                });

            }

            // Search Filter
            if ( this._filter_folder ) {

                let _folders = folders.filter( _folder => {
                    return _folder.name.toLowerCase().search( this._filter_folder.toLowerCase() ) > -1;
                });

                if ( _folders.length ) return _folders;

            }

            // Set Sub Folders
            folders.forEach( folder => {

                if ( folder.term_id in that.folder_hierarchy ) {
                    addChild( folder, folders );
                }

            });

            // Cleanup Extra Sub Folders
            for ( let parent_item in that.folder_hierarchy ) {
                that.folder_hierarchy[parent_item].forEach( child_id => {
                    let index = folders.findIndex( _folder => _folder.term_id == child_id );
                    folders.splice( index, 1 );
                });
            }

            return folders;
        },

        total_posts_count() {
            let total = 0;
            this.get_allowed_status().forEach( status => {
                total += Number( this.total_posts[status] );
            });
            return total;
        },

        is_reached_limit() {
            if ( this.is_pro ) return false; // go unlimited
            if ( this.folders && this.folders.length ) {
                return this.folders.length >= 3;
            }
            return false;
        }

    },

    watch: {

        filter_folder() {

            setTimeout( () => {
                this.init_draggable_events();
                this.init_droppable_events();
            }, 50 );

        }

    }

}
</script>
